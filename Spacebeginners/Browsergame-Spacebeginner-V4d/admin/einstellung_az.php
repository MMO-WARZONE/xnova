<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
    global $lang, $game_config, $_POST, $Adminerlaubt, $user;

    includeLang('admin/einstellung/einstellung_az');

    if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {

        if ($_POST['opt_save'] == "1") {

            if (isset($_POST['angriffszone']) && $_POST['angriffszone'] == 'on') {
                $game_config['angriffszone'] = "1";
            } else {
                $game_config['angriffszone'] = "0";
            }

            doquery("UPDATE {{table}} SET `config_value` = '". $game_config['angriffszone'] ."' WHERE `config_name` = 'angriffszone';", 'config');

            AdminMessage ($lang['speichern'][100], $lang['speichern'][101], '?'); } else {

            $parse                 = $lang;
            $parse['angriffszone'] = ($game_config['angriffszone'] == 1) ? " checked = 'checked' ":"";

            $PageTPL               = gettemplate('admin/einstellung/einstellung_az');
            $Page                 .= parsetemplate( $PageTPL, $parse );

            display ( $Page, $lang['adm_opt_title'], false, '', true );
        }
    } else {
        AdminMessage ( $lang['system'][9000], $lang['system'][9001] );
    }
    return $Page;
}
$Page = DisplayGameSettingsPage ( $user );

?>