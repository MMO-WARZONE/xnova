<?php

/**
 * resources.php

 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	includeLang('tech');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

function BuildRessourcePage ( $CurrentUser, $CurrentPlanet, $hide = '' ) {
	global $lang, $ProdGrid, $resource, $reslist, $game_config, $_POST;

	includeLang('resources');
	if ($user['urlaubs_modus'] == 1){
		message($lang['Vacation_mode'], $lang['Error'], "overview.php", 1);
	}

	$Caps = ProductionRate($CurrentUser,$CurrentPlanet);
	//print_r($Caps);

	$RessBodyTPL = gettemplate('resources');
	$RessRowTPL  = gettemplate('resources_row');

	// Si c'est une lune ... pas de ressources produites
	if ($CurrentPlanet['planet_type'] == 3) {
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
		$game_config['appolonium_basic_income'] =  $game_config['appolonium_basic_income'];
	}
    if ($CurrentPlanet['planet_type'] == 1) {
	    $game_config['appolonium_basic_income'] = 0;
		}
	
	
	
	$ValidList['percent'] = array (  0,  10,  20,  30,  40,  50,  60,  70,  80,  90, 100 );
	$SubQry               = "";
	if ($_POST) {
		foreach($_POST as $Field => $Value) {
			$FieldName = $Field."_porcent";
			if ( isset( $CurrentPlanet[ $FieldName ] ) ) {
				if ( ! in_array( $Value, $ValidList['percent']) ) {
					header("Location: ./?s=".UNI."&page=resources&mode=resources");
					exit;
				}

				$Value                        = $Value / 10;
				$CurrentPlanet[ $FieldName ]  = $Value;
				$SubQry                      .= ", `".$FieldName."` = '".$Value."'";
			}
		}
	}

	$parse  = $lang;

	$parse['production_level'] = 100;
	$post_porcent = $Caps['production_factor'];

	// -------------------------------------------------------------------------------------------------------
	// Mise a jour de l'espace de stockage
	$CurrentPlanet['metal_max']     = $Caps['metal_max'];
	$CurrentPlanet['crystal_max']   = $Caps['crystal_max'];
	$CurrentPlanet['deuterium_max'] = $Caps['deuterium_max'];
    $CurrentPlanet['appolonium_max'] = $Caps['appolonium_max'];
	// -------------------------------------------------------------------------------------------------------
	$parse['resource_row']                = "";
	$CurrentPlanet['metal_perhour']       = $Caps['metal_perhour'];
	$CurrentPlanet['crystal_perhour']     = $Caps['crystal_perhour'];
	$CurrentPlanet['deuterium_perhour']   = $Caps['deuterium_perhour'];
	$CurrentPlanet['appolonium_perhour']  = $Caps['appolonium_perhour'];
	$CurrentPlanet['energy_max']          = $Caps['energy_max'];
	$CurrentPlanet['energy_used']         = $Caps['energy_used'];
	$countforalt = 0;
	foreach($reslist['prod'] as $ProdID) {
		$ignore = array(22,23,24,25);
		if(!in_array($ProdID,$ignore)){

			$countforalt++;

			$metal       = $Caps[$ProdID]['metal_perhour'];
			$crystal     = $Caps[$ProdID]['crystal_perhour'];
			$deuterium   = $Caps[$ProdID]['deuterium_perhour'];
			$appolonium  = $Caps[$ProdID]['appolonium_perhour'];
			$energy    = $Caps[$ProdID]['energy_max'] + $Caps[$ProdID]['energy_used'];

			$Field                               = $resource[$ProdID] ."_porcent";
			$CurrRow                             = array();
			$CurrRow['name']                     = $resource[$ProdID];
			$CurrRow['porcent']                  = $CurrentPlanet[$Field];
			for ($Option = 10; $Option >= 0; $Option--) {
				$OptValue = $Option * 10;
				if ($Option == $CurrRow['porcent']) {
					$OptSelected    = " selected=selected";
				} else {
					$OptSelected    = "";
				}
				$CurrRow['option'] .= "<option value=\"".$OptValue."\"".$OptSelected.">".$OptValue."%</option>";
			}
			$CurrRow['type']                      = $lang['tech'][$ProdID];
			$CurrRow['level']                     = ($ProdID > 200) ? $lang['quantity'] : $lang['level'];
			$CurrRow['level_type']                = $CurrentPlanet[ $resource[$ProdID] ];
			$CurrRow['metal_type']                = pretty_number ( $metal     );
			$CurrRow['crystal_type']              = pretty_number ( $crystal   );
			$CurrRow['deuterium_type']            = pretty_number ( $deuterium );
			$CurrRow['appolonium_type']           = pretty_number ( $appolonium );
			$CurrRow['energy_type']               = pretty_number ( $energy    );
			$CurrRow['metal_type']                = colorNumber ( $CurrRow['metal_type']     );
			$CurrRow['crystal_type']              = colorNumber ( $CurrRow['crystal_type']   );
			$CurrRow['deuterium_type']            = colorNumber ( $CurrRow['deuterium_type'] );
			$CurrRow['appolonium_type']           = colorNumber ( $CurrRow['appolonium_type'] );
			$CurrRow['energy_type']               = colorNumber ( $CurrRow['energy_type']    );

			$CurrRow['alt'] = "";
			if($countforalt % 2 == 0){
				$CurrRow['alt'] = "alt";
			}

			$parse['resource_row']              .= parsetemplate ( $RessRowTPL, $CurrRow );
		}
	}

	$parse['Production_of_resources_in_the_planet'] =
	str_replace('%s', $CurrentPlanet['name'], $lang['Production_of_resources_in_the_planet']);
	if       ($CurrentPlanet['energy_max'] == 0 &&
	$CurrentPlanet['energy_used'] > 0) {
		$parse['production_level'] = 0;
	} elseif ($CurrentPlanet['energy_max']  > 0 &&
	abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = floor(($CurrentPlanet['energy_max']) / (0-$CurrentPlanet['energy_used']) * 100);
	} elseif ($CurrentPlanet['energy_max'] == 0 &&
	abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = 0;
	} else {
		$parse['production_level'] = 100;
	}
	if ($parse['production_level'] > 100) {
		$parse['production_level'] = 100;
	}

	$parse['metal_basic_income']      = $game_config['metal_basic_income']      * $game_config['resource_multiplier'];
	$parse['crystal_basic_income']    = $game_config['crystal_basic_income']    * $game_config['resource_multiplier'];
	$parse['deuterium_basic_income']  = $game_config['deuterium_basic_income']  * $game_config['resource_multiplier'];
	$parse['appolonium_basic_income'] = $game_config['appolonium_basic_income'] * $game_config['resource_multiplier'];
	$parse['energy_basic_income']     = $game_config['energy_basic_income']     * $game_config['resource_multiplier'];

	if ($CurrentPlanet['metal_max'] < $CurrentPlanet['metal']) {
		$parse['metal_max']         = "<font color=\"#ff0000\">";
	} else {
		$parse['metal_max']         = "<font color=\"#00ff00\">";
	}
	$parse['metal_max']            .= pretty_number($CurrentPlanet['metal_max'] / 1000) ." ". $lang['k']."</font>";

	if ($CurrentPlanet['crystal_max'] < $CurrentPlanet['crystal']) {
		$parse['crystal_max']       = "<font color=\"#ff0000\">";
	} else {
		$parse['crystal_max']       = "<font color=\"#00ff00\">";
	}
	$parse['crystal_max']          .= pretty_number($CurrentPlanet['crystal_max'] / 1000) ." ". $lang['k']."</font>";

	if ($CurrentPlanet['deuterium_max'] < $CurrentPlanet['deuterium']) {
		$parse['deuterium_max']     = "<font color=\"#ff0000\">";
	} else {
		$parse['deuterium_max']     = "<font color=\"#00ff00\">";
	}
	$parse['deuterium_max']        .= pretty_number($CurrentPlanet['deuterium_max'] / 1000) ." ". $lang['k']."</font>";
	
	if ($CurrentPlanet['appolonium_max'] < $CurrentPlanet['appolonium']) {
		$parse['appolonium_max']     = "<font color=\"#ff0000\">";
	} else {
		$parse['appolonium_max']     = "<font color=\"#00ff00\">";
	}
	$parse['appolonium_max']        .= pretty_number($CurrentPlanet['appolonium_max'] / 1000) ." ". $lang['k']."</font>";

	$parse['metal_total']           = colorNumber( pretty_number( floor( ( $CurrentPlanet['metal_perhour']     * 0.01 * $parse['production_level'] ) + $parse['metal_basic_income'])));
	$parse['crystal_total']         = colorNumber( pretty_number( floor( ( $CurrentPlanet['crystal_perhour']   * 0.01 * $parse['production_level'] ) + $parse['crystal_basic_income'])));
	$parse['deuterium_total']       = colorNumber( pretty_number( floor( ( $CurrentPlanet['deuterium_perhour'] * 0.01 * $parse['production_level'] ) + $parse['deuterium_basic_income'])));
	$parse['appolonium_total']      = colorNumber( pretty_number( floor( ( $CurrentPlanet['appolonium_perhour'] * 0.01 * $parse['production_level'] ) + $parse['appolonium_basic_income'])));
	$parse['energy_total']          = colorNumber( pretty_number( floor( ( $CurrentPlanet['energy_max'] + $parse['energy_basic_income']    ) + $CurrentPlanet['energy_used'] ) ) );

	$parse['daily_metal']           = floor($CurrentPlanet['metal_perhour']     * 24      * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24      );
	$parse['weekly_metal']          = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 7  );
	$parse['monthly_metal']         = floor($CurrentPlanet['metal_perhour']     * 24 * 30 * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 30 );

	$parse['daily_crystal']         = floor($CurrentPlanet['crystal_perhour']   * 24      * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24      );
	$parse['weekly_crystal']        = floor($CurrentPlanet['crystal_perhour']   * 24 * 7  * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 7  );
	$parse['monthly_crystal']       = floor($CurrentPlanet['crystal_perhour']   * 24 * 30 * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 30 );

	$parse['daily_deuterium']       = floor($CurrentPlanet['deuterium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24      );
	$parse['weekly_deuterium']      = floor($CurrentPlanet['deuterium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 7  );
	$parse['monthly_deuterium']     = floor($CurrentPlanet['deuterium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 30 );
	
	$parse['daily_appolonium']       = floor($CurrentPlanet['appolonium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['appolonium_basic_income'] * 24      );
	$parse['weekly_appolonium']      = floor($CurrentPlanet['appolonium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['appolonium_basic_income'] * 24 * 7  );
	$parse['monthly_appolonium']     = floor($CurrentPlanet['appolonium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['appolonium_basic_income'] * 24 * 30 );

	$parse['daily_metal']           = colorNumber(pretty_number($parse['daily_metal']));
	$parse['weekly_metal']          = colorNumber(pretty_number($parse['weekly_metal']));
	$parse['monthly_metal']         = colorNumber(pretty_number($parse['monthly_metal']));

	$parse['daily_crystal']         = colorNumber(pretty_number($parse['daily_crystal']));
	$parse['weekly_crystal']        = colorNumber(pretty_number($parse['weekly_crystal']));
	$parse['monthly_crystal']       = colorNumber(pretty_number($parse['monthly_crystal']));

	$parse['daily_deuterium']       = colorNumber(pretty_number($parse['daily_deuterium']));
	$parse['weekly_deuterium']      = colorNumber(pretty_number($parse['weekly_deuterium']));
	$parse['monthly_deuterium']     = colorNumber(pretty_number($parse['monthly_deuterium']));
	
	$parse['daily_appolonium']       = colorNumber(pretty_number($parse['daily_appolonium']));
	$parse['weekly_appolonium']      = colorNumber(pretty_number($parse['weekly_appolonium']));
	$parse['monthly_appolonium']     = colorNumber(pretty_number($parse['monthly_appolonium']));

	$parse['metal_storage']          = floor($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']        * 100) . $lang['o/o'];
	$parse['crystal_storage']        = floor($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']      * 100) . $lang['o/o'];
	$parse['deuterium_storage']      = floor($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max']    * 100) . $lang['o/o'];
	$parse['appolonium_storage']     = floor($CurrentPlanet['appolonium'] / $CurrentPlanet['appolonium_max']  * 100) . $lang['o/o'];
	$parse['metal_storage_bar']      = floor(($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']       * 100) * 2.5);
	$parse['crystal_storage_bar']    = floor(($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']     * 100) * 2.5);
	$parse['deuterium_storage_bar']  = floor(($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max']   * 100) * 2.5);
	$parse['appolonium_storage_bar'] = floor(($CurrentPlanet['appolonium'] / $CurrentPlanet['appolonium_max'] * 100) * 2.5);

	if ($parse['metal_storage_bar'] > (100 * 2.5)) {
		$parse['metal_storage_bar'] = 250;
		$parse['metal_storage_barcolor'] = '#C00000';
	} elseif ($parse['metal_storage_bar'] > (80 * 2.5)) {
		$parse['metal_storage_barcolor'] = '#C0C000';
	} else {
		$parse['metal_storage_barcolor'] = '#00C000';
	}

	if ($parse['crystal_storage_bar'] > (100 * 2.5)) {
		$parse['crystal_storage_bar'] = 250;
		$parse['crystal_storage_barcolor'] = '#C00000';
	} elseif ($parse['crystal_storage_bar'] > (80 * 2.5)) {
		$parse['crystal_storage_barcolor'] = '#C0C000';
	} else {
		$parse['crystal_storage_barcolor'] = '#00C000';
	}

	if ($parse['deuterium_storage_bar'] > (100 * 2.5)) {
		$parse['deuterium_storage_bar'] = 250;
		$parse['deuterium_storage_barcolor'] = '#C00000';
	} elseif ($parse['deuterium_storage_bar'] > (80 * 2.5)) {
		$parse['deuterium_storage_barcolor'] = '#C0C000';
	} else {
		$parse['deuterium_storage_barcolor'] = '#00C000';
	}
	
	if ($parse['appolonium_storage_bar'] > (100 * 2.5)) {
		$parse['appolonium_storage_bar'] = 250;
		$parse['appolonium_storage_barcolor'] = '#C00000';
	} elseif ($parse['appolonium_storage_bar'] > (80 * 2.5)) {
		$parse['appolonium_storage_barcolor'] = '#C0C000';
	} else {
		$parse['appolonium_storage_barcolor'] = '#00C000';
	}
	$parse['production_level_bar'] = $parse['production_level'] * 2.5;
	$parse['production_level']     = "{$parse['production_level']}%";
	$parse['production_level_barcolor'] = '#00ff00';

	$QryUpdatePlanet  = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."' ";
	$QryUpdatePlanet .= $SubQry;
	$QryUpdatePlanet .= "WHERE ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
	doquery( $QryUpdatePlanet, 'planets');

	//To show or not to show?
	$parse['hideres'] = $hide;

	$page = parsetemplate( $RessBodyTPL, $parse );

	return $page;
}
   $Page = BuildRessourcePage ( $user, $planetrow );
   display( $Page, $lang['Resources'] );
   
 function ProductionRate ($CurrentUser,$CurrentPlanet,$basic=false) {
	global $ProdGrid, $resource, $resources, $reslist, $game_config;

	$Caps = array();
	
	foreach($reslist['prod'] as $ProdID){
		$BuildTemp = $CurrentPlanet['temp_max'];
		$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
		$BuildLevel	   = $CurrentPlanet[ $resource[$ProdID] ];
		
		$Caps['metal_perhour']				 +=  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps['crystal_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps['deuterium_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps['appolonium_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['appolonium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));


		$Caps[$ProdID]['metal_perhour']		  =  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps[$ProdID]['crystal_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps[$ProdID]['deuterium_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		$Caps[$ProdID]['appolonium_perhour']  =  floor(eval($ProdGrid[$ProdID]['formule']['appolonium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[601]]  * 0.1)));
		
		$Energy								  =  floor(eval($ProdGrid[$ProdID]['formule']['energy']   ) * ($game_config['resource_multiplier']));
		
		if($Energy < 0){
			$Caps['energy_used']			 += $Energy;
			$Caps[$ProdID]['energy_used']	  = $Energy;
		}elseif($Energy > 0){
			$Caps['energy_max']				 +=  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1)));
			$Caps[$ProdID]['energy_max']	  =  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1)));
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
		
/*		
		//Now add base production
		$Caps['metal_perhour']		 += ($game_config['metal_basic_income'] *$game_config['resource_multiplier']);
		$Caps['crystal_perhour']	 += ($game_config['crystal_basic_income'] * $game_config['resource_multiplier']);
		$Caps['deuterium_perhour']	 += ($game_config['deuterium_basic_income'] * $game_config['resource_multiplier']);	
		$Caps['base'] = Array(
			'metal_perhour' => $game_config['metal_basic_income'],
			'crystal_perhour' => $game_config['crystal_basic_income'],
			'deuterium_perhour' => $game_config['deuterium_basic_income']
		);
*/		
		/*
		echo "<pre>";
		print_r($Caps);
		echo "</pre>";
		*/
		
		return $Caps;
		
		
	}
}
?>