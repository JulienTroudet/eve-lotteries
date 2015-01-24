<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Ticket', 'Model');
App::uses('Statistic', 'Model');
App::uses('Message', 'Model');
App::uses('Withdrawal', 'Model');
/**
 * Lottery Model
 *
 * @property EveItem $EveItem
 * @property LotteryStatus $LotteryStatus
 * @property User $User
 * @property Ticket $Ticket
 */
class Lottery extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	public $actsAs = array('Containable');

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
		unset($this->data['Lottery']['modified']);
	}

	public function createNewLotteryForItemByUser($choosenItem, $buyer) {
		//l'array qui contient le message à renvoyer
		$data = Array();

		//chargement des models (ne pas les oublier dans le App:uses)
		$statisticModel = new Statistic();
		$ticketModel = new Ticket();
		
		//création de la nouvelle lotterie
		$this->create();
		$newLottery = array(
			'Lottery'=>array(
				'eve_item_id' =>  $choosenItem['EveItem']['id'],
				'creator_user_id' => $buyer['User']['id'],
				'nb_tickets' => $choosenItem['EveItem']['nb_tickets_default'],
				'lottery_status_id' => 1,
				'value' => $choosenItem['EveItem']['eve_value'],
				'name'=> $choosenItem['EveItem']['name'],
				),
			'Ticket'=>array()
			);

		//on récupère le prix individuel d'un ticket
		$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);

		//on crée tous les nouveaux tickets et on les ajoute à l'objet lottery
		for ($i=0; $i < $choosenItem['EveItem']['nb_tickets_default']; $i++) {
			
			$newTicket = array(
				'position' => $i,
				'value' => $ticketPrice,
				);
			array_push($newLottery['Ticket'], $newTicket);
		}

		//datasource pour éviter les problèmes de requètes
		$dataSource = $this->Ticket->getDataSource();
		$dataSource->begin();

		//si la sauvegarde de la nouvelle lottery et des tickets associés fonctionne
		if ($this->saveAssociated($newLottery)) {

			$statisticModel->saveStat($buyer['User']['id'], 'init_lottery', $this->id, $choosenItem['EveItem']['eve_value'], $choosenItem['EveItem']['id']);

			$this->log('New Lottery : name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], lottery['.$this->id.'], item['.$choosenItem['EveItem']['name'].']', 'eve-lotteries');

			$data = array(
				'success' => true,
				'lotteryId' => $this->id
				);

			$dataSource->commit();
			return $data;
		}
		else {
			$dataSource->rollback();
			$data = array('error' => 'Error while processing.');
			return $data;
		}

	}

	public function checkForWinner($lotteryId, $lastBoughtTicketId = null) {

		//chargement des models (ne pas les oublier dans le App:uses)
		$ticketModel = new Ticket();
				


		$this->contain(array(
			'Ticket' => array(
				'User' => array('id', 'eve_name')
				),
			'EveItem'
			)
		);

		$testedLottery = $this->findById($lotteryId);

		$winnerPosition = $this->getWinnerTicketPosition($testedLottery);

		if ($winnerPosition >= 0) {

			$messageModel = new Message();
			$userModel = new User();
			$statisticModel = new Statistic();
			$withdrawalModel = new Withdrawal();

			$testedLottery['Lottery']['lottery_status_id'] = 2;
			unset($testedLottery['modified']);

			//on utilise une datasource pour éviter les erreurs en cas de rafraichissement pendant les requetes SQL
			$dataSource = $this->getDataSource();
			$dataSource->begin();

			if(isset($lastBoughtTicketId)){
				$this->log($lastBoughtTicketId);
				$lastTicket = $ticketModel->findById($lastBoughtTicketId);
				$statisticModel->saveStat($lastTicket['Ticket']['buyer_user_id'], 'end_lottery', $lastTicket['Ticket']['lottery_id'], $testedLottery['Lottery']['value'], $testedLottery['Lottery']['eve_item_id']);
			}
			
			$hasFailed = false;
			foreach ($testedLottery['Ticket'] as $key => $ticket) {

				if((int)$ticket['position'] == (int)$winnerPosition){

					$testedLottery['Ticket'][$key]['is_winner'] = true;

					$withdrawalModel->create();
					$newWithdrawal = array('Withdrawal'=>array(
						'type' =>'award',
						'value' => '',
						'status' =>'new',
						'user_id' =>$ticket['buyer_user_id'],
						'ticket_id' =>$ticket['id'],
						));

					$withdrawalModel->save($newWithdrawal, true, array('type', 'value', 'status','user_id', 'ticket_id'));

					$messageModel->sendLotteryMessage(
						$ticket['buyer_user_id'], 
						'Lottery Won', 
						'You have won '.preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$testedLottery['EveItem']['name']).'. You can now claim your prize.', 
						$withdrawalModel->id);

					$statisticModel->saveStat($ticket['buyer_user_id'], 'win_lottery', $testedLottery['Lottery']['id'], $testedLottery['Lottery']['value'], $testedLottery['Lottery']['eve_item_id']);
					$this->log('Lottery won : lottery['.$lotteryId.'], user_id['.$ticket['buyer_user_id'].'], ticket['.$ticket['id'].']', 'eve-lotteries');

					$userModel->updateNbNewWonLotteries($ticket['User']['id'], 1);

					

				}
				else{
					$testedLottery['Ticket'][$key]['is_winner'] = false;
				}

				unset($testedLottery['Ticket'][$key]['User']);


			}

			unset($testedLottery['EveItem']);
			$this->saveAssociated($testedLottery);

			if($hasFailed){
				$dataSource->rollback();
			}
			else{
				$dataSource->commit();
			}
			
		}

		
	}

	public function getWinnerTicketPosition($lottery) {

		$tickets = $lottery['Ticket'];
		$lotteryNbTickets = (int)$lottery['Lottery']['nb_tickets'];
		$nbSell = 0;
		foreach ($tickets as $id => $ticket) {
			if($ticket['buyer_user_id'] != null){
				$nbSell++;
			}
		}	
		if($lotteryNbTickets == $nbSell){
			$winner = rand(0 , $lotteryNbTickets-1);	

			return $winner;
		}

		return -1;
	}

	public function areAllTicketBought($lottery) {

		$tickets = $lottery['Ticket'];
		$lotteryNbTickets = (int)$lottery['Lottery']['nb_tickets'];
		$nbSell = 0;
		foreach ($tickets as $id => $ticket) {
			if($ticket['buyer_user_id'] != null){
				$nbSell++;
			}
		}	
		if($lotteryNbTickets == $nbSell){
			return true;
		}
		else{
			return false;
		} 
	}

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'eve_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'creator_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'nb_tickets' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'limitTickets' => array(
				'rule'    => array('inList', array(8, 16)),
				'message' => 'You can only propose 8 or 16 tickets.'
				)
			),
		'lottery_status_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'value' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
public $belongsTo = array(
	'EveItem' => array(
		'className' => 'EveItem',
		'foreignKey' => 'eve_item_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		),
	'LotteryStatus' => array(
		'className' => 'LotteryStatus',
		'foreignKey' => 'lottery_status_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		),
	'User' => array(
		'className' => 'User',
		'foreignKey' => 'creator_user_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'Ticket' => array(
		'className' => 'Ticket',
		'foreignKey' => 'lottery_id',
		'dependent' => true,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
		)
	);

}
