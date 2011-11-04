<?php
/**
 * @version		$Id: redirect.php 20740 2011-02-17 10:28:57Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Redirect component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_redirect
 * @since		1.6
 */
class RedirectHelper
{
	public static $extension = 'com_redirect';

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName)
	{
		// No submenu for this component.
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user		= JFactory::getUser();
		$result		= new JObject;
		$assetName	= 'com_redirect';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Returns an array of standard published state filter options.
	 *
	 * @return	string			The HTML code for the select tag
	 */
	public static function publishedOptions()
	{
		// Build the active state filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '*', 'JALL');
		$options[]	= JHtml::_('select.option', '1', 'JENABLED');
		$options[]	= JHtml::_('select.option', '0', 'JDISABLED');
		$options[]	= JHtml::_('select.option', '2', 'JARCHIVED');
		$options[]	= JHtml::_('select.option', '-2', 'JTRASHED');

		return $options;
	}

	/**
	 * Determines if the plugin for Redirect to work is enabled.
	 *
	 * @return	boolean
	 */
	public static function isEnabled()
	{
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT enabled' .
			' FROM #__extensions' .
			' WHERE folder = '.$db->quote('system').
			'  AND element = '.$db->quote('redirect')
		);
		$result = (boolean) $db->loadResult();
		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}
		return $result;
	}
}