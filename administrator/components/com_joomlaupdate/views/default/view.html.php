<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_joomlaupdate
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       2.5.2
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Joomla! Update's Default View
 *
 * @package     Joomla.Administrator
 * @subpackage  com_installer
 * @since       2.5.2
 */
class JoomlaupdateViewDefault extends JView
{
	/**
	 * Renders the view
	 * 
	 * @param   string  $tpl  Template name
	 * 
	 * @return void
	 */
	public function display($tpl=null)
	{
		// Get data from the model
		$this->state = $this->get('State');

		// Load useful classes
		$model = $this->getModel();
		$this->loadHelper('select');

		// Assign view variables
		$ftp = $model->getFTPOptions();
		$this->assign('updateInfo', $model->getUpdateInformation());
		$this->assign('methodSelect', JoomlaupdateHelperSelect::getMethods($ftp['enabled']));

		// Set the toolbar information
		JToolBarHelper::title(JText::_('COM_JOOMLAUPDATE_OVERVIEW'), 'install');

		// Add toolbar buttons
		JToolBarHelper::preferences('com_joomlaupdate');

		// Load mooTools
		JHtml::_('behavior.framework');

		// Load our Javascript
		$document = JFactory::getDocument();
		$document->addScript('../media/com_joomlaupdate/default.js');

		// Render the view
		parent::display($tpl);
	}

}
