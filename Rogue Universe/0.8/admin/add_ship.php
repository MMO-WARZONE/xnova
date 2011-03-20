<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin/ship');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_ship");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$light_hunter       = $_POST['light_hunter'];
			$heavy_hunter    = $_POST['heavy_hunter'];
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
	    		$titan	       = $_POST['titan'];
	    		$battleship      = $_POST['battleship'];
	    		$supernova      = $_POST['supernova'];
	    		$mothership      = $_POST['mothership'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` + '". $small_ship_cargo ."', ";
			$QryUpdatePlanet .= "`battleship` = `battleship` + '". $battleship ."', ";
			$QryUpdatePlanet .= "`supernova` = `supernova` + '". $supernova ."', ";
			$QryUpdatePlanet .= "`mother_ship` = `mother_ship` + '". $mothership ."', ";
			$QryUpdatePlanet .= "`titan` = `titan` + '". $titan ."', ";
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
			$QryUpdatePlanet .= "`light_hunter` = `light_hunter` + '". $light_hunter ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_addship2'], $lang['add_ship_ttle'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>