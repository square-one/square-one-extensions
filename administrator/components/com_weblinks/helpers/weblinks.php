<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Weblinks helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_weblinks
 * @since		1.6
 */
class WeblinksHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 * @since	1.6
	 */
	public static function addSubmenu($vName = 'weblinks')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_WEBLINKS_SUBMENU_WEBLINKS'),
			'index.php?option=com_weblinks&view=weblinks',
			$vName == 'weblinks'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_WEBLINKS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_weblinks',
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_weblinks')),
				'weblinks-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_weblinks';
		} else {
			$assetName = 'com_weblinks.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
