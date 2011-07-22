<?php

define('INSIDE'  , true);
define('INSTALL' , false);

	$rocketnova_root_path = './';
	include($rocketnova_root_path . 'extension.inc');
	include($rocketnova_root_path . 'common.' . $phpEx);

	includeLang('fleet');

// Schutz vor unregestrierten Usern
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}	
	
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
					// Faut calculer le temps reel de retour
					if ($FleetRow['fleet_start_time'] < time()) {
						// On a pas encore entamé le stationnement
						// Il faut calculer la parcelle de temps ecoulée depuis le lancement de la flotte
						$CurrentFlyingTime = time() - $FleetRow['start_time'];
					} else {
						// On est deja en stationnement
						// Il faut donc directement calculer la durée d'un vol aller ou retour
						$CurrentFlyingTime = $FleetRow['fleet_start_time'] - $FleetRow['start_time'];
					}
				} else {
					// C'est quoi le stationnement ??
					// On calcule sagement la parcelle de temps ecoulée depuis le depart
					$CurrentFlyingTime = time() - $FleetRow['start_time'];
				}
				// Allez houste au bout du compte y a la maison !! (E.T. phone home.............)
				  $ReturnFlyingTime  = (time() - $FleetRow['start_time']) + time();

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

?>