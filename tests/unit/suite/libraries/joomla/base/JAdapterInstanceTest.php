<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

require_once JPATH_BASE.'/libraries/joomla/base/adapterinstance.php';
/**
 * Test class for JAdapterInstance.
 * Generated by PHPUnit on 2009-10-08 at 11:43:00.
 */
class JAdapterInstanceTest extends JoomlaDatabaseTestCase {
	/**
	 * @var	JAdapterInstance
	 * @access protected
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp() {

	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown() {
	}

	/**
	 * @todo Decide how to Implement.
	 */
	public function testGetParent() {
		require_once(JPATH_BASE.'/libraries/joomla/base/adapterinstance.php');
		$this->object = new JAdapter(dirname(__FILE__), 'Test', 'adapters');

		$this->assertThat(
			$this->object->getAdapter('Testadapter3')->getParent(),
			$this->identicalTo($this->object)
		);
	}
}