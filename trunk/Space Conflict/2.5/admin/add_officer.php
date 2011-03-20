<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** add_officer.php                       **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_officer");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$rpg_indy       = $_POST['rpg_indy'];
			$rpg_bunker    = $_POST['rpg_bunker'];
			$rpg_acad        = $_POST['rpg_acad'];
			$rpg_conq        = $_POST['rpg_conq'];
			$rpg_raideur    = $_POST['rpg_raideur'];
			$rpg_empereur        = $_POST['rpg_empereur'];
			$rpg_geologue      = $_POST['rpg_geologue'];
			$rpg_amiral        = $_POST['rpg_amiral'];
			$rpg_ingenieur       = $_POST['rpg_ingenieur'];
			$rpg_technocrate      = $_POST['rpg_technocrate'];
	    	$rpg_constructeur     = $_POST['rpg_constructeur'];
	    	$rpg_scientifique       = $_POST['rpg_scientifique'];
	    	$rpg_stockeur       = $_POST['rpg_stockeur'];
			$rpg_defenseur     = $_POST['rpg_defenseur'];
			$rpg_espion     = $_POST['rpg_espion'];
			$rpg_commandant      = $_POST['rpg_commandant'];
			$rpg_destructeur      = $_POST['rpg_destructeur'];
			$rpg_general      = $_POST['rpg_general'];
			$rpg_quantum      = $_POST['rpg_quantum'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`rpg_indy` = `rpg_indy` + '". $rpg_indy ."', ";
			$QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` + '". $rpg_bunker ."', ";
			$QryUpdatePlanet .= "`rpg_acad` = `rpg_acad` + '". $rpg_acad ."', ";
			$QryUpdatePlanet .= "`rpg_conq` = `rpg_conq` + '". $rpg_conq ."', ";
			$QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` + '". $rpg_raideur ."', ";
			$QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` + '". $rpg_empereur ."', ";
			$QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` + '". $rpg_geologue ."', ";
			$QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` + '". $rpg_amiral ."', ";
			$QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` + '". $rpg_ingenieur ."', ";
			$QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` + '". $rpg_technocrate ."', ";
			$QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` + '". $rpg_constructeur ."', ";
			$QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` + '". $rpg_scientifique ."', ";
			$QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` + '". $rpg_stockeur ."', ";
			$QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` + '". $rpg_defenseur ."', ";
			$QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` + '". $rpg_espion ."', ";
			$QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` + '". $rpg_commandant ."', ";
			$QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` + '". $rpg_destructeur ."', ";
			$QryUpdatePlanet .= "`rpg_general` = `rpg_general` + '". $rpg_general ."', ";
			$QryUpdatePlanet .= "`rpg_quantum` = `rpg_quantum` + '". $rpg_quantum ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "users");

			AdminMessage ( $lang['adm_addofficer2'], $lang['adm_addofficer1'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>