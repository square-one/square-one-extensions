<?php
/**
 * @version		$Id: default.php 21049 2011-04-01 02:05:21Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php if (!empty($names)) : ?>
	<ul  class="latestusers<?php echo $moduleclass_sfx ?>" >
	<?php foreach($names as $name) : ?>
		<li>
			<?php if ($linknames == 1) : ?>
				<a href="index.php?option=com_users&view=profile&member_id=<?php echo (int) $name->id ?>">
				<?php echo $name->username; ?>
				</a>
			<?php else : ?>
				<?php echo $name->username; ?>
			<?php endif; ?>
		</li>
	<?php endforeach;  ?>
	</ul>
<?php endif; ?>