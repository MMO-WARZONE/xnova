<?php

/**
 * settings.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

function DisplayGameSettingsPage ( $CurrentUser ) {
	global $lang, $game_config, $_POST, $DB;

	includeLang('admin/settings');

	if ( $CurrentUser['authlevel'] >= 3 ) {
		if ($_POST['opt_save'] == "1") {
			// Jeu Ouvert ou Fermï¿½ !
			if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
				$game_config['game_disable']         = "1";
				$game_config['close_reason']         = $_POST['close_reason'];
			} else {
				$game_config['game_disable']         = "0";
				$game_config['close_reason']         = "";
			}

			// Y a un News Frame ? !
			if (isset($_POST['LoginNewsFrame']) && $_POST['LoginNewsFrame'] == 'on') {
				$game_config['LoginNewsFrame']     = "1";
				$game_config['LoginNewsText']      = $_POST['LoginNewsText'];
			} else {
				$game_config['LoginNewsFrame']     = "0";
				$game_config['LoginNewsText']      = "";
			}
			
			if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
				$game_config['OverviewNewsFrame']     = "1";
				$game_config['OverviewNewsText']      = $_POST['NewsText'];
			} else {
				$game_config['OverviewNewsFrame']     = "0";
				$game_config['OverviewNewsText']      = "";
			}

			// Y a un TCHAT externe ??
			if (isset($_POST['chatframe']) && $_POST['chatframe'] == 'on') {
				$game_config['OverviewExternChat']     = "1";
				$game_config['OverviewExternChatCmd']  = $_POST['ExternChat'];
			} else {
				$game_config['OverviewExternChat']     = "0";
				$game_config['OverviewExternChatCmd']  = "";
			}

			if (isset($_POST['googlead']) && $_POST['googlead'] == 'on') {
				$game_config['OverviewBanner']         = "1";
				$game_config['OverviewClickBanner']    = $_POST['GoogleAds'];
			} else {
				$game_config['OverviewBanner']         = "0";
				$game_config['OverviewClickBanner']    = "";
			}

			// Mode Debug ou pas !
			if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
				$game_config['debug'] = "1";
			} else {
				$game_config['debug'] = "0";
			}
			
			
			if (isset($_POST['adm_email']) && $_POST['adm_email'] != '') {
				$game_config['adminmail'] = $_POST['adm_email'];
			}
			
			if (isset($_POST['max_galaxy_in_world']) && $_POST['max_galaxy_in_world'] != '') {
				$game_config['max_galaxy_in_world'] = $_POST['max_galaxy_in_world'];
			}
			
			if (isset($_POST['max_system_in_galaxy']) && $_POST['max_system_in_galaxy'] != '') {
				$game_config['max_system_in_galaxy'] = $_POST['max_system_in_galaxy'];
			}
			
			if (isset($_POST['max_planet_in_system']) && $_POST['max_planet_in_system'] != '') {
				$game_config['max_planet_in_system'] = $_POST['max_planet_in_system'];
			}
			
			if (isset($_POST['spy_report_row']) && $_POST['spy_report_row'] != '') {
				$game_config['spy_report_row'] = $_POST['spy_report_row'];
			}
			
			if (isset($_POST['fields_by_moonbasis_level']) && $_POST['fields_by_moonbasis_level'] != '') {
				$game_config['fields_by_moonbasis_level'] = $_POST['fields_by_moonbasis_level'];
			}
			
			if (isset($_POST['max_player_planets']) && $_POST['max_player_planets'] != '') {
				$game_config['max_player_planets'] = $_POST['max_player_planets'];
			}
			
			if (isset($_POST['max_building_queue_size']) && $_POST['max_building_queue_size'] != '') {
				$game_config['max_building_queue_size'] = $_POST['max_building_queue_size'];
			}
			
			if (isset($_POST['max_fleet_or_defs_per_row']) && $_POST['max_fleet_or_defs_per_row'] != '') {
				$game_config['max_fleet_or_defs_per_row'] = $_POST['max_fleet_or_defs_per_row'];
			}
			
			if (isset($_POST['max_overflow']) && $_POST['max_overflow'] != '') {
				$game_config['max_overflow'] = $_POST['max_overflow'];
			}
			
			if (isset($_POST['base_storage_size']) && $_POST['base_storage_size'] != '') {
				$game_config['base_storage_size'] = $_POST['base_storage_size'];
			}
			
			if (isset($_POST['build_metal']) && $_POST['build_metal'] != '') {
				$game_config['build_metal'] = $_POST['build_metal'];
			}
			
			if (isset($_POST['build_cristal']) && $_POST['build_cristal'] != '') {
				$game_config['build_cristal'] = $_POST['build_cristal'];
			}
			
			if (isset($_POST['build_deuterium']) && $_POST['build_deuterium'] != '') {
				$game_config['build_deuterium'] = $_POST['build_deuterium'];
			}

			// Nom du Jeu
			if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
				$game_config['game_name'] = $_POST['game_name'];
			}

			// Adresse du Forum
			if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
				$game_config['forum_url'] = $_POST['forum_url'];
			}

			// Vitesse du Jeu
			if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
				$game_config['game_speed'] = $_POST['game_speed'];
			}

			// Vitesse des Flottes
			if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
				$game_config['fleet_speed'] = $_POST['fleet_speed'];
			}

			// Multiplicateur de Production
			if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
				$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
			}

			// Taille de la planete mÃ¨re
			if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
				$game_config['initial_fields'] = $_POST['initial_fields'];
			}

			// Revenu de base Metal
			if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
				$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
			}

			// Revenu de base Cristal
			if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
				$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
			}

			// Revenu de base Deuterium
			if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
				$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
			}

			// Revenu de base Energie
			if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
				$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
			}

			// Revenu de Fleet ins Trümmerfeld
			if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
				$game_config['Fleet_Cdr'] = $_POST['Fleet_Cdr'];
			}

			// Revenu de Def ins Trümmerfeld
			if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
				$game_config['Defs_Cdr'] = $_POST['Defs_Cdr'];
			}

			// Revenu de Noobprotection
			if (isset($_POST['noobprotection']) && is_numeric($_POST['noobprotection'])) {
				$game_config['noobprotection'] = $_POST['noobprotection'];
			}

			// Revenu de Noobprotection Time
			if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
				$game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
			}

			// Revenu de Noobprotection Multi
			if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti'])) {
				$game_config['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
			}

			// Revenu de LastSettedGalaxyPos
			if (isset($_POST['LastSettedGalaxyPos']) && is_numeric($_POST['LastSettedGalaxyPos'])) {
				$game_config['LastSettedGalaxyPos'] = $_POST['LastSettedGalaxyPos'];
			}

			// Revenu de LastSettedSystemPos
			if (isset($_POST['LastSettedSystemPos']) && is_numeric($_POST['LastSettedSystemPos'])) {
				$game_config['LastSettedSystemPos'] = $_POST['LastSettedSystemPos'];
			}

			// Revenu de LastSettedPlanetPos
			if (isset($_POST['LastSettedPlanetPos']) && is_numeric($_POST['LastSettedPlanetPos'])) {
				$game_config['LastSettedPlanetPos'] = $_POST['LastSettedPlanetPos'];
			}

			// Onlinestatus des Spiels
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'game_disable'");
			$Query->bindParam('value', $game_config['game_disable']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'close_reason'");
			$Query->bindParam('value', $game_config['close_reason']);
			$Query->execute();
			
			
			// Spielkonfiguration
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'adminmail'");
			$Query->bindParam('value', $game_config['adminmail']);
			$Query->execute();
			
			/*PLATZHALTER*/
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_galaxy_in_world'");
			$Query->bindParam('value', $game_config['max_galaxy_in_world']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_system_in_galaxy'");
			$Query->bindParam('value', $game_config['max_system_in_galaxy']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_planet_in_system'");
			$Query->bindParam('value', $game_config['max_planet_in_system']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'spy_report_row'");
			$Query->bindParam('value', $game_config['spy_report_row']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'fields_by_moonbasis_level'");
			$Query->bindParam('value', $game_config['fields_by_moonbasis_level']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_player_planets'");
			$Query->bindParam('value', $game_config['max_player_planets']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_building_queue_size'");
			$Query->bindParam('value', $game_config['max_building_queue_size']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_fleet_or_defs_per_row'");
			$Query->bindParam('value', $game_config['max_fleet_or_defs_per_row']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'max_overflow'");
			$Query->bindParam('value', $game_config['max_overflow']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'base_storage_size'");
			$Query->bindParam('value', $game_config['base_storage_size']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'build_metal'");
			$Query->bindParam('value', $game_config['build_metal']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'build_cristal'");
			$Query->bindParam('value', $game_config['build_cristal']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'build_deuterium'");
			$Query->bindParam('value', $game_config['build_deuterium']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'game_name'");
			$Query->bindParam('value', $game_config['game_name']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'forum_url'");
			$Query->bindParam('value', $game_config['forum_url']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'game_speed'");
			$Query->bindParam('value', $game_config['game_speed']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'fleet_speed'");
			$Query->bindParam('value', $game_config['fleet_speed']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'resource_multiplier'");
			$Query->bindParam('value', $game_config['resource_multiplier']);
			$Query->execute();
			
			// zusätzliche Seiten (News, Chat etc)
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewNewsFrame'");
			$Query->bindParam('value', $game_config['OverviewNewsFrame']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewNewsText'");
			$Query->bindParam('value', $game_config['OverviewNewsText']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewExternChat'");
			$Query->bindParam('value', $game_config['OverviewExternChat']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewExternChatCmd'");
			$Query->bindParam('value', $game_config['OverviewExternChatCmd']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewBanner'");
			$Query->bindParam('value', $game_config['OverviewBanner']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'OverviewClickBanner'");
			$Query->bindParam('value', $game_config['OverviewClickBanner']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'LoginNewsFrame'");
			$Query->bindParam('value', $game_config['LoginNewsFrame']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'LoginNewsText'");
			$Query->bindParam('value', $game_config['LoginNewsText']);
			$Query->execute();
			
			// Planetenoptionen
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'initial_fields'");
			$Query->bindParam('value', $game_config['initial_fields']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'metal_basic_income'");
			$Query->bindParam('value', $game_config['metal_basic_income']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'crystal_basic_income'");
			$Query->bindParam('value', $game_config['crystal_basic_income']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'deuterium_basic_income'");
			$Query->bindParam('value', $game_config['deuterium_basic_income']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'energy_basic_income'");
			$Query->bindParam('value', $game_config['energy_basic_income']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'Fleet_Cdr'");
			$Query->bindParam('value', $game_config['Fleet_Cdr']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'Defs_Cdr'");
			$Query->bindParam('value', $game_config['Defs_Cdr']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'noobprotection'");
			$Query->bindParam('value', $game_config['noobprotection']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'noobprotectiontime'");
			$Query->bindParam('value', $game_config['noobprotectiontime']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'noobprotectionmulti'");
			$Query->bindParam('value', $game_config['noobprotectionmulti']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'LastSettedGalaxyPos'");
			$Query->bindParam('value', $game_config['LastSettedGalaxyPos']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'LastSettedSystemPos'");
			$Query->bindParam('value', $game_config['LastSettedSystemPos']);
			$Query->execute();
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'LastSettedPlanetPos'");
			$Query->bindParam('value', $game_config['LastSettedPlanetPos']);
			$Query->execute();
			
		      // Mode Debug
			$Query = $DB->prepare("UPDATE ".PREFIX."config SET config_value = :value WHERE config_name = 'debug'");
			$Query->bindParam('value', $game_config['debug']);
			$Query->execute();
			AdminMessage ('Einstellungen wurden erfolgreich ge&auml;ndert!', 'Einstellungen', '?');
		} else {



			$parse                           = $lang;
			$parse['game_name']              = $game_config['game_name'];
			$parse['game_speed']             = $game_config['game_speed'];
			$parse['fleet_speed']            = $game_config['fleet_speed'];
			$parse['resource_multiplier']    = $game_config['resource_multiplier'];
			$parse['forum_url']              = $game_config['forum_url'];
			$parse['initial_fields']         = $game_config['initial_fields'];
			$parse['metal_basic_income']     = $game_config['metal_basic_income'];
			$parse['crystal_basic_income']   = $game_config['crystal_basic_income'];
			$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'];
			$parse['energy_basic_income']    = $game_config['energy_basic_income'];
			$parse['Fleet_Cdr']    	         = $game_config['Fleet_Cdr'];
			$parse['Defs_Cdr']     			 = $game_config['Defs_Cdr'];
			$parse['noobprotection']    	 = $game_config['noobprotection'];
			$parse['noobprotectiontime']     = $game_config['noobprotectiontime'];
			$parse['noobprotectionmulti']    = $game_config['noobprotectionmulti'];

			$parse['LastSettedGalaxyPos']    = $game_config['LastSettedGalaxyPos'];
			$parse['LastSettedSystemPos']    = $game_config['LastSettedSystemPos'];
			$parse['LastSettedPlanetPos']    = $game_config['LastSettedPlanetPos'];

			$parse['closed']                 = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
			$parse['close_reason']           = stripslashes( $game_config['close_reason'] );
			
			$parse['adm_email']					= $game_config['adminmail'];
			$parse['max_galaxy_in_world']		= $game_config['max_galaxy_in_world'];
			$parse['max_system_in_galaxy']		= $game_config['max_system_in_galaxy'];
			$parse['max_planet_in_system']		= $game_config['max_planet_in_system'];
			$parse['spy_report_row']			= $game_config['spy_report_row'];
			$parse['fields_by_moonbasis_level']	= $game_config['fields_by_moonbasis_level'];
			$parse['max_player_planets']		= $game_config['max_player_planets'];
			$parse['max_building_queue_size']	= $game_config['max_building_queue_size'];
			$parse['max_fleet_or_defs_per_row']	= $game_config['max_fleet_or_defs_per_row'];
			$parse['max_overflow']				= $game_config['max_overflow'];
			$parse['base_storage_size']			= $game_config['base_storage_size'];
			$parse['build_metal']				= $game_config['build_metal'];
			$parse['build_cristal']				= $game_config['build_cristal'];
			$parse['build_deuterium']			= $game_config['build_deuterium'];
			


			
			$parse['LoginNewsFrame']         = ($game_config['LoginNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['LoginNewsText']          = stripslashes( $game_config['LoginNewsText'] );
			
			$parse['newsframe']              = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['NewsTextVal']            = stripslashes( $game_config['OverviewNewsText'] );

			$parse['chatframe']              = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
			$parse['ExtTchatVal']            = stripslashes( $game_config['OverviewExternChatCmd'] );

			$parse['googlead']               = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
			$parse['GoogleAdVal']            = stripslashes( $game_config['OverviewClickBanner'] );

			$parse['debug']                  = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";

			$PageTPL                         = gettemplate('admin/options_body');
			$Page                           .= parsetemplate( $PageTPL,  $parse );

			display ( $Page, $lang['adm_opt_title'], false, '', true );
		}
	} else {
		header('Location: indexGame.php'); 
	}
	return $Page;
}

	$Page = DisplayGameSettingsPage ( $user );

?>
