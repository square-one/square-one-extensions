<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Link table class for the Finder package.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 * @since       2.5
 */
class FinderTableLink extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   object  &$db  JDatabase connector object.
	 *
	 * @since   2.5
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__finder_links', 'link_id', $db);
	}
}
