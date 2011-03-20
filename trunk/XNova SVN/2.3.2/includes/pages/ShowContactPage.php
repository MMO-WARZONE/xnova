<?php
//version 1

function ShowContactPage(){

global $lang,$displays,$db;

    $displays->assignContent('contact');

    $QrySelectUser  = "SELECT `username`, `email`, `authlevel` ";
    $QrySelectUser .= "FROM {{table}} ";
    $QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
    $GameOps = $db->query ( $QrySelectUser, 'users');

    $QryOpen  = "SELECT `register_time` ";
    $QryOpen .= "FROM {{table}} ";
    $QryOpen .= "WHERE `id` = '1';";
    $Open     = $db->query ( $QryOpen, 'users', true);

    $parse['game_speed']             	= pretty_number($db->game_config['game_speed']/2500);
    $parse['fleet_speed']            	= pretty_number($db->game_config['fleet_speed']/2500);
    $parse['resource_multiplier']    	= pretty_number($db->game_config['resource_multiplier']);
    $parse['Fleet_Cdr']            	= $db->game_config['Fleet_Cdr'];
    $parse['Defs_Cdr']    	        = $db->game_config['Defs_Cdr'];
    $parse['stat_settings']              = pretty_number($db->game_config['stat_settings']);
    $parse['stat_update_time']           = pretty_time($db->game_config['stat_update_time']*60);

    if ($db->game_config['noobprotection'] == 1)
    {
          $parse['noobprotectionmulti']    	= $db->game_config['noobprotectionmulti'];
          $parse['noobprotectiontime']       = pretty_number($db->game_config['noobprotectiontime']);
          $parse['noobprotectiontitle']      ="<a onMouseOver=\"return overlib('".$lang['ccd_alert_noobprot1']." ".$lang['noobprotectionmulti']." ".$lang['ccd_alert_noobprot2']." ".$lang['noobprotectionmulti']."', BELOW, CENTER, WIDTH, 350, CAPTION, 'Aclaracion!',BGCOLOR,'#344566', FGCOLOR,'#344566',TEXTCOLOR,'white',CLOSECOLOR,'lime', CAPCOLOR,'red');\" onMouseOut=\"return nd();\" class=\"big\">".$lang['ccd_noobprotect']." (*)</a>";
    } else {
          $parse['noobprotectionmulti']    	= "<font color=\"red\">Desactivada</color>";
          $parse['noobprotectiontime']       = "<font color=\"red\">Desactivada</color>";
          $parse['noobprotectiontitle']      = $lang['ccd_noobprotect'];
    }


    $parse['MAX_GALAXY_IN_WORLD']        = MAX_GALAXY_IN_WORLD;
    $parse['MAX_SYSTEM_IN_GALAXY']       = MAX_SYSTEM_IN_GALAXY;
    $parse['MAX_PLANET_IN_SYSTEM']       = MAX_PLANET_IN_SYSTEM;
    $parse['MAX_PLAYER_PLANETS']         = MAX_PLAYER_PLANETS;
    $parse['FIELDS_BY_TERRAFORMER']      = FIELDS_BY_TERRAFORMER;
    $parse['FIELDS_BY_MOONBASIS_LEVEL']  = FIELDS_BY_MOONBASIS_LEVEL;
    $parse['MAX_BUILDING_QUEUE_SIZE']    = MAX_BUILDING_QUEUE_SIZE;
    $parse['MAX_FLEET_OR_DEFS_PER_ROW']  = pretty_number(MAX_FLEET_OR_DEFS_PER_ROW);
    $parse['BASE_STORAGE_SIZE']          = pretty_number(BASE_STORAGE_SIZE);

    $parse['gamename']                   = $_SERVER['HTTP_HOST'];
    $parse['servername']                 = $db->game_config['game_name'];
    $parse['openserver']                 = gmdate ( "d/m/Y G:i:s", $Open['register_time'] );

    foreach($parse as $name => $trans){
            $displays->assign($name, $trans);
        }

    while( $Ops = mysql_fetch_assoc($GameOps) ) {
        $displays->newBlock("contact");
        $Ops["user_level"]=$lang['user_level'][$Ops['authlevel']];
        $email=explode("@",$Ops['email']);
        $Ops["email_script"]="<SCRIPT LANGUAGE='JavaScript'>user = '".$email[0]."';site = '".$email[1]."';document.write('<a href=\"mailto:' + user + '@' + site + '\">'+ user + '@' + site + '</a>');</SCRIPT>";
        foreach($Ops as $name => $trans){
            $displays->assign($name, $trans);
        }
        unset($Ops);
    }
    $displays->display('Contacto');
}



?>