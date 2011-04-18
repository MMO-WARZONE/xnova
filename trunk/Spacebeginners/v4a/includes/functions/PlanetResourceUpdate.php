<?php

/**
 * PlanetResourceUpdate.php
 *
 * @version 2.0
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */


function PlanetResourceUpdate($CurrentUser, &$CurrentPlanet){
	global $resources,$resource;
	
	//We need to know the production rates
	$Caps = ProductionRates ($CurrentUser,$CurrentPlanet);
	
	//How long since last update?
	$time = time();
	$production = $time - $CurrentPlanet['last_update'];
	
	//Some how many resources where mined in that time?
	foreach($resources as $res){
		//How much should we expect to produce?
		$produce = ($Caps[$res.'_perhour'] / 3600) * $production;
		
		//Do we go over limit?
		if($CurrentPlanet[$res] > $Caps[$res.'_max']){
			//We started over the limit - so base production only
			$CurrentPlanet[$res] += ($game_config[$res.'_basic_income'] * $production);
		}elseif($CurrentPlanet[$res] + $produce > $Caps[$res.'_max']){
			//We have exceded storage limit - resources were produced up to that limit normall, then base production only
			$space = $Caps[$res.'_max'] - $CurrentPlanet[$res];
			
			//What percentage of that time was at base income?
			$pc_base = 1 - ($space / $produce);
			
			//So we got to full...
			$CurrentPlanet[$res] = $Caps[$res.'_max'];
			
			//Then carried on at base comsumption for $pc_base% of the time
			$CurrentPlanet[$res] += ($game_config[$res.'_basic_income'] * $production * $pc_base);			
		}else{
			//We have not exceded storage limit - add the total produce
			$CurrentPlanet[$res] += $produce;
		}
	}
	
	//See what was built
	$built = HandleElementBuildingQueue($CurrentUser,$CurrentPlanet,$production);
	
	//Now update the planet
	$qry  = "UPDATE {{table}} SET";
	foreach($resources as $res){
		$qry .= "`".$res."` = '".$CurrentPlanet[$res]."', ";
		$qry .= "`".$res."_perhour` = '".$Caps[$res.'_perhour']."', "; $CurrentPlanet[$res.'_perhour'] = $Caps[$res.'_perhour'];
		$qry .= "`".$res."_max` = '".$Caps[$res.'_max']."', "; $CurrentPlanet[$res.'_max'] = $Caps[$res.'_max'];
	}
	$qry .= "`energy_used` = '".$Caps['energy_used']."', "; $CurrentPlanet['energy_used'] = $Caps['energy_used'];
	$qry .= "`energy_max` = '".$Caps['energy_max']."', "; $CurrentPlanet['energy_max'] = $Caps['energy_max'];
	$qry .= "`last_update` = '".$time."', ";
	foreach($built as $element => $count){
		if ($element > 0) {
			$qry .= "`".$resource[$element]."` = `".$resource[$element]."` + '".$count."', ";
		}
	}
	$qry .= "`b_hangar` = '".$CurrentPlanet['b_hangar']."', ";
	$qry .= "`b_hangar_id` = '".$CurrentPlanet['b_hangar_id']."' ";
	$qry .= "WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";

	doquery("LOCK TABLE {{table}} WRITE", 'planets');
	doquery($qry, 'planets');
	doquery("UNLOCK TABLES", '');
	
}
function ProductionRates ($CurrentUser,$CurrentPlanet,$basic=false) {
	global $ProdGrid, $resource, $resources, $reslist, $game_config;

	$Caps = array();
	
	foreach($reslist['prod'] as $ProdID){
		$BuildTemp = $CurrentPlanet['temp_max'];
		$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
		$BuildLevel	   = $CurrentPlanet[ $resource[$ProdID] ];
		
		$Caps['metal_perhour']				 +=  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps['crystal_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps['deuterium_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps['appolonium_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['appolonium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		
		$Caps[$ProdID]['metal_perhour']		  =  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps[$ProdID]['crystal_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps[$ProdID]['deuterium_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		$Caps[$ProdID]['appolonium_perhour']  =  floor(eval($ProdGrid[$ProdID]['formule']['appolonium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );

		$Energy								  =  floor(eval($ProdGrid[$ProdID]['formule']['energy']   ) * ($game_config['resource_multiplier']));
		
		if($Energy < 0){
			$Caps['energy_used']			 += $Energy;
			$Caps[$ProdID]['energy_used']	  = $Energy;
		}elseif($Energy > 0){
			$Caps['energy_max']				 +=  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
			$Caps[$ProdID]['energy_max']	  =  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1))* ( 1 + ( $CurrentUser['prod_op']  * 0.02 ) ) );
		}
	}	
	
	/*
	echo "<pre>";
	print_r($Caps);
	echo "</pre>";
	*/
	
	if($basic){
		return $Caps;
	}else{
	
		//What effects resource production?
		//1 - Planet - No income on moons.
		//2 - Storage full - Mines shut down - Still base income though???
		//3 - Production factor - Production is at porduction factor % - Basine income unefected.
		//4 - Vacation mode - Base income only
		
		// 1 - There is no production on the moon
		if($CurrentPlanet['planet_type'] == 3){
			$game_config['metal_basic_income']		 = 0;
			$game_config['crystal_basic_income']	 = 0;
			$game_config['deuterium_basic_income']	 = 0;
			$game_config['appolonium_basic_income']  = $game_config['appolonium_basic_income'];
			$Caps['metal_perhour']		 = 0;
			$Caps['crystal_perhour']	 = 0;
			$Caps['deuterium_perhour']	 = 0;
			$Caps['appolonium_perhour']	 = $Caps['appolonium_perhour'];
			
		}
		if($CurrentPlanet['planet_type'] == 1){
		   $game_config['appolonium_basic_income']	 = 0;
		   $Caps['appolonium_perhour']	= 0 ;
		   }
		
		//2 Check storage
		$Caps['metal_max']	 = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor((pow(1.6,$CurrentPlanet[$resource[22]]))* (1 + ($CurrentUser['rpg_stockeur'] * 0.5))));
		$Caps['crystal_max']   = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor((pow(1.6,$CurrentPlanet[$resource[23]]))* (1 + ($CurrentUser['rpg_stockeur'] * 0.5))));
		$Caps['deuterium_max'] = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor((pow(1.6,$CurrentPlanet[$resource[24]]))* (1 + ($CurrentUser['rpg_stockeur'] * 0.5))));
		$Caps['appolonium_max'] = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor((pow(1.6,$CurrentPlanet[$resource[25]]))* (1 + ($CurrentUser['rpg_stockeur'] * 0.5))));
		foreach ($resources as $res){
			if($CurrentPlanet[$res] >= ($Caps[$res.'_max'] * MAX_OVERFLOW)){
				//$Caps[$res.'_perhour'] = 0;
				//$game_config[$res.'_basic_income'] = 0;
				$Caps[$res.'_perhour'] = $game_config[$res.'_basic_income'];
				foreach($reslist['prod'] as $ProdID){
					if($Caps[$ProdID][$res.'_perhour'] > 0){
						$Caps[$ProdID][$res.'_perhour'] = 0;
						$Caps['energy_used'] -= $Caps[$ProdID]['energy_used'];
						$Caps[$ProdID]['energy_used'] = 0;
					}
				}
			}
		}
		
		//3 - Production Factor.
		if((0-$Caps['energy_used']) > 0){
			$production_level = ($Caps['energy_max'] / (0-$Caps['energy_used']));
		}else{
			$production_level = 1;
		}
		if($production_level > 1){ $production_level = 1; }
		$Caps['production_factor'] = floor($production_level * 100);
		foreach ($resources as $res){
			$Caps[$res.'_perhour']		 = $Caps[$res.'_perhour'] * $production_level;
			foreach($reslist['prod'] as $ProdID){
				//echo $ProdID." = ".$Caps[$ProdID][$res.'_perhour']." * ".$production_level."<br />";
				$Caps[$ProdID][$res.'_perhour'] = $Caps[$ProdID][$res.'_perhour'] * $production_level;
			}
		}
		
		
		//4 - Vacation Mode - Base income only
		if($CurrentUser['urlaubs_modus'] == 1){
			foreach ($resources as $res){
				$Caps[$res.'_perhour'] = 0;
				foreach($reslist['prod'] as $ProdID){
					$Caps[$ProdID][$res.'_perhour'] = $Caps[$ProdID][$res.'_perhour'] * $production_level;
				}
			}
			$Caps['energy_used']		 = 0;
			$Caps['energy_max']			 = 0;
		}	
		
		
		//Now add base production
		$Caps['metal_perhour']		 += ($game_config['metal_basic_income'] *$game_config['resource_multiplier']);
		$Caps['crystal_perhour']	 += ($game_config['crystal_basic_income'] * $game_config['resource_multiplier']);
		$Caps['deuterium_perhour']	 += ($game_config['deuterium_basic_income'] * $game_config['resource_multiplier']);
		$Caps['appolonium_perhour']	 += ($game_config['appolonium_basic_income'] * $game_config['resource_multiplier']);
		$Caps['base'] = Array(
			'metal_perhour' => $game_config['metal_basic_income'],
			'crystal_perhour' => $game_config['crystal_basic_income'],
			'deuterium_perhour' => $game_config['deuterium_basic_income'],
			'appolonium_perhour' => $game_config['appolonium_basic_income']
		);
		
		/*
		echo "<pre>";
		print_r($Caps);
		echo "</pre>";
		*/
		
		return $Caps;
		
		
	}
}


// Revision History
// - 1.0 Mise en module initiale
// - 1.1 Mise a jour automatique mines / silos / energie ...
// - 2.0 Upaated for new ProductionRates file, better management of starage, 1 function to mange production, not 3 or 4 which are different.
?>