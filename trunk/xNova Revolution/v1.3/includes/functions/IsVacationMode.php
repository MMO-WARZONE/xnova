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

	function IsVacationMode($CurrentUser)
	{
		global $game_config;

		if($CurrentUser['urlaubs_modus'] == 1)
		{
			$query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');

			while($id = mysql_fetch_array($query))
			{
				doquery("UPDATE {{table}} SET
				metal_perhour = '".$game_config['metal_basic_income']."',
				crystal_perhour = '".$game_config['crystal_basic_income']."',
				deuterium_perhour = '".$game_config['deuterium_basic_income']."',
                darkmatter_perhour = '".$game_config['darkmatter_basic_income']."',
            	metal_mine_porcent = '0',
				crystal_mine_porcent = '0',
				deuterium_sintetizer_porcent = '0',
				darkmatter_mine_porcent = '0',
				solar_plant_porcent = '0',
				fusion_plant_porcent = '0',
				solar_satelit_porcent = '0'
				WHERE id = '{$id['id']}' AND `planet_type` = '1' ", 'planets');
			}
			return true;
		}
		return false;
	}
?>
