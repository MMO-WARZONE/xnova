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

if(filesize($xgp_root . 'config.php') == 0 && INSTALL != true)
{
	exit ( header ( "location:" . $xgp_root .  "install/" ) );
}

$phpEx			= "php";
$game_config   	= array();
$user          	= array();
$lang          	= array();
$link          	= "";
$IsUserChecked 	= false;

include_once($xgp_root . 'includes/constants.'.$phpEx);
include_once($xgp_root . 'includes/GeneralFunctions.'.$phpEx);
include_once($xgp_root . 'includes/classes/class.debug.'.$phpEx);
$debug 		= new debug();

if (INSTALL != true)
{
	include($xgp_root . 'includes/vars.'.$phpEx);
	include($xgp_root . 'includes/functions/RoundUp.' . $phpEx);
	include($xgp_root . 'includes/functions/CreateOneMoonRecord.'.$phpEx);
	include($xgp_root . 'includes/functions/CreateOnePlanetRecord.'.$phpEx);
	include($xgp_root . 'includes/functions/SendSimpleMessage.'.$phpEx);
	include($xgp_root . 'includes/functions/calculateAttack.'.$phpEx);
	include($xgp_root . 'includes/functions/formatCR.'.$phpEx);
	include($xgp_root . 'includes/functions/GetBuildingTime.' . $phpEx);
	include($xgp_root . 'includes/functions/HandleElementBuildingQueue.' . $phpEx);
	include($xgp_root . 'includes/functions/PlanetResourceUpdate.' . $phpEx);

	$query = doquery("SELECT * FROM {{table}}",'config');

	while ($row = mysql_fetch_assoc($query))
	{
		$game_config[$row['config_name']] = $row['config_value'];
	}

	define('DEFAULT_LANG'	, (	$game_config['lang'] 	== ''	) ? "spanish" : 	$game_config['lang']	);
	define('VERSION'		, (	$game_config['VERSION'] == ''	) ? "		" : "v".$game_config['VERSION']	);

	includeLang('INGAME');

	if ($InLogin != true)
	{
		include($xgp_root . 'includes/classes/class.CheckSession.'.$phpEx);

		$Result        	= new CheckSession();
		$Result			= $Result->CheckUser($IsUserChecked);
		$IsUserChecked 	= $Result['state'];
		$user          	= $Result['record'];

		if($game_config['game_disable'] == 0 && $user['authlevel'] == 0)
		{
			message(stripslashes($game_config['close_reason']), '', '', false, false);
		}
	}

	if ( ( time() >= ( $game_config['stat_last_update'] + ( 60 * $game_config['stat_update_time'] ) ) ) )
	{
		include($xgp_root . 'adm/statfunctions.' . $phpEx);
		$result		= MakeStats();
		update_config('stat_last_update', $result['stats_time']);
	}

	if (isset($user))
	{
		include($xgp_root . 'includes/classes/class.FlyingFleetHandler.'.$phpEx);
		$_fleets = doquery("SELECT fleet_start_galaxy,fleet_start_system,fleet_start_planet,fleet_start_type FROM {{table}} WHERE `fleet_start_time` <= '".time()."' and `fleet_mess` ='0' order by fleet_id asc;", 'fleets'); // OR fleet_end_time <= ".time()

		while ($row = mysql_fetch_array($_fleets))
		{
			$array = array();
			$array['galaxy'] 		= $row['fleet_start_galaxy'];
			$array['system'] 		= $row['fleet_start_system'];
			$array['planet'] 		= $row['fleet_start_planet'];
			$array['planet_type'] 	= $row['fleet_start_type'];

			$temp = new FlyingFleetHandler ($array);
		}
		mysql_free_result($_fleets);
		$_fleets = doquery("SELECT fleet_end_galaxy,fleet_end_system,fleet_end_planet ,fleet_end_type FROM {{table}} WHERE `fleet_end_time` <= '".time()." order by fleet_id asc';", 'fleets'); // OR fleet_end_time <= ".time()

		while ($row = mysql_fetch_array($_fleets))
		{
			$array = array();
			$array['galaxy'] 		= $row['fleet_end_galaxy'];
			$array['system'] 		= $row['fleet_end_system'];
			$array['planet'] 		= $row['fleet_end_planet'];
			$array['planet_type'] 	= $row['fleet_end_type'];

			$temp = new FlyingFleetHandler ($array);
		}

		mysql_free_result($_fleets);
		unset($_fleets);

		if ( defined('IN_ADMIN') )
		{
			includeLang('ADMIN');
			include('../adm/AdminFunctions/Autorization.' . $phpEx);
			$dpath     = "../". DEFAULT_SKINPATH  ;
		}
		else
		{
			$dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
		}

		include($xgp_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
		SetSelectedPlanet ($user);

		$planetrow = doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$user['current_planet']."';", "planets", true);

		include($xgp_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
		CheckPlanetUsedFields($planetrow);
		include($xgp_root . 'includes/mod_plug.' . $phpEx);
		$mod_plug = new modPl();
		$mod_plug->run(); $mod_plug->run('SettingsPage', 'page');
	}
}
else
{
	$dpath     = "../" . DEFAULT_SKINPATH;
}


?>
