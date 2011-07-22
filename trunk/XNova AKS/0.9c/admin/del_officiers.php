<?php

/**
 * del_officier.php
 *
 * @version 1.0
 * @copyright 2008 By Xire -AlteGarde-
 * 
 */


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

    if ($user['authlevel'] >= 2) {
        includeLang('admin');

        $mode      = $_POST['mode'];

        $PageTpl   = gettemplate("admin/del_officiers");
        $parse     = $lang;

        if ($mode == 'addit') {
            $id          = $_POST['id'];
            $rpg_geologue       = $_POST['rpg_geologue'];
            $rpg_amiral    = $_POST['rpg_amiral'];
            $rpg_ingenieur        = $_POST['rpg_ingenieur'];
            $rpg_technocrate        = $_POST['rpg_technocrate'];
            $rpg_constructeur    = $_POST['rpg_constructeur'];
            $rpg_scientifique        = $_POST['rpg_scientifique'];
            $rpg_stockeur      = $_POST['rpg_stockeur'];
            $rpg_defenseur        = $_POST['rpg_defenseur'];
            $rpg_bunker       = $_POST['rpg_bunker'];
            $rpg_espion      = $_POST['rpg_espion'];
                $rpg_commandant     = $_POST['rpg_commandant'];
                $rpg_destructeur       = $_POST['rpg_destructeur'];
                $rpg_general       = $_POST['rpg_general'];
                $rpg_raideur      = $_POST['rpg_raideur'];
                $rpg_empereur      = $_POST['rpg_empereur'];
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` - '". $rpg_empereur ."', ";
            $QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` - '". $rpg_ingenieur ."', ";
            $QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` - '". $rpg_raideur ."', ";
            $QryUpdatePlanet .= "`rpg_general` = `rpg_general` - '". $rpg_general ."', ";
            $QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` - '". $rpg_destructeur ."', ";
            $QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` - '". $rpg_commandant ."', ";
            $QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` - '". $rpg_espion ."', ";
            $QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` - '". $rpg_bunker ."', ";
            $QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` - '". $rpg_defenseur ."', ";
            $QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` - '". $rpg_stockeur ."', ";
            $QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` - '". $rpg_scientifique ."', ";
            $QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` - '". $rpg_constructeur ."', ";
            $QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` - '". $rpg_amiral ."', ";
            $QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` - '". $rpg_technocrate ."', ";
            $QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` - '". $rpg_geologue ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $id ."' ";
            doquery( $QryUpdatePlanet, "users");

            AdminMessage ( $lang['adm_deloff2'], $lang['adm_deloff1'] );
        }
        $Page = parsetemplate($PageTpl, $parse);

        display ($Page, $lang['adm_am_ttle'], false, '', true);
    } else {
        AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
    }

?>