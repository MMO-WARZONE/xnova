-- Datenbank fuer eine frische Installation.
-- License: <http://www.gnu.org/licenses/gpl.txt> GNU/GPL
-- Version: Xnova-Reloaded 0.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `bla`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_aks`
--

CREATE TABLE IF NOT EXISTS `PREFIX_aks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `teilnehmer` text,
  `flotten` text,
  `ankunft` int(32) DEFAULT NULL,
  `galaxy` int(2) DEFAULT NULL,
  `system` int(4) DEFAULT NULL,
  `planet` int(2) DEFAULT NULL,
  `eingeladen` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_aks`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_alliance`
--

CREATE TABLE IF NOT EXISTS `PREFIX_alliance` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_alliance`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_banned`
--

CREATE TABLE IF NOT EXISTS `PREFIX_banned` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(11) NOT NULL DEFAULT '',
  `theme` text NOT NULL,
  `who2` varchar(11) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(11) NOT NULL DEFAULT '',
  `email` varchar(20) NOT NULL DEFAULT '',
  KEY `ID` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_banned`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_buddy`
--

CREATE TABLE IF NOT EXISTS `PREFIX_buddy` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_buddy`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_config`
--

CREATE TABLE IF NOT EXISTS `PREFIX_config` (
  `config_name` varchar(64) NOT NULL DEFAULT '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `PREFIX_config`
--

INSERT INTO `PREFIX_config` (`config_name`, `config_value`) VALUES
('game_speed', '1'),
('fleet_speed', '1'),
('resource_multiplier', '1'),
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('initial_fields', '230'),
('COOKIE_NAME', 'XNova'),
('game_name', 'XNova-Reloaded'),
('game_disable', '0'),
('close_reason', 'Dieses Game ist zuzeit Geschlossen !'),
('metal_basic_income', '30'),
('crystal_basic_income', '15'),
('deuterium_basic_income', '0'),
('energy_basic_income', '0'),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '1'),
('LastSettedPlanetPos', '1'),
('urlaubs_modus_erz', '1'),
('noobprotection', '1'),
('noobprotectiontime', '5000'),
('noobprotectionmulti', '5'),
('forum_url', 'http://www.xnova-reloaded.de/'),
('OverviewNewsFrame', '1'),
('OverviewNewsText', 'Willkommen bei Xnova-Reloaded'),
('LoginNewsFrame', '0'),
('LoginNewsText', ''),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', ''),
('debug', '0'),
('adminmail', 'noreply@deingame.tdl'),
('max_galaxy_in_world', '10'),
('max_system_in_galaxy', '300'),
('max_planet_in_system', '15'),
('spy_report_row', '1'),
('fields_by_moonbasis_level', '4'),
('max_player_planets', '10'),
('max_building_queue_size', '5'),
('max_fleet_or_defs_per_row', '5000'),
('max_overflow', '1'),
('base_storage_size', '100000'),
('build_metal', '800'),
('build_cristal', '500'),
('build_deuterium', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_errors`
--

CREATE TABLE IF NOT EXISTS `PREFIX_errors` (
  `error_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `error_sender` varchar(32) NOT NULL DEFAULT '0',
  `error_time` int(11) NOT NULL DEFAULT '0',
  `error_type` varchar(32) NOT NULL DEFAULT 'unknown',
  `error_text` text,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_errors`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_fleets`
--

CREATE TABLE IF NOT EXISTS `PREFIX_fleets` (
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
  PRIMARY KEY (`fleet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_fleets`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_galaxy`
--

CREATE TABLE IF NOT EXISTS `PREFIX_galaxy` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `PREFIX_galaxy`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_iraks`
--

CREATE TABLE IF NOT EXISTS `PREFIX_iraks` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_iraks`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_lunas`
--

CREATE TABLE IF NOT EXISTS `PREFIX_lunas` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_luna` int(11) NOT NULL DEFAULT '0',
  `name` varchar(11) NOT NULL DEFAULT 'Mond',
  `image` varchar(11) DEFAULT NULL,
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `id_owner` int(11) DEFAULT NULL,
  `galaxy` int(11) DEFAULT NULL,
  `system` int(11) DEFAULT NULL,
  `lunapos` int(11) DEFAULT NULL,
  `temp_min` int(11) NOT NULL DEFAULT '0',
  `temp_max` int(11) NOT NULL DEFAULT '0',
  `diameter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_lunas`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_messages`
--

CREATE TABLE IF NOT EXISTS `PREFIX_messages` (
  `message_id` bigint(12) unsigned NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) unsigned NOT NULL DEFAULT '0',
  `message_sender` int(11) unsigned NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `message_from` varchar(64) DEFAULT NULL,
  `message_subject` varchar(64) DEFAULT NULL,
  `message_text` text,
  `message_class` int(11) unsigned NOT NULL DEFAULT '0',
  `message_melden` int(11) unsigned NOT NULL DEFAULT '0',
  `message_melden_grund` text NOT NULL,
  `message_melden_time` int(11) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_messages`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_notes`
--

CREATE TABLE IF NOT EXISTS `PREFIX_notes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_notes`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_planets`
--

CREATE TABLE IF NOT EXISTS `PREFIX_planets` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `id_level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `galaxy` int(4) unsigned NOT NULL DEFAULT '0',
  `system` int(4) unsigned NOT NULL DEFAULT '0',
  `planet` int(4) unsigned NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `destruyed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `b_building` int(11) unsigned NOT NULL DEFAULT '0',
  `b_building_id` text NOT NULL,
  `b_tech` int(11) unsigned NOT NULL DEFAULT '0',
  `b_tech_id` int(11) unsigned NOT NULL DEFAULT '0',
  `b_hangar` int(11) unsigned NOT NULL DEFAULT '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) unsigned NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'planet_01',
  `diameter` int(11) unsigned NOT NULL DEFAULT '12800',
  `points` bigint(20) unsigned DEFAULT '0',
  `ranks` bigint(20) unsigned DEFAULT '0',
  `field_current` int(11) unsigned NOT NULL DEFAULT '0',
  `field_max` int(5) unsigned NOT NULL DEFAULT '230',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
  `metal` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `metal_perhour` int(11) unsigned NOT NULL DEFAULT '0',
  `metal_max` bigint(20) unsigned DEFAULT '100000',
  `crystal` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `crystal_perhour` int(11) unsigned NOT NULL DEFAULT '0',
  `crystal_max` bigint(20) unsigned DEFAULT '100000',
  `deuterium` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `deuterium_perhour` int(11) unsigned NOT NULL DEFAULT '0',
  `deuterium_max` bigint(20) unsigned DEFAULT '100000',
  `energy_used` int(11) NOT NULL DEFAULT '0',
  `energy_max` int(11) unsigned NOT NULL DEFAULT '0',
  `metal_mine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `crystal_mine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deuterium_sintetizer` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `solar_plant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fusion_plant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `robot_factory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `nano_factory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hangar` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `metal_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `crystal_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deuterium_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `laboratory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `terraformer` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ally_deposit` tinyint(11) unsigned NOT NULL DEFAULT '0',
  `silo` tinyint(11) unsigned NOT NULL DEFAULT '0',
  `small_ship_cargo` bigint(11) unsigned NOT NULL DEFAULT '0',
  `big_ship_cargo` bigint(11) unsigned NOT NULL DEFAULT '0',
  `light_hunter` bigint(11) unsigned NOT NULL DEFAULT '0',
  `heavy_hunter` bigint(11) unsigned NOT NULL DEFAULT '0',
  `crusher` bigint(11) unsigned NOT NULL DEFAULT '0',
  `battle_ship` bigint(11) unsigned NOT NULL DEFAULT '0',
  `colonizer` bigint(11) unsigned NOT NULL DEFAULT '0',
  `recycler` bigint(11) unsigned NOT NULL DEFAULT '0',
  `spy_sonde` bigint(11) unsigned NOT NULL DEFAULT '0',
  `bomber_ship` bigint(11) unsigned NOT NULL DEFAULT '0',
  `solar_satelit` bigint(11) unsigned NOT NULL DEFAULT '0',
  `destructor` bigint(11) unsigned NOT NULL DEFAULT '0',
  `dearth_star` bigint(11) unsigned NOT NULL DEFAULT '0',
  `battleship` bigint(11) unsigned NOT NULL DEFAULT '0',
  `misil_launcher` bigint(11) unsigned NOT NULL DEFAULT '0',
  `small_laser` bigint(11) unsigned NOT NULL DEFAULT '0',
  `big_laser` bigint(11) unsigned NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(11) unsigned NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(11) unsigned NOT NULL DEFAULT '0',
  `buster_canyon` bigint(11) unsigned NOT NULL DEFAULT '0',
  `small_protection_shield` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `big_protection_shield` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `interceptor_misil` int(11) unsigned NOT NULL DEFAULT '0',
  `interplanetary_misil` int(11) unsigned NOT NULL DEFAULT '0',
  `metal_mine_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `crystal_mine_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `solar_plant_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `fusion_plant_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `solar_satelit_porcent` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `mondbasis` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `phalanx` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sprungtor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_jump_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `PREFIX_planets`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_rw`
--

CREATE TABLE IF NOT EXISTS `PREFIX_rw` (
  `id_owner1` int(11) NOT NULL DEFAULT '0',
  `id_owner2` int(11) NOT NULL DEFAULT '0',
  `rid` varchar(72) NOT NULL,
  `raport` text NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `PREFIX_rw`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_statpoints`
--

CREATE TABLE IF NOT EXISTS `PREFIX_statpoints` (
  `id_owner` int(11) NOT NULL,
  `id_ally` int(11) NOT NULL,
  `stat_type` int(2) NOT NULL,
  `stat_code` int(11) NOT NULL,
  `tech_rank` int(11) NOT NULL,
  `tech_old_rank` int(11) NOT NULL,
  `tech_points` bigint(20) NOT NULL,
  `tech_count` int(11) NOT NULL,
  `build_rank` int(11) NOT NULL,
  `build_old_rank` int(11) NOT NULL,
  `build_points` bigint(20) NOT NULL,
  `build_count` int(11) NOT NULL,
  `defs_rank` int(11) NOT NULL,
  `defs_old_rank` int(11) NOT NULL,
  `defs_points` bigint(20) NOT NULL,
  `defs_count` int(11) NOT NULL,
  `fleet_rank` int(11) NOT NULL,
  `fleet_old_rank` int(11) NOT NULL,
  `fleet_points` bigint(20) NOT NULL,
  `fleet_count` int(11) NOT NULL,
  `total_rank` int(11) NOT NULL,
  `total_old_rank` int(11) NOT NULL,
  `total_points` bigint(20) NOT NULL,
  `total_count` int(11) NOT NULL,
  `stat_date` int(11) NOT NULL,
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `PREFIX_statpoints`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PREFIX_users`
--

CREATE TABLE IF NOT EXISTS `PREFIX_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `email_2` varchar(64) NOT NULL,
  `authlevel` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL DEFAULT 'images/DefaultAvatar.jpg',
  `id_planet` int(11) unsigned NOT NULL DEFAULT '0',
  `galaxy` int(4) unsigned NOT NULL DEFAULT '0',
  `system` int(4) unsigned NOT NULL DEFAULT '0',
  `planet` int(4) unsigned NOT NULL DEFAULT '0',
  `current_planet` int(11) unsigned NOT NULL DEFAULT '0',
  `user_lastip` varchar(16) NOT NULL,
  `user_agent` text NOT NULL,
  `register_time` int(11) NOT NULL DEFAULT '0',
  `onlinetime` int(11) NOT NULL DEFAULT '0',
  `planet_sort` tinyint(1) NOT NULL DEFAULT '0',
  `planet_sort_order` tinyint(1) NOT NULL DEFAULT '0',
  `spio_anz` tinyint(4) NOT NULL DEFAULT '1',
  `settings_tooltiptime` tinyint(4) NOT NULL DEFAULT '5',
  `settings_esp` tinyint(4) NOT NULL DEFAULT '1',
  `settings_wri` tinyint(4) NOT NULL DEFAULT '1',
  `settings_bud` tinyint(4) NOT NULL DEFAULT '1',
  `settings_mis` tinyint(4) NOT NULL DEFAULT '1',
  `urlaubs_modus` tinyint(4) NOT NULL DEFAULT '0',
  `db_deaktjava` tinyint(4) NOT NULL DEFAULT '0',
  `new_message` int(11) unsigned NOT NULL DEFAULT '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) unsigned NOT NULL DEFAULT '0',
  `spy_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `computer_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `military_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `defence_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `shield_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `energy_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hyperspace_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `combustion_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `impulse_motor_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hyperspace_motor_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `laser_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ionic_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `buster_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `intergalactic_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expedition_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `graviton_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ally_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ally_name` varchar(32) DEFAULT NULL,
  `ally_request` int(11) unsigned NOT NULL DEFAULT '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank_id` int(11) NOT NULL DEFAULT '0',
  `current_luna` int(11) unsigned NOT NULL DEFAULT '0',
  `rpg_geologue` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_amiral` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_ingenieur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_technocrate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_espion` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_constructeur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_scientifique` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_commandant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_points` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_stockeur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_defenseur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_destructeur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_general` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_bunker` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_raideur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_empereur` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lvl_minier` int(11) unsigned NOT NULL DEFAULT '1',
  `lvl_raid` int(11) unsigned NOT NULL DEFAULT '1',
  `xpraid` int(11) unsigned NOT NULL DEFAULT '0',
  `xpminier` int(11) unsigned NOT NULL DEFAULT '0',
  `raids` bigint(20) unsigned NOT NULL DEFAULT '0',
  `p_infligees` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mnl_alliance` int(11) unsigned NOT NULL,
  `mnl_joueur` int(11) unsigned NOT NULL,
  `mnl_attaque` int(11) unsigned NOT NULL,
  `mnl_spy` int(11) unsigned NOT NULL,
  `mnl_exploit` int(11) unsigned NOT NULL,
  `mnl_transport` int(11) unsigned NOT NULL,
  `mnl_expedition` int(11) unsigned NOT NULL,
  `mnl_buildlist` int(11) unsigned NOT NULL,
  `bana` int(11) DEFAULT NULL,
  `urlaubs_modus_time` int(11) NOT NULL DEFAULT '0',
  `deltime` int(11) NOT NULL DEFAULT '0',
  `aktywnosc` varchar(255) NOT NULL,
  `kod_aktywujacy` varchar(255) NOT NULL,
  `kiler` varchar(255) NOT NULL,
  `time_aktyw` int(11) NOT NULL DEFAULT '0',
  `ataker` int(11) NOT NULL DEFAULT '0',
  `atakin` int(11) NOT NULL DEFAULT '0',
  `banaday` int(11) DEFAULT NULL,
  `angriffszone` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;