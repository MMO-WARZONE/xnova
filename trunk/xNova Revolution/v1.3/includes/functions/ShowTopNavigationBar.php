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

	function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
	{
		global $lang, $game_config, $dpath;

		if($CurrentUser['urlaubs_modus'] == 0)
			PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		else
			doquery("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0, `darkmatter_mine_porcent` = 0 WHERE id_owner = ".$CurrentUser['id'],"planets");

		$parse				 			= $lang;
		$parse['dpath']      			= $dpath;
		$parse['image']      			= $CurrentPlanet['image'];
		if ($CurrentUser['rpg_geologue'] > 0 ) {
                   $parse['geologo'] = "geologue.gif";
                } else {
                   $parse['geologo'] = "geologue_un.gif";
                }
                if ($CurrentUser['rpg_amiral'] > 0 ) {
                   $parse['admirante'] = "admiral.gif";
                } else {
                   $parse['admirante'] = "amiral_un.gif";
                }
                if ($CurrentUser['rpg_empereur'] > 0 ) {
                   $parse['comandante'] = "empereur.gif";
                } else {
                   $parse['comandante'] = "empereur_un.gif";
                }
                if ($CurrentUser['rpg_ingenieur'] > 0 ) {
                   $parse['ingeniero'] = "ingenieur.gif";
                } else {
                   $parse['ingeniero'] = "ingenieur_un.gif";
                }
                if ($CurrentUser['rpg_technocrate'] > 0 ) {
                   $parse['tecnocrata'] = "technocrate.gif";
                } else {
                   $parse['tecnocrata'] = "technocrate_un.gif";
                } 

		if($CurrentUser['urlaubs_modus'] && $CurrentUser['db_deaktjava'])
		{
		$parse['show_umod_notice']      	.= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
	}
		else
		{
			$parse['show_umod_notice']       = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 2px solid #1DF0F0; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table><br>' : '';
			$parse['show_umod_notice']      .= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
		}

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
	    // Materia Oscura
		$darkmatter = pretty_number($CurrentPlanet["darkmatter"]);
		if (($CurrentPlanet["darkmatter"] >= $CurrentPlanet["darkmatter_max"])) {
			$parse['darkmatter'] = colorRed($darkmatter);
		} else {
			$parse['darkmatter'] = $darkmatter;
		}
        //$parse['darkmatter'] 		= pretty_number($CurrentUser["darkmatter"]);
        $parse['creditos'] 		= pretty_number($CurrentUser["creditos"]);
		$parse['user_username']     = $CurrentUser['username'];
		$parse['date_time'] = date("D M j H:i:s", time());
		$parse['metal_max']  = pretty_number($CurrentPlanet['metal_max']);
        $parse['crystal_max']  = pretty_number($CurrentPlanet['crystal_max']);
        $parse['deuterium_max']  = pretty_number($CurrentPlanet['deuterium_max']);  
        $parse['dearkmatter_max']  = pretty_number($CurrentPlanet['darkmatter_max']);
		$parse['metal_basic_income']     = $game_config['metal_basic_income']     * $game_config['resource_multiplier'];
	    $parse['crystal_basic_income']   = $game_config['crystal_basic_income']   * $game_config['resource_multiplier'];
	    $parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'] * $game_config['resource_multiplier'];
	    $parse['darkmatter_basic_income'] = $game_config['darkmatter_basic_income'] * $game_config['resource_multiplier'];
	    $parse['energy_basic_income']    = $game_config['energy_basic_income']    * $game_config['resource_multiplier'];
        $parse['user_username']     = $CurrentUser['username'];
        $TopBar 			 		= parsetemplate(gettemplate('topnav'), $parse);

		return $TopBar;
	}
?>
