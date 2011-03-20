<?php

function IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false) {
	global $pricelist, $resource;

	if ($Incremental) {
		$level  = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
	}

	$RetValue = true;
	$array    = array('metal', 'crystal', 'deuterium', 'energy_max');

	foreach ($array as $ResType) {
		if ($pricelist[$Element][$ResType] != 0) {
			if ($Incremental) {
				$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			} else {
				$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
			}

			if ($ForDestroy) {
				$cost[$ResType]  = floor($cost[$ResType] / 2);
			}

			if ($cost[$ResType] > $CurrentPlanet[$ResType]) {
				$RetValue = false;
			}
		}
	}
	return $RetValue;
}
?>