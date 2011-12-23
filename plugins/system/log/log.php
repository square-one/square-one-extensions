<?php
/**
 * @version		$Id$
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Joomla! System Logging Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	System.log
 */
class  plgSystemLog extends JPlugin
{
	function onUserLoginFailure($response)
	{
		$log = JLog::getInstance();
		$errorlog = array();

		switch($response['status'])
		{
			case JAUTHENTICATE_STATUS_CANCEL :
			{
				$errorlog['status']  = $response['type'] . " CANCELED: ";
				$errorlog['comment'] = $response['error_message'];
				$log->addEntry($errorlog);
			} break;

			case JAUTHENTICATE_STATUS_FAILURE :
			{
				$errorlog['status']  = $response['type'] . " FAILURE: ";
				if ($this->params->get('log_username', 0)) {
					$errorlog['comment'] = $response['error_message'] . ' ("' . $response['username'] . '")';
				}
				else {
					$errorlog['comment'] = $response['error_message'];
				}
				$log->addEntry($errorlog);
			}	break;

			default :
			{
				$errorlog['status']  = $response['type'] . " UNKNOWN ERROR: ";
				$errorlog['comment'] = $response['error_message'];
				$log->addEntry($errorlog);
			}	break;
		}
	}
}
