<?php
App::uses('EveCategory', 'Model');

/**
 * EveCategory Test Case
 *
 */
class EveCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.eve_category',
		'app.eve_item'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EveCategory = ClassRegistry::init('EveCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EveCategory);

		parent::tearDown();
	}

}
