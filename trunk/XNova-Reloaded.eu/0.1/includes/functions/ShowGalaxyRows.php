<?php

/**
 * ShowGalaxyRows.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxyRows ($Galaxy, $System) {
	global $DB, $lang, $planetcount, $CurrentRC, $dpath, $user;

	$Result = "";
	for ($Planet = 1; $Planet < 16; $Planet++) {
		unset($GalaxyRowPlanet);
		unset($GalaxyRowMoon);
		unset($GalaxyRowava);
		unset($GalaxyRowPlayer);
		unset($GalaxyRowAlly);

		$Query = $DB->query("SELECT * FROM ".PREFIX."galaxy WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."';");
		$GalaxyRow = $Query->fetch();
		
		$Result .= "\n";
		$Result .= "<tr>"; // Depart de ligne
		if ($GalaxyRow) {
			// Il existe des choses sur cette ligne de planete
			if ($GalaxyRow["id_planet"] != 0) {
				$Query2 = $DB->query("SELECT * FROM ".PREFIX."planets WHERE `id` = '". $GalaxyRow["id_planet"] ."';");
				$GalaxyRowPlanet = $Query2->fetch();

				if ($GalaxyRowPlanet['destruyed'] != 0 AND
					$GalaxyRowPlanet['id_owner'] != '' AND
					$GalaxyRow["id_planet"] != '') {
					CheckAbandonPlanetState ($GalaxyRowPlanet);
				} else {
					$planetcount++;
					$Query3 = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '". $GalaxyRowPlanet["id_owner"] ."';");
					$GalaxyRowPlayer = $Query3->fetch();
				}

				if ($GalaxyRow["id_luna"] != 0) {
					$Query = $DB->query("SELECT * FROM ".PREFIX."lunas WHERE `id` = '". $GalaxyRow["id_luna"] ."';");
					$GalaxyRowMoon = $Query->fetch();
					if ($GalaxyRowMoon["destruyed"] != 0) {
						CheckAbandonMoonState ($GalaxyRowMoon);
					}
				}
				$Query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE `id` = '". $GalaxyRow["id_planet"] ."';");
				$GalaxyRowPlanet = $Query->fetch();
				if ($GalaxyRowPlanet['id_owner'] <> 0) {
					$Query = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '". $GalaxyRow["id_planet"] ."';");
					$GalaxyRowUser = $Query->fetch();
				} else {
					$GalaxyRowUser     = array();
				}
			}
		}
		$Result .= "\n";
		$Result .= GalaxyRowPos        ( $Planet, $GalaxyRow );
		$Result .= "\n";
		$Result .= GalaxyRowPlanet     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1 );
		$Result .= "\n";
		$Result .= GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1 );
		$Result .= "\n";
		$Result .= GalaxyRowMoon       ( $GalaxyRow, $GalaxyRowMoon  , $GalaxyRowPlayer, $Galaxy, $System, $Planet, 3 );
		$Result .= "\n";
		$Result .= GalaxyRowDebris     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 2 );
		$Result .= "\n";
		$Result .= GalaxyRowava       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= GalaxyRowUser       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= GalaxyRowAlly       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= GalaxyRowActions    ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= "</tr>";
	}

	return $Result;
}
?>