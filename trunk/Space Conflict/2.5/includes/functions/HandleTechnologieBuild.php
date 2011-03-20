<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** HandleTechnologieBuild.php            **
******************************************/

function HandleTechnologieBuild ( &$CurrentPlanet, &$CurrentUser ) {
	global $resource;

	if ($CurrentUser['b_tech_planet'] != 0) {

		if ($CurrentUser['b_tech_planet'] != $CurrentPlanet['id']) {
			$WorkingPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['b_tech_planet'] ."';", 'planets', true);
		}

		if ($WorkingPlanet) {
			$ThePlanet = $WorkingPlanet;
		} else {
			$ThePlanet = $CurrentPlanet;
		}

		if ($ThePlanet['b_tech']    <= time() &&
			$ThePlanet['b_tech_id'] != 0) {
			$CurrentUser[$resource[$ThePlanet['b_tech_id']]]++;

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`b_tech` = '0', ";
			$QryUpdatePlanet .= "`b_tech_id` = '0' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $ThePlanet['id'] ."';";
			doquery( $QryUpdatePlanet, 'planets');

			$QryUpdateUser    = "UPDATE {{table}} SET ";
			$QryUpdateUser   .= "`".$resource[$ThePlanet['b_tech_id']]."` = '". $CurrentUser[$resource[$ThePlanet['b_tech_id']]] ."', ";
			$QryUpdateUser   .= "`b_tech_planet` = '0' ";
			$QryUpdateUser   .= "WHERE ";
			$QryUpdateUser   .= "`id` = '". $CurrentUser['id'] ."';";
			doquery( $QryUpdateUser, 'users');
			$ThePlanet["b_tech_id"] = 0;
			if (isset($WorkingPlanet)) {
				$WorkingPlanet = $ThePlanet;
			} else {
				$CurrentPlanet = $ThePlanet;
			}
			$Result['WorkOn'] = "";
			$Result['OnWork'] = false;

		} elseif ($ThePlanet["b_tech_id"] == 0) {
			doquery("UPDATE {{table}} SET `b_tech_planet` = '0'  WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
			$Result['WorkOn'] = "";
			$Result['OnWork'] = false;

		} else {
			$Result['WorkOn'] = $ThePlanet;
			$Result['OnWork'] = true;
		}
	} else {
		$Result['WorkOn'] = "";
		$Result['OnWork'] = false;
	}

	return $Result;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>