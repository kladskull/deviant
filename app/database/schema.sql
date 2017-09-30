-- Create syntax for TABLE 'cache'
CREATE TABLE `cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` char(190) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'user'
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` char(150) DEFAULT NULL,
  `first_name` char(50) DEFAULT NULL,
  `last_name` char(50) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `user_guid` char(128) DEFAULT NULL,
  `locked` tinyint(3) unsigned DEFAULT '1',
  `date_created` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `admin` tinyint(3) unsigned DEFAULT '0',
  `signature` char(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  UNIQUE KEY `user_guid` (`user_guid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;