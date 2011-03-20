<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** UpdatePlanetBatimentQueueList.php     **
******************************************/

function UpdatePlanetBatimentQueueList ( &$CurrentPlanet, &$CurrentUser ) {
	$RetValue = false;
	if ( $CurrentPlanet['b_building_id'] != 0 ) {
		while ( $CurrentPlanet['b_building_id'] != 0 ) {
			if ( $CurrentPlanet['b_building'] <= time() ) {
				PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, $CurrentPlanet['b_building'], false );
				$IsDone = CheckPlanetBuildingQueue( $CurrentPlanet, $CurrentUser );
				if ( $IsDone == true ) {
					SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );
				}
			} else {
				$RetValue = true;
				break;
			}
		}
	}
	return $RetValue;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>