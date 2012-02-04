<?php
/**
 * Joomla! v1.5 Unit Test Facility
 *
 * @package Joomla
 * @subpackage UnitTest
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc.
 *
 */

jimport( 'joomla.environment.request' );

/**
 * A unit test class for JRequest
 */
class JRequestTest_GetMethod extends PHPUnit_Framework_TestCase
{

	/**
	 * Clear the cache
	 */
	function setUp() {
		// Make sure the request hash is clean.
		$GLOBALS['_JREQUEST'] = array();
	}

	function testGetMethod()
	{
		$_SERVER['REQUEST_METHOD'] = 'post';
		$this -> assertEquals('POST', JRequest::getMethod());
		$_SERVER['REQUEST_METHOD'] = 'get';
		$this -> assertEquals('GET', JRequest::getMethod());
	}

}


