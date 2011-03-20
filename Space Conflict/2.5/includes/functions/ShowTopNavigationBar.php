<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** ShowTopNavigationBar.php              **
******************************************/

function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $_GET;
	
//	CheckPlanetUsedFields ( $CurrentPlanet );
	
	if ($CurrentUser) {
		if ( !$CurrentPlanet ) {
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets', true);
		}

		PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );

		$NavigationTPL       = gettemplate('topnav');

		$dpath               = (!$CurrentUser["dpath"]) ? DEFAULT_SKINPATH : $CurrentUser["dpath"];
		$parse               = $lang;
		$parse['dpath']      = $dpath;
		$parse['image']      = $CurrentPlanet['image'];

		$parse['planetlist'] = '';
		$ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
			if ($CurPlanet["destruyed"] == 0) {
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet']) {
					$parse['planetlist'] .= "selected=\"selected\" ";
				}
				if ($CurPlanet['planet_type'] == 3){
					$parse['planetlist'] .= "class=\"moon\" value=\"?cp=".$CurPlanet['id']."";
					$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
					$parse['planetlist'] .= "&amp;re=0\">";
					$parse['planetlist'] .= "".$CurPlanet['name'];
					$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
					$parse['planetlist'] .= "".$CurPlanet['system'].":";
					$parse['planetlist'] .= "".$CurPlanet['planet'];
					$parse['planetlist'] .= "]&nbsp;&nbsp;</span></option>";
				}else{
					$parse['planetlist'] .= "class=\"planet\" value=\"?cp=".$CurPlanet['id']."";
					$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
					$parse['planetlist'] .= "&amp;re=0\">";
					$parse['planetlist'] .= "".$CurPlanet['name'];
					$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
					$parse['planetlist'] .= "".$CurPlanet['system'].":";
					$parse['planetlist'] .= "".$CurPlanet['planet'];
					$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
				}
			}
		}

		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);

		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}

		$metal = pretty_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] > $CurrentPlanet["metal_max"])) {
			$parse['metal'] = colorRed($metal);
		} else {
			$parse['metal'] = $metal;
		}

		$crystal = pretty_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] > $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = colorRed($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}

		$deuterium = pretty_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] > $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = colorRed($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}

		$tachyon = pretty_number($CurrentPlanet["tachyon"]);
		if (($CurrentPlanet["tachyon"] > $CurrentPlanet["tachyon_max"])) {
			$parse['tachyon'] = colorRed($tachyon);
		} else {
			$parse['tachyon'] = $tachyon;
		}


		if ($CurrentUser['new_message'] > 0) {
			$parse['message'] = "<a href=\"messages.php\">[ ". $CurrentUser['new_message'] ." ]</a>";
		} else {
			$parse['message'] = "0";
		}

        $rpg_points = pretty_number($CurrentUser["rpg_points"]);
        if (($CurrentPlanet["rpg_points"] > $CurrentPlanet["deuterium_max"])) {
			$parse['rpg_points'] = colorRed($rpg_points);
		} else {
			$parse['rpg_points'] = $rpg_points;
		}

		$TopBar = parsetemplate( $NavigationTPL, $parse);
	} else {
		$TopBar = "";
	}

	return $TopBar;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>