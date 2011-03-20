<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** add_ship.php                          **
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

		$PageTpl   = gettemplate("admin/add_ship");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$light_hunter       = $_POST['light_hunter'];
			$heavy_hunter    = $_POST['heavy_hunter'];
			$elite_fighter    = $_POST['elite_fighter'];
			$small_ship_cargo        = $_POST['small_ship_cargo'];
			$big_ship_cargo        = $_POST['big_ship_cargo'];
			$crusher    = $_POST['crusher'];
			$battle_ship        = $_POST['battle_ship'];
			$colonizer      = $_POST['colonizer'];
			$recycler        = $_POST['recycler'];
			$spy_sonde       = $_POST['spy_sonde'];
			$bomber_ship      = $_POST['bomber_ship'];
	    		$solar_satelit     = $_POST['solar_satelit'];
	    		$destructor       = $_POST['destructor'];
	    		$dearth_star       = $_POST['dearth_star'];
	    		$battleship      = $_POST['battleship'];
	    		$freighter      = $_POST['freighter'];
	    		$world_eater      = $_POST['world_eater'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` + '". $small_ship_cargo ."', ";
			$QryUpdatePlanet .= "`battleship` = `battleship` + '". $battleship ."', ";
			$QryUpdatePlanet .= "`dearth_star` = `dearth_star` + '". $dearth_star ."', ";
			$QryUpdatePlanet .= "`destructor` = `destructor` + '". $destructor ."', ";
			$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` + '". $solar_satelit ."', ";
			$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` + '". $bomber_ship ."', ";
			$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` + '". $spy_sonde ."', ";
			$QryUpdatePlanet .= "`recycler` = `recycler` + '". $recycler ."', ";
			$QryUpdatePlanet .= "`colonizer` = `colonizer` + '". $colonizer ."', ";
			$QryUpdatePlanet .= "`battle_ship` = `battle_ship` + '". $battle_ship ."', ";
			$QryUpdatePlanet .= "`crusher` = `crusher` + '". $crusher ."', ";
			$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` + '". $heavy_hunter ."', ";
			$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` + '". $big_ship_cargo ."', ";
			$QryUpdatePlanet .= "`light_hunter` = `light_hunter` + '". $light_hunter ."', ";
			$QryUpdatePlanet .= "`elite_fighter` = `elite_fighter` + '". $elite_fighter ."', ";
			$QryUpdatePlanet .= "`freighter` = `freighter` + '". $freighter ."', ";
			$QryUpdatePlanet .= "`world_eater` = `world_eater` + '". $world_eater ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_addship2'], $lang['adm_addship1'] );
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