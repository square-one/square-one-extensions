<?php
/**
 * @version		$Id: contactemail.php 21321 2011-05-11 01:05:59Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.form.formrule');

require_once 'libraries/joomla/form/rules/email.php';

class JFormRuleContactEmail extends JFormRuleEmail
{
	public function test(& $element, $value, $group = null, & $input = null, & $form = null)
	{
		if(!parent::test($element, $value, $group, $input, $form)){
			return false;
		}

		$params = JComponentHelper::getParams('com_contact');
		$banned = $params->get('banned_email');

		foreach(explode(';', $banned) as $item){
			if (JString::stristr($item, $value) !== false)
					return false;
		}

		return true;
	}

}
