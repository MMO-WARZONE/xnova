<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-2010, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

/**
 * @var Legacies_Setup $setup
 */
$setup = $this;

$setup->beginSetup();

$oldConfig = include ROOT_PATH . 'config.php';

$newConfig = array(
    'global' => array(
        'database' => array(
            'core_default' => array(
                'engine' => 'Mysql4',
                'params' => array(
                    'host'             => NULL,
                    'username'         => NULL,
                    'password'         => NULL,
                    'dbname'           => NULL
                    ),
                'table_prefix' => NULL,
                ),
            'core_read' => array(
                'use' => 'core_default'
                ),
            'core_write' => array(
                'use' => 'core_default'
                ),
            'core_setup' => array(
                'use' => 'core_default'
                )
            )
        ),
    'entities' => array(
        'deprecated' => array(
            'aks'        => 'aks',
            'alliance'   => 'alliance',
            'annonce'    => 'annonce',
            'banned'     => 'banned',
            'buddy'      => 'buddy',
            'chat'       => 'chat',
            'config'     => 'config',
            'declared'   => 'declared',
            'errors'     => 'errors',
            'fleets'     => 'fleets',
            'galaxy'     => 'galaxy',
            'iraks'      => 'iraks',
            'lunas'      => 'lunas',
            'messages'   => 'messages',
            'multi'      => 'multi',
            'notes'      => 'notes',
            'planets'    => 'planets',
            'rw'         => 'rw',
            'statpoints' => 'statpoints',
            'users'      => 'users'
            ),
        'user' => array(
            'entity'     => 'user_entity',
            'session'    => 'user_session',
            'auth'       => 'user_auth',
            'log'        => 'user_log',
            'options'    => 'user_options',
            'group_link' => 'user_group_link',
            'group'      => 'user_group'
            ),
        'acl' => array(
            'role'            => 'acl_role',
            'role_group_link' => 'acl_role_group_link',
            'resource'        => 'acl_resource'
            ),
        'alliance' => array(
            'entity'     => 'alliance_entity',
            'group_link' => 'alliance_group_link'
            ),
        'empire' => array(
            'planet_building_queue' => 'empire_planet_building_queue',
            'technologies'          => 'user_technologies',
            'stats'                 => 'user_stats'
            )
        )
    );

file_put_contents(ROOT_PATH . 'config.php', "<?php\nreturn " . var_export($newConfig, true) . ';');

$sqlStructure =<<<EOF
SET FOREIGN_KEY_CHECKS=0
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `{$setup->getTable('deprecated/aks')}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/alliance')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `ally_name` varchar(32) CHARACTER SET latin1 DEFAULT '',
  `ally_tag` varchar(8) CHARACTER SET latin1 DEFAULT '',
  `ally_owner` int(11) NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_description` text CHARACTER SET latin1,
  `ally_web` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `ally_text` text CHARACTER SET latin1,
  `ally_image` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `ally_request` text CHARACTER SET latin1,
  `ally_request_waiting` text CHARACTER SET latin1,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT '0',
  `ally_owner_range` varchar(32) CHARACTER SET latin1 DEFAULT '',
  `ally_ranks` text CHARACTER SET latin1,
  `ally_members` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/annonce')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `galaxie` int(11) NOT NULL,
  `systeme` int(11) NOT NULL,
  `metala` bigint(11) NOT NULL,
  `cristala` bigint(11) NOT NULL,
  `deuta` bigint(11) NOT NULL,
  `metals` bigint(11) NOT NULL,
  `cristals` bigint(11) NOT NULL,
  `deuts` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/banned')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `theme` text CHARACTER SET latin1 NOT NULL,
  `who2` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  KEY `ID` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/buddy')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET latin1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/chat')}` (
  `messageid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `message` text COLLATE utf8_bin NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/config')}` (
  `config_name` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `config_value` text CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/declared')}` (
  `declarator` text COLLATE utf8_bin NOT NULL,
  `declared_1` text COLLATE utf8_bin NOT NULL,
  `declared_2` text COLLATE utf8_bin NOT NULL,
  `declared_3` text COLLATE utf8_bin NOT NULL,
  `reason` text COLLATE utf8_bin NOT NULL,
  `declarator_name` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/errors')}` (
  `error_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `error_sender` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `error_time` int(11) NOT NULL DEFAULT '0',
  `error_type` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'unknown',
  `error_text` text CHARACTER SET latin1,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/fleets')}` (
  `fleet_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `fleet_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_mission` int(11) NOT NULL DEFAULT '0',
  `fleet_amount` bigint(11) NOT NULL DEFAULT '0',
  `fleet_array` text CHARACTER SET latin1,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/galaxy')}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/iraks')}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/lunas')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_luna` int(11) NOT NULL DEFAULT '0',
  `name` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT 'Lune',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/messages')}` (
  `message_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) NOT NULL DEFAULT '0',
  `message_sender` int(11) NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` int(11) NOT NULL DEFAULT '0',
  `message_from` varchar(48) CHARACTER SET latin1 DEFAULT NULL,
  `message_subject` varchar(48) CHARACTER SET latin1 DEFAULT NULL,
  `message_text` text CHARACTER SET latin1,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/multi')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player` bigint(11) unsigned NOT NULL,
  `sharer` bigint(11) unsigned NOT NULL,
  `reason` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/notes')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `text` text CHARACTER SET latin1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/planets')}` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL,
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
  `dearth_star` bigint(11) NOT NULL DEFAULT '0',
  `battleship` bigint(11) NOT NULL DEFAULT '0',
  `misil_launcher` bigint(11) NOT NULL DEFAULT '0',
  `small_laser` bigint(11) NOT NULL DEFAULT '0',
  `big_laser` bigint(11) NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(11) NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(11) NOT NULL DEFAULT '0',
  `buster_canyon` bigint(11) NOT NULL DEFAULT '0',
  `small_protection_shield` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `big_protection_shield` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/rw')}` (
  `id_owner1` int(11) NOT NULL DEFAULT '0',
  `id_owner2` int(11) NOT NULL DEFAULT '0',
  `rid` varchar(72) CHARACTER SET latin1 NOT NULL,
  `raport` text CHARACTER SET latin1 NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/statpoints')}` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `{$setup->getTable('deprecated/users')}` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `password` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email_2` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `lang` varchar(8) CHARACTER SET latin1 NOT NULL DEFAULT 'fr',
  `authlevel` tinyint(4) NOT NULL DEFAULT '0',
  `sex` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `sign` text CHARACTER SET latin1,
  `id_planet` int(11) NOT NULL DEFAULT '0',
  `galaxy` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `current_planet` int(11) NOT NULL DEFAULT '0',
  `user_lastip` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `ip_at_reg` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `user_agent` text CHARACTER SET latin1 NOT NULL,
  `current_page` text CHARACTER SET latin1 NOT NULL,
  `register_time` int(11) NOT NULL DEFAULT '0',
  `onlinetime` int(11) NOT NULL DEFAULT '0',
  `dpath` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
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
  `fleet_shortcut` text CHARACTER SET latin1,
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
  `ally_id` int(11) NOT NULL DEFAULT '0',
  `ally_name` varchar(32) CHARACTER SET latin1 DEFAULT '',
  `ally_request` int(11) NOT NULL DEFAULT '0',
  `ally_request_text` text CHARACTER SET latin1,
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank_id` int(11) NOT NULL DEFAULT '0',
  `current_luna` int(11) NOT NULL DEFAULT '0',
  `kolorminus` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT 'red',
  `kolorplus` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '#00FF00',
  `kolorpoziom` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT 'yellow',
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
  `mnl_alliance` int(11) NOT NULL,
  `mnl_joueur` int(11) NOT NULL,
  `mnl_attaque` int(11) NOT NULL,
  `mnl_spy` int(11) NOT NULL,
  `mnl_exploit` int(11) NOT NULL,
  `mnl_transport` int(11) NOT NULL,
  `mnl_expedition` int(11) NOT NULL,
  `mnl_general` int(11) NOT NULL,
  `mnl_buildlist` int(11) NOT NULL,
  `bana` int(11) DEFAULT NULL,
  `multi_validated` int(11) DEFAULT NULL,
  `banaday` int(11) DEFAULT NULL,
  `raids1` int(11) DEFAULT NULL,
  `raidswin` int(11) DEFAULT NULL,
  `raidsloose` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


SET FOREIGN_KEY_CHECKS=1;

EOF;

$setup->exec($sqlStructure);

$configData = array(
    'users_amount' => '5',
    'game_speed' => '2500',
    'fleet_speed' => '2500',
    'resource_multiplier' => '1000',
    'Fleet_Cdr' => '30',
    'Defs_Cdr' => '0',
    'initial_fields' => '5000',
    'game_name' => 'XNova:Legacies',
    'game_disable' => '1',
    'close_reason' => 'Le jeu est clos pour le moment!',
    'metal_basic_income' => '20',
    'crystal_basic_income' => '10',
    'deuterium_basic_income' => '0',
    'energy_basic_income' => '0',
    'BuildLabWhileRun' => '0',
    'LastSettedGalaxyPos' => '1',
    'LastSettedSystemPos' => '1',
    'LastSettedPlanetPos' => '1',
    'urlaubs_modus_erz' => '1',
    'noobprotection' => '1',
    'noobprotectiontime' => '5000',
    'noobprotectionmulti' => '5',
    'forum_url' => 'http://board.xnova-ng.org/',
    'OverviewNewsFrame' => '1',
    'OverviewNewsText' => 'Bienvenue sur le nouveau serveur XNova:Legacies',
    'OverviewExternChat' => '0',
    'OverviewExternChatCmd' => '',
    'OverviewBanner' => '0',
    'OverviewClickBanner' => '',
    'ExtCopyFrame' => '0',
    'ExtCopyOwner' => '',
    'ExtCopyFunct' => '',
    'ForumBannerFrame' => '0',
    'stat_settings' => '1000',
    'link_enable' => '0',
    'link_name' => '',
    'link_url' => '',
    'enable_announces' => '1',
    'enable_marchand' => '1',
    'enable_notes' => '1',
    'bot_name' => 'XNoviana Reali',
    'bot_adress' => 'nobody@example.net',
    'banner_source_post' => '../images/bann.png',
    'ban_duration' => '30',
    'enable_bot' => '0',
    'enable_bbcode' => '1',
    'debug' => '0'
    );

$setup->insert($setup->getTable('deprecated/config'), $configData);

$setup->endSetup();
