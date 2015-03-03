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
			array('FlashLottery.status' => '"pick_winner"'),
			array(
				'AND'=>array(
					'FlashLottery.expiration_date < NOW()',
					'FlashLottery.start_date < NOW()',
					'FlashLottery.status'=>'ongoing')
				)
			);

		$this->checkForWinner();
	}

	public function checkForWinner() {



		//chargement des models (ne pas les oublier dans le App:uses)
		$flashTicketModel = new FlashTicket();

		$this->contain(array(
			'FlashTicket' => array('Buyer'),
			'EveItem'
			)
		);

		$testedLottery = $this->findByStatus('pick_winner');

		if(empty($testedLottery)){
			return null;
		}


		$messageModel = new Message();
		$userModel = new User();
		$statisticModel = new Statistic();

		$testedLottery['FlashLottery']['status'] = 'unclaimed';

		

		$winnerTicket = $this->getWinnerTicket($testedLottery['FlashTicket']);



			//on utilise une datasource pour éviter les erreurs en cas de rafraichissement pendant les requetes SQL
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		
		$hasFailed = false;

			//loop on all 
		foreach ($testedLottery['FlashTicket'] as $key => $flashTicket) {

			if($flashTicket['id'] == $winnerTicket['id']){

				$testedLottery['FlashTicket'][$key]['is_winner'] = true;

				$messageModel->sendFlashLotteryMessage(
					$flashTicket['buyer_user_id'], 
					'Flash Lottery Won', 
					'You have won a Flash Lottery ! You can now claim your prize.', 
					$testedLottery['FlashLottery']['id']);

					//insert the "win" stat
				$statisticModel->saveStat($flashTicket['buyer_user_id'], 'win_flash_lottery', $testedLottery['FlashLottery']['id'], $testedLottery['EveItem']['eve_value'], $testedLottery['FlashLottery']['eve_item_id']);
				
					//writes in the log
				$this->log('FlashLottery won : lottery['.$testedLottery['FlashLottery']['id'].'], user_id['.$flashTicket['buyer_user_id'].'], ticket['.$flashTicket['id'].']', 'eve-lotteries');

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

	private function getWinnerTicket($arrayTickets) {

		$arrayTicketsProxy = $arrayTickets;
		//remove the tickets without a buyer
		foreach ($arrayTicketsProxy as $key => $ticket) {
			if(empty($ticket['Buyer'])){
				unset($arrayTicketsProxy[$key]);
			}
		}
		$arrayTicketsProxy = array_values($arrayTicketsProxy);

		return $this->array_random($arrayTicketsProxy);
	}

	/**
	 * Return a random key from an array
	 * @param  [type]  $arr [description]
	 * @param  integer $num [description]
	 * @return [type]       [description]
	 */
	private function array_random($arr, $num = 1) {
		shuffle($arr);

		$r = array();
		for ($i = 0; $i < $num; $i++) {
			$r[] = $arr[$i];
		}
		return $num == 1 ? $r[0] : $r;
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
