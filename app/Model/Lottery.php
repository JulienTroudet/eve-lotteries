<?php
App::uses('AppModel', 'Model');
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

	public function checkForWinner($lottery) {

		
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

		return null;
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
