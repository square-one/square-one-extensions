<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_newsfeeds
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Newsfeeds Component Controller
 *
 * @package		Joomla.Site
 * @subpackage	com_newsfeeds
 * @since		1.5
 */
class NewsfeedsController extends JControllerLegacy
{
	/**
	 * Method to show a newsfeeds view
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Set the default view name and format from the Request.
		$vName	= JRequest::getCmd('view', 'categories');
		JRequest::setVar('view', $vName);

		$user = JFactory::getUser();

		if ($user->get('id') || ($_SERVER['REQUEST_METHOD'] == 'POST' && $vName = 'category' )) {
			$cachable = false;
		}

		$safeurlparams = array('id'=>'INT', 'limit'=>'UINT', 'limitstart'=>'UINT', 'filter_order'=>'CMD', 'filter_order_Dir'=>'CMD', 'lang'=>'CMD');

		parent::display($cachable, $safeurlparams);
	}
}
