<?php

/**
 * GalaxyCheckFunctions
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------
//
// Verification sur la base des planetes
//

// Suppression complete d'une lune
function CheckAbandonMoonState ($lunarow) {
	if ($lunarow['destruyed'] <= time() && $lunarow['destruyed'] != 0) {
		doquery("DELETE FROM {{table}} WHERE id={$lunarow['id']}", 'planets');
	}
}

// Suppression complete d'une planete
function CheckAbandonPlanetState ($planet) {
	if ($planet['destruyed'] <= time() && $planet['destruyed'] != 0) {
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}", 'planets');
		doquery("DELETE FROM {{table}} WHERE id_planet={$planet['id']}", 'galaxy');
	}
}


?>