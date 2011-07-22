<?php

/**
 * SetSelectedPlanet.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

function SetSelectedPlanet ( &$CurrentUser ) {
	global $_GET;

	if (isset ($_GET['cp'])) $SelectPlanet  = $_GET['cp'];
	if (isset ($_GET['re'])) $RestorePlanet = $_GET['re'];

	if (isset($SelectPlanet)      &&
		is_numeric($SelectPlanet) &&
		isset($RestorePlanet)     &&
		$RestorePlanet == 0) {
		$IsPlanetMine   = doquery("SELECT `id` FROM {{table}} WHERE `id` = '". $SelectPlanet ."' AND `id_owner` = '". $CurrentUser['id'] ."';", 'planets', true);
		if ($IsPlanetMine) {
			$CurrentUser['current_planet'] = $SelectPlanet;
			doquery("UPDATE {{table}} SET `current_planet` = '". $SelectPlanet ."' WHERE `id` = '".$CurrentUser['id']."';", 'users');
		}
	}
}
?>