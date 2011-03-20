<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** MissionCaseColonisation.php           **
******************************************/

function MissionCaseColonisation ( $FleetRow ) {
	global $lang, $resource;

	$iPlanetCount = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1'", 'planets'), 0);
	if ($FleetRow['fleet_mess'] == 0) {

		$iGalaxyPlace = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."';", 'galaxy'), 0);
		$TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
		if ($iGalaxyPlace == 0) {

			if ($iPlanetCount >= MAX_PLAYER_PLANETS) {
				$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'] . MAX_PLAYER_PLANETS . $lang['sys_colo_planet'];
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
			} else {
				$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'], false);
				if ( $NewOwnerPlanet == true ) {
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);

					if ($FleetRow['fleet_amount'] == 1) {
						doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
					} else {
						$CurrentFleet = explode(";", $FleetRow['fleet_array']);
						$NewFleet     = "";
						foreach ($CurrentFleet as $Item => $Group) {
							if ($Group != '') {
								$Class = explode (",", $Group);
								if ($Class[0] == 208) {
									if ($Class[1] > 1) {
										$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
									}
								} else {
									if ($Class[1] <> 0) {
									$NewFleet  .= $Class[0].",".$Class[1].";";
									}
								}
							}
						}
						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_array` = '". $NewFleet ."', ";
						$QryUpdateFleet .= "`fleet_amount` = `fleet_amount` - 1, ";
						$QryUpdateFleet .= "`fleet_mess` = '1' ";
						$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';";
						doquery( $QryUpdateFleet, 'fleets');
					}
				} else {
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
			}
		} else {

			$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);

			doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');

		}
	} else {

		RestoreFleetToPlanet ( $FleetRow, true );
		doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
	}
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>