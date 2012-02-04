<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
JLoader::register('BannersHelper', JPATH_COMPONENT.'/helpers/banners.php');

/**
 * View to edit a banner.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.5
 */
class BannersViewBanner extends JView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo		= BannersHelper::getActions($this->item->catid,0);

		JToolBarHelper::title($isNew ? JText::_('COM_BANNERS_MANAGER_BANNER_NEW') : JText::_('COM_BANNERS_MANAGER_BANNER_EDIT'), 'banners.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_banners', 'core.create')) > 0)) {
			JToolBarHelper::apply('banner.apply');
			JToolBarHelper::save('banner.save');

			if ($canDo->get('core.create')) {
				JToolBarHelper::save2new('banner.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::save2copy('banner.save2copy');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('banner.cancel');
		}
		else {
			JToolBarHelper::cancel('banner.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_BANNERS_BANNERS_EDIT');
	}
}
