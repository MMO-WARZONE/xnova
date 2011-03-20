<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** SetSelectedPlanet.php                 **
******************************************/

function SetSelectedPlanet ( &$CurrentUser ) {
	global $_GET;

	$SelectPlanet  = $_GET['cp'];
	$RestorePlanet = $_GET['re'];

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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>