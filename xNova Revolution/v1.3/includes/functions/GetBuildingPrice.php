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

	function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource;

		if ($Incremental)
			$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$array = array('metal', 'crystal', 'deuterium', 'darkmatter', 'energy_max');
		foreach ($array as $ResType)
		{
			if ($Incremental)
				$cost[$ResType] = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			else
				$cost[$ResType] = floor($pricelist[$Element][$ResType]);

			if ($ForDestroy == true)
			{
				$cost[$ResType]  = floor($cost[$ResType]) / 2;
				$cost[$ResType] /= 2;
			}
		}

		return $cost;
	}
?>
