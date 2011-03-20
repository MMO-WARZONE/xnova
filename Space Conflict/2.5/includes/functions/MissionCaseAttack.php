<?php

	/**
	 * This file is under the GPL liscence, which must be included with the file under distrobution (license.txt)
	 * this file was made by Xnova, edited to support Toms combat engine by Anthony (MadnessReD) [http://madnessred.co.cc/]
	 * Do not edit this comment block
	 */

	function MissionCaseAttack ( $FleetRow) {
		global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;

		//IPMORTANT!!! XNOVA 0.8? or SP1?
		/*
		If you are using X-Nova 0.8 you must change "$xnova_root_path" to "$ugamela_root_path".
		
		/* Below is the origional global, may need to pull some stuff across */
		//global $user, $phpEx, $ugamela_root_path, $pricelist, $lang, $resource, $CombatCaps;
		
		includelang('tech');
		includelang('system');
		
		doquery ("UPDATE {{table}} SET `small_protection_shield` =1 WHERE `small_protection_shield` >1;", 'planets')
			or die("Sorting Dome Cheaters:<br />".mysql_error());
		doquery ("UPDATE {{table}} SET `big_protection_shield` =1 WHERE `big_protection_shield` >1;", 'planets')
			or die("Sorting Dome Cheaters:<br />".mysql_error());
		/*
		doquery ("UPDATE {{table}} SET `sm_grav_dome` =1 WHERE `sm_grav_dome` >1;", 'planets')
			or die("Sorting Dome Cheaters:<br />".mysql_error());
		doquery ("UPDATE {{table}} SET `xl_grav_dome` =1 WHERE `xl_grav_dome` >1;", 'planets')
			or die("Sorting Dome Cheaters:<br />".mysql_error());
		*/
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time()) {
			
			if (!isset($CombatCaps[202]['sd'])) {
				message('<font color=red>'. $lang['sys_no_vars'] .'</font><br />(Error: <font color=red>(!isset($pricelist[202][\'sd\']))</font>. Please report this to an admin.)', $lang['sys_error'], 'fleet.php', 15);
			}

			//include toms stuff
			include($xnova_root_path."includes/functions/MissionCaseEvoAttack.php");
			
			// FROM HERE THE SCRIPT WAS IMPORTED (not TvdW code anymore)
			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
			$MoonChance       = $FleetDebris / 10000000;
       			if ($FleetDebris > 35000000) {
				$MoonChance = 35;
			}
			if ($FleetDebris < 10000000) {
				$UserChance = 0;
				$ChanceMoon = "";
			} elseif ($FleetDebris >= 10000000) {
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}	
			
			if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($galenemyrow['id_luna'] == 0)) {
				$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
				$GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$GottenMoon .= "<br />";
			} elseif ($UserChance = 0 or $UserChance > $MoonChance) {
				$GottenMoon = "";
			}
			
			//Start of Raid Points ((Anthony))
			/*
			$att_id = $CurrentUserID;
			$def_id = $TargetUserID;
			$att_dam = $zlom["atakujacy"];
			$def_dam = $zlom["wrog"];
			
			if($def_dam > $att_dam){
				$att_pts = round(sqrt($def_dam / (pow($att_dam, 2) + 1)));
				if ($att_pts > 10){
					$att_pts == 10;
				}
				$def_pts = 0;
				$raid_pts_mess = "The Attacker won ".$att_pts." points";
			}elseif($def_dam < $att_dam){
				$att_pts = 0;
				$def_pts = round(sqrt($att_dam / (pow($def_dam, 2) + 1)));
				if ($def_pts > 10){
					$def_pts == 10;
				}
				$raid_pts_mess = "The Defender won ".$def_pts." points";
			}else{
				$att_pts = 0;
				$def_pts = 0;
			}

			doquery("UPDATE {{table}} SET `lvl_raid` = `lvl_raid` + '".$att_pts."' WHERE `id` = '".$att_id."' ;", 'users');	
			doquery("UPDATE {{table}} SET `lvl_raid` = `lvl_raid` + '".$def_pts."' WHERE `id` = '".$def_id."' ;", 'users');

			doquery("UPDATE {{table}} SET `xpraid` = `xpraid` + '".$def_dam."' WHERE `id` = '".$att_id."' ;", 'users');	
			doquery("UPDATE {{table}} SET `xpraid` = `xpraid` + '".$att_dam."' WHERE `id` = '".$def_id."' ;", 'users');
			doquery("UPDATE {{table}} SET `xploss` = `xploss` + '".$att_dam."' WHERE `id` = '".$att_id."' ;", 'users');	
			doquery("UPDATE {{table}} SET `xploss` = `xploss` + '".$def_dam."' WHERE `id` = '".$def_id."' ;", 'users');
			*/
			//End of Raid Points
			
			//MadnessRed CR Creation.
			$formatted_cr = formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
			$raport = $formatted_cr['html'];

	
			$rid   = md5($raport);
			$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
			$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
			foreach ($attackFleets as $fleetID => $attacker) {
				$users2[$attacker['user']['id']] = $attacker['user']['id'];
			}
			foreach ($defense as $fleetID => $defender) {
				$users2[$defender['user']['id']] = $defender['user']['id'];
			}
			$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
			$QryInsertRapport .= '`rid` = "'. $rid .'", ';
			$QryInsertRapport .= '`raport` = "'. mysql_real_escape_string( $raport ) .'"';
			doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());
			
			// Colorize report.
            $raport  = '<a href # OnClick=\'f( "rw.php?raport='. $rid .'", "");\' >';
			$raport .= '<center>';
            if       ($result['won'] == 1) {
				$raport .= '<font color=\'green\'>';
            } elseif ($result['won'] == 0) {
				$raport .= '<font color=\'orange\'>';
            } elseif ($result['won'] == 2) {
				$raport .= '<font color=\'red\'>';
			}
			$raport .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br /><br />';
			$raport .= '<font color=\'red\'>'. $lang['sys_perte_attaquant'] .': '. $result['lost']['att'] .'</font>';
			$raport .= '<font color=\'green\'>   '. $lang['sys_perte_defenseur'] .': '. $result['lost']['def'] .'</font><br />' ;
            $raport .= $lang['sys_gain'] .' '. $lang['Metal'] .':<font color=\'#adaead\'>'. $steal['metal'] .'</font>   '. $lang['Crystal'] .':<font color=\'#ef51ef\'>'. $steal['crystal'] .'</font>   '. $lang['Deuterium'] .':<font color=\'#f77542\'>'. $steal['deuterium'] .'</font><br />';
            $raport .= $lang['sys_debris'] .' '. $lang['Metal'] .': <font color=\'#adaead\'>'. ($result['debree']['att'][0]+$result['debree']['def'][0]) .'</font>   '. $lang['Crystal'] .': <font color=\'#ef51ef\'>'. ($result['debree']['att'][1]+$result['debree']['def'][1]) .'</font><br /></center>';
			
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport );
			
			// Coloriize report.
			$raport2  = '<a href # OnClick=\'f( "rw.php?raport='. $rid .'", "");\' >';
			$raport2 .= '<center>';
			if       ($result['won'] == 1) {
				$raport2 .= '<font color=\'green\'>';
			} elseif ($result['won'] == 0) {
				$raport2 .= '<font color=\'orange\'>';
			} elseif ($result['won'] == 2) {
				$raport2 .= '<font color=\'red\'>';
			}
			$raport2 .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br /><br />';
			
			foreach ($users2 as $id) {
				if ($id != $FleetRow['fleet_owner'] && $id != 0) {
					SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );
				}
			}
			// Ajout du petit point raideur
			$AddPoint = $CurrentUser['xpraid'] + 1;

			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			$QryUpdateOfficier .= "`xpraid` = '" . $AddPoint . "' ";
			$QryUpdateOfficier .= "WHERE id = '" . $CurrentUserID . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
			// Ajout d'un point au compteur de raids
			$RaidsTotal = $CurrentUser['raids'] + 1;
			if ($FleetResult == "a") {
				$RaidsWin = $CurrentUser['raidswin'] + 1;
				$QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
				$QryUpdateRaidsCompteur .= "`raidswin` ='" . $RaidsWin . "', ";
				$QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
				$QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
				$QryUpdateRaidsCompteur .= "LIMIT 1 ;";
				doquery($QryUpdateRaidsCompteur, 'users');
			} elseif ($FleetResult == "r" || $FleetResult == "w") {
				$RaidsLoose = $CurrentUser['raidsloose'] + 1;
				$QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
				$QryUpdateRaidsCompteur .= "`raidsloose` ='" . $RaidsLoose . "', ";
				$QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
 				$QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
				$QryUpdateRaidsCompteur .= "LIMIT 1 ;";
				doquery($QryUpdateRaidsCompteur, 'users');
			}
		} elseif ($FleetRow['fleet_end_time'] <= time()) {
			RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
		}
	}

	// MadnessRed 2008
?>
