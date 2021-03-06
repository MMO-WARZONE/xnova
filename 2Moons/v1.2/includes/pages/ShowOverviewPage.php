<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowOverviewPage()
{
	global $CONF, $LNG, $PLANET, $USER, $db, $resource;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$template	= new template();	
	$template->getplanets();
	$AdminsOnline = $AllPlanets = $Moon = array();
	
	foreach($template->UserPlanets as $ID => $CPLANET)
	{		
		if ($ID == $_SESSION['planet'] || $CPLANET['planet_type'] == 3)
			continue;

		if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
			$Queue				= explode(';', $CPLANET['b_building_id']);
			$CurrBuild			= explode(',', $Queue[0]);
			$BuildPlanet		= $LNG['tech'][$CurrBuild[0]]." (".$CurrBuild[1].")<br><span style=\"color:#7F7F7F;\">(".pretty_time($CurrBuild[3] - TIMESTAMP).")</span>";
		} else {
			$BuildPlanet     = $LNG['ov_free'];
		}
		
		$AllPlanets[] = array(
			'id'	=> $CPLANET['id'],
			'name'	=> $CPLANET['name'],
			'image'	=> $CPLANET['image'],
			'build'	=> $BuildPlanet,
		);
	}
		
	if ($PLANET['id_luna'] != 0)
	{
		$Moon = $db->uniquequery("SELECT `id`, `name` FROM ".PLANETS." WHERE `id` = '".$PLANET['id_luna']."';");
	}

	if (!empty($PLANET['b_building']))
	{
		$Queue		= explode(';', $PLANET['b_building_id']);
		$CurrBuild	= explode(',', $Queue[0]);
		$Build		= $LNG['tech'][$CurrBuild[0]].' ('.$CurrBuild[1].')<br><div id="blc">"'.pretty_time($PLANET['b_building'] - TIMESTAMP).'</div>';
		$template->execscript('BuildTime();');
	}
	else
	{
		$Build 		= $LNG['ov_free'];
	}

	$Teamspeak = '';			
	if ($CONF['ts_modon'] == 1) {
		if($CONF['ts_version'] == 2){
			include_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak2.".PHP_EXT);
			$ts = new cyts();
			if($ts->connect($CONF['ts_server'], $CONF['ts_tcpport'], $CONF['ts_udpport'], $CONF['ts_timeout']))
			{
				$tsdata 	= $ts->info_serverInfo();
				$tsdata2 	= $ts->info_globalInfo();
				$ts->disconnect();
				$trafges 	= pretty_number(($tsdata2["total_bytessend"] / 1024 / 1024) + $tsdata2["total_bytesreceived"] / 1024 / 1024);
				$Teamspeak	= sprintf($LNG['ov_teamspeak_v2'], $CONF['ts_server'], $CONF['ts_udpport'], $USER['username'], $tsdata["server_currentusers"], $tsdata["server_maxusers"], $tsdata["server_currentchannels"], $trafges);
			} else {
				$Teamspeak	= $LNG['ov_teamspeak_not_online'];
			}
		} elseif($CONF['ts_version'] == 3){
			$ip 	= $CONF['ts_server'];
			$port 	= $CONF['ts_tcpport'];
			$t_port = $CONF['ts_udpport'];
			$sid 	= $CONF['ts_timeout']; 
			require_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak3.".PHP_EXT);

			$tsAdmin = new ts3admin($ip, $t_port);
			if($tsAdmin->connect())
			{
				$tsAdmin->selectServer($sid);
				#$tsAdmin->login($username, $password); Insert the SA Account Details, if Teamspeak banned you.
				$sinfo	= $tsAdmin->serverInfo();
				$tsAdmin->logout();
				$tsAdmin->quit();
				$trafges 	= round(($sinfo['connection_bytes_received_total'] / 1024 / 1024) + ($sinfo['connection_bytes_sent_total'] / 1024 / 1024), 2);
				$Debug		= $tsAdmin->getDebugLog();
				if($Debug == "Error while fetching: 'error id=518 msg=not logged in'<br>")
					$Teamspeak	= sprintf($LNG['ov_teamspeak_v3'], $ip, $port, $USER['username'], $sinfo['virtualserver_password'], ($sinfo['virtualserver_clientsonline'] - 1), $sinfo['virtualserver_maxclients'], $sinfo['virtualserver_channelsonline'], $trafges);
				else
					$Teamspeak	= $Debug;
			} else {
				$Teamspeak 	= $LNG['ov_teamspeak_not_online'];		
			}
		}
	}
	
	$OnlineAdmins 	= $db->query("SELECT `id`,`username` FROM ".USERS." WHERE `onlinetime` >= '".(TIMESTAMP-10*60)."' AND `authlevel` > '0';");
	while ($AdminRow = $db->fetch_array($OnlineAdmins)) {
		$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
	}

	$db->free_result($OnlineAdmins);
	
	$template->loadscript('mbContainer.js');
	$template->loadscript('overview.js');
	$template->execscript('GetFleets(true);');
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	
	$template->assign_vars(array(
		'user_rank'					=> sprintf($LNG['ov_userrank_info'], pretty_number($USER['total_points']), $LNG['ov_place'], $USER['total_rank'], $USER['total_rank'], $LNG['ov_of'], $CONF['users_amount']),
		'is_news'					=> $CONF['OverviewNewsFrame'],
		'news'						=> makebr($CONF['OverviewNewsText']),
		'planetname'				=> $PLANET['name'],
		'planetimage'				=> $PLANET['image'],
		'galaxy'					=> $PLANET['galaxy'],
		'system'					=> $PLANET['system'],
		'planet'					=> $PLANET['planet'],
		'buildtime'					=> $PLANET['b_building'],
		'userid'					=> $USER['id'],
		'username'					=> $USER['username'],
		'build'						=> $Build,
		'Moon'						=> $Moon,
		'AllPlanets'				=> $AllPlanets,
		'AdminsOnline'				=> $AdminsOnline,
		'Teamspeak'					=> $Teamspeak,
		'messages'					=> ($USER['new_message'] > 0) ? (($USER['new_message'] == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($USER['new_message']))): false,
		'planet_diameter'			=> pretty_number($PLANET['diameter']),
		'planet_field_current' 		=> $PLANET['field_current'],
		'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
		'planet_temp_min' 			=> $PLANET['temp_min'],
		'planet_temp_max' 			=> $PLANET['temp_max'],
		'ov_news'					=> $LNG['ov_news'],
		'fcm_moon'					=> $LNG['fcm_moon'],
		'ov_server_time'			=> $LNG['ov_server_time'],
		'ov_planet'					=> $LNG['ov_planet'],
		'ov_planetmenu'				=> $LNG['ov_planetmenu'],
		'ov_diameter'				=> $LNG['ov_diameter'],
		'ov_distance_unit'			=> $LNG['ov_distance_unit'],
		'ov_developed_fields'		=> $LNG['ov_developed_fields'],
		'ov_max_developed_fields'	=> $LNG['ov_max_developed_fields'],
		'ov_fields'					=> $LNG['ov_fields'],
		'ov_temperature'			=> $LNG['ov_temperature'],
		'ov_aprox'					=> $LNG['ov_aprox'	], 
		'ov_temp_unit'				=> $LNG['ov_temp_unit'],
		'ov_to'						=> $LNG['ov_to'],
		'ov_position'				=> $LNG['ov_position'],
		'ov_points'					=> $LNG['ov_points'],
		'ov_events'					=> $LNG['ov_events'],
		'ov_admins_online'			=> $LNG['ov_admins_online'],
		'ov_no_admins_online'		=> $LNG['ov_no_admins_online'],
		'ov_userbanner'				=> $LNG['ov_userbanner'],
		'ov_teamspeak'				=> $LNG['ov_teamspeak'],
		'ov_your_planet'			=> $LNG['ov_your_planet'],
		'ov_coords'					=> $LNG['ov_coords'],
		'ov_planet_name'			=> $LNG['ov_planet_name'],
		'ov_actions'				=> $LNG['ov_actions'],
		'ov_abandon_planet'			=> $LNG['ov_abandon_planet'],
		'ov_planet_rename'			=> $LNG['ov_planet_rename'],
		'ov_planet_rename_action'	=> $LNG['ov_planet_rename_action'],	
		'ov_password'				=> $LNG['ov_password'],
		'ov_with_pass'				=> $LNG['ov_with_pass'],
		'ov_security_confirm'		=> $LNG['ov_security_confirm'],
		'ov_security_request'		=> $LNG['ov_security_request'],
		'ov_delete_planet'			=> $LNG['ov_delete_planet'],
		'ov_planet_abandoned'		=> $LNG['ov_planet_abandoned'],
		'path'						=> PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT,
	));
	
	$template->show("overview_body.tpl");
}
?>