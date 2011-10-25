<?php
/**
 * @version		$Id: default_batch.php 21447 2011-06-04 17:39:55Z dextercowley $
 * @package		Joomla.Administrator
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>
<fieldset class="batch">
	<legend><?php echo JText::_('COM_WEBLINKS_BATCH_OPTIONS');?></legend>
	<?php echo JHtml::_('batch.access');?>

	<?php if ($published >= 0) : ?>
		<?php echo JHtml::_('batch.item', 'com_weblinks', $published);?>
	<?php endif; ?>
	<button type="submit" onclick="Joomla.submitbutton('weblink.batch');">
		<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
	</button>
	<button type="button" onclick="document.id('batch-category-id').value='';document.id('batch-access').value=''">
		<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
	</button>
</fieldset>
