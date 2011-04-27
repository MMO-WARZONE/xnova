<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package XNova
 * @version 0.2
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


// for old browsers and proxy servers
header('Cache-Control: no-cache, must-revalidate');

// NEEDED FOR SESSIONS :3 (Pada)
session_start();

define('VERSION','0.1');
								

set_magic_quotes_runtime(0);
$phpEx = "php";

$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;
$link = false;

define('DEFAULT_SKINPATH' , 'skins/xnova/');
define('TEMPLATE_DIR'     , 'templates/');
define('TEMPLATE_NAME'    , 'OpenGame');
define('DEFAULT_LANG'     , 'de');

define('PATH', $_SERVER['DOCUMENT_ROOT'] . "/");
define("TEMPLATES_PATH", PATH . "includes/templates/");

$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

include($ugamela_root_path . 'includes/debug.class.'.$phpEx);
$debug = new debug();

include($ugamela_root_path . 'includes/constants.'.$phpEx); //Consultas => 0
include($ugamela_root_path . 'includes/functions.'.$phpEx); //Consultas => 0
include($ugamela_root_path . 'includes/unlocalised.'.$phpEx); //Consutlas => 1 (no se ejecuta, es funcion BuildHostileFleetPlayerLink)
include($ugamela_root_path . 'includes/todofleetcontrol.'.$phpEx); //BUFF carga todo
include($ugamela_root_path . 'language/'. DEFAULT_LANG .'/lang_info.cfg');

// INCLUDE TEMPLATE POWER
include($ugamela_root_path . 'includes/tmpPower/class.TemplatePower.inc.'.$phpEx);

if (INSTALL != true) {
    include($ugamela_root_path . 'includes/vars.'.$phpEx);
    include($ugamela_root_path . 'includes/db.'.$phpEx);
    include($ugamela_root_path . 'includes/strings.'.$phpEx);

    // Lecture de la table de configuration
    $query = doquery("SELECT * FROM {{table}}",'config');
    while ( $row = mysql_fetch_assoc($query) ) {
	    $game_config[$row['config_name']] = $row['config_value'];
    }

	if ($InLogin != true) {
		$Result        = CheckSessions ( $IsUserChecked );
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
		$_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_end_time` <= '".time()."';", 'fleets'); //  OR fleet_end_time <= ".time()
		while ($row = mysql_fetch_array($_fleets)) {
			
			//Flotas que vuelven
			
			$array                = array();
			$array['galaxy']      = $row['fleet_end_galaxy'];
			$array['system']      = $row['fleet_end_system'];
			$array['planet']      = $row['fleet_end_planet'];
			$array['planet_type'] = $row['fleet_end_type'];

			$temp = FlyingFleetHandler ($array);
			
			//Flota que vienen
			if($row['fleet_end_time'] <= time()) {
			unset($array);
			$array                = array();
			$array['galaxy']      = $row['fleet_start_galaxy'];
			$array['system']      = $row['fleet_start_system'];
			$array['planet']      = $row['fleet_start_planet'];
			$array['planet_type'] = $row['fleet_start_type'];

			$temp = FlyingFleetHandler ($array);
			}
			
		}

		unset($_fleets);

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

// load plugins system
include($ugamela_root_path . 'includes/plugins.'.$phpEx);

if (@filesize('config.php') != 0) // if (!file_exists('config.php'))
{
//MOD Visitas Unicas y Visionados de pagina
 if($_SERVER["HTTP_X_FORWARDED_FOR"]){  $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];  }  else { $ip = $_SERVER["REMOTE_ADDR"];  } 	
 $fecha = date("Y/m/d");  //Cojemos la fecha en formato 2009/09/28
 $Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where ip='{$ip}' AND fecha='{$fecha}'","ips")); //Sacamos si el usuario entro hoy.
 $Consulta2 = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where fecha='{$fecha}'","visitas")); //Sacamos si entro algun usuario.
  if($Consulta[0] == "0") { doquery("INSERT INTO {{table}} SET fecha='{$fecha}', ip='{$ip}'", "ips"); } //Si no entro le guardamos la ip.
  if($Consulta2[0] == "0") { doquery("INSERT INTO {{table}} SET fecha='{$fecha}', vunicas='1', vpaginas='1'", "visitas"); } //Si no entro nadie insertamos la fecha
  else if($Consulta2[0] > 0 AND $Consulta[0] == "0") { doquery("UPDATE {{table}} SET vunicas=vunicas+1, vpaginas=vpaginas+1 where fecha='{$fecha}'" , "visitas"); } //Si entro alguien pero el no añadimos una visita unica.
  else if($Consulta2[0] > 0 AND $Consulta[0] > 0) { doquery("UPDATE {{table}} SET vpaginas=vpaginas+1 where fecha='{$fecha}'", "visitas"); } //Si entro alguien y el ya entrara añadimos un visita de pagina.
 //FIN MOD visitas 
}
?>
