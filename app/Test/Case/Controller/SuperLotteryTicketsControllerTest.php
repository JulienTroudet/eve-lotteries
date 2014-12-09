<?php
App::uses('SuperLotteryTicketsController', 'Controller');

/**
 * SuperLotteryTicketsController Test Case
 *
 */
class SuperLotteryTicketsControllerTest extends ControllerTestCase {

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

}
