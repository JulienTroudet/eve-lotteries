<?php
App::uses('Award', 'Model');

/**
 * Award Test Case
 *
 */
class AwardTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.award'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Award = ClassRegistry::init('Award');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Award);

		parent::tearDown();
	}

}
