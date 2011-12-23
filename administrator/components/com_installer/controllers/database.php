<?php
/**
 * @version		$Id$
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 */
class InstallerControllerDatabase extends JController
{

	/**
	 * Tries to fix missing database updates
	 *
	 * @since	2.5
	 */
	function fix()
	{
		$model = $this->getModel('database');
		$model->fix();
		$this->setRedirect(JRoute::_('index.php?option=com_installer&view=database',false));
	}
}
