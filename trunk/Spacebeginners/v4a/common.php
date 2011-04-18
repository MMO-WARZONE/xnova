<?php

/**
  * common.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

define('VERSION' , ($game_config['VERSION'] == '') ? " " : "v".$game_config['VERSION']);

set_magic_quotes_runtime(0);
$phpEx = "php";

$Adminerlaubt  = array ( '1'  );
$pirat         = array ( '2','3','4');
$game_config   = array();
$user          = array();
$lang          = array();
$link          = "";
$IsUserChecked = false;

define('DEFAULT_SKINPATH' , 'styl/design/xnova/');
define('TEMPLATE_DIR'     , 'styl/');
define('TEMPLATE_NAME'    , 'html');
define('DEFAULT_LANG'     , 'de');

$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

include($xnova_root_path . 'includes/debug.class.'.$phpEx);
$debug = new debug();

include($xnova_root_path . 'includes/constants.'.$phpEx);
include($xnova_root_path . 'includes/functions.'.$phpEx);
include($xnova_root_path . 'includes/unlocalised.'.$phpEx);
include($xnova_root_path . 'includes/todofleetcontrol.'.$phpEx);
include($xnova_root_path . 'styl/sprache/'. DEFAULT_LANG .'/lang_info.cfg');


if (INSTALL != true) {
    include($xnova_root_path . 'includes/vars.'.$phpEx);
    include($xnova_root_path . 'includes/db.'.$phpEx);
    include($xnova_root_path . 'includes/strings.'.$phpEx);

    $query = doquery("SELECT * FROM {{table}}",'config');
    while ( $row = mysql_fetch_assoc($query) ) {
        $game_config[$row['config_name']] = $row['config_value'];
    }

    if ($InLogin != true) {
        $Result        = CheckTheUser ( $IsUserChecked );
        $IsUserChecked = $Result['state'];
        $user          = $Result['record'];
    } elseif ($InLogin == false) {

        if ($game_config['game_disable']) {

            if ($user['authlevel'] < 1) {
                message ( stripslashes ( $game_config['close_reason'] ), $game_config['game_name'] );
            }
        }
    }

    includeLang ("system");
    includeLang ('tech');

    if ( isset ($user) ) {
        $_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_start_time` <= '".time()."';", 'fleets');

        while ($row = mysql_fetch_array($_fleets)) {
            $array                = array();
            $array['galaxy']      = $row['fleet_start_galaxy'];
            $array['system']      = $row['fleet_start_system'];
            $array['planet']      = $row['fleet_start_planet'];
            $array['planet_type'] = $row['fleet_start_type'];
            $temp = FlyingFleetHandler ($array);
        }

        $_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_end_time` <= '".time()."';", 'fleets');

        while ($row = mysql_fetch_array($_fleets)) {
            $array                = array();
            $array['galaxy']      = $row['fleet_end_galaxy'];
            $array['system']      = $row['fleet_end_system'];
            $array['planet']      = $row['fleet_end_planet'];
            $array['planet_type'] = $row['fleet_end_type'];
            $temp = FlyingFleetHandler ($array);
        }

        unset($_fleets);

        include($xnova_root_path . 'rak.'.$phpEx);

        if ( defined('IN_ADMIN') ) {
            $UserSkin  = $user['dpath'];
            $local     = stristr ( $UserSkin, "http:");

            if ($local === false) {

                if (!$user['dpath']) {
                    $dpath = "../". DEFAULT_SKINPATH  ;
                } else {
                    $dpath = "../". $user["dpath"];
                }
            } else {
                $dpath = $UserSkin;
            }
        } else {
            $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
        }

        SetSelectedPlanet ( $user );

        $planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
        $galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);

        CheckPlanetUsedFields($planetrow);
    } else {

    }
} else {
    $dpath = "../" . DEFAULT_SKINPATH;
}

?>