CREATE TABLE `#__messages` (
  `message_id` integer unsigned NOT NULL auto_increment,
  `user_id_from` integer unsigned NOT NULL default '0',
  `user_id_to` integer unsigned NOT NULL default '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`, `state`)
)  DEFAULT CHARSET=utf8;

CREATE TABLE `#__messages_cfg` (
  `user_id` integer unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE `idx_user_var_name` (`user_id`,`cfg_name`)
)  DEFAULT CHARSET=utf8;
