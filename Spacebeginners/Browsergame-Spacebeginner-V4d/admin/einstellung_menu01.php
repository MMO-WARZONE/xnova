<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
global $lang, $game_config, $_POST, $Adminerlaubt, $user;

includeLang('admin/einstellung/einstellung_menu');

if ( $user['authlevel'] >= 3 and in_array ($user['id'],$Adminerlaubt) ) {
if ($_POST['opt_save'] == "1") {

if (isset($_POST['over_']) && is_numeric($_POST['over_'])) {
$game_config['over'] = $_POST['over_'];
}
if (isset($_POST['gala_']) && is_numeric($_POST['gala_'])) {
$game_config['gala'] = $_POST['gala_'];
}
if (isset($_POST['fleet_']) && is_numeric($_POST['fleet_'])) {
$game_config['fleet'] = $_POST['fleet_'];
}
if (isset($_POST['mess_']) && is_numeric($_POST['mess_'])) {
$game_config['mess'] = $_POST['mess_'];
}

if (isset($_POST['gebau_']) && is_numeric($_POST['gebau_'])) {
$game_config['gebau'] = $_POST['gebau_'];
}
if (isset($_POST['forsch_']) && is_numeric($_POST['forsch_'])) {
$game_config['forsch'] = $_POST['forsch_'];
}
if (isset($_POST['armada_']) && is_numeric($_POST['armada_'])) {
$game_config['armada'] = $_POST['armada_'];
}
if (isset($_POST['abwehr_']) && is_numeric($_POST['abwehr_'])) {
$game_config['abwehr'] = $_POST['abwehr_'];
}

if (isset($_POST['officier_']) && is_numeric($_POST['officier_'])) {
$game_config['officier'] = $_POST['officier_'];
}
if (isset($_POST['marchand_']) && is_numeric($_POST['marchand_'])) {
$game_config['marchand'] = $_POST['marchand_'];
}
if (isset($_POST['annonce_']) && is_numeric($_POST['annonce_'])) {
$game_config['annonce'] = $_POST['annonce_'];
}
if (isset($_POST['schrotti_']) && is_numeric($_POST['schrotti_'])) {
$game_config['schrotti'] = $_POST['schrotti_'];
}

if (isset($_POST['imperium_']) && is_numeric($_POST['imperium_'])) {
$game_config['imperium'] = $_POST['imperium_'];
}
if (isset($_POST['alliance_']) && is_numeric($_POST['alliance_'])) {
$game_config['alliance'] = $_POST['alliance_'];
}
if (isset($_POST['resources_']) && is_numeric($_POST['resources_'])) {
$game_config['resources'] = $_POST['resources_'];
}
if (isset($_POST['techtree_']) && is_numeric($_POST['techtree_'])) {
$game_config['techtree'] = $_POST['techtree_'];
}

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['over']    ."' WHERE `config_name` = 'over';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['gala']    ."' WHERE `config_name` = 'gala';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet']   ."' WHERE `config_name` = 'fleet';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['mess']    ."' WHERE `config_name` = 'mess';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['gebau']   ."' WHERE `config_name` = 'gebau';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forsch']  ."' WHERE `config_name` = 'forsch';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['armada']  ."' WHERE `config_name` = 'armada';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['abwehr']  ."' WHERE `config_name` = 'abwehr';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['officier']   ."' WHERE `config_name` = 'officier';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['marchand']   ."' WHERE `config_name` = 'marchand';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['annonce']    ."' WHERE `config_name` = 'annonce';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['schrotti']   ."' WHERE `config_name` = 'schrotti';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['imperium']   ."' WHERE `config_name` = 'imperium';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['alliance']   ."' WHERE `config_name` = 'alliance';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resources']  ."' WHERE `config_name` = 'resources';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['techtree']   ."' WHERE `config_name` = 'techtree';", 'config');

AdminMessage ('Einstellungen erfolgreich gespeichert', 'Einstellungs-Men&uuml;', '?'); } else {

$parse                           = $lang;
$parse['over']                   = $game_config['over'];
$parse['gala']                   = $game_config['gala'];
$parse['fleet']                  = $game_config['fleet'];
$parse['mess']                   = $game_config['mess'];

$parse['gebau']                  = $game_config['gebau'];
$parse['forsch']                 = $game_config['forsch'];
$parse['armada']                 = $game_config['armada'];
$parse['abwehr']                 = $game_config['abwehr'];

$parse['officier']               = $game_config['officier'];
$parse['marchand']               = $game_config['marchand'];
$parse['annonce']                = $game_config['annonce'];
$parse['schrotti']               = $game_config['schrotti'];

$parse['imperium']               = $game_config['imperium'];
$parse['alliance']               = $game_config['alliance'];
$parse['resources']              = $game_config['resources'];
$parse['techtree']               = $game_config['techtree'];

$PageTPL                         = gettemplate('admin/einstellung/einstellung_menu01');
$Page                           .= parsetemplate( $PageTPL,  $parse );

display ( $Page, $lang['adm_opt_title'], false, '', true );
} } else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] ); }
return $Page; }
$Page = DisplayGameSettingsPage ( $user );

?>