<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_plugins
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'plugin.cancel' || document.formvalidator.isValid(document.id('style-form'))) {
			Joomla.submitform(task, document.getElementById('style-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_plugins&layout=edit&extension_id='.(int) $this->item->extension_id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('JDETAILS') ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('name'); ?>
			<?php echo $this->form->getInput('name'); ?>
			<span class="readonly plg-name"><?php echo JText::_($this->item->name);?></span></li>

			<li><?php echo $this->form->getLabel('enabled'); ?>
			<?php echo $this->form->getInput('enabled'); ?></li>

			<li><?php echo $this->form->getLabel('access'); ?>
			<?php echo $this->form->getInput('access'); ?></li>

			<li><?php echo $this->form->getLabel('ordering'); ?>
			<?php echo $this->form->getInput('ordering'); ?></li>

			<li><?php echo $this->form->getLabel('folder'); ?>
			<?php echo $this->form->getInput('folder'); ?></li>

			<li><?php echo $this->form->getLabel('element'); ?>
			<?php echo $this->form->getInput('element'); ?></li>

			<?php if ($this->item->extension_id) : ?>
				<li><?php echo $this->form->getLabel('extension_id'); ?>
				<?php echo $this->form->getInput('extension_id'); ?></li>
			<?php endif; ?>
			</ul>
			<!-- Plugin metadata -->
			<?php if ($this->item->xml) : ?>
				<?php if ($text = trim($this->item->xml->description)) : ?>

					<label id="jform_extdescription-lbl">
						<?php echo JText::_('JGLOBAL_DESCRIPTION'); ?>
					</label>
					<div class="clr"></div>
					<span class="readonly plg-desc">
						<?php echo JText::_($text); ?>
					</span>

				<?php endif; ?>
			<?php else : ?>
				<?php echo JText::_('COM_PLUGINS_XML_ERR'); ?>
			<?php endif; ?>

		</fieldset>
	</div>

	<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start', 'plugin-sliders-'.$this->item->extension_id); ?>

		<?php echo $this->loadTemplate('options'); ?>

		<div class="clr"></div>

	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	</div>

	<div class="clr"></div>
</form>
