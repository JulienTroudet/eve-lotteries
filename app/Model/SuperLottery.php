<?php
App::uses('AppModel', 'Model');
App::uses('Config', 'Model');
App::uses('FlashTicket', 'Model');
App::uses('Statistic', 'Model');
App::uses('Message', 'Model');
/**
 * SuperLottery Model
 *
 * @property EveItem $EveItem
 * @property CreatorUser $CreatorUser
 * @property LotteryStatus $LotteryStatus
 */
class SuperLottery extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';

public $actsAs = array('Containable');

public function afterSave($created, $options = array()) {
	$config = new Config();
	parent::afterSave($created, $options);
	$config->changeSuperLotteries();
}

	/**
	* Starts the super lottery when it's time
	* @return [type] [description]
	*/
	public function initiate_super_lottery(){
		$this->updateAll(
			array('SuperLottery.status' => '"ongoing"'),
			array(
				'AND'=>array(
					'SuperLottery.expiration_date > NOW()',
					'SuperLottery.start_date < NOW()',
					'SuperLottery.status'=>'waiting')
				)
			);
	}

	/**
	* Ends the super lottery when it's time
	* @return [type] [description]
	*/
	public function end_super_lottery(){
		$this->updateAll(
			array('SuperLottery.status' => '"pick_winner"'),
			array(
				'AND'=>array(
					'SuperLottery.expiration_date < NOW()',
					'SuperLottery.start_date < NOW()',
					'SuperLottery.status'=>'ongoing')
				)
			);

		$this->checkForWinner();
	}

	/**
	 * Check for the super lottery winner
	 * @return [type]            [description]
	 */
	protected  function checkForWinner() {
		$this->log('test');
		$messageModel = new Message();
		$userModel = new User();
		$statisticModel = new Statistic();

		$this->contain(array('SuperLotteryTicket', 'EveItem'));
		$superLottery = $this->findByStatus('pick_winner');

		//is there a super to check ?
		if(isset($superLottery['SuperLotteryTicket'])){
			$this->log('test2');

			$winner = rand(1, $superLottery['SuperLottery']['nb_ticket_bought']);
			$currentCount = 0;

			// for each set of ticket (one set by player)
			foreach ($superLottery['SuperLotteryTicket'] as $key => $ticketStack) {

				$currentCount += (int)$ticketStack['nb_tickets'];

				//if the picked ticket is in the winner set
				if($winner<=$currentCount){

					$superLottery['SuperLottery']['winner_user_id'] = $ticketStack['buyer_user_id'];
					$superLottery['SuperLottery']['status'] = 'unclaimed';
					unset($superLottery['SuperLottery']['modified']);

					$statisticModel->saveStat($ticketStack['buyer_user_id'], 'win_super_lottery', $superLottery['SuperLottery']['id'], ($superLottery['EveItem']['eve_value']*$superLottery['SuperLottery']['number_items']), $superLottery['SuperLottery']['eve_item_id']);

					$this->log('Super Lottery won : lottery['.$superLottery['SuperLottery']['id'].'], user_id['.$ticketStack['buyer_user_id'].']', 'eve-lotteries');

					$winnerUser = $userModel->findById($ticketStack['buyer_user_id']);
					$winnerUser['User']['nb_new_won_super_lotteries']++;

					if ($userModel->save($winnerUser, true, array('id', 'nb_new_won_super_lotteries')) && $this->save($superLottery, true, array('id', 'winner_user_id', 'status'))){

						$messageModel->sendSuperLotteryMessage(
							$ticketStack['buyer_user_id'], 
							'Super Lottery Won', 
							('You have win '.$superLottery['SuperLottery']['number_items'].' x '.$superLottery['EveItem']['name'].'. You can now claim your prize.'),
							$this->id);

						$newSup = $this->find('first', array(
							'conditions' => array('SuperLottery.status' => 'waiting'),
							'order' => array('SuperLottery.created' => 'asc'),
							));

						if(isset($newSup['SuperLottery']['id'])){

							$newSup['SuperLottery']['status'] = 'ongoing';
							$this->save($newSup, true, array('id', 'status'));
						}
						break;
					}

				}
			}
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
		'number_items' => array(
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
				//'allowEmpty' => false,
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
		'nb_tickets' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'ticket_value' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'status' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
		'SuperLotteryTicket' => array(
			'className' => 'SuperLotteryTicket',
			'foreignKey' => 'super_lottery_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
			),
		);
}
