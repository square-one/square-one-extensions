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
 * Filter view class for Finder.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 * @since       2.5
 */
class FinderViewFilter extends JView
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
		$this->filter = $this->get('Filter');
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
		JHtml::addIncludePath(JPATH_SITE . '/components/com_finder/helpers/html');

		// Configure the toolbar.
		$this->addToolbar();

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
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user = JFactory::getUser();
		$userId = $user->get('id');
		$isNew = ($this->item->filter_id == 0);
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo = FinderHelper::getActions();

		// Configure the toolbar.
		JToolBarHelper::title(JText::_('COM_FINDER_FILTER_EDIT_TOOLBAR_TITLE'), 'finder');

		// Set the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::apply('filter.apply');
				JToolBarHelper::save('filter.save');
				JToolBarHelper::save2new('filter.save2new');
			}
			JToolBarHelper::cancel('filter.cancel');
		}
		else
		{
			// Since it's an existing record, check the edit permission.
			if ($canDo->get('core.edit'))
			{
				JToolBarHelper::apply('filter.apply');
				JToolBarHelper::save('filter.save');

				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create'))
				{
					JToolBarHelper::save2new('filter.save2new');
				}
			}
			// If an existing item, can save as a copy
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::save2copy('filter.save2copy');
			}
			JToolBarHelper::cancel('filter.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
