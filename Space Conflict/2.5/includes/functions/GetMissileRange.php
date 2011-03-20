<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GetMissileRange.php                   **
******************************************/

function GetMissileRange () {
	global $resource, $user;

	if ($user[$resource[117]] > 0) {
		$MissileRange = ($user[$resource[117]] * 5) - 1;
	} elseif ($user[$resource[117]] == 0) {
		$MissileRange = 0;
	}

	return $MissileRange;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>