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

	function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
	{
		global $lang, $game_config, $dpath, $user;

		if($CurrentUser['urlaubs_modus'] == 0)
			PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		else
			doquery("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".intval($CurrentUser['id']),"planets");

		$parse				 			= $lang;
		$parse['dpath']      			= $dpath;
		$parse['image']      			= $CurrentPlanet['image'];


   
    if ($user['authlevel'] > 0)
	{
		$parse['admin_link']	="<tr><td><div align=\"center\"><a href=\"javascript:top.location.href='adm/index.php'\"> <font color=\"lime\">" . $lang['lm_administration'] . "</font></a></div></td></tr>";
	}
	else
	{
		$parse['admin_link']  	= "";
	}
               
		if($CurrentUser['urlaubs_modus'] && $CurrentUser['db_deaktjava'])
		{
		$parse['show_umod_notice']      	.= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
	}
		else
		{
			$parse['show_umod_notice']       = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 2px solid #1DF0F0; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table><br>' : '';
			$parse['show_umod_notice']      .= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
		}

		$parse['planetlist'] 			= '';
		$ThisUsersPlanets    			= SortUserPlanets ( $CurrentUser );

		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets))
		{
			if ($CurPlanet["destruyed"] == 0)
			{
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet'])
					$parse['planetlist'] .= "selected=\"selected\" ";
				$parse['planetlist'] .= "value=\"game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$CurPlanet['id']."";
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";
				if($CurPlanet['planet_type'] != 3)
					$parse['planetlist'] .= "".$CurPlanet['name'];
				else
					$parse['planetlist'] .= "".$CurPlanet['name'] . " (" . $lang['fcm_moon'] . ")";
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
			}
		}

		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$metal = pretty_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"])) {
			$parse['metal'] = colorRed($metal);
		} else {
			$parse['metal'] = $metal;
		}
		// Cristal
		$crystal = pretty_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = colorRed($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}
		// Deuterium
		$deuterium = pretty_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = colorRed($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}
		$parse['darkmatter'] 		= pretty_number($CurrentUser["darkmatter"]);


        // Porcentaje de almacenes con bug fix almaneces negativos.
        $parse['metal_max'] .= pretty_number($CurrentPlanet["metal_max"] / 1) . " {$lang['']}";
        $parse['crystal_max'] .= pretty_number($CurrentPlanet["crystal_max"] / 1) . " {$lang['']}";
        $parse['deuterium_max'] .= pretty_number($CurrentPlanet["deuterium_max"] / 1) . " {$lang['']}";

        $parse['metal_perhour'] .= $CurrentPlanet["metal_perhour"] + ($game_config['metal_basic_income'] * $game_config['resource_multiplier']);
        $parse['crystal_perhour'] .= $CurrentPlanet["crystal_perhour"] + ($game_config['crystal_basic_income'] * $game_config['resource_multiplier']);
        $parse['deuterium_perhour'] .= $CurrentPlanet["deuterium_perhour"] + ($game_config['deuterium_basic_income'] * $game_config['resource_multiplier']);

        $parse['metalh'] .= round($CurrentPlanet["metal"]);
        $parse['crystalh'] .= round($CurrentPlanet["crystal"]);
        $parse['deuteriumh'] .= round($CurrentPlanet["deuterium"]);

        $parse['metal_mmax'] .= $CurrentPlanet["metal_max"] * MAX_OVERFLOW;
        $parse['crystal_mmax'] .= $CurrentPlanet["crystal_max"] * MAX_OVERFLOW;
        $parse['deuterium_mmax'] .= $CurrentPlanet["deuterium_max"] * MAX_OVERFLOW;            
    
        $parse['metal_storage']         = floor($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) . "%";
        $parse['crystal_storage']       = floor($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) . "%";
        $parse['deuterium_storage']     = floor($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) . "%";
        $parse['energy_storage']        = floor(($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) / (1 + $CurrentPlanet['energy_max']) * 100) . "%";
        
        $parse['metal_storage_bar']     = floor(($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) * 0.70);
        $parse['crystal_storage_bar']   = floor(($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) * 0.70);
        $parse['deuterium_storage_bar'] = floor(($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) * 0.70);
        $parse['energy_storage_bar']    = floor((($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) / (1 + $CurrentPlanet['energy_max']) * 100) * 0.70);
    
        if ($parse['metal_storage_bar'] >= (100 * 0.70)) {
        $parse['metal_storage_bar']                = 70;
        $parse['metal_storage']                    = "100%";
        $parse['metal_storage_barcolor']        = '#FF0000';
        } elseif ($parse['metal_storage_bar'] > (100 * 0.63)) {
        $parse['metal_storage_barcolor']        = '#FFCC00';
        } else {
        $parse['metal_storage_barcolor']        = '#00CC00';
        }

        if ($parse['crystal_storage_bar'] >= (100 * 0.70)) {
        $parse['crystal_storage_bar']            = 70;
        $parse['crystal_storage']                = "100%";
        $parse['crystal_storage_barcolor']        = '#FF0000';
        } elseif ($parse['crystal_storage_bar'] > (100 * 0.63)) {
        $parse['crystal_storage_barcolor']        = '#FFCC00';
        } else {
        $parse['crystal_storage_barcolor']        = '#00CC00';
        }

        if ($parse['deuterium_storage_bar'] >= (100 * 0.70)) {
        $parse['deuterium_storage_bar']            = 70;
        $parse['deuterium_storage']                = "100%";
        $parse['deuterium_storage_barcolor']    = '#FF0000';
        } elseif ($parse['deuterium_storage_bar'] > (100 * 0.63)) {
        $parse['deuterium_storage_barcolor']    = '#FFCC00';
        } else {
        $parse['deuterium_storage_barcolor']    = '#00CC00';
        }
        
          if ($parse['energy_storage_bar'] >= (100 * 0.70)) {
        $parse['energy_storage_bar'] = 70;
        $parse['energy_storage_barcolor'] = '#00CC00';
        } elseif ($parse['energy_storage_bar'] < 0) {
       
       $parse['energy_storage_bar'] = floor((($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) / (1 + $CurrentPlanet['energy_max']) * 100) * 0.70);  
        $parse['energy_storage']     = floor(($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) / (1 + $CurrentPlanet['energy_max']) * 100) . "%"; 
        $parse['energy_storage_barcolor'] = '#FF0000';
        } else {
        $parse['energy_storage_barcolor'] = '#00CC00';
        } 
 


       
        if($user["new_message"]!=0){
        $color="color=\"red\"";
    }else{
        $color="color=\"white\"";
    }
    $parse["new_message"]    = '<font size="1px" '.$color.' > '. $user["new_message"].' </font>';  

        $funcionespia = doquery("SELECT * FROM `{{table}}` WHERE `galaxia` = ".$CurrentUser['galaxy']." AND `sistema` = ".$CurrentUser['system']." AND `planeta` = ".$CurrentPlanet['planet'].";", 'radar');
        $respy = mysql_num_rows($funcionespia);
        if ($respy) {
            for ($i=0;$i<$respy;$i++) {
            $lineaspy = mysql_fetch_array($funcionespia);
            $codealert = $lineaspy['id'];
            if ($lineaspy['alert'] == 1) {
            $alertred = 1;
            } elseif ($lineaspy['alert'] == 2) {
            $alertorange = 1;
            } else {
            $alertgreen = 1;
            }
            }
            }
        $actionled = $_GET['actionled'];
        if ($actionled == '1'){
        doquery("DELETE FROM {{table}} WHERE `id`=$codealert;", "radar");
        message ('Alert Deleted!', 'game.php?page=overview', 2);
        }
        if ($alertred == 1) {
            $parse['alertled'] = "<br><a href='game.php?page=overview&actionled=1' border='0'><img src='styles/images/red.gif' style='float:center; margin-right:2px;'></a>";
            } elseif
            ($alertorange == 1) {
            $parse['alertled'] = "<br><a href='game.php?page=overview&actionled=1' border='0'><img src='styles/images/yellow.gif' style='float:center; margin-right:2px;'></a>";
            } else { 
            $parse['alertled'] = "<br><img src='styles/images/green.gif' style='float:center; margin-right:2px;'>";
            }

                if ($CurrentUser['rpg_geologue'] > 0 ) {
                   $parse['geologo'] = "geologo.gif";
                } else {
                   $parse['geologo'] = "geologo_un.gif";
                }
                if ($CurrentUser['rpg_amiral'] > 0 ) {
                   $parse['admirante'] = "admirante.gif";
                } else {
                   $parse['admirante'] = "admirante_un.gif";
                }
                if ($CurrentUser['rpg_commandant'] > 0 ) {
                   $parse['comandante'] = "comandante.gif";
                } else {
                   $parse['comandante'] = "comandante_un.gif";
                }
                if ($CurrentUser['rpg_ingenieur'] > 0 ) {
                   $parse['ingeniero'] = "ingeniero.gif";
                } else {
                   $parse['ingeniero'] = "ingeniero_un.gif";
                }
                if ($CurrentUser['rpg_technocrate'] > 0 ) {
                   $parse['tecnocrata'] = "tecnocrata.gif";
                } else {
                   $parse['tecnocrata'] = "tecnocrata_un.gif";
                }   
                 if ($CurrentUser['rpg_constructeur'] > 0 ) {
                   $parse['constructeur'] = "constructeur.gif";
                } else {
                   $parse['constructeur'] = "constructeur_un.gif";
                }   
                 if ($CurrentUser['rpg_scientifique'] > 0 ) {
                   $parse['scientifique'] = "scientifique.gif";
                } else {
                   $parse['scientifique'] = "scientifique_un.gif";
                }   
                 if ($CurrentUser['rpg_stockeur'] > 0 ) {
                   $parse['stockeur'] = "stockeur.gif";
                } else {
                   $parse['stockeur'] = "stockeur_un.gif";
                }  
                 if ($CurrentUser['rpg_defenseur'] > 0 ) {
                   $parse['defenseur'] = "defenseur.gif";
                } else {
                   $parse['defenseur'] = "defenseur_un.gif";
                }  
                 if ($CurrentUser['rpg_bunker'] > 0 ) {
                   $parse['bunker'] = "bunker.gif";
                } else {
                   $parse['bunker'] = "bunker_un.gif";
                }  
                 if ($CurrentUser['rpg_espion'] > 0 ) {
                   $parse['espion'] = "espion.gif";
                } else {
                   $parse['espion'] = "espion_un.gif";
                }  
                 if ($CurrentUser['rpg_destructeur'] > 0 ) {
                   $parse['destructeur'] = "destructeur.gif";
                } else {
                   $parse['destructeur'] = "destructeur_un.gif";
                }  
                 if ($CurrentUser['rpg_general'] > 0 ) {
                   $parse['general'] = "general.gif";
                } else {
                   $parse['general'] = "general_un.gif";
                }  
                 if ($CurrentUser['rpg_raideur'] > 0 ) {
                   $parse['raideur'] = "raideur.gif";
                } else {
                   $parse['raideur'] = "raideur_un.gif";
                }  
                 if ($CurrentUser['rpg_empereur'] > 0 ) {
                   $parse['empereur'] = "empereur.gif";
                } else {
                   $parse['empereur'] = "empereur_un.gif";
                }  



		$TopBar 			 		= parsetemplate(gettemplate('topnav'), $parse);

		return $TopBar;
	}
?>