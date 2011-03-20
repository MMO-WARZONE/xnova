<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** FlyingFleetHandler.php                **
******************************************/

function FlyingFleetHandler (&$planet) {
	global $resource;

	doquery("LOCK TABLE {{table}}lunas WRITE, {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE, {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE", "");

	$QryFleet   = "SELECT * FROM {{table}} ";
	$QryFleet  .= "WHERE (";
	$QryFleet  .= "( ";
	$QryFleet  .= "`fleet_start_galaxy` = ". $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_start_system` = ". $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_start_planet` = ". $planet['planet']      ." AND ";
	$QryFleet  .= "`fleet_start_type` = ".   $planet['planet_type'] ." ";
	$QryFleet  .= ") OR ( ";
	$QryFleet  .= "`fleet_end_galaxy` = ".   $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_end_system` = ".   $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_end_planet` = ".   $planet['planet']      ." ) AND ";
	$QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." ) AND ";
	$QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
	$fleetquery = doquery( $QryFleet, 'fleets' );

	while ($CurrentFleet = mysql_fetch_array($fleetquery)) {
		switch ($CurrentFleet["fleet_mission"]) {
			case 1:
				MissionCaseAttack ( $CurrentFleet );
				break;

			case 2:
				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
				break;

			case 3:
				MissionCaseTransport ( $CurrentFleet );
				break;

			case 4:
				MissionCaseStay ( $CurrentFleet );
				break;

			case 5:
			MissionCaseStayAlly ( $CurrentFleet );
				break;

			case 6:
				MissionCaseSpy ( $CurrentFleet );
				break;

			case 7:
				MissionCaseColonisation ( $CurrentFleet );
				break;

			case 8:
				MissionCaseRecycling ( $CurrentFleet );
				break;

			case 9:
				MissionCaseDestruction ( $CurrentFleet );
				break;

			case 10:
				// Missiles?
				break;

			case 15:
				MissionCaseExpedition ( $CurrentFleet );
				break;

			default: {
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
			}
		}
	}

	doquery("UNLOCK TABLES", "");
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>