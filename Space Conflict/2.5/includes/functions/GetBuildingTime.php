<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GetBuildingTime.php                   **
******************************************/

// Calculate the construction time for each element (Buildings / Research / Defense / Ships )
// $user       ->  Current Player
// $planet     ->  Current Planet
// $Element    ->  Element to construct
// Resource  14 =>  Robotics Factory (5% bonus)
// Resource  15 =>  Nanite Factory (10% bonus)
// Resource  31 =>  Research Lab (10% bonus)
// Resource 123 =>  Intergalactic Research Network (50% bonus)
// Resource  21 =>  Shipyard (5% bonus)
// Resource  35 =>  Orbital Shipyard (10% bonus)

function GetBuildingTime ($user, $planet, $Element) {
	global $pricelist, $resource, $reslist, $game_config;
	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	$cost_metal     = floor($pricelist[$Element]['metal']      * pow($pricelist[$Element]['factor'], $level));
	$cost_crystal   = floor($pricelist[$Element]['crystal']    * pow($pricelist[$Element]['factor'], $level));
	$cost_deuterium = floor($pricelist[$Element]['deuterium']  * pow($pricelist[$Element]['factor'], $level));
	$cost_tachyon   = floor($pricelist[$Element]['tachyon']    * pow($pricelist[$Element]['factor'], $level));
	$cost_energy    = floor($pricelist[$Element]['energy_max'] * pow($pricelist[$Element]['factor'], $level));
	$cost_mass      = ($pricelist[$Element]['mass']);
	  $total_cost   = (($cost_metal) + ($cost_crystal) + ($cost_deuterium) + ($cost_tachyon) + ($cost_energy));

// Building Time Formula
	if       (in_array($Element, $reslist['build'])) {
		$time         = ($total_cost / $game_config['game_speed']);
		$time         = ($time * pow( 0.9, $planet[$resource['14']]) * pow( 0.75, $planet[$resource['15']]));
		$time         = floor(($time * 60 * 60) * pow(0.9, ($user['rpg_constructeur'])));

//Research Time Formula
// Need to fix IRN bonus
	} elseif (in_array($Element, $reslist['tech'])) {
		$time         = ($total_cost / $game_config['game_speed']);
		$time         = ($time * pow( 0.9, $planet[$resource['31']]) * pow( 0.5, $planet[$resource['123']]));
		$time         = floor(($time * 60 * 60) * pow( 0.9, ($user['rpg_scientifique'])));

// Defense Time Formula
	} elseif (in_array($Element, $reslist['defense'])) {
		$time         = ($total_cost / $game_config['game_speed']);
		$time         = ($time * pow( 0.9, $planet[$resource['14']]) * pow( 0.9, $planet[$resource['21']]) * pow( 0.75, $planet[$resource['15']]) * pow( 0.75, $planet[$resource['35']]));
		$time         = floor(($time * 60 * 60) * pow( 0.75, ($user['rpg_defenseur'])));

// Ship Time Formula
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = ($total_cost / $game_config['game_speed']);
		$time         = ($time * pow( 0.9, $planet[$resource['14']]) * pow( 0.9, $planet[$resource['21']]) * pow( 0.75, $planet[$resource['15']]) * pow( 0.75, $planet[$resource['35']]));
		$time         = floor(($time * 60 * 60) * pow( 0.75, ($user['rpg_technocrate'])));
	}


	return $time;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>