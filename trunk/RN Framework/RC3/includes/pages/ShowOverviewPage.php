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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowOverviewPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $dpath, $game_config, $lang, $planetrow, $user;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);
	$parse					= $lang;

	$FlyingFleetsTable = new FlyingFleetsTable();

	$lunarow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '" . $CurrentPlanet['id_owner'] . "' AND `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND `lunapos` = '" . $CurrentPlanet['planet'] . "';", 'lunas', true);
	CheckPlanetUsedFields($lunarow);

	$parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];

	switch ($_GET['mode'])
	{
		case 'renameplanet':

			if ($_POST['action'] == $lang['ov_planet_rename_action'])
			{
				$newname        = mysql_escape_string(strip_tags(trim($_POST['newname'])));

				if (preg_match("/[^A-z0-9_\- ]/", $newname) == 1)
				{
					message($lang['ov_newname_error'], "game.php?page=overview&mode=renameplanet",2);
				}
				if ($newname != "")
				{
					doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $CurrentUser['current_planet'] . "' LIMIT 1;", "planets");

					if ($CurrentPlanet['planet_type'] == 3)
					{
						doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND `lunapos` = '" . $CurrentPlanet['planet'] . "' LIMIT 1;", "lunas");
					}
				}
			}
			elseif ($_POST['action'] == $lang['ov_abandon_planet'])
			{
				return display(parsetemplate(gettemplate('overview/overview_deleteplanet'), $parse));
			}
			elseif ($_POST['kolonieloeschen'] == 1 && intval($_POST['deleteid']) == $CurrentUser['current_planet'])
			{
				if (md5($_POST['pw']) == $CurrentUser["password"] && $CurrentUser['id_planet'] != $CurrentUser['current_planet'])
				{

					doquery("UPDATE {{table}} SET `destruyed` = '".(time()+ 86400)."' WHERE `id` = '".mysql_real_escape_string($CurrentUser['current_planet'])."' LIMIT 1;" , 'planets');
					doquery("UPDATE {{table}} SET `current_planet` = `id_planet` WHERE `id` = '". mysql_real_escape_string($CurrentUser['id']) ."' LIMIT 1", "users");
	                doquery("DELETE FROM {{table}} WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."' AND `system` = '". $CurrentPlanet['system'] ."' AND `planet` = '". $CurrentPlanet['planet'] ."' AND `planet_type` = 3;", 'planets');
	                doquery("DELETE FROM {{table}} WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."' AND `system` = '". $CurrentPlanet['system'] ."' AND `lunapos` = '". $CurrentPlanet['planet'] ."';", 'lunas');

					message($lang['ov_planet_abandoned'], 'game.php?page=overview&mode=renameplanet');
				}
				elseif ($CurrentUser['id_planet'] == $CurrentUser["current_planet"])
				{
					message($lang['ov_principal_planet_cant_abanone'], 'game.php?page=overview&mode=renameplanet');
				}
				else
				{
					message($lang['ov_wrong_pass'], 'game.php?page=overview&mode=renameplanet');
				}
			}

			return display(parsetemplate(gettemplate('overview/overview_renameplanet'), $parse));
		break;

		default:
			if ($game_config['ts_modon'] == 1) {
				include_once($xgp_root . 'includes/classes/class.cyts.'.$phpEx);
				$ts = new cyts();
				if($ts->connect($game_config['ts_server'], $game_config['ts_tcpport'], $game_config['ts_udpport'], $game_config['ts_timeout'])){
					$tsdata = $ts->info_serverInfo();
					$tsdata2 = $ts->info_globalInfo();
					$maxusers = $tsdata["server_maxusers"];
					$useronline = $tsdata["server_currentusers"];
					$channels = $tsdata["server_currentchannels"];
					$seconds = $tsdata["server_uptime"];
					$os = $tsdata2["total_server_platform"];
					$version = $tsdata2["total_server_version"];
					$trafin = round($tsdata2["total_bytesreceived"] / 1024 / 1024, 2);
					$trafout = round($tsdata2["total_bytessend"] / 1024 / 1024, 2);
					$trafges = $trafin + $trafout;
					$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\"><a href=\"teamspeak://".$game_config['ts_server'].":".$game_config['ts_udpport']."?username=".$user['username']."\" alt=\"Teamspeak Connect\" name=\"Teamspeak Connect\">Connect</a> &bull; Online: " . $useronline . "/" . $maxusers . " &bull; Channels: " . $channels . " &bull; Traffic IN: " . $trafin . " MB &bull; Traffic Out: " . $trafout . " MB &bull; Traffic ges.: " . $trafges . " MB</th></tr>";
				} else {
					$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\">Server zurzeit nicht erreichbar. Wir bitten um verst&auml;ndnis.</th></tr>";
				}
			}
			$OnlineAdmins = doquery("SELECT * FROM {{table}} WHERE onlinetime>='".(time()-10*60)."' AND authlevel > 1",'users');
			if($OnlineAdmins) {
				$AdminsNr = 1;
				$parse['OnlineAdmins'] = "";
					while ($oas = mysql_fetch_array($OnlineAdmins)) {
						if ($AdminsNr == 1) {
							$parse['OnlineAdmins'] .= "<a href=\"game.php?page=messages&mode=write&id=". $oas['id'] ."\" >". $oas['username'] ."</a>";
						} else {
							$parse['OnlineAdmins'] .= "&nbsp;&bull;&nbsp;<a href=\"game.php?page=messages&mode=write&id=". $oas['id'] ."\" >". $oas['username'] ."</a>";					
						}
						$AdminsNr++;
					}
				} else {
				$parse['OnlineAdmins'] = "-";
			}
			if ($CurrentUser['new_message'] != 0)
			{
				$Have_new_message .= "<tr>";
				if ($CurrentUser['new_message'] == 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.$phpEx?page=messages>". $lang['ov_have_new_message'] ."</a></th>";
				}
				elseif ($CurrentUser['new_message'] > 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.$phpEx?page=messages>";
					$Have_new_message .= str_replace('%m', pretty_number($CurrentUser['new_message']), $lang['ov_have_new_messages']);
					$Have_new_message .= "</a></th>";
				}
				$Have_new_message .= "</tr>";
			}

			$OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $CurrentUser['id'] . "';", 'fleets');

			$Record = 0;

			while ($FleetRow = mysql_fetch_array($OwnFleets))
			{
				$Record++;

				$StartTime 	= $FleetRow['fleet_start_time'];
				$StayTime 	= $FleetRow['fleet_end_stay'];
				$EndTime 	= $FleetRow['fleet_end_time'];

				$Label = "fs";
				if ($StartTime > time())
				{
					$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10))
				{
					$Label = "ft";

					if ($StayTime > time())
					{
						$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > time())
					{
						$fpage[$EndTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}
			}

			$OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $CurrentUser['id'] . "';", 'fleets');

			$Record = 2000;
			while ($FleetRow = mysql_fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $CurrentUser['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime = $FleetRow['fleet_start_time'];
						$StayTime = $FleetRow['fleet_end_stay'];

						if ($StartTime > time())
						{
							$Label = "ofs";
							$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > time())
							{
								$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}

			$planets_query = doquery("SELECT * FROM `{{table}}` WHERE id_owner='{$CurrentUser['id']}' AND `destruyed` = 0", "planets");
			$Colone  	= 1;
			$AllPlanets = "<tr>";
            if ($game_config['OverviewNewsFrame'] == '1') {
            $parse['NewsFrame'] = "<tr><th>" . $lang['ov_news_title'] . "</th><th colspan=\"3\">" . stripslashes($game_config['OverviewNewsText']) . "</th></tr>";
            }  
			while ($CurrentUserPlanet = mysql_fetch_array($planets_query))
			{
				if ($CurrentUserPlanet["id"] != $CurrentUser["current_planet"] && $CurrentUserPlanet['planet_type'] != 3)
				{
					$Coloneshow++;
					$AllPlanets .= "<th>". $CurrentUserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"game.php?page=overview&cp=". $CurrentUserPlanet['id'] ."&re=0\" title=\"". $CurrentUserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $CurrentUserPlanet['image'] .".jpg\" height=\"50\" width=\"50\"></a><br>";
					$AllPlanets .= "<center>";

					if ($CurrentUserPlanet['b_building'] != 0)
					{
						UpdatePlanetBatimentQueueList ($CurrentUserPlanet, $CurrentUser);
						if ($CurrentUserPlanet['b_building'] != 0 )
						{
							$BuildQueue      = $CurrentUserPlanet['b_building_id'];
							$QueueArray      = explode ( ";", $BuildQueue );
							$CurrentBuild    = explode ( ",", $QueueArray[0] );
							$BuildElement    = $CurrentBuild[0];
							$BuildLevel      = $CurrentBuild[1];
							$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
							$AllPlanets     .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
							$AllPlanets     .= "<br><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
						}
						else
						{
							CheckPlanetUsedFields ($CurrentUserPlanet);
							$AllPlanets     .= $lang['ov_free'];
						}
					}
					else
					{
						$AllPlanets    .= $lang['ov_free'];
					}

					$AllPlanets .= "</center></th>";

					if ($Colone <= 1)
						$Colone++;
					else
					{
						$AllPlanets .= "</tr><tr>";
						$Colone = 1;
					}
				}
			}

			$AllPlanets .= "</tr>";

			if ($lunarow['id'] <> 0 && $lunarow['destruyed'] != 1 && $CurrentPlanet['planet_type'] != 3)
			{
				if ($CurrentPlanet['planet_type'] == 1 or $lunarow['id'] <> 0)
				{
					$moon = doquery ("SELECT `id`,`name`,`image` FROM {{table}} WHERE `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND `planet` = '" . $CurrentPlanet['planet'] . "' AND `planet_type` = '3'", 'planets', true);
					$parse['moon_img'] = "<a href=\"game.php?page=overview&cp=" . $moon['id'] . "&re=0\" title=\"" . $moon['name'] . "\"><img src=\"" . $dpath . "planeten/" . $moon['image'] . ".jpg\" height=\"50\" width=\"50\"></a>";
					$parse['moon'] = $moon['name'] ." (" . $lang['fcm_moon'] . ")";
				}
				else
				{
					$parse['moon_img'] = "";
					$parse['moon'] = "";
				}
			}
			else
			{
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}

			$parse['planet_diameter'] 		= pretty_number($CurrentPlanet['diameter']);
			$parse['planet_field_current']  = $CurrentPlanet['field_current'];
			$parse['planet_field_max'] 		= CalculateMaxPlanetFields($CurrentPlanet);
			$parse['planet_temp_min'] 		= $CurrentPlanet['temp_min'];
			$parse['planet_temp_max'] 		= $CurrentPlanet['temp_max'];

			$StatRecord = doquery("SELECT `total_rank`,`total_points` FROM `{{table}}` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $CurrentUser['id'] . "';", 'statpoints', true);

			$parse['user_username']        = $CurrentUser['username'];

			if (count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $time => $content)
				{
					$flotten .= $content . "\n";
				}
			}

			if ($CurrentPlanet['b_building'] != 0)
			{
				include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

				UpdatePlanetBatimentQueueList ($planetrow, $user);
				if ($CurrentPlanet['b_building'] != 0)
				{
					$BuildQueue  		 = explode (";", $CurrentPlanet['b_building_id']);
					$CurrBuild 	 		 = explode (",", $BuildQueue[0]);
					$RestTime 	 		 = $CurrentPlanet['b_building'] - time();
					$PlanetID 	 		 = $CurrentPlanet['id'];
					$Build 		 		 = InsertBuildListScript ("overview");
					$Build 	   			.= $lang['tech'][$CurrBuild[0]] . ' (' . ($CurrBuild[1]) . ')';
					$Build 				.= "<br /><div id=\"blc\" class=\"z\">" . pretty_time($RestTime) . "</div>";
					$Build 				.= "\n<script language=\"JavaScript\">";
					$Build 				.= "\n	pp = \"" . $RestTime . "\";\n";
					$Build 				.= "\n	pk = \"" . 1 . "\";\n";
					$Build 				.= "\n	pm = \"cancel\";\n";
					$Build 				.= "\n	pl = \"" . $PlanetID . "\";\n";
					$Build 				.= "\n	t();\n";
					$Build 				.= "\n</script>\n";
					$parse['building'] 	 = $Build;
				}
				else
				{
					$parse['building'] = $lang['ov_free'];
				}
			}
			else
			{
				$parse['building'] = $lang['ov_free'];
			}

			$parse['fleet_list']  			= $flotten;
			$parse['Have_new_message'] 		= $Have_new_message;
			$parse['planet_image'] 			= $CurrentPlanet['image'];
			$parse['anothers_planets'] 		= $AllPlanets;
			$parse["dpath"] 				= $dpath;
			if($game_config['stat'] == 0)
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			elseif($game_config['stat'] == 1 && $CurrentUser['authlevel'] < $game_config['stat_level'])
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			else
				$parse['user_rank']			= "-";

			$parse['date_time']				= date("D M j H:i:s", time());
			return display(parsetemplate(gettemplate('overview/overview_body'), $parse));
		break;
	}
}
?>