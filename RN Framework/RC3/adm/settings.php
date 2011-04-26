<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser )
{
	global $game_config, $lang;

	if ($CurrentUser['authlevel'] < 3) die(message ($lang['not_enough_permissions']));

	if ($_POST['opt_save'] == "1")
	{
		if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
		$game_config['game_disable']         = 1;
		$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
		} else {
		$game_config['game_disable']         = 0;
		$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
		}
        if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
        $game_config['OverviewNewsFrame']     = "1";
        $game_config['OverviewNewsText']      = addslashes( $_POST['NewsText'] );
        } else {
        $game_config['OverviewNewsFrame']     = "0";
        $game_config['OverviewNewsText']      = "";
        }  
		if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
		$game_config['debug'] = 1;
		} else {
		$game_config['debug'] = 0;
		}

		if (isset($_POST['reg_closed']) && $_POST['reg_closed'] == 'on') {
		$game_config['reg_closed'] = 1;
		} else {
		$game_config['reg_closed'] = 0;
		}
		
		if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
		$game_config['game_name'] = $_POST['game_name'];
		}

		if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
		$game_config['forum_url'] = $_POST['forum_url'];
		}

		if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
		$game_config['game_speed'] = $_POST['game_speed'];
		}

		if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
		$game_config['fleet_speed'] = $_POST['fleet_speed'];
		}

		if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
		$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
		}

		if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
		$game_config['initial_fields'] = $_POST['initial_fields'];
		}

		if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
		$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
		}

		if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
		$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
		}

		if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
		$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
		}

		if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
		$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
		}

		if (isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on') {
			$game_config['adm_attack'] = 1;
		} else {
			$game_config['adm_attack'] = 0;
		}

		if (isset($_POST['language'])) {
			$game_config['lang'] = $_POST['language'];
		} else {
			$game_config['lang'];
		}

		if (isset($_POST['capaktiv']) && $_POST['capaktiv'] == 'on') {
			$game_config['capaktiv'] = 1;
		} else {
			$game_config['capaktiv'] = 0;
		}
		
		if (isset($_POST['capprivate'])) {
		$game_config['capprivate'] = $_POST['capprivate'];
		}

		if (isset($_POST['cappublic'])) {
		$game_config['cappublic'] = $_POST['cappublic'];
		}
		
		if (isset($_POST['min_build_time']) && is_numeric($_POST['min_build_time'])){
			if ($_POST['min_build_time'] < 0) {
				$game_config['min_build_time'] = 0;
			} else {
				$game_config['min_build_time'] = $_POST['min_build_time'];			
			}
		}
		
		if (isset($_POST['min_build_time_rec']) && is_numeric($_POST['min_build_time_rec'])){
			if ($_POST['min_build_time_rec'] < 0) {
				$game_config['min_build_time_rec'] = 0;
			} else {
				$game_config['min_build_time_rec'] = $_POST['min_build_time_rec'];			
			}
		}		
		
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');
        doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsFrame']      ."' WHERE `config_name` = 'OverviewNewsFrame';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['reg_closed']             ."' WHERE `config_name` = 'reg_closed';", 'config');
        doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsText']       ."' WHERE `config_name` = 'OverviewNewsText';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']              ."' WHERE `config_name` = 'game_name';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['debug']                  ."' WHERE `config_name` = 'debug'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['adm_attack']             ."' WHERE `config_name` = 'adm_attack'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['lang']             	  ."' WHERE `config_name` = 'lang'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['capaktiv']               ."' WHERE `config_name` = 'capaktiv'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['capprivate']             ."' WHERE `config_name` = 'capprivate'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['cappublic']              ."' WHERE `config_name` = 'cappublic'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['min_build_time']         ."' WHERE `config_name` = 'min_build_time'", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['min_build_time_rec']     ."' WHERE `config_name` = 'min_build_time_rec'", 'config');
		header("location:settings.php");
	}
	else
	{
		$parse								= $lang;
		$parse['min_build_time_rec']        = $game_config['min_build_time_rec'];
		$parse['min_build_time']            = $game_config['min_build_time'];
		$parse['game_name']              	= $game_config['game_name'];
		$parse['game_speed']             	= $game_config['game_speed'];
		$parse['fleet_speed']            	= $game_config['fleet_speed'];
		$parse['resource_multiplier']    	= $game_config['resource_multiplier'];
		$parse['forum_url']              	= $game_config['forum_url'];
		$parse['initial_fields']         	= $game_config['initial_fields'];
		$parse['metal_basic_income']     	= $game_config['metal_basic_income'];
		$parse['crystal_basic_income']   	= $game_config['crystal_basic_income'];
		$parse['deuterium_basic_income'] 	= $game_config['deuterium_basic_income'];
		$parse['energy_basic_income']    	= $game_config['energy_basic_income'];
		$parse['closed']                 	= ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
		$parse['close_reason']           	= stripslashes($game_config['close_reason']);
		$parse['debug']                  	= ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";
		$parse['reg_closed']                = ($game_config['reg_closed'] == 1) ? " checked = 'checked' ":"";
		$parse['adm_attack']             	= ($game_config['adm_attack'] == 1)   ? " checked = 'checked' ":"";
        $parse['newsframe']                 = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
        $parse['NewsTextVal']               = stripslashes( $game_config['OverviewNewsText'] );  
		$parse['capprivate'] 				= $game_config['capprivate'];
		$parse['cappublic']    				= $game_config['cappublic'];
		$parse['capaktiv']                 	= ($game_config['capaktiv'] == 1) ? " checked = 'checked' ":"";
		$LangFolder = opendir("./../" . 'language');

		while (($LangSubFolder = readdir($LangFolder)) !== false)
		{
			if($LangSubFolder != '.' && $LangSubFolder != '..' && $LangSubFolder != '.htaccess')
			{
				$parse['language_settings'] .= "<option ";

				if($game_config['lang'] == $LangSubFolder)
					$parse['language_settings'] .= "selected = selected";

				$parse['language_settings'] .= " value=\"".$LangSubFolder."\">".$LangSubFolder."</option>";
			}
		}

		return display (parsetemplate(gettemplate('adm/settings_body'),  $parse), false, '', true, false);
	}
}

DisplayGameSettingsPage($user);
?>