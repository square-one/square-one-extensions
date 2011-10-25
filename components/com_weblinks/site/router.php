<?php
/**
 * @version		$Id: router.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

 /* Weblinks Component Route Helper
 *
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since 1.6
 */

defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Build the route for the com_weblinks component
 *
 * @param	array	An array of URL arguments
 *
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 */
function WeblinksBuildRoute(&$query)
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_weblinks');
	$advanced	= $params->get('sef_advanced_link', 0);

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	}
	else {
		$menuItem = $menu->getItem($query['Itemid']);
	}

	$mView	= (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
	$mCatid	= (empty($menuItem->query['catid'])) ? null : $menuItem->query['catid'];
	$mId	= (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];

	if (isset($query['view'])) {
		$view = $query['view'];

		if (empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}

		unset($query['view']);
	}

	// are we dealing with an weblink that is attached to a menu item?
	if (isset($query['view']) && ($mView == $query['view']) and (isset($query['id'])) and ($mId == intval($query['id']))) {
		unset($query['view']);
		unset($query['catid']);
		unset($query['id']);

		return $segments;
	}

	if (isset($view) and ($view == 'category' or $view == 'weblink' )) {
		if ($mId != intval($query['id']) || $mView != $view) {
			if ($view == 'weblink' && isset($query['catid'])) {
				$catid = $query['catid'];
			}
			else if (isset($query['id'])) {
				$catid = $query['id'];
			}

			$menuCatid = $mId;
			$categories = JCategories::getInstance('Weblinks');
			$category = $categories->get($catid);

			if ($category) {
				//TODO Throw error that the category either not exists or is unpublished
				$path = $category->getPath();
				$path = array_reverse($path);

				$array = array();
				foreach($path as $id)
				{
					if ((int) $id == (int)$menuCatid) {
						break;
					}

					if ($advanced) {
						list($tmp, $id) = explode(':', $id, 2);
					}

					$array[] = $id;
				}
				$segments = array_merge($segments, array_reverse($array));
			}

			if ($view == 'weblink') {
				if ($advanced) {
					list($tmp, $id) = explode(':', $query['id'], 2);
				}
				else {
					$id = $query['id'];
				}

				$segments[] = $id;
			}
		}

		unset($query['id']);
		unset($query['catid']);
	}

	if (isset($query['layout'])) {
		if (!empty($query['Itemid']) && isset($menuItem->query['layout'])) {
			if ($query['layout'] == $menuItem->query['layout']) {
				unset($query['layout']);
			}
		}
		else {
			if ($query['layout'] == 'default') {
				unset($query['layout']);
			}
		}
	};

	return $segments;
}
/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 */
function WeblinksParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	$params = JComponentHelper::getParams('com_weblinks');
	$advanced = $params->get('sef_advanced_link', 0);

	// Count route segments
	$count = count($segments);

	// Standard routing for weblinks.
	if (!isset($item)) {
		$vars['view']	= $segments[0];
		$vars['id']		= $segments[$count - 1];
		return $vars;
	}

	// From the categories view, we can only jump to a category.
	$id = (isset($item->query['id']) && $item->query['id'] > 1) ? $item->query['id'] : 'root';

	$category = JCategories::getInstance('Weblinks')->get($id);

	$categories = $category->getChildren();
	$found = 0;

	foreach($segments as $segment)
	{
		foreach($categories as $category)
		{
			if (($category->slug == $segment) || ($advanced && $category->alias == str_replace(':', '-',$segment))) {
				$vars['id'] = $category->id;
				$vars['view'] = 'category';
				$categories = $category->getChildren();
				$found = 1;

				break;
			}
		}

		if ($found == 0) {
			if ($advanced) {
				$db = JFactory::getDBO();
				$query = 'SELECT id FROM #__weblinks WHERE catid = '.$vars['id'].' AND alias = '.$db->Quote(str_replace(':', '-',$segment));
				$db->setQuery($query);
				$id = $db->loadResult();
			}
			else {
				$id = $segment;
			}

			$vars['id'] = $id;
			$vars['view'] = 'weblink';

			break;
		}

		$found = 0;
	}

	return $vars;
}
