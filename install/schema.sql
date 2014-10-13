-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Okt 2014 um 21:30
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `board`
--

INSERT INTO `board` (`id`, `parent_id`, `content`, `name`, `description`) VALUES
(1, 0, 1, 'mBBS', 'Alles zum micro bulletin board system'),
(2, 0, 1, 'Gastronomie', 'Essen und Trinken hält Leib und Magen zusammen.'),
(3, 0, 0, 'Kultur', 'Filme, Musik, Bücher, Theater, Kunst '),
(4, 0, 1, 'Soziales', 'Miteinander und Füreinander'),
(5, 3, 1, 'Filme', ''),
(6, 3, 1, 'Musik', ''),
(7, 3, 1, 'Bücher', ''),
(8, 3, 1, 'Theater', ''),
(9, 3, 1, 'Kunst', 'Bildende Kunst, Bildhauerei, Performances, Tanz');
