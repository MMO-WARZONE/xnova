<?php

/**
 * resources.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	includeLang('tech');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

function BuildRessourcePage ( $CurrentUser, $CurrentPlanet ) {
	global $pricelist, $lang, $ProdGrid, $resource, $reslist, $game_config, $_POST;

	includeLang('resources');

if (IsVacationMode($CurrentUser)){
   message($lang['Vacation_mode'], $lang['Error'], "overview.php", 1);
}
	$RessBodyTPL = gettemplate('resources');
	$RessRowTPL  = gettemplate('resources_row');

	// Si c'est une lune ... pas de ressources produites
	if ($CurrentPlanet['planet_type'] == 3) {
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
	}

	$ValidList['percent'] = array (  0,  10,  20,  30,  40,  50,  60,  70,  80,  90, 100 );
	$SubQry               = "";
	if ($_POST) {
		foreach($_POST as $Field => $Value) {
			$FieldName = $Field."_porcent";
			if ( isset( $CurrentPlanet[ $FieldName ] ) ) {
				if ( ! in_array( $Value, $ValidList['percent']) ) {
					header("Location: overview.php");
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
	if       ($CurrentPlanet['energy_max'] == 0 &&
		$CurrentPlanet['energy_used'] > 0) {
		$post_porcent = 0;
	} elseif ($CurrentPlanet['energy_max'] >  0 &&
		($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']) < 0 ) {
		$post_porcent = floor(($CurrentPlanet['energy_max']) / $CurrentPlanet['energy_used'] * 100);
	} else {
		$post_porcent = 100;
	}
	if ($post_porcent > 100) {
		$post_porcent = 100;
	}

	// -------------------------------------------------------------------------------------------------------
	// Mise a jour de l'espace de stockage
	$CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[22] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[23] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[24] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));

	// -------------------------------------------------------------------------------------------------------
	$parse['resource_row']               = "";
	$CurrentPlanet['metal_perhour']      = 0;
	$CurrentPlanet['crystal_perhour']    = 0;
	$CurrentPlanet['deuterium_perhour']  = 0;
	$CurrentPlanet['energy_max']         = 0;
	$CurrentPlanet['energy_used']        = 0;
	$BuildTemp                           = $CurrentPlanet[ 'temp_max' ];
	foreach($reslist['prod'] as $ProdID) {
		if ($CurrentPlanet[$resource[$ProdID]] > 0 && isset($ProdGrid[$ProdID])) {
			$BuildLevelFactor                    = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel                          = $CurrentPlanet[ $resource[$ProdID] ];
			$metal     = floor( eval ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$crystal   = floor( eval ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$deuterium = floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$energy    = floor( eval ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
			if ($energy > 0) {
				$CurrentPlanet['energy_max']    += $energy;
			} else {
				$CurrentPlanet['energy_used']   += $energy;
			}
			$CurrentPlanet['metal_perhour']     += $metal;
			$CurrentPlanet['crystal_perhour']   += $crystal;
			$CurrentPlanet['deuterium_perhour'] += $deuterium;

			$metal                               = $metal     * 0.01 * $post_porcent;
			$crystal                             = $crystal   * 0.01 * $post_porcent;
			$deuterium                           = $deuterium * 0.01 * $post_porcent;
			$energy                              = $energy    * 0.01 * $post_porcent;
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
			$CurrRow['type']                     = $lang['tech'][$ProdID];
			$CurrRow['level']                    = ($ProdID > 200) ? $lang['quantity'] : $lang['level'];
			$CurrRow['level_type']               = $CurrentPlanet[ $resource[$ProdID] ];
			$CurrRow['metal_type']               = pretty_number ( $metal     );
			$CurrRow['crystal_type']             = pretty_number ( $crystal   );
			$CurrRow['deuterium_type']           = pretty_number ( $deuterium );
			$CurrRow['energy_type']              = pretty_number ( $energy    );
			$CurrRow['metal_type']               = colorNumber ( $CurrRow['metal_type']     );
			$CurrRow['crystal_type']             = colorNumber ( $CurrRow['crystal_type']   );
			$CurrRow['deuterium_type']           = colorNumber ( $CurrRow['deuterium_type'] );
			$CurrRow['energy_type']              = colorNumber ( $CurrRow['energy_type']    );

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
		$parse['production_level'] = floor(($CurrentPlanet['energy_max']) / $CurrentPlanet['energy_used'] * 100);
	} elseif ($CurrentPlanet['energy_max'] == 0 &&
		abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = 0;
	} else {
		$parse['production_level'] = 100;
	}
	if ($parse['production_level'] > 100) {
		$parse['production_level'] = 100;
	}

	$parse['metal_basic_income']     = $game_config['metal_basic_income']     * $game_config['resource_multiplier'];
	$parse['crystal_basic_income']   = $game_config['crystal_basic_income']   * $game_config['resource_multiplier'];
	$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'] * $game_config['resource_multiplier'];
	$parse['energy_basic_income']    = $game_config['energy_basic_income']    * $game_config['resource_multiplier'];

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

	$parse['metal_total']           = colorNumber( pretty_number( floor( ( $CurrentPlanet['metal_perhour']     * 0.01 * $parse['production_level'] ) + $parse['metal_basic_income'])));
	$parse['crystal_total']         = colorNumber( pretty_number( floor( ( $CurrentPlanet['crystal_perhour']   * 0.01 * $parse['production_level'] ) + $parse['crystal_basic_income'])));
	$parse['deuterium_total']       = colorNumber( pretty_number( floor( ( $CurrentPlanet['deuterium_perhour'] * 0.01 * $parse['production_level'] ) + $parse['deuterium_basic_income'])));
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

	$parse['daily_metal']           = colorNumber(pretty_number($parse['daily_metal']));
	$parse['weekly_metal']          = colorNumber(pretty_number($parse['weekly_metal']));
	$parse['monthly_metal']         = colorNumber(pretty_number($parse['monthly_metal']));

	$parse['daily_crystal']         = colorNumber(pretty_number($parse['daily_crystal']));
	$parse['weekly_crystal']        = colorNumber(pretty_number($parse['weekly_crystal']));
	$parse['monthly_crystal']       = colorNumber(pretty_number($parse['monthly_crystal']));

	$parse['daily_deuterium']       = colorNumber(pretty_number($parse['daily_deuterium']));
	$parse['weekly_deuterium']      = colorNumber(pretty_number($parse['weekly_deuterium']));
	$parse['monthly_deuterium']     = colorNumber(pretty_number($parse['monthly_deuterium']));

	$parse['metal_storage']         = floor($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) . $lang['o/o'];
	$parse['crystal_storage']       = floor($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) . $lang['o/o'];
	$parse['deuterium_storage']     = floor($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) . $lang['o/o'];
	$parse['metal_storage_bar']     = floor(($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) * 2.5);
	$parse['crystal_storage_bar']   = floor(($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) * 2.5);
	$parse['deuterium_storage_bar'] = floor(($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) * 2.5);

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

	$parse['production_level_bar'] = $parse['production_level'] * 2.5;
	$parse['production_level']     = "{$parse['production_level']}%";
	$parse['production_level_barcolor'] = '#00ff00';

	$QryUpdatePlanet  = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."' ";
	$QryUpdatePlanet .= $SubQry;
	$QryUpdatePlanet .= "WHERE ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
	doquery( $QryUpdatePlanet, 'planets');

	///////////////Naves////////////////
	$c = 202; //Contador inicio naves
	$m = 215; //final
	while($c <= $m) {
	//naves
	$pemd = $pricelist[$c]['metal']; //precio de la nave
	$pecd = $pricelist[$c]['crystal']; //precio de la nave 
	$pedd = $pricelist[$c]['deuterium']; //precio de la nave 

	//recursos
	$recursosmetaldia  = floor($CurrentPlanet['metal_perhour']     * 24      * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24      );
	$recursosmetalsemana = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 7  );
	$recursosmetalmes = floor($CurrentPlanet['metal_perhour']     * 24 * 30 * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 30 );
	$recursoscristaldia = floor($CurrentPlanet['crystal_perhour']   * 24      * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24      );
	$recursoscristalsemana = floor($CurrentPlanet['crystal_perhour']   * 24 * 7  * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 7  );
	$recursoscristalmes = floor($CurrentPlanet['crystal_perhour']   * 24 * 30 * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 30 );
	$recursosdeudia = floor($CurrentPlanet['deuterium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24      );
	$recursosdeusemana  = floor($CurrentPlanet['deuterium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 7  );
	$recursosdeumes  = floor($CurrentPlanet['deuterium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 30 );
	//Calculamos
		//por dia
	$xmdia = @floor($recursosmetaldia/$pemd); //por dia
	$xcdia = @floor($recursoscristaldia/$pecd); //por dia
	$xddia = @floor($recursosdeudia/$pedd); //por dia


     //por mes
	$xmmes = @floor($recursosmetalmes/$pemd); //por mes
	$xcmes = @floor($recursoscristalmes/$pecd); //por mes
	$xdmes = @floor($recursosdeumes/$pedd); //por mes

	if($xmdia > 0) { $ahimetal = "1"; $xdia = $xcdia; } else { $ahimetal = "0"; }
	if($xcdia > 0) { $ahicristal = "1"; $xdia = $xcdia; } else { $ahicristal = "0"; } 
	if($xddia > 0) { $ahideuterio = "1"; $xdia = $xddia; } else { $ahideuterio = "0"; }
	
	//casos de por dia
	//Caso 1
	if($ahimetal == 1 AND $ahicristal == 1 AND $ahideuterio == 0) { //Si existe cristal y metal
	if($xmdia <= $xcdia) {  //si metal es menor o igual que el cristal
		$xdia = $xmdia; //ponemos los que son ya
	} else { //si el cristal es menor que el metal
		$xdia = $xcdia;  //ponemos los que son
	} //Fin
	} //Fin caso 1
	
		//Caso 2
	if($ahimetal == 1 AND $ahicristal == 1 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xmdia <= $xcdia) {  //si metal es menor o igual que el cristal
		$xdia = $xmdia; //ponemos los que son ya
	if($xmdia <= $xddia ) {  //Si es menor o igual que el deuterio
		$xdia = $xmdia; //ponemos de nuevo los que son 
	} else { //si el deuterio es mayor
	if($xddia > 0) { //y deuterio es mayor que 0 (en recursos para producirlo)
	$xdia = $xddia; //ponemos los que son 
	} //Fin 
	} //Fin final
	} else { //si el cristal es menor que el metal
		$xdia = $xcdia;  //ponemos los que son
	if($xcdia <= $xddia) {  //si es menor o igual que el deuterio
	$xdia = $xcdia;  // ponemos ls que son
	} else { //si no
	if($xddia > 0) { //y el deuterio es mayor
		$xdia = $xddia; //ponemos los que son
		} //Fin 
	} //Fin
	} //Fin
	} //Fin caso 2
	
	//Caso 3
	if($ahimetal == 1 AND $ahicristal == 0 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xmdia <= $xddia) {  //si metal es menor o igual que el deuterio
		$xdia = $xmdia; //ponemos los que son ya
	} else { //si el deuterio es menor que el metal
		$xdia = $xddia;  //ponemos los que son
	} //Fin
	} //Fin caso 3
	
		//Caso 4
	if($ahimetal == 0 AND $ahicristal == 1 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xcdia <= $xddia) {  //si cristal es menor o igual que el deuterio
		$xdia = $xcdia; //ponemos los que son ya
	} else { //si el deuterio es menor que el metal
		$xdia = $xddia;  //ponemos los que son
	} //Fin
	} //Fin caso 4

	//caso 5
	if($ahimetal == 1 AND $ahicristal == 0 AND $ahideuterio == 0) { $xdia = $xmdia; }
	//caso 6
	if($ahimetal == 0 AND $ahicristal == 1 AND $ahideuterio == 0) { $xdia = $xcdia; }
	//caso 7
	if($ahimetal == 0 AND $ahicristal == 0 AND $ahideuterio == 1) { $xdia = $xddia; }
	//Fin de por dia
		
		
			
	 $xsemana = floor($xdia*7);
	 $xmes = floor($xdia*30);

	$parse['predu_fleet'] .= "<tr>";
	$parse['predu_fleet'] .= "<th>".$lang['tech'][$c]."</th>";
	$parse['predu_fleet'] .= "<th>".$xdia."</th>";
	$parse['predu_fleet'] .= "<th>".$xsemana."</th>";
	$parse['predu_fleet'] .= "<th>".$xmes."</th>";
	$parse['predu_fleet'] .= "</tr>";
	$c++;
	}
	////////////////Defensas////////////////
	$c = 401; //Contador inicio naves
	$m = 503; //final
	while($c <= $m) {
	//naves
	$pemd = $pricelist[$c]['metal']; //precio de la nave
	$pecd = $pricelist[$c]['crystal']; //precio de la nave 
	$pedd = $pricelist[$c]['deuterium']; //precio de la nave 

	//recursos
	$recursosmetaldia  = floor($CurrentPlanet['metal_perhour']     * 24      * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24      );
	$recursosmetalsemana = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 7  );
	$recursosmetalmes = floor($CurrentPlanet['metal_perhour']     * 24 * 30 * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 30 );
	$recursoscristaldia = floor($CurrentPlanet['crystal_perhour']   * 24      * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24      );
	$recursoscristalsemana = floor($CurrentPlanet['crystal_perhour']   * 24 * 7  * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 7  );
	$recursoscristalmes = floor($CurrentPlanet['crystal_perhour']   * 24 * 30 * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 30 );
	$recursosdeudia = floor($CurrentPlanet['deuterium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24      );
	$recursosdeusemana  = floor($CurrentPlanet['deuterium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 7  );
	$recursosdeumes  = floor($CurrentPlanet['deuterium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 30 );
	//Calculamos
		//por dia
	$xmdia = @floor($recursosmetaldia/$pemd); //por dia
	$xcdia = @floor($recursoscristaldia/$pecd); //por dia
	$xddia = @floor($recursosdeudia/$pedd); //por dia


     //por mes
	$xmmes = @floor($recursosmetalmes/$pemd); //por mes
	$xcmes = @floor($recursoscristalmes/$pecd); //por mes
	$xdmes = @floor($recursosdeumes/$pedd); //por mes

	if($xmdia > 0) { $ahimetal = "1"; $xdia = $xcdia; } else { $ahimetal = "0"; }
	if($xcdia > 0) { $ahicristal = "1"; $xdia = $xcdia; } else { $ahicristal = "0"; } 
	if($xddia > 0) { $ahideuterio = "1"; $xdia = $xddia; } else { $ahideuterio = "0"; }
	
	//casos de por dia
	//Caso 1
	if($ahimetal == 1 AND $ahicristal == 1 AND $ahideuterio == 0) { //Si existe cristal y metal
	if($xmdia <= $xcdia) {  //si metal es menor o igual que el cristal
		$xdia = $xmdia; //ponemos los que son ya
	} else { //si el cristal es menor que el metal
		$xdia = $xcdia;  //ponemos los que son
	} //Fin
	} //Fin caso 1
	
		//Caso 2
	if($ahimetal == 1 AND $ahicristal == 1 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xmdia <= $xcdia) {  //si metal es menor o igual que el cristal
		$xdia = $xmdia; //ponemos los que son ya
	if($xmdia <= $xddia ) {  //Si es menor o igual que el deuterio
		$xdia = $xmdia; //ponemos de nuevo los que son 
	} else { //si el deuterio es mayor
	if($xddia > 0) { //y deuterio es mayor que 0 (en recursos para producirlo)
	$xdia = $xddia; //ponemos los que son 
	} //Fin 
	} //Fin final
	} else { //si el cristal es menor que el metal
		$xdia = $xcdia;  //ponemos los que son
	if($xcdia <= $xddia) {  //si es menor o igual que el deuterio
	$xdia = $xcdia;  // ponemos ls que son
	} else { //si no
	if($xddia > 0) { //y el deuterio es mayor
		$xdia = $xddia; //ponemos los que son
		} //Fin 
	} //Fin
	} //Fin
	} //Fin caso 2
	
	//Caso 3
	if($ahimetal == 1 AND $ahicristal == 0 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xmdia <= $xddia) {  //si metal es menor o igual que el deuterio
		$xdia = $xmdia; //ponemos los que son ya
	} else { //si el deuterio es menor que el metal
		$xdia = $xddia;  //ponemos los que son
	} //Fin
	} //Fin caso 3
	
		//Caso 4
	if($ahimetal == 0 AND $ahicristal == 1 AND $ahideuterio == 1) { //Si existe cristal y metal
	if($xcdia <= $xddia) {  //si cristal es menor o igual que el deuterio
		$xdia = $xcdia; //ponemos los que son ya
	} else { //si el deuterio es menor que el metal
		$xdia = $xddia;  //ponemos los que son
	} //Fin
	} //Fin caso 4

	//caso 5
	if($ahimetal == 1 AND $ahicristal == 0 AND $ahideuterio == 0) { $xdia = $xmdia; }
	//caso 6
	if($ahimetal == 0 AND $ahicristal == 1 AND $ahideuterio == 0) { $xdia = $xcdia; }
	//caso 7
	if($ahimetal == 0 AND $ahicristal == 0 AND $ahideuterio == 1) { $xdia = $xddia; }
	//Fin de por dia
		
		
			
	 $xsemana = floor($xdia*7);
	 $xmes = floor($xdia*30);

	$parse['predu_def'] .= "<tr>";
	$parse['predu_def'] .= "<th>".$lang['tech'][$c]."</th>";
	$parse['predu_def'] .= "<th>".$xdia."</th>";
	$parse['predu_def'] .= "<th>".$xsemana."</th>";
	$parse['predu_def'] .= "<th>".$xmes."</th>";
	$parse['predu_def'] .= "</tr>";
	if($c == 408) { $c = 502; } else { $c++; }
	}
	
	
	$page = parsetemplate( $RessBodyTPL, $parse );
	
	return $page;
}



	$Page = BuildRessourcePage ( $user, $planetrow );
	display( $Page, $lang['Resources'] );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour utilisation XNova
?>
