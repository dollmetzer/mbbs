-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 08. Jan 2018 um 21:11
-- Server-Version: 5.7.20-0ubuntu0.16.04.1
-- PHP-Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `mbbs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `board`
--

CREATE TABLE `board` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `content` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `board`
--

INSERT INTO `board` (`id`, `parent_id`, `content`, `name`, `description`) VALUES
  (1, 0, 1, 'mBBS', 'All about the micro bulletin board system');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `host`
--

CREATE TABLE `host` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(16) NOT NULL,
  `lastexport` datetime,
  `confirmed` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `host`
--

INSERT INTO `host` (`id`, `name`, `lastexport`, `confirmed`) VALUES
  (1, 'mbbs', null, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mail`
--

CREATE TABLE `mail` (
  `id` int(10) UNSIGNED NOT NULL,
  `mid` varchar(32) NOT NULL,
  `parent_mid` varchar(32) DEFAULT NULL,
  `origin_mid` varchar(32) DEFAULT NULL,
  `from` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `subject` varchar(80) NOT NULL,
  `written` datetime,
  `read` datetime,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mail_attachment`
--

CREATE TABLE `mail_attachment` (
  `mail_id` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `type` enum('image','audio','video') NOT NULL DEFAULT 'image',
  `path` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session`
--

CREATE TABLE `session` (
  `id` varchar(32) NOT NULL,
  `start` datetime,
  `lastquery` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_handle` varchar(32) NOT NULL,
  `area` varchar(255) NOT NULL,
  `useragent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `mail_attachment`
--
ALTER TABLE `mail_attachment`
  ADD KEY `id` (`mail_id`);

--
-- Indizes für die Tabelle `session`
--
ALTER TABLE `session`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `board`
--
ALTER TABLE `board`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `host`
--
ALTER TABLE `host`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mail_attachment`
--
ALTER TABLE `mail_attachment`
  ADD CONSTRAINT `fk_mail_id` FOREIGN KEY (`mail_id`) REFERENCES `mail` (`id`) ON DELETE CASCADE;
