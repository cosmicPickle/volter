-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране: 
-- Версия на сървъра: 5.6.12-log
-- Версия на PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `volter`
--
CREATE DATABASE IF NOT EXISTS `volter` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `volter`;

-- --------------------------------------------------------

--
-- Структура на таблица `volter_achievements`
--

CREATE TABLE IF NOT EXISTS `volter_achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `level` int(2) NOT NULL,
  `volts_req` bigint(64) NOT NULL,
  `avg_req` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Схема на данните от таблица `volter_achievements`
--

INSERT INTO `volter_achievements` (`id`, `name`, `title`, `description`, `cat_id`, `level`, `volts_req`, `avg_req`, `created_at`, `updated_at`) VALUES
(1, 'Brainer', 'Small of Brains', 'Get 5 Star ratings on Intelligence.', 2, 1, 5, 9, '2013-11-12 20:47:07', '2013-12-03 13:52:23'),
(2, 'Brainer', 'More of Brains', 'Get 5 Star ratings on Intelligence.', 2, 2, 10, 9, '2013-11-12 20:47:07', '2013-12-03 13:52:23'),
(3, 'Brainer', 'Knowledge is power', 'Get 5 Star ratings on Intelligence.', 2, 3, 15, 9, '2013-11-12 20:47:07', '2013-12-03 13:52:23');

-- --------------------------------------------------------

--
-- Структура на таблица `volter_achievement_records`
--

CREATE TABLE IF NOT EXISTS `volter_achievement_records` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fb_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fb_uid` (`fb_uid`,`achievement_id`),
  KEY `achievement_id` (`achievement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Схема на данните от таблица `volter_achievement_records`
--

INSERT INTO `volter_achievement_records` (`id`, `fb_uid`, `achievement_id`, `created_at`, `updated_at`) VALUES
(18, '100001583788628', 1, '2013-12-04 08:49:01', '2013-12-04 08:49:01'),
(19, '100001583788628', 2, '2013-12-04 08:50:13', '2013-12-04 08:50:13');

-- --------------------------------------------------------

--
-- Структура на таблица `volter_categories`
--

CREATE TABLE IF NOT EXISTS `volter_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sys_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Схема на данните от таблица `volter_categories`
--

INSERT INTO `volter_categories` (`id`, `sys_name`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'sexiness', 'Sexiness', 'This rates the person on their looks.', '2013-11-12 18:47:54', '0000-00-00 00:00:00'),
(2, 'intelligence', 'Intelligence', 'This rates the person''s brains.', '2013-11-12 18:47:54', '0000-00-00 00:00:00'),
(7, 'endurance', 'Endurance', 'This category rates the person in his ability to maintain physical activities.', '2013-11-12 16:54:46', '2013-11-12 16:54:46');

-- --------------------------------------------------------

--
-- Структура на таблица `volter_users`
--

CREATE TABLE IF NOT EXISTS `volter_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fb_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `volts` int(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fb_uid` (`fb_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Схема на данните от таблица `volter_users`
--

INSERT INTO `volter_users` (`id`, `fb_uid`, `volts`, `created_at`, `updated_at`) VALUES
(7, '100000681428755', 0, '2013-11-19 11:56:11', '2013-11-19 11:56:11'),
(13, '100001583788628', 0, '2013-12-03 20:29:43', '2013-12-03 20:29:43');

-- --------------------------------------------------------

--
-- Структура на таблица `volter_volts`
--

CREATE TABLE IF NOT EXISTS `volter_volts` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `from_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `to_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `volt` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `from_uid` (`from_uid`),
  KEY `to_uid` (`to_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Схема на данните от таблица `volter_volts`
--

INSERT INTO `volter_volts` (`id`, `cat_id`, `from_uid`, `to_uid`, `volt`, `created_at`, `updated_at`) VALUES
(45, 1, '100001583788628', '100000681428755', 10, '2013-12-03 22:39:29', '2013-12-04 08:35:30'),
(46, 7, '100001583788628', '100000681428755', 10, '2013-12-03 22:39:53', '2013-12-04 08:35:26'),
(50, 2, '100001583788628', '100000681428755', 10, '2013-12-03 20:49:01', '2013-12-03 20:49:01'),
(51, 2, '100001583788628', '100000681428755', 10, '2013-12-04 06:07:16', '2013-12-04 06:07:16'),
(52, 2, '100001583788628', '100000681428755', 10, '2013-12-04 06:31:52', '2013-12-04 06:31:52');

-- --------------------------------------------------------

--
-- Структура на таблица `volter_volt_scores`
--

CREATE TABLE IF NOT EXISTS `volter_volt_scores` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `fb_uid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `volts_count` bigint(64) NOT NULL,
  `volts_score` bigint(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`fb_uid`,`cat_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `volter_achievements`
--
ALTER TABLE `volter_achievements`
  ADD CONSTRAINT `volter_achievements_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `volter_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `volter_achievement_records`
--
ALTER TABLE `volter_achievement_records`
  ADD CONSTRAINT `volter_achievement_records_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `volter_achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volter_achievement_records_ibfk_3` FOREIGN KEY (`fb_uid`) REFERENCES `volter_users` (`fb_uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `volter_volts`
--
ALTER TABLE `volter_volts`
  ADD CONSTRAINT `volter_volts_ibfk_3` FOREIGN KEY (`cat_id`) REFERENCES `volter_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volter_volts_ibfk_4` FOREIGN KEY (`from_uid`) REFERENCES `volter_users` (`fb_uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volter_volts_ibfk_5` FOREIGN KEY (`to_uid`) REFERENCES `volter_users` (`fb_uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `volter_volt_scores`
--
ALTER TABLE `volter_volt_scores`
  ADD CONSTRAINT `volter_volt_scores_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `volter_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volter_volt_scores_ibfk_3` FOREIGN KEY (`fb_uid`) REFERENCES `volter_users` (`fb_uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
