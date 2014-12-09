<?php
/**
 * LotteryFixture
 *
 */
class LotteryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'eve_item_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creator_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'timestamp', 'null' => false),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'nb_tickets' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'lottery_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'lotteries_eve_items' => array('column' => 'eve_item_id', 'unique' => 0),
			'lotteries_lottery_status' => array('column' => 'lottery_status_id', 'unique' => 0),
			'lotteries_users' => array('column' => 'creator_user_id', 'unique' => 0)
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
			'eve_item_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'creator_user_id' => 1,
			'created' => 1409997527,
			'modified' => 1409997527,
			'nb_tickets' => 1,
			'lottery_status_id' => 1
		),
	);

}
