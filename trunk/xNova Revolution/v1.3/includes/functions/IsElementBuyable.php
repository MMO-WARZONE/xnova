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

	function IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false)
	{
		global $pricelist, $resource, $xgp_root, $phpEx;

		include_once($xgp_root . 'includes/functions/IsVacationMode.' . $phpEx);

	    if (IsVacationMode($CurrentUser))
	       return false;

		if ($Incremental)
			$level  = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$RetValue = true;
		$array    = array('metal', 'crystal', 'deuterium', 'darkmatter', 'energy_max');

		foreach ($array as $ResType)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				if ($Incremental)
					$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost[$ResType]  = floor($pricelist[$Element][$ResType]);

				if ($ForDestroy)
					$cost[$ResType]  = floor($cost[$ResType] / 2);

				if ($cost[$ResType] > $CurrentPlanet[$ResType])
					$RetValue = false;
			}
		}
		return $RetValue;
	}

?>
