-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Jan 2017 um 18:51
-- Server Version: 5.5.53-0ubuntu0.14.04.1
-- PHP-Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `zzapapp`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if group is protected from change or delete',
  `name` varchar(16) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `group`
--

INSERT INTO `group` (`id`, `active`, `protected`, `name`, `description`) VALUES
(1, 1, 1, 'guest', 'Guest'),
(2, 1, 1, 'user', 'Basic User'),
(3, 1, 0, 'premium', 'Premium User'),
(4, 1, 0, 'moderator', 'Content Moderator'),
(5, 1, 0, 'operator', 'Operator'),
(6, 1, 1, 'administrator', 'Administrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `handle` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `email` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `confirmed` datetime DEFAULT NULL,
  `confirmcode` varchar(8) NOT NULL COMMENT 'Code for confirmin registration',
  `lastlogin` datetime DEFAULT NULL,
  `token` varchar(32) NOT NULL DEFAULT '' COMMENT 'Token ist used for quicklogin',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'useragent used at last login'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `active`, `handle`, `password`, `language`, `email`, `created`, `confirmed`, `confirmcode`, `lastlogin`, `token`, `useragent`) VALUES
(1, 1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'de', 'your.name@yourdomain.com', '2017-01-01 12:00:00', '2017-01-01 12:00:00', '', '2017-01-01 12:00:00', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `fk_user_id` (`user_id`),
  KEY `fk_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_group`
--

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1, 6),
(1, 2);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_ug_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ug_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
