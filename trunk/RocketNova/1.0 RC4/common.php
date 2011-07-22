<?php
/**
 * common.php
 *
 * @version 1.1
 * Sessions & Template Power eingebunden
 */

 $security_version = '1.0.106';

 // Check Server Configration

 if (function_exists('ini_get'))
 {
    $register_globals = ini_get('register_globals');
 }
 else
 {
    $register_globals = 1;
 }

 if (function_exists('get_magic_quotes_gpc'))
 {
    $magic_quotes = get_magic_quotes_gpc();
 }
 elseif (function_exists('ini_get'))
 {
    $magic_quotes = ini_get('magic_quotes_gpc');
 }
 else
 {
    $magic_quotes = 1;
 }

 $requests = array_merge($_POST, $_GET, $_REQUEST, $_COOKIE);

 if ($register_globals)
 {
    foreach ($requests as $name => $value)
    {
       eval("if(isset(\$".$name."))\$".$name."='';");
    }
 }

 if (!$magic_quotes)
 {
    foreach ($_POST as $name => $value)
    {
// Die Funktion Blockt schiff und deffbau

        $_POST[$name] = addslashes($value);
    }
 }



 function CheckData ($data, $security_version)
 {
    if (is_array($data)) {
        foreach ($data as $name => $value) {
            CheckData($value, $security_version);
        }
        return;
    }

    $sql_words = array(
        "UNION(.*?)SELECT(.*?)FROM" => "SQL-Injection",
        "SET(.*?)=" => "SQL-Injection / Datenmanipulation",
            );

    foreach ($sql_words as $word => $type)
    {
        if (preg_match("#".str_replace("#", "\\#", $word)."#ism", $data))
        {
            ?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <title>Security Alert</title>
                    </head>
                    <body>
                        <center>
                            <font style="color: red; font-size: 50px; font-family: Verdana; font-weight: bold;">! SECURITY ALERT !</font><br />
                            <font style="color: black; font-size: 14px; font-family: Verdana;"><b>Versuchtes eindingen ins System per <?php echo $type; ?> gestoppt.</b></font><br /><br /><br />
                        </center>
                    </body>
                </html>
            <?php
                exit;
        }
    }
 }

 CheckData($requests, $security_version);

 foreach ($_POST as $name => $value)
 {
    if (is_array($value))
        continue;
    if (preg_match("#\<(.*?)\>#ism", $value))
        $_POST[$name] = htmlentities($value);
 }

 foreach ($_GET as $name => $value)
 {
    if (is_array($value))
        continue;
    if (preg_match("#\<(.*?)\>#ism", $value))
        $_GET[$name] = htmlentities($value);
 }

// für ältere Browser
header('Cache-Control: no-cache, must-revalidate'); 

// Sessions
session_start();
 
define('VERSION','1.0 RC4');		// Version


set_magic_quotes_runtime(0);
$phpEx = "php";

$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

define('DEFAULT_SKINPATH' , 'designs/xnova/');
define('TEMPLATE_DIR'     , 'html/');
define('TEMPLATE_NAME'    , 'templates');

define('PATH', $_SERVER['DOCUMENT_ROOT'] . "/");
define("TEMPLATES_PATH", PATH . "includes/templates/");

if($_COOKIE['Langs'] == "de"){define('DEFAULT_LANG'     , 'de');}
else{define('DEFAULT_LANG'     , 'de');}

$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

include($rocketnova_root_path . 'includes/debug.class.'.$phpEx);
$debug = new debug();

include($rocketnova_root_path . 'includes/constants.'.$phpEx);
include($rocketnova_root_path . 'includes/functions.'.$phpEx);
include($rocketnova_root_path . 'includes/unlocalised.'.$phpEx);
include($rocketnova_root_path . 'includes/todofleetcontrol.'.$phpEx);
include($rocketnova_root_path . 'language/'. DEFAULT_LANG .'/lang_info.cfg');

// Template Power wurde includiert
include($rocketnova_root_path . 'includes/tmpPower/class.TemplatePower.inc.'.$phpEx);

if (INSTALL != true) {
    include($rocketnova_root_path . 'includes/vars.'.$phpEx);
    include($rocketnova_root_path . 'includes/db.'.$phpEx);
    include($rocketnova_root_path . 'includes/strings.'.$phpEx);
	include($rocketnova_root_path . 'lockeder.'.$phpEx);

    $query = doquery("SELECT * FROM {{table}}",'config');
    while ( $row = mysql_fetch_assoc($query) ) {
	    $game_config[$row['config_name']] = $row['config_value'];
    }

	// Sessions
	if ($InLogin != true) {
		$Result        = CheckSessions ( $IsUserChecked );
		$IsUserChecked = $Result['state'];
		$user          = $Result['record'];
	} elseif ($InLogin == false) {

		if( $game_config['game_disable']) {
			if ($user['authlevel'] < 1) {
				message ( stripslashes ( $game_config['close_reason'] ), $game_config['game_name'] );
			}
		}
	}

	includeLang ("system");
	includeLang ('tech');

		if ( isset ($user) ) {
$_lastupdate = doquery("SELECT lastupdate FROM {{table}} LIMIT 1;", 'update'); 
$row = mysql_fetch_row($_lastupdate); 
//echo "now[".time()."] lastupdate[".$row[0]."] diff[".(time()-$row[0])."]"; 
if(time()-$row[0]>60){ 
doquery("LOCK TABLE {{table}} WRITE", 'update'); 
doquery("UPDATE {{table}} SET lastupdate = ".time()."", 'update'); 
doquery("UNLOCK TABLES", ''); 

$_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_start_time` <= '".time()."';", 'fleets'); // OR fleet_end_time <= ".time() 
while ($row = mysql_fetch_array($_fleets)) { 
$array = array(); 
$array['galaxy'] = $row['fleet_start_galaxy']; 
$array['system'] = $row['fleet_start_system']; 
$array['planet'] = $row['fleet_start_planet']; 
$array['planet_type'] = $row['fleet_start_type']; 
$temp = FlyingFleetHandler ($array); 
} 
$_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_end_time` <= '".time()."';", 'fleets'); // OR fleet_end_time <= ".time() 
while ($row = mysql_fetch_array($_fleets)) { 
$array = array(); 
$array['galaxy'] = $row['fleet_end_galaxy']; 
$array['system'] = $row['fleet_end_system']; 
$array['planet'] = $row['fleet_end_planet']; 
$array['planet_type'] = $row['fleet_end_type']; 
$temp = FlyingFleetHandler ($array); 
} 
unset($_fleets); 
}

		include($rocketnova_root_path . 'rak.'.$phpEx);
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

		$planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
		$galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);

		CheckPlanetUsedFields($planetrow);
	} else {


	}
} else {
	$dpath     = "../" . DEFAULT_SKINPATH;
}
?>
