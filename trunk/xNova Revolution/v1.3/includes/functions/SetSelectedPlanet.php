<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SetSelectedPlanet ( &$CurrentUser )
	{

		$SelectPlanet  = $_GET['cp'];
		$RestorePlanet = $_GET['re'];

		if (isset($SelectPlanet) && is_numeric($SelectPlanet) && isset($RestorePlanet) && $RestorePlanet == 0)
		{
			$IsPlanetMine   = doquery("SELECT `id` FROM {{table}} WHERE `id` = '". $SelectPlanet ."' AND `id_owner` = '". $CurrentUser['id'] ."';", 'planets', true);
			if ($IsPlanetMine)
			{
				$CurrentUser['current_planet'] = $SelectPlanet;
				doquery("UPDATE {{table}} SET `current_planet` = '". $SelectPlanet ."' WHERE `id` = '".$CurrentUser['id']."';", 'users');
			}
		}
	}

?>
