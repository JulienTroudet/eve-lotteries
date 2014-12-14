<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property User $User
 */
class Message extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'title';

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
		unset($this->data['Message']['modified']);
	}

	public function sendMessage($user_id, $title, $body, $controller_name, $action_name) {
		$this->create();
		$statData = array(
			'user_id' => $user_id,
			'status' => 'unread',
			'title' => $title,
			'body' => $body,
			'controller_name' => $controller_name,
			'action_name' => $action_name,
			);

		$this->incrementMessageCount($user_id);

		return $this->save($statData, true, array('user_id', 'status', 'title', 'body', 'controller_name', 'action_name'));
	}

	public function sendLotteryMessage($user_id, $title, $body, $withdrawal_group_id) {
		$this->create();
		$statData = array(
			'user_id' => $user_id,
			'status' => 'unread',
			'title' => $title,
			'body' => $body,
			'controller_name' => 'withdrawals',
			'action_name' => 'view',
			'model_id' => $withdrawal_group_id,
			);

		$this->incrementMessageCount($user_id);

		return $this->save($statData, true, array('user_id', 'status', 'title', 'body', 'controller_name', 'action_name', 'model_id'));
	}

	public function sendSuperLotteryMessage($user_id, $title, $body, $super_lotteries_id) {
		$this->create();
		$statData = array(
			'user_id' => $user_id,
			'status' => 'unread',
			'title' => $title,
			'body' => $body,
			'controller_name' => 'withdrawals',
			'action_name' => 'index',
			'anchor_name' => 'tab_super-lotteries-pane',
			);

		$this->incrementMessageCount($user_id);

		return $this->save($statData, true, array('user_id', 'status', 'title', 'body', 'controller_name', 'action_name', 'anchor_name'));
	}

	public function sendSponsorMessage($user_id, $budy) {
		$this->create();
		$statData = array(
			'user_id' => $user_id,
			'status' => 'unread',
			'title' => $budy['User']['eve_name'].' sponsored !',
			'body' => $budy['User']['eve_name'].' used your sponsor link to register. You will earn credits every time he/she makes a deposit.',
			'controller_name' => 'users',
			'action_name' => 'account',
			);

		$this->incrementMessageCount($user_id);

		return $this->save($statData, true, array('user_id', 'status', 'title', 'body', 'controller_name', 'action_name'));
	}

	public function incrementMessageCount($id) {
		$this->User->id = $id;
		$data = $this->User->read();
		$this->User->saveField('nb_new_messages', ($data['User']['nb_new_messages']+1));
	}

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				),
			),
		'status' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				),
			),
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				),
			),
		'body' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				),
			),
		);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			)
		);
}
