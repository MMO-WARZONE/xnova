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

	function GetBuildingTime ($user, $planet, $Element)
	{
		global $pricelist, $resource, $reslist, $game_config;


		$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		if       (in_array($Element, $reslist['build']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
            $cost_darkmatter = floor($pricelist[$Element]['darkmatter'] * pow($pricelist[$Element]['factor'], $level));
            $time         = ((($cost_crystal) + ($cost_metal) + ($cost_darkmatter)) / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]);
			$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_constructeur']) * CONSTRUCTEUR)));
		}
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
            $cost_darkmatter = floor($pricelist[$Element]['darkmatter'] * pow($pricelist[$Element]['factor'], $level));
            $intergal_lab = $user[$resource[123]];

			if($intergal_lab < 1)
				$lablevel = $planet[$resource['31']];
			else
			{
				$limite = $intergal_lab+1;
				$inves = doquery("SELECT laboratory FROM {{table}} WHERE id_owner='".$user['id']."' ORDER BY laboratory DESC limit ".$limite."", 'planets');
				$lablevel = 0;
				while ($row= mysql_fetch_array($inves))
				{
					$lablevel += $row['laboratory'];
				}
			}

			$time         = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / (($lablevel + 1) * 2);
			$time         = floor(($time * 60 * 60 * 60) * (1 - (($user['rpg_scientifique']) * SCIENTIFIQUE)));
		}
		elseif (in_array($Element, $reslist['defense']))
		{
			$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal'] + $pricelist[$Element]['darkmatter']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
			$time         = floor(($time * 60 * 60 * 60) * (1 - ((($user['rpg_general']) * GENERAL) + (($user['rpg_defenseur']) * DEFENSEUR))));
		}
		elseif (in_array($Element, $reslist['fleet']))
		{
			$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal'] + $pricelist[$Element]['darkmatter']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
			$time         = floor(($time * 60 * 60 * 60) * (1 - ((($user['rpg_general']) * GENERAL) + (($user['rpg_technocrate']) * TECHNOCRATE))));
		}

		return $time;
	}

?>
