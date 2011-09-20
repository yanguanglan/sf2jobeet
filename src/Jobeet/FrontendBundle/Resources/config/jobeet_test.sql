-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Hoszt: localhost
-- Létrehozás ideje: 2011. szept. 20. 11:27
-- Szerver verzió: 5.5.8
-- PHP verzió: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `jobeet_test`
--
DROP DATABASE IF EXISTS `jobeet_test`;
CREATE DATABASE `jobeet_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jobeet_test`;

-- --------------------------------------------------------

--
-- Tábla szerkezet: `affiliate`
--

CREATE TABLE IF NOT EXISTS `affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `affiliate_U_1` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- A tábla adatainak kiíratása `affiliate`
--

INSERT INTO `affiliate` (`id`, `url`, `email`, `token`, `is_active`, `created_at`) VALUES
(1, 'http://www.sensio-labs.com/', 'fabien.potencier@example.com', 'sensio_labs', 1, NULL),
(2, 'http://www.symfony-project.org/', 'example@example.com', 'symfony', 0, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_U_1` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- A tábla adatainak kiíratása `category`
--

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(1, 'Design', 'design'),
(2, 'Programming', 'programming'),
(3, 'Manager', 'manager'),
(4, 'Administrator', 'administrator');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `categoryaffiliate`
--

CREATE TABLE IF NOT EXISTS `categoryaffiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- A tábla adatainak kiíratása `categoryaffiliate`
--

INSERT INTO `categoryaffiliate` (`id`, `affiliate_id`, `category_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `how_to_apply` text NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_public` tinyint(4) NOT NULL DEFAULT '1',
  `is_activated` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_U_1` (`token`),
  KEY `job_FI_1` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- A tábla adatainak kiíratása `job`
--

INSERT INTO `job` (`id`, `category_id`, `type`, `company`, `logo`, `url`, `position`, `location`, `description`, `how_to_apply`, `token`, `is_public`, `is_activated`, `email`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'full-time', 'Sensio Labs', 'sensio-labs.gif', 'http://www.sensiolabs.com/', 'Web Designer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_sensio_labs', 1, 1, 'job@example.com', '2012-10-10 00:00:00', NULL, NULL),
(2, 1, 'part-time', 'Extreme Sensio', 'extreme-sensio.gif', 'http://www.extreme-sensio.com/', 'expired', 'Paris, France', 'You''ve already developed websites with symfony and you want to work with Open-Source technologies. You have a minimum of 3 years experience in web development with PHP or Java and you wish to participate to development of Web 2.0 sites using the best frameworks available.', 'Send your resume to fabien.potencier [at] sensio.com', 'expired_job', 1, 1, 'job@example.com', '2010-10-10 00:00:00', NULL, NULL),
(3, 2, 'part-time', 'Company_100', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_100', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(4, 2, 'part-time', 'Company_101', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_101', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(5, 2, 'part-time', 'Company_102', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_102', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(6, 2, 'part-time', 'Company_103', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_103', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(7, 2, 'part-time', 'Company_104', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_104', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(8, 2, 'part-time', 'Company_105', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_105', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(9, 2, 'part-time', 'Company_106', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_106', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(10, 2, 'part-time', 'Company_107', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_107', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(11, 2, 'part-time', 'Company_108', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_108', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(12, 2, 'part-time', 'Company_109', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_109', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(13, 2, 'part-time', 'Company_110', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_110', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(14, 2, 'part-time', 'Company_111', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_111', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(15, 2, 'part-time', 'Company_112', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_112', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(16, 2, 'part-time', 'Company_113', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_113', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(17, 2, 'part-time', 'Company_114', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_114', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(18, 2, 'part-time', 'Company_115', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_115', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(19, 2, 'part-time', 'Company_116', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_116', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(20, 2, 'part-time', 'Company_117', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_117', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(21, 2, 'part-time', 'Company_118', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_118', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(22, 2, 'part-time', 'Company_119', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_119', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(23, 2, 'part-time', 'Company_120', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_120', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(24, 2, 'part-time', 'Company_121', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_121', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(25, 2, 'part-time', 'Company_122', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_122', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(26, 2, 'part-time', 'Company_123', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_123', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(27, 2, 'part-time', 'Company_124', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_124', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(28, 2, 'part-time', 'Company_125', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_125', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(29, 2, 'part-time', 'Company_126', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_126', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(30, 2, 'part-time', 'Company_127', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_127', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(31, 2, 'part-time', 'Company_128', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_128', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(32, 2, 'part-time', 'Company_129', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_129', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(33, 2, 'part-time', 'Company_130', NULL, 'http://www.extreme-sensio.com/', 'Web Developer', 'Paris, France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n		    \r\n		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_130', 1, 1, 'job@example.com', '2011-12-10 00:00:00', NULL, NULL),
(34, 1, 'part-time', 'Expires', NULL, 'http://www.fictional.com/', 'Designer', 'Tomorrow', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.\r\n	    \r\n	    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Send your resume to fabien.potencier [at] sensio.com', 'job_extendable', 1, 1, 'job@example.com', '2011-09-20 00:00:00', NULL, NULL);