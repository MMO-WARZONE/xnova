<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** overview.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


	$nick = $user['username'];

	$lunarow   = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$planetrow['id_owner']."' AND `galaxy` = '".$planetrow['galaxy']."' AND `system` = '".$planetrow['system']."' AND `lunapos` = '".$planetrow['planet']."';", 'lunas', true);

	CheckPlanetUsedFields ($lunarow);

	$mode = $_GET['mode'];
	$pl = mysql_escape_string($_GET['pl']);
	$_POST['deleteid'] = intval($_POST['deleteid']);

	includeLang('resources');
	includeLang('overview');

	switch ($mode) {

// Rename or Abandon Planet
	case 'renameplanet':
		if ($_POST['action'] == $lang['namer']) {
		// Rename Planet
			$UserPlanet     = CheckInputStrings ( $_POST['newname'] );
			$newname        = mysql_escape_string(strip_tags(trim( $UserPlanet )));
			if ($newname != "") {
				$planetrow['name'] = $newname;
			doquery("UPDATE {{table}} SET `name` = '".$newname."' WHERE `id` = '". $user['current_planet'] ."' LIMIT 1;", "planets");
				if ($planetrow['planet_type'] == 3) {
					doquery("UPDATE {{table}} SET `name` = '".$newname."' WHERE `galaxy` = '".$planetrow['galaxy']."' AND `system` = '".$planetrow['system']."' AND `lunapos` = '".$planetrow['planet']."' LIMIT 1;", "lunas");
				}
			}

		// Abandon Planet
		} elseif ($_POST['action'] == $lang['colony_abandon']) {
			$parse                   = $lang;
			$parse['planet_id']      = $planetrow['id'];
			$parse['galaxy_galaxy']  = $galaxyrow['galaxy'];
			$parse['galaxy_system']  = $galaxyrow['system'];
			$parse['galaxy_planet']  = $galaxyrow['planet'];
			$parse['planet_name']    = $planetrow['name'];

			$page                   .= parsetemplate(gettemplate('overview_deleteplanet'), $parse);

			display($page, $lang['rename_and_abandon_planet']);

		} elseif ($_POST['kolonieloeschen'] == 1 && $_POST['deleteid'] == $user['current_planet']) {

			if (md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet'] && $planetrow['planet_type'] != 3) {
				include_once($ugamela_root_path . 'includes/functions/AbandonColony.' . $phpEx);
			if (CheckFleets($planetrow)){
				$strMessage = "Cannot abandon colony! A fleet is still present";
				message($strMessage, $lang['colony_abandon'], 'overview.php?mode=renameplanet',3);
			}
			AbandonColony($user,$planetrow);
				$QryUpdateUser = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`current_planet` = `id_planet` ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '" . $user['id'] . "' LIMIT 1";
			doquery($QryUpdateUser, "users");
			message($lang['deletemessage_ok'] , $lang['colony_abandon'], 'overview.php',3);
		} elseif ($planetrow['planet_type'] == 3) {
			message($lang['deletemessage_wrong_moon'], $lang['colony_abandon'], 'overview.php?mode=renameplanet');
		}else {
			message($lang['deletemessage_fail'] , $lang['colony_abandon'], 'overview.php?mode=renameplanet');

			}
		}

			$parse = $lang;
			$parse['planet_id']     = $planetrow['id'];
			$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
			$parse['galaxy_system'] = $galaxyrow['system'];
			$parse['galaxy_planet'] = $galaxyrow['planet'];
			$parse['planet_name']   = $planetrow['name'];

			$page                  .= parsetemplate(gettemplate('overview_renameplanet'), $parse);

			display($page, $lang['rename_and_abandon_planet']);
			break;

// Default Overview Page
	default:

	// Check For Messages
		$Have_new_message = "";
		if ($user['new_message'] != 0) {
			$Have_new_message .= "<tr>";
			if       ($user['new_message'] == 1) {
				$Have_new_message .= "<th colspan=4><a href=messages.$phpEx>". $lang['Have_new_message']."</a></th>";
			} elseif ($user['new_message'] > 1) {
				$Have_new_message .= "<th colspan=4><a href=messages.$phpEx>";
				$m = pretty_number($user['new_message']);
				$Have_new_message .= str_replace('%m', $m, $lang['Have_new_messages']);
				$Have_new_message .= "</a></th>";
			}
				$Have_new_message .= "</tr>";
		}

	// Check for Miner or Raider Levels
		$XpMinierUp  = $user['lvl_minier'] * 50;
		$XpRaidUp    = $user['lvl_raid']   * 10;
		$XpMinier    = $user['xpminier'];
		$XPRaid      = $user['xpraid'];

		$LvlUpMinier = $user['lvl_minier'] + 1;
		$LvlUpRaid   = $user['lvl_raid']   + 1;

		if( ($LvlUpMinier + $LvlUpRaid) <= 100 ) {
			if ($XpMinier >= $XpMinierUp) {
				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`lvl_minier` = '".$LvlUpMinier."', ";
				$QryUpdateUser .= "`rpg_points` = `rpg_points` + 5000 ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $user['id'] ."';";
			doquery( $QryUpdateUser, 'users');
				$HaveNewLevelMineur  = "<tr>";
				$HaveNewLevelMineur .= "<th colspan=4><a href=officier.$phpEx>". $lang['Have_new_level_mineur']."</a></th>";
			}
			if ($XPRaid >= $XpRaidUp) {
				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`lvl_raid` = '".$LvlUpRaid."', ";
				$QryUpdateUser .= "`rpg_points` = `rpg_points` + 10000 ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $user['id'] ."';";
			doquery( $QryUpdateUser, 'users');
				$HaveNewLevelMineur  = "<tr>";
				$HaveNewLevelMineur .= "<th colspan=4><a href=officier.$phpEx>". $lang['Have_new_level_raid']."</a></th>";
			}
		}

	// Check User Fleet Activity
		$OwnFleets       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
		$Record          = 0;
		while ($FleetRow = mysql_fetch_array($OwnFleets)) {
			$Record++;
			$StartTime   = $FleetRow['fleet_start_time'];
			$StayTime    = $FleetRow['fleet_end_stay'];
			$EndTime     = $FleetRow['fleet_end_time'];

		// Fleets in Mission
			$Label = "fs";
			if ($StartTime > time()) {
				$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, true, $Label, $Record );
			}

		// Fleets Deployed
			if ($FleetRow['fleet_mission'] <> 4) {
				$Label = "ft";
				if ($StayTime > time()) {
					$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, true, $Label, $Record );
				}

		// Fleets Returning
			$Label = "fe";
				if ($EndTime > time()) {
					$fpage[$EndTime]  = BuildFleetEventTable ( $FleetRow, 2, true, $Label, $Record );
				}
			}
		} // End While


	// Check Enemy or Ally Fleet Activity
		$OtherFleets     = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '".$user['id']."';", 'fleets');
		$Record          = 2000;
		while ($FleetRow = mysql_fetch_array($OtherFleets)) {
			if ($FleetRow['fleet_owner'] != $user['id']) {
				if ($FleetRow['fleet_mission'] != 8) {
					$Record++;
					$StartTime = $FleetRow['fleet_start_time'];
					$StayTime  = $FleetRow['fleet_end_stay'];

					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, false, $Label, $Record );
					}
					if ($FleetRow['fleet_mission'] == 5) {
						$Label = "oft";
						if ($StayTime > time()) {
							$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, false, $Label, $Record );
						}
					}
				}
			}
		}

	// Show Planet Lists
		$planets_query = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user['id']}'", "planets");
		$Colone  = 1;
		$AllPlanets = "<tr>";
		while ($UserPlanet = mysql_fetch_array($planets_query)) {
			if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
				$AllPlanets .= "<th>". $UserPlanet['name'] ."<br>";
				$AllPlanets .= "<a href=\"?cp=". $UserPlanet['id'] ."&re=0\" title=\"". $UserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $UserPlanet['image'] .".jpg\" height=\"50\" width=\"50\"></a><br>";
				$AllPlanets .= "<center>";

			// Check Building Queue
				if ($UserPlanet['b_building'] != 0) {
					UpdatePlanetBatimentQueueList ( $UserPlanet, $user );
					if ( $UserPlanet['b_building'] != 0 ) {
						$BuildQueue      = $UserPlanet['b_building_id'];
						$QueueArray      = explode ( ";", $BuildQueue );
						$CurrentBuild    = explode ( ",", $QueueArray[0] );
						$BuildElement    = $CurrentBuild[0];
						$BuildLevel      = $CurrentBuild[1];
						$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
						$AllPlanets     .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
						$AllPlanets     .= "<br><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
					} else {
						CheckPlanetUsedFields ($UserPlanet);
						$AllPlanets     .= $lang['Free'];
					}
				} else {
					$AllPlanets    .= $lang['Free'];
				}

				$AllPlanets .= "</center></th>";
				if ($Colone <= 1) {
					$Colone++;
				} else {
					$AllPlanets .= "</tr><tr>";
					$Colone      = 1;
				}
			}
		}

	// Show Missile Attacks
		$iraks_query = doquery("SELECT * FROM {{table}} WHERE owner = '" . $user['id'] . "'", 'iraks');
		$Record = 4000;
		while ($irak = mysql_fetch_array ($iraks_query)) {
			$Record++;
			$fpage[$irak['zeit']] = '';

			if ($irak['zeit'] > time()) {
				$time = $irak['zeit'] - time();

				$fpage[$irak['zeit']] .= InsertJavaScriptChronoApplet ( "fm", $Record, $time, true );

				$planet_start = doquery("SELECT * FROM {{table}} WHERE
				galaxy = '" . $irak['galaxy'] . "' AND
				system = '" . $irak['system'] . "' AND
				planet = '" . $irak['planet'] . "' AND
				planet_type = '1'", 'planets');

				$user_planet = doquery("SELECT * FROM {{table}} WHERE
				galaxy = '" . $irak['galaxy_angreifer'] . "' AND
				system = '" . $irak['system_angreifer'] . "' AND
				planet = '" . $irak['planet_angreifer'] . "' AND
				planet_type = '1'", 'planets', true);

				if (mysql_num_rows($planet_start) == 1) {
					$planet = mysql_fetch_array($planet_start);
				}

				$fpage[$irak['zeit']] .= "<tr><th><div id=\"bxxfs$i\" class=\"z\"></div><font color=\"lime\">" . gmdate("H:i:s", $irak['zeit'] + 1 * 60 * 60) . "</font> </th><th colspan=\"3\"><font color=\"#0099FF\">Une attaque de missiles (" . $irak['anzahl'] . ") de " . $user_planet['name'] . " ";
				$fpage[$irak['zeit']] .= '<a href="galaxy.php?mode=3&galaxy=' . $irak["galaxy_angreifer"] . '&system=' . $irak["system_angreifer"] . '&planet=' . $irak["planet_angreifer"] . '">[' . $irak["galaxy_angreifer"] . ':' . $irak["system_angreifer"] . ':' . $irak["planet_angreifer"] . ']</a>';
				$fpage[$irak['zeit']] .= ' arrive sur la plan&egrave;te' . $planet["name"] . ' ';
				$fpage[$irak['zeit']] .= '<a href="galaxy.php?mode=3&galaxy=' . $irak["galaxy"] . '&system=' . $irak["system"] . '&planet=' . $irak["planet"] . '">[' . $irak["galaxy"] . ':' . $irak["system"] . ':' . $irak["planet"] . ']</a>';
				$fpage[$irak['zeit']] .= '</font>';
				$fpage[$irak['zeit']] .= InsertJavaScriptChronoApplet ( "fm", $Record, $time, false );
				$fpage[$irak['zeit']] .= "</th>";
			}
		}

	// Additional Overview Displays
		$parse                         = $lang;

		// News Display
		if ($game_config['OverviewNewsFrame'] == '1') {
			$parse['NewsFrame']          = "<tr><th>". $lang['ov_news_title'] ."</th><th colspan=\"3\">". stripslashes($game_config['OverviewNewsText']) ."</th></tr>";
		}

		// External Chat Display
		if ($game_config['OverviewExternChat'] == '1') {
			$parse['ExternalTchatFrame'] = "<tr><th colspan=\"4\">". stripslashes( $game_config['OverviewExternChatCmd'] ) ."</th></tr>";
		}

		// Banner Display
		if ($game_config['OverviewClickBanner'] != '') {
			$parse['ClickBanner'] = stripslashes( $game_config['OverviewClickBanner'] );
		}

		// Show Moon
			if ($planetrow['galaxy'] == $lunarow['galaxy'] && $planetrow['system'] == $lunarow['system'] && $planetrow['planet'] == $lunarow['lunapos'] && $planetrow['planet_type'] != 3) {
				$lune = doquery("SELECT * FROM {{table}} WHERE `galaxy`='".$lunarow['galaxy']."' AND `system`='".$lunarow['system']."' AND `planet`='".$lunarow['lunapos']."' AND `planet_type`='3'", 'planets', true);
				$parse['moon_img'] = "<a href=\"?cp={$lune['id']}&re=0\" title=\"{$UserPlanet['name']}\"><img src=\"{$dpath}planeten/{$lunarow['image']}.jpg\" height=\"50\" width=\"50\"></a>";
				$parse['moon'] = $lunarow['name'];
			} else {
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}

	// User and Planet Statistics Display
		$parse['planet_name']          = $planetrow['name'];
		$parse['planet_diameter']      = pretty_number($planetrow['diameter']);
		$parse['planet_field_current'] = $planetrow['field_current'];
		$parse['planet_field_max']     = CalculateMaxPlanetFields($planetrow);
		$parse['planet_temp_min']      = $planetrow['temp_min'];
		$parse['planet_temp_max']      = $planetrow['temp_max'];
		$parse['galaxy_galaxy']        = $planetrow['galaxy'];
		$parse['galaxy_planet']        = $planetrow['planet'];
		$parse['galaxy_system']        = $planetrow['system'];
		$StatRecord = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);

		$parse['user_points']          = pretty_number( $StatRecord['build_points'] );
		$parse['user_fleet']           = pretty_number( $StatRecord['fleet_points'] );
		$parse['player_points_tech']   = pretty_number( $StatRecord['tech_points'] );
		$parse['total_points']         = pretty_number( $StatRecord['total_points'] );;

		$parse['user_rank']            = $StatRecord['total_rank'];
		$ile = $StatRecord['total_old_rank'] - $StatRecord['total_rank'];
		if ($ile >= 1) {
			$parse['ile']              = "<font color=lime>+" . $ile . "</font>";
		} elseif ($ile < 0) {
			$parse['ile']              = "<font color=red>-" . $ile . "</font>";
		} elseif ($ile == 0) {
			$parse['ile']              = "<font color=lightblue>" . $ile . "</font>";
		}
		$parse['u_user_rank']          = $StatRecord['total_rank'];
		$parse['user_username']        = $user['username'];

		if (count($fpage) > 0) {
			ksort($fpage);
			foreach ($fpage as $time => $content) {
				$flotten .= $content . "\n";
			}
		}

		$parse['fleet_list']  = $flotten;
		$parse['energy_used'] = $planetrow["energy_max"] - $planetrow["energy_used"];

		$parse['Have_new_message']      = $Have_new_message;
		$parse['Have_new_level_mineur'] = $HaveNewLevelMineur;
		$parse['Have_new_level_raid']   = $HaveNewLevelRaid;
		$parse['time']                  = date("D M d H:i:s", time());
		$parse['dpath']                 = $dpath;
		$parse['planet_image']          = $planetrow['image'];
		$parse['anothers_planets']      = $AllPlanets;
		$parse['max_users']             = $game_config['users_amount'];

		$parse['metal_debris']          = pretty_number($galaxyrow['metal']);
		$parse['crystal_debris']        = pretty_number($galaxyrow['crystal']);
		if (($galaxyrow['metal'] != 0 || $galaxyrow['crystal'] != 0) && $planetrow[$resource[209]] != 0) {
			$parse['get_link'] = " (<a href=\"quickfleet.php?mode=8&g=".$galaxyrow['galaxy']."&s=".$galaxyrow['system']."&p=".$galaxyrow['planet']."&t=2\">". $lang['type_mission'][8] ."</a>)";
		} else {
			$parse['get_link'] = '';
		}

		if ( $planetrow['b_building'] != 0 ) {
			UpdatePlanetBatimentQueueList ( $planetrow, $user );
			if ( $planetrow['b_building'] != 0 ) {
				$BuildQueue = explode (";", $planetrow['b_building_id']);
				$CurrBuild  = explode (",", $BuildQueue[0]);
				$RestTime   = $planetrow['b_building'] - time();
				$PlanetID   = $planetrow['id'];
				$Build  = InsertBuildListScript ( "overview" );
				$Build .= $lang['tech'][$CurrBuild[0]] .' ('. ($CurrBuild[1]) .')';
				$Build .= "<br /><div id=\"blc\" class=\"z\">". pretty_time( $RestTime ) ."</div>";
				$Build .= "\n<script language=\"JavaScript\">";
				$Build .= "\n	pp = \"". $RestTime ."\";\n";
				$Build .= "\n	pk = \"". 1 ."\";\n";
				$Build .= "\n	pm = \"cancel\";\n";
				$Build .= "\n	pl = \"". $PlanetID ."\";\n";
				$Build .= "\n	t();\n";
				$Build .= "\n</script>\n";

				$parse['building'] = $Build;
			} else {
				$parse['building'] = $lang['Free'];
			}
		} else {
			$parse['building'] = $lang['Free'];
		}
		{
			$query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true);
				$parse['last_user'] = $query['username'];
			$query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
				$parse['online_users'] = $query[0];
				// $count = doquery(","users",true);
				$parse['users_amount'] = $game_config['users_amount'];
		}

	// Planet Development Percentage bar
		$parse['case_pourcentage'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) . $lang['o/o'];
		$parse['case_barre'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) * 2.5;

		if ($parse['case_barre'] > (100 * 2.5)) {
			$parse['case_barre'] = 400;
			$parse['case_barre_barcolor'] = '#C00000';
		} elseif ($parse['case_barre'] > (80 * 2.5)) {
			$parse['case_barre_barcolor'] = '#C0C000';
		} else {
			$parse['case_barre_barcolor'] = '#00C000';
		}

	// Mining and Raid level Improvements
		$parse['xpminier']= $user['xpminier'];
		$parse['xpraid']= $user['xpraid'];
		$parse['lvl_minier'] = $user['lvl_minier'];
		$parse['lvl_raid'] = $user['lvl_raid'];

		$LvlMinier = $user['lvl_minier'];
		$LvlRaid = $user['lvl_raid'];

		$parse['lvl_up_minier'] = $LvlMinier * 50;
		$parse['lvl_up_raid']   = $LvlRaid * 10;
	
		$parse['gameurl'] = GAMEURL;
		$parse['kod'] = $user['kiler'];

	// Number of Online Players
		$OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='".(time()-15*60)."'",'users', 'true');
		$parse['NumberMembersOnline'] = $OnlineUsers[0];

// Show Adsense Ad
	if ($adsense_config['overview_on'] == 1) {
		$parse['overview_script']  = "<div>".$adsense_config['overview_script']."</div>";
	} else {
		$parse['overview_script']  = "";
	}

	display(parsetemplate(gettemplate('overview_body'), $parse), $lang['Overview']);
			break;
	}
	
/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>