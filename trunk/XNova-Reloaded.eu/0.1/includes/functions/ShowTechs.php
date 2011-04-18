<?php
function ShowTechs ($CurrentUser, $CurrentPlanet, $BuildID) {
	global $dpath, $lang, $resource, $pricelist, $CombatCaps;

	includeLang('infos');

	$GateTPL              = '';
	$DestroyTPL           = '';
	$TableHeadTPL         = '';

	$parse                = $lang;
	// Données de base
	$parse['dpath']       = $dpath;
	$parse['name']        = $lang['info'][$BuildID]['name'];
	$parse['image']       = $BuildID;
	$parse['description'] = $lang['info'][$BuildID]['description'];


	if       ($BuildID >=   1 && $BuildID <=   3) {
		// Cas des mines
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_p_hour}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID ==   4) {
		// Centrale Solaire
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th></tr>";
	} elseif ($BuildID ==  12) {
		// Centrale Fusion
		$PageTPL              = gettemplate('info_buildings_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_deuter}</td><td class=\"c\">{nfo_difference}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
	} elseif ($BuildID >=  14 && $BuildID <=  32) {
		// Batiments Generaux
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  33) {
		// Batiments Terraformer
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  34) {
		// Dépot d'alliance
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  44) {
		// Silo de missiles
		$PageTPL              = gettemplate('info_buildings_general');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  41) {
		// Batiments lunaires
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID ==  42) {
		// Phalange
		$PageTPL              = gettemplate('info_buildings_table');
		$TableHeadTPL         = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_range}</td></tr>";
		$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_range}</th></tr>";
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID ==  43) {
		// Porte de Saut
		$PageTPL              = gettemplate('info_buildings_general');
		$GateTPL              = gettemplate('gate_fleet_table');
		$DestroyTPL           = gettemplate('info_buildings_destroy');
	} elseif ($BuildID >= 106 && $BuildID <= 199) {
		// Laboratoire
		$PageTPL              = gettemplate('info_buildings_general');
	} elseif ($BuildID >= 202 && $BuildID <= 215) {
		// Flotte
		$PageTPL              = gettemplate('info_buildings_fleet');
		$parse['element_typ'] = $lang['tech'][200];
		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
		$parse['capacity_pt'] = pretty_number ($pricelist[$BuildID]['capacity']); // Capacitée de fret
		$parse['base_speed']  = pretty_number ($pricelist[$BuildID]['speed']);    // Vitesse de base
		$parse['base_conso']  = pretty_number ($pricelist[$BuildID]['consumption']);  // Consommation de base
		if ($BuildID == 202) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
			$parse['upd_conso']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['consumption2']) .")</font>"; // Consommation apres rééquipement
		} elseif ($BuildID == 211) {
			$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";       // Vitesse rééquipée
		}
	} elseif ($BuildID >= 401 && $BuildID <= 408) {
		// Defenses
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];

		$parse['rf_info_to']  = ShowRapidFireTo ($BuildID);   // Rapid Fire vers
		$parse['rf_info_fr']  = ShowRapidFireFrom ($BuildID); // Rapid Fire de
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 502 && $BuildID <= 503) {
		// Misilles
		$PageTPL              = gettemplate('info_buildings_defense');
		$parse['element_typ'] = $lang['tech'][400];
		$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']); // Points de Structure
		$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);  // Points de Bouclier
		$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);  // Points d'Attaque
	} elseif ($BuildID >= 601 && $BuildID <= 615) {
		// Officiers
		$PageTPL              = gettemplate('info_officiers_general');
	}

	// ---- Tableau d'evolution
	if ($TableHeadTPL != '') {
		$parse['table_head']  = parsetemplate ($TableHeadTPL, $lang);
		$parse['table_data']  = ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $TableTPL);
	}

	// La page principale
	$page  = parsetemplate($PageTPL, $parse);
	if ($GateTPL != '') {
		if ($CurrentPlanet[$resource[$BuildID]] > 0) {
			$RestString               = GetNextJumpWaitTime ( $CurrentPlanet );
			$parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
			if ($RestString['value'] != 0) {
				$parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
				$parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
				$parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
			} else {
				$parse['gate_time_script'] = "";
				$parse['gate_wait_time']   = "";
				$parse['gate_script_go']   = "";
			}
			$parse['gate_dest_moons'] = BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet );
			$parse['gate_fleet_rows'] = BuildFleetListRows ( $CurrentPlanet );
			$page .= parsetemplate($GateTPL, $parse);
		}
	}

	if ($DestroyTPL != '') {
		if ($CurrentPlanet[$resource[$BuildID]] > 0) {
			// ---- Destruction
			$NeededRessources     = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $BuildID, true, true);
			$DestroyTime          = GetBuildingTime  ($CurrentUser, $CurrentPlanet, $BuildID) / 2;
			$parse['destroyurl']  = "?action=internalBuildings&amp;cmd=destroy&amp;building=".$BuildID; // Non balisé les balises sont dans le tpl
			$parse['levelvalue']  = $CurrentPlanet[$resource[$BuildID]] -1; // Niveau du batiment a detruire
			$parse['nfo_metal']   = $lang['Metal'];
			$parse['nfo_crysta']  = $lang['Crystal'];
			$parse['nfo_deuter']  = $lang['Deuterium'];
			$parse['metal']       = pretty_number ($NeededRessources['metal']);     // Cout en metal de la destruction
			$parse['crystal']     = pretty_number ($NeededRessources['crystal']);   // Cout en cristal de la destruction
			$parse['deuterium']   = pretty_number ($NeededRessources['deuterium']); // Cout en deuterium de la destruction
			$parse['destroytime'] = pretty_time   ($DestroyTime);                   // Durée de la destruction
			// L'insert de destruction
			$page .= parsetemplate($DestroyTPL, $parse);
		}
	}

	return $page;
}
?>