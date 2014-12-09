<?php
App::uses('LotteryStatus', 'Model');

/**
 * LotteryStatus Test Case
 *
 */
class LotteryStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lottery_status',
		'app.lottery'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LotteryStatus = ClassRegistry::init('LotteryStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LotteryStatus);

		parent::tearDown();
	}

}
