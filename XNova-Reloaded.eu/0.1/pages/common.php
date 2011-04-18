<?php

/**
 * common.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */


include(XNOVA_ROOT_PATH . 'includes/security.func.php');
unregister_globals();
define('VERSION','XNova-Reloaded 0.1');
set_magic_quotes_runtime(0);

// Sessions
$sessiondir = XNOVA_ROOT_PATH . 'sessions';
session_name("sid");
ini_set('session.save_path', $sessiondir);
session_start();


$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

define('DEFAULT_SKINPATH' , 'skins/xnova/');
define('TEMPLATE_DIR'     , 'templates/');
define('TEMPLATE_NAME'    , 'OpenGame');

ini_set('date.timezone', 'Europe/Berlin');

if($_COOKIE['Langs'] == "de"){define('DEFAULT_LANG'     , 'de');}
else{define('DEFAULT_LANG'     , 'de');}

$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

include(XNOVA_ROOT_PATH . 'includes/debug.class.php');
$debug = new debug();

include(XNOVA_ROOT_PATH . 'includes/functions.php');
include(XNOVA_ROOT_PATH . 'includes/unlocalised.php');
include(XNOVA_ROOT_PATH . 'includes/todofleetcontrol.php');
include(XNOVA_ROOT_PATH . 'language/'. DEFAULT_LANG .'/lang_info.cfg');


if (INSTALL != true) {
    /*Datenbankverbindung mit PDO herstellen*/
    include(XNOVA_ROOT_PATH . 'includes/db.php');
	$DB = ConnectPDO();
autounban();
    include(XNOVA_ROOT_PATH . 'includes/vars.php');
    include(XNOVA_ROOT_PATH . 'includes/strings.php');
	include(XNOVA_ROOT_PATH . 'pages/lockeder.php');

	//Config auslesen
    foreach ($DB->query("SELECT * FROM `".PREFIX."config`") as $row) {
        $game_config[$row['config_name']] = $row['config_value'];
    }

	if ($InLogin != true) {
		session_start();
		$Result        = CheckTheUser ( $IsUserChecked );
		$IsUserChecked = $Result['state'];
		$user          = $Result['record'];
	} elseif ($InLogin == false) {
		// Jeux en mode 'clos' ???
		if( $game_config['game_disable']) {
			if ($user['authlevel'] < 1) {
				$parse['close_reason'] = $game_config['close_reason'];
				$parse['game_name']	   = $game_config['game_name'];
				display(parsetemplate(gettemplate('game_offline'), $parse), $game_config['game_name']." OFFLINE", false);
			}
		}
	}

	includeLang ("system");
	includeLang ('tech');
	check_urlaubmodus_time();

	if(isset($user)){
	
        foreach($DB->query("SELECT * FROM ".PREFIX."fleets WHERE `fleet_start_time` <= '".time()."' OR `fleet_start_time` <= '".time()."'") as $row) {
		    $array                = array();
			$array['galaxy']      = $row['fleet_start_galaxy'];
			$array['system']      = $row['fleet_start_system'];
			$array['planet']      = $row['fleet_start_planet'];
			$array['planet_type'] = $row['fleet_start_type'];

			$temp = FlyingFleetHandler ($array);
        }

		include(XNOVA_ROOT_PATH . 'pages/rak.php');
		if ( defined('IN_ADMIN') ) {
			$UserSkin  = $user['dpath'];
			$local     = stristr ( $UserSkin, "http:");
			if ($local === false) {
				if (!$user['dpath']) {
					$dpath     = "../". DEFAULT_SKINPATH  ;
				} else {
					$dpath     = "../". $user["dpath"];
				}
			} else {
				$dpath     = $UserSkin;
			}
		} else {
			$dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
		}

		SetSelectedPlanet ( $user );

		$Query = $DB->query("SELECT * FROM `".PREFIX."planets` WHERE `id` = '".$user['current_planet']."'");
		$planetrow = $Query->fetch();
		$Query = $DB->query("SELECT * FROM `".PREFIX."galaxy` WHERE `id_planet` = '".$planetrow['id']."'");
		$galaxyrow = $Query->fetch();

		CheckPlanetUsedFields($planetrow);
	} else {

	/*Wenn nicht eingelogt passiert hier au nix ;)*/

	}
} else {
	$dpath     = "../" . DEFAULT_SKINPATH;
}
//Konstanten festlegen
	define('ADMINEMAIL'               , $game_config['adminmail']);
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	// Festlegen von Galaxien, Sonnensytemen und Planeten!
	define('MAX_GALAXY_IN_WORLD'      , $game_config['max_galaxy_in_world']);
	define('MAX_SYSTEM_IN_GALAXY'     , $game_config['max_system_in_galaxy']);
	define('MAX_PLANET_IN_SYSTEM'     , $game_config['max_planet_in_system']);
	
	// Zusätzliche Felder pro Stufe der Mondbasis
	define('FIELDS_BY_MOONBASIS_LEVEL', $game_config['fields_by_moonbasis_level']);
	// Maximale Anzahl der Planeten für jeden Spieler
	define('MAX_PLAYER_PLANETS'       , $game_config['max_player_planets']);
	// Maximale Anzahl von Einträgen in der Bau Queue
	define('MAX_BUILDING_QUEUE_SIZE'  , $game_config['max_building_queue_size']);
	// Maximale Anzahl von Elementen in der Flotten und Deff Bauschleife
	define('MAX_FLEET_OR_DEFS_PER_ROW', $game_config['max_fleet_or_defs_per_row']);
	// Lager können überfüllt werden.
	// 1.0 entspricht 100% Kapazität - 1.1 entspricht 110% Kapazität usw...
	define('MAX_OVERFLOW'             , $game_config['max_overflow']);
	
	//Unterschied der AZ
   define('AZ_ABSTAND'         , 2);

	// Werte für die bereits vorhandenen Ress auf neuen Planeten und der Lagergröße
	define('BASE_STORAGE_SIZE'        , $game_config['base_storage_size']);
	// Debug Level
	define('DEBUG', 1); // Debugging off
	// Mot qui sont interdit a la saisie !
	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript");


//Unregistrierte User auf die index.php weiterleiten
if	(! defined('USER_MUSS_REGISTRIERT_SEIN'))
//wenn die Konstante nicht existiert, wird sie erzeugt und auf true gesetzt
	define('USER_MUSS_REGISTRIERT_SEIN', true);

define('INDEX_URL', 'http://'.$_SERVER['SERVER_NAME'].str_replace('//','/',dirname($_SERVER['SCRIPT_NAME']).'/index.php'));
//Pfad zur Index.php definieren
                
if(USER_MUSS_REGISTRIERT_SEIN === true && empty($user['id']) && empty($_SESSION['id'])  ) 
//Wenn nicht eingelogt, das heißt USER_MUSS_REGISTRIERT_SEIN true hat und $user['id'] und $_SESSION['id'] 0 oder Leer ist 
{
    header('Location: '.INDEX_URL);	
    exit;
	//Weiterleiten auf die index.php und Script abbrechen
}
?>