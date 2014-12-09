<?php
App::uses('Message', 'Model');

/**
 * Message Test Case
 *
 */
class MessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.message',
		'app.user',
		'app.group',
		'app.ticket',
		'app.lottery',
		'app.eve_item',
		'app.eve_category',
		'app.super_lottery',
		'app.super_lottery_ticket',
		'app.lottery_status',
		'app.withdrawal',
		'app.article',
		'app.statistic',
		'app.transaction',
		'app.user_award',
		'app.award',
		'app.user_awards'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Message = ClassRegistry::init('Message');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Message);

		parent::tearDown();
	}

}
