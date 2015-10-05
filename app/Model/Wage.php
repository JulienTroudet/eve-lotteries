<?php
App::uses('AppModel', 'Model');
/**
 * Wage Model
 *
 * @property test $test
 * @property Recipient $Recipient
 * @property Admin $Admin
 */
class Wage extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'recipient_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'amount' => array(
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
		'Recipient' => array(
			'className' => 'User',
			'foreignKey' => 'recipient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Admin' => array(
			'className' => 'User',
			'foreignKey' => 'admin_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
