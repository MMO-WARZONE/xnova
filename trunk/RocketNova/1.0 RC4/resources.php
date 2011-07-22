<?php

/**
 * resources.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	includeLang('tech');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

function BuildRessourcePage ( $CurrentUser, $CurrentPlanet ) {
	global $pricelist, $lang, $ProdGrid, $resource, $reslist, $game_config, $_POST;

	includeLang('resources');

if ($user['urlaubs_modus'] == 1){
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
	if	($CurrentPlanet['energy_max'] == 0 && abs($CurrentPlanet['energy_used']) <= 0) {
		$post_porcent = 0;
	} elseif	($CurrentPlanet['energy_max'] == 0) {
		$post_porcent = 0;
	} elseif ($CurrentPlanet['energy_max'] >  0 && ($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']) < 0 ) {
		$post_porcent = ($CurrentPlanet['energy_max'] / abs($CurrentPlanet['energy_used']) * 100);
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
			$metal     = ( eval ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$crystal   = ( eval ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$deuterium = ( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$energy    = ( eval ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );

			if ($energy > 0) {
				$CurrentPlanet['energy_max']    += $energy;
			} else {
				$CurrentPlanet['energy_used']   += $energy;
			}
			$CurrentPlanet['metal_perhour']     += $metal;
			$CurrentPlanet['crystal_perhour']   += $crystal;
			$CurrentPlanet['deuterium_perhour'] += $deuterium;

			$metal                               = ($metal     * 0.01 * $post_porcent);
			$crystal                             = ($crystal   * 0.01 * $post_porcent);
			$deuterium                           = ($deuterium * 0.01 * $post_porcent);
			$energy                              = $energy;    //* 0.01 * $post_porcent;
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
			$CurrRow['metal_type']               = colorNumber(pretty_number ( $metal     ));
			$CurrRow['crystal_type']             = colorNumber(pretty_number ( $crystal   ));
			$CurrRow['deuterium_type']           = colorNumber(pretty_number ( $deuterium ));
			if ($energy < 0) { $CurrRow['energy_type']              = colorNumber(pretty_number(ceil($energy)));
			} else { $CurrRow['energy_type']              = colorNumber(pretty_number(floor($energy))); }
			
		/*	$CurrRow['metal_type']               = colorNumber ( $CurrRow['metal_type']     );
			$CurrRow['crystal_type']             = colorNumber ( $CurrRow['crystal_type']   );
			$CurrRow['deuterium_type']           = colorNumber ( $CurrRow['deuterium_type'] );
			$CurrRow['energy_type']              = colorNumber ( $CurrRow['energy_type']    );
		*/
			$parse['resource_row']              .= parsetemplate ( $RessRowTPL, $CurrRow );
		}
	}

	$parse['Production_of_resources_in_the_planet'] =
	str_replace('%s', $CurrentPlanet['name'], $lang['Production_of_resources_in_the_planet']);
	if  ($CurrentPlanet['energy_max'] == 0 && abs($CurrentPlanet['energy_used']) >= 0) {
		$parse['production_level'] = 0;
	} elseif ($CurrentPlanet['energy_max']  > 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = (($CurrentPlanet['energy_max']) / abs($CurrentPlanet['energy_used']) * 100);
	} elseif ($CurrentPlanet['energy_max'] == 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
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
	if ($parse['energy_total'] < 0) { 
	$parse['energy_total']          = colorNumber(pretty_number(( $CurrentPlanet['energy_max'] + $parse['energy_basic_income']) - abs($CurrentPlanet['energy_used'])));
  } else {
  $parse['energy_total']          = colorNumber(pretty_number(floor(( $CurrentPlanet['energy_max'] + $parse['energy_basic_income']) - abs($CurrentPlanet['energy_used']))));
  }
	$value['daily_metal']           = floor($CurrentPlanet['metal_perhour']     * 24      * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24      );
	$value['weekly_metal']          = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 7  );
	$value['monthly_metal']         = floor($CurrentPlanet['metal_perhour']     * 24 * 30 * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 30 );

	$value['daily_crystal']         = floor($CurrentPlanet['crystal_perhour']   * 24      * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24      );
	$value['weekly_crystal']        = floor($CurrentPlanet['crystal_perhour']   * 24 * 7  * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 7  );
	$value['monthly_crystal']       = floor($CurrentPlanet['crystal_perhour']   * 24 * 30 * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 30 );

	$value['daily_deuterium']       = floor($CurrentPlanet['deuterium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24      );
	$value['weekly_deuterium']      = floor($CurrentPlanet['deuterium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 7  );
	$value['monthly_deuterium']     = floor($CurrentPlanet['deuterium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 30 );

	$parse['daily_metal']           = colorNumber(pretty_number($value['daily_metal']));
	$parse['weekly_metal']          = colorNumber(pretty_number($value['weekly_metal']));
	$parse['monthly_metal']         = colorNumber(pretty_number($value['monthly_metal']));

	$parse['daily_crystal']         = colorNumber(pretty_number($value['daily_crystal']));
	$parse['weekly_crystal']        = colorNumber(pretty_number($value['weekly_crystal']));
	$parse['monthly_crystal']       = colorNumber(pretty_number($value['monthly_crystal']));

	$parse['daily_deuterium']       = colorNumber(pretty_number($value['daily_deuterium']));
	$parse['weekly_deuterium']      = colorNumber(pretty_number($value['weekly_deuterium']));
	$parse['monthly_deuterium']     = colorNumber(pretty_number($value['monthly_deuterium']));

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
	// Oh mein gott alles neu machen das ja totaler schwachsin und das auch noch im schleife Oo
	// Ship and deffend produktion calculate script
	// new writen and fixed by Mori for Xnova 
	// (c)2009 by Mori all rights reserved
		
	////////////////Fleets////////////////	
	$c = 202; //value from first ship out table
	$m = 218; //end and last ship
	while($c <= $m) {
		
	$Spm = $pricelist[$c]['metal']; 	// Met. price from ship $c
	$Spc = $pricelist[$c]['crystal']; 	// crys. price from ship $c
	$Spd = $pricelist[$c]['deuterium']; // Deut. price from ship $c

	$Xdprom	=	@floor($value['daily_metal']/$Spm);
	$Xdproc	=	@floor($value['daily_crystal']/$Spc);
	$Xdprod	=	@floor($value['daily_deuterium']/$Spd);
	$Xwprom	=	@floor($value['weekly_metal']/$Spm);
	$Xwproc	=	@floor($value['weekly_crystal']/$Spc);
	$Xwprod	=	@floor($value['weekly_deuterium']/$Spd);
	$Xmprom	=	@floor($value['monthly_metal']/$Spm);
	$Xmproc	=	@floor($value['monthly_crystal']/$Spc);
	$Xmprod	=	@floor($value['monthly_deuterium']/$Spd);
	
	if ($Spm > 0 and $Spc == 0 and $Spd == 0) {
		$xsd	=	$Xdprom;
		$xsw	=	$Xwprom;
		$xsm	=	$Xmprom;
	} elseif ($Spm == 0 and $Spc > 0 and $Spd == 0) {
		$xsd	=	$Xdproc;
		$xsw	=	$Xwproc;
		$xsm	=	$Xmproc;
	} elseif ($Spm > 0 and $Spc > 0 and $Spd == 0) {
		$xmind	=	min($Xdprom,$Xdproc);
		$xminw	=	min($Xwprom,$Xwproc);
		$xminm	=	min($Xmprom,$Xmproc);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} elseif ($Spm > 0 and $Spc > 0 and $Spd > 0) {
		$xmind	=	min($Xdprom,$Xdproc,$Xdprod);
		$xminw	=	min($Xwprom,$Xwproc,$Xwprod);
		$xminm	=	min($Xmprom,$Xmproc,$Xmprod);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} elseif ($Spm == 0 and $Spc > 0 and $Spd > 0) {
		$xmind	=	min($Xdproc,$Xdprod);
		$xminw	=	min($Xwproc,$Xwprod);
		$xminm	=	min($Xmproc,$Xmprod);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} else {
		$xsd	= ('<font color=red>0</font>');
		$xsw	= ('<font color=red>0</font>');
		$xsm	= ('<font color=red>0</font>'); 
	}
	if ($xsd > 0 and $xsw > 0 and $xsm > 0) {} else {$xsd=0;$xsw=0;$xsm=0;} //verhindert minus produktion anzeige
	
	$parse['predu_fleet'] .= "<tr>";
	$parse['predu_fleet'] .= "<th>".$lang['tech'][$c]."</th>";
	$parse['predu_fleet'] .= "<th>".$xsd."</th>";
	$parse['predu_fleet'] .= "<th>".$xsw."</th>";
	$parse['predu_fleet'] .= "<th>".$xsm."</th>";
	$parse['predu_fleet'] .= "</tr>";
	$c++;
	}
	////////////////Deffends////////////////
	
	$c = 401; //targed from first deffend out table
	$m = 503; //end and last deffend
	while($c <= $m) {
	
	$Spm = $pricelist[$c]['metal']; 	// Met. price from deffend $c
	$Spc = $pricelist[$c]['crystal']; 	// crys. price from deffend $c
	$Spd = $pricelist[$c]['deuterium']; // Deut. price from deffend $c

	$Xdprom	=	@floor($value['daily_metal']/$Spm);
	$Xdproc	=	@floor($value['daily_crystal']/$Spc);
	$Xdprod	=	@floor($value['daily_deuterium']/$Spd);
	$Xwprom	=	@floor($value['weekly_metal']/$Spm);
	$Xwproc	=	@floor($value['weekly_crystal']/$Spc);
	$Xwprod	=	@floor($value['weekly_deuterium']/$Spd);
	$Xmprom	=	@floor($value['monthly_metal']/$Spm);
	$Xmproc	=	@floor($value['monthly_crystal']/$Spc);
	$Xmprod	=	@floor($value['monthly_deuterium']/$Spd);
	
	if ($Spm > 0 and $Spc == 0 and $Spd == 0) {
		$xsd	=	$Xdprom;
		$xsw	=	$Xwprom;
		$xsm	=	$Xmprom;
	} elseif ($Spm == 0 and $Spc > 0 && $Spd == 0) {
		$xsd	=	$Xdproc;
		$xsw	=	$Xwproc;
		$xsm	=	$Xmproc;
	} elseif ($Spm > 0 and $Spc > 0 and $Spd == 0) {
		$xmind	=	min($Xdprom,$Xdproc);
		$xminw	=	min($Xwprom,$Xwproc);
		$xminm	=	min($Xmprom,$Xmproc);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} elseif ($Spm > 0 and $Spc > 0 and $Spd > 0) {
		$xmind	=	min($Xdprom,$Xdproc,$Xdprod);
		$xminw	=	min($Xwprom,$Xwproc,$Xwprod);
		$xminm	=	min($Xmprom,$Xmproc,$Xmprod);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} elseif ($Spm == 0 and $Spc > 0 and $Spd > 0) {
		$xmind	=	min($Xdproc,$Xdprod);
		$xminw	=	min($Xwproc,$Xwprod);
		$xminm	=	min($Xmproc,$Xmprod);
		$xsd	=	$xmind;
		$xsw	=	$xminw;
		$xsm	=	$xminm; 
	} else {
		$xsd	= ('<font color=red>0</font>');
		$xsw	= ('<font color=red>0</font>');
		$xsm	= ('<font color=red>0</font>'); 
	}
	if ($xsd > 0 and $xsw > 0 and $xsm > 0) {} else {$xsd=0;$xsw=0;$xsm=0;} //verhindert minus produktion anzeige
	
	$parse['predu_def'] .= "<tr>";
	$parse['predu_def'] .= "<th>".$lang['tech'][$c]."</th>";
	$parse['predu_def'] .= "<th>".$xsd."</th>";
	$parse['predu_def'] .= "<th>".$xsw."</th>";
	$parse['predu_def'] .= "<th>".$xsm."</th>";
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
