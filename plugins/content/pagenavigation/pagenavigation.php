<?php
/**
 * @version		$Id: pagenavigation.php 21814 2011-07-11 14:51:10Z chdemko $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Pagenavigation plugin class.
 *
 * @package		Joomla.Plugin
 * @subpackage	Content.pagenavigation
 */
class plgContentPagenavigation extends JPlugin
{
	/**
	 * @since	1.6
	 */
	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
	{
		$view = JRequest::getCmd('view');
		$print = JRequest::getBool('print');

		if ($print) {
			return false;
		}

		if ($params->get('show_item_navigation') && ($context == 'com_content.article') && ($view == 'article')) {
			$html = '';
			$db		= JFactory::getDbo();
			$user	= JFactory::getUser();
			$app	= JFactory::getApplication();
			$lang	= JFactory::getLanguage();
			$nullDate = $db->getNullDate();

			$date	= JFactory::getDate();
			$config	= JFactory::getConfig();
			$now	= $date->toMySQL();

			$uid	= $row->id;
			$option	= 'com_content';
			$canPublish = $user->authorise('core.edit.state', $option.'.article.'.$row->id);

			// The following is needed as different menu items types utilise a different param to control ordering.
			// For Blogs the `orderby_sec` param is the order controlling param.
			// For Table and List views it is the `orderby` param.
			$params_list = $params->toArray();
			if (array_key_exists('orderby_sec', $params_list)) {
				$order_method = $params->get('orderby_sec', '');
			} else {
				$order_method = $params->get('orderby', '');
			}
			// Additional check for invalid sort ordering.
			if ($order_method == 'front') {
				$order_method = '';
			}

			// Determine sort order.
			switch ($order_method) {
				case 'date' :
					$orderby = 'a.created';
					break;
				case 'rdate' :
					$orderby = 'a.created DESC';
					break;
				case 'alpha' :
					$orderby = 'a.title';
					break;
				case 'ralpha' :
					$orderby = 'a.title DESC';
					break;
				case 'hits' :
					$orderby = 'a.hits';
					break;
				case 'rhits' :
					$orderby = 'a.hits DESC';
					break;
				case 'order' :
					$orderby = 'a.ordering';
					break;
				case 'author' :
					$orderby = 'a.created_by_alias, u.name';
					break;
				case 'rauthor' :
					$orderby = 'a.created_by_alias DESC, u.name DESC';
					break;
				case 'front' :
					$orderby = 'f.ordering';
					break;
				default :
					$orderby = 'a.ordering';
					break;
			}

			$xwhere = ' AND (a.state = 1 OR a.state = -1)' .
			' AND (publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).')' .
			' AND (publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).')';

			// Array of articles in same category correctly ordered.
			$query	= $db->getQuery(true);
			$query->select('a.id, '
					.'CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug, '
					.'CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug');
			$query->from('#__content AS a');
			$query->leftJoin('#__categories AS cc ON cc.id = a.catid');
			$query->where('a.catid = '. (int)$row->catid .' AND a.state = '. (int)$row->state
						. ($canPublish ? '' : ' AND a.access = ' .(int)$row->access) . $xwhere);
			$query->order($orderby);
			if ($app->isSite() && $app->getLanguageFilter()) {
				$query->where('a.language in ('.$db->quote($lang->getTag()).','.$db->quote('*').')');
			}

			$db->setQuery($query);
			$list = $db->loadObjectList('id');

			// This check needed if incorrect Itemid is given resulting in an incorrect result.
			if (!is_array($list)) {
				$list = array();
			}

			reset($list);

			// Location of current content item in array list.
			$location = array_search($uid, array_keys($list));

			$rows = array_values($list);

			$row->prev = null;
			$row->next = null;

			if ($location -1 >= 0)	{
				// The previous content item cannot be in the array position -1.
				$row->prev = $rows[$location -1];
			}

			if (($location +1) < count($rows)) {
				// The next content item cannot be in an array position greater than the number of array postions.
				$row->next = $rows[$location +1];
			}

			$pnSpace = "";
			if (JText::_('JGLOBAL_LT') || JText::_('JGLOBAL_GT')) {
				$pnSpace = " ";
			}

			if ($row->prev) {
				$row->prev = JRoute::_(ContentHelperRoute::getArticleRoute($row->prev->slug, $row->prev->catslug));
			} else {
				$row->prev = '';
			}

			if ($row->next) {
				$row->next = JRoute::_(ContentHelperRoute::getArticleRoute($row->next->slug, $row->next->catslug));
			} else {
				$row->next = '';
			}

			// Output.
			if ($row->prev || $row->next) {
				$html = '
				<ul class="pagenav">'
				;
				if ($row->prev) {
					$html .= '
					<li class="pagenav-prev">
						<a href="'. $row->prev .'" rel="next">'
							. JText::_('JGLOBAL_LT') . $pnSpace . JText::_('JPREV') . '</a>
					</li>'
					;
				}



				if ($row->next) {
					$html .= '
					<li class="pagenav-next">
						<a href="'. $row->next .'" rel="prev">'
							. JText::_('JNEXT') . $pnSpace . JText::_('JGLOBAL_GT') .'</a>
					</li>'
					;
				}
				$html .= '
				</ul>'
				;

				$position	= $this->params->get('position', 1);

				if ($position) {
					// Display after content.
					$row->text .= $html;
				} else {
					// Display before content.
					$row->text = $html . $row->text;
				}
			}
		}

		return ;
	}
}
