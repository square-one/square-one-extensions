<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_joomlaupdate
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Joomla! Update Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_joomlaupdate
 * @since		2.5.4
 */
class JoomlaupdateController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	2.5.4
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Get the document object.
		$document = JFactory::getDocument();

		// Set the default view name and format from the Request.
		$vName		= JRequest::getCmd('view', 'default');
		$vFormat	= $document->getType();
		$lName		= JRequest::getCmd('layout', 'default');

		// Get and render the view.
		if ($view = $this->getView($vName, $vFormat)) {
			$ftp	= JClientHelper::setCredentialsFromRequest('ftp');
			$view->assignRef('ftp', $ftp);

			// Get the model for the view.
			$model = $this->getModel($vName);
			
			// Perform update source preference check and refresh update information
			$model->applyUpdateSite();
			$model->refreshUpdates();

			// Push the model into the view (as default).
			$view->setModel($model, true);
			$view->setLayout($lName);

			// Push document object into the view.
			$view->assignRef('document', $document);
			$view->display();
		}

		return $this;
	}
}
