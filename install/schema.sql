-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Nov 2014 um 17:07
-- Server Version: 5.5.29
-- PHP-Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `mbbs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `board`
--

CREATE TABLE `board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `content` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `board`
--

INSERT INTO `board` (`id`, `parent_id`, `content`, `name`, `description`) VALUES
(1, 0, 1, 'mBBS', 'All about the micro bulletin board system');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--

CREATE TABLE `group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(16) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
-- Tabellenstruktur für Tabelle `host`
--

CREATE TABLE `host` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `lastexport` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `host`
--

INSERT INTO `host` (`id`, `name`, `lastexport`, `confirmed`) VALUES
(1, 'mbbs', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mail`
--

CREATE TABLE `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
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

CREATE TABLE `user_group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `fk_user_id` (`user_id`),
  KEY `fk_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_group`
--

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
