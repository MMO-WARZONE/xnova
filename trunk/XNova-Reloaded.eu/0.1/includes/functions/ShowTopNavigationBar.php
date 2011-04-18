<?php

/**
 * ShowTopNavigationBar.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $_GET, $game_config; 

	if ($CurrentUser) {
		if ( !$CurrentPlanet ) {
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets', true);
		}

		// Aktualisieren der Planeten Ress
		PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );

		$NavigationTPL       = gettemplate('topnav');

		$dpath               = (!$CurrentUser["dpath"]) ? DEFAULT_SKINPATH : $CurrentUser["dpath"];
		$parse               = $lang;
		$parse['dpath']      = $dpath;
		$parse['image']      = $CurrentPlanet['image'];

		// Genearation de la combo des planetes du joueur
		$parse['planetlist'] = '';
		$ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
			if ($CurPlanet["destruyed"] == 0) {
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet']) {
					// Bon puisque deja on s'y trouve autant le marquer
					$parse['planetlist'] .= "selected=\"selected\" ";
				}
				$parse['planetlist'] .= "value=\"?cp=".$CurPlanet['id']."";
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";

				// Nom et coordonnées de la planete
				$parse['planetlist'] .= "".$CurPlanet['name'];
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
			}
		}
		
		if       ($CurrentPlanet['energy_max'] == 0 &&
		$CurrentPlanet['energy_used'] > 0) {
		$production_level = 0;
		} elseif ($CurrentPlanet['energy_max']  > 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
			$production_level = floor(($CurrentPlanet['energy_max']) / abs($CurrentPlanet['energy_used']) * 100);
		} elseif ($CurrentPlanet['energy_max'] == 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
			$production_level = 0;
		} else {
			$production_level = 100;
		}
		if ($production_level > 100) {
			$production_level = 100;
		}

		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$parse['metal'] = pretty_number($CurrentPlanet["metal"]);
		$parse['metal_js'] = str_replace(".", "", pretty_number($CurrentPlanet["metal"]));
		if (($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"])) {
			$parse['metal_per_hour'] = 0;
		} else {
			$metal = abs(floor( $CurrentPlanet['metal_perhour']     * 0.01 * $production_level )) + ($game_config['metal_basic_income'] * $game_config['resource_multiplier']);
			$parse['metal_per_hour'] = $metal / 3600;
		}
		
		
		// Cristal
		$parse['crystal'] = pretty_number($CurrentPlanet["crystal"]);
		$parse['crystal_js'] = str_replace(".", "", pretty_number($CurrentPlanet["crystal"]));
		if (($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"])) {
			$parse['crystal_per_hour'] = 0;
		} else {
			$crystal = abs(floor( $CurrentPlanet['crystal_perhour']     * 0.01 * $production_level )) + ($game_config['crystal_basic_income'] * $game_config['resource_multiplier']);
			$parse['crystal_per_hour'] = $crystal / 3600;
		}
		
		// Deuterium
		$parse['deuterium'] = pretty_number($CurrentPlanet["deuterium"]);
		$parse['deuterium_js'] = str_replace(".", "", pretty_number($CurrentPlanet["deuterium"]));
		if (($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium_per_hour'] = 0;
		} else {
			$deuterium = abs(floor( $CurrentPlanet['deuterium_perhour']     * 0.01 * $production_level )) + ($game_config['deuterium_basic_income'] * $game_config['resource_multiplier']);
			$parse['deuterium_per_hour'] = $deuterium / 3600;
		}
		
		// Max Energie
		$energy_max= pretty_number($CurrentPlanet["energy_max"]);
		if (($CurrentPlanet["energy_max"] > $CurrentPlanet["energy_max"])) {
			$parse['energy_max'] = colorRed($energy_max);
		} else {
			$parse['energy_max'] = $energy_max;
		}

$parse['energy_total'] = colorNumber(pretty_number(floor(($CurrentPlanet['energy_max'] + $CurrentPlanet["energy_used"]))) - $parse['energy_basic_income']);

$parse['speed'] = $game_config['resource_multiplier'];

// Metal maximum
if ($CurrentPlanet["metal_max"] < $CurrentPlanet["metal"]) {
	$parse['metal_max'] = '<font color="#ff0000">';
} else {
	$parse['metal_max'] = '<font color="#00ff00">';
}
$parse['metal_max'] .= pretty_number($CurrentPlanet["metal_max"] / 1) . " {$lang['']}</font>";
$parse['metal_max_js'] = str_replace(".", "", pretty_number($CurrentPlanet["metal_max"]));

// Cristal maximum
if ($CurrentPlanet["crystal_max"] < $CurrentPlanet["crystal"]) {
	$parse['crystal_max'] = '<font color="#ff0000">';
} else {
	$parse['crystal_max'] = '<font color="#00ff00">';
}
$parse['crystal_max'] .= pretty_number($CurrentPlanet["crystal_max"] / 1) . " {$lang['']}</font>";
$parse['crystal_max_js'] = str_replace(".", "", pretty_number($CurrentPlanet["crystal_max"]));

// Deuterium maximum
if ($CurrentPlanet["deuterium_max"] < $CurrentPlanet["deuterium"]) {
	$parse['deuterium_max'] = '<font color="#ff0000">';
} else {
	$parse['deuterium_max'] = '<font color="#00ff00">';
}
$parse['deuterium_max'] .= pretty_number($CurrentPlanet["deuterium_max"] / 1) . " {$lang['']}</font>";
$parse['deuterium_max_js'] = str_replace(".", "", pretty_number($CurrentPlanet["deuterium_max"]));

		// Message
		if ($CurrentUser['new_message'] > 0) {
			$parse['message'] = "<a href=\"?action=internalMessages\" style=\"text-decoration:blink\">[ ". $CurrentUser['new_message'] ." ]</a>";
		} else {
			$parse['message'] = "0";
		}

		// Le tout passe dans la template
		$TopBar = parsetemplate( $NavigationTPL, $parse);
	} else {
		$TopBar = "";
	}

	return $TopBar;
}

?>
