<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
	/**
	 * User Model
	 *
	 * @property Group $Group
	 * @property ticket $tickets_users
	 * @property article $articles_users
	 * @property lottery $lotteries_users
	 */
	class User extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'eve_name';

	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false), 'Containable');

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
		// if($this->data['User']['password'] == ""){
		// 	unset($this->data['User']['password']);
		// }

	}


	/**
	 * Met à jour la session user à chaque update du model
	 * @param  [type] $created [description]
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function afterSave($created, $options = array()){
		parent::afterSave($created,$options);

        //updating authentication session
		App::uses('CakeSession', 'Model/Datasource');
		CakeSession::write('Auth',$this->findById(AuthComponent::user('id')));

		return true;
	}


	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	public function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Your custom message here',
				),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Your custom message here',
				),
			),
		'wallet' => array(
			'decimal' => array(
				'required' => false,
				'rule' => array('decimal'),
				'message' => 'Your custom message here',
				),
			),
		'id' => array(
			'id_unique' => array(
				'rule' => array('isUnique'),
				'required' => true,
				'message' => 'That EVE id is already in use.',
				),
			),
		'eve_name' => array(
			'eve_name_unique' => array(
				'rule' => array('isUnique'),
				'required' => true,
				'message' => 'That EVE Name is already in use.',
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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
			'foreignKey' => 'buyer_user_id',
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
		'Withdrawal' => array(
			'className' => 'Withdrawal',
			'foreignKey' => 'user_id',
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
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'creator_user_id',
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
		'Lottery' => array(
			'className' => 'Lottery',
			'foreignKey' => 'creator_user_id',
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
		'SuperLotteryCreator' => array(
			'className' => 'SuperLottery',
			'foreignKey' => 'creator_user_id',
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
		'SuperLotteryWinner' => array(
			'className' => 'SuperLottery',
			'foreignKey' => 'winner_user_id',
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
		'Statistic' => array(
			'className' => 'Statistic',
			'foreignKey' => 'user_id',
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
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'user_id',
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
		'UserAward' => array(
			'className' => 'UserAward',
			'foreignKey' => 'user_id',
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
