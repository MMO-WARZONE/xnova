<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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

if(@filesize($xgp_root . 'config.php') == 0 && INSTALL != true)
{
	exit ( header ( "location:" . $xgp_root .  "install/" ) );
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$phpEx			= "php";
$game_config   	= array();
$user          	= array();
$lang          	= array();
$link          	= "";
$IsUserChecked 	= false;

	if(!defined("NO_IDS") and !defined('IN_ADMIN')){
		if(defined("INPUT_STRANGE") and INPUT_STRANGE === true){
			foreach($_POST as $Key => $Value){
				if(is_string($Value)){
					$_POST[$Key] = str_replace('<', '&lt;', strip_tags($Value));
					$_POST[$Key] = str_replace(">", '&gt;', strip_tags($Value));
					$_POST[$Key] = str_replace('"', '&quot;', strip_tags($Value));
					$_POST[$Key] = str_replace("'", '&apos;', strip_tags($Value));
				}
			}
			foreach($_GET as $Key => $Value){
				
				if(is_string($Value)){
					$_GET[$Key] = str_replace('<', '&lt;', strip_tags($Value));
					$_GET[$Key] = str_replace(">", '&gt;', strip_tags($Value));
					$_GET[$Key] = str_replace('"', '&quot;', strip_tags($Value));
					$_GET[$Key] = str_replace("'", '&apos;', strip_tags($Value));
				}
			}
		}
		set_include_path(
		   get_include_path()
		   . PATH_SEPARATOR
		   . $xgp_root
		  );
		require_once ('IDS/Init.php');
		$request = array(
			  'GET' => $_GET,
			  'POST' => $_POST,
		);
		  $init = IDS_Init::init($xgp_root.'IDS/Config/Config.ini.php');
		  $init->config['General']['base_path'] = $xgp_root.'IDS/';
		  $init->config['General']['use_base_path'] = true;
		  $init->config['Caching']['caching'] = 'none';
		  $ids = new IDS_Monitor($request, $init);
		  $result = $ids->run();

		  if (!$result->isEmpty()) {  
			$AttackImpact = $result->getImpact();
		  }else{
			$AttackImpact = 0;
		  }
	 }else{
		$AttackImpact = 0;
	 }
include_once($xgp_root . 'includes/constants.'.$phpEx);
include_once($xgp_root . 'includes/GeneralFunctions.'.$phpEx);
include_once($xgp_root . 'includes/vendor/simplehtmldom/simple_html_dom.' . $phpEx);
include_once($xgp_root . 'includes/classes/class.debug.'.$phpEx);
$debug 		= new debug();

if (INSTALL != true)
{
	if(file_exists($xgp_root."install/")){
		message('No has eliminado o cambiado de nombre la carpeta de instalacion.<br/>El juego no se podra acceder mientras no la borres o la renombres.', '', '', false, false);
	}
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
	$ToolTips = '';
	include_once($xgp_root . 'includes/classes/class.MiniDB.'.$phpEx);
	include_once($xgp_root . 'includes/classes/class.DbCache.'.$phpEx);
	include($xgp_root.'config.'.$phpEx);
	$DbCache = new DbCache($dbsettings);
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
	if ( isset($user) and defined('IN_ADMIN') )
	{
		includeLang('ADMIN');
		include('../adm/AdminFunctions/Autorization.' . $phpEx);
		$dpath     = "../". DEFAULT_SKINPATH  ;
	}
	else
	{
		$dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
	}
	//We include the plugin system 0.3
	$PluginShips = array();
    include($xgp_root . 'includes/plugins.'.$phpEx);
	if ( ( time() >= ( $game_config['stat_last_update'] + ( 60 * $game_config['stat_update_time'] ) ) ) )
	{
		include($xgp_root . 'adm/statfunctions.' . $phpEx);
		update_config('stat_last_update', time());
		$result		= MakeStats();
	}

	if (isset($user))
	{	
		$user['avatar'] = sprintf( 'http://www.gravatar.com/avatar/%s?d=%s&s=%d&r=%s', md5( $user['email'] ), 'identicon', 128, 'pg' );
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

		include($xgp_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
		SetSelectedPlanet ($user);

		$planetrow = doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$user['current_planet']."';", "planets", true);

		include($xgp_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
		CheckPlanetUsedFields($planetrow);
		define("PHPIDS_IMPACT", $AttackImpact);
		if(PHPIDS_IMPACT >= 10){
			foreach($_POST as $Key => $Value){
				if(is_string($Value)){
					$_POST[$Key] = str_replace('<', '&lt;', strip_tags($Value));
					$_POST[$Key] = str_replace(">", '&gt;', strip_tags($Value));
					$_POST[$Key] = str_replace('"', '&quot;', strip_tags($Value));
					$_POST[$Key] = str_replace("'", '&apos;', strip_tags($Value));
					$_POST[$Key] = str_replace("´", '&acute;', strip_tags($Value));
				}
			}
			foreach($_GET as $Key => $Value){
				
				if(is_string($Value)){
					$_GET[$Key] = str_replace('<', '&lt;', strip_tags($Value));
					$_GET[$Key] = str_replace(">", '&gt;', strip_tags($Value));
					$_GET[$Key] = str_replace('"', '&quot;', strip_tags($Value));
					$_GET[$Key] = str_replace("'", '&apos;', strip_tags($Value));
					$_GET[$Key] = str_replace("´", '&acute;', strip_tags($Value));
				}
			}
		}
	}
}
else
{
	$dpath     = "../" . DEFAULT_SKINPATH;
}

include('includes/classes/class.SecurePage.' . $phpEx ); // include the class
$SecureSqlInjection	= new SecureSqlInjection(); // load the class
$SecureSqlInjection->secureGlobals(); // run the main class function

?>
