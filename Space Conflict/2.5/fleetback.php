<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** fleetback.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

	$xnova_root_path = './';
	include($xnova_root_path . 'extension.inc');
	include($xnova_root_path . 'common.' . $phpEx);

	includeLang('fleet');

	$BoxTitle   = $lang['fl_error'];
	$TxtColor   = "red";
	$BoxMessage = $lang['fl_notback'];
	if ( is_numeric($_POST['fleetid']) ) {
		$fleetid  = intval($_POST['fleetid']);

		$FleetRow = doquery("SELECT * FROM {{table}} WHERE `fleet_id` = '". $fleetid ."';", 'fleets', true);
		$i = 0;

		if ($FleetRow['fleet_owner'] == $user['id']) {
			if ($FleetRow['fleet_mess'] == 0) {
				if ($FleetRow['fleet_end_stay'] != 0) {

					if ($FleetRow['fleet_start_time'] < time()) {
						$CurrentFlyingTime = time() - $FleetRow['start_time'];
					} else {
						$CurrentFlyingTime = $FleetRow['fleet_start_time'] - $FleetRow['start_time'];
					}
				} else {
					$CurrentFlyingTime = time() - $FleetRow['start_time'];
				}
				$ReturnFlyingTime  = $CurrentFlyingTime + time();

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_start_time` = '". (time() - 1) ."', ";
				$QryUpdateFleet .= "`fleet_end_stay` = '0', ";
				$QryUpdateFleet .= "`fleet_end_time` = '". ($ReturnFlyingTime + 1) ."', ";
				$QryUpdateFleet .= "`fleet_target_owner` = '". $user['id'] ."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE ";
				$QryUpdateFleet .= "`fleet_id` = '" . $fleetid . "';";
				doquery( $QryUpdateFleet, 'fleets');

				$BoxTitle   = $lang['fl_sback'];
				$TxtColor   = "lime";
				$BoxMessage = $lang['fl_isback'];
			} elseif ($FleetRow['fleet_mess'] == 1) {
				$BoxMessage = $lang['fl_notback'];
			}
		} else {
			$BoxMessage = $lang['fl_onlyyours'];
		}
	}

	message ("<font color=\"".$TxtColor."\">". $BoxMessage ."</font>", $BoxTitle, "fleet.". $phpEx, 2);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>