-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.2.0.4675
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table ads_system.ad
DROP TABLE IF EXISTS `ad`;
CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ad_job` (`job_id`),
  KEY `FK_ad_user` (`user_id`),
  CONSTRAINT `FK_ad_job` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_ad_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.ad: ~2 rows (approximately)
/*!40000 ALTER TABLE `ad` DISABLE KEYS */;
INSERT INTO `ad` (`id`, `user_id`, `job_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(14, 1, 1, '2015-09-14 08:14:55', '2015-09-14 16:18:11', NULL),
	(15, 1, 2, '2015-09-14 08:34:02', '2015-09-14 16:17:54', NULL);
/*!40000 ALTER TABLE `ad` ENABLE KEYS */;


-- Dumping structure for table ads_system.ad_job_location
DROP TABLE IF EXISTS `ad_job_location`;
CREATE TABLE IF NOT EXISTS `ad_job_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `job_location` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `additional_info` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_ad_job_location_ad` (`ad_id`),
  CONSTRAINT `FK_ad_job_location_ad` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.ad_job_location: ~3 rows (approximately)
/*!40000 ALTER TABLE `ad_job_location` DISABLE KEYS */;
INSERT INTO `ad_job_location` (`id`, `ad_id`, `job_location`, `additional_info`) VALUES
	(10, 14, '11', '11'),
	(11, 15, '11', '22'),
	(12, 14, '22', '22');
/*!40000 ALTER TABLE `ad_job_location` ENABLE KEYS */;


-- Dumping structure for table ads_system.ad_newspaper
DROP TABLE IF EXISTS `ad_newspaper`;
CREATE TABLE IF NOT EXISTS `ad_newspaper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `newspaper_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ad_newspaper_ad` (`ad_id`),
  KEY `FK_ad_newspaper_newspaper` (`newspaper_id`),
  CONSTRAINT `FK_ad_newspaper_ad` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ad_newspaper_newspaper` FOREIGN KEY (`newspaper_id`) REFERENCES `newspaper` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.ad_newspaper: ~3 rows (approximately)
/*!40000 ALTER TABLE `ad_newspaper` DISABLE KEYS */;
INSERT INTO `ad_newspaper` (`id`, `ad_id`, `newspaper_id`) VALUES
	(8, 14, 1),
	(9, 15, 1),
	(10, 14, 2);
/*!40000 ALTER TABLE `ad_newspaper` ENABLE KEYS */;


-- Dumping structure for table ads_system.ad_newspaper_placement_date
DROP TABLE IF EXISTS `ad_newspaper_placement_date`;
CREATE TABLE IF NOT EXISTS `ad_newspaper_placement_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_newspaper_id` int(11) NOT NULL,
  `placement_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ad_newspaper_placement_date_ad_newspaper` (`ad_newspaper_id`),
  CONSTRAINT `FK_ad_newspaper_placement_date_ad_newspaper` FOREIGN KEY (`ad_newspaper_id`) REFERENCES `ad_newspaper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.ad_newspaper_placement_date: ~8 rows (approximately)
/*!40000 ALTER TABLE `ad_newspaper_placement_date` DISABLE KEYS */;
INSERT INTO `ad_newspaper_placement_date` (`id`, `ad_newspaper_id`, `placement_date`) VALUES
	(31, 8, '2015-09-14'),
	(32, 9, '2015-09-03'),
	(36, 8, '2015-09-30'),
	(37, 10, '2015-09-16'),
	(38, 10, '2015-09-18'),
	(39, 10, '2015-09-14'),
	(40, 10, '2015-09-26'),
	(41, 8, '2015-09-03'),
	(42, 9, '2015-09-14'),
	(43, 9, '2015-09-15'),
	(44, 10, '2015-09-15');
/*!40000 ALTER TABLE `ad_newspaper_placement_date` ENABLE KEYS */;


-- Dumping structure for table ads_system.auth_assignment
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.auth_assignment: ~2 rows (approximately)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('admin', '1', 1442228899),
	('user', '2', 1442128504);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;


-- Dumping structure for table ads_system.auth_item
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.auth_item: ~6 rows (approximately)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('/site/*', 2, NULL, NULL, NULL, 1442132033, 1442132033),
	('/user/security/login', 2, NULL, NULL, NULL, 1442131097, 1442131097),
	('/user/security/logout', 2, NULL, NULL, NULL, 1442131103, 1442131103),
	('admin', 1, 'Admin role', NULL, NULL, 1442126834, 1442126834),
	('user', 1, 'User role', NULL, NULL, 1442126853, 1442126853);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;


-- Dumping structure for table ads_system.auth_item_child
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.auth_item_child: ~4 rows (approximately)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('user', '/site/*'),
	('user', '/user/security/login'),
	('user', '/user/security/logout');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;


-- Dumping structure for table ads_system.auth_rule
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.auth_rule: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;


-- Dumping structure for table ads_system.job
DROP TABLE IF EXISTS `job`;
CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.job: ~2 rows (approximately)
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
INSERT INTO `job` (`id`, `job_name`, `deleted_at`) VALUES
	(1, 'Zusteller', NULL),
	(2, 'Springer', NULL);
/*!40000 ALTER TABLE `job` ENABLE KEYS */;


-- Dumping structure for table ads_system.migration
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.migration: ~9 rows (approximately)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1441440073),
	('m140209_132017_init', 1441440077),
	('m140403_174025_create_account_table', 1441440078),
	('m140504_113157_update_tables', 1441440081),
	('m140504_130429_create_token_table', 1441440082),
	('m140506_102106_rbac_init', 1441441682),
	('m140830_171933_fix_ip_field', 1441440083),
	('m140830_172703_change_account_table_name', 1441440083),
	('m141222_110026_update_ip_field', 1441440084);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;


-- Dumping structure for table ads_system.newspaper
DROP TABLE IF EXISTS `newspaper`;
CREATE TABLE IF NOT EXISTS `newspaper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newspaper_name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ads_system.newspaper: ~13 rows (approximately)
/*!40000 ALTER TABLE `newspaper` DISABLE KEYS */;
INSERT INTO `newspaper` (`id`, `newspaper_name`, `deleted_at`) VALUES
	(1, 'NWZ Gesamtausgabe', NULL),
	(2, 'NWZ Hauptausgabe', NULL),
	(3, 'NWZ Oldenburger Nachrichten', NULL),
	(4, 'NWZ Ammenländer Nachrichten', NULL),
	(5, 'NWZ Oldenburger Kreiszeitung', NULL),
	(6, 'NWZ Wesermarsch-Zeitung', NULL),
	(7, 'NWZ Kreiszeitung Friesland', NULL),
	(8, 'NWZ Der Münsterländer', NULL),
	(9, 'NWZ Kleinanzeiger', NULL),
	(10, 'NWZ Karriereteil', NULL),
	(11, 'Hunte Report', NULL),
	(12, 'SonntagsZeitung', NULL),
	(13, 'Friesländer Bote', NULL);
/*!40000 ALTER TABLE `newspaper` ENABLE KEYS */;


-- Dumping structure for table ads_system.profile
DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table ads_system.profile: ~2 rows (approximately)
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`) VALUES
	(1, NULL, NULL, 'admin@a.aa', '8c90f1cf97cbd6a7ffb0f84f1a08cbc4', NULL, NULL, NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;


-- Dumping structure for table ads_system.social_account
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE IF NOT EXISTS `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table ads_system.social_account: ~0 rows (approximately)
/*!40000 ALTER TABLE `social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_account` ENABLE KEYS */;


-- Dumping structure for table ads_system.token
DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table ads_system.token: ~0 rows (approximately)
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;


-- Dumping structure for table ads_system.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table ads_system.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
	(1, 'admin', 'admin@a.aa', '$2y$10$EmIFqjOw1L9Em0zfzExanuO44CeExOuaMsGO/.Fx2Nbf5DEXfmpxi', 'qVv15fOr8JILJoFu86mKIoG_b-Qomn_A', 1442126600, NULL, NULL, '127.0.0.1', 1442126600, 1442126600, 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
