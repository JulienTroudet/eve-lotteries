<?php
App::uses('SuperLottery', 'Model');

/**
 * SuperLottery Test Case
 *
 */
class SuperLotteryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.super_lottery',
		'app.eve_item',
		'app.eve_category',
		'app.lottery',
		'app.lottery_status',
		'app.user',
		'app.group',
		'app.ticket',
		'app.withdrawal',
		'app.article',
		'app.statistic',
		'app.transaction',
		'app.user_award',
		'app.award',
		'app.user_awards',
		'app.creator_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SuperLottery = ClassRegistry::init('SuperLottery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SuperLottery);

		parent::tearDown();
	}

}
