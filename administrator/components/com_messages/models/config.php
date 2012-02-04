<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

/**
 * Message configuration model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_messages
 * @since		1.6
 */
class MessagesModelConfig extends JModelForm
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app	= JFactory::getApplication('administrator');
		$user	= JFactory::getUser();

		$this->setState('user.id', $user->get('id'));

		// Load the parameters.
		$params	= JComponentHelper::getParams('com_messages');
		$this->setState('params', $params);
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem()
	{
		// Initialise variables.
		$item = new JObject;

		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('cfg_name, cfg_value');
		$query->from('#__messages_cfg');
		$query->where('user_id = '.(int) $this->getState('user.id'));

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		if ($error = $db->getErrorMsg()) {
			$this->setError($error);
			return false;
		}

		foreach ($rows as $row) {
			$item->set($row->cfg_name, $row->cfg_value);
		}

		return $item;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_messages.config', 'config', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 * @return	boolean	True on success.
	 */
	public function save($data)
	{
		$db = $this->getDbo();

		if ($userId = (int) $this->getState('user.id')) {
			$db->setQuery(
				'DELETE FROM #__messages_cfg'.
				' WHERE user_id = '. $userId
			);
			$db->query();
			if ($error = $db->getErrorMsg()) {
				$this->setError($error);
				return false;
			}

			$tuples = array();
			foreach ($data as $k => $v) {
				$tuples[] =  '('.$userId.', '.$db->Quote($k).', '.$db->Quote($v).')';
			}

			if ($tuples) {
				$db->setQuery(
					'INSERT INTO #__messages_cfg'.
					' (user_id, cfg_name, cfg_value)'.
					' VALUES '.implode(',', $tuples)
				);
				$db->query();
				if ($error = $db->getErrorMsg()) {
					$this->setError($error);
					return false;
				}
			}
			return true;
		} else {
			$this->setError('COM_MESSAGES_ERR_INVALID_USER');
			return false;
		}
	}
}
