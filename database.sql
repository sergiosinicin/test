SET NAMES utf8;
SET time_zone = '+03:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
CREATE DATABASE IF NOT EXISTS `test_db` COLLATE 'utf8mb4_unicode_ci';

SET NAMES utf8mb4;
DROP TABLE IF EXISTS `property_type`;
CREATE TABLE `property_type` (
 `id` INT(10),
 `title`VARCHAR(64) NOT NULL,
 `description` TEXT  NOT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `property_type_title_index` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `property`;
CREATE TABLE `property` (
     `id` INT(11) AUTO_INCREMENT,
     `uuid` VARCHAR(64) NOT NULL,
     `county` VARCHAR(255)  NOT NULL,
     `country` VARCHAR(255)  NOT NULL,
     `town` VARCHAR(255)  NOT NULL,
     `description` TEXT  NOT NULL,
     `address` VARCHAR(255)  NOT NULL,
     `image_full` VARCHAR(255) NULL DEFAULT NULL,
     `image_thumbnail` VARCHAR(255) NULL DEFAULT NULL,
     `latitude` DECIMAL(11,8)  NULL DEFAULT NULL,
     `longitude` DECIMAL(11,8) NULL DEFAULT NULL,
     `num_bedrooms` TINYINT(3) UNSIGNED DEFAULT '0',
     `num_bathrooms` TINYINT(3) UNSIGNED DEFAULT '0',
     `price` DECIMAL(12,2) UNSIGNED DEFAULT '0.00',
     `property_type_id` INT UNSIGNED  DEFAULT '0',
     `type` ENUM('sale','rent'),
     `created_at` timestamp NULL DEFAULT NULL,
     `updated_at` timestamp NULL DEFAULT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `property` ADD KEY `num_bedrooms` (`num_bedrooms`);
ALTER TABLE `property` ADD KEY `country` (`price`);
ALTER TABLE `property` ADD KEY `type` (`type`);
ALTER TABLE `property` ADD KEY `property_type_id` (`property_type_id`);

