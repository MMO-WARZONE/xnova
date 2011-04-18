<?php
define('VERSION','0.8h');		// Passera en version 1.0 quand toutes les fonctions ET l'install seront correct
								// Et c'est pas encore demain la veille !!!

set_magic_quotes_runtime(0);
$phpEx = "php";

$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

define('DEFAULT_SKINPATH' , 'skins/xnova/');
define('TEMPLATE_DIR'     , 'templates/');
define('TEMPLATE_NAME'    , 'OpenGame');

if($_COOKIE['Langs'] == "de"){define('DEFAULT_LANG'     , 'de');}
else{define('DEFAULT_LANG'     , 'de');}

$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

include($ugamela_root_path . 'includes/debug.class.'.$phpEx);
$debug = new debug();

include($ugamela_root_path . 'includes/constants.'.$phpEx);
include($ugamela_root_path . 'includes/functions.'.$phpEx);
include($ugamela_root_path . 'includes/unlocalised.'.$phpEx);
include($ugamela_root_path . 'includes/todofleetcontrol.'.$phpEx);
include($ugamela_root_path . 'language/'. DEFAULT_LANG .'/lang_info.cfg');

if (INSTALL != true) {
    include($ugamela_root_path . 'includes/vars.'.$phpEx);
    include($ugamela_root_path . 'includes/db.'.$phpEx);
    include($ugamela_root_path . 'includes/strings.'.$phpEx);
	include($ugamela_root_path . 'lockeder.'.$phpEx);

    // Lecture de la table de configuration
    $query = doquery("SELECT * FROM {{table}}",'config');
    while ( $row = mysql_fetch_assoc($query) ) {
	    $game_config[$row['config_name']] = $row['config_value'];
    }

	if ($InLogin != true) {
		$Result        = CheckTheUser ( $IsUserChecked );
		$IsUserChecked = $Result['state'];
		$user          = $Result['record'];
	} elseif ($InLogin == false) {
		// Jeux en mode 'clos' ???
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

		include($ugamela_root_path . 'rak.'.$phpEx);
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
		// Bah si déja y a quelqu'un qui passe par là et qu'a rien a faire de pressé ...
		// On se sert de lui pour mettre a jour tout les retardataires !!

	}
} else {
	$dpath     = "../" . DEFAULT_SKINPATH;
}
?>
