<?php

/**
 * overview.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 * modified by gianluca311 for XNova-Reloaded
 */

	$Query = $DB->prepare("SELECT * FROM ".PREFIX."lunas WHERE 
	`id_owner` = :id_owner AND
	`galaxy` = :galaxy AND 
	`system` = :system AND 
	`lunapos` = :planet
	");
	
	$Query->bindParam('id_owner', $planetrow['id_owner']);
	$Query->bindParam('galaxy', $planetrow['galaxy']);
	$Query->bindParam('system', $planetrow['system']);
	$Query->bindParam('planet', $planetrow['planet']);
	$Query->execute();
	$lunarow = $Query->fetch(PDO::FETCH_ASSOC);

	CheckPlanetUsedFields ($lunarow);

	$mode = $_GET['mode'];
	$pl = $_GET['pl'];
	$_POST['deleteid'] = intval($_POST['deleteid']);

	includeLang('resources');
	includeLang('overview');

	switch ($mode) {
		case 'umbenennen':
		define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
			// -----------------------------------------------------------------------------------------------
			if ($_POST['action'] == $lang['rename']) {
				// String überprüfen
				$UserPlanet     = CheckInputStrings ( $_POST['newname'] );
				$newname        = strip_tags(trim( $UserPlanet ));
				if ($newname != "") { // Wenn der Name nicht NULL ist
					//Update den Namen
					$Query = $DB->prepare("UPDATE ".PREFIX."planets SET `name` = :newname WHERE `id` = '". $user['current_planet'] ."' LIMIT 1");
					$Query->bindParam('newname', $newname);
					$Query->execute();
					// Wenns ein Mond ist
					if ($planetrow['planet_type'] == 3) {
						// Dann Update auch den Mondnamen in der lunas Tabelle
						$Query = $DB->prepare("UPDATE ".PREFIX."lunas SET `name` = :newname WHERE `galaxy` = '".$planetrow['galaxy']."' AND `system` = '".$planetrow['system']."' AND `lunapos` = '".$planetrow['planet']."' LIMIT 1;");
						$Query->bindParam('newname', $newname);
						$Query->execute();
					}
				}
				header('Location: indexGame.php?action=internalHome'); 
			}
			$parse = $lang;

			$parse['planet_id']     = $planetrow['id'];
			$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
			$parse['galaxy_system'] = $galaxyrow['system'];
			$parse['galaxy_planet'] = $galaxyrow['planet'];
			$parse['planet_name']   = $planetrow['name'];

			$page                  .= parsetemplate(gettemplate('overview_renameplanet'), $parse);

			display($page, $lang['rename_and_abandon_planet'], false);
			break;
			
			case 'loeschen':
			define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
			if ($_POST['kolonieloeschen'] == 1 && $_POST['deleteid'] == $user['current_planet']) {
			define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
				// Passwort überprüfen
				if (md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet']) { // wenns stimmt...
					
					// ... aus der Planets Tabelle löschen...
					$Query = $DB->prepare("DELETE FROM ".PREFIX."planets WHERE `id` = :current_planet LIMIT 1");
					$Query->bindParam('current_planet', $user['current_planet']);
					$Query->execute();
					
					// ... sowie aus der Galaxy...
					$Query = $DB->prepare("DELETE FROM ".PREFIX."galaxy WHERE `id_planet` = :current_planet LIMIT 1");
					$Query->bindParam('current_planet', $user['current_planet']);
					$Query->execute();
					
					// ...und der users
					$Query = $DB->prepare("UPDATE ".PREFIX."users SET `current_planet` = :id_planet WHERE `id` = :userid LIMIT 1");
					$Query->bindParam('id_planet', $user['id_planet']);
					$Query->bindParam('userid', $user['id']);
					$Query->execute();
					
					
					// Löschung erfolgreich
					message($lang['deletemessage_ok']."<meta http-equiv=\"refresh\" content=\"3; ?action=internalHome\";/>" , $lang['colony_abandon']);

				} elseif ($user['id_planet'] == $user["current_planet"]) {
					// Wenn der User den Hauptplaneten aufgeben will -> Nachticht das das nicht geht
					message($lang['deletemessage_wrong']."<meta http-equiv=\"refresh\" content=\"3; ?action=internalHome\";/>", $lang['colony_abandon']);

				} else {
					// wenn nichts zutrifft kann nur noch das Passwort falsch sein
					message($lang['deletemessage_fail']."<meta http-equiv=\"refresh\" content=\"3; ?action=internalHome\";/>" , $lang['colony_abandon']);

				}
				header('Location: indexGame.php?action=internalHome'); 
			}

			$parse = $lang;

			$parse['planet_id']     = $planetrow['id'];
			$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
			$parse['galaxy_system'] = $galaxyrow['system'];
			$parse['galaxy_planet'] = $galaxyrow['planet'];
			$parse['planet_name']   = $planetrow['name'];

			$page                  .= parsetemplate(gettemplate('overview_deleteplanet'), $parse);

			display($page, $lang['rename_and_abandon_planet'], false);
			break;

		default:
			// ---Neue Nachrichten ----------------------------------------------------------------------
			$Have_new_message = "";
			if ($user['new_message'] != 0) {
				$Have_new_message .= "<tr>";
				if       ($user['new_message'] == 1) {
					$Have_new_message .= "<th colspan=4><a href=\"?action=internalMessages\">". $lang['Have_new_message']."</a></th>";
				} elseif ($user['new_message'] > 1) {
					$Have_new_message .= "<th colspan=4><a href=\"?action=internalMessages\">";
					$m = pretty_number($user['new_message']);
					$Have_new_message .= str_replace('%m', $m, $lang['Have_new_messages']);
					$Have_new_message .= "</a></th>";
				}
				$Have_new_message .= "</tr>";
			}
			// -----------------------------------------------------------------------------------------------
			
			
			// --- Offiziere -------------------------------------------------------------------------
			
			$XpMinierUp  = $user['lvl_minier'] * 100000;
			$XpRaidUp    = $user['lvl_raid']   * 10;
			$XpMinier    = $user['xpminier'];
			$XPRaid      = $user['xpraid'];

			$LvlUpMinier = $user['lvl_minier'] + 1;
			$LvlUpRaid   = $user['lvl_raid']   + 1;

            if( ($LvlUpMinier + $LvlUpRaid) <= 100 ) {
				if ($XpMinier >= $XpMinierUp) {
					$DB->query("UPDATE ".PREFIX."users SET `lvl_minier` = '".$LvlUpMinier."', `rpg_points` = `rpg_points` + 1 WHERE `id` = '". $user['id'] ."';");
					
					$HaveNewLevelMineur  = "<tr>";
					$HaveNewLevelMineur .= "<th colspan=4><a href=officier.php>". $lang['Have_new_level_mineur']."</a></th>";
				}
				if ($XPRaid >= $XpRaidUp) {
					$DB->query("UPDATE ".PREFIX."users SET `lvl_minier` = '".$LvlUpRaid."', `rpg_points` = `rpg_points` + 1 WHERE `id` = '". $user['id'] ."';");
					$HaveNewLevelMineur  = "<tr>";
					$HaveNewLevelMineur .= "<th colspan=4><a href=officier.php>". $lang['Have_new_level_raid']."</a></th>";
				}
			}
			// -----------------------------------------------------------------------------------------------

			// --- Gestion des flottes personnelles ---------------------------------------------------------
			// Toutes de vert vetues
			$Record          = 0;
			foreach ($DB->query("SELECT * FROM ".PREFIX."fleets WHERE `fleet_owner` = '". $user['id'] ."';") as $FleetRow) {
				$Record++;

				$StartTime   = $FleetRow['fleet_start_time'];
				$StayTime    = $FleetRow['fleet_end_stay'];
				$EndTime     = $FleetRow['fleet_end_time'];

				// Flotte a l'aller
				$Label = "fs";
				if ($StartTime > time()) {
					$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, true, $Label, $Record );
				}

				if ($FleetRow['fleet_mission'] <> 4) {
					// Flotte en stationnement
					$Label = "ft";
					if ($StayTime > time()) {
						$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, true, $Label, $Record );
					}

					// Flotte au retour
					$Label = "fe";
					if ($EndTime > time()) {
						$fpage[$EndTime]  = BuildFleetEventTable ( $FleetRow, 2, true, $Label, $Record );
					}
				}
			} // End While

			// -----------------------------------------------------------------------------------------------

			// --- Gestion des flottes autres que personnelles ----------------------------------------------
			// Flotte ennemies (ou amie) mais non personnelles
			$Record          = 2000;
			foreach ($DB->query("SELECT * FROM ".PREFIX."fleets WHERE `fleet_target_owner` = '".$user['id']."';") as $FleetRow) {
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
							// Flotte en stationnement
							$Label = "oft";
							if ($StayTime > time()) {
								$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, false, $Label, $Record );
							}
						}
					}
				}
			}

			// -----------------------------------------------------------------------------------------------

			// --- Gestion de la liste des planetes ----------------------------------------------------------
			// Planetes ...
			$Colone  = 1;

			$AllPlanets = "<tr>";
			foreach ($DB->query("SELECT * FROM ".PREFIX."planets WHERE id_owner='".$user['id']."'") as $UserPlanet) {
				if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
					$AllPlanets .= "<th>". $UserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"?cp=". $UserPlanet['id'] ."&amp;re=0\" title=\"". $UserPlanet['name'] ."\"><img src=\"images/planeten/gross/". $UserPlanet['image'] .".jpg\" height=\"70\" width=\"70\" alt=\"{$UserPlanet['name']}\"></a><br>";
					$AllPlanets .= "<center>";

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
					if ($Colone <= 3) {
						$Colone++;
					} else {
						$AllPlanets .= "</tr><tr>";
						$Colone      = 1;
					}
				}
			}
			// -----------------------------------------------------------------------------------------------

			// --- Gestion des attaques missiles -------------------------------------------------------------
			$Record = 4000;
			foreach ($DB->query("SELECT * FROM ".PREFIX."iraks WHERE owner ='". $user['id']."'") as $irak) {
				$Record++;
				$fpage[$irak['zeit']] = '';

				if ($irak['zeit'] > time()) {
					$time = $irak['zeit'] - time();

					$fpage[$irak['zeit']] .= InsertJavaScriptChronoApplet ( "fm", $Record, $time, true );

					$query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE galaxy = '" . $irak['galaxy'] . "' AND system = '" . $irak['system'] . "' AND planet = '" . $irak['planet'] . "' AND planet_type = '1'");

					
					$Query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE galaxy = '" . $irak['galaxy_angreifer'] . "' AND system = '" . $irak['system_angreifer'] . "' AND planet = '" . $irak['planet_angreifer'] . "' AND planet_type = '1'");
					$userplanet = $Query->fetch(); 
					
					if (sql_num_rows($query) == 1) {
						$planet = $query->fetch();
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

			// -----------------------------------------------------------------------------------------------

			$parse                         = $lang;
			
			//Planeten Typ
			if ($planetrow['planet_type'] == 3)
				$parse['planet_type'] = $lang['your_moon']; // Entweder Mond
			else
				$parse['planet_type'] = $lang['your_planet']; // Oder Planet
			

			// -----------------------------------------------------------------------------------------------
			// News Frame ...
			// External Chat Frame ...
			// Banner ADS Google (meme si je suis contre cela)
			if ($game_config['OverviewNewsFrame'] == '1') {
				$parse['NewsFrame']          = "<tr><th>". $lang['ov_news_title'] ."</th><th colspan=\"3\">". nl2br(stripslashes($game_config['OverviewNewsText'])) ."</th></tr>";
			}
			if ($game_config['OverviewExternChat'] == '1') {
				$parse['ExternalTchatFrame'] = "<tr><th colspan=\"4\">". stripslashes( $game_config['OverviewExternChatCmd'] ) ."</th></tr>";
			}
			if ($game_config['OverviewClickBanner'] != '') {
				$parse['ClickBanner'] = stripslashes( $game_config['OverviewClickBanner'] );
			}

			// --- Gestion de l'affichage d'une lune ---------------------------------------------------------
			if ($planetrow['galaxy'] == $lunarow['galaxy'] && $planetrow['system'] == $lunarow['system'] && $planetrow['planet'] == $lunarow['lunapos'] && $planetrow['planet_type'] != 3) {
				
				$Query = $DB->prepare("SELECT * FROM ".PREFIX."planets WHERE 
				galaxy = :galaxy AND
				system = :system AND
				planet = :planet AND
				planet_type = 3
				");
				$Query->bindParam('galaxy', $lunarow['galaxy']);
				$Query->bindParam('system', $lunarow['system']);
				$Query->bindParam('planet', $lunarow['lunapos']);
				$Query->execute();
				$lune = $Query->fetch();
				
				$parse['DeinMond'] = "<u>Dein Mond:</u>";
				$parse['moon_img'] = "<a href=\"?cp={$lune['id']}&amp;re=0\" title=\"{$UserPlanet['name']}\"><img src=\"images/planeten/gross/{$lunarow['image']}.jpg\" height=\"80\" width=\"80\" alt=\"{$lunarow['name']}\"></a>";
				$parse['moon'] = $lunarow['name'];
			} else {
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}
			// Moon END

			$parse['planet_name']          = $planetrow['name'];
			$parse['planet_diameter']      = pretty_number($planetrow['diameter']);
			$parse['planet_field_current'] = $planetrow['field_current'];
			$parse['planet_field_max']     = CalculateMaxPlanetFields($planetrow);
			$parse['planet_temp_min']      = $planetrow['temp_min'];
			$parse['planet_temp_max']      = $planetrow['temp_max'];
			$parse['galaxy_galaxy']        = $planetrow['galaxy'];
			$parse['galaxy_planet']        = $planetrow['planet'];
			$parse['galaxy_system']        = $planetrow['system'];

			if (count($fpage) > 0) {
				ksort($fpage);
				foreach ($fpage as $time => $content) {
					$flotten .= $content . "\n";
				}
			}

			$parse['fleet_list']  = $flotten;
			$parse['energy_used'] = $planetrow["energy_max"] - $planetrow["energy_used"];
			$parse['DeinePlanis'] = '<tr><td class ="c" width="519" height="1" align="left" valign="top" colspan="4"><center><b>Weitere Kolonien deines Imperiums</b></center></td></tr>';
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
				$parse['get_link'] = " (<a href=\"?action=internalQuickfleet&amp;mode=8&amp;g=".$galaxyrow['galaxy']."&amp;s=".$galaxyrow['system']."&amp;p=".$galaxyrow['planet']."&amp;t=2\">". $lang['type_mission'][8] ."</a>)";
			} else {
				$parse['get_link'] = '';
			}

	UpdatePlanetBatimentQueueList ( $planetrow, $user );		
	if ( $planetrow['b_building'] != 0 ) {
		
		$BuildQueue = explode (";", $planetrow['b_building_id']);
		$CurrBuild  = explode (",", $BuildQueue[0]);
		$RestTime   = $planetrow['b_building'] - time();
		$PlanetID   = $planetrow['id'];

		$parse['building'] = "<th>".countdown('gebaude', $RestTime, 'Kontrollzentrum')."</th><th>".$lang['tech'][$CurrBuild[0]]." (Stufe ".$CurrBuild[1].") </th>";
	} else {
		$parse['building'] = "<th>&nbsp;</th><th>&nbsp;</th>";
	}

	if ( $planetrow['b_tech'] != 0 ) {
   		HandleTechnologieBuild ( $planetrow, $user );
    	if ( $planetrow['b_tech'] != 0 ) {
   			$BuildQueue = explode (";", $planetrow['b_tech_id']);
   			$CurrBuild  = explode (",", $BuildQueue[0]);
    		$RestTime   = $planetrow['b_tech'] - time();
    		$PlanetID   = $planetrow['id'];
    		$parse['tech'] = "<th>".Countdown("forschung",$RestTime, 'Kontrollzentrum')."</th><th>".$lang['tech'][$CurrBuild[0]]."</th>";
   		} else {
    		$parse['tech'] = "<th>&nbsp;</th><th>&nbsp;</th>";
    	}
	} else {
		$parse['tech'] = "<th>&nbsp;</th><th>&nbsp;</th>";
	} 
	
	//Flotten und Deff
	
	if ( $planetrow['b_hangar_id'] != 0 ) {
		$HangarQueue = explode (";", $planetrow['b_hangar_id']);
		$CurrBuild  = explode (",", $HangarQueue[0]);
		$time = GetBuildingTime("", $planetrow, $CurrBuild[0]);
		$totaltime = $time - $planetrow['b_hangar'];
		
			if ( $CurrBuild[0] >= 202 && $CurrBuild[0] <= 215)
				$parse['fleet'] = "<th>".Countdown("Flotte",$totaltime, 'Kontrollzentrum')."</th><th>".$lang['tech'][$CurrBuild[0]]."</th>";
			else
				$parse['fleet'] = "<th>&nbsp;</th><th>&nbsp;</th>";
				
			if ( $CurrBuild[0] >= 401 && $CurrBuild[0] <= 503)
				$parse['def'] = "<th>".Countdown("Verteidigung",$totaltime, 'Kontrollzentrum')."</th><th>".$lang['tech'][$CurrBuild[0]]."</th>";
			else
				$parse['def'] = "<th>&nbsp;</th><th>&nbsp;</th>";
	}else {
		$parse['fleet'] = "<th>&nbsp;</th><th>&nbsp;</th>";
		$parse['def'] = "<th>&nbsp;</th><th>&nbsp;</th>";
	} 
			
			{ // Vista normal
				$Query   = $DB->query("SELECT `username` FROM `".PREFIX."users` ORDER BY `register_time` DESC LIMIT 1");
				$query = $Query->fetch(PDO::FETCH_ASSOC);
				$parse['last_user'] = $query['username'];
				
				$Query = $DB->query("SELECT COUNT(DISTINCT(id)) AS `0` FROM `".PREFIX."users` WHERE `onlinetime` > '" . (time()-900) ."'");
				$query = $Query->fetch(PDO::FETCH_ASSOC);
				$parse['online_users'] = $query[0];
				
				$parse['users_amount'] = $game_config['users_amount'];
			}
			// Rajout d'une barre pourcentage
			// Calcul du pourcentage de remplissage
			$parse['case_pourcentage'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) . $lang['o/o'];
			// Barre de remplissage
			$parse['case_barre'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) * 2.5;
			// Couleur de la barre de remplissage
			if ($parse['case_barre'] > (100 * 2.5)) {
				$parse['case_barre'] = 250;
				$parse['case_barre_barcolor'] = '#C00000';
			} elseif ($parse['case_barre'] > (80 * 2.5)) {
				$parse['case_barre_barcolor'] = '#C0C000';
			} else {
				$parse['case_barre_barcolor'] = '#00C000';
			}

            //Mode Améliorations
			$parse['xpminier']= $user['xpminier'];
			$parse['xpraid']= $user['xpraid'];
			$parse['lvl_minier'] = $user['lvl_minier'];
			$parse['lvl_raid'] = $user['lvl_raid'];

			$LvlMinier = $user['lvl_minier'];
			$LvlRaid = $user['lvl_raid'];

			$parse['lvl_up_minier'] = $LvlMinier * 100000;
			$parse['lvl_up_raid']   = $LvlRaid * 10;

           		 //Extras
			$parse['avatar'] = $user['avatar'];

			//Compteur de Membres en lign
			$Query = $DB->query("SELECT COUNT(*) FROM ".PREFIX."users WHERE onlinetime>='".(time()-15*60)."'");
			$OnlineUsers = $Query->fetch();
			$parse['NumberMembersOnline'] = $OnlineUsers['COUNT(*)'];
			$Query2 = $DB->query("SELECT COUNT(username) FROM ".PREFIX."users");
			$userc = $Query2->fetch();
			$parse['total_users'] 		   = $userc['COUNT(username)'];

			$page = parsetemplate(gettemplate('overview_body'), $parse);

			display($page, $lang['Overview']);
			break;
	}

?>
