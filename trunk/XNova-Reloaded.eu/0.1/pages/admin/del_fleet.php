<?php

/**
 * del_fleet.php
 *
 * @version 1.0
 * @copyright 2008 by Tom1991 for XNova
 *
 *fixed by Steggi for Xnova-Reloaded.de
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

if ($user['authlevel'] >= 2) {

includeLang('admin/del_fleet');

$parse	= $lang;

$mode = $_POST['mode'];

	if($mode == 'del')
	{
	    $id					= $_POST['id'];
	    $light_hunter		= $_POST['light_hunter'];
	    $heavy_hunter		= $_POST['heavy_hunter'];
	    $small_ship_cargo	= $_POST['small_ship_cargo'];
	    $big_ship_cargo		= $_POST['big_ship_cargo'];
	    $crusher			= $_POST['crusher'];
	    $battle_ship		= $_POST['battle_ship'];
	    $colonizer			= $_POST['colonizer'];
	    $recycler			= $_POST['recycler'];
	    $spy_sonde			= $_POST['spy_sonde'];
	    $bomber_ship		= $_POST['bomber_ship'];
	    $solar_satelit		= $_POST['solar_satelit'];
	    $destructor			= $_POST['destructor'];
	    $dearth_star		= $_POST['dearth_star'];
	    $battleship			= $_POST['battleship'];


        $SqlAdd = "UPDATE {{table}} SET";
        $SqlAdd .= "`light_hunter` = '".$light_hunter."-light_hunter', ";
        $SqlAdd .= "`heavy_hunter` = '".$heavy_hunter."-heavy_hunter', ";
        $SqlAdd .= "`small_ship_cargo` = '".$small_ship_cargo."-small_ship_cargo', ";
        $SqlAdd .= "`big_ship_cargo` = '".$gt."-big_ship_cargo', ";
		$SqlAdd .= "`crusher` = '".$crusher."-crusher', ";
		$SqlAdd .= "`battle_ship` = '".$battle_ship."-battle_ship', ";
		$SqlAdd .= "`colonizer` = '".$colonizer."-colonizer', ";
		$SqlAdd .= "`recycler` = '".$recycler."-recycler', ";
		$SqlAdd .= "`spy_sonde`= '".$spy_sonde."-spy_sonde', ";
		$SqlAdd .= "`bomber_ship` = '".$bomber_ship."-bomber_ship', ";
		$SqlAdd .= "`solar_satelit` = '".$solar_satelit."-solar_satelit', ";
		$SqlAdd .= "`destructor` = '".$destructor."-destructor', ";
		$SqlAdd .= "`dearth_star` = '".$dearth_star."-dearth_star', ";
		$SqlAdd .= "`battleship` = '".$battleship."-battleship' ";
		$SqlAdd .= " WHERE `id` = '".$id."' LIMIT 1";

		doquery( $SqlAdd, "planets");

		message('Die Schiffe wurden gel&ouml;scht');


	}

	display(parsetemplate(gettemplate('admin/del_fleet'), $parse), '', false);
	
	}
	else
	header('Location: indexGame.php');

?>