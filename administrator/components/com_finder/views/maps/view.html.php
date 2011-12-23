<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Groups view class for Finder.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 * @since       2.5
 */
class FinderViewMaps extends JView
{
	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   2.5
	 */
	public function display($tpl = null)
	{
		// Load the view data.
		$this->items		= $this->get('Items');
		$this->total		= $this->get('Total');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Prepare the view.
		$this->addToolbar();

		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
		parent::display($tpl);
	}

	/**
	 * Method to configure the toolbar for this view.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected function addToolbar()
	{
		// For whatever reason, the helper isn't being found
		include_once JPATH_COMPONENT . '/helpers/finder.php';
		$canDo	= FinderHelper::getActions();

		JToolBarHelper::title(JText::_('COM_FINDER_MAPS_TOOLBAR_TITLE'), 'finder');
		$toolbar = JToolBar::getInstance('toolbar');

		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::publishList('maps.publish');
			JToolBarHelper::unpublishList('maps.unpublish');
			JToolBarHelper::divider();
		}
		if ($canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', 'maps.delete');
			JToolBarHelper::divider();
		}
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_finder');
		}
		JToolBarHelper::divider();
		$toolbar->appendButton('Popup', 'stats', 'COM_FINDER_STATISTICS', 'index.php?option=com_finder&view=statistics&tmpl=component', 550, 500);
		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_FINDER_MANAGE_CONTENT_MAPS');
	}
}
