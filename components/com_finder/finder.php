<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT . '/helpers/route.php';

// Execute the task.
$controller = JController::getInstance('Finder');
$controller->execute(JFactory::getApplication()->input->get('task', '', 'word'));
$controller->redirect();
