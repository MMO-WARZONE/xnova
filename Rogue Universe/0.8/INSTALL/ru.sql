/*
MySQL Data Transfer
Source Host: localhost
Source Database: release
Target Host: localhost
Target Database: release
Date: 2009-01-18 22:55:56
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for game_aks
-- ----------------------------
CREATE TABLE `game_aks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `teilnehmer` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `flotten` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `ankunft` int(32) DEFAULT NULL,
  `galaxy` int(2) DEFAULT NULL,
  `system` int(4) DEFAULT NULL,
  `planet` int(2) DEFAULT NULL,
  `eingeladen` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_alliance
-- ----------------------------
CREATE TABLE `game_alliance` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `ally_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `ally_tag` varchar(8) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `ally_owner` int(11) NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_description` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ally_web` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `ally_text` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ally_image` varchar(255) DEFAULT '',
  `ally_request` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ally_request_waiting` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT '0',
  `ally_owner_range` varchar(32) DEFAULT '',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL DEFAULT '0',
  `allykasse_metall` bigint(60) NOT NULL,
  `allykasse_kristall` bigint(60) NOT NULL,
  `allykasse_deuterium` bigint(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_annonce
-- ----------------------------
CREATE TABLE `game_annonce` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_banned
-- ----------------------------
CREATE TABLE `game_banned` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(11) NOT NULL DEFAULT '',
  `theme` text NOT NULL,
  `who2` varchar(11) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(11) NOT NULL DEFAULT '',
  `email` varchar(20) NOT NULL DEFAULT '',
  KEY `ID` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_buddy
-- ----------------------------
CREATE TABLE `game_buddy` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_chat
-- ----------------------------
CREATE TABLE `game_chat` (
  `messageid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_config
-- ----------------------------
CREATE TABLE `game_config` (
  `config_name` varchar(64) NOT NULL DEFAULT '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_errors
-- ----------------------------
CREATE TABLE `game_errors` (
  `error_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `error_sender` varchar(32) NOT NULL DEFAULT '0',
  `error_time` int(11) NOT NULL DEFAULT '0',
  `error_type` varchar(32) NOT NULL DEFAULT 'unknown',
  `error_text` text,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_fleets
-- ----------------------------
CREATE TABLE `game_fleets` (
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
  `fleet_target_obj` int(2) NOT NULL DEFAULT '0',
  `fleet_resource_metal` bigint(11) NOT NULL DEFAULT '0',
  `fleet_resource_crystal` bigint(11) NOT NULL DEFAULT '0',
  `fleet_resource_deuterium` bigint(11) NOT NULL DEFAULT '0',
  `fleet_target_owner` int(2) NOT NULL DEFAULT '0',
  `fleet_group` int(11) NOT NULL DEFAULT '0',
  `fleet_mess` int(11) NOT NULL DEFAULT '0',
  `start_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`fleet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_galaxy
-- ----------------------------
CREATE TABLE `game_galaxy` (
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

-- ----------------------------
-- Table structure for game_iraks
-- ----------------------------
CREATE TABLE `game_iraks` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_loteria
-- ----------------------------
CREATE TABLE `game_loteria` (
  `ID` int(11) NOT NULL,
  `user` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tickets` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for game_lunas
-- ----------------------------
CREATE TABLE `game_lunas` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_luna` int(11) NOT NULL DEFAULT '0',
  `name` varchar(11) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL DEFAULT 'Lune',
  `image` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT 'mond',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `id_owner` int(11) DEFAULT NULL,
  `galaxy` int(11) DEFAULT NULL,
  `system` int(11) DEFAULT NULL,
  `lunapos` int(11) DEFAULT NULL,
  `temp_min` int(11) NOT NULL DEFAULT '0',
  `temp_max` int(11) NOT NULL DEFAULT '0',
  `diameter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for game_messages
-- ----------------------------
CREATE TABLE `game_messages` (
  `message_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) NOT NULL DEFAULT '0',
  `message_sender` int(11) NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` int(11) NOT NULL DEFAULT '0',
  `message_from` varchar(48) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `message_subject` varchar(48) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `message_text` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `visible` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_notes
-- ----------------------------
CREATE TABLE `game_notes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_planets
-- ----------------------------
CREATE TABLE `game_planets` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `id_level` int(11) NOT NULL DEFAULT '0',
  `galaxy` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` int(11) NOT NULL DEFAULT '1',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `b_building` int(11) NOT NULL DEFAULT '0',
  `b_building_id` text CHARACTER SET latin1 NOT NULL,
  `b_tech` int(11) NOT NULL DEFAULT '0',
  `b_tech_id` int(11) NOT NULL DEFAULT '0',
  `b_hangar` int(11) NOT NULL DEFAULT '0',
  `b_hangar_id` text CHARACTER SET latin1 NOT NULL,
  `b_hangar_plus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'normaltempplanet01',
  `diameter` int(11) NOT NULL DEFAULT '12800',
  `points` bigint(20) DEFAULT '0',
  `ranks` bigint(20) DEFAULT '0',
  `field_current` int(11) NOT NULL DEFAULT '0',
  `field_max` int(11) NOT NULL DEFAULT '163',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
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
  `titan` bigint(11) NOT NULL DEFAULT '0',
  `battleship` bigint(11) NOT NULL DEFAULT '0',
  `supernova` bigint(11) NOT NULL DEFAULT '0',
  `misil_launcher` bigint(11) NOT NULL DEFAULT '0',
  `small_laser` bigint(11) NOT NULL DEFAULT '0',
  `big_laser` bigint(11) NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(11) NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(11) NOT NULL DEFAULT '0',
  `buster_canyon` bigint(11) NOT NULL DEFAULT '0',
  `small_protection_shield` int(11) NOT NULL DEFAULT '0',
  `big_protection_shield` int(11) NOT NULL DEFAULT '0',
  `planet_protector` int(11) NOT NULL DEFAULT '0',
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
  `arraki` int(255) NOT NULL DEFAULT '0',
  `mother_ship` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for game_rw
-- ----------------------------
CREATE TABLE `game_rw` (
  `id_owner1` int(11) NOT NULL DEFAULT '0',
  `id_owner2` int(11) NOT NULL DEFAULT '0',
  `rid` varchar(72) NOT NULL DEFAULT '',
  `raport` text NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_statpoints
-- ----------------------------
CREATE TABLE `game_statpoints` (
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

-- ----------------------------
-- Table structure for game_supp
-- ----------------------------
CREATE TABLE `game_supp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_time
-- ----------------------------
CREATE TABLE `game_time` (
  `soort` varchar(255) DEFAULT NULL,
  `beurt` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_topkb
-- ----------------------------
CREATE TABLE `game_topkb` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_owner1` bigint(20) NOT NULL DEFAULT '0',
  `angreifer` varchar(64) NOT NULL DEFAULT '',
  `id_owner2` bigint(20) NOT NULL DEFAULT '0',
  `defender` varchar(64) NOT NULL DEFAULT '',
  `gesamtunits` bigint(20) NOT NULL DEFAULT '0',
  `gesamttruemmer` bigint(20) NOT NULL DEFAULT '0',
  `rid` varchar(72) NOT NULL DEFAULT '',
  `raport` text NOT NULL,
  `fleetresult` varchar(64) NOT NULL DEFAULT '',
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_users
-- ----------------------------
CREATE TABLE `game_users` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
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
  `user_lastip` varchar(16) NOT NULL DEFAULT '',
  `user_agent` text NOT NULL,
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
  `interalliance_tech` int(11) NOT NULL DEFAULT '0',
  `graviton_tech` int(11) NOT NULL DEFAULT '0',
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
  `rpg_points` int(11) NOT NULL DEFAULT '0',
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
  `mnl_buildlist` int(11) NOT NULL DEFAULT '0',
  `bana` int(11) DEFAULT NULL,
  `urlaubs_modus_time` int(11) NOT NULL DEFAULT '0',
  `deltime` int(11) NOT NULL DEFAULT '0',
  `aktywnosc` varchar(255) NOT NULL DEFAULT '',
  `kod_aktywujacy` varchar(255) NOT NULL DEFAULT '',
  `kiler` varchar(255) NOT NULL DEFAULT '',
  `time_aktyw` int(11) NOT NULL DEFAULT '0',
  `ataker` int(11) NOT NULL DEFAULT '0',
  `atakin` int(11) NOT NULL DEFAULT '0',
  `banaday` int(11) DEFAULT NULL,
  `arraki` int(255) NOT NULL DEFAULT '0',
  `records` int(11) unsigned NOT NULL DEFAULT '0',
  `raids1` int(11) NOT NULL DEFAULT '0',
  `raidsdraw` int(11) NOT NULL DEFAULT '0',
  `raidswin` int(11) NOT NULL DEFAULT '0',
  `raidsloose` int(11) NOT NULL DEFAULT '0',
  `wons` bigint(20) NOT NULL DEFAULT '0',
  `loos` bigint(20) NOT NULL DEFAULT '0',
  `draws` bigint(20) NOT NULL DEFAULT '0',
  `kbmetal` bigint(20) NOT NULL DEFAULT '0',
  `kbcrystal` bigint(20) NOT NULL DEFAULT '0',
  `lostunits` bigint(20) NOT NULL DEFAULT '0',
  `desunits` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for game_vacation
-- ----------------------------
CREATE TABLE `game_vacation` (
  `id_owner` int(11) DEFAULT NULL,
  `id` bigint(11) NOT NULL DEFAULT '0',
  `metal_perhour` int(11) NOT NULL DEFAULT '0',
  `crystal_perhour` int(11) NOT NULL DEFAULT '0',
  `deuterium_perhour` int(11) NOT NULL DEFAULT '0',
  `energy_used` int(11) NOT NULL DEFAULT '0',
  `energy_max` int(11) NOT NULL DEFAULT '0',
  `metal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `crystal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `fusion_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_satelit_porcent` int(11) NOT NULL DEFAULT '10',
  `planet_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `game_config` VALUES ('users_amount', '1');
INSERT INTO `game_config` VALUES ('game_speed', '2500');
INSERT INTO `game_config` VALUES ('fleet_speed', '25000');
INSERT INTO `game_config` VALUES ('resource_multiplier', '2');
INSERT INTO `game_config` VALUES ('Fleet_Cdr', '30');
INSERT INTO `game_config` VALUES ('Defs_Cdr', '30');
INSERT INTO `game_config` VALUES ('initial_fields', '175');
INSERT INTO `game_config` VALUES ('COOKIE_NAME', 'RogueUni');
INSERT INTO `game_config` VALUES ('game_name', 'Rogue Universe');
INSERT INTO `game_config` VALUES ('game_disable', '0');
INSERT INTO `game_config` VALUES ('close_reason', '');
INSERT INTO `game_config` VALUES ('metal_basic_income', '20');
INSERT INTO `game_config` VALUES ('crystal_basic_income', '10');
INSERT INTO `game_config` VALUES ('deuterium_basic_income', '0');
INSERT INTO `game_config` VALUES ('energy_basic_income', '0');
INSERT INTO `game_config` VALUES ('BuildLabWhileRun', '0');
INSERT INTO `game_config` VALUES ('LastSettedGalaxyPos', '3');
INSERT INTO `game_config` VALUES ('LastSettedSystemPos', '210');
INSERT INTO `game_config` VALUES ('LastSettedPlanetPos', '3');
INSERT INTO `game_config` VALUES ('urlaubs_modus_erz', '0');
INSERT INTO `game_config` VALUES ('noobprotection', '0');
INSERT INTO `game_config` VALUES ('noobprotectiontime', '400');
INSERT INTO `game_config` VALUES ('noobprotectionmulti', '5');
INSERT INTO `game_config` VALUES ('forum_url', 'http://YOUR.SITE.COM/forum');
INSERT INTO `game_config` VALUES ('OverviewNewsFrame', '1');
INSERT INTO `game_config` VALUES ('OverviewNewsText', 'Welcome to Rogue Universe');
INSERT INTO `game_config` VALUES ('OverviewExternChat', '1');
INSERT INTO `game_config` VALUES ('OverviewExternChatCmd', '');
INSERT INTO `game_config` VALUES ('OverviewBanner', '1');
INSERT INTO `game_config` VALUES ('OverviewClickBanner', '');
INSERT INTO `game_config` VALUES ('debug', '0');
INSERT INTO `game_config` VALUES ('updatingfleet', '1231412531');
INSERT INTO `game_config` VALUES ('users_checking', 'N;');
INSERT INTO `game_config` VALUES ('last_checkuser', '1231412527');
INSERT INTO `game_config` VALUES ('ForumBannerFrame', '1');
INSERT INTO `game_config` VALUES ('banner_source_post', '../images/bann.png');
INSERT INTO `game_config` VALUES ('Loteria', '1232306575');
INSERT INTO `game_galaxy` VALUES ('1', '1', '1', '1', '0', '0', '0', '0');
INSERT INTO `game_planets` VALUES ('1', 'Admin', '1', '3', '1', '1', '1', '1232315587', '1', '0', '0', '0', '0', '0', '0', '', '0', 'trockenplanet04', '12450', '0', '0', '0', '175', '11', '51', '1276.66666661', '20', '2500000', '1138.33333329', '10', '2500000', '1000.00000000', '0', '2500000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '10', '10', '10', '10', '10', '10', '0', '0', '0', '0', '0', '0');
INSERT INTO `game_supp` VALUES ('1', '1', '1231762250', 'test', 'testar', '0');
INSERT INTO `game_supp` VALUES ('2', '1', '1231763507', 'test2', 'sad sa dsad sa da', '0');
INSERT INTO `game_time` VALUES ('time', '1');
INSERT INTO `game_users` VALUES ('1', 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'admin@gmail.com', 'en', '3', 'M', '', null, '1', '1', '1', '1', '1', '192.168.1.20', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; sv-SE; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5', '1214239919', '1232315590', '', '1', '1', '0', '0', '1', '5', '0', '0', '1', '1', '1', '1', '0', '0', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', null, '0', '0', '0', 'red', '#00FF00', 'yellow', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '0', '0', '', '', '', '0', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
