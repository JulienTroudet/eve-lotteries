<?php
/**
 * TicketFixture
 *
 */
class TicketFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'lottery_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'position' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'buyer_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'is_winner' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'value' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '20,2', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'tickets_lotteries' => array('column' => 'lottery_id', 'unique' => 0),
			'tickets_users' => array('column' => 'buyer_user_id', 'unique' => 0)
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
			'lottery_id' => 1,
			'position' => 1,
			'buyer_user_id' => 1,
			'is_winner' => 1,
			'value' => ''
		),
	);

}
