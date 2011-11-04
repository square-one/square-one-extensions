<?php
/**
 * @version		$Id: redirect.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.plugin.plugin');

/**
 * Plugin class for redirect handling.
 *
 * @package		Joomla.Plugin
 * @subpackage	System.redirect
 */
class plgSystemRedirect extends JPlugin
{
	/**
	 * Object Constructor.
	 *
	 * @access	public
	 * @param	object	The object to observe -- event dispatcher.
	 * @param	object	The configuration object for the plugin.
	 * @return	void
	 * @since	1.0
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		// Set the error handler for E_ERROR to be the class handleError method.
		JError::setErrorHandling(E_ERROR, 'callback', array('plgSystemRedirect', 'handleError'));
	}

	static function handleError(&$error)
	{
		// Get the application object.
		$app = JFactory::getApplication();

		// Make sure the error is a 404 and we are not in the administrator.
		if (!$app->isAdmin() and ($error->getCode() == 404))
		{
			// Get the full current URI.
			$uri = JURI::getInstance();
			$current = $uri->toString(array('scheme', 'host', 'port', 'path', 'query', 'fragment'));

			// Attempt to ignore idiots.
			if ((strpos($current, 'mosConfig_') !== false) || (strpos($current, '=http://') !== false)) {
				// Render the error page.
				JError::customErrorPage($error);
			}

			// See if the current url exists in the database as a redirect.
			$db = JFactory::getDBO();
			$db->setQuery(
				'SELECT `new_url`, `published`' .
				' FROM `#__redirect_links`' .
				' WHERE `old_url` = '.$db->quote($current),
				0, 1
			);
			$link = $db->loadObject();

			// If a redirect exists and is published, permanently redirect.
			if ($link and ($link->published == 1)) {
				$app->redirect($link->new_url, null, null, true, false);
			}
			else
			{
				$referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];

				// If not, add the new url to the database.
				$db->setQuery(
					'INSERT IGNORE INTO `#__redirect_links` (`old_url`, `referer`, `published`, `created_date`)' .
					' VALUES ('.$db->Quote($current).', '.$db->Quote($referer).', 0, '.$db->Quote(JFactory::getDate()->toMySQL()).')'
				);
				$db->query();

				// Render the error page.
				JError::customErrorPage($error);
			}
		}
		else {
			// Render the error page.
			JError::customErrorPage($error);
		}
	}
}
