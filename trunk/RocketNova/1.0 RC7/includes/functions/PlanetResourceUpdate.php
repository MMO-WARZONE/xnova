<?php

/**
 * PlanetResourceUpdate.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 * Edit and fixed 2009 by Mori for Xnova 
 */

function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false ) {
	global $ProdGrid, $resource, $reslist, $game_config;
  
	$atom_energy = 0;
  
	// Mise a jour de l'espace de stockage
	$CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[22] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[23] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[24] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
  
	// Calcul de l'espace de stockage (avec les debordements possibles)
	$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
	$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
	$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;

	// Calcul de production lin�aire des divers types
	$Caps             = array();
	$BuildTemp        = $CurrentPlanet[ 'temp_max' ];

	for ( $ProdID = 0; $ProdID < 300; $ProdID++ ) {
		if ( in_array( $ProdID, $reslist['prod']) ) {
			$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel       = $CurrentPlanet[ $resource[$ProdID] ];
			$Caps['metal_perhour']     +=  ( eval  ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$Caps['crystal_perhour']   +=  ( eval  ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$deutval                    =  ( eval  ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $game_config['resource_multiplier']));
			
			if ($deutval < 0) {
				$Caps['deuterium_used'] += $deutval;
			} else {
				$Caps['deuterium_perhour'] += $deutval * (1 + ( $CurrentUser['rpg_geologue'] * 0.05 ));
			}

			$Energy = eval( $ProdGrid[$ProdID]['formule']['energy']);

			if ($ProdID < 4) {
				$Caps['energy_used']   +=  $Energy;
			} elseif ($ProdID >= 4 ) {
				$Caps['energy_max']    +=  ($Energy * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05 + ($CurrentUser['energy_tech'] * 0.01))));
			}
			
			if ($ProdID == 12) { $atom_energy = ($Energy * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05 + ($CurrentUser['energy_tech'] * 0.01)))); }
		}
	}

	// Il n'y a pas de production de base sur une lune (ni de production tout court d'ailleurs
	if ($CurrentPlanet['planet_type'] == 3) {
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
		$CurrentPlanet['metal_perhour']        = 0;
		$CurrentPlanet['crystal_perhour']      = 0;
		$CurrentPlanet['deuterium_perhour']    = 0;
		$CurrentPlanet['energy_used']          = 0;
		$CurrentPlanet['energy_max']           = 0;
		$CurrentPlanet['deuterium_used']       = 0;
	} else {
		$CurrentPlanet['metal_perhour']        = ($Caps['metal_perhour']);
		$CurrentPlanet['crystal_perhour']      = ($Caps['crystal_perhour']);
		$CurrentPlanet['deuterium_perhour']    = ($Caps['deuterium_perhour']);
		$CurrentPlanet['energy_used']          = ($Caps['energy_used']);
		$CurrentPlanet['energy_max']           = ($Caps['energy_max']);
		$CurrentPlanet['deuterium_used']       = ($Caps['deuterium_used']);
	}

	// Depuis quand n'avons nous pas les infos ressources a jours ?
	$ProductionTime               = ($UpdateTime - $CurrentPlanet['last_update']);
	$CurrentPlanet['last_update'] = $UpdateTime;
	

	if ($CurrentPlanet['energy_max'] <= 0) {
		// Ah ha ... l'energie max est 0 ...
		// Soit pas de production d'energie ... Soit mode vacance
		$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
		$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
		$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
		$production_level            = 0;
	} elseif ($CurrentPlanet["energy_max"] >= abs($CurrentPlanet["energy_used"])) {
		// Cas normal (Y a assez d'energie toutes les mines tournent a plein rendement)
		$production_level            = 100;
	} else {
		// Cas ou il manque de l'energie ... On calcule un pourcentage de production
		$production_level            = (($CurrentPlanet['energy_max'] / abs($CurrentPlanet['energy_used'])) * 100);
	}
	// Mise a l'echele des valeurs
	if ($production_level > 100) {
		$production_level = 100;
	} elseif ($production_level < 0) {
		$production_level = 0;
	}

	// checks fusion work or goes offline
	// script writen by Mori for Xnova 2009

	if ($CurrentPlanet['deuterium_used'] < 0) {
		$DeuteriumProduction = ($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * (0.01 * $production_level);
		$DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$DeuteriumUsedAtom   = ($ProductionTime * ($CurrentPlanet['deuterium_used'] / 3600));
		$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc + $DeuteriumUsedAtom;
		// calculate fusion-worktime to off time and resource production
		if  ($DeuteriumTheorical < 0) {
			$DeuteriumTheorical = 0;
			$dh    = $CurrentPlanet['deuterium'];
			$dps   = ($CurrentPlanet['deuterium_perhour'] * (0.01 * $production_level))/3600;
			$dups  = (abs($CurrentPlanet['deuterium_used'])/3600);
			$gtime = floor(($dh-$dps)/($dups-$dps));
			$CurrentPlanet['fusion_plant_porcent'] = 0;
			$EngineOff = true;
			$at_DeutProd         = ($gtime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * (0.01 * $production_level);
			$at_DeutBaseProd     = (($gtime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$DeutUsedAtom        = ($gtime * ($CurrentPlanet['deuterium_used'] / 3600));
			$at_DeutProd        += $at_DeutBaseProd + $DeutUsedAtom;
			$at_MetalProd        = ($gtime * ($CurrentPlanet['metal_perhour'] / 3600)) * (0.01 * $production_level);
			$at_MetalBaseProd    = (($gtime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$at_MetalProd       += $at_MetalBaseProd;
			$at_CrystalProd      = ($gtime * ($CurrentPlanet['crystal_perhour'] / 3600)) * (0.01 * $production_level);
			$at_CrystalBaseProd  = (($gtime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$at_CrystalProd     += $at_CrystalBaseProd;
			$ProductionTime     -= $gtime;
			$CurrentPlanet['deuterium_used'] = 0;
			// new production level
			$CurrentPlanet['energy_max'] -= $atom_energy;

			if ($CurrentPlanet['energy_max'] <= 0) {
				$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
				$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
				$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
				$production_level            = 0;
			} elseif ($CurrentPlanet["energy_max"] >= abs($CurrentPlanet["energy_used"])) {
				$production_level            = 100;
			} else {
				$production_level            = (($CurrentPlanet['energy_max'] / abs($CurrentPlanet['energy_used'])) * 100);
			}

			if ($production_level > 100) {
				$production_level = 100;
			} elseif ($production_level < 0) {
				$production_level = 0;
			}

		}
    
	} 
  
	// fusionscript end

	if ( $CurrentPlanet['metal'] <= $MaxMetalStorage ) {
		$MetalProduction = ($ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * (0.01 * $production_level);
		$MetalBaseProduc = (($ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$MetalTheorical  = $CurrentPlanet['metal'] + $MetalProduction  +  $MetalBaseProduc;
		if ( $MetalTheorical <= $MaxMetalStorage ) {
			$CurrentPlanet['metal']  = $MetalTheorical + $at_MetalProd;
		} else {
			$CurrentPlanet['metal']  = $MaxMetalStorage;
		}
	}

	if ( $CurrentPlanet['crystal'] <= $MaxCristalStorage ) {
		$CristalProduction = ($ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * (0.01 * $production_level);
		$CristalBaseProduc = (($ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$CristalTheorical  = $CurrentPlanet['crystal'] + $CristalProduction  +  $CristalBaseProduc;
		if ( $CristalTheorical <= $MaxCristalStorage ) {
			$CurrentPlanet['crystal']  = $CristalTheorical + $at_CrystalProd;
		} else {
			$CurrentPlanet['crystal']  = $MaxCristalStorage;
		}
	}

	if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage ) {
		$DeuteriumProduction = ($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * (0.01 * $production_level);
		$DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$DeuteriumUsedAtom   = ($ProductionTime * ($CurrentPlanet['deuterium_used'] / 3600));
		$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc + $DeuteriumUsedAtom;
		if ( $DeuteriumTheorical <= $MaxDeuteriumStorage ) {
			$CurrentPlanet['deuterium']  = $DeuteriumTheorical + $at_DeutProd;
		} else {
			$CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
		}
	}

	if ($Simul == false) {
		// Gestion de l'eventuelle queue de fabrication d'elements
		$Builded          = HandleElementBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );

		// On enregistre la planete !
		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             ."', ";
		$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           ."', ";
		$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         ."', ";
		$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       ."', ";
		$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       ."', ";
		$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     ."', ";
		$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   ."', ";
		$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] ."', ";
		$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']       ."', ";
		$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        ."', ";
		$QryUpdatePlanet .= "`deuterium_used` = '"   . $CurrentPlanet['deuterium_used']    ."', ";
		if ($EngineOff == true) {
			$QryUpdatePlanet .= "`fusion_plant_porcent` = '"   . $CurrentPlanet['fusion_plant_porcent']    ."', ";
			$EngineOff = false;
		}
		// Par hasard des elements etaient finis ....
		if ( $Builded != '' ) {
			foreach ( $Builded as $Element => $Count ) {
				if ($Element <> '') {
					$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
		}
		$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";

		doquery("LOCK TABLE {{table}} WRITE", 'planets');
		doquery($QryUpdatePlanet, 'planets');
		doquery("UNLOCK TABLES", '');
	}
	if($Simul == true) {
		
		echo '
		Current User-ID: 		'.$CurrentUser['id']					.'<br>
		Current User-Name:		'.$CurrentUser['username']				.'<br>
		======================================================================<br>
		Metall:           '.intval($CurrentPlanet['metal'])				.'<br>
		Kristall: 				'.intval($CurrentPlanet['crystal'])				.'<br>         
		Deuterium: 				'.intval($CurrentPlanet['deuterium'])			.'<br>        
		Last_Update: 			'.intval($CurrentPlanet['last_update'])			.'<br>       
		B_Hangar_ID: 			'.intval($CurrentPlanet['b_hangar_id'])			.'<br>       
		Metall theo pro Stunde: 		'.intval($CurrentPlanet['metal_perhour'])		.'<br>     
		Kristall theo pro Stunde: 	'.intval($CurrentPlanet['crystal_perhour'])		.'<br>   
		Deuterium theo pro Stunde: 	'.intval($CurrentPlanet['deuterium_perhour'])	.'<br>
		Metall pro Stunde           '.($CurrentPlanet['metal_perhour'] * (0.01 * $production_level)).'<br>
		Kristall pro Stunde         '.($CurrentPlanet['crystal_perhour'] * (0.01 * $production_level)).'<br>
		Deuterium pro Stunde        '.(($CurrentPlanet['deuterium_perhour'] * (0.01 * $production_level)) + $CurrentPlanet['deuterium_used']).'<br>
		Energy Max                  '.$CurrentPlanet['energy_max'].'<br>
		Energy used                 '.$CurrentPlanet['energy_used'].'<br>
		Energy percent              '.((0.01 * $production_level)*100).'<br>
		Energy used                 '.$CurrentPlanet['energy_used'].'<br>
		Deuterium used              '.$CurrentPlanet['deuterium_used'].'<br>
		Deuterium used time now up  '.$DeuteriumUsedAtom.'<br>
		Fusion percent =            '.$CurrentPlanet['fusion_plant_porcent'].'<br>
		Energie: 		   '.intval($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']).'/'.intval($CurrentPlanet['energy_max']).'<br>
		<br><br><br><br>';
	}

}

// Revision History
// - 1.0 Mise en module initiale
// - 1.1 Mise a jour automatique mines / silos / energie ...
// - 1.2 added Simulation Output by Helmchen
?>
