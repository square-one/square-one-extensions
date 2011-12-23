<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.Highlight
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_BASE') or die;

jimport('joomla.application.component.helper');

/**
 * System plugin to highlight terms.
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Highlight
 * @since       2.5
 */
class PlgSystemHighlight extends JPlugin
{
	/**
	 * Method to catch the onAfterDispatch event.
	 *
	 * This is where we setup the click-through content highlighting for.
	 * The highlighting is done with JavaScript so we just
	 * need to check a few parameters and the JHtml behavior will do the rest.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.5
	 */
	public function onAfterDispatch()
	{
		// Check that we are in the site application.
		if (JFactory::getApplication()->isAdmin())
		{
			return true;
		}

		// Set the variables
		$input = JFactory::getApplication()->input;
		$extension = $input->get('option', '', 'cmd');

		// Check if the highlighter is enabled.
		if (!JComponentHelper::getParams($extension)->get('highlight_terms', 1))
		{
			return true;
		}

		// Check if the highlighter should be activated in this environment.
		if (JFactory::getDocument()->getType() !== 'html' || $input->get('tmpl', '', 'cmd') === 'component')
		{
			return true;
		}

		// Get the terms to highlight from the request.
		$terms = $input->request->get('highlight', null, 'base64');
		$terms = $terms ? unserialize(base64_decode($terms)) : null;

		// Check the terms.
		if (empty($terms))
		{
			return true;
		}

		// Activate the highlighter.
		JHtml::stylesheet('plugins/system/finder/media/css/highlight.css', false, false, false);
		JHtml::_('behavior.highlighter', $terms);

		// Adjust the component buffer.
		$doc = JFactory::getDocument();
		$buf = $doc->getBuffer('component');
		$buf = '<br id="highlight-start" />' . $buf . '<br id="highlight-end" />';
		$doc->setBuffer($buf, 'component');

		return true;
	}
}
