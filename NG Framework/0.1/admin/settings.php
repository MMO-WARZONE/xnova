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

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
	global $lang, $game_config, $_POST;

	includeLang('admin/settings');

	if ( $CurrentUser['authlevel'] >= 3 ) {
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

			$parse['closed']                 = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
			$parse['close_reason']           = stripslashes( $game_config['close_reason'] );

			$parse['newsframe']              = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['NewsTextVal']            = stripslashes( $game_config['OverviewNewsText'] );

			$parse['chatframe']              = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
			$parse['ExtTchatVal']            = stripslashes( $game_config['OverviewExternChatCmd'] );

			$parse['googlead']               = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
			$parse['GoogleAdVal']            = stripslashes( $game_config['OverviewClickBanner'] );

			$parse['debug']                  = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";
			
		if ($_POST['opt_save'] == "1") {
			//mensaje a mostrar
		$parse['mensaje'] .= "<tr>";
		$parse['mensaje'] .= "<td class=\"mensaje\" colspan=\"4\">Datos Guardaos Correctamente</td>";
		$parse['mensaje'] .= "</tr>";
	
			// Jeu Ouvert ou Ferm� !
			if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
				$game_config['game_disable']         = "1";
				$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
			} else {
				$game_config['game_disable']         = "0";
				$game_config['close_reason']         = "";
			}

			// Y a un News Frame ? !
			if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
				$game_config['OverviewNewsFrame']     = "1";
				$game_config['OverviewNewsText']      = addslashes( $_POST['NewsText'] );
			} else {
				$game_config['OverviewNewsFrame']     = "0";
				$game_config['OverviewNewsText']      = "";
			}

			// Y a un TCHAT externe ??
			if (isset($_POST['chatframe']) && $_POST['chatframe'] == 'on') {
				$game_config['OverviewExternChat']     = "1";
				$game_config['OverviewExternChatCmd']  = addslashes( $_POST['ExternChat'] );
			} else {
				$game_config['OverviewExternChat']     = "0";
				$game_config['OverviewExternChatCmd']  = "";
			}

			if (isset($_POST['googlead']) && $_POST['googlead'] == 'on') {
				$game_config['OverviewBanner']         = "1";
				$game_config['OverviewClickBanner']    = addslashes( $_POST['GoogleAds'] );
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

			// Taille de la planete mère
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

			// Activation du jeu
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');

			// Configuration du Jeu
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']              ."' WHERE `config_name` = 'game_name';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');

			// Page Generale
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsFrame']       ."' WHERE `config_name` = 'OverviewNewsFrame';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsText']        ."' WHERE `config_name` = 'OverviewNewsText';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChat']      ."' WHERE `config_name` = 'OverviewExternChat';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChatCmd']   ."' WHERE `config_name` = 'OverviewExternChatCmd';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewBanner']          ."' WHERE `config_name` = 'OverviewBanner';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewClickBanner']     ."' WHERE `config_name` = 'OverviewClickBanner';", 'config');

			// Options Planete
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');

			// Mode Debug
			doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['debug']                  ."' WHERE `config_name` ='debug'", 'config');

		} 

		

			$PageTPL                         = gettemplate('admin/options_body');
			$Page                           .= parsetemplate( $PageTPL,  $parse );

			display ( $Page, $lang['adm_opt_title'], false, '', true );
		
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
	return $Page;
}

	$Page = DisplayGameSettingsPage ( $user );

?>
