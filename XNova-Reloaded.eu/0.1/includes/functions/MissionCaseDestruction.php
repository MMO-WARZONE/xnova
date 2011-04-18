<?php

/**
 * MissionCaseDestruction.php
 * Par Tom, et oué enfin un truc bien codé par moi ^^
 * Largement inspiré de MissionCaseAttack quand même
 *
 * @version 1
 * @copyright 2008
 */

function MissionCaseDestruction($FleetRow) {
	global $user, $lang;

	includeLang('system');

	if ($FleetRow['fleet_mess'] == 0) {
		if ($FleetRow['fleet_start_time'] < time()) {
			// La flotte arrive pour démollir la lune
			$QryTargetPlanet  = "SELECT * FROM {{table}} ";
			$QryTargetPlanet .= "WHERE ";
			$QryTargetPlanet .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
			$QryTargetPlanet .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
			$QryTargetPlanet .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "';";
			$TargetPlanet     = doquery($QryTargetPlanet, 'planets', true);

			$TargetUserID     = $TargetPlanet['id_owner'];

			$QryCurrentUser   = "SELECT * FROM {{table}} ";
			$QryCurrentUser  .= "WHERE ";
			$QryCurrentUser  .= "`id` = '" . $FleetRow['fleet_owner'] . "';";
			$CurrentUser      = doquery($QryCurrentUser , 'users', true);

			$CurrentUserID    = $CurrentUser['id'];

			$QryTargetUser    = "SELECT * FROM {{table}} ";
			$QryTargetUser   .= "WHERE ";
			$QryTargetUser   .= "`id` = '" . $TargetUserID . "';";

			$TargetUser       = doquery($QryTargetUser, 'users', true);

			$QryTargetTech    = "SELECT ";
			$QryTargetTech   .= "`military_tech`, `defence_tech`, `shield_tech` ";
			$QryTargetTech   .= "FROM {{table}} ";
			$QryTargetTech   .= "WHERE ";
			$QryTargetTech   .= "`id` = '" . $TargetUserID . "';";

			$TargetTechno     = doquery($QryTargetTech, 'users', true);

			$QryCurrentTech   = "SELECT ";
			$QryCurrentTech  .= "`military_tech`, `defence_tech`, `shield_tech` ";
			$QryCurrentTech  .= "FROM {{table}} ";
			$QryCurrentTech  .= "WHERE ";
			$QryCurrentTech  .= "`id` = '" . $CurrentUserID . "';";
			$CurrentTechno    = doquery($QryCurrentTech, 'users', true);

			for ($SetItem = 200; $SetItem < 500; $SetItem++) {
				if ($TargetPlanet[$resource[$SetItem]] > 0) {
					$TargetSet[$SetItem]["ilosc"] = $TargetPlanet[$resource[$SetItem]];
				}
			}

			$TheFleet = explode(";", $FleetRow['fleet_array']);
			foreach($TheFleet as $a => $b) {
				if ($b != '') {
					$a = explode(",", $b);
					$CurrentSet[$a[0]]["ilosc"] = $a[1];
				}
			}

			// On inclue que le fichier d'attaque et pas de calcul de ressources car on est là pour DETRUIRE !
			include_once(XNOVA_ROOT_PATH . 'includes/ataki.php');
			// Les petits calculs divers pour le futur rapport
			// Initialisation
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$starttime    = $mtime;
			// Et là on attaque le gros, l'attaque !
			$Destruction  = walka($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno);
			// la on a  les données de l'attaque on va commencer les petits calculs
			// Calcul de la duree de traitement (calcul) (Merci Chlorel)
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$endtime      = $mtime;
			$totaltime    = ($endtime - $starttime);
			// Ce qu'il reste de l'attaquant
			$CurrentSet   = $Destruction["atakujacy"];
			// Ce qu'il reste de l'attaqué
			$TargetSet    = $Destruction["wrog"];
			// Le resultat de la bataille
			$FleetResult  = $Destruction["wygrana"];
			// Rapport long (rapport de bataille detaillé)
			$RapportLong  = $Destruction["dane_do_rw"];
			// Rapport court (cdr + unitées perdues)
			$RapportCourt = $Destruction["zlom"];

			$FleetAmount  = 0;
			foreach ($CurrentSet as $Ship => $Count) {
				$FleetStorage += $pricelist[$Ship]["capacity"] * $Count["ilosc"];
				$FleetArray   .= $Ship . "," . $Count["ilosc"] . ";";
				$FleetAmount  += $Count["ilosc"];
			}

			// Si le defenseur a perdu (GG l'attaquant !)
			if ($FleetResult == "a") {
			}
		}
	}
}
?>