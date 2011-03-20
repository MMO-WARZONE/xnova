-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: sql303.byetcluster.com
-- Generation Time: Oct 27, 2009 at 03:06 PM
-- Server version: 5.1.39
-- PHP Version: 5.2.6-1+lenny3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `Space Conflict 2.5`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_adsense`
--

CREATE TABLE IF NOT EXISTS `RageOnline_adsense` (
  `adsense_name` text NOT NULL,
  `adsense_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_adsense`
--

INSERT INTO `RageOnline_adsense` (`adsense_name`, `adsense_value`) VALUES
('leftmenu_on', '0'),
('leftmenu_script', ''),
('overview_on', '0'),
('overview_script', ''),
('options_on', '0'),
('galaxy_on', '0'),
('donate_on', '0'),
('donorstore_on', '0'),
('scrapyard_on', '0');

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_aks`
--

CREATE TABLE IF NOT EXISTS `RageOnline_aks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `teilnehmer` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `flotten` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `ankunft` int(32) DEFAULT NULL,
  `galaxy` int(2) DEFAULT NULL,
  `system` int(4) DEFAULT NULL,
  `planet` int(2) DEFAULT NULL,
  `eingeladen` int(11) DEFAULT NULL,
  `planet_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `RageOnline_aks`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_alliance`
--

CREATE TABLE IF NOT EXISTS `RageOnline_alliance` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `ally_name` varchar(32) DEFAULT '',
  `ally_tag` varchar(8) DEFAULT '',
  `ally_owner` int(11) NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_description` text,
  `ally_web` varchar(255) DEFAULT '',
  `ally_text` text,
  `ally_image` varchar(255) DEFAULT '',
  `ally_request` text,
  `ally_request_waiting` text,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT '0',
  `ally_owner_range` varchar(32) DEFAULT '',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `RageOnline_alliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_annonce`
--

CREATE TABLE IF NOT EXISTS `RageOnline_annonce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `galaxie` int(11) NOT NULL DEFAULT '0',
  `systeme` int(11) NOT NULL DEFAULT '0',
  `metala` bigint(11) NOT NULL DEFAULT '0',
  `cristala` bigint(11) NOT NULL DEFAULT '0',
  `deuta` bigint(11) NOT NULL DEFAULT '0',
  `metals` bigint(11) NOT NULL DEFAULT '0',
  `cristals` bigint(11) NOT NULL DEFAULT '0',
  `deuts` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `RageOnline_annonce`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_banned`
--

CREATE TABLE IF NOT EXISTS `RageOnline_banned` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(11) NOT NULL DEFAULT '',
  `theme` text NOT NULL,
  `who2` varchar(11) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(11) NOT NULL DEFAULT '',
  `email` varchar(20) NOT NULL DEFAULT '',
  KEY `ID` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `RageOnline_banned`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_buddy`
--

CREATE TABLE IF NOT EXISTS `RageOnline_buddy` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `RageOnline_buddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_chat`
--

CREATE TABLE IF NOT EXISTS `RageOnline_chat` (
  `messageid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3181 ;

--
-- Dumping data for table `RageOnline_chat`
--

INSERT INTO `RageOnline_chat` (`messageid`, `user`, `message`, `timestamp`) VALUES
(2668, 'WELLST', 'Welcome to Space Conflict', 1247177160);


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_config`
--

CREATE TABLE IF NOT EXISTS `RageOnline_config` (
  `config_name` varchar(64) NOT NULL DEFAULT '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_config`
--

INSERT INTO `RageOnline_config` (`config_name`, `config_value`) VALUES
('users_amount', '0'),
('game_speed', '87500'),
('fleet_speed', '25000'),
('resource_multiplier', '25'),
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('initial_fields', '500'),
('COOKIE_NAME', 'Xnova'),
('game_name', 'SpaceConflict'),
('game_disable', '0'),
('close_reason', ''),
('metal_basic_income', '20'),
('crystal_basic_income', '10'),
('deuterium_basic_income', '50'),
('energy_basic_income', '0'),
('BuildLabWhileRun', '1'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '35'),
('LastSettedPlanetPos', '2'),
('urlaubs_modus_erz', '1'),
('noobprotection', '0'),
('noobprotectiontime', '0'),
('noobprotectionmulti', '0'),
('forum_url', 'Your Forum Name'),
('OverviewNewsFrame', '1'),
('OverviewNewsText', '<img src=images/bann.png></img>\r\n<marquee><span style=\\"color: #ffffff;\\">W</span><span style=\\"color: #fcfcfc;\\">e</span><span style=\\"color: #f9f9f9;\\">l</span><span style=\\"color: #f7f7f7;\\">c</span><span style=\\"color: #f4f4f4;\\">o</span><span style=\\"color: #f2f2f2;\\">m</span><span style=\\"color: #efefef;\\">e</span> <span style=\\"color: #eaeaea;\\">t</span><span style=\\"color: #e8e8e8;\\">o</span> <span style=\\"color: #e3e3e3;\\">S</span><span style=\\"color: #e0e0e0;\\">p</span><span style=\\"color: #dedede;\\">a</span><span style=\\"color: #dbdbdb;\\">c</span><span style=\\"color: #d9d9d9;\\">e</span> <span style=\\"color: #d4d4d4;\\">C</span><span style=\\"color: #d1d1d1;\\">o</span><span style=\\"color: #cfcfcf;\\">n</span><span style=\\"color: #cccccc;\\">f</span><span style=\\"color: #cacaca;\\">l</span><span style=\\"color: #c7c7c7;\\">i</span><span style=\\"color: #c5c5c5;\\">c</span><span style=\\"color: #c2c2c2;\\">t</span></marquee>\r\n\r\nFor best perfomance use the <a href=\\"http://www.mozilla.com/firefox\\"><u><font color=lime>firefox</font></u></a> web browser with the ad-block plus add-on installed. \r\n\r\nWe are still getting new players to the game, if you like it tell your friends. The more people the better!'),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', ''),
('ExtCopyFrame', '0'),
('ExtCopyOwner', ''),
('ExtCopyFunct', ''),
('ForumBannerFrame', '0'),
('stat_settings', '1000'),
('link_enable', '1'),
('link_name', '<font color=red>Rules</font>'),
('link_url', 'http://board.ogame.org/index.php?page=Thread&threadID=269802'),
('enable_announces', '0'),
('enable_marchand', '1'),
('enable_notes', '1'),
('bot_name', 'SpaceConflict'),
('bot_adress', 'admin.spaceconflict@googlemail.com'),
('banner_source_post', '../images/bann.png'),
('ban_duration', '30'),
('enable_bot', '1'),
('enable_bbcode', '1'),
('debug', '0'),
('tachyon_basic_income', '0'),
('enable_source', '0'),
('enable_donate', '0');

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_declared`
--

CREATE TABLE IF NOT EXISTS `RageOnline_declared` (
  `declarator` text NOT NULL,
  `declared_1` text NOT NULL,
  `declared_2` text NOT NULL,
  `declared_3` text NOT NULL,
  `reason` text NOT NULL,
  `declarator_name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_declared`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_errors`
--

CREATE TABLE IF NOT EXISTS `RageOnline_errors` (
  `error_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `error_sender` varchar(32) NOT NULL DEFAULT '0',
  `error_time` int(11) NOT NULL DEFAULT '0',
  `error_type` varchar(32) NOT NULL DEFAULT 'unknown',
  `error_text` text,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=299 ;

--
-- Dumping data for table `RageOnline_errors`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_fleets`
--

CREATE TABLE IF NOT EXISTS `RageOnline_fleets` (
  `fleet_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `fleet_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_mission` int(11) NOT NULL DEFAULT '0',
  `fleet_amount` bigint(11) NOT NULL DEFAULT '0',
  `fleet_array` text,
  `fleet_start_time` int(11) NOT NULL DEFAULT '0',
  `fleet_start_galaxy` int(11) NOT NULL DEFAULT '0',
  `fleet_start_system` int(11) NOT NULL DEFAULT '0',
  `fleet_start_planet` int(11) NOT NULL DEFAULT '0',
  `fleet_start_type` int(11) NOT NULL DEFAULT '0',
  `fleet_end_time` int(11) NOT NULL DEFAULT '0',
  `fleet_end_stay` int(11) NOT NULL DEFAULT '0',
  `fleet_end_galaxy` int(11) NOT NULL DEFAULT '0',
  `fleet_end_system` int(11) NOT NULL DEFAULT '0',
  `fleet_end_planet` int(11) NOT NULL DEFAULT '0',
  `fleet_end_type` int(11) NOT NULL DEFAULT '0',
  `fleet_taget_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_resource_metal` bigint(11) NOT NULL DEFAULT '0',
  `fleet_resource_crystal` bigint(11) NOT NULL DEFAULT '0',
  `fleet_resource_deuterium` bigint(11) NOT NULL DEFAULT '0',
  `fleet_target_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_group` int(11) NOT NULL DEFAULT '0',
  `fleet_mess` int(11) NOT NULL DEFAULT '0',
  `start_time` int(11) DEFAULT NULL,
  `fleet_resource_tachyon` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fleet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53558 ;

--
-- Dumping data for table `RageOnline_fleets`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_galaxy`
--

CREATE TABLE IF NOT EXISTS `RageOnline_galaxy` (
  `galaxy` int(2) NOT NULL DEFAULT '0',
  `system` int(3) NOT NULL DEFAULT '0',
  `planet` int(2) NOT NULL DEFAULT '0',
  `id_planet` int(11) NOT NULL DEFAULT '0',
  `metal` bigint(11) NOT NULL DEFAULT '0',
  `crystal` bigint(11) NOT NULL DEFAULT '0',
  `id_luna` int(11) NOT NULL DEFAULT '0',
  `luna` int(2) NOT NULL DEFAULT '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_galaxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_iraks`
--

CREATE TABLE IF NOT EXISTS `RageOnline_iraks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zeit` int(32) DEFAULT NULL,
  `galaxy` int(2) DEFAULT NULL,
  `system` int(4) DEFAULT NULL,
  `planet` int(2) DEFAULT NULL,
  `galaxy_angreifer` int(2) DEFAULT NULL,
  `system_angreifer` int(4) DEFAULT NULL,
  `planet_angreifer` int(2) DEFAULT NULL,
  `owner` int(32) DEFAULT NULL,
  `zielid` int(32) DEFAULT NULL,
  `anzahl` int(32) DEFAULT NULL,
  `primaer` int(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=330 ;

--
-- Dumping data for table `RageOnline_iraks`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_lunas`
--

CREATE TABLE IF NOT EXISTS `RageOnline_lunas` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_luna` int(11) NOT NULL DEFAULT '0',
  `name` varchar(11) NOT NULL DEFAULT 'Lune',
  `image` varchar(11) NOT NULL DEFAULT 'mond',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `id_owner` int(11) DEFAULT NULL,
  `galaxy` int(11) DEFAULT NULL,
  `system` int(11) DEFAULT NULL,
  `lunapos` int(11) DEFAULT NULL,
  `temp_min` int(11) NOT NULL DEFAULT '0',
  `temp_max` int(11) NOT NULL DEFAULT '0',
  `diameter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=403 ;

--
-- Dumping data for table `RageOnline_lunas`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_messages`
--

CREATE TABLE IF NOT EXISTS `RageOnline_messages` (
  `message_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) NOT NULL DEFAULT '0',
  `message_sender` int(11) NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` int(11) NOT NULL DEFAULT '0',
  `message_from` varchar(48) DEFAULT NULL,
  `message_subject` varchar(48) DEFAULT NULL,
  `message_text` text,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30791818 ;

--
-- Dumping data for table `RageOnline_messages`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_multi`
--

CREATE TABLE IF NOT EXISTS `RageOnline_multi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player` bigint(11) unsigned NOT NULL DEFAULT '0',
  `sharer` bigint(11) unsigned NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `RageOnline_multi`
--


-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_notes`
--

CREATE TABLE IF NOT EXISTS `RageOnline_notes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `RageOnline_notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_planets`
--

CREATE TABLE IF NOT EXISTS `RageOnline_planets` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `id_level` int(11) NOT NULL DEFAULT '0',
  `galaxy` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` int(11) NOT NULL DEFAULT '1',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `b_building` int(11) NOT NULL DEFAULT '0',
  `b_building_id` text NOT NULL,
  `b_tech` int(11) NOT NULL DEFAULT '0',
  `b_tech_id` int(11) NOT NULL DEFAULT '0',
  `b_hangar` int(11) NOT NULL DEFAULT '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',
  `diameter` int(11) NOT NULL DEFAULT '12800',
  `ranks` bigint(20) DEFAULT '0',
  `field_current` int(11) NOT NULL DEFAULT '0',
  `field_max` int(11) NOT NULL DEFAULT '163',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
  `points` bigint(20) NOT NULL DEFAULT '0',
  `metal` double(132,8) NOT NULL DEFAULT '0.00000000',
  `metal_perhour` int(11) NOT NULL DEFAULT '0',
  `metal_max` bigint(20) DEFAULT '100000',
  `crystal` double(132,8) NOT NULL DEFAULT '0.00000000',
  `crystal_perhour` int(11) NOT NULL DEFAULT '0',
  `crystal_max` bigint(20) DEFAULT '100000',
  `deuterium` double(132,8) NOT NULL DEFAULT '0.00000000',
  `deuterium_perhour` int(11) NOT NULL DEFAULT '0',
  `deuterium_max` bigint(20) DEFAULT '100000',
  `energy_used` int(11) NOT NULL DEFAULT '0',
  `energy_max` int(11) NOT NULL DEFAULT '0',
  `metal_mine` int(11) NOT NULL DEFAULT '0',
  `crystal_mine` int(11) NOT NULL DEFAULT '0',
  `deuterium_sintetizer` int(11) NOT NULL DEFAULT '0',
  `solar_plant` int(11) NOT NULL DEFAULT '0',
  `fusion_plant` int(11) NOT NULL DEFAULT '0',
  `robot_factory` int(11) NOT NULL DEFAULT '0',
  `nano_factory` int(11) NOT NULL DEFAULT '0',
  `hangar` int(11) NOT NULL DEFAULT '0',
  `metal_store` int(11) NOT NULL DEFAULT '0',
  `crystal_store` int(11) NOT NULL DEFAULT '0',
  `deuterium_store` int(11) NOT NULL DEFAULT '0',
  `laboratory` int(11) NOT NULL DEFAULT '0',
  `terraformer` int(11) NOT NULL DEFAULT '0',
  `ally_deposit` int(11) NOT NULL DEFAULT '0',
  `silo` int(11) NOT NULL DEFAULT '0',
  `small_ship_cargo` bigint(11) NOT NULL DEFAULT '0',
  `big_ship_cargo` bigint(11) NOT NULL DEFAULT '0',
  `light_hunter` bigint(11) NOT NULL DEFAULT '0',
  `heavy_hunter` bigint(11) NOT NULL DEFAULT '0',
  `crusher` bigint(11) NOT NULL DEFAULT '0',
  `battle_ship` bigint(11) NOT NULL DEFAULT '0',
  `colonizer` bigint(11) NOT NULL DEFAULT '0',
  `recycler` bigint(11) NOT NULL DEFAULT '0',
  `spy_sonde` bigint(11) NOT NULL DEFAULT '0',
  `bomber_ship` bigint(11) NOT NULL DEFAULT '0',
  `solar_satelit` bigint(11) NOT NULL DEFAULT '0',
  `destructor` bigint(11) NOT NULL DEFAULT '0',
  `dearth_star` bigint(11) NOT NULL DEFAULT '0',
  `battleship` bigint(11) NOT NULL DEFAULT '0',
  `elite_fighter` bigint(11) NOT NULL DEFAULT '0',
  `world_eater` bigint(11) NOT NULL DEFAULT '0',
  `misil_launcher` bigint(11) NOT NULL DEFAULT '0',
  `small_laser` bigint(11) NOT NULL DEFAULT '0',
  `big_laser` bigint(11) NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(11) NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(11) NOT NULL DEFAULT '0',
  `buster_canyon` bigint(11) NOT NULL DEFAULT '0',
  `small_protection_shield` int(11) NOT NULL DEFAULT '0',
  `big_protection_shield` int(11) NOT NULL DEFAULT '0',
  `orb_def_plat` bigint(11) NOT NULL DEFAULT '0',
  `interceptor_misil` int(11) NOT NULL DEFAULT '0',
  `interplanetary_misil` int(11) NOT NULL DEFAULT '0',
  `metal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `crystal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `fusion_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_satelit_porcent` int(11) NOT NULL DEFAULT '10',
  `mondbasis` bigint(11) NOT NULL DEFAULT '0',
  `phalanx` bigint(11) NOT NULL DEFAULT '0',
  `sprungtor` bigint(11) NOT NULL DEFAULT '0',
  `last_jump_time` int(11) NOT NULL DEFAULT '0',
  `records` int(11) NOT NULL DEFAULT '1',
  `orb_shipyard` int(11) NOT NULL DEFAULT '0',
  `freighter` bigint(11) NOT NULL DEFAULT '0',
  `tachyon` double(132,8) NOT NULL DEFAULT '0.00000000',
  `tachyon_perhour` int(11) NOT NULL DEFAULT '0',
  `tachyon_max` bigint(11) NOT NULL DEFAULT '100000',
  `tach_accel` int(11) NOT NULL DEFAULT '0',
  `tachyon_store` int(11) NOT NULL DEFAULT '0',
  `tach_accel_porcent` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3936 ;

--
-- Dumping data for table `RageOnline_planets`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_rw`
--

CREATE TABLE IF NOT EXISTS `RageOnline_rw` (
  `id_owner1` int(11) NOT NULL DEFAULT '0',
  `id_owner2` int(11) NOT NULL DEFAULT '0',
  `rid` varchar(72) NOT NULL DEFAULT '',
  `raport` text NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `owners` int(11) NOT NULL,
  UNIQUE KEY `rid` (`rid`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_rw`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_statpoints`
--

CREATE TABLE IF NOT EXISTS `RageOnline_statpoints` (
  `id_owner` int(11) NOT NULL DEFAULT '0',
  `id_ally` int(11) NOT NULL DEFAULT '0',
  `stat_type` int(2) NOT NULL DEFAULT '0',
  `stat_code` int(11) NOT NULL DEFAULT '0',
  `tech_rank` int(11) NOT NULL DEFAULT '0',
  `tech_old_rank` int(11) NOT NULL DEFAULT '0',
  `tech_points` bigint(20) NOT NULL DEFAULT '0',
  `tech_count` int(11) NOT NULL DEFAULT '0',
  `build_rank` int(11) NOT NULL DEFAULT '0',
  `build_old_rank` int(11) NOT NULL DEFAULT '0',
  `build_points` bigint(20) NOT NULL DEFAULT '0',
  `build_count` int(11) NOT NULL DEFAULT '0',
  `defs_rank` int(11) NOT NULL DEFAULT '0',
  `defs_old_rank` int(11) NOT NULL DEFAULT '0',
  `defs_points` bigint(20) NOT NULL DEFAULT '0',
  `defs_count` int(11) NOT NULL DEFAULT '0',
  `fleet_rank` int(11) NOT NULL DEFAULT '0',
  `fleet_old_rank` int(11) NOT NULL DEFAULT '0',
  `fleet_points` bigint(20) NOT NULL DEFAULT '0',
  `fleet_count` int(11) NOT NULL DEFAULT '0',
  `total_rank` int(11) NOT NULL DEFAULT '0',
  `total_old_rank` int(11) NOT NULL DEFAULT '0',
  `total_points` bigint(20) NOT NULL DEFAULT '0',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `stat_date` int(11) NOT NULL DEFAULT '0',
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_statpoints`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_users`
--

CREATE TABLE IF NOT EXISTS `RageOnline_users` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `email_2` varchar(64) NOT NULL DEFAULT '',
  `lang` varchar(8) NOT NULL DEFAULT 'en',
  `authlevel` tinyint(4) NOT NULL DEFAULT '0',
  `sex` char(1) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `sign` text,
  `id_planet` int(11) NOT NULL DEFAULT '0',
  `galaxy` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `current_planet` int(11) NOT NULL DEFAULT '0',
  `user_lastip` varchar(15) NOT NULL DEFAULT '',
  `ip_at_reg` varchar(15) NOT NULL DEFAULT '',
  `user_agent` text NOT NULL,
  `current_page` text NOT NULL,
  `register_time` int(11) NOT NULL DEFAULT '0',
  `onlinetime` int(11) NOT NULL DEFAULT '0',
  `dpath` varchar(255) NOT NULL DEFAULT '',
  `design` tinyint(4) NOT NULL DEFAULT '1',
  `noipcheck` tinyint(4) NOT NULL DEFAULT '1',
  `planet_sort` tinyint(1) NOT NULL DEFAULT '0',
  `planet_sort_order` tinyint(1) NOT NULL DEFAULT '0',
  `spio_anz` tinyint(4) NOT NULL DEFAULT '1',
  `settings_tooltiptime` tinyint(4) NOT NULL DEFAULT '5',
  `settings_fleetactions` tinyint(4) NOT NULL DEFAULT '0',
  `settings_allylogo` tinyint(4) NOT NULL DEFAULT '0',
  `settings_esp` tinyint(4) NOT NULL DEFAULT '1',
  `settings_wri` tinyint(4) NOT NULL DEFAULT '1',
  `settings_bud` tinyint(4) NOT NULL DEFAULT '1',
  `settings_mis` tinyint(4) NOT NULL DEFAULT '1',
  `settings_rep` tinyint(4) NOT NULL DEFAULT '0',
  `urlaubs_modus` tinyint(4) NOT NULL DEFAULT '0',
  `urlaubs_until` int(11) NOT NULL DEFAULT '0',
  `db_deaktjava` tinyint(4) NOT NULL DEFAULT '0',
  `new_message` int(11) NOT NULL DEFAULT '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) NOT NULL DEFAULT '0',
  `spy_tech` int(11) NOT NULL DEFAULT '0',
  `computer_tech` int(11) NOT NULL DEFAULT '0',
  `military_tech` int(11) NOT NULL DEFAULT '0',
  `defence_tech` int(11) NOT NULL DEFAULT '0',
  `shield_tech` int(11) NOT NULL DEFAULT '0',
  `energy_tech` int(11) NOT NULL DEFAULT '0',
  `hyperspace_tech` int(11) NOT NULL DEFAULT '0',
  `combustion_tech` int(11) NOT NULL DEFAULT '0',
  `impulse_motor_tech` int(11) NOT NULL DEFAULT '0',
  `hyperspace_motor_tech` int(11) NOT NULL DEFAULT '0',
  `laser_tech` int(11) NOT NULL DEFAULT '0',
  `ionic_tech` int(11) NOT NULL DEFAULT '0',
  `buster_tech` int(11) NOT NULL DEFAULT '0',
  `intergalactic_tech` int(11) NOT NULL DEFAULT '0',
  `expedition_tech` int(11) NOT NULL DEFAULT '0',
  `graviton_tech` int(11) NOT NULL DEFAULT '0',
  `tach_extract_tech` int(11) NOT NULL DEFAULT '0',
  `tach_compress_tech` int(11) NOT NULL DEFAULT '0',
  `quantum_tech` int(11) NOT NULL DEFAULT '0',
  `quantum_drive_tech` int(11) NOT NULL DEFAULT '0',
  `genetic_tech` int(11) NOT NULL DEFAULT '0',
  `ally_id` int(11) NOT NULL DEFAULT '0',
  `ally_name` varchar(32) DEFAULT '',
  `ally_request` int(11) NOT NULL DEFAULT '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank_id` int(11) NOT NULL DEFAULT '0',
  `current_luna` int(11) NOT NULL DEFAULT '0',
  `kolorminus` varchar(11) NOT NULL DEFAULT 'red',
  `kolorplus` varchar(11) NOT NULL DEFAULT '#00FF00',
  `kolorpoziom` varchar(11) NOT NULL DEFAULT 'yellow',
  `rpg_geologue` int(11) NOT NULL DEFAULT '0',
  `rpg_amiral` int(11) NOT NULL DEFAULT '0',
  `rpg_ingenieur` int(11) NOT NULL DEFAULT '0',
  `rpg_technocrate` int(11) NOT NULL DEFAULT '0',
  `rpg_espion` int(11) NOT NULL DEFAULT '0',
  `rpg_constructeur` int(11) NOT NULL DEFAULT '0',
  `rpg_scientifique` int(11) NOT NULL DEFAULT '0',
  `rpg_commandant` int(11) NOT NULL DEFAULT '0',
  `rpg_points` int(11) NOT NULL DEFAULT '500',
  `rpg_stockeur` int(11) NOT NULL DEFAULT '0',
  `rpg_defenseur` int(11) NOT NULL DEFAULT '0',
  `rpg_destructeur` int(11) NOT NULL DEFAULT '0',
  `rpg_general` int(11) NOT NULL DEFAULT '0',
  `rpg_bunker` int(11) NOT NULL DEFAULT '0',
  `rpg_raideur` int(11) NOT NULL DEFAULT '0',
  `rpg_empereur` int(11) NOT NULL DEFAULT '0',
  `lvl_minier` int(11) NOT NULL DEFAULT '1',
  `lvl_raid` int(11) NOT NULL DEFAULT '1',
  `xpraid` int(11) NOT NULL DEFAULT '0',
  `xpminier` int(11) NOT NULL DEFAULT '0',
  `raids` bigint(20) NOT NULL DEFAULT '0',
  `p_infligees` bigint(20) NOT NULL DEFAULT '0',
  `mnl_alliance` int(11) NOT NULL DEFAULT '0',
  `mnl_joueur` int(11) NOT NULL DEFAULT '0',
  `mnl_attaque` int(11) NOT NULL DEFAULT '0',
  `mnl_spy` int(11) NOT NULL DEFAULT '0',
  `mnl_exploit` int(11) NOT NULL DEFAULT '0',
  `mnl_transport` int(11) NOT NULL DEFAULT '0',
  `mnl_expedition` int(11) NOT NULL DEFAULT '0',
  `mnl_general` int(11) NOT NULL DEFAULT '0',
  `mnl_buildlist` int(11) NOT NULL DEFAULT '0',
  `bana` int(11) DEFAULT NULL,
  `multi_validated` int(11) DEFAULT NULL,
  `banaday` int(11) DEFAULT NULL,
  `raids1` int(11) DEFAULT NULL,
  `raidswin` int(11) DEFAULT NULL,
  `raidsloose` int(11) DEFAULT NULL,
  `records` int(11) NOT NULL DEFAULT '1',
  `rpg_indy` int(11) NOT NULL DEFAULT '0',
  `rpg_acad` int(11) NOT NULL DEFAULT '0',
  `rpg_conq` int(11) NOT NULL DEFAULT '0',
  `rpg_quantum` int(11) NOT NULL DEFAULT '0',
  `tach_tech` int(11) NOT NULL DEFAULT '0',
  `active` varchar(1) DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=632 ;

--
-- Dumping data for table `RageOnline_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `RageOnline_vacation`
--

CREATE TABLE IF NOT EXISTS `RageOnline_vacation` (
  `id_owner` int(11) DEFAULT NULL,
  `id` bigint(11) NOT NULL DEFAULT '0',
  `metal_perhour` int(11) NOT NULL DEFAULT '0',
  `crystal_perhour` int(11) NOT NULL DEFAULT '0',
  `deuterium_perhour` int(11) NOT NULL DEFAULT '0',
  `tachyon_perhour` int(11) NOT NULL DEFAULT '0',
  `energy_used` int(11) NOT NULL DEFAULT '0',
  `energy_max` int(11) NOT NULL DEFAULT '0',
  `metal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `crystal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL DEFAULT '10',
  `tach_accel_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `fusion_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_satelit_porcent` int(11) NOT NULL DEFAULT '10',
  `planet_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RageOnline_vacation`
--