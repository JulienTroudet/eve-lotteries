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
	public $displayField = 'username';

	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false), 'Containable');


	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
			echo('<br><br><br>emrigpethipeothin'.$groupId);
		} else {
			$groupId = $this->field('group_id');
			echo('<br><br><br>hello'.$groupId);
		}
		if (!$groupId) {
			return null;
		} else {
			echo('<br><br><br>hello2'.$groupId);
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
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You must have a Name.',
				),
			'length' => array(
				'rule'      => array('between', 6, 40),
				'message'   => 'Your Name must be between 6 and 40 characters.',
				'on'        => 'create',  
				),
			'username_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That name is already in use.'
				),
			),

		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Your custom message here',

				'on' => 'create', 
				),
			'length' => array(
				'rule'      => array('between', 8, 40),
				'message'   => 'Your password must be between 8 and 40 characters.',
				'on'        => 'create',  
				),
			),
		'mail' => array(
			'notEmpty' => array(
				'rule'    => array('notEmpty'),
				'message' => 'Please provide a valid Email'
				),
			'mail_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That email is already in use.',
				),
			'mail_valide' => array(
				'rule'    => array('email', true),
				'message' => 'That email is not valid.',
				),
			),
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
		'eve_id' => array(
			'eve_id_unique' => array(
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
			'className' => 'ticket',
			'foreignKey' => 'buyer_user_id',
			'dependent' => false,
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
			'className' => 'article',
			'foreignKey' => 'creator_user_id',
			'dependent' => false,
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
			'className' => 'lottery',
			'foreignKey' => 'creator_user_id',
			'dependent' => false,
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
			'className' => 'transaction',
			'foreignKey' => 'user_id',
			'dependent' => false,
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

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
		if($this->data['User']['password'] == ""){
			unset($this->data['User']['password']);
		}

	}

	/**
	 * Encoding password
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if(!empty($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		} 
		return true;
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
}
