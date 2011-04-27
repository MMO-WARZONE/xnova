<?php
/**
 *
 * @package XNova
 * @version databaseinfos.php 0.8
 * @copyright 2008 By Chlorel, XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('INSIDE'))
{
	die();
}


// Definition des tables d'XNova
//
	// Table aks
	$QryTableAks         = "CREATE TABLE `{{table}}` ( ";
	$QryTableAks        .= "`id` bigint(20) unsigned NOT NULL auto_increment, ";
	$QryTableAks        .= "`name` varchar(50) collate latin1_general_ci default NULL, ";
	$QryTableAks        .= "`teilnehmer` text collate latin1_general_ci, ";
	$QryTableAks        .= "`flotten` text collate latin1_general_ci, ";
	$QryTableAks        .= "`ankunft` int(32) default NULL, ";
	$QryTableAks        .= "`galaxy` int(2) default NULL, ";
	$QryTableAks        .= "`system` int(4) default NULL, ";
	$QryTableAks        .= "`planet` int(2) default NULL, ";
	$QryTableAks        .= "`eingeladen` int(11) default NULL, ";
	$QryTableAks        .= "PRIMARY KEY  (`id`) ";
	$QryTableAks        .= ") ENGINE=MyISAM;";

	// Table annonce
	$QryTableAnnonce     = "CREATE TABLE `{{table}}` ( ";
	$QryTableAnnonce    .= "`id` int(11) NOT NULL auto_increment, ";
	$QryTableAnnonce    .= "`user` text collate latin1_general_ci NOT NULL, ";
	$QryTableAnnonce    .= "`galaxie` int(11) NOT NULL, ";
	$QryTableAnnonce    .= "`systeme` int(11) NOT NULL, ";
	$QryTableAnnonce    .= "`metala` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "`cristala` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "`deuta` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "`metals` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "`cristals` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "`deuts` bigint(11) NOT NULL, ";
	$QryTableAnnonce    .= "PRIMARY KEY  (`id`) ";
	$QryTableAnnonce    .= ") ENGINE=MyISAM;";

	// Table alliance
	$QryTableAlliance    = "CREATE TABLE `{{table}}` ( ";
	$QryTableAlliance   .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableAlliance   .= "`ally_name` varchar(32) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_tag` varchar(8) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_owner` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_register_time` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_description` text character set latin1, ";
	$QryTableAlliance   .= "`ally_web` varchar(255) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_text` text character set latin1, ";
	$QryTableAlliance   .= "`ally_image` varchar(255) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_request` text character set latin1, ";
	$QryTableAlliance   .= "`ally_request_waiting` text character set latin1, ";
	$QryTableAlliance   .= "`ally_request_notallow` tinyint(4) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_owner_range` varchar(32) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_ranks` text character set latin1, ";
	$QryTableAlliance   .= "`ally_members` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "PRIMARY KEY  (`id`) ";
	$QryTableAlliance   .= ") ENGINE=MyISAM;";

	// Table banned
	$QryTableBanned      = "CREATE TABLE `{{table}}` ( ";
	$QryTableBanned     .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableBanned     .= "`who` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`theme` text character set latin1 NOT NULL, ";
	$QryTableBanned     .= "`who2` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`time` int(11) NOT NULL default '0', ";
	$QryTableBanned     .= "`longer` int(11) NOT NULL default '0', ";
	$QryTableBanned     .= "`author` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`email` varchar(20) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "KEY `ID` (`id`) ";
	$QryTableBanned     .= ") ENGINE=MyISAM;";

	// Table buddy
	$QryTableBuddy       = "CREATE TABLE `{{table}}` ( ";
	$QryTableBuddy      .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableBuddy      .= "`sender` int(11) NOT NULL default '0', ";
	$QryTableBuddy      .= "`owner` int(11) NOT NULL default '0', ";
	$QryTableBuddy      .= "`active` tinyint(3) NOT NULL default '0', ";
	$QryTableBuddy      .= "`text` text character set latin1, ";
	$QryTableBuddy      .= "PRIMARY KEY  (`id`) ";
	$QryTableBuddy      .= ") ENGINE=MyISAM;";

	// Table chat
	$QryTableChat        = "CREATE TABLE `{{table}}` ( ";
	$QryTableChat       .= "`messageid` int(5) unsigned NOT NULL auto_increment, ";
	$QryTableChat       .= "`user` varchar(255) NOT NULL default '', ";
	$QryTableChat       .= "`message` text NOT NULL, ";
	$QryTableChat       .= "`timestamp` int(11) NOT NULL default '0', ";
	$QryTableChat       .= "PRIMARY KEY  (`messageid`) ";
	$QryTableChat       .= ") ENGINE=MyISAM;";

	// Table config
	$QryTableConfig      = "CREATE TABLE `{{table}}` ( ";
	$QryTableConfig     .= "`config_name` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableConfig     .= "`config_value` text character set latin1 NOT NULL ";
	$QryTableConfig     .= ") ENGINE=MyISAM;";

	// Valeurs de base de la config
	$QryInsertConfig     = "INSERT INTO `{{table}}` ";
	$QryInsertConfig    .= "(`config_name`           , `config_value`) VALUES ";
	$QryInsertConfig    .= "('users_amount'          , '0'), ";
	$QryInsertConfig    .= "('game_speed'            , '2500'), ";
	$QryInsertConfig    .= "('fleet_speed'           , '2500'), ";
	$QryInsertConfig    .= "('resource_multiplier'   , '1'), ";
	$QryInsertConfig    .= "('Fleet_Cdr'             , '30'), ";
	$QryInsertConfig    .= "('Defs_Cdr'              , '30'), ";
	$QryInsertConfig    .= "('initial_fields'        , '163'), ";
	$QryInsertConfig    .= "('COOKIE_NAME'           , 'XnovaNG'), ";
	$QryInsertConfig    .= "('game_name'             , ' NG Framework'), ";
	$QryInsertConfig    .= "('game_disable'          , '1'), ";
	$QryInsertConfig    .= "('close_reason'          , 'Closed!'), ";
	$QryInsertConfig    .= "('metal_basic_income'    , '20'), ";
	$QryInsertConfig    .= "('crystal_basic_income'  , '10'), ";
	$QryInsertConfig    .= "('deuterium_basic_income', '0'), ";
	$QryInsertConfig    .= "('energy_basic_income'   , '0'), ";
	$QryInsertConfig    .= "('BuildLabWhileRun'      , '0'), ";
	$QryInsertConfig    .= "('LastSettedGalaxyPos'   , '1'), ";
	$QryInsertConfig    .= "('LastSettedSystemPos'   , '8'), ";
	$QryInsertConfig    .= "('LastSettedPlanetPos'   , '3'), ";
	$QryInsertConfig    .= "('urlaubs_modus_erz'     , '1'), ";
	$QryInsertConfig    .= "('noobprotection'        , '1'), ";
	$QryInsertConfig    .= "('noobprotectiontime'    , '5000'), ";
	$QryInsertConfig    .= "('noobprotectionmulti'   , '5'), ";
	$QryInsertConfig    .= "('forum_url'             , 'http://www.teamrocket.info' ), ";
	$QryInsertConfig    .= "('OverviewNewsFrame'     , '1' ), ";
	$QryInsertConfig    .= "('OverviewNewsText'      , 'Welcome to Rocket Nova NG Framework' ), ";
	$QryInsertConfig    .= "('OverviewExternChat'    , '0' ), ";
	$QryInsertConfig    .= "('OverviewExternChatCmd' , '' ), ";
	$QryInsertConfig    .= "('OverviewBanner'        , '0' ), ";
	$QryInsertConfig    .= "('OverviewClickBanner'   , '' ), ";
	$QryInsertConfig    .= "('debug'                 , '0'), ";
	$QryInsertConfig    .= "('Loteria', '00000000'), ";
	$QryInsertConfig    .= "('configloteria', '12500|100|100|100|100|100'), ";
	$QryInsertConfig    .= "('configstats' , '1|1|1|1|1') ";
	$QryInsertConfig    .= ";";

	// Table errors
	$QryTableErrors      = "CREATE TABLE `{{table}}` ( ";
	$QryTableErrors     .= "`error_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableErrors     .= "`error_sender` varchar(32) character set latin1 NOT NULL default '0', ";
	$QryTableErrors     .= "`error_time` int(11) NOT NULL default '0', ";
	$QryTableErrors     .= "`error_type` varchar(32) character set latin1 NOT NULL default 'unknown', ";
	$QryTableErrors     .= "`error_text` text character set latin1, ";
	$QryTableErrors     .= "PRIMARY KEY  (`error_id`) ";
	$QryTableErrors     .= ") ENGINE=MyISAM;";

	// Table fleets
	$QryTableFleets      = "CREATE TABLE `{{table}}` ( ";
	$QryTableFleets     .= "`fleet_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableFleets     .= "`fleet_owner` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_mission` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_amount` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_array` text character set latin1, ";
	$QryTableFleets     .= "`fleet_start_time` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_system` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_planet` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_type` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_time` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_stay` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_system` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_planet` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_type` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_target_obj` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_metal` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_crystal` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_deuterium` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_target_owner` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_group` int (11) NOT NULL DEFAULT '0', ";
	$QryTableFleets     .= "`fleet_mess` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`start_time` int(11) default NULL, ";
	$QryTableFleets     .= "PRIMARY KEY  (`fleet_id`) ";
	$QryTableFleets     .= ") ENGINE=MyISAM;";

	// Table galaxy
	$QryTableGalaxy      = "CREATE TABLE `{{table}}` ( ";
	$QryTableGalaxy     .= "`galaxy` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`system` int(3) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`planet` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`id_planet` int(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`metal` bigint(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`crystal` bigint(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`id_luna` int(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`luna` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "KEY `galaxy` (`galaxy`), ";
	$QryTableGalaxy     .= "KEY `system` (`system`), ";
	$QryTableGalaxy     .= "KEY `planet` (`planet`) ";
	$QryTableGalaxy     .= ") ENGINE=MyISAM;";

	// Table iraks
	$QryTableIraks       = "CREATE TABLE `{{table}}` ( ";
	$QryTableIraks      .= "`id` bigint(20) unsigned NOT NULL auto_increment, ";
	$QryTableIraks      .= "`zeit` int(32) default NULL, ";
	$QryTableIraks      .= "`galaxy` int(2) default NULL, ";
	$QryTableIraks      .= "`system` int(4) default NULL, ";
	$QryTableIraks      .= "`planet` int(2) default NULL, ";
	$QryTableIraks      .= "`galaxy_angreifer` int(2) default NULL, ";
	$QryTableIraks      .= "`system_angreifer` int(4) default NULL, ";
	$QryTableIraks      .= "`planet_angreifer` int(2) default NULL, ";
	$QryTableIraks      .= "`owner` int(32) default NULL, ";
	$QryTableIraks      .= "`zielid` int(32) default NULL, ";
	$QryTableIraks      .= "`anzahl` int(32) default NULL, ";
	$QryTableIraks      .= "`primaer` int(32) default NULL, ";
	$QryTableIraks      .= "PRIMARY KEY  (`id`) ";
	$QryTableIraks      .= ") ENGINE=MyISAM;";

	// Table messages
	$QryTableMessages    = "CREATE TABLE `{{table}}` ( ";
	$QryTableMessages   .= "`message_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableMessages   .= "`message_owner` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_sender` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_time` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_type` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_from` varchar(48) character set latin1 default NULL, ";
	$QryTableMessages   .= "`message_subject` varchar(48) character set latin1 default NULL, ";
	$QryTableMessages   .= "`message_text` text character set latin1, ";
	$QryTableMessages   .= "PRIMARY KEY  (`message_id`) ";
	$QryTableMessages   .= ") ENGINE=MyISAM;";

	// Table notes
	$QryTableNotes       = "CREATE TABLE `{{table}}` ( ";
	$QryTableNotes      .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableNotes      .= "`owner` int(11) default NULL, ";
	$QryTableNotes      .= "`time` int(11) default NULL, ";
	$QryTableNotes      .= "`priority` tinyint(1) default NULL, ";
	$QryTableNotes      .= "`title` varchar(32) character set latin1 default NULL, ";
	$QryTableNotes      .= "`text` text character set latin1, ";
	$QryTableNotes      .= "PRIMARY KEY  (`id`) ";
	$QryTableNotes      .= ") ENGINE=MyISAM;";

	// Table planets
	$QryTablePlanets     = "CREATE TABLE `{{table}}` ( ";
	$QryTablePlanets    .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTablePlanets    .= "`name` varchar(255) character set latin1 default NULL, ";
	$QryTablePlanets    .= "`id_owner` int(11) default NULL, ";
	$QryTablePlanets    .= "`id_level` int(11) default NULL, ";
	$QryTablePlanets    .= "`galaxy` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`system` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`planet` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`last_update` int(11) default NULL, ";
	$QryTablePlanets    .= "`planet_type` int(11) NOT NULL default '1', ";
	$QryTablePlanets    .= "`destruyed` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`b_building` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`b_building_id` text character set latin1 NOT NULL, ";
	$QryTablePlanets    .= "`b_tech` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`b_tech_id` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`b_hangar` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`b_hangar_id` text character set latin1 NOT NULL, ";
	$QryTablePlanets    .= "`b_hangar_plus` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`image` varchar(32) character set latin1 NOT NULL default 'normaltempplanet01', ";
	$QryTablePlanets    .= "`diameter` int(11) NOT NULL default '12800', ";
	$QryTablePlanets    .= "`points` bigint(20) default '0', ";
	$QryTablePlanets    .= "`ranks` bigint(20) default '0', ";
	$QryTablePlanets    .= "`field_current` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`field_max` int(11) NOT NULL default '163', ";
	$QryTablePlanets    .= "`temp_min` int(3) NOT NULL default '-17', ";
	$QryTablePlanets    .= "`temp_max` int(3) NOT NULL default '23', ";
	$QryTablePlanets    .= "`metal` double(132,8) NOT NULL default '0.00000000', ";
	$QryTablePlanets    .= "`metal_perhour` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`metal_max` bigint(20) default '100000', ";
	$QryTablePlanets    .= "`crystal` double(132,8) NOT NULL default '0.00000000', ";
	$QryTablePlanets    .= "`crystal_perhour` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`crystal_max` bigint(20) default '100000', ";
	$QryTablePlanets    .= "`deuterium` double(132,8) NOT NULL default '0.00000000', ";
	$QryTablePlanets    .= "`deuterium_perhour` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`deuterium_max` bigint(20) default '100000', ";
	$QryTablePlanets    .= "`energy_used` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`energy_max` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`metal_mine` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`crystal_mine` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`deuterium_sintetizer` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`solar_plant` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`fusion_plant` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`robot_factory` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`nano_factory` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`hangar` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`metal_store` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`crystal_store` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`deuterium_store` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`laboratory` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`terraformer` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`ally_deposit` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`silo` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`small_ship_cargo` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`big_ship_cargo` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`light_hunter` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`heavy_hunter` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`crusher` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`battle_ship` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`colonizer` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`recycler` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`spy_sonde` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`bomber_ship` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`solar_satelit` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`destructor` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`dearth_star` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`battleship` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`misil_launcher` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`small_laser` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`big_laser` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`gauss_canyon` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`ionic_canyon` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`buster_canyon` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`small_protection_shield` ENUM('0','1') NOT NULL default '0', ";
	$QryTablePlanets    .= "`big_protection_shield` ENUM('0','1') NOT NULL default '0', ";
	$QryTablePlanets    .= "`interceptor_misil` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`interplanetary_misil` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`metal_mine_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`crystal_mine_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`deuterium_sintetizer_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`solar_plant_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`fusion_plant_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`solar_satelit_porcent` int(11) NOT NULL default '10', ";
	$QryTablePlanets    .= "`mondbasis` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`phalanx` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`sprungtor` bigint(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "`last_jump_time` int(11) NOT NULL default '0', ";
	$QryTablePlanets    .= "PRIMARY KEY  (`id`) ";
	$QryTablePlanets    .= ") ENGINE=MyISAM;";

	// Table rw
	$QryTableRw          = "CREATE TABLE `{{table}}` ( ";
	$QryTableRw         .= "`id_owner1` int(11) NOT NULL default '0', ";
	$QryTableRw         .= "`id_owner2` int(11) NOT NULL default '0', ";
	$QryTableRw         .= "`rid` varchar(72) character set latin1 NOT NULL, ";
	$QryTableRw         .= "`raport` text character set latin1 NOT NULL, ";
	$QryTableRw         .= "`a_zestrzelona` tinyint(3) unsigned NOT NULL default '0', ";
	$QryTableRw         .= "`time` int(10) unsigned NOT NULL default '0', ";
	$QryTableRw         .= "UNIQUE KEY `rid` (`rid`), ";
	$QryTableRw         .= "KEY `id_owner1` (`id_owner1`,`rid`), ";
	$QryTableRw         .= "KEY `id_owner2` (`id_owner2`,`rid`), ";
	$QryTableRw         .= "KEY `time` (`time`), ";
	$QryTableRw         .= "FULLTEXT KEY `raport` (`raport`) ";
	$QryTableRw         .= ") ENGINE=MyISAM;";

	// Table statpoints
	$QryTableStatPoints  = "CREATE TABLE `{{table}}` ( ";
	$QryTableStatPoints .= "`id_owner` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`id_ally` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`stat_type` int(2) NOT NULL, ";
	$QryTableStatPoints .= "`stat_code` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`tech_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`build_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`defs_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`total_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`stat_date` int(11) NOT NULL, ";
	$QryTableStatPoints .= "KEY `TECH` (`tech_points`), ";
	$QryTableStatPoints .= "KEY `BUILDS` (`build_points`), ";
	$QryTableStatPoints .= "KEY `DEFS` (`defs_points`), ";
	$QryTableStatPoints .= "KEY `FLEET` (`fleet_points`), ";
	$QryTableStatPoints .= "KEY `TOTAL` (`total_points`) ";
	$QryTableStatPoints .= ") ENGINE=MyISAM;";

	// Table users
	$QryTableUsers       = "CREATE TABLE `{{table}}` ( ";
	$QryTableUsers      .= "`id` bigint(11) unsigned NOT NULL auto_increment PRIMARY KEY, ";
	$QryTableUsers      .= "`username` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`password` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`email` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`email_2` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`lang` varchar(8) character set latin1 NOT NULL default 'es', ";
	$QryTableUsers      .= "`authlevel` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`sex` char(1) character set latin1 default NULL, ";
	$QryTableUsers      .= "`avatar` varchar(255) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`sign` text character set latin1, ";
	$QryTableUsers      .= "`id_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`galaxy` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`system` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`current_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`refer` varchar(64) NOT NULL,";
	$QryTableUsers      .= "`reg_ip` varchar(16) NOT NULL,";
	$QryTableUsers      .= "`user_lastip` varchar(16) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`user_agent` text character set latin1 NOT NULL, ";
	$QryTableUsers      .= "`register_time` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`onlinetime` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`dpath` varchar(255) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`design` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`noipcheck` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`planet_sort` tinyint(1) NOT NULL default '0', ";
	$QryTableUsers      .= "`planet_sort_order` tinyint(1) NOT NULL default '0', ";
	$QryTableUsers      .= "`spio_anz` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_tooltiptime` tinyint(4) NOT NULL default '5', ";
	$QryTableUsers      .= "`settings_fleetactions` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`settings_allylogo` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`settings_esp` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_wri` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_bud` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_mis` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_rep` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`urlaubs_modus` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`urlaubs_until` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`db_deaktjava` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`new_message` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`fleet_shortcut` text character set latin1, ";
	$QryTableUsers      .= "`b_tech_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`spy_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`computer_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`military_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`defence_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`shield_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`energy_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`hyperspace_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`combustion_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`impulse_motor_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`hyperspace_motor_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`laser_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ionic_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`buster_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`intergalactic_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`expedition_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`graviton_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_id` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_name` varchar(32) character set latin1 default '', ";
	$QryTableUsers      .= "`ally_request` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_request_text` text character set latin1, ";
	$QryTableUsers      .= "`ally_register_time` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_rank_id` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`vis_galaxy` INT( 1 ) NOT NULL default '1', ";
	$QryTableUsers      .= "`vis_messages` INT( 1 ) NOT NULL default '1', ";
	$QryTableUsers      .= "`current_luna` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`kolorminus` varchar(11) character set latin1 NOT NULL default 'red', ";
	$QryTableUsers      .= "`kolorplus` varchar(11) character set latin1 NOT NULL default '#00FF00', ";
	$QryTableUsers      .= "`kolorpoziom` varchar(11) character set latin1 NOT NULL default 'yellow', ";
	$QryTableUsers      .= "`rpg_geologue` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_amiral` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_ingenieur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_technocrate` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_espion` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_constructeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_scientifique` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_commandant` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_points` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_stockeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_defenseur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_destructeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_general` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_bunker` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_raideur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_empereur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`lvl_minier` int(11) NOT NULL default '1', ";
	$QryTableUsers      .= "`lvl_raid` int(11) NOT NULL default '1', ";
	$QryTableUsers      .= "`xpraid` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`xpminier` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`raids` bigint(20) NOT NULL default '0', ";
	$QryTableUsers      .= "`mnl_alliance` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_joueur` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_attaque` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_spy` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_exploit` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_transport` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_expedition` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_buildlist` INT (11) NOT NULL , ";
	$QryTableUsers      .= "`hof` INT( 1 ) NOT NULL default '1', ";
	$QryTableUsers      .= "`wons` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`loos` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`draws` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`kbmetal` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`kbcrystal` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`lostunits` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`desunits` bigint(20) NOT NULL default '0' , ";
	$QryTableUsers      .= "`bana` int(11) default NULL , ";
	$QryTableUsers      .= "`banaday` int(11) default NULL ";
	$QryTableUsers      .= ") ENGINE=MyISAM;";
	

	//Tabla de Control de IP
	
    $QryTableBannedip   .= " CREATE TABLE `{{table}}`( ";
    $QryTableBannedip   .= " `id` int( 11 ) NOT NULL AUTO_INCREMENT , ";
    $QryTableBannedip   .= " `ip` varchar( 255 ) NOT NULL default '', ";
    $QryTableBannedip   .= " `time` varchar( 255 ) NOT NULL default '', ";
    $QryTableBannedip   .= " `long` varchar( 255 ) NOT NULL default '', ";
    $QryTableBannedip   .= " `reason` text NOT NULL , ";
    $QryTableBannedip   .= " PRIMARY KEY ( `id` ) ";
    $QryTableBannedip   .= ") ENGINE = MYISAM ; ";
	
	//Tabla que control de Incidencias
	$QryTableSupp       .= "CREATE TABLE  `{{table}}` ( ";
	$QryTableSupp       .= "`ID` int(11) NOT NULL auto_increment,";
    $QryTableSupp       .= "`player_id` int(11) NOT NULL,";
    $QryTableSupp       .= "`time` int(11) NOT NULL,";
    $QryTableSupp       .= "`subject` varchar(255) NOT NULL,";
    $QryTableSupp       .= " `text` longtext NOT NULL,";
    $QryTableSupp       .= "`status` int(1) NOT NULL,";
    $QryTableSupp       .= " PRIMARY KEY  (`ID`)";
	$QryTableSupp       .= ") ENGINE = MYISAM CHARACTER SET latin1 COLLATE latin1_bin;";
	
	//tabla del menu
	$QryTableMenu       .= "CREATE TABLE  `{{table}}` ( ";
	$QryTableMenu       .= "`id` INT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,";
	$QryTableMenu       .= "`nombre` VARCHAR( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,";
	$QryTableMenu       .= "`link` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,";
	$QryTableMenu       .= "`orden` INT( 6 ) NOT NULL DEFAULT '0',";
    $QryTableMenu   	.= "`lang` int(1) NOT NULL DEFAULT '0'";
	$QryTableMenu       .= ") ENGINE=MyISAM  DEFAULT CHARSET=latin1";
	
	//datos menu
	$QryInsertMenu       .= "INSERT INTO `game_menu` (`id`, `nombre`, `link`, `orden`, `lang`) VALUES";
	$QryInsertMenu       .= "(1, 'devlp', '', '1', '0'), ";
	$QryInsertMenu       .= "(2, 'Overview', 'overview.php', '2', '0'), ";
	$QryInsertMenu       .= "(3, 'Buildings', 'buildings.php', '3', '0'), ";
	$QryInsertMenu       .= "(4, 'Research', 'buildings.php?mode=research', '4', '0'), ";
	$QryInsertMenu       .= "(5, 'Shipyard', 'buildings.php?mode=fleet', '5', '0'), ";
	$QryInsertMenu       .= "(6, 'Defense', 'buildings.php?mode=defense', '6', '0'), ";
	$QryInsertMenu       .= "(7, 'Officiers', 'officier.php', '7', '0'), ";
	$QryInsertMenu       .= "(8, 'Marchand', 'marchand.php', '8', '0'), ";
	$QryInsertMenu       .= "(9, 'navig', '', '10', '0'), ";
	$QryInsertMenu       .= "(10, 'Alliance', 'alliance.php', '11', '0'), ";
	$QryInsertMenu       .= "(11, 'Fleet', 'fleet.php', '12', '0'), ";
	$QryInsertMenu       .= "(12, 'Messages', 'messages.php', '13', '0'), ";
	$QryInsertMenu       .= "(13, 'observ', '', '14', '0'), ";
	$QryInsertMenu       .= "(14, 'Galaxy', 'galaxy.php?mode=0', '15', '0'), ";
	$QryInsertMenu       .= "(15, 'Imperium', 'imperium.php', '16', '0'), ";
	$QryInsertMenu       .= "(16, 'Resources', 'resources.php', '17', '0'), ";
	$QryInsertMenu       .= "(17, 'Technology', 'techtree.php', '18', '0'), ";
	$QryInsertMenu       .= "(18, 'Records', 'records.php', '19', '0'), ";
	$QryInsertMenu       .= "(33, 'Hall of Fame', 'topkb.php', '20', '1'),";
	$QryInsertMenu       .= "(19, 'Statistics', 'stat.php?start=', '21', '0'), ";
	$QryInsertMenu       .= "(20, 'Search', 'search.php', '22', '0'), ";
	$QryInsertMenu       .= "(21, 'blocked', 'banned.php', '23', '0'), ";
	$QryInsertMenu       .= "(22, 'Annonces', 'annonce.php', '24', '0'), ";
	$QryInsertMenu       .= "(23, 'commun', '', '25', '0'), ";
	$QryInsertMenu       .= "(24, 'Buddylist', 'buddy.php', '26', '0'), ";
	$QryInsertMenu       .= "(25, 'Notes', 'notes.php', '27', '0'), ";
	$QryInsertMenu       .= "(26, 'Chat', 'chat.php', '28', '0'), ";
	$QryInsertMenu       .= "(27, 'Board', 'Foro.php', '30', '0'), ";
	$QryInsertMenu       .= "(28, 'Contact', 'contact.php', '31', '0'), ";
	$QryInsertMenu       .= "(29, 'support_system', 'support.php', '32', '0'), ";
	$QryInsertMenu       .= "(30, 'Options', 'options.php', '33', '0');";
	
	
	//tabla del modulos
	$QryTableModulos       .= "CREATE TABLE IF NOT EXISTS `game_modulos` (";
	$QryTableModulos       .= "`id` int(5) NOT NULL AUTO_INCREMENT,";
	$QryTableModulos       .= "`modulo` varchar(150) NOT NULL,";
	$QryTableModulos       .= "`estado` int(1) NOT NULL,";
	$QryTableModulos       .= "PRIMARY KEY (`id`)";
	$QryTableModulos       .= ") ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";
	
	//Datos modulos
	$QryInsertModulos       .= "INSERT INTO `game_modulos` (`id`, `modulo`, `estado`) VALUES";
	$QryInsertModulos       .= "(1, 'Offiziere', 1),";
	$QryInsertModulos       .= "(2, 'H&auml;ndler', 1),";
	$QryInsertModulos       .= "(3, 'Allianzen', 1),";
	$QryInsertModulos       .= "(4, 'Nachrichten', 1),";
	$QryInsertModulos       .= "(5, 'Galaxie', 1),";
	$QryInsertModulos       .= "(6, 'Planeten&uuml;bersicht', 1),";
	$QryInsertModulos       .= "(7, 'Waffenfabrik', 1),";
	$QryInsertModulos       .= "(8, 'Forschung', 1),";
	$QryInsertModulos       .= "(9, 'Rekorde', 1),";
	$QryInsertModulos       .= "(10, 'Rangliste', 1),";
	$QryInsertModulos       .= "(11, 'Suche', 1),";
	$QryInsertModulos       .= "(12, 'Sperren', 1),";
	$QryInsertModulos       .= "(13, 'Ank&uuml;ndigungen', 1),";
	$QryInsertModulos       .= "(14, 'Chat', 1),";
	$QryInsertModulos       .= "(15, 'Kontakt', 1),";
	$QryInsertModulos       .= "(16, 'Support Ticket', 1),";
	$QryInsertModulos       .= "(19, 'Hall of Fame', 1),";
	$QryInsertModulos       .= "(20, 'Multi IP Check', 1);";
	
	//tabla Loteria
	$QryTableLoteria       .= "CREATE TABLE  `{{table}}` ( ";
	$QryTableLoteria       .= "`ID` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableLoteria       .= "`user` varchar(255) collate latin1_spanish_ci NOT NULL,";
	$QryTableLoteria       .= "`tickets` int(5) NOT NULL,";
	$QryTableLoteria       .= " PRIMARY KEY (`ID`)";
	$QryTableLoteria       .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	
	//tabla visitas unicas y visionados
	$QryTablevisitas       .= " CREATE TABLE `{{table}}` ( ";
	$QryTablevisitas       .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTablevisitas       .= "`fecha` DATE NOT NULL ,";
	$QryTablevisitas       .= "`vunicas` INT( 15 ) NOT NULL ,";
	$QryTablevisitas       .= "`vpaginas` INT( 15 ) NOT NULL,";
	$QryTablevisitas       .= " PRIMARY KEY (`id`)";
	$QryTablevisitas       .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	
	//tabla ips
	$QryTableips       .= "CREATE TABLE `{{table}}` ( ";
	$QryTableips       .= "`fecha` DATE NOT NULL ,";
	$QryTableips	   .= "`ip` VARCHAR( 18 ) NOT NULL";
	$QryTableips   	   .= ") ENGINE = MYISAM ";
	
	//tabla topkb
	$QryTabletopkb       .= "CREATE TABLE `{{table}}` ( ";
	$QryTabletopkb       .= "`id` bigint(11) unsigned NOT NULL auto_increment,";
	$QryTabletopkb       .= "`id_owner1` bigint(20) NOT NULL default '0',";
	$QryTabletopkb       .= "`angreifer` varchar(64) NOT NULL default '',";
	$QryTabletopkb       .= "`id_owner2` bigint(20) NOT NULL default '0',";
	$QryTabletopkb       .= "`defender` varchar(64) NOT NULL default '',";
	$QryTabletopkb       .= "`gesamtunits` bigint(20) NOT NULL default '0',";
	$QryTabletopkb       .= "`gesamttruemmer` bigint(20) NOT NULL default '0',";
	$QryTabletopkb       .= "`rid` varchar(72) NOT NULL default '',";
	$QryTabletopkb       .= "`raport` text NOT NULL,";
	$QryTabletopkb       .= "`fleetresult` varchar(64) NOT NULL default '',";
	$QryTabletopkb       .= "`a_zestrzelona` tinyint(3) unsigned NOT NULL default '0',";
	$QryTabletopkb       .= "`time` int(10) unsigned NOT NULL default '0',";
	$QryTabletopkb       .= "KEY `id_owner1` (`id_owner1`,`rid`),";
	$QryTabletopkb       .= "KEY `id_owner2` (`id_owner2`,`rid`),";
	$QryTabletopkb       .= "KEY `time` (`time`),";
	$QryTabletopkb       .= "FULLTEXT KEY `raport` (`raport`),";
	$QryTabletopkb       .= " PRIMARY KEY  (`id`)";
	$QryTabletopkb       .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
?>
