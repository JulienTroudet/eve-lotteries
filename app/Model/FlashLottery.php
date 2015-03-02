<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('FlashTicket', 'Model');
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

	public function checkForWinner($flashLotteryId, $lastBoughtTicketId = null) {

		//chargement des models (ne pas les oublier dans le App:uses)
		$flashTicketModel = new FlashTicket();

		$this->contain(array(
			'FlashTicket' => array('Buyer'),
			)
		);

		$testedLottery = $this->findById($flashLotteryId);

		$winnerPosition = $this->getWinnerTicketPosition($testedLottery);

		if ($winnerPosition >= 0) {

			$messageModel = new Message();
			$userModel = new User();
			$statisticModel = new Statistic();

			$testedLottery['FlashLottery']['status'] = 'unclaimed';

			//on utilise une datasource pour éviter les erreurs en cas de rafraichissement pendant les requetes SQL
			$dataSource = $this->getDataSource();
			$dataSource->begin();

			//add to the stats that the player get the last ticket
			if(isset($lastBoughtTicketId)){
				$lastTicket = $flashTicketModel->findById($lastBoughtTicketId);
				$statisticModel->saveStat($lastTicket['FlashTicket']['buyer_user_id'], 'end_flash_lottery', $lastTicket['FlashTicket']['flash_lottery_id'], 1, $testedLottery['FlashLottery']['eve_item_id']);
			}
			
			$hasFailed = false;

			//loop on all 
			foreach ($testedLottery['FlashTicket'] as $key => $flashTicket) {

				if((int)$flashTicket['position'] == (int)$winnerPosition){

					$testedLottery['FlashTicket'][$key]['is_winner'] = true;

					$messageModel->sendFlashLotteryMessage(
						$flashTicket['buyer_user_id'], 
						'Flash Lottery Won', 
						'You have won a Flash Lottery ! You can now claim your prize.', 
						$flashLotteryId);

					//insert the "win" stat
					$statisticModel->saveStat($flashTicket['buyer_user_id'], 'win_flash_lottery', $testedLottery['FlashLottery']['id'], $testedLottery['FlashLottery']['value'], $testedLottery['FlashLottery']['eve_item_id']);
					
					//writes in the log
					$this->log('FlashLottery won : lottery['.$flashLotteryId.'], user_id['.$flashTicket['buyer_user_id'].'], ticket['.$flashTicket['id'].']', 'eve-lotteries');

					$userModel->updateNbNewWonFlashLotteries($flashTicket['Buyer']['id'], 1);

					$testedLottery['FlashLottery']['winner_user_id'] = $flashTicket['Buyer']['id'];

					

				}
				else{
					$testedLottery['FlashTicket'][$key]['is_winner'] = false;
				}
				//remove the users so it doesn't save it
				unset($testedLottery['FlashTicket'][$key]['Buyer']);


			}
			//remove the item so it doesn't save it
			unset($testedLottery['EveItem']);

			//save the lottery and the tickets
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

		$tickets = $lottery['FlashTicket'];
		$lotteryNbTickets = (int)$lottery['FlashLottery']['nb_tickets'];
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

		$tickets = $lottery['FlashTicket'];
		$lotteryNbTickets = (int)$lottery['FlashLottery']['nb_tickets'];
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
		),
	'Winner' => array(
		'className' => 'User',
		'foreignKey' => 'winner_user_id',
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
