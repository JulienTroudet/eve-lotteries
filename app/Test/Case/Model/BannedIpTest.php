<?php
App::uses('BannedIp', 'Model');

/**
 * BannedIp Test Case
 *
 */
class BannedIpTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.banned_ip'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BannedIp = ClassRegistry::init('BannedIp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BannedIp);

		parent::tearDown();
	}

}
