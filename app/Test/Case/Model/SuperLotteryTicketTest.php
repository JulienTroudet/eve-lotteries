<?php
App::uses('SuperLotteryTicket', 'Model');

/**
 * SuperLotteryTicket Test Case
 *
 */
class SuperLotteryTicketTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.super_lottery_ticket',
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
		'app.buyer_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SuperLotteryTicket = ClassRegistry::init('SuperLotteryTicket');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SuperLotteryTicket);

		parent::tearDown();
	}

}
