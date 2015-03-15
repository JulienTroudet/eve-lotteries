<?php
App::uses('AppModel', 'Model');
/**
 * Config Model
 *
 */
class Config extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';


	/**
	 * every time a ticket or a lottery is changed this function is called (in afterSave)
	 * it update the timestamp
	 * @return [type] [description]
	 */
	public function changeLotteries() {
		$this->updateAll(
			array('Config.value' => time()),
			array('Config.name' => 'lotteries_timestamp')
			);
	}

	/**
	 * every time a super ticket or a super lottery is changed this function is called (in afterSave)
	 * it update the timestamp
	 * @return [type] [description]
	 */
	public function changeSuperLotteries() {
		$this->updateAll(
			array('Config.value' => time()),
			array('Config.name' => 'super_lotteries_timestamp')
			);
	}

	/**
	 * every time a flash ticket or a flash lottery is changed this function is called (in afterSave)
	 * it update the timestamp
	 * @return [type] [description]
	 */
	public function changeFlashLotteries() {
		$this->updateAll(
			array('Config.value' => time()),
			array('Config.name' => 'flash_lotteries_timestamp')
			);
	}

	/**
	 * Check if the given timestamp is the same as the actual lotteries timestamp
	 * 
	 * @param  [type]  $timestamp [description]
	 * @return boolean            [description]
	 */
	public function hasLotteriesChanged($timestamp) {
		$conf = $this->findByName('lotteries_timestamp');

		if($timestamp != $conf['Config']['value']){
			return true;
		}

		return false;
	}

	/**
	 * Check if the given timestamp is the same as the actual super lotteries timestamp
	 * 
	 * @param  [type]  $timestamp [description]
	 * @return boolean            [description]
	 */
	public function hasSuperLotteriesChanged($timestamp) {
		$conf = $this->findByName('super_lotteries_timestamp');

		if($timestamp != $conf['Config']['value']){
			return true;
		}

		return false;
	}

	/**
	 * Check if the given timestamp is the same as the actual flash lotteries timestamp
	 * 
	 * @param  [type]  $timestamp [description]
	 * @return boolean            [description]
	 */
	public function hasFlashLotteriesChanged($timestamp) {
		$conf = $this->findByName('flash_lotteries_timestamp');

		if($timestamp != $conf['Config']['value']){
			return true;
		}

		return false;
	}

	/**
	 * Get the actual lotteries timestamp
	 * @return [type] [description]
	 */
	public function getLotteriesTimestamp() {
		$conf = $this->findByName('lotteries_timestamp');
		return $conf['Config']['value'];
	}

	/**
	 * Get the actual super lotteries timestamp
	 * @return [type] [description]
	 */
	public function getSuperLotteriesTimestamp() {
		$conf = $this->findByName('super_lotteries_timestamp');
		return $conf['Config']['value'];
	}

	/**
	 * Get the actual flash lotteries timestamp
	 * @return [type] [description]
	 */
	public function getFlashLotteriesTimestamp() {
		$conf = $this->findByName('flash_lotteries_timestamp');
		return $conf['Config']['value'];
	}

	


	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
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
		'value' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
}
