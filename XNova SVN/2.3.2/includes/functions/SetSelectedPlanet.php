<?php
//version 1

function SetSelectedPlanet ( &$CurrentUser )
{
        global $db;
	$SelectPlanet  = intval($_GET['cp']);
	$RestorePlanet = intval($_GET['re']);

	if (isset($SelectPlanet) && is_numeric($SelectPlanet) && isset($RestorePlanet) && $RestorePlanet == 0)
	{
		$IsPlanetMine   = $db->query("SELECT `id` FROM {{table}}
					  WHERE `id` = '". $SelectPlanet ."'
					  AND `id_owner` = '". $CurrentUser['id'] ."';", 'planets', true);
		if ($IsPlanetMine)
		{
			$CurrentUser['current_planet'] = $SelectPlanet;
			$db->query("UPDATE {{table}} SET `current_planet` = '". $SelectPlanet ."' WHERE `id` = '".$CurrentUser['id']."';", 'users' );
		}
	}
}

?>