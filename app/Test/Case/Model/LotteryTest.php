<?php
App::uses('Lottery', 'Model');

/**
 * Lottery Test Case
 *
 */
class LotteryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lottery',
		'app.eve_item',
		'app.category',
		'app.lottery_status',
		'app.user',
		'app.group',
		'app.ticket',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lottery = ClassRegistry::init('Lottery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lottery);

		parent::tearDown();
	}

}
