<?php
App::uses('TransactionsController', 'Controller');

/**
 * TransactionsController Test Case
 *
 */
class TransactionsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.transaction',
		'app.user',
		'app.group',
		'app.ticket',
		'app.lottery',
		'app.eve_item',
		'app.eve_category',
		'app.lottery_status',
		'app.article'
	);

}
