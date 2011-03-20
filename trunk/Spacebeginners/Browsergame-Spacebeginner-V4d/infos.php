<?php

/**
 * infos.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

// ----------------------------------------------------------------------------------------------------------
// Creation de la Liste de flotte disponible sur la lune
//
function BuildFleetListRows ( $CurrentPlanet ) {
	global $resource, $lang;

	$RowsTPL  = gettemplate('gate_fleet_rows');
	$CurrIdx  = 1;
	$Result   = "";
	for ($Ship = 300; $Ship > 200; $Ship-- ) {
		if ($resource[$Ship] != "") {
			if ($CurrentPlanet[$resource[$Ship]] > 0) {
				$bloc['idx']             = $CurrIdx;
				$bloc['fleet_id']        = $Ship;
				$bloc['fleet_name']      = $lang['tech'][$Ship];
				$bloc['fleet_max']       = pretty_number ( $CurrentPlanet[$resource[$Ship]] );
				$bloc['gate_ship_dispo'] = $lang['gate_ship_dispo'];
				$Result                 .= parsetemplate ( $RowsTPL, $bloc );
				$CurrIdx++;
			}
		}
	}
	return $Result;
}
 
// ----------------------------------------------------------------------------------------------------------
// Creation de la combo de selection de Lune d'arrivé
//
function BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet ) {
	global $resource;
	$QrySelectMoons  = "SELECT * FROM {{table}} WHERE `planet_type` = '3' AND `id_owner` = '". $CurrentUser['id'] ."';";
	$MoonList        = doquery ( $QrySelectMoons, 'planets');
	$Combo           = "";
	while ( $CurMoon = mysql_fetch_assoc($MoonList) ) {
		if ( $CurMoon['id'] != $CurrentPlanet['id'] ) {
			$RestString = GetNextJumpWaitTime ( $CurMoon );
			if ( $CurMoon[$resource[43]] >= 1) {
				$Combo .= "<option value=\"". $CurMoon['id'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
			}
		}
	}
	return $Combo;
}

// Planeten Ressgate

function BuildJumpablePlanetCombo ( $CurrentUser, $CurrentPlanet ) {
    global $resource ,$user;
    $QrySelectPorte  = "SELECT * FROM {{table}} WHERE (`planet_type` = '1' OR `planet_type` = '3') AND `id_owner` = '".$CurrentUser['id'] ."';";
    $PlanetList        = doquery ( $QrySelectPorte, 'planets');
    $Combo           = "";
    while ( $CurPlanete = mysql_fetch_assoc($PlanetList) ) {
        if ( $CurPlanete['id'] != $CurrentPlanet['id'] ) {
            $RestString = GetNextJumpWaitTimePlanet ( $CurPlanete );
            if ( $CurPlanete[$resource[46]] >= 1) {
                $Combo .= "<option value=\"". $CurPlanete['id'] ."\">[". $CurPlanete['galaxy'] .":". $CurPlanete['system'] .":". $CurPlanete['planet'] ."] ". $CurPlanete['name'] . $RestString['string'] ."</option>\n";
            }
        }
    }
    return $Combo;
}

// ----------------------------------------------------------------------------------------------------------
// Creation du tableau de production de ressources
// Tient compte du parametrage de la planete (si la production n'est pas affectée a 100% par exemple
// Tient compte aussi du multiplicateur de ressources
//
function ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $Template) {
	global $ProdGrid, $resource, $game_config;

	$BuildLevelFactor = $CurrentPlanet[ $resource[$BuildID]."_porcent" ];
	$BuildTemp        = $CurrentPlanet[ 'temp_max' ];
	$CurrentBuildtLvl = $CurrentPlanet[ $resource[$BuildID] ];

	$BuildLevel       = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
	$Prod[1]          = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[2]          = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[3]          = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[4]          = (floor(eval($ProdGrid[$BuildID]['formule']['appolonium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	// Prise en compte du bonus de l'ingénieur 
	if( $BuildID >= 11 ) { // l'énergie augmente avec les centrales et satellites 
		$Prod[11] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
	} else $Prod[11] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier'])) * $BuildLevel       = "";

	$ActualProd       = floor($Prod[$BuildID]);
	if ($BuildID != 12) {
		$ActualNeed       = floor($Prod[11]);
	} else {
		$ActualNeed       = floor($Prod[3]);
	}

	$BuildStartLvl    = $CurrentBuildtLvl - 2;
	if ($BuildStartLvl < 1) {
		$BuildStartLvl = 1;
	}
	$Table     = "";
	$ProdFirst = 0;

	
	$LastDiff					= 0;
	for ( $BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 10; $BuildLevel++ ) {
		if ($BuildID != 42) {
			$Prod[1] = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])      * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			$Prod[2] = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			$Prod[3] = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium'])  * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
            $Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['appolonium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			// Prise en compte du bonus de l'ingénieur 
			if( $BuildID >= 11 ) { // l'énergie augmente avec les centrales et satellites 
				$Prod[11] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
			} else $Prod[11] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']));
				
			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			if ($ProdFirst > 0) {
				if ($BuildID != 12) {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[$BuildID] - $ProdFirst)) .")</font>";
				} else {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[4] - $ProdFirst)) .")</font>";
				}
			} else {
				$bloc['build_gain']      = "";
			}
				
			$bloc['build_need_diff'] = 0;	
				
			if ($BuildID != 12) {
				// fix diff
				//$LastDiffValue		= $LastDiff - ($Prod[4] - $ActualNeed );
				if ( $BuildLevel > $BuildStartLvl) {
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor((($Prod[4] - $ActualNeed) - $LastDiff))));
				}


				$LastDiff					= $Prod[11] - $ActualNeed;


				$bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[11])) );
				//$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
				//$bloc['build_need_diff'] = colorNumber( pretty_number(floor($LastDiffValue)) );

			} else {
				// fix diff
				//$LastDiffValue		= $LastDiff - ($Prod[3] - $ActualNeed );
				if ( $BuildLevel > $BuildStartLvl) {
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor((($Prod[3] - $ActualNeed) - $LastDiff))));
				}
				
				$LastDiff					= $Prod[3] - $ActualNeed;

				$bloc['build_prod']      = pretty_number(floor($Prod[11]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[11] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
				//$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
				//$bloc['build_need_diff'] = colorNumber( pretty_number(floor($LastDiffValue)) );
			}
				
				
				
				
			if ($ProdFirst == 0) {
				if ($BuildID != 12) {
					$ProdFirst = floor($Prod[$BuildID]);
				} else {
					$ProdFirst = floor($Prod[11]);
				}
			}
		} else {
			// Cas particulier de la phalange
			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			$bloc['build_range']     = ($BuildLevel * $BuildLevel) - 1;
		}
		$Table    .= parsetemplate($Template, $bloc);
	}

	return $Table;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire contre ...
//
function ShowRapidFireTo ($BuildID) {
	global $lang, $CombatCaps;
	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$BuildID]['sd'][$Type] > 1) {
			$ResultString .= $lang['nfo_rf_again']. " ". $lang['tech'][$Type] ." <font color=\"#00ff00\">".$CombatCaps[$BuildID]['sd'][$Type]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire de ...
//
function ShowRapidFireFrom ($BuildID) {
	global $lang, $CombatCaps;

	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$Type]['sd'][$BuildID] > 1) {
			$ResultString .= $lang['nfo_rf_from']. " ". $lang['tech'][$Type] ." <font color=\"#ff0000\">".$CombatCaps[$Type]['sd'][$BuildID]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Construit la page par rapport a l'information demandée ...
// Permet de faire la differance entre les divers types et les pages speciales
//
function ShowBuildingInfoPage ($CurrentUser, $CurrentPlanet, $BuildID) {
	global $dpath, $lang, $resource, $pricelist, $CombatCaps;

	includeLang('infos');

	$GateTPL              = '';
	$DestroyTPL           = '';
	$TableHeadTPL         = '';

	$parse                = $lang;
	// Données de base
	$parse['dpath']       = $dpath;
	$parse['name']        = $lang['info'][$BuildID]['name'];
	$parse['image']       = $BuildID;
	$parse['description'] = $lang['info'][$BuildID]['description'];


	if       ($BuildID >=   1 && $BuildID <=   4) {
		// Cas des mines
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_p_hour}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID ==   11) {
		// Centrale Solaire
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th></tr>";
	} elseif ($BuildID ==  12) {
		// Centrale Fusion
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_deuter}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID >=  14 && $BuildID <=  32) {
		// Batiments Generaux
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  33) {
		// Batiments Terraformer
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  34) {
		// Dépot d'alliance
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  41) {
		// Batiments lunaires
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  42) {
		// Phalange
		$PageTPL              = gettemplate('info_buildings_table');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_range}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_range}</th></tr>";
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  43) {
		// Sprungtor
		$PageTPL              = gettemplate('info_buildings_general');
		$GateTPL              = gettemplate('gate_fleet_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  44) {
		// Silo de missiles
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');	
	} elseif ($BuildID ==  45) {
		// Mondtransformer
		$PageTPL              = gettemplate('info_buildings_general');
		$PageTPL             .= gettemplate('mondtransformer');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  46) {
		// Resstransmiter
		$PageTPL              = gettemplate('info_buildings_general');
		$GateTPL              = gettemplate('gate_ress_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID >= 106 && $BuildID <= 199) {
		// Laboratoire
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID >= 202 && $BuildID <= 220) {
		// Flotte
		$PageTPL              = gettemplate('info_buildings_fleet');
		$parse['element_typ'] = $lang['tech'][200];
		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
		$parse['capacity_pt'] = pretty_number ($pricelist[$BuildID]['capacity']); // Capacitée de fret
		$parse['base_speed']  = pretty_number ($pricelist[$BuildID]['speed']);    // Vitesse de base
		$parse['base_conso']  = pretty_number ($pricelist[$BuildID]['consumption']);  // Consommation de base
		if ($BuildID == 202) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
			$parse['upd_conso']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['consumption2']) .")</font>"; // Consommation apres rééquipement
		} elseif ($BuildID == 211) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
		}
	} elseif ($BuildID >= 401 && $BuildID <= 410) {
		// Defenses
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];

		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 502 && $BuildID <= 503) {
		// Misilles
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 601 && $BuildID <= 615) {
		// Officiers
		$PageTPL              = gettemplate('info_officiers_general');
	}

	// ---- Tableau d'evolution
	if ($TableHeadTPL != '') {
		$parse['table_head']  = parsetemplate ($TableHeadTPL, $lang);
		$parse['table_data']  = ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $TableTPL);
	}

   // La page principale
      $page  = parsetemplate($PageTPL, $parse);
   if ($BuildID ==  43) {
     if ($GateTPL != '') {
        if ($CurrentPlanet[$resource[$BuildID]] > 0) {
            $RestString               = GetNextJumpWaitTime ( $CurrentPlanet );
            $parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
            if ($RestString['value'] != 0) {
                $parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
                $parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
                $parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
            } else {
                $parse['gate_time_script'] = "";
                $parse['gate_wait_time']   = "";
                $parse['gate_script_go']   = "";
            }
            $parse['gate_dest_moons'] = BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet );
            $parse['gate_fleet_rows'] = BuildFleetListRows ( $CurrentPlanet );
            $page .= parsetemplate($GateTPL, $parse);
        }
    }
    }elseif ($BuildID ==  46) {
     if ($GateTPL != '') {
    $parse['gate_start_moon'] = $lang['gate_start2_moon'];
    $parse['gate_dest_moon']  = $lang['gate_dest2_moon'];
    $parse['gate_use_gate']   = $lang['gate_use2_gate'];
    $parse['gate_ship_sel']   = $lang['gate_ship2_sel'];
    $parse['gate_ship_dispo'] = $lang['gate_shipt2_dispo'];
    $parse['gate_jump_btn']   = $lang['gate_jump2_btn'];
    $parse['gate_jump_done']  = $lang['gate_jump2_done'];
    $parse['gate_wait_dest']  = $lang['gate_wait2_dest'];
    $parse['gate_no_dest_g']  = $lang['gate_no2_dest_g'];
    $parse['gate_wait_star']  = $lang['gate_wait2_star'];
    $parse['gate_wait_data']  = $lang['gate_wait2_data'];
    if ($CurrentPlanet[$resource[$BuildID]] > 0) {
            $RestString               = GetNextJumpWaitTimePlanet ( $CurrentPlanet );
            $parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
            if ($RestString['value'] != 0) {

                $parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
                $parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
                $parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
            } else {
                $parse['gate_time_script'] = "";
                $parse['gate_wait_time']   = "";
                $parse['gate_script_go']   = "";
            }
            $parse['gate_dest_moons'] = BuildJumpablePlanetCombo ( $CurrentUser, $CurrentPlanet );
            //$parse['gate_units_rows'] = BuildUnitsListRows ( $CurrentPlanet );
            $page .= parsetemplate($GateTPL, $parse);
                    
        }
        
    }
}

	if ($DestroyTPL != '') {
		if ($CurrentPlanet[$resource[$BuildID]] > 0) {
			// ---- Destruction
			$NeededRessources          = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $BuildID, true, true);
			$DestroyTime               = GetBuildingTime  ($CurrentUser, $CurrentPlanet, $BuildID) / 2;
			$parse['destroyurl']       = "buildings.php?cmd=destroy&building=".$BuildID; // Non balisé les balises sont dans le tpl
			$parse['levelvalue']       = $CurrentPlanet[$resource[$BuildID]]; // Niveau du batiment a detruire
			$parse['nfo_metal']        = $lang['Metal'];
			$parse['nfo_crysta']       = $lang['Crystal'];
			$parse['nfo_deuter']       = $lang['Deuterium'];
			$parse['nfo_appolonium']   = $lang['Appolonium'];
			$parse['metal']            = pretty_number ($NeededRessources['metal']);     // Cout en metal de la destruction
			$parse['crystal']          = pretty_number ($NeededRessources['crystal']);   // Cout en cristal de la destruction
			$parse['deuterium']        = pretty_number ($NeededRessources['deuterium']); // Cout en deuterium de la destruction
			$parse['appolonium']       = pretty_number ($NeededRessources['appolonium']); // Cout en deuterium de la destruction
			$parse['destroytime']      = pretty_time   ($DestroyTime);                   // Durée de la destruction
			// L'insert de destruction
			$page .= parsetemplate($DestroyTPL, $parse);
		}
	}

	return $page;
}

// ----------------------------------------------------------------------------------------------------------
// Appel de la page ...
// Tout le reste ne sert qu'a la calculer :)
//

$gid  = $_GET['gid'];
$page = ShowBuildingInfoPage ($user, $planetrow, $gid);

display ($page, $lang['nfo_page_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture (réinventation de l'eau tiède)
// 1.1 - Ajout JumpGate pour la porte de saut comme la présente OGame ... Enfin un peu mieux quand meme 
// 1.2 - Fixx diff column (olegk)
?>