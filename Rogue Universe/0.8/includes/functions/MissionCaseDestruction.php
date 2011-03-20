<?php

function MissionCaseDestruction($FleetRow) {
	global $user, $phpEx, $ugamela_root_path, $lang;

	includeLang('system');

	if ($FleetRow['fleet_mess'] == 0) {
		if ($FleetRow['fleet_start_time'] < time()) {

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

			include_once($ugamela_root_path . 'includes/ataki.' . $phpEx);
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$starttime    = $mtime;
			$Destruction  = walka($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno);
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$endtime      = $mtime;
			$totaltime    = ($endtime - $starttime);
			$CurrentSet   = $Destruction["atakujacy"];
			$TargetSet    = $Destruction["wrog"];
			$FleetResult  = $Destruction["wygrana"];
			$RapportLong  = $Destruction["dane_do_rw"];
			$RapportCourt = $Destruction["zlom"];

			$FleetAmount  = 0;
			foreach ($CurrentSet as $Ship => $Count) {
				$FleetStorage += $pricelist[$Ship]["capacity"] * $Count["ilosc"];
				$FleetArray   .= $Ship . "," . $Count["ilosc"] . ";";
				$FleetAmount  += $Count["ilosc"];
			}

			if ($FleetResult == "a") {
			}
		}
	}
}
?>