<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JForm.
 *
 * @package		Joomla.UnitTest
 * @subpackage	Form
 *
 */
class JFormRuleEqualsTest extends JoomlaTestCase
{
	/**
	 * set up for testing
	 *
	 * @return void
	 */
	public function setUp()
	{
		jimport('joomla.form.formrule');
		jimport('joomla.utilities.xmlelement');
		require_once JPATH_BASE.'/libraries/joomla/form/rules/equals.php';
	}

	/**
	 * Test the JFormRuleEquals::test method.
	 */
	public function testEquals()
	{
		// Initialise variables.

		$rule = new JFormRuleEquals;
		$xml = simplexml_load_string('<form><field name="foo" /></form>', 'JXMLElement');

		// Test fail conditions.

		// Test pass conditions.

		$this->markTestIncomplete();
	}
}