<?php

/**
 * MissionCaseSave.php
 *
 * @version 1 By Chlorel for XNova

 */

function MissionCaseSave ( $FleetRow ) {
	global $lang;

	$QryStartPlanet   = "SELECT * FROM {{table}} ";
	$QryStartPlanet  .= "WHERE ";
	$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
	$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
	$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
	$QryStartPlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";
	$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
	$StartName        = $StartPlanet['name'];
	$StartOwner       = $StartPlanet['id_owner'];

	$QryTargetPlanet  = "SELECT * FROM {{table}} ";
	$QryTargetPlanet .= "WHERE ";
	$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
	$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
	$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
	$QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
	$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
	$TargetName       = $TargetPlanet['name'];
	$TargetOwner      = $TargetPlanet['id_owner'];

	if ($FleetRow['fleet_mess'] == 0) {
		if ($FleetRow['fleet_start_time'] < time()) {


			$QryUpdateFleet  = "UPDATE {{table}} SET ";
			$QryUpdateFleet .= "`fleet_mess` = '1' ";
			$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
			$QryUpdateFleet .= "LIMIT 1 ;";
			doquery( $QryUpdateFleet, 'fleets');
		}
	} else {
		if ($FleetRow['fleet_end_time'] < time()) {
			$Message             = sprintf ($lang['sys_save_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
			SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_save'], $lang['sys_mess_fleetback'], $Message);
			RestoreFleetToPlanet ( $FleetRow, true );
			doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
		}
	}
}

// -----------------------------------------------------------------------------------------------------------
// History version
?>