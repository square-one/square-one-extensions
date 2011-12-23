<?php
/**
 * @version		$Id$
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
$id = "";
if(array_key_exists('id', $button)) {
	if(!empty($button['id'])) {
		$id = 'id ="'.$button['id'].'"';
	}
}
?>
<div class="icon-wrapper" <?php echo $id ?>>
	<div class="icon">
		<a href="<?php echo $button['link']; ?>">
			<?php echo JHtml::_('image', $button['image'], NULL, NULL, true); ?>
			<span><?php echo $button['text']; ?></span></a>
	</div>
</div>
