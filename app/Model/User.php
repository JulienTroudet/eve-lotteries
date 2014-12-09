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

	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));

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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'minLength' => array(
				'rule' => array('minLength', '3'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'maxLength' => array(
				'rule' => array('maxLength', '50'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'username_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That name is already in use.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'minLength' => array(
				'rule' => array('minLength', '3'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'maxLength' => array(
				'rule' => array('maxLength', '50'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'mail' => array(
			'notEmpty' => array(
				'rule'    => array('notEmpty'),
				'message' => 'Please use a valid Email'
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'mail_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That email is already in use.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'mail_valide' => array(
				'rule'    => array('email', true),
				'message' => 'That email is not valid.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'wallet' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'eve_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'eve_id_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That EVE id is already in use.',
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
			)
		);
	/**
	 * Encoding password
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function beforeSave($options = array()) {
		$this->data['User']['password'] = AuthComponent::password(
			$this->data['User']['password']
			);
		return true;
	}
}
