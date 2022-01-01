-- seems like database was missing from the dump
CREATE DATABASE IF NOT EXISTS pokemon_go_together;
USE pokemon_go_together;

-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Machine: sql201.epizy.com
-- Genereertijd: 22 mei 2019 om 05:26
-- Serverversie: 5.6.41-84.1
-- PHP-versie: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `epiz_23515214_GIP13`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activiteit`
--

CREATE TABLE IF NOT EXISTS `activiteit` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Titel` varchar(60) NOT NULL,
  `Omschrijving` text,
  `Land` varchar(60) DEFAULT NULL,
  `Stad` varchar(60) NOT NULL,
  `Postnr` varchar(60) DEFAULT NULL,
  `Straatnaam` varchar(60) DEFAULT NULL,
  `Straatnummer` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`AID`),
  UNIQUE KEY `AID` (`AID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Gegevens worden uitgevoerd voor tabel `activiteit`
--

INSERT INTO `activiteit` (`AID`, `Datum`, `Titel`, `Omschrijving`, `Land`, `Stad`, `Postnr`, `Straatnaam`, `Straatnummer`) VALUES
(1, '2019-03-24 20:10:40', '', 'Dit is de eerste meeting van team rood.', 'Belgie', 'Torhout', '8820', 'Kloosterstraat ', '8'),
(40, '2019-03-25 11:00:20', '', 'TEAM ROOD\r\nWe bespreken onze aanvals strategie op team geel', 'België', 'Torhout', '8820', 'Bruggestraat', '23'),
(39, '2019-03-25 10:30:46', '', 'In deze meeting bespreken we onze strategie.', 'België', 'Torhout', '8820', 'stationstraat', '4'),
(44, '2019-04-28 00:49:31', 'Titel', 'Dit is een omschrijving\r\nokey', 'België', 'Panne', '1547', 'straate', '6'),
(45, '2019-04-29 00:22:07', 'Pokemon Yellow', 'We komen samen om een strategie te bedenken om deze pokemon te vangen', 'België', 'habsbug', '8578', 'straate', '4'),
(55, '2019-05-18 17:09:28', 'KO', 'Luk', 'UK', 'test', '1244', 'James st', '8');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activiteitheeftgebruiker`
--

CREATE TABLE IF NOT EXISTS `activiteitheeftgebruiker` (
  `HID` int(11) NOT NULL AUTO_INCREMENT,
  `AID` int(11) NOT NULL,
  `GIB` int(11) NOT NULL,
  PRIMARY KEY (`HID`),
  UNIQUE KEY `HID` (`HID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `activiteitheeftgebruiker`
--

INSERT INTO `activiteitheeftgebruiker` (`HID`, `AID`, `GIB`) VALUES
(1, 55, 5),
(2, 39, 5),
(3, 44, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE IF NOT EXISTS `gebruiker` (
  `GIB` int(11) NOT NULL AUTO_INCREMENT,
  `Gebruikersnaam` varchar(25) NOT NULL,
  `Paswoord` varchar(60) NOT NULL,
  `AanmaakDatum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Beheerder` tinyint(1) NOT NULL DEFAULT '0',
  `Email` varchar(40) NOT NULL,
  PRIMARY KEY (`GIB`),
  UNIQUE KEY `GIB` (`GIB`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`GIB`, `Gebruikersnaam`, `Paswoord`, `AanmaakDatum`, `Beheerder`, `Email`) VALUES
(1, 'Gebruiker11', '$2a$12$GhR0NtgoGuVH0Vletw3Xd.ga5yQQO22.cPhfcyofCD1P5hhrPufMi', '2019-04-29 05:39:22', 0, 'Mda+jf'),
(2, 'Bob', '$2a$12$PU2FgCh0bsJWBhGC7PMJDODFBk3zNvzJ/miEhUj.yUjhFJ92pOdgO', '2019-05-14 21:30:43', 0, 'bob@b.com'),
(3, 'Leukerd', '$2a$12$JHzHP1nMA5kpsuiCz3dSou2j0lPp94Ny6ofGZDDvtLoPC5QIt7knq', '2019-05-14 21:32:50', 1, 'niet@gm.com'),
(4, 'Tester', '$2a$12$ynWg7wYTAlFxcYYYVIQopefDmlltfM8vIvNLVQRvcZRYm.Fd1kgV6', '2019-05-14 21:41:50', 0, 'test@gmail.com'),
(5, 'admin', '$2a$12$hkKiTZDaSsoIv88BAUOR5.BsEey/b7miAU7ur7tr6ehMSS0HI4ADi', '2019-05-18 17:00:41', 1, 'admin@school.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `melding`
--

CREATE TABLE IF NOT EXISTS `melding` (
  `MID` int(11) NOT NULL AUTO_INCREMENT,
  `GIB` int(11) NOT NULL,
  `Pokemon` varchar(60) DEFAULT NULL,
  `Datum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Land` varchar(60) DEFAULT NULL,
  `Postnr` varchar(20) NOT NULL,
  `Stad` varchar(60) DEFAULT NULL,
  `Straatnaam` varchar(60) DEFAULT NULL,
  `Straatnummer` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`MID`),
  UNIQUE KEY `MID` (`MID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `melding`
--

INSERT INTO `melding` (`MID`, `GIB`, `Pokemon`, `Datum`, `Land`, `Postnr`, `Stad`, `Straatnaam`, `Straatnummer`) VALUES
(1, 0, 'Charizard', '2019-03-24 23:25:42', 'Belgie', '8680', 'Koekelare', 'kerkstraat', '3'),
(2, 0, 'Piplup', '2019-03-24 23:39:22', 'België', '0', '8680', 'Kerkstraat', '4'),
(5, 0, 'Testpokemon', '2019-04-27 23:59:35', 'Nederland', '8818', 'Amsterdam', 'Straat', '14'),
(6, 0, 'sdf', '2019-04-28 00:22:27', 'Nederland', '8578', 'habsbug', 'straate', '8'),
(7, 0, 'NiewPOk', '2019-04-28 00:26:20', 'België', '4879', 'Gistel', 'Vleug', '98'),
(9, 0, 'Charmeleon', '2019-05-12 00:39:45', 'België', '8686', 'Koekelare', 'Kerkstraat', '8'),
(10, 0, 'Piplup', '2019-05-16 14:57:21', 'UK', '12479', 'London', 'Charles street', '87'),
(11, 5, 'Charmeleon', '2019-05-18 17:08:02', 'UK', '1244', 'London', 'James st', '8');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

