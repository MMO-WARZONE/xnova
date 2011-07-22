<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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
	
    global $xgp_root, $phpEx, $dpath, $game_config, $lang, $planetrow, $user, $resource;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);
	include_once($xgp_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);

	$FlyingFleetsTable = new FlyingFleetsTable();

	$lunarow = 	 doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".intval($CurrentPlanet['id_owner']) . "' AND `galaxy` = '" . intval($CurrentPlanet['galaxy']) . "' AND `system` = '" . intval($CurrentPlanet['system']) . "' AND  `planet` = '" . intval($CurrentPlanet['planet']) . "' AND `planet_type`='3'", 'planets', true);

	if (empty($lunarow)) { unset($lunarow); }

	CheckPlanetUsedFields($lunarow);

	$parse					= $lang;
    $parse['id']            =$user['id']; 
	$parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];
    $parse['dpath']         = $dpath;
    $parse['avatar']        = $user['avatar'];
    $QueryStat = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$CurrentUser['id']."' AND `stat_type` = '1'", "statpoints", true); 
    $parse{'puntos_defensa'}      =  pretty_number($QueryStat['defs_count']); 
    $parse{'puntos_edificios'}    =  pretty_number($QueryStat['build_points']); 
    $parse{'puntos_naves'}        =   pretty_number($QueryStat['fleet_count']); 
    $parse{'puntos_investigaciones'}    =  pretty_number($QueryStat['tech_count']); 
    $StatRecord = doquery("SELECT `total_rank`,`total_points`,`defs_rank`,`build_rank`,`fleet_rank`,`tech_rank` FROM `{{table}}` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $CurrentUser['id'] . "';", 'statpoints', true); 
    $parse['top_defensa']            =    $StatRecord['defs_rank']; 
    $parse['top_edificios']            =    $StatRecord['build_rank']; 
    $parse['top_naves']                =    $StatRecord['fleet_rank']; 
    $parse['top_investigaciones']   =    $StatRecord['tech_rank'];  


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
					doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . intval($CurrentUser['current_planet']) . "' LIMIT 1;", "planets");
				}
			}
			elseif ($_POST['action'] == $lang['ov_abandon_planet'])
			{
				return display(parsetemplate(gettemplate('overview/overview_deleteplanet'), $parse));
			}
			elseif (intval($_POST['kolonieloeschen']) == 1 && intval($_POST['deleteid']) == $CurrentUser['current_planet'])
			{
				$filokontrol = doquery("SELECT * FROM {{table}} WHERE fleet_owner = '".intval($user['id'])."' AND fleet_start_galaxy='".intval($CurrentPlanet['galaxy'])."' AND fleet_start_system='".intval($CurrentPlanet['system'])."' AND fleet_start_planet='".intval($CurrentPlanet['planet'])."'", 'fleets');

				while($satir = mysql_fetch_array($filokontrol))
				{
					$kendifilo 	= $satir['fleet_owner'];
					$digerfilo 	= $satir['fleet_target_owner'];
					$harabeyeri = $satir['fleet_end_type'];
					$mess 		= $satir['fleet_mess'];
				}

				$filokontrol = doquery("SELECT * FROM {{table}} WHERE fleet_target_owner = '".intval($user['id'])."' AND fleet_end_galaxy='".intval($CurrentPlanet['galaxy'])."' AND fleet_end_system='".intval($CurrentPlanet['system'])."' AND fleet_end_planet='".intval($CurrentPlanet['planet'])."'" , 'fleets');

				while($satir = mysql_fetch_array($filokontrol))
				{
					$kendifilo 	= $satir['fleet_owner'];
					$digerfilo 	= $satir['fleet_target_owner'];
					$gezoay 	= $satir['fleet_end_type'];
					$mess 		= $satir['fleet_mess'];
				}

				if ($kendifilo > 0)
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				elseif ((($digerfilo > 0) && ($mess < 1 )) && $gezoay <> 2  )
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				else
				{
					if (md5($_POST['pw']) == $CurrentUser["password"] && $CurrentUser['id_planet'] != $CurrentUser['current_planet'])
					{

						doquery("UPDATE {{table}} SET `destruyed` = '".(time()+ 86400)."' WHERE `id` = '".intval($CurrentUser['current_planet'])."' LIMIT 1;" , 'planets');
						doquery("UPDATE {{table}} SET `current_planet` = `id_planet` WHERE `id` = '". intval($CurrentUser['id']) ."' LIMIT 1", "users");
						doquery("DELETE FROM {{table}} WHERE `galaxy` = '". intval($CurrentPlanet['galaxy']) ."' AND `system` = '". intval($CurrentPlanet['system']) ."' AND `planet` = '". intval($CurrentPlanet['planet']) ."' AND `planet_type` = 3;", 'planets');

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
			}

			return display(parsetemplate(gettemplate('overview/overview_renameplanet'), $parse));
			break;

     default:

             $CONSULTA = doquery("SELECT metal,crystal FROM {{table}} WHERE galaxy = '".$CurrentPlanet['galaxy']."' AND system = '".$CurrentPlanet['system']."' AND planet = '".$CurrentPlanet['planet']."'", "galaxy", true);

            $parse['metal_debris'] = pretty_number($CONSULTA['metal']);
            $parse['crystal_debris'] = pretty_number($CONSULTA['crystal']);

            if ($CurrentPlanet['recycler'] != 0 && ($CONSULTA['metal'] != 0 || $CONSULTA['crystal'] != 0))
         {
            $parse['get_link'] = " (<a href=\"game.php?page=galaxy&mode=8&g=".$CurrentPlanet['galaxy']."&s=".$CurrentPlanet['system']."&p=".$CurrentPlanet['planet'] . "&t=2\"> DF </a>)";
            }
         else
         {
                $parse['get_link'] = '';
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

			$OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . intval($CurrentUser['id']) . "';", 'fleets');

			$Record = 0;

			while ($FleetRow = mysql_fetch_array($OwnFleets))
			{
				$Record++;

				$StartTime 	= $FleetRow['fleet_start_time'];
				$StayTime 	= $FleetRow['fleet_end_stay'];
				$EndTime 	= $FleetRow['fleet_end_time'];
				/////// // ### LUCKY , CODES ARE BELOW
				$hedefgalaksi 	= $FleetRow['fleet_end_galaxy'];
				$hedefsistem 	= $FleetRow['fleet_end_system'];
				$hedefgezegen 	= $FleetRow['fleet_end_planet'];
				$mess 			= $FleetRow['fleet_mess'];
				$filogrubu 		= $FleetRow['fleet_group'];
				$id         	= $FleetRow['fleet_id'];
				//////
				$Label = "fs";
				if ($StartTime > time())
				{
					$fpage[$StartTime.$id]  = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10))
				{
					$Label = "ft";

					if ($StayTime > time())
					{
						$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > time())
					{
						$fpage[$EndTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}

				/**fix fleet table return by jstar**/
				if($FleetRow['fleet_mission'] == 4 && $StartTime < time() && $EndTime > time())
				{
					$fpage[$EndTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, "fjstar", $Record);
				}
				/**end fix**/

			}
			mysql_free_result($OwnFleets);
			//iss ye katilan filo////////////////////////////////////

			// ### LUCKY , CODES ARE BELOW

			$dostfilo = doquery("SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '" . intval($hedefgalaksi) . "' AND `fleet_end_system` = '" . intval($hedefsistem) . "' AND `fleet_end_planet` = '" . intval($hedefgezegen) . "' AND `fleet_group` = '" . intval($filogrubu) . "';", 'fleets');
			$Record1 = 0;
			while ($FleetRow = mysql_fetch_array($dostfilo)) {


				$StartTime = $FleetRow['fleet_start_time'];
				$StayTime = $FleetRow['fleet_end_stay'];
				$EndTime = $FleetRow['fleet_end_time'];

				///////
				$hedefgalaksi = $FleetRow['fleet_end_galaxy'];
				$hedefsistem = $FleetRow['fleet_end_system'];
				$hedefgezegen = $FleetRow['fleet_end_planet'];
				$mess = $FleetRow['fleet_mess'];
				$filogrubu = $FleetRow['fleet_group'];
				$id             = $FleetRow['fleet_id'];
				///////
				if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $CurrentUser['id'])) {
					$Record1++;
					//		if (($FleetRow['fleet_mission'] == 2) ){
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}

					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime.$id]  =$FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1);
					}

					//	}
				} ///""

				if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $CurrentUser['id']) && ($filogrubu > 0 ) ){
					$Record++;
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}
					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime.$id]  = $FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
					}

				}

			}
			mysql_free_result($dostfilo);
			//
			
//////////////////////////////////////////////////
//nome da aliança

 $ally_id = $user['ally_id'];
if($ally_id)
{
   $allydata = doquery("SELECT `ally_name` FROM {{table}} WHERE `id` = '".$ally_id."'","alliance",true);
   if($allydata['ally_name'] != '')
        $parse['ally_name'] = $allydata['ally_name'];
   else
        $parse['ally_name'] = "You dont have any alliance";
}
else
{
         $parse['ally_name'] = "You dont have any alliance";
}
//////////////////////////////////////////////////
       
           //Administración overview
                   $OnlineAdmins = doquery("SELECT * FROM {{table}} WHERE onlinetime>='".(time()-10*60)."' AND authlevel>=1",'users');
                    if($OnlineAdmins)
                   {
                   $parse['OnlineAdmins'] = "";
                   while ($oas = mysql_fetch_array($OnlineAdmins))
                   {
                   $parse['OnlineAdmins'] .= "<a href=\"game.php?page=messages&mode=write&id=". $oas['id'] ."\" >". $oas['username'] ."</a>&nbsp;&bull;&nbsp;";
                   }
                   if($parse['OnlineAdmins'] == "")
                    $parse['OnlineAdmins'] = "--";
                   }
            //Administración overview  




			$OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . intval($CurrentUser['id']) . "';", 'fleets');

			$Record = 2000;
			while ($FleetRow = mysql_fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $CurrentUser['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime 	= $FleetRow['fleet_start_time'];
						$StayTime 	= $FleetRow['fleet_end_stay'];
						$id         = $FleetRow['fleet_id'];

						if ($StartTime > time())
						{
							$Label = "ofs";
							$fpage[$StartTime.$id]  = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > time())
							{
								$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}
			mysql_free_result($OtherFleets);

			$planets_query = doquery("SELECT * FROM `{{table}}` WHERE id_owner='".intval($CurrentUser['id'])."' AND `destruyed` = 0", "planets");
			$Colone  	= 1;
			$AllPlanets = "<tr>";
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

					if ($Colone <= 9)
						$Colone++;
					else
					{
						$AllPlanets .= "</tr><tr>";
						$Colone = 0;
					}
				}
			}
			mysql_free_result($planets_query);

			$AllPlanets .= "</tr>";
            if ($game_config['OverviewNewsFrame'] == '1') {
            $parse['NewsFrame'] = "<tr>" . $lang['ov_news_title'] . "<th colspan=\"4\">" . stripslashes($game_config['OverviewNewsText']) . "</th></tr>";
            } 

			if ($lunarow['id'] <> 0 && $lunarow['destruyed'] != 1 && $CurrentPlanet['planet_type'] != 3)
			{
				if ($CurrentPlanet['planet_type'] == 1 or $lunarow['id'] <> 0)
				{
					$moon = doquery ("SELECT `id`,`name`,`image` FROM {{table}} WHERE `galaxy` = '" . intval($CurrentPlanet['galaxy']) . "' AND `system` = '" . intval($CurrentPlanet['system']) . "' AND `planet` = '" . intval($CurrentPlanet['planet']) . "' AND `planet_type` = '3'", 'planets', true);
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

// Gouvernement
    $staatsform    = $user['staatsform'];

    if ($staatsform == 2) {
        $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['demokratie']."</a></th>
</tr>";
    } elseif ($staatsform == 3) {
    $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['monarchie']."</a></th>
</tr>";
    } elseif ($staatsform == 4) {
    $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['diktatur']."</a></th>
</tr>";
    } elseif ($staatsform == 5) {
    $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['imperialisme']."</a></th>
</tr>";
    } elseif ($staatsform == 6) {
    $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['aristocratie']."</a></th>
</tr>";
    } else {
        $parse['STAATSFORM_LINK']  = "
<tr><center>
    <th colspan=\"2\">Forma de gobierno:</th>
    <th colspan=\"2\"><a href=\"game.php?page=gouv\" accesskey=\"d\" style=\"font-size:100%\">".$lang['barbarisch']."</a></th>
</tr>";
    }  


              if ($user['humano'] == 1)
                {$parse['race'] = 'Raza: Humano';
                 $parse['imgrace'] = 'images/human.gif';}
                    else {
                        if ($user['vampiro'] == 1)
                        {$parse['race'] = 'Raza: Vampiro';
                         $parse['imgrace'] = 'images/vampiro.gif';}
                            else {
                                if ($user['lobo'] == 1)
                                {$parse['race'] = 'Raza : Lobo';
                                 $parse['imgrace'] = 'images/lobo.gif';}
                                    else {
                                        if ($user['asgard'] == 1)
                                        {$parse['race'] = 'Raza : Asgard';
                                         $parse['imgrace'] = 'images/asgard.gif';}
                                        }
                                }
                        }  


     


			$StatRecord = doquery("SELECT `total_rank`,`total_points` FROM `{{table}}` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . intval($CurrentUser['id']) . "';", 'statpoints', true);

			$parse['user_username']        = $CurrentUser['username'];

			if (count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $time => $content)
				{
					$flotten .= $content . "\n";
				}
			}

	// **** INICIA MOD {MOSTRAR TECNOLOGIA EN PROCESO EN VISTA GENERAL} ****
            if ($CurrentPlanet['b_building'] != 0)
            {
                include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

                UpdatePlanetBatimentQueueList ($planetrow, $user);
                if ($CurrentPlanet['b_building'] != 0)
                {
                    $BuildQueue           = explode (";", $CurrentPlanet['b_building_id']);
                    $CurrBuild               = explode (",", $BuildQueue[0]);
                    $RestTime               = $CurrentPlanet['b_building'] - time();
                    $PlanetID               = $CurrentPlanet['id'];
                    $Build                   = InsertBuildListScript ("buildings");
                    $Build              .= "<table>";
                    $Build              .= "    <tr>";
                    $Build              .= "        <td colspan=\"2\">".$lang['tech'][$CurrBuild[0]]."</td>";
                    $Build              .= "    </tr>";
                    $Build              .= "    <tr>";
                    $Build              .= "        <td align=\"center\" valign=\"middle\"><img src=\"".$dpath."gebaeude/".$CurrBuild[0].".gif\" width=\"40\" height=\"40\"></td>";
                    $Build              .= "        <td>".$lang['pr_subiendo']." <span style=\"color:#FF8C00;\">Nivel ".$CurrBuild[1]."</span><br />";
                    $Build              .= "            ".$lang['pr_duracion'].":<div id=\"blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
                    $Build              .= "        </td>";
                    $Build              .= "    </tr>";
                    $Build              .= "</Table>";
                    $Build                 .= "\n<script language=\"JavaScript\">";
                    $Build                 .= "\n    pp = \"" . $RestTime . "\";\n";
                    $Build                 .= "\n    pk = \"" . 1 . "\";\n";
                    $Build                 .= "\n    pm = \"cancel\";\n";
                    $Build                 .= "\n    pl = \"" . $PlanetID . "\";\n";
                    $Build                 .= "\n    t();\n";
                    $Build                 .= "\n</script>\n";
                    $parse['building']      = $Build;
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
            
            $PlanetaQueInv = doquery("SELECT id, name, b_tech, b_tech_id FROM `{{table}}` WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `b_tech` != '0';", 'planets', true);
            if ($PlanetaQueInv['b_tech'] != 0)
            {   
                include($xgp_root . 'includes/functions/InsertTechListScript.' . $phpEx);
                
                UpdatePlanetBatimentQueueList ($planetrow, $user);
                
                $NvlActual = $CurrentUser[$resource[$PlanetaQueInv['b_tech_id']]] + 1;
                $RestTime  = $PlanetaQueInv['b_tech'] - time();
                $PlanetID  = $PlanetaQueInv['id'];
                $NomPlaneta = "";
                if ($PlanetaQueInv['name'] != $CurrentPlanet['name']) {
                    $NomPlaneta = " de " . $PlanetaQueInv['name'];
                }
                $Tech      = InsertTechListScript("buildings",$NomPlaneta);
                $Tech     .= "<table>";
                $Tech     .= "    <tr>";
                $Tech     .= "        <td colspan=\"2\">".$lang['tech'][$PlanetaQueInv['b_tech_id']]."</td>";
                $Tech     .= "    </tr>";
                $Tech     .= "    <tr>";
                $Tech     .= "        <td align=\"center\" valign=\"middle\"><img src=\"".$dpath."gebaeude/".$PlanetaQueInv['b_tech_id'].".gif\" width=\"40\" height=\"40\"></td>";
                $Tech     .= "        <td>".$lang['pr_investigando']." <span style=\"color:#FF8C00;\">Nivel ".$NvlActual."</span><br />";
                $Tech     .= "            ".$lang['pr_duracion'].":<div id=\"tec_blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
                $Tech     .= "        </td>";
                $Tech     .= "    </tr>";
                $Tech     .= "</Table>";
                $Tech     .= "\n<script language=\"JavaScript\">";
                $Tech     .= "\n    tec_pp = \"" . $RestTime . "\";\n";
                $Tech     .= "\n    tec_pk = \"" . 1 . "\";\n";
                $Tech     .= "\n    tec_pm = \"cancel\";\n";
                $Tech     .= "\n    tec_pl = \"" . $PlanetaQueInv['b_tech_id'] . "\";\n";
                $Tech     .= "\n    tec_t();\n";
                $Tech     .= "\n</script>\n";
                
                $parse['tech_en_proceso'] .= $Tech;
            } else {
                $parse['tech_en_proceso'] = $lang['ov_free'];
            }
            
            if ($CurrentPlanet['b_hangar'] != 0)
            {   
                include($xgp_root . 'includes/functions/InsertHangarListScript.' . $phpEx);
                
                UpdatePlanetBatimentQueueList ($planetrow, $user);
                
                $BuildQueue = explode (";", $CurrentPlanet['b_hangar_id']);
                $CurrBuild  = explode (",", $BuildQueue[0]);
                $RealTime   = GetBuildingTime( $CurrentUser, $CurrentPlanet, $CurrBuild[0] );
                $QueueTime  = $RealTime * $CurrBuild[1];
                $RestTime   = $QueueTime - $CurrentPlanet['b_hangar'];
                $PlanetID   = $CurrentPlanet['id'];
                $Hangar     = InsertHangarListScript("overview");
                $Hangar    .= "<table>";
                $Hangar    .= "    <tr>";
                $Hangar    .= "        <td colspan=\"2\">".$lang['tech'][$CurrBuild[0]]."</td>";
                $Hangar    .= "    </tr>";
                $Hangar    .= "    <tr>";
                $Hangar    .= "        <td align=\"center\" valign=\"middle\"><img src=\"".$dpath."gebaeude/".$CurrBuild[0].".gif\" width=\"40\" height=\"40\"><br />";
                $Hangar    .= "        </td>";
                $Hangar    .= "        <td>".$lang['pr_tiempo_prod']."<br />";
                $Hangar    .= "            <div id=\"han_blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
                $Hangar    .= "        </td>";
                $Hangar    .= "    </tr>";
                $Hangar    .= "</Table>";
                $Hangar    .= "\n<script language=\"JavaScript\">";
                $Hangar    .= "\n    han_pp = \"" . $RestTime . "\";\n";
                $Hangar    .= "\n    han_pk = \"" . 1 . "\";\n";
                $Hangar    .= "\n    han_pm = \"cancel\";\n";
                $Hangar    .= "\n    han_pl = \"" . $PlanetID . "\";\n";
                $Hangar    .= "\n    han_t();\n";
                $Hangar    .= "\n</script>\n";
                
                $parse['hangar_en_proceso'] .= $Hangar;
            } else {
                $parse['hangar_en_proceso'] = $lang['ov_free'];
            }
            
            $parse['overview_produccion'] = parsetemplate(gettemplate('overview/overview_produccion'), $parse);
            // **** FIN MOD {MOSTRAR TECNOLOGIA EN PROCESO EN VISTA GENERAL} ****  


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

            // Rajout d'une barre pourcentage
            // Calcul du pourcentage de remplissage
            $parse['case_pourcentage'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) . $lang['o/o'];
            // Barre de remplissage
            $parse['case_barre'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 101) * 4.1;
            // Couleur de la barre de remplissage
            if ($parse['case_barre'] > (100 * 4.0)) {
            $parse['case_barre'] = 400;
            $parse['case_barre_barcolor'] = '#C00000';
            } elseif ($parse['case_barre'] > (80 * 4.0)) {
            $parse['case_barre_barcolor'] = '#C0C000';
            } else {
            $parse['case_barre_barcolor'] = '#00C000';
            }  

                if($StatRecord['total_points'] >= 0 && $StatRecord['total_points'] < 100000) {
                $parse['rankgame'] = "Soldado";
                $parse['rankimg'] = "rank1.gif";
                } elseif ($StatRecord['total_points'] >= 100000 && $StatRecord['total_points'] < 250000) {
                $parse['rankgame'] = "Cabo Cazador";
                $parse['rankimg'] = "rank2.gif";
                } elseif ($StatRecord['total_points'] >= 250000 && $StatRecord['total_points'] < 500000) {
                $parse['rankgame'] = "Sargento Cazador";
                $parse['rankimg'] = "rank3.gif";
                } elseif ($StatRecord['total_points'] >= 500000 && $StatRecord['total_points'] < 1000000) {
                $parse['rankgame'] = "Teniente de Crucero";
                $parse['rankimg'] = "rank4.gif";
                } elseif ($StatRecord['total_points'] >= 1000000 && $StatRecord['total_points'] < 2500000) {
                $parse['rankgame'] = "Capitán Destructor";
                $parse['rankimg'] = "rank5.gif";
                } elseif ($StatRecord['total_points'] >= 2500000 && $StatRecord['total_points'] < 5000000) {
                $parse['rankgame'] = "Almirante Acorazado";
                $parse['rankimg'] = "rank6.gif";
                } elseif ($StatRecord['total_points'] >= 5000000 && $StatRecord['total_points'] < 10000000) {
                $parse['rankgame'] = "General Estrella";
                $parse['rankimg'] = "rank7.gif";
                } elseif ($StatRecord['total_points'] >= 10000000 && $StatRecord['total_points'] < 25000000) {
                $parse['rankgame'] = "General Supernova";
                $parse['rankimg'] = "rank8.gif";
                } elseif ($StatRecord['total_points'] >= 25000000 && $StatRecord['total_points'] < 50000000) {
                $parse['rankgame'] = "General de Flota";
                $parse['rankimg'] = "rank9.gif";
                } elseif ($StatRecord['total_points'] >= 50000000 && $StatRecord['total_points'] < 100000000) {
                $parse['rankgame'] = "General Interestelar";
                $parse['rankimg'] = "rank10.gif";
                } elseif ($StatRecord['total_points'] >= 100000000 && $StatRecord['total_points'] < 500000000) {
                $parse['rankgame'] = "Cónsul General";
                $parse['rankimg'] = "rank11.gif";
                } elseif ($StatRecord['total_points'] >= 500000000) {
                $parse['rankgame'] = "Emperador";
                $parse['rankimg'] = "rank12.gif";
                }  



			return display(parsetemplate(gettemplate('overview/overview_body'), $parse));
			break;
	}
}
?>