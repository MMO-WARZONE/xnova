<?php
//version 1


function GetBuildingTime ($user, $planet, $Element)
{
	global $pricelist, $resource, $reslist, $db;


	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	if       (in_array($Element, $reslist['build']))
	{
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
                $cost_deuterio  = floor($pricelist[$Element]['deuterium']* pow($pricelist[$Element]['factor'], $level));

		$time         = (($cost_crystal + $cost_metal + $cost_deuterio) / $db->game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.1)));
	}
	elseif (in_array($Element, $reslist['tech']))
	{
		$cost_metal     = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal   = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$cost_deuterio  = floor($pricelist[$Element]['deuterium']* pow($pricelist[$Element]['factor'], $level));
		$cost_energia   = floor($pricelist[$Element]['energy_max'] * pow($pricelist[$Element]['factor'], $level));

                $intergal_lab = $user[$resource[123]];

		if($intergal_lab < 1){
			$lablevel = $planet[$resource['31']];
                }
                else
		{
			$limite = $intergal_lab+1;
			$inves = $db->query("SELECT laboratory FROM {{table}}
					 WHERE id_owner='".$user['id']."'
					 ORDER BY laboratory DESC limit ".$limite."", 'planets');
			$lablevel = 0;
			while ($row= mysql_fetch_array($inves))
			{
				$lablevel += $row['laboratory'];
			}
		}

		$time         = (($cost_metal + $cost_crystal + $cost_deuterio + $cost_energia) / $db->game_config['game_speed']) / (($lablevel + 1) * 2);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_scientifique']) * 0.1)));
	}
	elseif (in_array($Element, $reslist['defense']))
	{
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $db->game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - ((($user['rpg_general']) * 0.10) + (($user['rpg_defenseur']) * 0.25))));
	}
	elseif (in_array($Element, $reslist['fleet']))
	{
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $db->game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - ((($user['rpg_general']) * 0.10) + (($user['rpg_technocrate']) * 0.05))));
	}
        
	if($time<5){
            $time=5;
        }
	return $time;
}

?>