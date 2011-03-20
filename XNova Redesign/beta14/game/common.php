<?php

/**
 * common.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

// This is purely for the sake of the admin panel, do not, change it, instead change the version in cahngelog.mo
define('VERSION','beta13');       // Current XNova version

//Check rootpath
//$info =debug_backtrace();
if(!defined(ROOT_PATH)){ @define('ROOT_PATH',$xnova_root_path); /*trigger_error("Error, ROOT_PATH is not defined in ".$info[0]['file']); unset($info);*/ }
$xnova_root_path = ROOT_PATH;

//A bit of comfig
@set_magic_quotes_runtime(0);
$phpEx = "php"; //This is dangerous and will be fased out asap.


$lang = array();		//We should start the language array now.
$link = false;			//Link for mysql atm nothing.
$IsUserChecked = false;	//No, we haven't checked user yet.

//Basic Game constants
require_once(ROOT_PATH . 'SETUP.PHP');

//Load the session.
if(UNITTYPE == "domain"){
	$domain = str_ireplace("www.","",$_SERVER['HTTP_HOST']);
	$domain = explode(".",$domain);
	$uni = preg_replace("/[^0-9]/", "", $domain[UNI_IN_DOMAIN]);
}elseif(UNITTYPE == "get"){
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_POST[GETVAL]; }
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_GET['s']; }
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_POST['s']; }
	if(!$_GET[GETVAL]){ die("Error, unknown session, please login again"); define('UNIVERSE',''); }
	else{ define('UNIVERSE',preg_replace("/[^0-9]/", "", $_GET[GETVAL])); }
}else{
	define('UNIVERSE',UNITTYPE);
}
//echo UNIVERSE;

//And lets include the game files
require_once(ROOT_PATH . 'includes/error_handler.php');				//Errors handling
require_once(ROOT_PATH . 'includes/constants.php');					//More Game constants
require_once(ROOT_PATH . 'includes/functions.php');					//Functions
require_once(ROOT_PATH . 'includes/display.php');					//Display functions
require_once(ROOT_PATH . 'includes/unlocalised.php');				//Language function
require_once(ROOT_PATH . 'includes/loadfunctions.php');				//All the game functions.
require_once(ROOT_PATH . 'lang/config.mo');							//Language configs.*/

//Set language
$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

if(!INSTALL){
    require_once(ROOT_PATH . 'includes/vars.php');					//Load the variables
    require_once(ROOT_PATH . 'includes/db.php');					//Load the sql database
    require_once(ROOT_PATH . 'includes/strings.php');				//Load some strings
    
    //We need some pages to only have a small load on the server.
    $basic_pages = array('im','fleetajax');
    if(in_array($_GET['page'],$basic_pages) && strlen($_GET['page']) > 0){
    	define("SMALL_LOAD",true);
    }else{
    	define("SMALL_LOAD",false);
    }

    // Lecture de la table de configuration
    $query = doquery("SELECT * FROM {{table}}",'config');
    while($row = FetchArray($query)){
	    $game_config[$row['config_name']] = $row['config_value'];
    }

	if(!$InLogin){
		$Result        = CheckTheUser ( $IsUserChecked );
		$IsUserChecked = $Result['state'];
		$user          = $Result['record'];
	}else{
		// Jeux en mode 'clos' ???
		if($game_config['game_disable'] > 0){
			if ($user['authlevel'] < 1) {
				message ( stripslashes ( $game_config['close_reason'] ), $game_config['game_name'] );
			}
		}
	}
 

    require_once(ROOT_PATH . 'includes/userconstants.php');				//user specific constants


	includeLang ("system");
	includeLang ('tech');
	getLang ('general');
	getLang ('names');
	getLang ('menu');

	
	//What pages do we no need to be logged in for
	$login_not_required  = array('changelog','validate');
	

	if ($user['id'] > 0) {
		//ajax pages want to be quick load, so not generating combat reports or anything
		if(!SMALL_LOAD){
			//Right, lets completely recode all the missions and fleet management.
			include(ROOT_PATH . 'includes/ManageFleets.php');
			ManageFleets($user['id']);
			
			//Lets get current rank
			$rank = doquery("SELECT COUNT('id') +1 AS 'rank' FROM {{table}} WHERE `total_points` > '".$user['total_points']."' ;",'users',true);
			define("USER_RANK",$rank['rank']);
		}

		//If they have no skin, give them the default
		if(!$user['skin']){ $user['skin'] = DEFAULT_SKIN; }

		//Do they have commander?
		if($user[$resource[601]."_exp"] >= time()){ define("COMMANDER",true); }
		else{ define("COMMANDER",false); }

		//Set the planet if the user has changed it.
		if($_GET['cp'] > 0 && $_GET['cp'] != $user['current_planet']){ SetSelectedPlanet($user); }

		//Set the language if the user has changed it.
		if(strlen($_GET['lang']) > 0 && @in_array($_GET['lang'],$basedlang)){
			doquery("UPDATE {{table}} SET `lang` = '".mysql_real_escape_string($_GET['lang'])."' WHERE `id` = '".$user['id']."' LIMIT 1 ;",'users');
		}

		//Get planet row and galaxy row.
		if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true); }
		//if(!$galaxyrow){ $galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true); }

		//Check for cheating potentially.
		CheckPlanetUsedFields($planetrow);
	}else{
		//Log them out (unless we are on the login page).
		if(!defined('LOGIN') || LOGIN != true){
			if(!in_array($_GET['page'],$login_not_required)){
				if($_GET['demo'] == 'special'){
					$user['skin'] = "http://xnovauk.com/skins/xr/";
				}else{
					header("Location: ".LOGINURL);
				}
			}
		}
	}
} else {
	$dpath = DEFAULT_SKINPATH;
}

?>
