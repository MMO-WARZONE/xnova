<?php

/**
 * GetBuildingTime
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 *
 *Übersetzung by Steggi for Xnova-reloaded.de
 */

// Zeitberechnung für die Bau bzw Forschungszeit (Techwerte werden mitberechnet)
// $user       -> Der User selber
// $planet     -> Der Planet, wo das Element (Gebäude, Forschung, Fleet,Deff) hin soll
// $Element    -> Element was man haben will
function GetBuildingTime ($user, $planet, $Element) {
	global $pricelist, $resource, $reslist, $game_config;


	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	if       (in_array($Element, $reslist['build'])) {
		// Pour un batiment ...
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = ((($cost_crystal) + ($cost_metal)) / ($game_config['game_speed'] * 2500)) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.1)));
	} elseif (in_array($Element, $reslist['tech'])) {
		// Pour une recherche
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$intergal_lab = $user[$resource[123]];
		if       ( $intergal_lab < "1" ) {
			$lablevel = $planet[$resource['31']];
		} elseif ( $intergal_lab >= "1" ) {
			$empire = doquery("SELECT * FROM {{table}} WHERE id_owner='". $user[id] ."';", 'planets');
			$NbLabs = 0;
			while ($colonie = mysql_fetch_array($empire)) {
				$techlevel[$NbLabs] = $colonie[$resource['31']];
				$NbLabs++;
			}
			if ($intergal_lab >= "1") {
				$lablevel = 0;
				for ($lab = 1; $lab <= $intergal_lab; $lab++) {
					asort($techlevel);
					$lablevel += $techlevel[$lab - 1];
				}
			}
		}
		$time         = (($cost_metal + $cost_crystal) / ($game_config['game_speed'] * 2500)) / (($lablevel + 1) * 2);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_scientifique']) * 0.1)));
	} elseif (in_array($Element, $reslist['defense'])) {
		// Pour les defenses ou la flotte 'tarif fixe' durée adaptée a u niveau nanite et usine robot
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500)) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_defenseur'])   * 0.375)));
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500)) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor(($time * 60 * 60) * (1 - (($user['rpg_technocrate']) * 0.05)));
	}
	//Wenn die Bauzeit kleiner als 1 ist, ist sie wieder 1, um instantbauten zu verhindern
	if ($time < 1)
	$time = 1;


	return $time;
}
?>