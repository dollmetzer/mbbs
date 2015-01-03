-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2015 at 02:48 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mbbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `content` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`id`, `parent_id`, `content`, `name`, `description`) VALUES
(1, 0, 1, 'mBBS', 'All about the micro bulletin board system');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `active`, `protected`, `name`, `description`) VALUES
(1, 1, 1, 'operator', 'System Operator'),
(2, 1, 1, 'administrator', 'User/Group Administrator'),
(3, 1, 1, 'moderator', 'Content Moderator'),
(4, 1, 1, 'user', 'Basic User');

-- --------------------------------------------------------

--
-- Table structure for table `host`
--

CREATE TABLE IF NOT EXISTS `host` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `lastexport` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `host`
--

INSERT INTO `host` (`id`, `name`, `lastexport`, `confirmed`) VALUES
(1, 'mbbs', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` varchar(32) NOT NULL,
  `parent_mid` varchar(32) NOT NULL,
  `from` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `subject` varchar(80) NOT NULL,
  `written` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `read` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `handle` varchar(16) NOT NULL,
  `password` varchar(40) NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'de',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `active`, `handle`, `password`, `language`, `created`, `lastlogin`) VALUES
(1, 1, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 'en', '2014-10-23 12:00:00', '0000-00-00 00:00:00'),
(2, 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'en', '2014-10-23 12:00:00', '2015-01-03 14:43:19'),
(3, 1, 'moderator', '79f52b5b92498b00cb18284f1dcb466bd40ad559', 'en', '2014-10-23 12:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `fk_user_id` (`user_id`),
  KEY `fk_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
