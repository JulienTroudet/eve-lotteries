<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Ticket', 'Model');
App::uses('Statistic', 'Model');
App::uses('Message', 'Model');
/**
 * FlashLottery Model
 *
 * @property EveItem $EveItem
 * @property LotteryStatus $LotteryStatus
 * @property User $User
 * @property Ticket $Ticket
 */
class FlashLottery extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	public $actsAs = array('Containable');

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
		unset($this->data['FlashLottery']['modified']);
	}

	/**
	* Starts the flash lottery when it's time
	* @return [type] [description]
	*/
	public function initiate_flash_lottery(){
		$this->updateAll(
			array('FlashLottery.status' => '"ongoing"'),
			array(
				'AND'=>array(
					'FlashLottery.expiration_date > NOW()',
					'FlashLottery.start_date < NOW()',
					'FlashLottery.status'=>'waiting')
				)
			);
	}

	/**
	* Ends the flash lottery when it's time
	* @return [type] [description]
	*/
	public function end_flash_lottery(){
		$this->updateAll(
			array('FlashLottery.status' => '"unclaimed"'),
			array(
				'AND'=>array(
					'FlashLottery.expiration_date < NOW()',
					'FlashLottery.start_date < NOW()',
					'FlashLottery.status'=>'ongoing')
				)
			);
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
				'required' => true,
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
		
		'nb_tickets' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
		// 'start_date' => array(
		// 		'rule' => array('datetime', 'c'),
		// 		'message' => 'Bad Start date',
		// 		//'allowEmpty' => false,
		// 		//'required' => true,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// 'expiration_date' => array(
		// 		'rule' => array('datetime', 'c'),
		// 		'message' => 'Bad end date',
		// 		//'allowEmpty' => false,
		// 		//'required' => true,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		//		),
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
	'Creator' => array(
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
	'FlashTicket' => array(
		'className' => 'FlashTicket',
		'foreignKey' => 'flash_lottery_id',
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
