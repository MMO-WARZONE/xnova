<?php
//version 1
if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowOverviewPage($CurrentUser, $CurrentPlanet)
{
	global $svn_root, $phpEx, $dpath,$db, $lang, $planetrow, $users, $displays;
	
	$displays->assignContent('overview/overview');
	
	include_once($svn_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($svn_root . 'includes/functions/classes/class.FlyingFleetsTable.' . $phpEx);

	$FlyingFleetsTable = new FlyingFleetsTable();

	$lunarow = $db->query("SELECT `id`,`name`,`image`,`destruyed` FROM {{table}}
			   WHERE `id_owner` = '" . $CurrentPlanet['id_owner'] . "'
			   AND `galaxy` = '" . $CurrentPlanet['galaxy'] . "'
			   AND `system` = '" . $CurrentPlanet['system'] . "'
			   AND `planet` = '" . $CurrentPlanet['planet'] . "'
			   AND `planet_type`= '3';", 'planets', true );
	if (empty($lunarow)) { unset($lunarow); }
	CheckPlanetUsedFields($lunarow);

        $parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];

	switch ($_GET['mode'])
	{
		case 'renameplanet':
			
			if($_POST['newname']){
				$parse['planet_name']        = mysql_escape_string(strip_tags(trim($_POST['newname'])));
			}
			foreach($parse as $name => $trans){
                            $displays->assignGlobal($name, $trans);
                        }
			if ($_POST['action'] == $lang['ov_planet_rename_action'])
			{
				$newname        = mysql_escape_string(strip_tags(trim($_POST['newname'])));
				if (preg_match("/[^A-z0-9_\- ]/", $newname) == 1)
				{
					$displays->message($lang['ov_newname_error'], "game.php?page=overview&mode=renameplanet",2);
				}
				if ($newname != "")
				{
					$db->query("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $CurrentUser['current_planet'] . "' LIMIT 1;", "planets" );
					
				}
				
			}
			elseif ($_POST['action'] == $lang['ov_abandon_planet'])
			{
				$displays->newblock('deleted');
			}
			elseif ($_POST['kolonieloeschen'] == 1 && intval($_POST['deleteid']) == $CurrentUser['current_planet'])
			{
				if (md5($_POST['pw']) == $CurrentUser["password"] && $CurrentUser['id_planet'] != $CurrentUser['current_planet'])
				{

					$db->query("UPDATE {{table}} SET `destruyed` = '".(time()+ 86400)."'
						WHERE `id` = '".mysql_real_escape_string($CurrentUser['current_planet'])."' LIMIT 1;" , 'planets' );
					$db->query("UPDATE {{table}} SET `current_planet` = `id_planet`
						WHERE `id` = '". mysql_real_escape_string($CurrentUser['id']) ."' LIMIT 1", "users" );
					$db->query("DELETE FROM {{table}}
						WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."'
						AND `system` = '". $CurrentPlanet['system'] ."'
						AND `planet` = '". $CurrentPlanet['planet'] ."'
						AND `planet_type` = 3;", 'planets' );
					$db->query("UPDATE {{table}} SET `id_luna` = '0'
						WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."'
						AND `system` = '". $CurrentPlanet['system'] ."'
						AND `planet` = '". $CurrentPlanet['planet'] ."';", 'galaxy' );
					$displays->message($lang['ov_planet_abandoned'], 'game.php?page=overview&mode=renameplanet');
				}
				elseif ($CurrentUser['id_planet'] == $CurrentUser["current_planet"])
				{
					$displays->message($lang['ov_principal_planet_cant_abanone'], 'game.php?page=overview&mode=renameplanet');
				}
				else
				{
					$displays->message($lang['ov_wrong_pass'], 'game.php?page=overview&mode=renameplanet');
				}
			}
			
			$displays->newblock('renameplanet');
                break;
		default:
			
			$displays->newblock('overview');
			if($CurrentUser["db_deaktjava"]=="1"){
				$parse["delete"]="<tr><th colspan=4 ><h1>".$lang["deleted"].gmdate("j-m-y  H:i:s",$CurrentUser["db_time"])."</h1></th></tr>";
			}
			$noticias=explode(";;",$db->game_config["information"]);
			
			if($noticias[0]==1){
				$displays->newblock('noticias');
				$new = nl2br(stripslashes($noticias[1]));
				$new = str_replace(":name:",$CurrentUser['username'],$new);
				$new = str_replace(":server:",$db->game_config['game_name'], $new);
				$displays->assign('news', $new);
			}
			
			$OwnFleets = $db->query("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $CurrentUser['id'] . "';", 'fleets' );

			$Record = 0;
                        $fpage=array();
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

			$OtherFleets = $db->query("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $CurrentUser['id'] . "';", 'fleets' );

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
			mysql_free_result($OtherFleets);
			
			$planets_query = $db->query("SELECT * FROM `{{table}}` WHERE id_owner='{$CurrentUser['id']}' AND `destruyed` = 0", "planets" );
			$Colone  	= 1;
			$PlanetaQueInv=array();
                        
			while ($CurrentUserPlanet = mysql_fetch_array($planets_query))
			{
                                if($CurrentUserPlanet["b_tech"]!=0){
                                $PlanetaQueInv['b_tech']    = $CurrentUserPlanet["b_tech"];
                                $PlanetaQueInv['b_tech_id'] = $CurrentUserPlanet["b_tech_id"];
                                $PlanetaQueInv['name']      = $CurrentUserPlanet["name"];
                                $PlanetaQueInv['id']        = $CurrentUserPlanet["id"];
                                }
				if ($CurrentUserPlanet["id"] != $CurrentUser["current_planet"] && $CurrentUserPlanet['planet_type'] != 3)
				{
					$Coloneshow++;
					$AllPlanets .= "<th>". $CurrentUserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"game.php?page=overview&cp=". $CurrentUserPlanet['id'] ."&re=0\" title=\"". $CurrentUserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $CurrentUserPlanet['image'] .".jpg\" height=\"20\" width=\"20\"></a><br>";
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
					if($Coloneshow%6==0){
						$AllPlanets .= "</tr><tr>";
					}

				}
			}
			if ($lunarow['id'] <> 0 && $lunarow['destruyed'] != 0 && $CurrentPlanet['planet_type'] != 3)
			{
				if ($CurrentPlanet['planet_type'] == 1 or $lunarow['id'] <> 0)
				{
					$displays->newblock('moon');
					$displays->assign('moon_img', "<a href=\"game.php?page=overview&cp=" . $lunarow['id'] . "&re=0\" title=\"" . $lunarow['name'] . "\"><img src=\"" . $dpath . "planeten/small/s_" . $lunarow['image'] . ".png\" height=\"50\" width=\"50\"></a>");
					$displays->assign('moon', $lunarow['name'] ." (" . $lang['fcm_moon'] . ")");
				}
			}
			
			$parse['planet_diameter'] 		= pretty_number($CurrentPlanet['diameter']);
			$parse['planet_field_current']  	= $CurrentPlanet['field_current'];
			$parse['planet_field_max'] 		= CalculateMaxPlanetFields($CurrentPlanet);
			$parse['planet_temp_min'] 		= $CurrentPlanet['temp_min'];
			$parse['planet_temp_max'] 		= $CurrentPlanet['temp_max'];
			$parse['user_username']                 = $CurrentUser['username'];

			if (count($fpage) > 0)
			{
                                $flotten="";
				ksort($fpage);
				foreach ($fpage as $time => $content)
				{
					$flotten .= $content . "\n";
				}
			}

			if ($CurrentPlanet['b_building'] != 0)
			{
				include($svn_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

				UpdatePlanetBatimentQueueList ($planetrow, $users->user);
				if ($CurrentPlanet['b_building'] != 0)
				{
					$BuildQueue  		 	 = explode (";", $CurrentPlanet['b_building_id']);
					$CurrBuild 	 		 = explode (",", $BuildQueue[0]);
					$RestTime 	 		 = $CurrentPlanet['b_building'] - time();
					$PlanetID 	 		 = $CurrentPlanet['id'];
					$Build                   	 = InsertBuildListScript ("buildings");
					$Build              		.= "<table>";
					$Build              		.= "    <tr>";
					$Build              		.= "        <th colspan=\"2\">".$lang['tech'][$CurrBuild[0]]."</th>";
					$Build              		.= "    </tr>";
					$Build              		.= "    <tr>";
					$Build              		.= "        <th class='anything' align=\"center\" style=\"background-image: url(".$dpath."gebaeude/".$CurrBuild[0].".gif);background-repeat:no-repeat;width:60px; height:60;\"   valign=\"middle\"></th>";
					$Build              		.= "        <th class='anything'>".$lang['pr_subiendo']." <span style=\"color:#FF8C00;\">Nivel ".$CurrBuild[1]."</span><br />";
					$Build              		.= "            ".$lang['pr_duracion'].":<div id=\"blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
					$Build              		.= "        </th>";
					$Build              		.= "    </tr>";
					$Build              		.= "</Table>";
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
			
			if ($PlanetaQueInv['b_tech'] != 0 && $PlanetaQueInv['b_tech_id'])
			{
                            global $resource;
			    include($svn_root . 'includes/functions/InsertTechListScript.' . $phpEx);
			    
			    UpdatePlanetBatimentQueueList ($planetrow,$users->user);
			    
                            $NvlActual = ($CurrentUser[$resource[$PlanetaQueInv['b_tech_id']]] + 1);
                            $RestTime  = $PlanetaQueInv['b_tech'] - time();
			    $PlanetID  = $PlanetaQueInv['id'];
			    $NomPlaneta = "";
			    if ($PlanetaQueInv['name'] != $CurrentPlanet['name']) {
				$NomPlaneta = " de " . $PlanetaQueInv['name'];
			    }
			    $Tech      = InsertTechListScript("buildings&mode=research",$NomPlaneta);
			    $Tech     .= "<table>";
			    $Tech     .= "    <tr>";
			    $Tech     .= "        <th colspan=\"2\">".$lang['tech'][$PlanetaQueInv['b_tech_id']]."</th>";
			    $Tech     .= "    </tr>";
			    $Tech     .= "    <tr>";
			    $Tech     .= "        <th class='anything' align=\"center\" style=\"background-image: url(".$dpath."gebaeude/".$PlanetaQueInv['b_tech_id'].".gif);background-repeat:no-repeat;width:60px; height:60;\" valign=\"middle\"></th>";
			    $Tech     .= "        <th class='anything'>".$lang['pr_investigando']." <span style=\"color:#FF8C00;\">Nivel ".$NvlActual."</span><br />";
			    $Tech     .= "            ".$lang['pr_duracion'].":<div id=\"tec_blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
			    $Tech     .= "        </th>";
			    $Tech     .= "    </tr>";
			    $Tech     .= "</Table>";
			    $Tech     .= "\n<script language=\"JavaScript\">";
			    $Tech     .= "\n    tec_pp = \"" . $RestTime . "\";\n";
			    $Tech     .= "\n    tec_pk = \"" . 1 . "\";\n";
			    $Tech     .= "\n    tec_pm = \"cancel\";\n";
			    $Tech     .= "\n    tec_pl = \"" . $PlanetaQueInv['b_tech_id'] . "\";\n";
			    $Tech     .= "\n    tec_t();\n";
			    $Tech     .= "\n</script>\n";
			    unset($resource);
			    $parse['tech_en_proceso'] .= $Tech;
			} else {
			    $parse['tech_en_proceso'] = $lang['ov_free'];
			}
			
			if ($CurrentPlanet['b_hangar'] != 0)
			{   
			    include($svn_root . 'includes/functions/InsertHangarListScript.' . $phpEx);
			    
			    UpdatePlanetBatimentQueueList ($planetrow, $users->user);
			    
			    $BuildQueue = explode (";", $CurrentPlanet['b_hangar_id']);
			    $CurrBuild  = explode (",", $BuildQueue[0]);
			    $RealTime   = GetBuildingTime( $CurrentUser, $CurrentPlanet, $CurrBuild[0] );
			    $QueueTime  = $RealTime * $CurrBuild[1];
			    $RestTime   = $QueueTime - $CurrentPlanet['b_hangar'];
			    $PlanetID   = $CurrentPlanet['id'];
			    $Hangar     = InsertHangarListScript("fleet");
			    $Hangar    .= "<table>";
			    $Hangar    .= "    <tr>";
			    $Hangar    .= "        <th colspan=\"2\">".$lang['tech'][$CurrBuild[0]]."</th>";
			    $Hangar    .= "    </tr>";
			    $Hangar    .= "    <tr>";
			    $Hangar    .= "        <th class='anything' align=\"center\" style=\"background-image: url(".$dpath."gebaeude/".$CurrBuild[0].".gif);background-repeat:no-repeat;width:60px; height:60;\" valign=\"middle\"><br />";
			    $Hangar    .= "        </th>";
			    $Hangar    .= "        <th class='anything'>".$lang['pr_tiempo_prod']."<br />";
			    $Hangar    .= "            <div id=\"han_blc\" class=\"z\" style=\"color:yellow;\">" . pretty_time($RestTime) . "</div>";
			    $Hangar    .= "        </th>";
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
            
			// Usuarios conectados
			$OnlineUsers = $db->query("SELECT COUNT(DISTINCT id) as count FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "'", 'users', 'true');
			$parse['NumberMembersOnline']   = $OnlineUsers['count'];
                        $parse['id']                    = $CurrentPlanet['id'];
			
                        $parse['fleet_list']  		= $flotten;
                        
			$parse['planet_image'] 		= $CurrentPlanet['image'];
			if(isset($AllPlanets)){
				$displays->newblock('anothers_planets');
				$displays->assign('anothers_planets', $AllPlanets);
			}
			
			
			$parse["dpath"] 				= $dpath;
			if($db->game_config['stat'] == 0){
				$parse['user_rank']			= pretty_number($users->user['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$users->user['total_rank']."\">".$users->user['total_rank']."</a> ". $lang['ov_of'] ." ".$db->game_config['users_amount'].")";
			}elseif($db->game_config['stat'] == 1 && $CurrentUser['authlevel'] < $db->game_config['stat_level']){
				$parse['user_rank']			= pretty_number($users->user['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&range=".$users->user['total_rank']."\">".$users->user['total_rank']."</a> ". $lang['ov_of'] ." ".$db->game_config['users_amount'].")";
			}
			else{
				$parse['user_rank']			= "-";
			}
	    		setlocale(LC_ALL, 'es_ES.UTF-8/UTF-8');
		        $parse['date_time']= strftime("Hoy es %A, %e de %B de %Y, son las %H:%M:%S" ,time());
                        //$url=explode("game.php",$_SERVER[HTTP_REFERER]);
                        $url=dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";
			$parse['refer']= ''.$url.'index.php?ref='.$users->user['username'].'';

                        $displays->gotoBlock('overview');
			foreach($parse as $name => $trans){
                            $displays->assign($name, $trans);
                        }
			
		break;
	}

	$displays->display("Overview");
}
?>