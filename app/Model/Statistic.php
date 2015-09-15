<?php
App::uses('AppModel', 'Model');
App::uses('Config', 'Model');
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


    /**
     * Update some configs to optimise some request
     * - set the total_won config
     * @param boolean $created
     * @param  array  $options
     * @return boolean
     */
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);

        $last = $this->findById($this->id);

        if($last['Statistic']['type'] =='win_lottery' || $last['Statistic']['type'] =='win_super_lottery' ||$last['Statistic']['type'] =='win_flash_lottery' ) {

            $params = array(
                'conditions' => array('OR'=>array(array('Statistic.type' => 'win_super_lottery'), array('Statistic.type' => 'win_lottery'), array('Statistic.type' => 'win_flash_lottery'))),
                'fields' => array('SUM(Statistic.isk_value) as totalAmount'),
            );
            $total = $this->find('first', $params);
            if(isset($total[0])){
                $total_won =  $total[0]['totalAmount'];

                $configModel = new Config();

                $configModel->updateTotalWon($total_won);
            }

        }
        return true;
    }


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
