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

if (isset($_POST['reco_']) && is_numeric($_POST['reco_'])) {
$game_config['reco'] = $_POST['reco_'];
}
if (isset($_POST['stat_']) && is_numeric($_POST['stat_'])) {
$game_config['stat'] = $_POST['stat_'];
}
if (isset($_POST['topk_']) && is_numeric($_POST['topk_'])) {
$game_config['topk'] = $_POST['topk_'];
}
if (isset($_POST['simu_']) && is_numeric($_POST['simu_'])) {
$game_config['simu'] = $_POST['simu_'];
}

if (isset($_POST['note_']) && is_numeric($_POST['note_'])) {
$game_config['note'] = $_POST['note_'];
}
if (isset($_POST['budd_']) && is_numeric($_POST['budd_'])) {
$game_config['budd'] = $_POST['budd_'];
}
if (isset($_POST['chat_']) && is_numeric($_POST['chat_'])) {
$game_config['chat'] = $_POST['chat_'];
}
if (isset($_POST['sear_']) && is_numeric($_POST['sear_'])) {
$game_config['sear'] = $_POST['sear_'];
}

if (isset($_POST['decl_']) && is_numeric($_POST['decl_'])) {
$game_config['decl'] = $_POST['decl_'];
}
if (isset($_POST['rule_']) && is_numeric($_POST['rule_'])) {
$game_config['rule'] = $_POST['rule_'];
}
if (isset($_POST['conn_']) && is_numeric($_POST['conn_'])) {
$game_config['conn'] = $_POST['conn_'];
}
if (isset($_POST['supp_']) && is_numeric($_POST['supp_'])) {
$game_config['supp'] = $_POST['supp_'];
}

if (isset($_POST['bann_']) && is_numeric($_POST['bann_'])) {
$game_config['bann'] = $_POST['bann_'];
}
if (isset($_POST['opti_']) && is_numeric($_POST['opti_'])) {
$game_config['opti'] = $_POST['opti_'];
}

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['reco']    ."' WHERE `config_name` = 'reco';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['stat']    ."' WHERE `config_name` = 'stat';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['topk']    ."' WHERE `config_name` = 'topk';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['simu']    ."' WHERE `config_name` = 'simu';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['note']    ."' WHERE `config_name` = 'note';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['budd']    ."' WHERE `config_name` = 'budd';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['chat']    ."' WHERE `config_name` = 'chat';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['sear']    ."' WHERE `config_name` = 'sear';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['decl']    ."' WHERE `config_name` = 'decl';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['rule']    ."' WHERE `config_name` = 'rule';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['conn']    ."' WHERE `config_name` = 'conn';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['supp']    ."' WHERE `config_name` = 'supp';", 'config');

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bann']    ."' WHERE `config_name` = 'bann';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['opti']   ."' WHERE `config_name` = 'opti';", 'config');

AdminMessage ('Einstellungen erfolgreich gespeichert', 'Einstellungs-Men&uuml;', '?'); } else {

$parse                           = $lang;
$parse['reco']                   = $game_config['reco'];
$parse['stat']                   = $game_config['stat'];
$parse['topk']                   = $game_config['topk'];
$parse['simu']                   = $game_config['simu'];

$parse['note']                   = $game_config['note'];
$parse['budd']                   = $game_config['budd'];
$parse['chat']                   = $game_config['chat'];
$parse['sear']                   = $game_config['sear'];

$parse['decl']                   = $game_config['decl'];
$parse['rule']                   = $game_config['rule'];
$parse['conn']                   = $game_config['conn'];
$parse['supp']                   = $game_config['supp'];

$parse['bann']                   = $game_config['bann'];
$parse['opti']                   = $game_config['opti'];

$PageTPL                         = gettemplate('admin/einstellung/einstellung_menu02');
$Page                           .= parsetemplate( $PageTPL,  $parse );

display ( $Page, $lang['adm_opt_title'], false, '', true );
} } else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] ); }
return $Page; }
$Page = DisplayGameSettingsPage ( $user );

?>