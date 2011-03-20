<?php
//VERSION 1.4


if (!defined('INSIDE'))
{
	die();
}

class GalaxyPada {

        protected  $FleetMax      ="";
        protected  $CurrentMIP    ="";
        protected  $CurrentRC     ="";
        protected  $CurrentSP    ="";
        protected  $HavePhalanx   ="";
        protected  $CurrentSystem ="";
        protected  $CurrentGalaxy ="";
        protected  $CanDestroy    ="";
        protected  $CurrentPlanet = "";
        protected  $CurrentPlanet_type = "";

	protected function GetMissileRange ()
	{
		global $resource, $users;

		if ($users->user[$resource["117"]] > 0)
		{
			//$MissileRange = ($users->user[$resource["117"]] * 2) - 1
                        $MissileRange = ($users->user[$resource["117"]] * $users->user[$resource["117"]]) - 1;
		}else{
			$MissileRange = 0;
		}
                return $MissileRange;
	}

	protected function GetPhalanxRange($PhalanxLevel)
	{
		$PhalanxRange = 0;
		//ANTIGUO SISTEMA
                /* if ($PhalanxLevel > 1)
		{
			for ($Level = 2; $Level < $PhalanxLevel + 1; $Level++)
			{
				$lvl           = ($Level * 2) - 1;
				$PhalanxRange += $lvl;
			}

		}*/
                //FIN ANTIGUO
                //NUEVO
                if ($PhalanxLevel > 1)
		{
			//$MissileRange = ($users->user[$resource["117"]] * 2) - 1
                        $PhalanxRange = ($PhalanxLevel * $PhalanxLevel) - 1;
		}
		return $PhalanxRange;
	}


	protected  function _TooltipActions($Row, $Galaxy, $System, $Planet, $PlanetType) {
		global $lang, $users, $dpath, $CurrentSystem, $CurrentGalaxy;
                if ($Row['id'] != $users->user['id']) {
			if ($this->CurrentMIP > 0) {
                            if ($Row['galaxy'] == $Galaxy) {
                                    $Range = $this->GetMissileRange();
                                    $SystemLimitMin = $this->CurrentSystem - $Range;

                                    if ($SystemLimitMin < 1) {
                                            $SystemLimitMin = 1;
                                    }
                                    $SystemLimitMax = $this->CurrentSystem + $Range;
                                    if ($System <= $SystemLimitMax) {
                                        
                                            if ($System >= $SystemLimitMin) {
                                                    $MissileBtn = true;
                                            } else {
                                                    $MissileBtn = false;
                                            }
                                    } else {
                                            $MissileBtn = false;
                                    }
                            } else {
                                    $MissileBtn = false;
                            }
				
			} else {
				$MissileBtn = false;
			}
	
			if ($Row && $Row["destruyed"] == 0) {
				if ($users->user["settings_esp"] && $Row['id'] != $users->user['id']) {
					$Result .= "<a href=# onclick=\"javascript:pada_galaxy(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$users->user["spio_anz"].");\" >";
					$Result .= "<img src=". $dpath ."img/e.gif alt=\"".$lang['gl_espionner']."\" title=\"".$lang['gl_espionner']."\" border=0></a>";
					$Result .= "&nbsp;";
				}
				if ($users->user["settings_wri"]) {
					$Result .= "<a href=# onclick=\"new_mensaje('".$Row['username']."','".$Row['id']."','Sin Asunto','')\">";
					$Result .= "<img src=". $dpath ."img/m.gif alt=\"".$lang['gl_sendmess']."\" title=\"".$lang['gl_sendmess']."\" border=0></a>";
                                        $Result .= "&nbsp;";
				}
				if ($users->user["settings_bud"] && $Row['id'] != $users->user['id']) {
					$Result .= "<a href=game.php?page=buddy&mode=2&amp;u=".$Row['id']." >";
					$Result .= "<img src=". $dpath ."img/b.gif alt=\"".$lang['gl_buddyreq']."\" title=\"".$lang['gl_buddyreq']."\" border=0></a>";
                                        $Result .= "&nbsp;";
				}
				if ($users->user["settings_mis"] AND $MissileBtn && $Row['id'] != $users->user['id']) {
					$Result .= "<a href=game.php?page=galaxy&mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&current=".$users->user['current_planet']." >";
					$Result .= "<img src=". $dpath ."img/r.gif alt=\"".$lang['gl_mipattack']."\" title=\"".$lang['gl_mipattack']."\" border=0></a>";
				}
			}
		}
	
		return $Result;
	}
	
	protected function _TooltipAlliance($Row, $Galaxy, $System, $Planet, $PlanetType ) {
		global $lang, $users;
	
		if ($Row['ally_members'] > 1) {
			$add = "s";
		} else {
			$add = "";
		}
	
		$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table width=240>";
		$Result .= "<tr>";
		$Result .= "<td class=c>".$lang['gl_alliance']." ". preg_replace("('|\"|`)", '', $Row['ally_name']) ." ".$lang['gl_with']." ". $Row['ally_members'] ." ". $lang['gl_member'] . $add ."</td>";
		$Result .= "</tr>";
		$Result .= "<th>";
		$Result .= "<table>";
		$Result .= "<tr>";
		$Result .= "<th><a href=game.php?page=alliance&mode=ainfo&a=". $Row['ally_id'] .">".$lang['gl_alliance_page']."</a></th>";
		$Result .= "</tr><tr>";
		$Result .= "<th><a href=game.php?page=stat&start=101&who=ally>".$lang['gl_see_on_stats']."</a></th>";
		if ($Row["ally_web"]) {
			$Result .= "</tr><tr>";
			$Result .= "<th><a href=".preg_replace("('|\"|`)", '', $Row["ally_web"])   ." target=_new>".$lang['gl_alliance_web_page']."</th>";
		}
		$Result .= "</tr>";
		$Result .= "</table>";
		$Result .= "</th>";
		$Result .= "</table>\"";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		if ($users->user['ally_id'] == $Row['ally_id']) {
			$Result .= "<span class=\"allymember\">". $Row['ally_tag'] ."</span></a>";
		} else {
			$Result .= $Row['ally_tag'] ."</a>";
		}
	
		return $Result;
	}
	
	protected function _TooltipUser($Row, $Galaxy, $System, $Planet, $PlanetType ) {
		global $db, $UserPoints, $lang, $users,$noobs;
		
		if ($Row && $Row["destruyed"] == 0) {

                        $noobs->seco=$Row['total_points'];
                        $noobs->vacation=$Row['urlaubs_modus'];
                        $noobs_users=$noobs->check();
                        //print_r($noobs);
                        //echo "<br>";
/*
			$NoobProt = $db->game_config['noobprotection'];
			$NoobTime = $db->game_config['noobprotectiontime'];//5000
			$NoobMulti = $db->game_config['noobprotectionmulti'];
	
			$CurrentPoints = $users->user['total_points'];
			$RowUserPoints = $Row['total_points'];
			
			$RowUserLevel  = $RowUserPoints * $NoobMulti;
			$CurrentLevel  = $CurrentPoints * $NoobMulti;
			
			$CurrentLevel  = $CurrentPoints * $NoobMulti['config_value'];
			$RowUserLevel  = $RowUserPoints * $NoobMulti['config_value'];*/
			
			
			if ($Row['bana'] == 1 && $Row['urlaubs_modus'] == 1)
				{
					$Systemtatus2 	= "v <a href=\"game.php?page=banned\"><span class=\"banned\">".$lang['gl_b']."</span></a>";
					$Systemtatus 	= "<span class=\"vacation\">";
				}
				elseif ($Row['bana'] == 1)
				{
					$Systemtatus2 	= "<a href=\"game.php?page=banned\"><span class=\"banned\">".$lang['gl_b']."</span></a>";
					$Systemtatus 	= "";
				}
				elseif ($Row['urlaubs_modus'] == 1)
				{
					$Systemtatus2 	= "<span class=\"vacation\">".$lang['gl_v']."</span>";
					$Systemtatus 	= "<span class=\"vacation\">";
				}
				elseif ($Row['onlinetime'] < (time()-60 * 60 * 24 * 7) && $Row['onlinetime'] > (time()-60 * 60 * 24 * 28))
				{
					$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span>";
					$Systemtatus 	= "<span class=\"inactive\">";
				}
				elseif ($Row['onlinetime'] < (time()-60 * 60 * 24 * 28))
				{
					$Systemtatus2 	= "<span class=\"inactive\">".$lang['gl_i']."</span><span class=\"longinactive\">".$lang['gl_I']."</span>";
					$Systemtatus 	= "<span class=\"longinactive\">";
				}

                                //PRUEBA
                                elseif($noobs_users['status']){
                                        $span=explode("_", $noobs_users['lang_g']);
                                        $array=array("s"=>"strong","w"=> "noob");
                                        $Systemtatus2 	= "<span class=\"{$array[$span[1]]}\">".$lang[$noobs_users['lang_g']]."</span>";
                                        $Systemtatus 	= "<span class=\"{$array[$span[1]]}\">";
                                }

                                //FIN PRUEBA
				/*elseif ($RowUserLevel < $CurrentPoints && $NoobProt['config_value'] == 1 && $NoobTime['config_value'] * 1000 > $RowUserPoints)
				{
					$Systemtatus2 	= "<span class=\"noob\">".$lang['gl_w']."</span>";
					$Systemtatus 	= "<span class=\"noob\">";
				}
				elseif ($RowUserPoints > $CurrentLevel && $NoobProt['config_value'] == 1 && $NoobTime['config_value'] * 1000 > $CurrentPoints)
				{
					$Systemtatus2 	= $lang['gl_s'];
					$Systemtatus 	= "<span class=\"strong\">";
				}
				
				
				elseif($NoobProt == 1
					&& $RowUserPoints<$NoobMulti){		
			
					$Systemtatus2 	= "<span class=\"noob\">".$lang['gl_w']."</span>";
					$Systemtatus 	= "<span class=\"noob\">";
				
				}				
				elseif($NoobProt == 1
					&& $NoobTime < $RowUserPoints
					&& $CurrentPoints < $NoobTime){
					 //FUERTES
						
					$Systemtatus2 	= $lang['gl_s'];
					$Systemtatus 	= "<span class=\"strong\">";
					
				}elseif($NoobProt == 1
					&& $NoobTime > $RowUserPoints
					&& $CurrentPoints > $NoobTime){		
			
					$Systemtatus2 	= "<span class=\"noob\">".$lang['gl_w']."</span>";
					$Systemtatus 	= "<span class=\"noob\">";
				}*/
				else
				{
					$Systemtatus2 	= "";
					$Systemtatus 	= "";
				}
				$Systemtatus4 		= $User2Points['total_rank'];
	
				if ($Systemtatus2 != '')
				{
					$Systemtatus6 	= "<font color=\"white\">(</font>";
					$Systemtatus7 	= "<font color=\"white\">)</font>";
				}
				if ($Systemtatus2 == '')
				{
					$Systemtatus6 	= "";
					$Systemtatus7 	= "";
				}
			$admin = "";
			if ($Row['authlevel'] > 0) {
				$admin = "<font color=\"lime\"><blink>A</blink></font>";
			}
			$Systemtart = $Row['total_rank'];
			if (strlen($Systemtart) < 3) {
				$Systemtart = 1;
			} else {
				$Systemtart = (floor( $Systemtart / 100 ) * 100) + 1;
			}
				$Result .= "<a style=\"cursor: pointer;\"";
				$Result .= " onmouseover='return overlib(\"";
				$Result .= "<table width=190>";
				$Result .= "<tr>";
				$Result .= "<td class=c colspan=2>". $lang['gl_player'] .preg_replace("('|\")", '', $Row['username']). $lang['gl_in_the_rank'] .$Row['total_rank']."</td>";
                                $Result .= "</tr><tr>";
				/*if ($Row['id'] != $users->user['id'])
				{
					$Result .= "<td><a href=game.php?page=buddy&mode=2&u=".$Row['id'].">".$lang['gl_buddy_request']."</a></td>";
					$Result .= "</tr><tr>";
				}*/
				$Result .= "<td><a href=game.php?page=statistics&who=player&start=".$Systemtart.">".$lang['gl_stat']."</a></td>";
				$Result .= "</tr>";
				$Result .= "</table>\"";
				$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
				$Result .= " onmouseout='return nd();'>";
				$Result .= $Systemtatus;
				//$Result .= eregi_replace("'|\"", '', $Row['username'])."</span>";
                                $Result .= preg_replace("('|\")", '', $Row['username'])."</span>";
				$Result .= $Systemtatus6;
				$Result .= $Systemtatus;
				$Result .= $Systemtatus2;
				$Result .= $Systemtatus7." ".$admin;
				$Result .= "</span></a>";

                                
		}
	
		return $Result;
	}
	
	protected function _TooltipDebris($Row, $Galaxy, $System, $Planet, $PlanetType){
		global $lang, $dpath,   $planetrow, $pricelist;
		
		$RecNeeded = ceil(($Row['debris_metal'] + $Row['debris_crystal']) / $pricelist[209]['capacity']);
                //echo $RecNeeded;
                if ($RecNeeded < $this->CurrentRC) {
			$RecSended = $RecNeeded;
		} elseif ($RecNeeded >= $this->CurrentRC) {
			$RecSended = $planetrow['recycler'];
		} else {
			$RecSended = $planetrow['recycler'];
		}
		$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table width=240>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>";
		$Result .= $lang['gl_debris_field']." [".$Galaxy.":".$System.":".$Planet."]";
		$Result .= "</td>";
		$Result .= "</tr><tr>";
		$Result .= "<th width=80>";
		$Result .= "<img src=". $dpath ."planeten/debris.jpg height=75 width=75 />";
		$Result .= "</th>";
		$Result .= "<th>";
		$Result .= "<table>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>".$lang['gl_resources']."</td>";
		$Result .= "</tr><tr>";
		$Result .= "<th>".$lang['Metal']." </th><th>". pretty_number($Row['debris_metal']) ."</th>";
		$Result .= "</tr><tr>";
		$Result .= "<th>".$lang['Crystal']." </th><th>". pretty_number($Row['debris_crystal']) ."</th>";
		$Result .= "</tr><tr>";
		$Result .= "<td class=c colspan=2>".$lang['gl_actions']."</td>";
		$Result .= "</tr><tr>";
		$Result .= "<th colspan=2 align=left>";
		$Result .= "<a href= # onclick=&#039javascript:pada_galaxy (8, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$RecSended.");&#039 >". $lang['type_mission'][8] ."</a>";
		$Result .= "</th></tr>";
		$Result .= "</table>";
		$Result .= "</th>";
		$Result .= "</tr>";
		$Result .= "</table>\"";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		$Result .= "<img src=". $dpath ."planeten/debris.jpg height=22 width=22></a>";
	
		return $Result;
	}
	 
	protected function _TooltipMoon($Row, $Galaxy, $System, $Planet, $PlanetType) {
		global $lang, $users, $dpath,  $CurrentSystem, $CurrentGalaxy, $CanDestroy;
	
		if ($Row['id'] != $users->user['id']) {
			$MissionType6Link = "<a href=# onclick=&#039javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039 >". $lang['type_mission'][6] ."</a><br /><br />";
		} elseif ($Row['id'] == $users->user['id']) {
			$MissionType6Link = "";
		}
		if ($Row['id'] != $users->user['id']) {
			$MissionType1Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>". $lang['type_mission'][1] ."</a><br />";
		} elseif ($Row['id'] == $users->user['id']) {
			$MissionType1Link = "";
		}
	
		if ($Row['id'] != $users->user['id']) {
			$MissionType5Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=5>". $lang['type_mission'][5] ."</a><br />";
		} elseif ($Row['id'] == $users->user['id']) {
			$MissionType5Link = "";
		}
		if ($Row['id'] == $users->user['id']) {
			$MissionType4Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=4>". $lang['type_mission'][4] ."</a><br />";
		} elseif ($Row['id'] != $users->user['id']) {
			$MissionType4Link = "";
		}
	
		if ($Row['id'] != $users->user['id']) {
			if ($CanDestroy > 0) {
				$MissionType9Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=9>". $lang['type_mission'][9] ."</a>";
			} else {
				$MissionType9Link = "";
			}
		} elseif ($Row['id'] == $users->user['id']) {
			$MissionType9Link = "";
		}
	
		$MissionType3Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=3>". $lang['type_mission'][3] ."</a><br />";
		
		if ($Row AND !$Row["destruyed"] AND $Row["id_luna"]){		
			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>";
			$Result .= $lang['gl_moon'].": " . $Row['moon_name'] . " [".$Galaxy.":".$System.":".$Planet."]";
			$Result .= "</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th width=80>";
			$Result .= "<img src=". $dpath ."planeten/s_mond.jpg height=75 width=75 />";
			$Result .= "</th>";
			$Result .= "<th>";
			$Result .= "<table>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_features']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th>".$lang['gl_diameter']."</th>";
			$Result .= "<th>". pretty_number($Row['diameter']) ."</th>";
			$Result .= "</tr><tr>";
			$Result .= "<th>".$lang['gl_temperature']."</th><th>". pretty_number($Row['temp_min']) ."</th>";
			$Result .= "</tr><tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_actions']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<th colspan=2 align=center>";
			$Result .= $MissionType6Link;
			$Result .= $MissionType3Link;
			$Result .= $MissionType4Link;
			$Result .= $MissionType1Link;
			$Result .= $MissionType5Link;
			$Result .= $MissionType9Link;
			$Result .= "</tr>";
			$Result .= "</table>";
			$Result .= "</th>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= "<img src=". $dpath ."planeten/small/s_mond.jpg height=22 width=22>";
			$Result .= "</a>";
		}
	
		return $Result;
	}
	
	protected function _TooltipPlanetStatus($Row, $Galaxy, $System, $Planet, $PlanetType){
		global $lang, $users,  $CurrentSystem, $CurrentGalaxy,$planetrow;//$HavePhalanx,
		//print_r($GLOBALS);
		if ($Row['ally_id'] == $users->user['ally_id']
			AND	$Row['id'] != $user['id']
			AND	$users->user['ally_id'] != '') {
			$TextColor = "<font color=\"green\">";
			$EndColor  = "</font>";
		} elseif ($Row['id'] == $users->user['id']) {
			$TextColor = "<font color=\"red\">";
			$EndColor  = "</font>";
		} else {
			$TextColor = '';
			$EndColor  = "";
		}
               // echo $HavePhalanx;
		if ($Row['last_update'] > (time()-59 * 60)
			AND	$Row['id'] != $users->user['id']) {
			$Inactivity = pretty_time_hour(time() - $Row['last_update']);
		}
                
		if ($Row && $Row["destruyed"] == 0) {
                        
			if ($this->HavePhalanx > 0) {
                                if ($Row["galaxy"] ==  $Galaxy && $Row['id'] != $users->user['id']) {
					$Range = $this->GetPhalanxRange ( $this->HavePhalanx );
                                        //REVISAR INICIO
					$SystemLimitMin = $this->CurrentSystem - $Range;
                                        $SystemLimitMax = $this->CurrentSystem + $Range;

                                        if ($SystemLimitMin < 1) {
                                                $SystemLimitMin = 1;
                                        }
                                        //REVISAR FIN
                                         if ($System <= $SystemLimitMax) {

                                            if ($System >= $SystemLimitMin) {
                                                    $PhalanxTypeLink = "<a href=game.php?page=phalanx&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."  title=\"".$lang['gl_phalanx']."\">" . $Row['planet_name'] . "</a><br />";

                                            }
                                        }
                                        //echo $Range;
					//if (($this->CurrentGalaxy + $Range) <= $this->CurrentSystem && $this->CurrentSystem >= ($this->CurrentGalaxy - $Range)) {
                                        //    $PhalanxTypeLink = "<a href=# onclick=fenster('game.php?page=phalanx&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."')  title=\"".$lang['gl_phalanx']."\">" . $Row['planet_name'] . "</a><br />";
					//}
				}
			}

                        
			$PhalanxTypeLink = (isset($PhalanxTypeLink)) ? $PhalanxTypeLink : $Row['planet_name'];
	
			$Result .= $TextColor . $PhalanxTypeLink . $EndColor;
	
			if ($Row['last_update'] > (time() - (59 * 60)) && $Row['id'] != $users->user['id']) {
				if ($Row['last_update']  > (time()-10 * 60)
					AND	$Row['id'] != $users->user['id']) {
					$Result .= "(*)";
				} else {
					$Result .= " (".$Inactivity.")";
				}
			}
		} elseif ($Row["destruyed"] != 0) {
			$Result .= $lang['gl_planet_destroyed'];
		}
	
		return $Result;
	}
	
	protected function _TooltipPlanet($Row, $Galaxy, $System, $Planet, $PlanetType ) {
		global $lang, $dpath, $users, $CurrentSystem, $CurrentGalaxy,$planetrow;
                
		if ($Row && $Row["destruyed"] == 0 && $Row["id_planet"] != 0) {
                    
			if ($this->HavePhalanx > 0) {

                                if ($Row["galaxy"] == $Galaxy && $Row['id'] != $users->user['id']){
                                        
                                    $Range = $this->GetPhalanxRange ( $this->HavePhalanx );
                                        //REVISAR INICIO
					$SystemLimitMin = $this->CurrentSystem - $Range;
                                        $SystemLimitMax = $this->CurrentSystem + $Range;

                                        if ($SystemLimitMin < 1) {
                                                $SystemLimitMin = 1;
                                        }
                                        //REVISAR FIN
                                         if ($System <= $SystemLimitMax) {

                                            if ($System >= $SystemLimitMin) {
                                                    $PhalanxTypeLink = "<a href=game.php?page=phalanx&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType.">" . $lang['gl_phalanx'] . "</a><br />";
                                                    
                                            }
                                        } else {
                                                $PhalanxTypeLink = "";
                                        }
                                        
                                } else {
                                        $PhalanxTypeLink = "";
                                }
				 
			} else {
				$PhalanxTypeLink = "";
			}
	
			if ($Row['id'] != $users->user['id']) {
				$MissionType6Link = "<a href=# onclick=&#039javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039 >". $lang['type_mission'][6] ."</a><br /><br />";
			} elseif ($Row['id'] == $users->user['id']) {
				$MissionType6Link = "";
			}
			if ($Row['id'] != $users->user['id']) {
				$MissionType1Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>". $lang['type_mission'][1] ."</a><br />";
			} elseif ($Row['id'] == $users->user['id']) {
				$MissionType1Link = "";
			}
			if ($Row['id'] != $users->user['id']) {
				$MissionType5Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=5>". $lang['type_mission'][5] ."</a><br />";
			} elseif ($Row['id'] == $users->user['id']) {
				$MissionType5Link = "";
			}
			if ($Row['id'] == $users->user['id']) {
				$MissionType4Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=4>". $lang['type_mission'][4] ."</a><br />";
			} elseif ($Row['id'] != $users->user['id']) {
				$MissionType4Link = "";
			}
			$MissionType3Link = "<a href=game.php?page=fleet&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=3>". $lang['type_mission'][3] ."</a><br />";
	
			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>";   
			//$Result .= $lang['gl_planet'] . " " . cleanHTML($Row['planet_name']) . " [".$Galaxy.":".$System.":".$Planet."]";
			
			$Result .= $lang['gl_planet'] . " " . $Row['planet_name'] . " [".$Galaxy.":".$System.":".$Planet."]";
			$Result .= "</td>";
			$Result .= "</tr>";
			$Result .= "<tr>";
			$Result .= "<th width=80>";
			$Result .= "<img src=". $dpath ."planeten/small/s_". $Row["image"] .".jpg height=75 width=75 />";
			$Result .= "</th>";
			$Result .= "<th align=left>";
			$Result .= $MissionType6Link;
			$Result .= $PhalanxTypeLink;
			$Result .= $MissionType1Link;
			$Result .= $MissionType5Link;
			$Result .= $MissionType4Link;
			$Result .= $MissionType3Link;
                        $Result .= $PhalanxTypeLink;
			$Result .= "</th>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= "<img src=".	$dpath ."planeten/small/s_". $Row["image"] .".jpg height=30 width=30>";
			$Result .= "</a>";
		}
		
		return $Result;
	}
	
	protected function secureNumericGet(){
		if(!$_GET) return false;
	
		foreach($_GET as $name => $value){
			if(secureNumeric($value) == false){
				unset($_GET[$name]);
			}
		}
		return;
	}
	
	protected function secureNumeric($value){
		if(!$value) return false;
	
		if(ereg("[0-9]", $value) === false){
			return false;
		}
		return true;
	}
	
	protected function actual_time($format, $offset, $timestamp){
		$offset = getActualTimeOffset();
		$timestamp = $timestamp + $offset;
		return gmdate($format, $timestamp);
	}
	
	protected function getActualTimeOffset($offset = "+3"){
		return $offset * 60 * 60;
	}
}

?>