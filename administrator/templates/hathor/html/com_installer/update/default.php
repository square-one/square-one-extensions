<?php
/**
 * @version		$Id: default.php 22137 2011-09-22 23:45:02Z dextercowley $
 * @package		Joomla.Administrator
 * @subpackage	Templates.hathor
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.multiselect');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_installer&view=update');?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->showMessage) : ?>
		<?php echo $this->loadTemplate('message'); ?>
	<?php endif; ?>

	<?php if ($this->ftp) : ?>
		<?php echo $this->loadTemplate('ftp'); ?>
	<?php endif; ?>

	<?php if (count($this->items)) : ?>
	<table class="adminlist" cellspacing="1">
		<thead>
			<tr>
				<th class="checkmark-col"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
				<th class="nowrap"><?php echo JHtml::_('grid.sort', 'COM_INSTALLER_HEADING_NAME', 'name', $listDirn, $listOrder); ?></th>
				<th class="nowrap"><?php echo JHtml::_('grid.sort', 'COM_INSTALLER_HEADING_INSTALLTYPE', 'extension_id', $listDirn, $listOrder); ?></th>
				<th ><?php echo JHtml::_('grid.sort', 'COM_INSTALLER_HEADING_TYPE', 'type', $listDirn, $listOrder); ?></th>
				<th class="width-10" class="center"><?php echo JText::_('JVERSION'); ?></th>
				<th><?php echo JHtml::_('grid.sort', 'COM_INSTALLER_HEADING_FOLDER', 'folder', $listDirn, $listOrder); ?></th>
				<th><?php echo JHtml::_('grid.sort', 'COM_INSTALLER_HEADING_CLIENT', 'client_id', $listDirn, $listOrder); ?></th>
				<th class="width-25"><?php echo JText::_('COM_INSTALLER_HEADING_DETAILSURL'); ?></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach($this->items as $i=>$item):
			$client	= $item->client_id ? JText::_('JADMINISTRATOR') : JText::_('JSITE');
		?>
			<tr class="row<?php echo $i%2; ?>">
				<td><?php echo JHtml::_('grid.id', $i, $item->update_id); ?></td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_('JGLOBAL_DESCRIPTION');?>::<?php echo $item->description ? $item->description : JText::_('COM_INSTALLER_MSG_UPDATE_NODESC'); ?>">
					<?php echo $item->name; ?>
					</span>
				</td>
				<td class="center">
					<?php echo $item->extension_id ? JText::_('COM_INSTALLER_MSG_UPDATE_UPDATE') : JText::_('COM_INSTALLER_NEW_INSTALL') ?>
				</td>
				<td><?php echo JText::_('COM_INSTALLER_TYPE_' . $item->type) ?></td>
				<td class="center"><?php echo $item->version ?></td>
				<td class="center"><?php echo @$item->folder != '' ? $item->folder : JText::_('COM_INSTALLER_TYPE_NONAPPLICABLE'); ?></td>
				<td class="center"><?php echo $client; ?></td>
				<td><?php echo $item->detailsurl ?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<?php echo $this->pagination->getListFooter(); ?>

	<?php else : ?>
		<p class="nowarning"><?php echo JText::_('COM_INSTALLER_MSG_UPDATE_NOUPDATES'); ?></p>
	<?php endif; ?>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
