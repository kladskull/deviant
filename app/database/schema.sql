CREATE DATABASE deviant
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- use this for all your actions. Instead of delete, use a field called deleted
CREATE USER 'deviantuser'@'localhost' IDENTIFIED BY 'somepassword';
GRANT SELECT,INSERT,UPDATE ON deviant.* to 'deviantuser'@'localhost';

USE deviant;

-- Create syntax for TABLE 'cache'
CREATE TABLE `cache` (
  `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key`     CHAR(190)        NOT NULL DEFAULT '',
  `value`   LONGTEXT         NOT NULL,
  `expires` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- Create syntax for TABLE 'user'
CREATE TABLE `user` (
  `id`            INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_address` CHAR(150)                 DEFAULT NULL,
  `first_name`    CHAR(50)                  DEFAULT NULL,
  `last_name`     CHAR(50)                  DEFAULT NULL,
  `password`      CHAR(255)                 DEFAULT NULL,
  `user_guid`     CHAR(128)                 DEFAULT NULL,
  `locked`        TINYINT(3) UNSIGNED       DEFAULT '1',
  `record_guid`   CHAR(128)                 DEFAULT NULL,
  `date_created`  DATETIME                  DEFAULT NULL,
  `created_by`    INT(10) UNSIGNED          DEFAULT NULL,
  `date_modified` DATETIME                  DEFAULT NULL,
  `modified_by`   INT(10) UNSIGNED          DEFAULT NULL,
  `admin`         TINYINT(3) UNSIGNED       DEFAULT '0',
  `signature`     CHAR(128)                 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  UNIQUE KEY `user_guid` (`user_guid`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

create table api
(
    `id` int auto_increment
        primary key,
    `user_id` int null,
    `access_id` char(128) null,
    `description` char(255) null,
    `last_used` datetime null,
    `locked` int null,
    `record_guid` char(128) null,
    `date_created` datetime null,
    `created_by` int null,
    `date_modified` datetime null,
    `modified_by` int null,
    `signature` char(128) null
);
