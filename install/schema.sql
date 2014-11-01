-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. Okt 2014 um 19:39
-- Server Version: 5.5.37-0ubuntu0.13.10.1
-- PHP-Version: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `mbbs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `content` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Daten für Tabelle `board`
--

INSERT INTO `board` (`id`, `parent_id`, `content`, `name`, `description`) VALUES
(1, 0, 1, 'mBBS', 'All about the micro bulletin board system');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(16) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `group`
--

INSERT INTO `group` (`id`, `active`, `name`, `description`) VALUES
(1, 1, 'operator', 'System Operator'),
(2, 1, 'administrator', 'User/Group Administrator'),
(3, 1, 'moderator', 'Content Moderator'),
(4, 1, 'user', 'Basic User');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `subject` varchar(80) NOT NULL,
  `written` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `read` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `active`, `handle`, `password`, `language`, `created`, `lastlogin`) VALUES
(1, 1, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 'en', '2014-10-23 12:00:00', '0000-00-00 00:00:00'),
(2, 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'en', '2014-10-23 12:00:00', '0000-00-00 00:00:00'),
(3, 1, 'moderator', '79f52b5b92498b00cb18284f1dcb466bd40ad559', 'en', '2014-10-23 12:00:00', '0000-00-00 00:00:00');


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_group`
--

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 2),
(3, 3);
