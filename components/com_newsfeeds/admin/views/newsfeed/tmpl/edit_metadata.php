<?php
/**
 * @version		$Id: edit_metadata.php 21529 2011-06-11 22:17:15Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_newsfeeds
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$fieldSets = $this->form->getFieldsets('metadata');
foreach ($fieldSets as $name => $fieldSet) :
	echo JHtml::_('sliders.panel',JText::_($fieldSet->label), $name.'-options');
	if (isset($fieldSet->description) && trim($fieldSet->description)) :
		echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
	endif;
	?>
	<fieldset class="panelform">
	<ul class="adminformlist">
		<?php if ($name == 'jmetadata') : // Include the real fields in this panel. ?>
			<li><?php echo $this->form->getLabel('metadesc'); ?>
			<?php echo $this->form->getInput('metadesc'); ?></li>

			<li><?php echo $this->form->getLabel('metakey'); ?>
			<?php echo $this->form->getInput('metakey'); ?></li>

			<li><?php echo $this->form->getLabel('xreference'); ?>
			<?php echo $this->form->getInput('xreference'); ?></li>
		<?php endif; ?>
		<?php foreach ($this->form->getFieldset($name) as $field) : ?>
			<li><?php echo $field->label; ?>
			<?php echo $field->input; ?></li>
		<?php endforeach; ?>
	</ul>
	</fieldset>
<?php endforeach; ?>