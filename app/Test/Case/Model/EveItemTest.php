<?php
App::uses('EveItem', 'Model');

/**
 * EveItem Test Case
 *
 */
class EveItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.eve_item',
		'app.category',
		'app.lottery'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EveItem = ClassRegistry::init('EveItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EveItem);

		parent::tearDown();
	}

}
