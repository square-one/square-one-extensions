<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_syndicate
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<a href="<?php echo $link ?>" class="syndicate-module<?php echo $moduleclass_sfx ?>">
	<?php echo JHtml::_('image','system/livemarks.png', 'feed-image', NULL, true); ?> <span><?php echo $text ?></span></a>
