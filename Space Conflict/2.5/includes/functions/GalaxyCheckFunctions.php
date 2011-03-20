<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GalaxyCheckFunctions.php              **
******************************************/

function CheckAbandonMoonState ($lunarow) {
	if (($lunarow['destruyed'] + 172800) <= time() && $lunarow['destruyed'] != 0) {
		$query = doquery("DELETE FROM {{table}} WHERE id = '" . $lunarow['id'] . "'", "lunas");
	}
}

function CheckAbandonPlanetState (&$planet) {
	if ($planet['destruyed'] <= time()) {
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}", 'planets');
		doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}", 'galaxy');
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