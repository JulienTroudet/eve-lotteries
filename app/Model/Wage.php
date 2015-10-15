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

    public function addIskToWage($recipient_id, $amount, $withdrawal_id) {

        $params = array(
            'conditions' => array(
                'Wage.recipient_id' => $recipient_id,
                'Wage.status' => 'unclaimed'
            ),

        );
        $wage = $this->find('first', $params);

        if(empty($wage)){
            $wage = array(
                'Wage'=> array(
                    'recipient_id' => $recipient_id,
                    'amount' => $amount,
                    'status' => 'unclaimed',
                    'withdrawals_array' => $withdrawal_id,
                )
            );
            $this->create();
            return $this->save($wage);
        }
        else{
            $wage['Wage']['amount'] = $wage['Wage']['amount']+$amount;

            $wage['Wage']['withdrawals_array'] = $wage['Wage']['withdrawals_array'].','.$withdrawal_id;

            return $this->save($wage, true, array('id', 'amount'));
        }
    }

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
