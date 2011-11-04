<?php
/**
 * @version		$Id: helper.php 21359 2011-05-14 17:13:18Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modUsersLatestHelper
{
	// get users sorted by activation date
	static function getUsers($params)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.id, a.name, a.username, a.registerDate');
		$query->order('a.registerDate DESC');
		$query->from('#__users AS a');
		$db->setQuery($query,0,$params->get('shownumber'));
		$result = $db->loadObjectList();
		return (array) $result;
	}
}
