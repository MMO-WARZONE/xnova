<?php

function CheckLabSettingsInQueue ( $CurrentPlanet ) {
	global $lang, $game_config;

	if ($CurrentPlanet['b_building_id'] != "0") {
		$BuildQueue = $CurrentPlanet['b_building_id'];
		if (strpos ($BuildQueue, ";")) {
			$Queue = explode (";", $BuildQueue);
			$CurrentBuilding = $Queue[0];
		} else {

			$CurrentBuilding = $BuildQueue;
		}

		if ($CurrentBuilding == 31 && $game_config['BuildLabWhileRun'] != 1) {
			$return = false;
		} else {
			$return = true;
		}

	} else {
		$return = true;
	}

	return $return;
}
?>