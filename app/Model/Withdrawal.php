<?php
App::uses('AppModel', 'Model');
/**
 * Ticket Model
 *
 * @property Lottery $Lottery
 * @property User $User
 */
class Withdrawal extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'value';

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'ticket_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
