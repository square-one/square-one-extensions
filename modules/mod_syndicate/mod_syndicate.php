<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_syndicate
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$params->def('format', 'rss');

$link = modSyndicateHelper::getLink($params);

if (is_null($link)) {
	return;
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$text = htmlspecialchars($params->get('text'));

require JModuleHelper::getLayoutPath('mod_syndicate', $params->get('layout', 'default'));
