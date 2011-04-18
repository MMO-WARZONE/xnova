<?php

/**
 * GetBuildingTimeWhithoutTechs
 *
 * @copyright 2009 by Steggi for Xnova-reloaded.de
+
 */

// Zeitberechnung für die ursprüngliche Bau bzw Forschungszeit (die Techwerte werden hierbei nicht berücksichtigt)
// $user       -> Der User selber
// $planet     -> Der Planet, wo das Element (Gebäude, Forschung, Fleet,Deff) hin soll
// $Element    -> Element was man haben will
function GetBuildingTimeWithoutTechs ($user, $planet, $Element) {
	global $pricelist, $resource, $reslist, $game_config;


	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	if       (in_array($Element, $reslist['build'])) {
		// Für Gebaude wird diese Formel benutzt
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = ((($cost_crystal) + ($cost_metal)) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['tech'])) {
		//und für Forschung diese Formel
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = (($cost_metal + $cost_crystal) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['defense'])) {
		//Feste Bauzeiten für Fleet und Deff. Zeitverkürzung durch Roboterfabrik, und Nanitenfabrik
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	}
	//Wenn die Bauzeit kleiner als 1 ist, ist sie wieder 1, um instantbauten zu verhindern
	if ($time < 1)
	$time = 1;

	return $time;
}
?>