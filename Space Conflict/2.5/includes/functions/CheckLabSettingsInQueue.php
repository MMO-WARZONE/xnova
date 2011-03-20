<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** CheckLabSettingsInQueue.php           **
******************************************/

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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>