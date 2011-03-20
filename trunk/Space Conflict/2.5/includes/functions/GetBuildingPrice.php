<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GetBuildingPrice.php                  **
******************************************/

function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false) {
	global $pricelist, $resource;

	if ($Incremental) {
		$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
	}

	$array = array('metal', 'crystal', 'deuterium', 'tachyon', 'energy_max');
	foreach ($array as $ResType) {
		if ($Incremental) {
			$cost[$ResType] = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
		} else {
			$cost[$ResType] = floor($pricelist[$Element][$ResType]);
		}

		if ($ForDestroy == true) {
			$cost[$ResType]  = floor($cost[$ResType]) / 2;
			$cost[$ResType] /= 2;
		}
	}

	return $cost;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>