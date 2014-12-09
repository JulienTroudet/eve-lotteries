<?php
App::uses('AppModel', 'Model');
/**
 * Transaction Model
 *
 * @property User $User
 */
class Statistic extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'type';


	public function saveStat($user_id, $type, $value, $iskValue, $eveItemId) {
		$this->create();
		$statData = array(
			'user_id' => $user_id,
			'type' => $type,
			'value' => $value,
			'isk_value' => $iskValue,
			'eve_item_id' => $eveItemId,
			);
		return $this->save($statData, true, array('user_id', 'type', 'value', 'isk_value', 'eve_item_id'));
	}


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'type' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'user_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
