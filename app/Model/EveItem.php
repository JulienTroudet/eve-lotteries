<?php
App::uses('AppModel', 'Model');
/**
 * EveItem Model
 *
 * @property EveCategory $EveCategory
 * @property Lottery $Lottery
 */
class EveItem extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';

public $actsAs = array('Containable');

public function getTicketPrice($eveItem) {


		$evePrice = $eveItem['EveItem']['eve_value'];

		$nbTickets = $eveItem['EveItem']['nb_tickets_default'];

		$profit = $eveItem['EveCategory']['profit'];

		$newPrice = $evePrice + (($evePrice*($profit/100)));

		$ticketPrice = (int) round($newPrice/$nbTickets, -6);

		return $ticketPrice;

	}

/**
 * Validation rules
 *
 * @var array
 */
public $validate = array(
	'eve_id' => array(
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
	'eve_category_id' => array(
		'numeric' => array(
			'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	'eve_value' => array(
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
		'numeric' => array(
			'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	'nb_tickets_default' => array(
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
	'EveCategory' => array(
		'className' => 'EveCategory',
		'foreignKey' => 'eve_category_id',
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
	'Lottery' => array(
		'className' => 'Lottery',
		'foreignKey' => 'eve_item_id',
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

}
