<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GalaxyRowPlanetName.php               **
******************************************/

function GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user, $HavePhalanx, $CurrentSystem, $CurrentGalaxy;

	$Result  = "<th style=\"white-space: nowrap;\" width=130>";

	if ($GalaxyRowUser['ally_id'] == $user['ally_id'] AND
		$GalaxyRowUser['id']      != $user['id']      AND
		$user['ally_id']          != '') {
		$TextColor = "<font color=\"green\">";
		$EndColor  = "</font>";
	} elseif ($GalaxyRowUser['id'] == $user['id']) {
		$TextColor = "<font color=\"red\">";
		$EndColor  = "</font>";
	} else {
		$TextColor = '';
		$EndColor  = "";
	}

	if ($GalaxyRowPlanet['last_update'] > (time()-59 * 60) AND
		$GalaxyRowUser['id'] != $user['id']) {
		$Inactivity = pretty_time_hour(time() - $GalaxyRowPlanet['last_update']);
	}
	if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0) {
		if ($HavePhalanx <> 0) {
			if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
				$Range = GetPhalanxRange ( $HavePhalanx );
				if ($CurrentGalaxy + $Range <= $CurrentSystem AND
					$CurrentSystem >= $CurrentGalaxy - $Range) {
					$PhalanxTypeLink = "<a href=# onclick=fenster('phalanx.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."')  title=\"".$lang['gl_phalanx']."\">".$GalaxyRowPlanet['name']."</a><br />";
				} else {
					$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
				}
			} else {
				$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
			}
		} else {
			$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
		}

		$Result .= $TextColor . $PhalanxTypeLink . $EndColor;

		if ($GalaxyRowPlanet['last_update']  > (time()-59 * 60) AND
			$GalaxyRowUser['id']            != $user['id']) {
			if ($GalaxyRowPlanet['last_update']  > (time()-10 * 60) AND
				$GalaxyRowUser['id']            != $user['id']) {
				$Result .= "(*)";
			} else {
				$Result .= " (".$Inactivity.")";
			}
		}
	} elseif ($GalaxyRowPlanet["destruyed"] != 0) {
		$Result .= $lang['gl_destroyedplanet'];
	}

	$Result .= "</th>";

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