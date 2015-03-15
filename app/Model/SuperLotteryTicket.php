<?php
App::uses('AppModel', 'Model');
App::uses('Config', 'Model');
/**
 * SuperLotteryTicket Model
 *
 * @property SuperLottery $SuperLottery
 * @property BuyerUser $BuyerUser
 */
class SuperLotteryTicket extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $actsAs = array('Containable');

	public function afterSave($created, $options = array()) {
		$config = new Config();
		parent::afterSave($created, $options);
		$config->changeSuperLotteries();
	}

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'super_lottery_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'buyer_user_id' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SuperLottery' => array(
			'className' => 'SuperLottery',
			'foreignKey' => 'super_lottery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'buyer_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
