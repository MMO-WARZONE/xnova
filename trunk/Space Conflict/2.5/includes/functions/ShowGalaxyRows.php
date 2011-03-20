<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** ShowGalaxyRows.php                    **
******************************************/

function ShowGalaxyRows ($Galaxy, $System) {
	global $lang, $planetcount, $CurrentRC, $dpath, $user;

	$Result = "";
	for ($Planet = 1; $Planet < (MAX_PLANET_IN_SYSTEM + 1); $Planet++) {
		unset($GalaxyRowPlanet);
		unset($GalaxyRowMoon);
		unset($GalaxyRowPlayer);
		unset($GalaxyRowAlly);

		$GalaxyRow = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."';", 'galaxy', true);

		$Result .= "\n";
		$Result .= "<tr>";
		if ($GalaxyRow) {
			if ($GalaxyRow["id_planet"] != 0) {
				$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_planet"] ."';", 'planets', true);

				if ($GalaxyRowPlanet['destruyed'] != 0 AND
					$GalaxyRowPlanet['id_owner'] != '' AND
					$GalaxyRow["id_planet"] != '') {
					CheckAbandonPlanetState ($GalaxyRowPlanet);
				} else {
					$planetcount++;
					$GalaxyRowPlayer = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet["id_owner"] ."';", 'users', true);
				}

				if ($GalaxyRow["id_luna"] != 0) {
					$GalaxyRowMoon   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_luna"] ."';", 'lunas', true);
					if ($GalaxyRowMoon["destruyed"] != 0) {
						CheckAbandonMoonState ($GalaxyRowMoon);
					}
				}
				$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_planet"] ."';", 'planets', true);
				if ($GalaxyRowPlanet['id_owner'] <> 0) {
					$GalaxyRowUser     = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet['id_owner'] ."';", 'users', true);
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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>