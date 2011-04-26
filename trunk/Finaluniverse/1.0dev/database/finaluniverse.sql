-- phpMyAdmin SQL Dump
-- version 3.2.1-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Dezember 2009 um 15:53
-- Server Version: 5.0.67
-- PHP-Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `finaluniverse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_alliance`
--

CREATE TABLE IF NOT EXISTS `ugml_alliance` (
  `id` int(11) NOT NULL auto_increment,
  `ally_name` varchar(32) default '',
  `ally_tag` varchar(8) default '',
  `ally_owner` int(11) NOT NULL default '0',
  `ally_register_time` int(11) NOT NULL default '0',
  `ally_description` text,
  `ally_web` varchar(255) default '',
  `ally_text` text,
  `ally_image` varchar(255) default '',
  `ally_request` text,
  `ally_request_waiting` text,
  `ally_request_notallow` tinyint(4) NOT NULL default '0',
  `ally_owner_range` varchar(32) default '',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL default '0',
  `ally_points` bigint(20) NOT NULL default '0',
  `ally_points_builds` int(11) NOT NULL default '0',
  `ally_points_fleet` int(11) NOT NULL default '0',
  `ally_points_tech` int(11) NOT NULL default '0',
  `ally_points_builds_old` int(11) NOT NULL default '0',
  `ally_points_fleet_old` int(11) NOT NULL default '0',
  `ally_points_tech_old` int(11) NOT NULL default '0',
  `ally_members_points` int(11) NOT NULL default '0',
  `ally_points_fleet2` int(11) NOT NULL default '0',
  `nameLastChanged` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ally_tag` (`ally_tag`),
  KEY `ally_owner` (`ally_owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_alliance_to_alliances`
--

CREATE TABLE IF NOT EXISTS `ugml_alliance_to_alliances` (
  `allianceID1` int(11) NOT NULL,
  `allianceID2` int(11) NOT NULL,
  `interrelationType` tinyint(4) NOT NULL,
  `interrelationState` tinyint(4) NOT NULL,
  `creationTime` int(11) NOT NULL,
  `data` text character set latin1 NOT NULL,
  UNIQUE KEY `allianceID1_2` (`allianceID1`,`allianceID2`,`interrelationType`,`interrelationState`),
  KEY `allianceID1` (`allianceID1`),
  KEY `allianceID2` (`allianceID2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_archive_fleet`
--

CREATE TABLE IF NOT EXISTS `ugml_archive_fleet` (
  `rowID` int(11) NOT NULL auto_increment,
  `fleetID` int(11) NOT NULL,
  `impactTime` int(11) NOT NULL,
  `returnTime` int(11) NOT NULL,
  `startPlanetID` int(11) NOT NULL,
  `targetPlanetID` int(11) NOT NULL,
  `missionID` int(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`rowID`),
  KEY `impactTime` (`impactTime`),
  KEY `returnTime` (`returnTime`),
  KEY `startPlanetID` (`startPlanetID`),
  KEY `targetPlanetID` (`targetPlanetID`),
  KEY `missionID` (`missionID`),
  KEY `fleetID` (`fleetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1020779 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_archive_messages`
--

CREATE TABLE IF NOT EXISTS `ugml_archive_messages` (
  `message_id` int(11) NOT NULL,
  `message_owner` int(11) NOT NULL default '0',
  `message_sender` int(11) NOT NULL default '0',
  `message_time` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `message_from` varchar(255) default NULL,
  `message_subject` varchar(255) default NULL,
  `message_text` text,
  `viewed` tinyint(1) NOT NULL default '0',
  KEY `message_owner` (`message_owner`),
  KEY `viewed` (`viewed`),
  KEY `message_type` (`message_type`),
  KEY `message_time` (`message_time`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_banned`
--

CREATE TABLE IF NOT EXISTS `ugml_banned` (
  `id` int(11) NOT NULL auto_increment,
  `who` varchar(50) NOT NULL,
  `theme` text NOT NULL,
  `who2` varchar(11) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  `longer` int(11) NOT NULL default '0',
  `author` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  KEY `ID` (`id`),
  KEY `who` (`who`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=788 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_bot_detection`
--

CREATE TABLE IF NOT EXISTS `ugml_bot_detection` (
  `detectionID` int(11) NOT NULL auto_increment,
  `detectorID` int(11) NOT NULL,
  `requestID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `planetID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `information` varchar(65480) NOT NULL,
  PRIMARY KEY  (`detectionID`),
  KEY `detectorID` (`detectorID`),
  KEY `requestID` (`requestID`),
  KEY `userID` (`userID`),
  KEY `planetID` (`planetID`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_bot_detector`
--

CREATE TABLE IF NOT EXISTS `ugml_bot_detector` (
  `detectorID` int(11) NOT NULL auto_increment,
  `executionPriority` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `executionProbability` int(11) NOT NULL,
  `className` varchar(255) NOT NULL,
  `locationPattern` varchar(255) NOT NULL,
  PRIMARY KEY  (`detectorID`),
  UNIQUE KEY `className` (`className`,`locationPattern`),
  KEY `locationPattern` (`locationPattern`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_buddy`
--

CREATE TABLE IF NOT EXISTS `ugml_buddy` (
  `id` int(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (`id`),
  KEY `sender` (`sender`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=948 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_combat_report`
--

CREATE TABLE IF NOT EXISTS `ugml_combat_report` (
  `reportID` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `text` mediumtext NOT NULL,
  `oneRound` tinyint(1) NOT NULL,
  PRIMARY KEY  (`reportID`),
  KEY `time_2` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1679223 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_combat_report_user`
--

CREATE TABLE IF NOT EXISTS `ugml_combat_report_user` (
  `reportID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  UNIQUE KEY `reportID` (`reportID`,`userID`),
  KEY `reportID_2` (`reportID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_config`
--

CREATE TABLE IF NOT EXISTS `ugml_config` (
  `config_name` varchar(64) NOT NULL default '',
  `config_value` longtext NOT NULL,
  PRIMARY KEY  (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_dilizium_link`
--

CREATE TABLE IF NOT EXISTS `ugml_dilizium_link` (
  `clickID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `registered` tinyint(11) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  `ipAddress` int(10) unsigned NOT NULL,
  `userAgent` varchar(1023) NOT NULL,
  `cookieData` varchar(1023) NOT NULL,
  PRIMARY KEY  (`clickID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=280 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_espionage_report`
--

CREATE TABLE IF NOT EXISTS `ugml_espionage_report` (
  `reportID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `planetID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `report` text character set latin1 NOT NULL,
  PRIMARY KEY  (`reportID`),
  KEY `planetID` (`planetID`),
  KEY `userID_2` (`userID`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1247648 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_event`
--

CREATE TABLE IF NOT EXISTS `ugml_event` (
  `eventID` int(10) unsigned NOT NULL auto_increment,
  `eventTypeID` int(11) NOT NULL default '1',
  `time` double(13,2) NOT NULL,
  `specificID` int(11) NOT NULL,
  PRIMARY KEY  (`eventID`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=2046651 ;

--
-- Trigger `ugml_event`
--
DROP TRIGGER IF EXISTS `finaluniverse`.`oventEventUpdate`;
DELIMITER //
CREATE TRIGGER `finaluniverse`.`oventEventUpdate` BEFORE UPDATE ON `finaluniverse`.`ugml_event`
 FOR EACH ROW UPDATE ugml_ovent SET `time` = NEW.`time`, relationalID = NEW.specificID WHERE eventID = NEW.eventID
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_event_data`
--

CREATE TABLE IF NOT EXISTS `ugml_event_data` (
  `eventID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`eventID`,`name`),
  UNIQUE KEY `eventID` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_event_exception_log`
--

CREATE TABLE IF NOT EXISTS `ugml_event_exception_log` (
  `exceptionID` int(11) NOT NULL auto_increment,
  `eventID` int(11) NOT NULL,
  `eventTypeID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `exception` longtext NOT NULL,
  PRIMARY KEY  (`exceptionID`),
  UNIQUE KEY `eventID` (`eventID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_event_type`
--

CREATE TABLE IF NOT EXISTS `ugml_event_type` (
  `eventTypeID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `classPath` varchar(255) NOT NULL,
  PRIMARY KEY  (`eventTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_event_type_data`
--

CREATE TABLE IF NOT EXISTS `ugml_event_type_data` (
  `eventTypeID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` varchar(255) NOT NULL,
  PRIMARY KEY  (`eventTypeID`,`name`),
  KEY `eventTypeID` (`eventTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleet`
--

CREATE TABLE IF NOT EXISTS `ugml_fleet` (
  `fleetID` int(11) NOT NULL auto_increment,
  `missionID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `impactEventID` int(11) NOT NULL,
  `wakeUpEventID` int(11) NOT NULL,
  `returnEventID` int(11) NOT NULL,
  `startPlanetID` int(11) NOT NULL,
  `targetPlanetID` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `ofiaraID` int(11) NOT NULL,
  `formationID` int(11) NOT NULL,
  `galaxy` int(11) NOT NULL,
  `system` int(11) NOT NULL,
  `planet` int(11) NOT NULL,
  `metal` bigint(23) NOT NULL,
  `crystal` bigint(23) NOT NULL,
  `deuterium` bigint(23) NOT NULL,
  `startTime` int(11) NOT NULL,
  `impactTime` int(11) NOT NULL,
  `returnTime` int(11) NOT NULL,
  `wakeUpTime` int(11) NOT NULL,
  `spec` varchar(1023) NOT NULL,
  `primaryDestination` int(11) NOT NULL,
  PRIMARY KEY  (`fleetID`),
  KEY `impactEventID` (`impactEventID`),
  KEY `wakeUpEventID` (`wakeUpEventID`),
  KEY `returnEventID` (`returnEventID`),
  KEY `startPlanetID` (`startPlanetID`),
  KEY `targetPlanetID` (`targetPlanetID`),
  KEY `ownerID` (`ownerID`),
  KEY `ofiaraID` (`ofiaraID`),
  KEY `packageID` (`packageID`),
  KEY `formationID` (`formationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1020874 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleets`
--

CREATE TABLE IF NOT EXISTS `ugml_fleets` (
  `fleet_id` int(11) NOT NULL auto_increment,
  `startPlanetID` int(11) NOT NULL,
  `endPlanetID` int(11) NOT NULL,
  `fleet_start_galaxy` int(11) NOT NULL,
  `fleet_start_system` int(11) NOT NULL,
  `fleet_start_planet` int(11) NOT NULL,
  `fleet_start_type` int(11) NOT NULL,
  `fleet_end_galaxy` int(11) NOT NULL,
  `fleet_end_system` int(11) NOT NULL,
  `fleet_end_planet` int(11) NOT NULL,
  `fleet_end_type` int(11) NOT NULL,
  PRIMARY KEY  (`fleet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleet_queue`
--

CREATE TABLE IF NOT EXISTS `ugml_fleet_queue` (
  `fleetQueueID` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `missionID` int(11) NOT NULL,
  `startPlanetID` int(11) NOT NULL,
  `endPlanetID` int(11) NOT NULL,
  `galaxy` int(11) NOT NULL,
  `system` int(11) NOT NULL,
  `planet` int(11) NOT NULL,
  `planet_type` int(11) NOT NULL,
  `planetType` varchar(255) NOT NULL,
  `ships` varchar(1000) NOT NULL,
  `metal` decimal(30,6) NOT NULL,
  `crystal` decimal(30,6) NOT NULL,
  `deuterium` decimal(30,6) NOT NULL,
  `percent` int(11) NOT NULL,
  `speedPercent` decimal(2,1) NOT NULL default '1.0',
  `state` int(11) NOT NULL,
  `primaryDestination` int(11) NOT NULL,
  `backlink` varchar(255) NOT NULL,
  PRIMARY KEY  (`fleetQueueID`),
  KEY `userID` (`userID`)
) ENGINE=MEMORY  DEFAULT CHARSET=latin2 AUTO_INCREMENT=25514 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleet_queue_fleet`
--

CREATE TABLE IF NOT EXISTS `ugml_fleet_queue_fleet` (
  `fleetQueueID` int(11) NOT NULL,
  `specID` int(11) NOT NULL,
  `shipCount` int(11) NOT NULL,
  PRIMARY KEY  (`fleetQueueID`,`specID`),
  KEY `fleetQueueID` (`fleetQueueID`),
  KEY `specID` (`specID`)
) ENGINE=MEMORY DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleet_spec`
--

CREATE TABLE IF NOT EXISTS `ugml_fleet_spec` (
  `fleetID` int(11) NOT NULL,
  `specID` int(11) NOT NULL,
  `shipCount` bigint(23) NOT NULL,
  PRIMARY KEY  (`fleetID`,`specID`),
  KEY `fleetID` (`fleetID`),
  KEY `specID` (`specID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_fleet_start_log`
--

CREATE TABLE IF NOT EXISTS `ugml_fleet_start_log` (
  `fleetID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `fleetOwner` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `userAgent` varchar(200) NOT NULL,
  `resources` varchar(50) NOT NULL,
  `sql` varchar(2000) NOT NULL,
  PRIMARY KEY  (`fleetID`),
  KEY `time` (`time`),
  KEY `fleetOwner` (`fleetOwner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_galactic_jump_queue`
--

CREATE TABLE IF NOT EXISTS `ugml_galactic_jump_queue` (
  `queueID` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `startPlanetID` int(11) NOT NULL,
  `endPlanetID` int(11) NOT NULL,
  `ships` varchar(1000) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY  (`queueID`),
  KEY `userID` (`userID`)
) ENGINE=MEMORY  DEFAULT CHARSET=latin2 AUTO_INCREMENT=563772 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_galaxy`
--

CREATE TABLE IF NOT EXISTS `ugml_galaxy` (
  `galaxy` int(2) NOT NULL default '0',
  `system` int(3) NOT NULL default '0',
  `planet` int(2) NOT NULL default '0',
  `id_planet` int(11) NOT NULL default '0',
  `metal` int(11) NOT NULL default '0',
  `crystal` int(11) NOT NULL default '0',
  `id_luna` int(11) NOT NULL default '0',
  `luna` int(2) NOT NULL default '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`),
  KEY `id_planet` (`id_planet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_log_biggerattack`
--

CREATE TABLE IF NOT EXISTS `ugml_log_biggerattack` (
  `attackID` int(11) NOT NULL auto_increment,
  `fleetID` int(11) NOT NULL,
  `obj` mediumtext NOT NULL,
  PRIMARY KEY  (`attackID`),
  UNIQUE KEY `fleetID` (`fleetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_lunas`
--

CREATE TABLE IF NOT EXISTS `ugml_lunas` (
  `id` int(11) NOT NULL auto_increment,
  `id_luna` int(11) NOT NULL default '0',
  `name` varchar(11) NOT NULL default 'Moon',
  `image` varchar(11) NOT NULL default 'mond',
  `destruyed` int(11) NOT NULL default '0',
  `id_owner` int(11) default NULL,
  `galaxy` int(11) default NULL,
  `system` int(11) default NULL,
  `lunapos` int(11) default NULL,
  `temp_min` int(11) NOT NULL default '0',
  `temp_max` int(11) NOT NULL default '0',
  `diameter` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_messages`
--

CREATE TABLE IF NOT EXISTS `ugml_messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `message_owner` int(11) NOT NULL default '0',
  `message_sender` int(11) NOT NULL default '0',
  `message_time` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `message_from` varchar(255) default NULL,
  `message_subject` varchar(255) default NULL,
  `message_text` text,
  `viewed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`message_id`),
  KEY `message_owner` (`message_owner`),
  KEY `viewed` (`viewed`),
  KEY `message_type` (`message_type`),
  KEY `message_time` (`message_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=5821328 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_mission`
--

CREATE TABLE IF NOT EXISTS `ugml_mission` (
  `missionID` int(11) NOT NULL auto_increment,
  `packageID` int(11) NOT NULL,
  `classPath` varchar(255) NOT NULL,
  PRIMARY KEY  (`missionID`),
  KEY `packageID` (`packageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_mission_route`
--

CREATE TABLE IF NOT EXISTS `ugml_mission_route` (
  `routeID` int(11) NOT NULL auto_increment,
  `missionID` int(11) NOT NULL,
  `startPlanetTypeID` int(11) NOT NULL,
  `endPlanetTypeID` int(11) default NULL,
  `noobProtection` tinyint(1) NOT NULL,
  PRIMARY KEY  (`routeID`),
  KEY `missionID` (`missionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_naval_formation`
--

CREATE TABLE IF NOT EXISTS `ugml_naval_formation` (
  `formationID` int(11) NOT NULL auto_increment,
  `formationName` varchar(20) NOT NULL,
  `leaderFleetID` int(11) NOT NULL,
  `endPlanetID` int(11) NOT NULL,
  `impactTime` int(11) NOT NULL,
  PRIMARY KEY  (`formationID`),
  UNIQUE KEY `leaderFleetID` (`leaderFleetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1311 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_naval_formation_to_fleets`
--

CREATE TABLE IF NOT EXISTS `ugml_naval_formation_to_fleets` (
  `formationID` int(11) NOT NULL,
  `fleetID` varchar(11) NOT NULL,
  PRIMARY KEY  (`formationID`,`fleetID`),
  UNIQUE KEY `fleetID` (`fleetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_naval_formation_to_users`
--

CREATE TABLE IF NOT EXISTS `ugml_naval_formation_to_users` (
  `formationID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `joinTime` int(11) NOT NULL,
  PRIMARY KEY  (`formationID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_notes`
--

CREATE TABLE IF NOT EXISTS `ugml_notes` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) default NULL,
  `time` int(11) default NULL,
  `priority` tinyint(1) default NULL,
  `title` varchar(32) default NULL,
  `text` text,
  PRIMARY KEY  (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=690 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_ovent`
--

CREATE TABLE IF NOT EXISTS `ugml_ovent` (
  `oventID` int(10) unsigned NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `planetID` int(11) NOT NULL,
  `eventID` int(10) unsigned default NULL,
  `oventTypeID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `relationalID` int(11) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`oventID`),
  KEY `userID` (`userID`),
  KEY `planetID` (`planetID`),
  KEY `eventID` (`eventID`),
  KEY `relationalID` (`relationalID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1091978 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_ovent_type`
--

CREATE TABLE IF NOT EXISTS `ugml_ovent_type` (
  `oventTypeID` int(11) NOT NULL auto_increment,
  `packageID` int(11) NOT NULL,
  `classPath` varchar(255) NOT NULL,
  PRIMARY KEY  (`oventTypeID`),
  KEY `packageID` (`packageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_pbu`
--

CREATE TABLE IF NOT EXISTS `ugml_pbu` (
  `pbuID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `serverID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `fileName` varchar(255) NOT NULL,
  PRIMARY KEY  (`pbuID`),
  KEY `userID` (`userID`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_planets`
--

CREATE TABLE IF NOT EXISTS `ugml_planets` (
  `id` int(11) NOT NULL auto_increment,
  `packageID` int(11) NOT NULL default '79',
  `sortID` int(11) NOT NULL,
  `name` varchar(255) default NULL,
  `id_owner` int(11) default NULL,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `last_update` int(11) default NULL,
  `className` varchar(100) NOT NULL default 'UserPlanet',
  `planetTypeID` int(11) NOT NULL,
  `planet_type` int(11) NOT NULL default '1',
  `planetKind` int(11) NOT NULL,
  `destruyed` int(11) NOT NULL default '0',
  `b_building` int(11) NOT NULL default '0',
  `moreBuildings` varchar(1000) NOT NULL,
  `b_building_id` int(11) NOT NULL default '0',
  `b_tech` int(11) NOT NULL default '0',
  `b_tech_id` int(11) NOT NULL default '0',
  `b_hangar` int(11) NOT NULL default '0',
  `b_hangar_id` varchar(1000) NOT NULL,
  `b_hangar_plus` int(11) NOT NULL default '0',
  `image` varchar(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',
  `points` bigint(20) default '0',
  `ranks` bigint(20) default '0',
  `field_current` int(11) NOT NULL default '0',
  `field_max` int(11) NOT NULL default '163',
  `temp_min` int(3) NOT NULL default '-17',
  `temp_max` int(3) NOT NULL default '23',
  `metal` double(30,6) unsigned NOT NULL default '0.000000',
  `metal_perhour` int(11) NOT NULL default '0',
  `metal_max` bigint(20) default '100000',
  `crystal` double(30,6) unsigned NOT NULL default '0.000000',
  `crystal_perhour` int(11) NOT NULL default '0',
  `crystal_max` bigint(20) default '100000',
  `deuterium` double(30,6) unsigned NOT NULL default '0.000000',
  `deuterium_perhour` int(11) NOT NULL default '0',
  `deuterium_max` bigint(20) default '100000',
  `energy` int(11) NOT NULL,
  `energy_used` int(11) NOT NULL default '0',
  `energy_max` int(11) NOT NULL default '0',
  `metal_mine` int(11) NOT NULL default '0',
  `crystal_mine` int(11) NOT NULL default '0',
  `deuterium_sintetizer` int(11) NOT NULL default '0',
  `solar_plant` int(11) NOT NULL default '0',
  `fusion_plant` int(11) NOT NULL default '0',
  `refinery` int(11) NOT NULL,
  `robot_factory` int(11) NOT NULL default '0',
  `nano_factory` int(11) NOT NULL default '0',
  `hangar` int(11) NOT NULL default '0',
  `metal_store` int(11) NOT NULL default '0',
  `crystal_store` int(11) NOT NULL default '0',
  `deuterium_store` int(11) NOT NULL default '0',
  `laboratory` int(11) NOT NULL default '0',
  `terraformer` int(11) NOT NULL default '0',
  `ally_deposit` int(11) NOT NULL default '0',
  `silo` int(11) NOT NULL default '0',
  `lunar_base` int(11) NOT NULL,
  `sensor_phalanx` int(11) NOT NULL,
  `quantic_jump` int(11) NOT NULL,
  `small_ship_cargo` bigint(23) unsigned NOT NULL default '0',
  `big_ship_cargo` bigint(23) unsigned NOT NULL default '0',
  `light_hunter` bigint(23) unsigned NOT NULL default '0',
  `heavy_hunter` bigint(23) unsigned NOT NULL default '0',
  `crusher` bigint(23) unsigned NOT NULL default '0',
  `battle_ship` bigint(23) unsigned NOT NULL default '0',
  `colonizer` bigint(23) unsigned NOT NULL default '0',
  `recycler` bigint(23) unsigned NOT NULL default '0',
  `spy_sonde` bigint(23) unsigned NOT NULL default '0',
  `bomber_ship` bigint(23) unsigned NOT NULL default '0',
  `solar_satelit` bigint(23) unsigned NOT NULL default '0',
  `destructor` bigint(23) unsigned NOT NULL default '0',
  `dearth_star` bigint(23) unsigned NOT NULL default '0',
  `battleship` bigint(23) unsigned NOT NULL default '0',
  `misil_launcher` bigint(23) unsigned NOT NULL default '0',
  `small_laser` bigint(23) unsigned NOT NULL default '0',
  `big_laser` bigint(23) unsigned NOT NULL default '0',
  `gauss_canyon` bigint(23) unsigned NOT NULL default '0',
  `ionic_canyon` bigint(23) unsigned NOT NULL default '0',
  `buster_canyon` bigint(23) unsigned NOT NULL default '0',
  `small_protection_shield` int(11) unsigned NOT NULL default '0',
  `big_protection_shield` int(11) unsigned NOT NULL default '0',
  `interceptor_misil` int(11) NOT NULL default '0',
  `interplanetary_misil` int(11) NOT NULL default '0',
  `metal_mine_porcent` int(11) NOT NULL default '10',
  `crystal_mine_porcent` int(11) NOT NULL default '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL default '10',
  `solar_plant_porcent` int(11) NOT NULL default '10',
  `fusion_plant_porcent` int(11) NOT NULL default '10',
  `solar_satelit_porcent` int(11) NOT NULL default '10',
  `refinery_porcent` int(11) NOT NULL default '10',
  `moon` int(11) NOT NULL default '0',
  `phalanx_views` int(11) NOT NULL default '0',
  `galactic_jump_time` int(11) NOT NULL,
  `pointsPoints` int(11) NOT NULL,
  `fleetPoints` int(11) NOT NULL,
  `buildingPoints` int(11) NOT NULL,
  `defensePoints` int(11) NOT NULL,
  `debug` varchar(100) NOT NULL,
  `lockedFleet` tinyint(1) NOT NULL default '0',
  `siloSlots` int(11) NOT NULL,
  `refineryProduction` varchar(255) NOT NULL,
  `refineryProductionChange` int(11) NOT NULL,
  `activity` int(11) NOT NULL,
  `hostileActivity` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_owner` (`id_owner`),
  KEY `sortID` (`sortID`),
  KEY `galaxy` (`galaxy`,`system`),
  KEY `planet` (`planet`),
  KEY `planet_type` (`planet_type`),
  KEY `planetKind` (`planetKind`),
  KEY `packageID` (`packageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=67399 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_planet_type`
--

CREATE TABLE IF NOT EXISTS `ugml_planet_type` (
  `planetTypeID` int(11) NOT NULL,
  `classPath` varchar(255) NOT NULL,
  `planetKind` int(11) NOT NULL,
  `forceImage` varchar(255) NOT NULL,
  PRIMARY KEY  (`planetTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_request`
--

CREATE TABLE IF NOT EXISTS `ugml_request` (
  `requestID` int(10) unsigned NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `ip` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`requestID`),
  KEY `userID` (`userID`),
  KEY `time` (`time`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=6380730 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_spec`
--

CREATE TABLE IF NOT EXISTS `ugml_spec` (
  `specID` int(11) NOT NULL,
  `specType` int(11) NOT NULL,
  `flag` bit(16) NOT NULL,
  `colName` varchar(255) NOT NULL,
  `specClass` varchar(255) NOT NULL default 'Spec',
  `costsMetal` int(11) NOT NULL,
  `costsCrystal` int(11) NOT NULL,
  `costsDeuterium` int(11) NOT NULL,
  `costsEnergy` int(11) NOT NULL,
  `costsFactor` decimal(4,2) NOT NULL,
  `productionOrder` int(11) NOT NULL,
  `prodMetal` varchar(5000) NOT NULL default 'return 0;',
  `prodCrystal` varchar(5000) NOT NULL default 'return 0;',
  `prodDeuterium` varchar(5000) NOT NULL default 'return 0;',
  `prodEnergy` varchar(5000) NOT NULL default 'return 0;',
  `capacity` int(11) NOT NULL,
  `weapon` int(11) NOT NULL,
  `shield` int(11) NOT NULL,
  PRIMARY KEY  (`specID`),
  UNIQUE KEY `colName` (`colName`),
  KEY `specType` (`specType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_spec_drive`
--

CREATE TABLE IF NOT EXISTS `ugml_spec_drive` (
  `specID` int(11) NOT NULL,
  `drive` int(11) NOT NULL,
  `min` int(11) default NULL,
  `max` int(11) default NULL,
  `speed` int(11) NOT NULL,
  `consumption` int(11) NOT NULL,
  `factor` decimal(2,1) NOT NULL,
  PRIMARY KEY  (`specID`,`drive`),
  KEY `specID` (`specID`),
  KEY `drive` (`drive`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_spec_rapidfire`
--

CREATE TABLE IF NOT EXISTS `ugml_spec_rapidfire` (
  `specID` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `shots` int(11) NOT NULL,
  PRIMARY KEY  (`specID`,`target`),
  KEY `specID` (`specID`),
  KEY `target` (`target`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_spec_requirement`
--

CREATE TABLE IF NOT EXISTS `ugml_spec_requirement` (
  `specID` int(11) NOT NULL,
  `requirement` int(11) NOT NULL,
  `min` int(11) default NULL,
  `max` int(11) default NULL,
  PRIMARY KEY  (`specID`,`requirement`),
  KEY `specID` (`specID`),
  KEY `requirement` (`requirement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_stat`
--

CREATE TABLE IF NOT EXISTS `ugml_stat` (
  `userID` int(11) NOT NULL default '0',
  `allyID` int(11) NOT NULL default '0',
  `rankPoints` int(11) NOT NULL default '0',
  `oldRankPoints` int(11) NOT NULL default '0',
  `rankFleet` int(11) NOT NULL default '0',
  `oldRankFleet` int(11) NOT NULL default '0',
  `rankResearch` int(11) NOT NULL default '0',
  `oldRankResearch` int(11) NOT NULL default '0',
  `allyRankPoints` int(11) NOT NULL default '0',
  `oldAllyRankPoints` int(11) NOT NULL default '0',
  `allyRankFleet` int(11) NOT NULL default '0',
  `oldAllyRankFleet` int(11) NOT NULL default '0',
  `allyRankResearch` int(11) NOT NULL default '0',
  `oldAllyRankResearch` int(11) NOT NULL default '0',
  `points` int(11) NOT NULL default '0',
  `fleet` int(11) NOT NULL default '0',
  `research` int(11) NOT NULL default '0',
  `pointsTMP` float(30,6) NOT NULL default '0.000000',
  `fleetTMP` float(30,6) NOT NULL default '0.000000',
  `researchTMP` float(30,6) NOT NULL default '0.000000',
  PRIMARY KEY  (`userID`),
  KEY `rankPoints` (`rankPoints`),
  KEY `allyID` (`allyID`),
  KEY `rankFleet` (`rankFleet`),
  KEY `rankResearch` (`rankResearch`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_stat_entry`
--

CREATE TABLE IF NOT EXISTS `ugml_stat_entry` (
  `statTypeID` int(11) NOT NULL,
  `relationalID` int(11) NOT NULL,
  `rank` mediumint(8) NOT NULL,
  `change` mediumint(8) NOT NULL,
  `points` bigint(23) NOT NULL,
  PRIMARY KEY  (`statTypeID`,`relationalID`),
  KEY `statTypeID` (`statTypeID`),
  KEY `rank` (`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_stat_entry_archive`
--

CREATE TABLE IF NOT EXISTS `ugml_stat_entry_archive` (
  `statTypeID` int(11) NOT NULL,
  `relationalID` int(11) NOT NULL,
  `rank` mediumint(8) NOT NULL,
  `change` mediumint(8) NOT NULL,
  `points` bigint(23) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`statTypeID`,`relationalID`,`time`),
  KEY `relationalID` (`relationalID`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_stat_type`
--

CREATE TABLE IF NOT EXISTS `ugml_stat_type` (
  `statTypeID` int(11) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` tinyint(1) unsigned NOT NULL,
  `selectable` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`statTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_tmp_fleets`
--

CREATE TABLE IF NOT EXISTS `ugml_tmp_fleets` (
  `fleet_id` int(11) NOT NULL auto_increment,
  `fleet_owner` int(11) NOT NULL default '0',
  `fleet_mission` int(11) NOT NULL default '0',
  `fleet_amount` int(11) NOT NULL default '0',
  `fleet_array` varchar(2000) default NULL,
  `startPlanetID` int(11) NOT NULL,
  `endPlanetID` int(11) NOT NULL,
  `className` varchar(64) NOT NULL,
  `fleet_start_time` int(11) NOT NULL default '0',
  `fleet_start_galaxy` int(11) NOT NULL default '0',
  `fleet_start_system` int(11) NOT NULL default '0',
  `fleet_start_planet` int(11) NOT NULL default '0',
  `fleet_start_type` int(11) NOT NULL default '0',
  `fleet_end_time` int(11) NOT NULL default '0',
  `fleet_end_galaxy` int(11) NOT NULL default '0',
  `fleet_end_system` int(11) NOT NULL default '0',
  `fleet_end_planet` int(11) NOT NULL default '0',
  `fleet_end_type` int(11) NOT NULL default '0',
  `fleet_resource_metal` int(11) NOT NULL default '0',
  `fleet_resource_crystal` int(11) NOT NULL default '0',
  `fleet_resource_deuterium` int(11) NOT NULL default '0',
  `fleet_ofiara` int(11) NOT NULL default '0',
  `fleet_mess` int(11) NOT NULL default '0',
  `ip` varchar(100) NOT NULL,
  `pointsPoints` int(11) NOT NULL,
  `fleetPoints` int(11) NOT NULL,
  `primaryDestination` int(11) NOT NULL,
  `standByTime` int(11) NOT NULL,
  PRIMARY KEY  (`fleet_id`),
  KEY `fleet_start` (`fleet_start_galaxy`,`fleet_start_system`,`fleet_start_planet`,`fleet_start_type`),
  KEY `fleet_end` (`fleet_end_galaxy`,`fleet_end_system`,`fleet_end_planet`,`fleet_end_type`),
  KEY `fleet_owner` (`fleet_owner`),
  KEY `endPlanetID` (`endPlanetID`),
  KEY `startPlanetID` (`startPlanetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_tmp_planets`
--

CREATE TABLE IF NOT EXISTS `ugml_tmp_planets` (
  `id` int(11) NOT NULL auto_increment,
  `packageID` int(11) NOT NULL,
  `sortID` int(11) NOT NULL,
  `name` varchar(255) default NULL,
  `id_owner` int(11) default NULL,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `last_update` int(11) default NULL,
  `className` varchar(100) NOT NULL default 'UserPlanet',
  `planetTypeID` int(11) NOT NULL,
  `planet_type` int(11) NOT NULL default '1',
  `planetKind` int(11) NOT NULL,
  `destruyed` int(11) NOT NULL default '0',
  `b_building` int(11) NOT NULL default '0',
  `moreBuildings` varchar(1000) character set utf8 NOT NULL,
  `b_building_id` int(11) NOT NULL default '0',
  `b_tech` int(11) NOT NULL default '0',
  `b_tech_id` int(11) NOT NULL default '0',
  `b_hangar` int(11) NOT NULL default '0',
  `b_hangar_id` varchar(1000) NOT NULL,
  `b_hangar_plus` int(11) NOT NULL default '0',
  `image` varchar(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',
  `points` bigint(20) default '0',
  `ranks` bigint(20) default '0',
  `field_current` int(11) NOT NULL default '0',
  `field_max` int(11) NOT NULL default '163',
  `temp_min` int(3) NOT NULL default '-17',
  `temp_max` int(3) NOT NULL default '23',
  `metal` double(16,6) NOT NULL default '0.000000',
  `metal_perhour` int(11) NOT NULL default '0',
  `metal_max` bigint(20) default '100000',
  `crystal` double(16,6) NOT NULL default '0.000000',
  `crystal_perhour` int(11) NOT NULL default '0',
  `crystal_max` bigint(20) default '100000',
  `deuterium` double(16,6) NOT NULL default '0.000000',
  `deuterium_perhour` int(11) NOT NULL default '0',
  `deuterium_max` bigint(20) default '100000',
  `energy_used` int(11) NOT NULL default '0',
  `energy_max` int(11) NOT NULL default '0',
  `metal_mine` int(11) NOT NULL default '0',
  `crystal_mine` int(11) NOT NULL default '0',
  `deuterium_sintetizer` int(11) NOT NULL default '0',
  `solar_plant` int(11) NOT NULL default '0',
  `fusion_plant` int(11) NOT NULL default '0',
  `robot_factory` int(11) NOT NULL default '0',
  `nano_factory` int(11) NOT NULL default '0',
  `hangar` int(11) NOT NULL default '0',
  `metal_store` int(11) NOT NULL default '0',
  `crystal_store` int(11) NOT NULL default '0',
  `deuterium_store` int(11) NOT NULL default '0',
  `laboratory` int(11) NOT NULL default '0',
  `terraformer` int(11) NOT NULL default '0',
  `ally_deposit` int(11) NOT NULL default '0',
  `silo` int(11) NOT NULL default '0',
  `lunar_base` int(11) NOT NULL,
  `sensor_phalanx` int(11) NOT NULL,
  `quantic_jump` int(11) NOT NULL,
  `small_ship_cargo` int(11) NOT NULL default '0',
  `big_ship_cargo` int(11) NOT NULL default '0',
  `light_hunter` int(11) NOT NULL default '0',
  `heavy_hunter` int(11) NOT NULL default '0',
  `crusher` int(11) NOT NULL default '0',
  `battle_ship` int(11) NOT NULL default '0',
  `colonizer` int(11) NOT NULL default '0',
  `recycler` int(11) NOT NULL default '0',
  `spy_sonde` int(11) NOT NULL default '0',
  `bomber_ship` int(11) NOT NULL default '0',
  `solar_satelit` int(11) NOT NULL default '0',
  `destructor` int(11) NOT NULL default '0',
  `dearth_star` int(11) NOT NULL default '0',
  `battleship` int(11) NOT NULL default '0',
  `misil_launcher` int(11) NOT NULL default '0',
  `small_laser` int(11) NOT NULL default '0',
  `big_laser` int(11) NOT NULL default '0',
  `gauss_canyon` int(11) NOT NULL default '0',
  `ionic_canyon` int(11) NOT NULL default '0',
  `buster_canyon` int(11) NOT NULL default '0',
  `small_protection_shield` int(11) NOT NULL default '0',
  `big_protection_shield` int(11) NOT NULL default '0',
  `interceptor_misil` int(11) NOT NULL default '0',
  `interplanetary_misil` int(11) NOT NULL default '0',
  `metal_mine_porcent` int(11) NOT NULL default '10',
  `crystal_mine_porcent` int(11) NOT NULL default '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL default '10',
  `solar_plant_porcent` int(11) NOT NULL default '10',
  `fusion_plant_porcent` int(11) NOT NULL default '10',
  `solar_satelit_porcent` int(11) NOT NULL default '10',
  `moon` int(11) NOT NULL default '0',
  `phalanx_views` int(11) NOT NULL default '0',
  `galactic_jump_time` int(11) NOT NULL,
  `pointsPoints` int(11) NOT NULL,
  `fleetPoints` int(11) NOT NULL,
  `buildingPoints` int(11) NOT NULL,
  `defensePoints` int(11) NOT NULL,
  `debug` varchar(100) NOT NULL,
  `lockedFleet` tinyint(1) NOT NULL default '0',
  `siloSlots` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_owner` (`id_owner`),
  KEY `position` (`galaxy`,`system`,`planet`,`planet_type`),
  KEY `sortID` (`sortID`),
  KEY `planetTypeID` (`planetTypeID`),
  KEY `planetKind` (`planetKind`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_tmp_request`
--

CREATE TABLE IF NOT EXISTS `ugml_tmp_request` (
  `requestID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `site` varchar(50) NOT NULL,
  `args` varchar(1000) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `userAgent` varchar(200) NOT NULL,
  PRIMARY KEY  (`requestID`),
  KEY `userID` (`userID`),
  KEY `site` (`site`),
  KEY `time` (`time`),
  KEY `ip` (`ip`),
  KEY `userAgent` (`userAgent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_tmp_users`
--

CREATE TABLE IF NOT EXISTS `ugml_tmp_users` (
  `id` int(11) NOT NULL default '0',
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_2` varchar(64) NOT NULL default '',
  `dilizium` int(11) NOT NULL default '0',
  `diliziumFeatures` varchar(1000) NOT NULL,
  `lostDilizium` int(11) NOT NULL default '0',
  `lang` varchar(8) NOT NULL default 'es',
  `authlevel` tinyint(4) NOT NULL default '0',
  `banned` tinyint(1) NOT NULL default '0',
  `sex` char(1) default NULL,
  `avatar` varchar(255) NOT NULL default '',
  `id_planet` int(11) NOT NULL default '0',
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `current_planet` int(11) NOT NULL default '0',
  `planetClassName` varchar(100) NOT NULL default 'UserPlanet',
  `user_lastip` varchar(16) NOT NULL default '',
  `register_time` int(11) NOT NULL default '0',
  `onlinetime` int(11) NOT NULL default '0',
  `dpath` varchar(255) NOT NULL default '',
  `design` tinyint(4) NOT NULL default '1',
  `noipcheck` tinyint(4) NOT NULL default '1',
  `spio_anz` tinyint(4) NOT NULL default '1',
  `settings_tooltiptime` tinyint(4) NOT NULL default '5',
  `settings_fleetactions` tinyint(4) NOT NULL default '0',
  `settings_allylogo` tinyint(4) NOT NULL default '0',
  `settings_esp` tinyint(4) NOT NULL default '1',
  `settings_wri` tinyint(4) NOT NULL default '1',
  `settings_bud` tinyint(4) NOT NULL default '1',
  `settings_mis` tinyint(4) NOT NULL default '1',
  `settings_rep` tinyint(4) NOT NULL default '0',
  `urlaubs_modus` int(11) NOT NULL default '0',
  `db_deaktjava` tinyint(4) NOT NULL default '0',
  `points_builds` bigint(20) NOT NULL default '0',
  `points_tech` bigint(20) NOT NULL default '0',
  `points_fleet` bigint(20) NOT NULL default '0',
  `points_builds2` bigint(20) NOT NULL default '0',
  `points_tech2` bigint(20) NOT NULL default '0',
  `points_fleet2` bigint(20) NOT NULL default '0',
  `points_builds_old` bigint(20) NOT NULL default '0',
  `points_tech_old` bigint(20) NOT NULL default '0',
  `points_fleet_old` bigint(20) NOT NULL default '0',
  `points_points` bigint(20) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `new_message` int(11) NOT NULL default '0',
  `fleet_shortcut` varchar(1000) default NULL,
  `b_tech_planet` int(11) NOT NULL default '0',
  `spy_tech` int(11) NOT NULL default '0',
  `computer_tech` int(11) NOT NULL default '0',
  `military_tech` int(11) NOT NULL default '0',
  `defence_tech` int(11) NOT NULL default '0',
  `shield_tech` int(11) NOT NULL default '0',
  `energy_tech` int(11) NOT NULL default '0',
  `hyperspace_tech` int(11) NOT NULL default '0',
  `combustion_tech` int(11) NOT NULL default '0',
  `impulse_motor_tech` int(11) NOT NULL default '0',
  `hyperspace_motor_tech` int(11) NOT NULL default '0',
  `laser_tech` int(11) NOT NULL default '0',
  `ionic_tech` int(11) NOT NULL default '0',
  `buster_tech` int(11) NOT NULL default '0',
  `intergalactic_tech` int(11) NOT NULL default '0',
  `graviton_tech` int(11) NOT NULL default '0',
  `ally_id` int(11) NOT NULL default '0',
  `ally_name` varchar(32) default '',
  `ally_request` int(11) NOT NULL default '0',
  `ally_rank_id` int(11) NOT NULL default '0',
  `ally_request_text` varchar(1000) default NULL,
  `ally_register_time` int(11) NOT NULL default '0',
  `current_luna` int(11) NOT NULL default '0',
  `kolorminus` varchar(11) NOT NULL default 'red',
  `kolorplus` varchar(11) NOT NULL default '#00FF00',
  `kolorpoziom` varchar(11) NOT NULL default 'yellow',
  `rank_old` int(11) NOT NULL default '0',
  `lastLoginTime` int(11) NOT NULL,
  `pointsPoints` int(11) NOT NULL,
  `researchPoints` int(11) NOT NULL,
  `debug` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ally_id` (`ally_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ugml_users`
--

CREATE TABLE IF NOT EXISTS `ugml_users` (
  `id` int(11) NOT NULL default '0',
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_2` varchar(64) NOT NULL default '',
  `dilizium` int(11) NOT NULL default '0',
  `diliziumFeatures` varchar(1000) NOT NULL,
  `lostDilizium` int(11) NOT NULL default '0',
  `lang` varchar(8) NOT NULL default 'es',
  `authlevel` tinyint(4) NOT NULL default '0',
  `banned` tinyint(1) NOT NULL default '0',
  `sex` char(1) default NULL,
  `avatar` varchar(255) NOT NULL default '',
  `id_planet` int(11) NOT NULL default '0',
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `current_planet` int(11) NOT NULL default '0',
  `planetClassName` varchar(100) NOT NULL default 'UserPlanet',
  `user_lastip` varchar(16) NOT NULL default '',
  `register_time` int(11) NOT NULL default '0',
  `onlinetime` int(11) NOT NULL default '0',
  `dpath` varchar(255) NOT NULL default '',
  `design` tinyint(4) NOT NULL default '1',
  `noipcheck` tinyint(4) NOT NULL default '1',
  `spio_anz` tinyint(4) NOT NULL default '1',
  `settings_tooltiptime` tinyint(4) NOT NULL default '5',
  `settings_fleetactions` tinyint(4) NOT NULL default '0',
  `settings_allylogo` tinyint(4) NOT NULL default '0',
  `settings_esp` tinyint(4) NOT NULL default '1',
  `settings_wri` tinyint(4) NOT NULL default '1',
  `settings_bud` tinyint(4) NOT NULL default '1',
  `settings_mis` tinyint(4) NOT NULL default '1',
  `settings_rep` tinyint(4) NOT NULL default '0',
  `urlaubs_modus` int(11) NOT NULL default '0',
  `db_deaktjava` tinyint(4) NOT NULL default '0',
  `points_builds` bigint(20) NOT NULL default '0',
  `points_tech` bigint(20) NOT NULL default '0',
  `points_fleet` bigint(20) NOT NULL default '0',
  `points_builds2` bigint(20) NOT NULL default '0',
  `points_tech2` bigint(20) NOT NULL default '0',
  `points_fleet2` bigint(20) NOT NULL default '0',
  `points_builds_old` bigint(20) NOT NULL default '0',
  `points_tech_old` bigint(20) NOT NULL default '0',
  `points_fleet_old` bigint(20) NOT NULL default '0',
  `points_points` bigint(20) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `new_message` int(11) NOT NULL default '0',
  `fleet_shortcut` varchar(1000) default NULL,
  `b_tech_planet` int(11) NOT NULL default '0',
  `spy_tech` int(11) NOT NULL default '0',
  `computer_tech` int(11) NOT NULL default '0',
  `military_tech` int(11) NOT NULL default '0',
  `defence_tech` int(11) NOT NULL default '0',
  `shield_tech` int(11) NOT NULL default '0',
  `energy_tech` int(11) NOT NULL default '0',
  `hyperspace_tech` int(11) NOT NULL default '0',
  `combustion_tech` int(11) NOT NULL default '0',
  `impulse_motor_tech` int(11) NOT NULL default '0',
  `hyperspace_motor_tech` int(11) NOT NULL default '0',
  `laser_tech` int(11) NOT NULL default '0',
  `ionic_tech` int(11) NOT NULL default '0',
  `buster_tech` int(11) NOT NULL default '0',
  `intergalactic_tech` int(11) NOT NULL default '0',
  `graviton_tech` int(11) NOT NULL default '0',
  `ally_id` int(11) NOT NULL default '0',
  `ally_name` varchar(32) default '',
  `ally_request` int(11) NOT NULL default '0',
  `ally_rank_id` int(11) NOT NULL default '0',
  `ally_request_text` varchar(1000) default NULL,
  `ally_register_time` int(11) NOT NULL default '0',
  `current_luna` int(11) NOT NULL default '0',
  `kolorminus` varchar(11) NOT NULL default 'red',
  `kolorplus` varchar(11) NOT NULL default '#00FF00',
  `kolorpoziom` varchar(11) NOT NULL default 'yellow',
  `rank_old` int(11) NOT NULL default '0',
  `lastLoginTime` int(11) NOT NULL,
  `pointsPoints` int(11) NOT NULL,
  `lastClickAnalyzationMin` int(11) NOT NULL,
  `researchPoints` int(11) NOT NULL,
  `debug` int(11) NOT NULL,
  `sim_uses` int(11) NOT NULL,
  `klicks` int(11) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ally_id` (`ally_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ugml_ovent`
--
ALTER TABLE `ugml_ovent`
  ADD CONSTRAINT `ugml_ovent_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `ugml_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ugml_ovent_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `ugml_event` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE;

  -- phpMyAdmin SQL Dump
-- version 3.2.1-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Dezember 2009 um 15:54
-- Server Version: 5.0.67
-- PHP-Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `finaluniverse`
--

--
-- Daten fÃ¼r Tabelle `ugml_config`
--

INSERT INTO `ugml_config` (`config_name`, `config_value`) VALUES
('allow_invetigate_while_lab_is_update', '0'),
('biggest_debris', '1'),
('COOKIE_NAME', 'xBeliebigesGame'),
('copyright', '(c) by xBeliebigesGame'),
('crystal_basic_income', '40'),
('debug', '0'),
('deuterium_basic_income', '0'),
('energy_basic_income', '0'),
('eventhandler', '0'),
('fleet_speed', '10000'),
('flota_na_zlom', '30'),
('game_name', '...'),
('game_speed', '10000'),
('id_g', '1'),
('id_p', '1'),
('id_s', '1'),
('initial_fields', '400'),
('lastAttackStatClean7', '1259866802'),
('lastehstart', '2009-09-04 12:51:37'),
('max_position', '15'),
('metal_basic_income', '80'),
('noobProtection', '1'),
('obrona_na_zlom', '5'),
('resource_multiplier', '8'),
('stats', 'Sat Oct 20 22:53:36 CEST 2007'),
('stats_new', '2009-01-31 16:00:01'),
('users_amount', '0');

--
-- Daten fÃ¼r Tabelle `ugml_event_type`
--

INSERT INTO `ugml_event_type` (`eventTypeID`, `packageID`, `classPath`) VALUES
(1, 79, 'lib/data/fleet/Fleet.class.php');

--
-- Daten fÃ¼r Tabelle `ugml_event_type_data`
--

INSERT INTO `ugml_event_type_data` (`eventTypeID`, `name`, `default`) VALUES
(1, 'state', '0');

--
-- Daten fÃ¼r Tabelle `ugml_mission`
--

INSERT INTO `ugml_mission` (`missionID`, `packageID`, `classPath`) VALUES
(1, 79, 'lib/data/fleet/AttackFleet.class.php'),
(3, 79, 'lib/data/fleet/TransportFleet.class.php'),
(4, 79, 'lib/data/fleet/DeployFleet.class.php'),
(5, 79, 'lib/data/fleet/DestroyFleet.class.php'),
(6, 79, 'lib/data/fleet/EspionageFleet.class.php'),
(8, 79, 'lib/data/fleet/HarvestFleet.class.php'),
(9, 79, 'lib/data/fleet/ColonizeFleet.class.php'),
(11, 79, 'lib/data/fleet/NavalFormationAttackFleet.class.php'),
(12, 79, 'lib/data/fleet/StandByFleet.class.php'),
(20, 79, 'lib/data/fleet/MissileAttackFleet.class.php');

--
-- Daten fÃ¼r Tabelle `ugml_mission_route`
--

INSERT INTO `ugml_mission_route` (`routeID`, `missionID`, `startPlanetTypeID`, `endPlanetTypeID`, `noobProtection`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 3, 1),
(3, 1, 3, 1, 1),
(4, 1, 3, 3, 1),
(5, 3, 1, 1, 0),
(6, 3, 1, 3, 0),
(7, 3, 3, 1, 0),
(8, 3, 3, 3, 0),
(9, 4, 1, 1, 0),
(10, 4, 1, 3, 0),
(11, 4, 3, 1, 0),
(12, 4, 3, 3, 0),
(13, 5, 1, 3, 1),
(14, 5, 3, 3, 1),
(15, 6, 1, 1, 1),
(16, 6, 1, 3, 1),
(17, 6, 3, 1, 1),
(18, 6, 3, 3, 1),
(19, 8, 1, 2, 0),
(20, 8, 3, 2, 0),
(21, 9, 1, NULL, 0),
(22, 9, 3, NULL, 0),
(23, 11, 1, 1, 1),
(24, 11, 1, 3, 1),
(25, 11, 3, 1, 1),
(26, 11, 3, 3, 1),
(27, 12, 1, 1, 1),
(28, 12, 3, 1, 1),
(29, 20, 1, 1, 1),
(30, 20, 1, 3, 1),
(31, 12, 1, 3, 1),
(32, 12, 3, 3, 1);

--
-- Daten fÃ¼r Tabelle `ugml_ovent_type`
--

INSERT INTO `ugml_ovent_type` (`oventTypeID`, `packageID`, `classPath`) VALUES
(1, 79, 'lib/data/ovent/FleetOvent.class.php');

--
-- Daten fÃ¼r Tabelle `ugml_planet_type`
--

INSERT INTO `ugml_planet_type` (`planetTypeID`, `classPath`, `planetKind`, `forceImage`) VALUES
(1, 'UserPlanet', 1, ''),
(2, 'Debris', 2, 'debris'),
(3, 'UserMoon', 3, 'mond');

--
-- Daten fÃ¼r Tabelle `ugml_spec`
--

INSERT INTO `ugml_spec` (`specID`, `specType`, `flag`, `colName`, `specClass`, `costsMetal`, `costsCrystal`, `costsDeuterium`, `costsEnergy`, `costsFactor`, `productionOrder`, `prodMetal`, `prodCrystal`, `prodDeuterium`, `prodEnergy`, `capacity`, `weapon`, `shield`) VALUES
(1, 1, '', 'metal_mine', 'MetalMineSpec', 60, 15, 0, 0, 1.50, 5, 'return (30 * $this->metal_mine *  pow(1.1, $this->metal_mine)) * (0.1 * $this->metal_mine_porcent);', 'return 0;', 'return 0;', 'return -(10 * $this->metal_mine * pow(1.1, $this->metal_mine)) * 0.1 * $this->metal_mine_porcent;', 0, 0, 0),
(2, 1, '', 'crystal_mine', 'CrystalMineSpec', 48, 24, 0, 0, 1.60, 10, 'return 0;', 'return (20 * $this->crystal_mine *  pow(1.1, $this->crystal_mine)) * (0.1 * $this->crystal_mtal_mine)) * (0.1 * $this->metal_mine_porcent);ine_porcent);', 'return 0;', 'return -(10 * $this->crystal_mine * pow(1.1, $this->crystal_mine)) * 0.1 * $this->crystal_mine_porcent;', 0, 0, 0),
(3, 1, '', 'deuterium_sintetizer', 'DeuteriumSynthesizerSpec', 225, 75, 0, 0, 1.50, 15, 'return 0;', 'return 0;', 'return ((10 * $this->deuterium_sintetizer * pow(1.1, $this->deuterium_sintetizer)) * (-0.002 * $this->temp_max + 1.28)) * 0.1 * $this->deuterium_sintetizer_porcent;', 'return -(20 * $this->deuterium_sintetizer * pow(1.1, $this->deuterium_sintetizer)) * 0.1 * $this->deuterium_sintetizer_porcent;', 0, 0, 0),
(4, 1, '', 'solar_plant', 'SolarPlantSpec', 75, 30, 0, 0, 1.50, 20, 'return 0;', 'return 0;', 'return 0;', 'return (20 * $this->solar_plant * pow(1.1, $this->solar_plant)) * (0.1 * $this->solar_plant_procent);', 0, 0, 0),
(12, 1, '', 'fusion_plant', 'FusionPlantSpec', 900, 360, 180, 0, 1.80, 25, 'return 0;', 'return 0;', 'return -(10 * $this->fusion_plant * pow(1.1, $this->fusion_plant))* (0.1 * $this->fusion_plant_porcent);', 'return (50 * $this->fusion_plant * pow(1.1, $this->fusion_plant))* (0.1 * $this->fusion_plant_porcent);', 0, 0, 0),
(13, 0, '', 'refinery', 'RefinerySpec', 75000, 50000, 30000, 0, 1.70, 35, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(14, 1, '\0', 'robot_factory', 'Spec', 400, 120, 200, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(15, 1, '\0', 'nano_factory', 'Spec', 1000000, 500000, 100000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(21, 1, '\0', 'hangar', 'Spec', 400, 200, 100, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(22, 1, '\0', 'metal_store', 'Spec', 2000, 0, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(23, 1, '\0', 'crystal_store', 'Spec', 2000, 1000, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(24, 1, '\0', 'deuterium_store', 'Spec', 2000, 2000, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(31, 1, '\0', 'laboratory', 'Spec', 200, 400, 200, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(33, 1, '\0', 'terraformer', 'Spec', 0, 50000, 100000, 1000, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(34, 1, '\0', 'ally_deposit', 'Spec', 20000, 40000, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(41, 1, '\0', 'lunar_base', 'Spec', 20000, 40000, 20000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(42, 1, '\0', 'sensor_phalanx', 'Spec', 20000, 40000, 20000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(43, 1, '\0', 'quantic_jump', 'Spec', 15000000, 2500000, 2000000, 0, 1.20, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(44, 1, '\0', 'silo', 'Spec', 20000, 20000, 1000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(106, 2, '\0', 'spy_tech', 'Spec', 200, 1000, 200, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(108, 2, '\0', 'computer_tech', 'Spec', 0, 400, 600, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(109, 2, '\0', 'military_tech', 'Spec', 800, 200, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(110, 2, '\0', 'defence_tech', 'Spec', 200, 600, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(111, 2, '\0', 'shield_tech', 'Spec', 1000, 0, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(113, 2, '\0', 'energy_tech', 'Spec', 0, 800, 400, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(114, 2, '\0', 'hyperspace_tech', 'Spec', 0, 4000, 2000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(115, 2, '\0', 'combustion_tech', 'Spec', 400, 0, 600, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(117, 2, '\0', 'impulse_motor_tech', 'Spec', 2000, 4000, 600, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(118, 2, '\0', 'hyperspace_motor_tech', 'Spec', 10000, 20000, 6000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(120, 2, '\0', 'laser_tech', 'Spec', 200, 100, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(121, 2, '\0', 'ionic_tech', 'Spec', 1000, 300, 0, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(122, 2, '\0', 'buster_tech', 'Spec', 2000, 4000, 1000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(123, 2, '\0', 'intergalactic_tech', 'Spec', 240000, 400000, 160000, 0, 2.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(199, 2, '\0', 'graviton_tech', 'Spec', 0, 0, 0, 300000, 3.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(202, 3, '\0', 'small_ship_cargo', 'FleetSpec', 2000, 2000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 5000, 5, 10),
(203, 3, '\0', 'big_ship_cargo', 'FleetSpec', 6000, 6000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 25000, 5, 25),
(204, 3, '\0', 'light_hunter', 'FleetSpec', 3000, 1000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 50, 50, 10),
(205, 3, '\0', 'heavy_hunter', 'FleetSpec', 6000, 4000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 100, 150, 25),
(206, 3, '\0', 'crusher', 'FleetSpec', 20000, 7000, 2000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 800, 400, 20),
(207, 3, '\0', 'battle_ship', 'FleetSpec', 45000, 15000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 1500, 1000, 200),
(208, 3, '\0', 'colonizer', 'FleetSpec', 10000, 20000, 10000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 7500, 50, 100),
(209, 3, '\0', 'recycler', 'FleetSpec', 10000, 6000, 2000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 20000, 1, 10),
(210, 3, '\0', 'spy_sonde', 'FleetSpec', 0, 1000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 5, 0, 0),
(211, 3, '\0', 'bomber_ship', 'FleetSpec', 50000, 25000, 15000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 500, 1000, 500),
(212, 3, '', 'solar_satelit', 'SolarSatelliteSpec', 0, 2000, 500, 0, 1.00, 30, 'return 0;', 'return 0;', 'return 0;', 'return (($this->temp_max / 4) + 20) * $this->solar_satelit * 0.1 * $this->solar_satelit_porcent;', 0, 1, 10),
(213, 3, '\0', 'destructor', 'FleetSpec', 60000, 50000, 15000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 2000, 2000, 500),
(214, 3, '\0', 'dearth_star', 'FleetSpec', 5000000, 4000000, 1000000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 1000000, 200000, 50000),
(215, 3, '\0', 'battleship', 'FleetSpec', 30000, 40000, 15000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 750, 700, 400),
(401, 4, '\0', 'misil_launcher', 'FleetSpec', 2000, 0, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 80, 20),
(402, 4, '\0', 'small_laser', 'FleetSpec', 1500, 500, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 100, 25),
(403, 4, '\0', 'big_laser', 'FleetSpec', 6000, 2000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 250, 100),
(404, 4, '\0', 'gauss_canyon', 'FleetSpec', 20000, 15000, 2000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 1100, 200),
(405, 4, '\0', 'ionic_canyon', 'FleetSpec', 2000, 6000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 150, 500),
(406, 4, '\0', 'buster_canyon', 'FleetSpec', 50000, 50000, 30000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 3000, 300),
(407, 4, '\0', 'small_protection_shield', 'FleetSpec', 10000, 10000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 1, 2000),
(408, 4, '\0', 'big_protection_shield', 'FleetSpec', 50000, 50000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 1, 10000),
(502, 52, '\0p', 'interceptor_misil', 'FleetSpec', 8000, 2000, 0, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 0, 0),
(503, 51, '\0°', 'interplanetary_misil', 'FleetSpec', 12500, 2500, 10000, 0, 1.00, 0, 'return 0;', 'return 0;', 'return 0;', 'return 0;', 0, 12000, 0);

--
-- Daten fÃ¼r Tabelle `ugml_spec_drive`
--

INSERT INTO `ugml_spec_drive` (`specID`, `drive`, `min`, `max`, `speed`, `consumption`, `factor`) VALUES
(202, 115, 2, NULL, 5000, 20, 0.1),
(202, 117, 5, NULL, 10000, 40, 0.2),
(203, 115, 6, NULL, 7500, 50, 0.1),
(204, 115, 1, NULL, 12500, 20, 0.1),
(205, 117, 2, NULL, 10000, 75, 0.2),
(206, 117, 4, NULL, 15000, 300, 0.2),
(207, 118, 4, NULL, 10000, 500, 0.3),
(208, 117, 3, NULL, 2500, 1000, 0.2),
(209, 115, 6, NULL, 2000, 300, 0.1),
(210, 115, 3, NULL, 100000000, 1, 0.1),
(211, 117, 6, NULL, 4000, 1000, 0.2),
(211, 118, 8, NULL, 5000, 1000, 0.3),
(213, 118, 6, NULL, 5000, 1000, 0.3),
(214, 118, 7, NULL, 100, 1, 0.3),
(215, 118, 5, NULL, 10000, 250, 0.3);

--
-- Daten fÃ¼r Tabelle `ugml_spec_rapidfire`
--

INSERT INTO `ugml_spec_rapidfire` (`specID`, `target`, `shots`) VALUES
(202, 210, 5),
(202, 212, 5),
(203, 210, 5),
(203, 212, 5),
(204, 210, 5),
(204, 212, 5),
(205, 202, 3),
(205, 210, 5),
(205, 212, 5),
(206, 204, 6),
(206, 210, 5),
(206, 212, 5),
(206, 401, 10),
(207, 210, 5),
(207, 212, 5),
(208, 210, 5),
(208, 212, 5),
(209, 210, 5),
(209, 212, 5),
(211, 210, 5),
(211, 212, 5),
(211, 401, 20),
(211, 402, 20),
(211, 403, 10),
(211, 405, 10),
(213, 210, 5),
(213, 212, 5),
(213, 215, 2),
(213, 402, 10),
(214, 202, 250),
(214, 203, 250),
(214, 204, 200),
(214, 205, 100),
(214, 206, 33),
(214, 207, 30),
(214, 208, 250),
(214, 209, 250),
(214, 210, 1250),
(214, 211, 25),
(214, 212, 1250),
(214, 213, 5),
(214, 215, 15),
(214, 401, 200),
(214, 402, 200),
(214, 403, 100),
(214, 404, 50),
(214, 405, 100),
(215, 202, 3),
(215, 203, 3),
(215, 205, 4),
(215, 206, 4),
(215, 207, 7),
(215, 210, 5),
(215, 212, 5);

--
-- Daten fÃ¼r Tabelle `ugml_spec_requirement`
--

INSERT INTO `ugml_spec_requirement` (`specID`, `requirement`, `min`, `max`) VALUES
(12, 3, 5, NULL),
(12, 113, 3, NULL),
(15, 14, 10, NULL),
(15, 108, 10, NULL),
(21, 14, 2, NULL),
(33, 15, 1, NULL),
(33, 113, 12, NULL),
(42, 41, 1, NULL),
(43, 41, 1, NULL),
(43, 114, 7, NULL),
(106, 31, 3, NULL),
(108, 31, 1, NULL),
(109, 31, 4, NULL),
(110, 31, 6, NULL),
(110, 113, 3, NULL),
(111, 31, 2, NULL),
(113, 31, 1, NULL),
(114, 31, 7, NULL),
(114, 110, 5, NULL),
(114, 113, 5, NULL),
(115, 31, 1, NULL),
(115, 113, 1, NULL),
(117, 31, 2, NULL),
(117, 113, 1, NULL),
(118, 31, 7, NULL),
(118, 114, 3, NULL),
(120, 31, 1, NULL),
(120, 113, 2, NULL),
(121, 31, 4, NULL),
(121, 113, 4, NULL),
(121, 120, 5, NULL),
(122, 31, 5, NULL),
(122, 113, 8, NULL),
(122, 120, 10, NULL),
(122, 121, 5, NULL),
(123, 31, 10, NULL),
(123, 108, 8, NULL),
(123, 114, 8, NULL),
(199, 31, 12, NULL),
(202, 21, 2, NULL),
(202, 115, 2, NULL),
(203, 21, 4, NULL),
(203, 115, 6, NULL),
(204, 21, 1, NULL),
(204, 115, 1, NULL),
(205, 21, 3, NULL),
(205, 111, 2, NULL),
(205, 117, 2, NULL),
(206, 21, 5, NULL),
(206, 117, 4, NULL),
(206, 121, 2, NULL),
(207, 21, 7, NULL),
(207, 118, 4, NULL),
(208, 21, 4, NULL),
(208, 117, 3, NULL),
(209, 21, 4, NULL),
(209, 110, 2, NULL),
(209, 115, 6, NULL),
(210, 21, 3, NULL),
(210, 106, 2, NULL),
(210, 115, 3, NULL),
(211, 21, 8, NULL),
(211, 117, 6, NULL),
(211, 122, 5, NULL),
(212, 21, 1, NULL),
(213, 21, 9, NULL),
(213, 114, 5, NULL),
(213, 118, 6, NULL),
(214, 21, 6, NULL),
(214, 114, 6, NULL),
(214, 118, 7, NULL),
(214, 199, 1, NULL),
(215, 21, 8, NULL),
(215, 114, 5, NULL),
(215, 118, 5, NULL),
(215, 120, 12, NULL),
(401, 21, 1, NULL),
(402, 21, 2, NULL),
(402, 113, 1, NULL),
(402, 120, 3, NULL),
(403, 21, 4, NULL),
(403, 113, 3, NULL),
(403, 120, 6, NULL),
(404, 21, 6, NULL),
(404, 109, 3, NULL),
(404, 110, 1, NULL),
(404, 113, 6, NULL),
(405, 21, 4, NULL),
(405, 121, 4, NULL),
(406, 21, 8, NULL),
(406, 122, 7, NULL),
(407, 21, 1, NULL),
(407, 110, 2, NULL),
(407, 407, NULL, 1),
(408, 21, 6, NULL),
(408, 110, 6, NULL),
(408, 408, NULL, 1),
(502, 44, 2, NULL),
(503, 44, 4, NULL);

--
-- Daten fÃ¼r Tabelle `ugml_stat_type`
--

INSERT INTO `ugml_stat_type` (`statTypeID`, `type`, `name`, `default`, `selectable`) VALUES
(1, 'user', 'points', 0, 1),
(2, 'alliance', 'points', 0, 1),
(3, 'user', 'fleet', 0, 1),
(4, 'alliance', 'fleet', 0, 1),
(5, 'user', 'research', 0, 1),
(6, 'alliance', 'research', 0, 1),
(7, 'user', 'attack', 1, 1),
(8, 'alliance', 'attack', 0, 1),
(9, 'alliance', 'pointsAvg', 0, 0),
(10, 'alliance', 'fleetAvg', 0, 0),
(11, 'alliance', 'researchAvg', 0, 0),
(12, 'alliance', 'attackAvg', 0, 0);


-- phpMyAdmin SQL Dump
-- version 3.2.1-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Dezember 2009 um 15:57
-- Server Version: 5.0.67
-- PHP-Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `finaluniverse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wcf1_fleet_option`
--

CREATE TABLE IF NOT EXISTS `wcf1_fleet_option` (
  `optionID` int(10) unsigned NOT NULL auto_increment,
  `packageID` int(10) unsigned NOT NULL default '0',
  `optionName` varchar(255) NOT NULL default '',
  `categoryName` varchar(255) NOT NULL default '',
  `optionType` varchar(255) NOT NULL default '',
  `defaultValue` mediumtext,
  `validationPattern` text,
  `enableOptions` mediumtext,
  `showOrder` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`optionID`),
  UNIQUE KEY `optionName` (`optionName`,`packageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `wcf1_fleet_option`
--

INSERT INTO `wcf1_fleet_option` (`optionID`, `packageID`, `optionName`, `categoryName`, `optionType`, `defaultValue`, `validationPattern`, `enableOptions`, `showOrder`) VALUES
(1, 79, 'impactTime', 'fleet', 'timerange', '', '', '', 1),
(2, 79, 'returnTime', 'fleet', 'timerange', '', '', '', 2),
(3, 79, 'startPlanetID', 'fleet', 'pseudointeger', '', '', '', 3),
(4, 79, 'targetPlanetID', 'fleet', 'pseudointeger', '', '', '', 4),
(5, 79, 'startUserID', 'fleet', 'userplanets', '', '', '', 5),
(6, 79, 'targetUserID', 'fleet', 'userplanets', '', '', '', 6),
(7, 79, 'missionID', 'fleet', 'mission', '', '', '', 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wcf1_fleet_option_category`
--

CREATE TABLE IF NOT EXISTS `wcf1_fleet_option_category` (
  `categoryID` int(10) unsigned NOT NULL auto_increment,
  `packageID` int(10) unsigned NOT NULL default '0',
  `categoryName` varchar(255) NOT NULL default '',
  `parentCategoryName` varchar(255) NOT NULL default '',
  `showOrder` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`categoryID`),
  UNIQUE KEY `categoryName` (`categoryName`,`packageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=44 ;

--
-- Daten für Tabelle `wcf1_fleet_option_category`
--

INSERT INTO `wcf1_fleet_option_category` (`categoryID`, `packageID`, `categoryName`, `parentCategoryName`, `showOrder`) VALUES
(1, 79, 'fleet', '', 1);
-- phpMyAdmin SQL Dump
-- version 3.2.1-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Dezember 2009 um 16:07
-- Server Version: 5.0.67
-- PHP-Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `finaluniverse`
--

--
-- Daten für Tabelle `wcf1_language_item`
--

INSERT INTO `wcf1_language_item` (`languageItemID`, `languageID`, `languageItem`, `languageItemValue`, `languageCategoryID`, `packageID`) VALUES
(11310, 1, 'wot.planet.actionsPage.error.password.activityMoon', 'Auf dem Mond des Planeten gibt es noch Flottenbewegungen!', 88, 79),
(11308, 1, 'wot.planet.actionsPage.error.password.notValid', 'Das angegebene Passwort ist falsch.', 88, 79),
(11309, 1, 'wot.planet.actionsPage.error.password.activity', 'Auf dem Planeten gibt es noch Flottenbewegungen!', 88, 79),
(11307, 1, 'wot.planet.actionsPage.error.newName.notValid', 'Der angegebene Planetenname entspricht nicht den Vorgaben.', 88, 79),
(11306, 1, 'wot.planet.actionsPage.password', 'Passwort (zur Überprüfung)', 88, 79),
(11305, 1, 'wot.planet.actionsPage.newName', 'Neuer Name', 88, 79),
(11303, 1, 'wot.planet.actionsPage.action.delete', 'Löschen', 88, 79),
(11304, 1, 'wot.planet.actionsPage.title', 'Planet umbenennen / löschen', 88, 79),
(11301, 1, 'wot.overview.planet.change', 'Ändern', 92, 79),
(11302, 1, 'wot.planet.actionsPage.action.rename', 'Umbenennen', 88, 79),
(11300, 1, 'wot.overview.resourcesOverview', 'Bewegte Rohstoffe', 92, 79),
(11298, 1, 'wot.overview.resourcesOverview.fleetCount', 'Anzahl', 92, 79),
(11299, 1, 'wot.overview.resourcesOverview.total', 'Gesamt', 92, 79),
(11293, 1, 'wot.overview.planet.construction', 'Gebäudebau', 92, 79),
(11295, 1, 'wot.overview.planet.fleets', 'Fliegende Flotten', 92, 79),
(11296, 1, 'wot.overview.planet.fleets.hostile', 'feindlich', 92, 79),
(11294, 1, 'wot.overview.planet.fields', 'Felder', 92, 79),
(11323, 1, 'wot.ovent.ovent', 'Ereignis', 91, 79),
(11297, 1, 'wot.overview.planet.size', 'Größe', 92, 79),
(11269, 1, 'wot.global.date.theDayAfterTomorrow', 'Übermorgen', 83, 79),
(11267, 1, 'wot.global.date.days', 'Tage', 83, 79),
(11268, 1, 'wot.global.date.tomorrow', 'Morgen', 83, 79),
(11266, 1, 'wot.global.date.day', 'Tag', 83, 79),
(11280, 1, 'wot.planet.prefix.planetKind2', 'Orbit', 88, 79),
(11281, 1, 'wot.planet.prefix.planetKind3', 'Mond', 88, 79),
(11279, 1, 'wot.planet.prefix.planetKind1', 'Planeten', 88, 79),
(11324, 1, 'wot.ovent.time', 'Zeit', 91, 79),
(11314, 1, 'wot.ovent.extended', 'Erweitert', 91, 79),
(11265, 1, 'wot.global.serverTime', 'Aktuelle Zeit', 83, 79),
(11319, 1, 'wot.ovent.fleet.passage.return_2', ' zurück. Ihr Auftrag lautete:', 91, 79),
(11322, 1, 'wot.ovent.fleet.shipCount', 'Anzahl der Schiffe', 91, 79),
(11318, 1, 'wot.ovent.fleet.passage.return_1', 'kehrt vom', 91, 79),
(11317, 1, 'wot.ovent.fleet.passage.flight_2', '. Ihr Auftrag lautet:', 91, 79),
(11292, 1, 'wot.overview.page.title', 'Übersicht', 92, 79),
(11316, 1, 'wot.ovent.fleet.passage.flight_1', 'erreicht den', 91, 79),
(11315, 1, 'wot.ovent.fleet', 'Eine {if $ovent->ownerID == $this->user->userID}deiner{else}fremde{/if} {if $showShipStr}<a id="shipStr{@$c}">{/if}Flotte{if $ovent->ownerID == $this->user->userID}n{/if}{if $showShipStr}</a>{/if} vom {@$startPlanet} {lang}wot.ovent.fleet.passage.{@$ovent->passage}_1{/lang} {@$targetPlanet}{lang}wot.ovent.fleet.passage.{@$ovent->passage}_2{/lang} {if $showResources}<a id="resources{@$c}">{/if}{lang}wot.mission.mission{@$ovent->missionID}{/lang}{if $showResources}</a>{/if}', 91, 79),
(11205, 1, 'wot.fleet.durationAfterRecall', 'Rückrufzeit', 80, 79),
(11206, 1, 'wot.mission.mission6.impact.owner.simulate', 'Simulieren', 84, 79),
(11203, 1, 'wot.fleet.start.planetShortcuts', 'Kolonien', 80, 79),
(11204, 1, 'wot.fleet.start.resourcesMenu', 'Auftrag und Rohstoffe', 80, 79),
(11202, 1, 'wot.fleet.start.coordinatesMenu', 'Koordinaten und Geschwindigkeit', 80, 79),
(11201, 1, 'wot.fleet.durationRe', 'Rückkehrzeit', 80, 79),
(11139, 1, 'wcf.global.date.minute', 'Minuten', 3, 79),
(11138, 1, 'wot.acp.fleet.view.revision', 'Revision {#$revisionNo} über {$revision.stack}', 90, 79),
(11136, 1, 'wot.acp.fleet.search.conditions.general', 'Bedingungen', 90, 79),
(11137, 1, 'wot.acp.fleet.search.matches', '{if $items == 1}Ein{else}{#$items}{/if} Treffer', 90, 79),
(11135, 1, 'wot.acp.fleet.search', 'Flotten suchen', 90, 79),
(11133, 1, 'wot.acp.menu.link.game.fleet.search', 'Flottensuche', 89, 79),
(11134, 1, 'wot.acp.fleet.view', 'Flottendetails zeigen', 90, 79),
(11132, 1, 'wot.acp.menu.link.game.fleet', 'Flotten', 89, 79),
(11278, 1, 'wot.planet.colony', 'Kolonie', 88, 79),
(11131, 1, 'wot.acp.menu.link.game', 'Lost Worlds', 89, 79),
(10770, 1, 'wot.stat.page.title', 'Statistiken', 86, 79),
(10769, 1, 'wot.stat.select', '<fieldset><legend>Zeige...</legend>{@$typeSelect|trim}<span> bei </span>{@$nameSelect|trim}<span> auf </span>{@$rankSelect|trim}</fieldset>', 86, 79),
(10766, 1, 'wot.stat.rank.ownPosition', 'Eigene Position', 86, 79),
(10767, 1, 'wot.stat.rank.top', 'Top100', 86, 79),
(10768, 1, 'wot.stat.rank.input', 'Springe zu ...', 86, 79),
(10765, 1, 'wot.stat.name.attackAvg', 'Angriffen', 86, 79),
(10763, 1, 'wot.stat.name.fleetAvg', 'Flotten', 86, 79),
(10764, 1, 'wot.stat.name.researchAvg', 'Forschungen', 86, 79),
(10762, 1, 'wot.stat.name.pointsAvg', 'Punkten', 86, 79),
(10760, 1, 'wot.stat.average', 'Durchschnitt', 86, 79),
(10761, 1, 'wot.stat.allPoints', 'Gesamt', 86, 79),
(10758, 1, 'wot.stat.name.research', 'Forschungen', 86, 79),
(10759, 1, 'wot.stat.name.attack', 'Angriffen', 86, 79),
(10756, 1, 'wot.stat.name.points', 'Punkten', 86, 79),
(10757, 1, 'wot.stat.name.fleet', 'Flotten', 86, 79),
(10755, 1, 'wot.stat.type.alliance', 'Allianzen', 86, 79),
(10752, 1, 'wot.stat.actions', '', 86, 79),
(10753, 1, 'wot.stat.points', 'Punkte', 86, 79),
(10754, 1, 'wot.stat.type.user', 'Spieler', 86, 79),
(10880, 1, 'wot.fleet.a', 'a', 80, 79),
(10772, 1, 'wot.user.points', 'Punkte', 87, 79),
(10773, 1, 'wot.user.username', 'Name', 87, 79),
(10774, 1, 'wot.user.name', 'Spieler', 87, 79),
(10771, 1, 'wot.user.online', 'Online', 87, 79),
(11199, 1, 'wot.spec.spec502', 'Abfangrakete', 85, 79),
(11200, 1, 'wot.spec.spec503', 'Interplanetarrakete', 85, 79),
(11198, 1, 'wot.spec.spec44', 'Raketensilo', 85, 79),
(11196, 1, 'wot.spec.spec42', 'Sensorphalanx', 85, 79),
(11197, 1, 'wot.spec.spec43', 'Sprungtor', 85, 79),
(11195, 1, 'wot.spec.spec41', 'Mondbasis', 85, 79),
(11193, 1, 'wot.spec.spec407', 'Kleine Schildkuppel', 85, 79),
(11194, 1, 'wot.spec.spec408', 'Große Schildkuppel', 85, 79),
(11192, 1, 'wot.spec.spec406', 'Plasmawerfer', 85, 79),
(11190, 1, 'wot.spec.spec404', 'Gaußkanone', 85, 79),
(11191, 1, 'wot.spec.spec405', 'Ionengeschütz', 85, 79),
(11189, 1, 'wot.spec.spec403', 'Schweres Lasergeschütz', 85, 79),
(11188, 1, 'wot.spec.spec402', 'Leichtes Lasergeschütz', 85, 79),
(11187, 1, 'wot.spec.spec401', 'Raketenwerfer', 85, 79),
(11186, 1, 'wot.spec.spec4', 'Solarkraftwerk', 85, 79),
(11185, 1, 'wot.spec.spec34', 'Allianzdepot', 85, 79),
(11184, 1, 'wot.spec.spec33', 'Terraformer', 85, 79),
(11183, 1, 'wot.spec.spec31', 'Forschungslabor', 85, 79),
(11182, 1, 'wot.spec.spec3', 'Deuteriumsynthetisierer', 85, 79),
(11181, 1, 'wot.spec.spec24', 'Deuteriumtank', 85, 79),
(11180, 1, 'wot.spec.spec23', 'Kristallspeicher', 85, 79),
(11179, 1, 'wot.spec.spec22', 'Metallspeicher', 85, 79),
(11178, 1, 'wot.spec.spec215', 'Schlachtkreuzer', 85, 79),
(11177, 1, 'wot.spec.spec214', 'Todesstern', 85, 79),
(11176, 1, 'wot.spec.spec213', 'Zerstörer', 85, 79),
(11175, 1, 'wot.spec.spec212', 'Solarsatellit', 85, 79),
(11174, 1, 'wot.spec.spec211', 'Bomber', 85, 79),
(11173, 1, 'wot.spec.spec210', 'Spionagesonde', 85, 79),
(11172, 1, 'wot.spec.spec21', 'Raumschiffwerft', 85, 79),
(11171, 1, 'wot.spec.spec209', 'Recycler', 85, 79),
(11170, 1, 'wot.spec.spec208', 'Kolonieschiff', 85, 79),
(11169, 1, 'wot.spec.spec207', 'Schlachtschiff', 85, 79),
(11168, 1, 'wot.spec.spec206', 'Kreuzer', 85, 79),
(11167, 1, 'wot.spec.spec205', 'Schwerer Jäger', 85, 79),
(11166, 1, 'wot.spec.spec204', 'Leichter Jäger', 85, 79),
(11165, 1, 'wot.spec.spec203', 'Großer Transporter', 85, 79),
(11164, 1, 'wot.spec.spec202', 'Kleiner Transporter', 85, 79),
(11163, 1, 'wot.spec.spec2', 'Kristallmine', 85, 79),
(11162, 1, 'wot.spec.spec199', 'Gravitonforschung', 85, 79),
(11161, 1, 'wot.spec.spec15', 'Roboterfabrik', 85, 79),
(11159, 1, 'wot.spec.spec123', 'Intergalaktisches Forschungsnetzwerk', 85, 79),
(11160, 1, 'wot.spec.spec14', 'Roboterfabrik', 85, 79),
(11158, 1, 'wot.spec.spec122', 'Plasmatechnik', 85, 79),
(11156, 1, 'wot.spec.spec120', 'Lasertechnik', 85, 79),
(11157, 1, 'wot.spec.spec121', 'Ionentechnik', 85, 79),
(11154, 1, 'wot.spec.spec118', 'Hyperraumantrieb', 85, 79),
(11155, 1, 'wot.spec.spec12', 'Fusionskraftwerk', 85, 79),
(11150, 1, 'wot.spec.spec113', 'Energietechnik', 85, 79),
(11151, 1, 'wot.spec.spec114', 'Hyperraumtechnik', 85, 79),
(11152, 1, 'wot.spec.spec115', 'Verbrennungstechnik', 85, 79),
(11153, 1, 'wot.spec.spec117', 'Impulstriebwerk', 85, 79),
(11149, 1, 'wot.spec.spec111', 'Raumschiffpanzerung', 85, 79),
(11148, 1, 'wot.spec.spec110', 'Schildtechnik', 85, 79),
(11146, 1, 'wot.spec.spec108', 'Computertechnik', 85, 79),
(11147, 1, 'wot.spec.spec109', 'Waffentechnik', 85, 79),
(11145, 1, 'wot.spec.spec106', 'Spionagetechnik', 85, 79),
(11143, 1, 'wot.spec.research', 'Forschung', 85, 79),
(11144, 1, 'wot.spec.spec1', 'Metallmine', 85, 79),
(11141, 1, 'wot.spec.defense', 'Verteidigung', 85, 79),
(11142, 1, 'wot.spec.fleet', 'Flotte', 85, 79),
(11001, 1, 'wot.mission.mission12.return.subject', 'Rückkehr', 84, 79),
(11045, 1, 'wot.mission.mission5.sender.owner', 'Flottenkommando', 84, 79),
(11140, 1, 'wot.spec.buildings', 'Gebäude', 85, 79),
(11009, 1, 'wot.mission.mission20.sender.ofiara', 'Raumüberwachung', 84, 79),
(11005, 1, 'wot.mission.mission20.impact.destroy.ofiara.subject', 'Raketeneinschlag', 84, 79),
(11065, 1, 'wot.mission.mission8.sender.owner', 'Flottenkommando', 84, 79),
(11049, 1, 'wot.mission.mission6.impact.owner.attack', 'Angreifen', 84, 79),
(11003, 1, 'wot.mission.mission12.sender.owner', 'Flottenkommando', 84, 79),
(11053, 1, 'wot.mission.mission6.sender.ofiara', 'Raumüberwachung', 84, 79),
(11052, 1, 'wot.mission.mission6.report.header', 'Rohstoffe auf {$targetPlanet} am {$time}', 84, 79),
(11047, 1, 'wot.mission.mission6.impact.ofiara.subject', 'Spionageaktion', 84, 79),
(11048, 1, 'wot.mission.mission6.impact.ofiara.text', 'Eine feindliche Flotte vom {$startPlanet} wurde bei deinem  {$targetPlanet} gesichtet. Chance der Spionageabwehr: {$defenseChance}%', 84, 79),
(11006, 1, 'wot.mission.mission20.impact.destroy.owner.subject', 'Einschlag', 84, 79),
(11010, 1, 'wot.mission.mission20.sender.owner', 'Flottenkommando', 84, 79),
(11002, 1, 'wot.mission.mission12.return.text', 'Eine deiner Flotten kehrt zurück vom Halten beim {$targetPlanet} zum {$startPlanet}.', 84, 79),
(11050, 1, 'wot.mission.mission6.impact.owner.defenseChance', 'Chance der Spionageabwehr: {$defenseChance}%', 84, 79),
(11051, 1, 'wot.mission.mission6.impact.owner.subject', 'Spionagebericht', 84, 79),
(11073, 1, 'wot.mission.mission9.sender.owner', 'Flottenkommando', 84, 79),
(11054, 1, 'wot.mission.mission6.sender.owner', 'Flottenkommando', 84, 79),
(11071, 1, 'wot.mission.mission9.return.subject', 'Rückkehr', 84, 79),
(11072, 1, 'wot.mission.mission9.return.text', 'Eine deiner Flotten {$shipsList} kehrt von der gescheiterten Kolonisation auf {$targetPlanetCoordinates} zu {$startPlanet} zurück. Sie liefert {$resources}.', 84, 79),
(11070, 1, 'wot.mission.mission9.impact.success.owner.text', 'Eine deiner Flotten {$shipsList} erreicht {$targetPlanetCoordinates}, findet dort einen neuen Planeten und beginnt sofort mit seiner Erschließung. Es werden dort {$resources} stationiert.', 84, 79),
(11069, 1, 'wot.mission.mission9.impact.planetLimit.owner.text', 'Eine deiner Flotten {$shipsList} erreicht {$targetPlanetCoordinates}, findet dort einen neuen Planeten und beginnt sofort mit seiner Erschließung. Kurz nach Beginn der Kolonisation trifft aber eine Nachricht ein, dass es Unruhen auf der Hauptwelt des Reiches gibt, da das Imperium zu groß wird und man zieht sich zum {$startPlanet} zurück.', 84, 79),
(11068, 1, 'wot.mission.mission9.impact.owner.subject', 'Kolonisation', 84, 79),
(11067, 1, 'wot.mission.mission9.impact.exists.owner.text', 'Der von einer deiner Flotten {$shipsList} mit dem Ziel der Kolonisation angeflogene Planet {$targetPlanetCoordinates} ist bereits durch ein fremdes Imperium bewohnt. Enttäuscht macht man sich wieder zurück zum Start der Mission beim {$startPlanet} auf.', 84, 79),
(11066, 1, 'wot.mission.mission9', 'Kolonisation', 84, 79),
(11064, 1, 'wot.mission.mission8.sender.ofiara', 'Raumüberwachung', 84, 79),
(11062, 1, 'wot.mission.mission8.return.subject', 'Rückkehr', 84, 79),
(11063, 1, 'wot.mission.mission8.return.text', 'Eine deiner Flotten {$shipsList} kehrt vom {$targetPlanet} zum {$startPlanet} zurück und liefert {$resources}.', 84, 79),
(11061, 1, 'wot.mission.mission8.report.header', 'Rohstoffe auf {$targetPlanet} am {$time}', 84, 79),
(11060, 1, 'wot.mission.mission8.impact.owner.text', 'Eine deiner Flotten {$shipsList} vom {$startPlanet} hat am {$targetPlanet} {$resources} abgebaut.', 84, 79),
(11059, 1, 'wot.mission.mission8.impact.owner.subject', 'Abbau', 84, 79),
(11058, 1, 'wot.mission.mission8.impact.owner.defenseChance', 'Chance der Spionageabwehr: {$defenseChance}%', 84, 79),
(11057, 1, 'wot.mission.mission8.impact.ofiara.text', 'Eine feindliche Flotte vom {$startPlanet} wurde bei deinem  {$targetPlanet} gesichtet. Chance der Spionageabwehr: {$defenseChance}%', 84, 79),
(11056, 1, 'wot.mission.mission8.impact.ofiara.subject', 'Spionageaktion', 84, 79),
(11046, 1, 'wot.mission.mission6', 'Spionage', 84, 79),
(11055, 1, 'wot.mission.mission8', 'Abbau', 84, 79),
(11044, 1, 'wot.mission.mission5.return.subject', 'Eine deiner Flotten {$shipsList} kehrt vom {$targetPlanet} zum {$startPlanet} zurück.', 84, 79),
(11043, 1, 'wot.mission.mission5.impact.destroyNothing.owner.text', 'Deine Flotte hatte leider nicht genug Todessterne mit den nötigen Gravitonkanonen dabei, um den Mond zu zerstören. Sie kehrt wieder zum Startplaneten zurück.', 84, 79),
(11042, 1, 'wot.mission.mission5.impact.destroyNothing.owner.subject', 'Zerstörung', 84, 79),
(11019, 1, 'wot.mission.mission3.sender.ofiara', 'Raumüberwachung', 84, 79),
(11020, 1, 'wot.mission.mission3.sender.owner', 'Flottenkommando', 84, 79),
(11021, 1, 'wot.mission.mission4', 'Stationierung', 84, 79),
(11022, 1, 'wot.mission.mission4.impact.owner.subject', 'Stationierung', 84, 79),
(11023, 1, 'wot.mission.mission4.impact.owner.text', 'Eine deiner Flotten {$shipsList} von {$startPlanet} erreicht erfolgreich den {$targetPlanet} und liefert {$resources}.', 84, 79),
(11024, 1, 'wot.mission.mission4.return.subject', 'Rückkehr', 84, 79),
(11025, 1, 'wot.mission.mission4.return.text', 'Eine deiner Flotten {$shipsList} kehrt vom zum {$startPlanet} zurück und liefert {$resources}.', 84, 79),
(11026, 1, 'wot.mission.mission4.sender.owner', 'Flottenkommando', 84, 79),
(11027, 1, 'wot.mission.mission5', 'Zerstörung', 84, 79),
(11028, 1, 'wot.mission.mission5.impact.destroyFleet.ofiara.subject', 'Flottenzerstörung', 84, 79),
(11029, 1, 'wot.mission.mission5.impact.destroyFleet.ofiara.text', 'Die angreifende Flotte war nicht in der Lage, durch genügend Gravitonkanonen deinen {$targetPlanet} zu zerstören. Stattdessen kam es zu einer Rückkopplung, wodurch die angreifende Flotte komplett vernichtet wurde.', 84, 79),
(11030, 1, 'wot.mission.mission5.impact.destroyFleet.owner.subject', 'Flottenzerstörung', 84, 79),
(11031, 1, 'wot.mission.mission5.impact.destroyFleet.owner.text', 'Beim Versuch der Mondzerstörung konnten leider nicht genug Gravitonkanonen mobilisiert werden, um den Mond zu zerstören. Der Versuch endete erfolgslos, denn es kam statt der erhofften Mondzerstörung zu einer Rückkopplung, wodurch deine gesamte Flotte zerstört wurde.', 84, 79),
(11032, 1, 'wot.mission.mission5.impact.destroyMoon.ofiara.subject', 'Mondzerstörung', 84, 79),
(11033, 1, 'wot.mission.mission5.impact.destroyMoon.ofiara.text', 'Die Todessterne des Angreifers waren stark genug, um deinen {$targetPlanet} zu zerst&ouml;ren. Alle sich dort befindlichen Einheiten wurden vernichtet.', 84, 79),
(11034, 1, 'wot.mission.mission5.impact.destroyMoon.owner.subject', 'Mondzerstörung', 84, 79),
(11035, 1, 'wot.mission.mission5.impact.destroyMoon.owner.text', 'Deine Todessterne konnten genug Gravitonkanonen mobilisieren, um den gegnerischen Mond zu zerstören. Er wurde plangemäß vernichtet und die Flotte kehrt wie erwartet zurück.', 84, 79),
(11036, 1, 'wot.mission.mission5.impact.destroyNoTry.ofiara.subject', 'Sieg', 84, 79),
(11037, 1, 'wot.mission.mission5.impact.destroyNoTry.ofiara.text', 'Die Flotte des Angreifers wurde schon vor dem Versuch einer Mondzerstörung vernichtet, sodass der Mond erfolgreich geschützt wurde.', 84, 79),
(11038, 1, 'wot.mission.mission5.impact.destroyNoTry.owner.subject', 'Niederlage', 84, 79),
(11039, 1, 'wot.mission.mission5.impact.destroyNoTry.owner.text', 'Deine Flotte wurde nach dem Kampf gegen die verteidigende Flotten komplett vernichtet, sodass sich der Versuch einer Mondzerst&ouml;rung selbst erübrigte.', 84, 79),
(11040, 1, 'wot.mission.mission5.impact.destroyNothing.ofiara.subject', 'Zerstörung', 84, 79),
(11041, 1, 'wot.mission.mission5.impact.destroyNothing.ofiara.text', 'Die angreifende Flotte hat es nicht geschafft, deinen {$targetPlanet} zu zerstören. Sie machte sich wieder auf den Rückweg zu ihrem Startplaneten.', 84, 79),
(11018, 1, 'wot.mission.mission3.sender', 'Flottenkommando', 84, 79),
(11017, 1, 'wot.mission.mission3.return.text', 'Eine deiner Flotten {$shipsList} kehrt vom Transport zum Planeten {$targetPlanet} zum {$startPlanet} zurück.', 84, 79),
(10999, 1, 'wot.mission.mission11.sender.owner', 'Flottenkommando', 84, 79),
(11000, 1, 'wot.mission.mission12', 'Halten', 84, 79),
(11004, 1, 'wot.mission.mission20', 'Interplanetarraktenangriff', 84, 79),
(11007, 1, 'wot.mission.mission20.report.header', 'Raketenaufschlag auf {$targetPlanet} von {$attacker} um {$time}', 84, 79),
(11008, 1, 'wot.mission.mission20.report.lostDefense', 'Verlorene Verteidigung (-Verluste)', 84, 79),
(11011, 1, 'wot.mission.mission3', 'Transport', 84, 79),
(11012, 1, 'wot.mission.mission3.impact.ofiara.subject', 'Rohstofflieferung', 84, 79),
(11013, 1, 'wot.mission.mission3.impact.ofiara.text', 'Eine fremde Flotte vom {$startPlanet} liefert {$resources} an den {$targetPlanet}.', 84, 79),
(11014, 1, 'wot.mission.mission3.impact.owner.subject', 'Transport', 84, 79),
(11015, 1, 'wot.mission.mission3.impact.owner.text', 'Eine deiner Flotten {$shipsList} von {$startPlanet} erreicht erfolgreich den {$targetPlanet} und liefert {$resources}.', 84, 79),
(11016, 1, 'wot.mission.mission3.return.subject', 'Flottenkommando', 84, 79),
(10860, 1, 'wot.alliance.rank.all', 'Alle', 82, 79),
(10812, 1, 'wot.alliance.delete', 'Allianz auflösen', 82, 79),
(10813, 1, 'wot.alliance.delete.sure', 'Willst du die Allianz wirklich auflösen?', 82, 79),
(10829, 1, 'wot.alliance.founder', 'Gründer', 82, 79),
(10830, 1, 'wot.alliance.founder.short', 'G', 82, 79),
(10801, 1, 'wot.alliance.changeFounder.sure', 'Willst du wirklich den Gründerstatus abgeben?', 82, 79),
(10831, 1, 'wot.alliance.homepage', 'Webseite', 82, 79),
(10841, 1, 'wot.alliance.membersCount', 'Mitglieder', 82, 79),
(11102, 1, 'wot.global.coordinates', 'Koordinaten', 83, 79),
(11103, 1, 'wot.global.crystal', 'Kristall', 83, 79),
(11106, 1, 'wot.global.deuterium', 'Deuterium', 83, 79),
(11107, 1, 'wot.global.energy', 'Energie', 83, 79),
(11109, 1, 'wot.global.metal', 'Metall', 83, 79),
(11129, 1, 'wot.global.write', 'Nachricht schreiben', 83, 79),
(11105, 1, 'wot.global.debris', 'TF', 83, 79),
(11108, 1, 'wot.global.energy_max', 'Energie', 83, 79),
(11110, 1, 'wot.global.moon', 'Mond', 83, 79),
(11111, 1, 'wot.global.moon.defaultName', 'Mond', 83, 79),
(11112, 1, 'wot.global.planet', 'Planet', 83, 79),
(11113, 1, 'wot.global.time.withDays', '{$days}d {if $hours || $minutes || $seconds}{$hours}{if $minutes || $seconds}:{$minutes}{if $seconds}:{$seconds}{/if}{/if}{/if}h', 83, 79),
(11114, 1, 'wot.global.time.withDaysToDays', '{$days}d', 83, 79),
(11115, 1, 'wot.global.time.withDaysToHours', '{$days}d {$hours}h', 83, 79),
(11116, 1, 'wot.global.time.withDaysToMinutes', '{$days}d {$hours}:{$minutes}h', 83, 79),
(11117, 1, 'wot.global.time.withDaysToSeconds', '{$days}d {$hours}:{$minutes}:{$seconds}h', 83, 79),
(11118, 1, 'wot.global.time.withHours', '{$hours}{if $minutes || $seconds}:{$minutes}{if $seconds}:{$seconds}{/if}{/if}h', 83, 79),
(11119, 1, 'wot.global.time.withHoursToHours', '{$hours}h', 83, 79),
(11120, 1, 'wot.global.time.withHoursToMinutes', '{$hours}:{$minutes}h', 83, 79),
(11121, 1, 'wot.global.time.withHoursToSeconds', '{$hours}:{$minutes}:{$seconds}h', 83, 79),
(11122, 1, 'wot.global.time.withMinutes', '{$minutes}{if $seconds}:{$seconds}{/if}m', 83, 79),
(11123, 1, 'wot.global.time.withMinutesToMinutes', '{$minutes}m', 83, 79),
(11124, 1, 'wot.global.time.withMinutesToSeconds', '{$minutes}:{$seconds}m', 83, 79),
(11125, 1, 'wot.global.time.withSeconds', '{$seconds}s', 83, 79),
(11126, 1, 'wot.global.time.withSecondsToSeconds', '{$seconds}s', 83, 79),
(11127, 1, 'wot.global.timeFormat', '%d.%m.%Y, %H:%M:%S', 83, 79),
(11128, 1, 'wot.global.vacation.error', 'Du kannst diese Aktion wegen des Urlaubsmodus'' nicht ausführen.', 83, 79),
(11104, 1, 'wot.global.dateInputOrder.extended', 'day-month-year-hour-minute', 83, 79),
(10995, 1, 'wot.mission.mission1', 'Angriff', 84, 79),
(10996, 1, 'wot.mission.mission11', 'Verbandsangriff', 84, 79),
(10997, 1, 'wot.mission.mission11.return.subject', 'Rückkehr', 84, 79),
(10998, 1, 'wot.mission.mission11.return.text', 'Eine deiner Flotten {$shipsList} kehrt vom Angriff auf den {$targetPlanet} zurück zum {$startPlanet} und liefert {$resources}.', 84, 79),
(10806, 1, 'wot.alliance.circularCreate.title', 'Neue Rundmail schicken', 82, 79),
(10835, 1, 'wot.alliance.interrelationApply.title', 'Diplomatienachricht an [{$allianceTag}] schicken', 82, 79),
(10836, 1, 'wot.alliance.joinTime', 'Beitritt', 82, 79),
(10837, 1, 'wot.alliance.kickedUser.alliance', '{username} wurde aus der Allianz ausgeschlossen.', 82, 79),
(10838, 1, 'wot.alliance.kickedUser.user', 'Du wurdest aus der Allianz {alliance} ausgeschlossen.', 82, 79),
(10839, 1, 'wot.alliance.leave', 'Allianz verlassen', 82, 79),
(10840, 1, 'wot.alliance.leave.sure', 'Willst du die Allianz wirklich verlassen?', 82, 79),
(10842, 1, 'wot.alliance.membersList.title', 'Mitgliederliste deiner Allianz [{$alliance->ally_tag}]', 82, 79),
(10843, 1, 'wot.alliance.message.defaultSubject', 'Rundmail deiner Allianz {alliance} von {username}', 82, 79),
(10844, 1, 'wot.alliance.name', 'Allianzname', 82, 79),
(10845, 1, 'wot.alliance.newMember.alliance', '{username} wurde in die Allianz aufgenommen. Begründung:\r\n\r\n{answer}', 82, 79),
(10846, 1, 'wot.alliance.newMember.alliance.noAnswer', '{username} wurde in die Allianz aufgenommen.', 82, 79),
(10847, 1, 'wot.alliance.newMember.user', 'Du wurdest in die Allianz {alliance} aufgenommen. Begründung:\r\n\r\n{answer}', 82, 79),
(10848, 1, 'wot.alliance.newMember.user.noAnswer', 'Du wurdest in die Allianz {alliance} aufgenommen', 82, 79),
(10849, 1, 'wot.alliance.newcomer', 'Neuling', 82, 79),
(10850, 1, 'wot.alliance.notExisting', 'Diese Allianz existiert nicht!', 82, 79),
(10851, 1, 'wot.alliance.notMember', 'Du hast derzeit keine Allianz. Du kannst allerdings eine neue Allianz <a href="index.php?form=AllianceCreate">gr&uuml;nden</a>.', 82, 79),
(10852, 1, 'wot.alliance.page.administrate', 'Allianz verwalten', 82, 79),
(10853, 1, 'wot.alliance.page.applicationsList', 'Bewerbungen ansehen', 82, 79),
(10854, 1, 'wot.alliance.page.image', 'Allianzbild', 82, 79),
(10855, 1, 'wot.alliance.page.leader', 'Leader', 82, 79),
(10856, 1, 'wot.alliance.page.member', 'Mitglieder', 82, 79),
(10857, 1, 'wot.alliance.page.membersList', 'Mitgliederliste', 82, 79),
(10858, 1, 'wot.alliance.page.title', 'Allianzseite der Allianz {$alliance->ally_name} [{$alliance->ally_tag}]', 82, 79),
(10859, 1, 'wot.alliance.rank', 'Rang', 82, 79),
(10861, 1, 'wot.alliance.rank.alle', 'Alle', 82, 79),
(10862, 1, 'wot.alliance.rank.delete', 'Rang löschen', 82, 79),
(10863, 1, 'wot.alliance.rank.delete.sure', 'Willst du diesen Rang wirklich löschen?', 82, 79),
(10864, 1, 'wot.alliance.rank.new', 'Neuen Rang erstellen:', 82, 79),
(10865, 1, 'wot.alliance.rank1', 'Allianz auflösen', 82, 79),
(10866, 1, 'wot.alliance.rankList.title', 'Rechte konfigurieren', 82, 79),
(10867, 1, 'wot.alliance.right1', 'Allianz auflösen', 82, 79),
(10868, 1, 'wot.alliance.right2', 'User kicken', 82, 79),
(10869, 1, 'wot.alliance.right3', 'Bewerbungen einsehen', 82, 79),
(10870, 1, 'wot.alliance.right4', 'Memberliste sehen', 82, 79),
(10871, 1, 'wot.alliance.right5', 'Bewerbungen bearbeiten', 82, 79),
(10872, 1, 'wot.alliance.right6', 'Allianz verwalten', 82, 79),
(10873, 1, 'wot.alliance.right7', 'Onlinestatus in der Memberliste sehen', 82, 79),
(10874, 1, 'wot.alliance.right8', 'Rundschreiben verfassen', 82, 79),
(10875, 1, 'wot.alliance.right9', '''Rechte Hand'' (nötig zum übertragen des Gründerstatus)', 82, 79),
(10876, 1, 'wot.alliance.tag', 'Allianztag', 82, 79),
(10877, 1, 'wot.alliance.user.kick', 'Kicken', 82, 79),
(10878, 1, 'wot.alliance.user.kick.sure', 'Willst du den User wirklich kicken?', 82, 79),
(10879, 1, 'wot.alliance.waitingForApplicationAnswer', 'Du hast dich bei der Allianz <a href="index.php?page=Alliance&amp;allianceID={allianceID}">[{allianceTag}]</a> beworben. Du kannst entweder auf eine Antwort warten oder deine Bewerbung <a href="index.php?action=AllianceApplicationDelete&amp;userID={userID}" onclick="return confirm(''Willst du deine Bewerbung wirklich zurückziehen?'')" >zurückziehen</a>.', 82, 79),
(10751, 1, 'wot.stat.change', '', 86, 79),
(10834, 1, 'wot.alliance.interrelation.apply.type', 'Verbindungstyp', 82, 79),
(10793, 1, 'wot.alliance.applicationView.disagree', 'Ablehnen', 82, 79),
(10794, 1, 'wot.alliance.applicationView.text', 'Antworttext', 82, 79),
(10795, 1, 'wot.alliance.applicationView.title', 'Bewerbung von {$user->username} bearbeiten', 82, 79),
(10796, 1, 'wot.alliance.applications', 'Bewerbungen', 82, 79),
(10797, 1, 'wot.alliance.applicationsList.noApplications', 'Keine Bewerbungen', 82, 79),
(10798, 1, 'wot.alliance.applicationsList.title', 'Bewerbungen', 82, 79),
(10799, 1, 'wot.alliance.apply.text', 'Bewerbungstext', 82, 79),
(10800, 1, 'wot.alliance.apply.title', 'Bei der Allianz [{$allianceTag}] bewerben', 82, 79),
(10802, 1, 'wot.alliance.circular', 'Rundmail', 82, 79),
(10803, 1, 'wot.alliance.circular.create', 'Rundmail senden', 82, 79),
(10804, 1, 'wot.alliance.circularCreate.alliances', 'Allianzen', 82, 79),
(10805, 1, 'wot.alliance.circularCreate.text', 'Text', 82, 79),
(10807, 1, 'wot.alliance.create.name.notUnique', 'Dieser Allianzname wird bereits verwendet', 82, 79),
(10808, 1, 'wot.alliance.create.name.notValid', 'Dieser Allianzname entspricht nicht den Vorgaben', 82, 79),
(10809, 1, 'wot.alliance.create.tag.notUnique', 'Dieser Allianztag wird bereits verwendet', 82, 79),
(10810, 1, 'wot.alliance.create.tag.notValid', 'Dieser Allianztag entspricht nicht den Vorgaben', 82, 79),
(10811, 1, 'wot.alliance.create.title', 'Allianz gründen', 82, 79),
(10814, 1, 'wot.alliance.diplomacy.agree', 'Annehmen', 82, 79),
(10815, 1, 'wot.alliance.diplomacy.confederation', 'Bündnis', 82, 79),
(10816, 1, 'wot.alliance.diplomacy.confederations', 'Bündnisse', 82, 79),
(10817, 1, 'wot.alliance.diplomacy.disagree', 'Löschen', 82, 79),
(10818, 1, 'wot.alliance.diplomacy.interrelation.active', 'Aktiv', 82, 79),
(10819, 1, 'wot.alliance.diplomacy.interrelation.view', 'Anzeigen', 82, 79),
(10820, 1, 'wot.alliance.diplomacy.interrelation.wait', 'Auf Bestätigung warten', 82, 79),
(10821, 1, 'wot.alliance.diplomacy.newWar', 'Die Bashregel tritt in 12 Stunden außer Kraft. Du kannst optional im Forum einen Thema zum Krieg <a href="{boardURL}index.php?form=ThreadAdd&amp;boardID={boardID}">erstellen</a>.', 82, 79),
(10822, 1, 'wot.alliance.diplomacy.nonAggressionPacts', 'Nichtangriffspakte', 82, 79),
(10823, 1, 'wot.alliance.diplomacy.nonAgressionPact', 'Nichtangriffspakt', 82, 79),
(10824, 1, 'wot.alliance.diplomacy.state', 'Status', 82, 79),
(10825, 1, 'wot.alliance.diplomacy.title', 'Diplomatie', 82, 79),
(10826, 1, 'wot.alliance.diplomacy.war', 'Krieg', 82, 79),
(10827, 1, 'wot.alliance.diplomacy.wars', 'Kriege', 82, 79),
(10828, 1, 'wot.alliance.externalText', 'Externer Allianztext', 82, 79),
(10832, 1, 'wot.alliance.internalText', 'Interner Allianztext', 82, 79),
(10833, 1, 'wot.alliance.interrelation.apply.text', 'Text', 82, 79),
(10792, 1, 'wot.alliance.applicationView.application', 'Bewerbung von {$user->username}', 82, 79),
(10474, 1, 'wot.fleet.option.impactTime.description', '', 81, 79),
(10475, 1, 'wot.fleet.option.returnTime.description', '', 81, 79),
(10476, 1, 'wot.fleet.option.missionID.description', '', 81, 79),
(10775, 1, 'wot.alliance.administration.diplomacy', 'Diplomatie', 82, 79),
(10776, 1, 'wot.alliance.administration.editAllianceName', 'Allianznamen verändern', 82, 79),
(10777, 1, 'wot.alliance.administration.editAllianceTag', 'Allianztag verändern', 82, 79),
(10778, 1, 'wot.alliance.administration.editMembers', 'Mitglieder verwalten', 82, 79),
(10779, 1, 'wot.alliance.administration.editRights', 'Rechte konfigurieren', 82, 79),
(10780, 1, 'wot.alliance.administration.founder', 'Leaderrang', 82, 79),
(10781, 1, 'wot.alliance.administration.homepage', 'Homepage', 82, 79),
(10782, 1, 'wot.alliance.administration.image', 'Allianzbild', 82, 79),
(10783, 1, 'wot.alliance.administration.title', 'Allianzverwaltung', 82, 79),
(10784, 1, 'wot.alliance.alliance', 'Allianz', 82, 79),
(10785, 1, 'wot.alliance.application', 'Bewerbung', 82, 79),
(10786, 1, 'wot.alliance.application.disagreed', 'Die Allianz {alliance} hat deine Bewerbung abgelehnt. Begründung:\r\n\r\n{answer}', 82, 79),
(10787, 1, 'wot.alliance.application.disagreed.noAnswer', 'Die Allianz {alliance} hat deine Bewerbung abgelehnt.', 82, 79),
(10788, 1, 'wot.alliance.applicationTemplate', 'Bewerbungsvorlage', 82, 79),
(10789, 1, 'wot.alliance.applicationTime', 'Bewerbungszeit', 82, 79),
(10790, 1, 'wot.alliance.applicationView.agree', 'Annehmen', 82, 79),
(10791, 1, 'wot.alliance.applicationView.agree.legend', 'Bestätigung', 82, 79),
(10473, 1, 'wot.fleet.option.date.minute', 'Minute', 81, 79),
(10468, 1, 'wot.fleet.option.missionID', 'Auftrag', 81, 79),
(10469, 1, 'wot.fleet.option.startPlanetID.description', '', 81, 79),
(10470, 1, 'wot.fleet.option.targetPlanetID.description', '', 81, 79),
(10471, 1, 'wot.fleet.option.startUserID.description', '', 81, 79),
(10472, 1, 'wot.fleet.option.targetUserID.description', '', 81, 79),
(10467, 1, 'wot.fleet.option.returnTime', 'Rückkehr', 81, 79),
(10466, 1, 'wot.fleet.option.impactTime', 'Einschlag', 81, 79),
(10465, 1, 'wot.fleet.option.targetUserID', 'userID des Angeflogenen', 81, 79),
(10464, 1, 'wot.fleet.option.startUserID', 'userID des Besitzers', 81, 79),
(10463, 1, 'wot.fleet.option.targetPlanetID', 'planetID des Zielplaneten', 81, 79),
(10957, 1, 'wot.fleet.start.resources.no', 'Keine Rohstoffe', 80, 79),
(10462, 1, 'wot.fleet.option.startPlanetID', 'planetID des Startplaneten', 81, 79),
(10956, 1, 'wot.fleet.start.resources.max', 'Alle Rohstoffe', 80, 79),
(10935, 1, 'wot.fleet.revision.ownerIP', 'IP-Adresse des Besitzers', 80, 79),
(10934, 1, 'wot.fleet.revision.ofiaraIP', 'IP-Adresse des Angeflogenen', 80, 79),
(10941, 1, 'wot.fleet.ships', 'Schiffe', 80, 79),
(10897, 1, 'wot.fleet.impactTime', 'Einschlag', 80, 79),
(10927, 1, 'wot.fleet.returnTime', 'Rückkehr', 80, 79),
(10910, 1, 'wot.fleet.missionID', 'Auftrag', 80, 79),
(10933, 1, 'wot.fleet.revision.event.wakeUp.time', 'Aufwachzeit', 80, 79),
(10932, 1, 'wot.fleet.revision.event.wakeUp', 'Aufwach-EventID', 80, 79),
(10926, 1, 'wot.fleet.owner', 'Besitzer', 80, 79),
(10931, 1, 'wot.fleet.revision.event.return.time', 'Rückkehr', 80, 79),
(10930, 1, 'wot.fleet.revision.event.return', 'Rückkehr-EventID', 80, 79),
(10929, 1, 'wot.fleet.revision.event.impact.time', 'Einschlag', 80, 79),
(10928, 1, 'wot.fleet.revision.event.impact', 'Einschlags-EventID', 80, 79),
(10936, 1, 'wot.fleet.revision.timestamp', 'Timestamp', 80, 79),
(10894, 1, 'wot.fleet.fleetID', 'fleetID', 80, 79),
(10750, 1, 'wot.stat.rank', 'Platz', 86, 79),
(10960, 1, 'wot.fleet.start.ships.max', '[max]', 80, 79),
(10961, 1, 'wot.fleet.start.ships.min', '[min]', 80, 79),
(10916, 1, 'wot.fleet.navalFormation.invite.message.text', 'Du wurdest durch {$inviter} zum Verbandsangriff {$formationName} eingeladen. Einschlag ist um {$impactTime} auf dem {$planet}.', 80, 79),
(10919, 1, 'wot.fleet.navalFormation.name.change', 'Gib bitte hier den neuen Namen für den Verbandsangriff ein:', 80, 79),
(10912, 1, 'wot.fleet.navalFormation.addUser', 'Hinzufügen', 80, 79),
(10884, 1, 'wot.fleet.cancel.sure', 'Flotte wirklich zurückrufen?', 80, 79),
(10947, 1, 'wot.fleet.start.details', 'Details', 80, 79),
(10948, 1, 'wot.fleet.start.galacticJump.submit', 'Sprungtor', 80, 79),
(10964, 1, 'wot.fleet.start.vacationError', 'Das Ziel befindet sich im Urlaubsmodus.', 80, 79),
(10965, 1, 'wot.fleet.startPlanet', 'Startplanet', 80, 79),
(10966, 1, 'wot.fleet.targetPlanet', 'Zielplanet', 80, 79),
(10950, 1, 'wot.fleet.start.insufficientSlots', 'Alle Flottenslots sind belegt.', 80, 79),
(10963, 1, 'wot.fleet.start.tooMuchResources', 'Zu wenig Rohstoffe auf dem Startplaneten vorhanden.', 80, 79),
(10962, 1, 'wot.fleet.start.ships.title', 'Flottenzentrale', 80, 79),
(10959, 1, 'wot.fleet.start.samePlanet', 'Du kannst nicht den Startplaneten anfliegen.', 80, 79),
(10958, 1, 'wot.fleet.start.rest', 'Frei', 80, 79),
(10955, 1, 'wot.fleet.start.protectedOfiara', 'Du kannst das Ziel wegen eines Schutzes (bspw. Admin) nicht angreifen.', 80, 79),
(10954, 1, 'wot.fleet.start.noobProtection', 'Das Ziel befindet sich im Noobschutz.', 80, 79),
(10953, 1, 'wot.fleet.start.noShips', 'Keine Schiffe ausgewählt.', 80, 79),
(10951, 1, 'wot.fleet.start.navalFormation.time', 'Einschlag', 80, 79),
(10952, 1, 'wot.fleet.start.noFleets', 'Keine fliegenden Flotten', 80, 79),
(10949, 1, 'wot.fleet.start.illegalPlanet', 'Zielplanet befindet sich nicht innerhalb des gültigen Planetenbereichs.', 80, 79),
(10946, 1, 'wot.fleet.start.coordinates', 'Start', 80, 79),
(10945, 1, 'wot.fleet.start.capacityError', 'Zu wenig Ladekapazität in der Flotte.', 80, 79),
(10944, 1, 'wot.fleet.standBy.time', 'Haltedauer', 80, 79),
(10943, 1, 'wot.fleet.speed.max', 'Max. Geschwindigkeit', 80, 79),
(10942, 1, 'wot.fleet.speed', 'Geschwindigkeit', 80, 79),
(10940, 1, 'wot.fleet.shipCount', 'Anzahl', 80, 79),
(10939, 1, 'wot.fleet.ship.name', 'Schiffstyp', 80, 79),
(10938, 1, 'wot.fleet.ship.inFleet', 'In Flotte', 80, 79),
(10925, 1, 'wot.fleet.ofiara', 'Ziel', 80, 79),
(10937, 1, 'wot.fleet.ship.available', 'Verfügbar', 80, 79),
(10924, 1, 'wot.fleet.no', 'Nr.', 80, 79),
(10923, 1, 'wot.fleet.navalFormation.viewDetail', 'Verbandsangriff verwalten', 80, 79),
(10922, 1, 'wot.fleet.navalFormation.users', 'Eingeladene', 80, 79),
(10921, 1, 'wot.fleet.navalFormation.tooLate', 'Du kannst dich diesem Verband nicht mehr anschließen', 80, 79),
(10920, 1, 'wot.fleet.navalFormation.target', 'Ziel', 80, 79),
(10918, 1, 'wot.fleet.navalFormation.name', 'Verband', 80, 79),
(10917, 1, 'wot.fleet.navalFormation.joinTime', 'Beitritt', 80, 79),
(10915, 1, 'wot.fleet.navalFormation.invite.message.subject', 'Einladung', 80, 79),
(10914, 1, 'wot.fleet.navalFormation.invite.message.sender', 'Flottenverband', 80, 79),
(10913, 1, 'wot.fleet.navalFormation.create', 'Verbandsangriff gründen', 80, 79),
(10911, 1, 'wot.fleet.navalFormation', 'Verbandsangriff', 80, 79),
(10902, 1, 'wot.fleet.mission12', 'Halten', 80, 79),
(10903, 1, 'wot.fleet.mission20', 'Interplanetarraketenangriff', 80, 79),
(10904, 1, 'wot.fleet.mission3', 'Transport', 80, 79),
(10905, 1, 'wot.fleet.mission4', 'Stationierung', 80, 79),
(10906, 1, 'wot.fleet.mission5', 'Zerstörung', 80, 79),
(10907, 1, 'wot.fleet.mission6', 'Spionage', 80, 79),
(10908, 1, 'wot.fleet.mission8', 'Abbau', 80, 79),
(10909, 1, 'wot.fleet.mission9', 'Kolonisation', 80, 79),
(10901, 1, 'wot.fleet.mission11', 'Verbandsangriff', 80, 79),
(10900, 1, 'wot.fleet.mission1', 'Angriff', 80, 79),
(10899, 1, 'wot.fleet.mission.notAvailable', 'Der gewählte Auftrag ist nicht verfügbar.', 80, 79),
(10898, 1, 'wot.fleet.mission', 'Auftrag', 80, 79),
(10890, 1, 'wot.fleet.consumption', 'Deuteriumverbrauch', 80, 79),
(10891, 1, 'wot.fleet.distance', 'Entfernung', 80, 79),
(10892, 1, 'wot.fleet.duration', 'Wegzeit', 80, 79),
(10893, 1, 'wot.fleet.end.coordinates', 'Ziel', 80, 79),
(10895, 1, 'wot.fleet.fleetStart', 'Flotte schicken', 80, 79),
(10889, 1, 'wot.fleet.comeBackTime', 'Rückkehr', 80, 79),
(10888, 1, 'wot.fleet.combat.subject', 'Kampfbericht', 80, 79),
(10887, 1, 'wot.fleet.combat.sender.owner', 'Flottenkommando', 80, 79),
(10886, 1, 'wot.fleet.combat.sender.ofiara', 'Raumüberwachung', 80, 79),
(10885, 1, 'wot.fleet.capacity', 'Kapazität', 80, 79),
(10883, 1, 'wot.fleet.cancel', 'Zurückrufen', 80, 79),
(10882, 1, 'wot.fleet.arrivalTime', 'Ankunft', 80, 79),
(10881, 1, 'wot.fleet.actions', 'Befehle', 80, 79),
(10896, 1, 'wot.fleet.fleetsList', 'Flottenbewegungen <span{if $fleets|count >= $this->user->computer_tech+1} class="insufficientSlots"{/if}>({#$fleets|count}/{#$this->user->computer_tech+1} Slots belegt)</span>', 80, 79),
(11311, 1, 'wot.fleet.start.error', 'Fehler beim Laden der Daten!', 80, 79),
(11320, 1, 'wot.ovent.fleet.passage.standBy_1', 'beginnt ihren Rückflug von', 91, 79),
(11321, 1, 'wot.ovent.fleet.passage.standBy_2', '. Ihr Auftrag lautet:', 91, 79),
(11325, 1, 'wot.overview.planets', 'Meine Planeten', 92, 79);




INSERT INTO `wcf1_language_category` (`languageCategoryID`, `languageCategory`) VALUES
(80, 'wot.fleet'),
(81, 'wot.fleet.option'),
(82, 'wot.alliance'),
(83, 'wot.global'),
(84, 'wot.mission'),
(85, 'wot.spec'),
(86, 'wot.stat'),
(87, 'wot.user'),
(88, 'wot.planet'),
(89, 'wot.acp.menu'),
(90, 'wot.acp.fleet'),
(91, 'wot.ovent'),
(92, 'wot.overview');

INSERT INTO `wcf1_language_to_packages` (`languageID`, `packageID`) VALUES
(1, 79);

INSERT INTO `wcf1_package` (`packageID`, `package`, `packageDir`, `packageName`, `instanceNo`, `packageDescription`, `packageVersion`, `packageDate`, `packageURL`, `parentPackageID`, `isUnique`, `standalone`, `author`, `authorURL`) VALUES
(79, 'game.wot.core', '../', 'WOT Game Core', 1, 'WOT Game Core', '1.2.1', 1249720361, '', 0, 0, 1, 'Biggerskimo', '');

INSERT INTO `wcf1_package_dependency` (`packageID`, `dependency`, `priority`) VALUES
(79, 0, 0),
(79, 1, 0),
(79, 2, 1),
(79, 3, 2),
(79, 4, 1),
(79, 5, 3),
(79, 6, 4),
(79, 7, 1),
(79, 8, 5),
(79, 9, 1),
(79, 10, 1),
(79, 11, 2),
(79, 12, 1),
(79, 13, 1),
(79, 14, 2),
(79, 15, 2),
(79, 16, 4),
(79, 17, 5),
(79, 18, 6),
(79, 19, 6),
(79, 20, 7),
(79, 21, 7),
(79, 22, 7),
(79, 23, 7),
(79, 24, 7),
(79, 25, 1),
(79, 26, 8),
(79, 27, 7),
(79, 28, 7),
(79, 29, 2),
(79, 30, 2),
(79, 31, 1),
(79, 32, 1),
(79, 33, 1),
(79, 34, 2),
(79, 35, 3),
(79, 36, 2),
(79, 79, 10);

INSERT INTO `wcf1_package_requirement` (`packageID`, `requirement`) VALUES
(79, 1),
(79, 5),
(79, 6),
(79, 8),
(79, 9),
(79, 11),
(79, 12),
(79, 13),
(79, 16),
(79, 17),
(79, 18),
(79, 19),
(79, 20),
(79, 21),
(79, 22),
(79, 23),
(79, 24),
(79, 25),
(79, 26),
(79, 27),
(79, 28),
(79, 29),
(79, 30),
(79, 31),
(79, 32),
(79, 33),
(79, 34),
(79, 35),
(79, 36),
(79, 37);

INSERT INTO `wcf1_package_requirement_map` (`packageID`, `requirement`, `level`) VALUES
(79, 1, 0),
(79, 2, 1),
(79, 3, 2),
(79, 4, 1),
(79, 5, 3),
(79, 6, 4),
(79, 7, 1),
(79, 8, 5),
(79, 9, 1),
(79, 10, 1),
(79, 11, 2),
(79, 12, 1),
(79, 13, 1),
(79, 14, 2),
(79, 15, 2),
(79, 16, 4),
(79, 17, 5),
(79, 18, 6),
(79, 19, 6),
(79, 20, 7),
(79, 21, 7),
(79, 22, 7),
(79, 23, 7),
(79, 24, 7),
(79, 25, 1),
(79, 26, 8),
(79, 27, 7),
(79, 28, 7),
(79, 29, 2),
(79, 30, 2),
(79, 31, 1),
(79, 32, 1),
(79, 33, 1),
(79, 34, 2),
(79, 35, 3),
(79, 36, 2),
(79, 37, 3);

DELIMITER |

CREATE FUNCTION `BIGGER`(a INT, b INT)
RETURNS int(11)
DETERMINISTIC
BEGIN
	IF a > b
		THEN
			RETURN a;
		ELSE
			RETURN b;
	END IF;
END|

CREATE FUNCTION `SMALLER`(a INT, b INT)
RETURNS int(11)
DETERMINISTIC
BEGIN
	IF a < b
		THEN
			RETURN a;
		ELSE
			RETURN b;
	END IF;
END|

DELIMITER ;

CREATE TRIGGER oventEventUpdate
BEFORE UPDATE
ON ugml_event
FOR EACH ROW
UPDATE ugml_ovent SET `time` = NEW.`time`, relationalID = NEW.specificID WHERE eventID = NEW.eventID;