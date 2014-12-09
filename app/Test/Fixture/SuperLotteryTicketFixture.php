<?php
/**
 * SuperLotteryTicketFixture
 *
 */
class SuperLotteryTicketFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'super_lottery_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'buyer_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false),
		'nb_tickets' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'super_lottery_id' => 1,
			'buyer_user_id' => 1,
			'nb_tickets' => 1
		),
	);

}
