<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	Templates.hathor
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
?>
	<fieldset class="adminform" title="<?php echo JText::_('COM_LANGUAGES_FTP_TITLE'); ?>">
		<legend><?php echo JText::_('COM_LANGUAGES_FTP_TITLE'); ?></legend>

		<?php echo JText::_('COM_LANGUAGES_FTP_DESC'); ?>

		<?php if ($ftp instanceof Exception): ?>
			<p class="warning"><?php echo JText::_($ftp->message); ?></p>
		<?php endif; ?>

		<div>
			<label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
			<input type="text" id="username" name="username" class="inputbox" value="" />
		</div>
		<div>
			<label for="password"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
			<input type="password" id="password" name="password" class="inputbox" value="" />
		</div>
	</fieldset>
