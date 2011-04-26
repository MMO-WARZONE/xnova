<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

	function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
	{
		global $lang, $game_config, $dpath;

		if($CurrentUser['urlaubs_modus'] == 0)
			PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		else
			doquery("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".$CurrentUser['id'],"planets");

		$parse				 			= $lang;
		$parse['dpath']      			= $dpath;
		$parse['image']      			= $CurrentPlanet['image'];
		$parse['show_umod_notice']  	= $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 3px solid red; text-align:center;"><tr><td>' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table>' : '';
		$parse['show_umod_notice']		= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 3px solid red; text-align:center;"><tr><td>' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
		$parse['planetlist'] 			= '';
		$ThisUsersPlanets    			= SortUserPlanets ( $CurrentUser );

		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets))
		{
			if ($CurPlanet["destruyed"] == 0)
			{
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet'])
					$parse['planetlist'] .= "selected=\"selected\" ";
				$parse['planetlist'] .= "value=\"game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$CurPlanet['id']."";
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";
				if($CurPlanet['planet_type'] != 3)
					$parse['planetlist'] .= "".$CurPlanet['name'];
				else
					$parse['planetlist'] .= "".$CurPlanet['name'] . " (" . $lang['fcm_moon'] . ")";
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
			}
		}

		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = colorRed($energy);
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$metal = pretty_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"])) {
			$parse['metal'] = colorRed($metal);
		} else {
			$parse['metal'] = $metal;
		}
		// Cristal
		$crystal = pretty_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = colorRed($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}
		// Deuterium
		$deuterium = pretty_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = colorRed($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}
		$parse['darkmatter'] 		= pretty_number($CurrentUser["darkmatter"]);
		$parse['metal_max'] .= pretty_number($CurrentPlanet["metal_max"] / 1);
		$parse['crystal_max'] .= pretty_number($CurrentPlanet["crystal_max"] / 1);
		$parse['deuterium_max'] .= pretty_number($CurrentPlanet["deuterium_max"] / 1);

		$parse['metal_perhour'] .= $CurrentPlanet["metal_perhour"] + ($game_config['metal_basic_income'] * $game_config['resource_multiplier']);
		$parse['crystal_perhour'] .= $CurrentPlanet["crystal_perhour"] + ($game_config['crystal_basic_income'] * $game_config['resource_multiplier']);
		$parse['deuterium_perhour'] .= $CurrentPlanet["deuterium_perhour"] + ($game_config['deuterium_basic_income'] * $game_config['resource_multiplier']);

		$parse['metalh'] .= round($CurrentPlanet["metal"]);
		$parse['crystalh'] .= round($CurrentPlanet["crystal"]);
		$parse['deuteriumh'] .= round($CurrentPlanet["deuterium"]);

		$parse['metal_mmax'] .= $CurrentPlanet["metal_max"] * MAX_OVERFLOW;
		$parse['crystal_mmax'] .= $CurrentPlanet["crystal_max"] * MAX_OVERFLOW;
		$parse['deuterium_mmax'] .= $CurrentPlanet["deuterium_max"] * MAX_OVERFLOW;
		$TopBar 			 		= parsetemplate(gettemplate('topnav'), $parse);

		return $TopBar;
	}
?>