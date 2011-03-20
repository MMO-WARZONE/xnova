<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** RemoveBuildingFromQueue.php           **
******************************************/

function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID ) {
	if ($QueueID > 1) {
		$CurrentQueue  = $CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
			$ListIDArray   = explode ( ",", $QueueArray[$QueueID - 2] );
			$BuildEndTime  = $ListIDArray[3];
			for ($ID = $QueueID; $ID < $ActualCount; $ID++ ) {
				$ListIDArray          = explode ( ",", $QueueArray[$ID] );
				$BuildEndTime        += $ListIDArray[2];
				$ListIDArray[3]       = $BuildEndTime;
				$QueueArray[$ID - 1]  = implode ( ",", $ListIDArray );
			}
			unset ($QueueArray[$ActualCount - 1]);
			$NewQueue     = implode ( ";", $QueueArray );
		}
		$CurrentPlanet['b_building_id'] = $NewQueue;
	}
	return $QueueID;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>