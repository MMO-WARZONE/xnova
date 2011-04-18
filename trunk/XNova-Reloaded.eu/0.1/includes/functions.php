<?php

/**
 * functions.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------
//
// Routine pour la gestion du mode vacance
//
function check_urlaubmodus ($user) {
	if ($user['urlaubs_modus'] == 1) {
		message("Sie Sind in Urlaubs Modus!", $title = $user['username'], $dest = "", $time = "3");
	}
}

function check_urlaubmodus_time () {
	global $user, $game_config;
	if ($game_config['urlaubs_modus_erz'] == 1) {
		$begrenzung = 86400; //24x60x60= 24h
		$iduser = $user["id"];
		$urlaub_modus_time = $user['urlaubs_modus_time'];
		$urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
		$time_jetzt = time();
		if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
			$soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
			$soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
		message("sie sind in urlaubsmodus!<br>Urlaub dauert bis $soll_datum $soll_uhrzeit<br>	in diesen zeitraum k&ouml;nnen sie nichs machen..", "Urlaubs modus");
		}
		elseif ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll < $time_jetzt) {
			doquery("UPDATE {{table}} SET
				`urlaubs_modus` = '0',
				`urlaubs_modus_time` = '0'
				WHERE `id` = '$iduser' LIMIT 1", "users");
		}
	}
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Test de validité d'une adresse email
//
function is_email($email)
 {
  $email = htmlspecialchars($email); // eMail-Adresse
  if(!preg_match('/^([A-Za-z0-9\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]){1,64}\@{1}([A-Za-z0-9\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]){1,248}\.{1}([a-z]){2,6}$/', $email))
   return FALSE;
  list($teil1, $teil2) = explode('@', $email, 2);
  if(@!fsockopen($teil2, 80))
   return FALSE;
  
  return TRUE; 
 }

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message administrateur avec saut vers une autre page si souhaité
//
function AdminMessage ($mes, $title = 'Error', $dest = "", $time = "3") {
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes']   = $mes;

	$page .= parsetemplate(gettemplate('admin/message_body'), $parse);

	display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), true);
}
//InstallerMessage
function InstallerMessage ($mes, $title = 'Error', $dest = "", $time = "3") {
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes']   = $mes;

	$page .= parsetemplate(gettemplate('admin/message_body'), $parse);

	display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), true, true);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message avec saut vers une autre page si souhaité
//
function message ($mes, $title = 'Error', $dest = "", $time = "3") {
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes']   = $mes;

	$page .= parsetemplate(gettemplate('message_body'), $parse);
	if(!empty($dest)) {
		$meta = "<meta http-equiv=\"refresh\" content=\"".$time."; '".$dest."';\">";
	}
	else {
		$meta = "";
	}

	display ($page, $title, false, $meta , false);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine d'affichage d'une page dans un cadre donné
//
// $page      -> la page
// $title     -> le titre de la page
// $topnav    -> Affichage des ressources ? oui ou non ??
// $metatags  -> S'il y a quelques actions particulieres a faire ...
// $AdminPage -> Si on est dans la section admin ... faut le dire ...
function display ($page, $title = '', $topnav = true, $metatags = '', $AdminPage = false, $Installer = false) {
	global $link, $game_config, $debug, $user, $planetrow;
	
	$title = $game_config['game_name']." ".$title;
	if ($Installer){
		$DisplayPage  = InstallerHeader ($title, $metatags);
	}
	elseif (!$AdminPage) {
		$DisplayPage  = StdUserHeader ($title, $metatags);
	} else {
		$DisplayPage  = AdminUserHeader ($title, $metatags);
	}

	include(XNOVA_ROOT_PATH . 'pages/leftmenu.php');
	include(XNOVA_ROOT_PATH . 'pages/admin/leftmenu.php');
	
	if(!defined('LEFTMENU_NICHT_ANZEIGEN'))
	$DisplayPage .= ShowLeftMenu ( $user['authlevel'] );
	
	if(defined('ADMINMENU_ANZEIGEN'))
	$DisplayPage .= ShowAdminMenu ( $user['authlevel'] );
	
	if(!defined('KEIN_SCROLLDIV'))
	$DisplayPage .= "<div class=\"scrolldiv\">";
	
	if ($topnav) {

		if ($user['aktywnosc'] == 1) {
			$urlaub_act_time = $user['time_aktyw'];
			$act_datum = date("d.m.Y", $urlaub_act_time);
			$act_uhrzeit = date("H:i:s", $urlaub_act_time);
		$DisplayPage .= "Le mode del dure jusque $act_datum $act_uhrzeit<br>	Ce n'est qu'après cette période que vous pouvez changer vos options.";
		}

		if ($user['db_deaktjava'] == 1) {
			$urlaub_del_time = $user['deltime'];
			$del_datum = date("d.m.Y", $urlaub_del_time);
			$del_uhrzeit = date("h:i:s", $urlaub_del_time);
		$DisplayPage .= "Account L&ouml;schung aktiviert!<br>Ihr Account wird am $del_datum $del_uhrzeit Ge&ouml;scht!.";
		}

		$DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
	}
	
	// Affichage du Debug si necessaire
	if ($user['authlevel'] == 1 || $user['authlevel'] == 3) {
		if ($game_config['debug'] == 1) $debug->echo_log();
	}

	
	if (isset($link)) {
		mysql_close();
	}

	
	
	//$DisplayPage .= "<center>\n". $page ."\n</center>\n";
	$DisplayPage .= "$page</div>"; //<center> muss manuell in jeder tpl gesetzt werden
	$DisplayPage .= StdFooter();
	
	echo $DisplayPage;

	die();
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page
//
function StdUserHeader ($title = '', $metatags = '') {
	global $user, $dpath, $langInfos;

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse           = $langInfos;
	$parse['dpath']  = $dpath;
	$parse['title']  = $title;
	$parse['-meta-'] = ($metatags) ? $metatags : "";
	$parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
	return parsetemplate(gettemplate('simple_header'), $parse);
}
//Installer Header
function InstallerHeader ($title = '', $metatags = '') {
	global $user, $dpath, $langInfos;

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse           = $langInfos;
	$parse['dpath']  = $dpath;
	$parse['title']  = $title;
	$parse['-meta-'] = ($metatags) ? $metatags : "";
	$parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
	return parsetemplate(gettemplate('install/simple_header'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page administration
//
function AdminUserHeader ($title = '', $metatags = '') {
	global $user, $dpath, $langInfos;

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse           = $langInfos;
	$parse['dpath']  = $dpath;
	$parse['title']  = $title;
	$parse['-meta-'] = ($metatags) ? $metatags : "";
	$parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
	return parsetemplate(gettemplate('admin/simple_header'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Pied de page
//
function StdFooter() {
	global $game_config, $lang;
	$parse['copyright']     = $game_config['copyright'];
	$parse['TranslationBy'] = $lang['TranslationBy'];
	return parsetemplate(gettemplate('overall_footer'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Calcul de la place disponible sur une planete
//
function CalculateMaxPlanetFields (&$planet) {
	global $resource;

	if($planet["planet_type"] != 3) {
	return $planet["field_max"] + ($planet[ $resource[33] ] * 5);
	}
	elseif($planet["planet_type"] == 3) {
	return $planet["field_max"] + ($planet[ $resource[41] ] * 3);
	}
}
function autounban() {
	global $DB;
	foreach($DB->query("SELECT * FROM ".PREFIX."banned") as $Row) {
		if($Row['longer'] < time() OR $Row['longer'] == time()) { //wenn die Bannzeit um ist
			$DB->query("UPDATE ".PREFIX."users SET bana = '0', banaday = '0' WHERE username = '".$Row['who']."';"); //Spieler entsperren
			$DB->query("DELETE FROM ".PREFIX."banned WHERE who = '".$Row['who']."'");//und aus der Banned Tabelle löschen.
		}
	}
}
//aus infos.php

// ----------------------------------------------------------------------------------------------------------
// Creation de la Liste de flotte disponible sur la lune
//

function BuildFleetListRows ( $CurrentPlanet ) {
	global $resource, $lang;

	$RowsTPL  = gettemplate('gate_fleet_rows');
	$CurrIdx  = 1;
	$Result   = "";
	for ($Ship = 300; $Ship > 200; $Ship-- ) {
		if ($resource[$Ship] != "") {
			if ($CurrentPlanet[$resource[$Ship]] > 0) {
				$bloc['idx']             = $CurrIdx;
				$bloc['fleet_id']        = $Ship;
				$bloc['fleet_name']      = $lang['tech'][$Ship];
				$bloc['fleet_max']       = pretty_number ( $CurrentPlanet[$resource[$Ship]] );
				$bloc['gate_ship_dispo'] = $lang['gate_ship_dispo'];
				$Result                 .= parsetemplate ( $RowsTPL, $bloc );
				$CurrIdx++;
			}
		}
	}
	return $Result;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de la combo de selection de Lune d'arrivé
//
function BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet ) {
	global $resource;
	$QrySelectMoons  = "SELECT * FROM {{table}} WHERE `planet_type` = '3' AND `id_owner` = '". $CurrentUser['id'] ."';";
	$MoonList        = doquery ( $QrySelectMoons, 'planets');
	$Combo           = "";
	while ( $CurMoon = mysql_fetch_assoc($MoonList) ) {
		if ( $CurMoon['id'] != $CurrentPlanet['id'] ) {
			$RestString = GetNextJumpWaitTime ( $CurMoon );
			if ( $CurMoon[$resource[43]] >= 1) {
				$Combo .= "<option value=\"". $CurMoon['id'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
			}
		}
	}
	return $Combo;
}

// ----------------------------------------------------------------------------------------------------------
// Creation du tableau de production de ressources
// Tient compte du parametrage de la planete (si la production n'est pas affectée a 100% par exemple
// Tient compte aussi du multiplicateur de ressources
//
function ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $Template) {
	global $ProdGrid, $resource, $game_config;

	$BuildLevelFactor = $CurrentPlanet[ $resource[$BuildID]."_porcent" ];
	$BuildTemp        = $CurrentPlanet[ 'temp_max' ];
	$CurrentBuildtLvl = $CurrentPlanet[ $resource[$BuildID] ];

	$BuildLevel       = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
	$Prod[1]          = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[2]          = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[3]          = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
	$Prod[4]          = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
	$BuildLevel       = "";

	$ActualProd       = floor($Prod[$BuildID]);
	if ($BuildID != 12) {
		$ActualNeed       = floor($Prod[4]);
	} else {
		$ActualNeed       = floor($Prod[3]);
	}

	$BuildStartLvl    = $CurrentBuildtLvl - 2;
	if ($BuildStartLvl < 1) {
		$BuildStartLvl = 1;
	}
	$Table     = "";
	$ProdFirst = 0;
	for ( $BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 10; $BuildLevel++ ) {
		if ($BuildID != 42) {
			$Prod[1] = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			$Prod[2] = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			$Prod[3] = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));

			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			if ($ProdFirst > 0) {
				if ($BuildID != 12) {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[$BuildID] - $ProdFirst)) .")</font>";
				} else {
					$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[4] - $ProdFirst)) .")</font>";
				}
			} else {
				$bloc['build_gain']      = "";
			}
			if ($BuildID != 12) {
				$bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[4])) );
				$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
			} else {
				$bloc['build_prod']      = pretty_number(floor($Prod[4]));
				$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualProd)) );
				$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
				$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
			}
			if ($ProdFirst == 0) {
				if ($BuildID != 12) {
					$ProdFirst = floor($Prod[$BuildID]);
				} else {
					$ProdFirst = floor($Prod[4]);
				}
			}
		} else {
			// Cas particulier de la phalange
			$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
			$bloc['build_range']     = ($BuildLevel * $BuildLevel) - 1;
		}
		$Table    .= parsetemplate($Template, $bloc);
	}

	return $Table;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire contre ...
//
function ShowRapidFireTo ($BuildID) {
	global $lang, $CombatCaps;
	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$BuildID]['sd'][$Type] > 1) {
			$ResultString .= $lang['nfo_rf_again']. " ". $lang['tech'][$Type] ." <font color=\"#00ff00\">".$CombatCaps[$BuildID]['sd'][$Type]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de l'information des RapidFire de ...
//
function ShowRapidFireFrom ($BuildID) {
	global $lang, $CombatCaps;

	$ResultString = "";
	for ($Type = 200; $Type < 500; $Type++) {
		if ($CombatCaps[$Type]['sd'][$BuildID] > 1) {
			$ResultString .= $lang['nfo_rf_from']. " ". $lang['tech'][$Type] ." <font color=\"#ff0000\">".$CombatCaps[$Type]['sd'][$BuildID]."</font><br>";
		}
	}
	return $ResultString;
}

// ----------------------------------------------------------------------------------------------------------
// Construit la page par rapport a l'information demandée ...
// Permet de faire la differance entre les divers types et les pages speciales
//
function ShowBuildingInfoPage ($CurrentUser, $CurrentPlanet, $BuildID) {
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
			$parse['destroyurl']  = "?action=internalBuildings&amp;cmd=destroy&building=".$BuildID; // Non balisé les balises sont dans le tpl
			$parse['levelvalue']  = $CurrentPlanet[$resource[$BuildID]]; // Niveau du batiment a detruire
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

function countdown($typ, $resttime, $Linkziel) {
	
	switch ($Linkziel) {
		case'Kontrollzentrum': $Datei = 'indexGame.php?action=internalHome'; break;
		default: $Datei = 'indexGame.php?action=internalHome'; break;
	}
	
    $script = '<span class="actions_text" id="countDown'.$typ.'Text"></span>
    <script type="text/javascript">

          var countDown'.$typ.' = '.$resttime.';
          var timestamp'.$typ.'=countDown'.$typ.';
        function countDown_'.$typ.'()
                {
          sekunden = timestamp'.$typ.';
          monate = Math.floor(sekunden/2419200);
          sekunden-=monate*2419200;

          tage = Math.floor(sekunden/86400);
          sekunden-=tage*86400;

          stunden=Math.floor(sekunden/3600);
          sekunden-=stunden*3600;

          minuten=Math.floor(sekunden/60);
          sekunden-=minuten*60;


            if(stunden < 10) stunden = "0"+stunden;
            if(sekunden < 10) sekunden = "0"+sekunden;
            if(minuten < 10) minuten = "0"+minuten;
 var bt = "'.$typ.'"=="epoche"?"":"";


monate = (monate > 0) ? monate+" m " : "";

tage = (tage > 0) ? tage+" t " : "";
stunden = (stunden > 0) ? stunden+":" : "";
minuten = (minuten > 0) ? minuten+":" : "00:";
sekunden = (sekunden > 0) ? sekunden : "00";
text = bt + monate+tage+stunden+minuten+sekunden;


      if (timestamp'.$typ.' < 1)
                {
                    document.getElementById("countDown'.$typ.'Text").innerHTML = "<font color=lime>Fertig!</font>";
					window.location.href = "'.$Datei.'";
                    return;
                }
            else
                {
                    timestamp'.$typ.'--;
                    document.getElementById("countDown'.$typ.'Text").innerHTML = text;
                    setTimeout("countDown_'.$typ.'()", 1000);
                }
        }
            countDown_'.$typ.'();
    </script>';
    return $script;
}

function Nr2Str ( $nr, $precision = 0, $fixed = 0 ) {
	global $lang;

	if ( ! isset($lang['DECIMAL_POINT']) ) { $lang['DECIMAL_POINT'] = '.'; }
	if ( ! isset($lang['THOUSAND_SEP']) ) { $lang['THOUSAND_SEP'] = ','; }

	// add leading 0s if fixed number of digits is given
	if ( $fixed > 0 ) {
		return sprintf("%0{$fixed}u", $nr);
	}

	// str_replace is needed to prevent word wrapping
	return str_replace(' ', '&nbsp;', number_format($nr, $precision, $lang['DECIMAL_POINT'], $lang['THOUSAND_SEP']));
}

?>