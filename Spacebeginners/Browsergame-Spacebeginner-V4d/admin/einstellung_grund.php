<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
global $lang, $game_config, $_POST ,$Adminerlaubt, $user;

includeLang('admin/einstellung/einstellung_grund');


if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {

if ($_POST['opt_save'] == "1") {

if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
$game_config['game_disable']         = "1";
$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
} else {
$game_config['game_disable']         = "0";
$game_config['close_reason']         = "";
}

if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
$game_config['OverviewNewsFrame']     = "1";
$game_config['OverviewNewsText']      = addslashes( $_POST['NewsText'] );
} else {
$game_config['OverviewNewsFrame']     = "0";
$game_config['OverviewNewsText']      = "";
}

if (isset($_POST['chatframe']) && $_POST['chatframe'] == 'on') {
$game_config['OverviewExternChat']     = "1";
$game_config['OverviewExternChatCmd']  = addslashes( $_POST['ExternChat'] );
} else {
$game_config['OverviewExternChat']     = "0";
$game_config['OverviewExternChatCmd']  = "";
}

if (isset($_POST['googlead']) && $_POST['googlead'] == 'on') {
$game_config['OverviewBanner']         = "1";
$game_config['OverviewClickBanner']    = addslashes( $_POST['GoogleAds'] );
} else {
$game_config['OverviewBanner']         = "0";
$game_config['OverviewClickBanner']    = "";
}

if (isset($_POST['bannerframe']) && $_POST['bannerframe'] == 'on') {
$game_config['ForumBannerFrame']     = "1";
} else {
$game_config['ForumBannerFrame']     = "0";
}

if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
$game_config['debug'] = "1";
} else {
$game_config['debug'] = "0";
}

if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
$game_config['game_name'] = $_POST['game_name'];
}

if (isset($_POST['VERSION']) && $_POST['VERSION'] != '') {
$game_config['VERSION'] = $_POST['VERSION'];
}

if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
$game_config['forum_url'] = $_POST['forum_url'];
}

if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
$game_config['game_speed'] = $_POST['game_speed'];
}

if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
$game_config['fleet_speed'] = $_POST['fleet_speed'];
}

if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
}

if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
$game_config['initial_fields'] = $_POST['initial_fields'];
}

if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
}

if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
}

if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
}

if (isset($_POST['appolonium_basic_income']) && is_numeric($_POST['appolonium_basic_income'])) {
$game_config['appolonium_basic_income'] = $_POST['appolonium_basic_income'];
}

if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
}

if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
$game_config['Fleet_Cdr'] = $_POST['Fleet_Cdr'];
}

if (isset($_POST['attack_disabled']) && $_POST['attack_disabled'] == 'on') {
$game_config['attack_disabled'] = "1";
} else {
$game_config['attack_disabled'] = "0";
}

if (isset($_POST['SHOW_ADMIN_IN_RECORDS']) && $_POST['SHOW_ADMIN_IN_RECORDS'] == 'on') {
$game_config['SHOW_ADMIN_IN_RECORDS'] = "1";
} else {
$game_config['SHOW_ADMIN_IN_RECORDS'] = "0";
}

if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
$game_config['Defs_Cdr'] = $_POST['Defs_Cdr'];
}

if (isset($_POST['noobprotection']) && is_numeric($_POST['noobprotection'])) {
$game_config['noobprotection'] = $_POST['noobprotection'];
}

if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
$game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
}

if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti'])) {
$game_config['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
}

if (isset($_POST['LastSettedGalaxyPos']) && is_numeric($_POST['LastSettedGalaxyPos'])) {
$game_config['LastSettedGalaxyPos'] = $_POST['LastSettedGalaxyPos'];
}

if (isset($_POST['LastSettedSystemPos']) && is_numeric($_POST['LastSettedSystemPos'])) {
$game_config['LastSettedSystemPos'] = $_POST['LastSettedSystemPos'];
}

if (isset($_POST['LastSettedPlanetPos']) && is_numeric($_POST['LastSettedPlanetPos'])) {
$game_config['LastSettedPlanetPos'] = $_POST['LastSettedPlanetPos'];
}

if (isset($_POST['enable_link_']) && is_numeric($_POST['enable_link_'])) {
$game_config['link_enable'] = $_POST['enable_link_'];
}

$game_config['link_name'] = addslashes( $_POST['name_link_']);
$game_config['link_url']  = $_POST['url_link_'];
$game_config['banner_source_post'] = $_POST['banner_source_post'];

if (isset($_POST['stat_settings']) && is_numeric($_POST['stat_settings'])) {
$game_config['stat_settings'] = $_POST['stat_settings'];
}

$game_config['bot_name'] = addslashes( $_POST['name_bot']);
$game_config['bot_adress'] = addslashes( $_POST['adress_bot']);

if (isset($_POST['duration_ban']) && is_numeric($_POST['duration_ban'])) {
$game_config['ban_duration'] = $_POST['duration_ban'];
}

if (isset($_POST['bot_enable']) && is_numeric($_POST['bot_enable'])) {
$game_config['enable_bot'] = $_POST['bot_enable'];
}

if (isset($_POST['bbcode_field']) && is_numeric($_POST['bbcode_field'])) {
$game_config['enable_bbcode'] = $_POST['bbcode_field'];
}

doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['stat_settings']              ."' WHERE `config_name` = 'stat_settings';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']              ."' WHERE `config_name` = 'game_name';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['VERSION']                ."' WHERE `config_name` = 'VERSION';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['attack_disabled']           ."' WHERE `config_name` = 'attack_disabled';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['SHOW_ADMIN_IN_RECORDS']           ."' WHERE `config_name` = 'SHOW_ADMIN_IN_RECORDS';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsFrame']       ."' WHERE `config_name` = 'OverviewNewsFrame';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsText']        ."' WHERE `config_name` = 'OverviewNewsText';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChat']      ."' WHERE `config_name` = 'OverviewExternChat';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChatCmd']   ."' WHERE `config_name` = 'OverviewExternChatCmd';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewBanner']          ."' WHERE `config_name` = 'OverviewBanner';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewClickBanner']     ."' WHERE `config_name` = 'OverviewClickBanner';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ForumBannerFrame']       ."' WHERE `config_name` = 'ForumBannerFrame';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['banner_source_post']       ."' WHERE `config_name` = 'banner_source_post';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['appolonium_basic_income'] ."' WHERE `config_name` = 'appolonium_basic_income';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['Fleet_Cdr']              ."' WHERE `config_name` = 'Fleet_Cdr';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['Defs_Cdr']               ."' WHERE `config_name` = 'Defs_Cdr';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['noobprotection']         ."' WHERE `config_name` = 'noobprotection';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['noobprotectiontime']     ."' WHERE `config_name` = 'noobprotectiontime';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['noobprotectionmulti']    ."' WHERE `config_name` = 'noobprotectionmulti';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['LastSettedGalaxyPos']    ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['LastSettedSystemPos']    ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['LastSettedPlanetPos']    ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_name']    ."' WHERE `config_name` = 'bot_name';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_adress']    ."' WHERE `config_name` = 'bot_adress';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ban_duration']    ."' WHERE `config_name` = 'ban_duration';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bot']    ."' WHERE `config_name` = 'enable_bot';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bbcode']    ."' WHERE `config_name` = 'enable_bbcode';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_announces']    ."' WHERE `config_name` = 'enable_announces';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_marchand']    ."' WHERE `config_name` = 'enable_marchand';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_notes']    ."' WHERE `config_name` = 'enable_notes';", 'config');
doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['debug']                  ."' WHERE `config_name` ='debug'", 'config');

AdminMessage ($lang['speichern']['100'], $lang['speichern']['102'], '?');
} else {

$parse                           = $lang;
$parse['game_name']              = $game_config['game_name'];
$parse['VERSION']                = $game_config['VERSION'];
$parse['game_speed']             = $game_config['game_speed'];
$parse['fleet_speed']            = $game_config['fleet_speed'];
$parse['resource_multiplier']    = $game_config['resource_multiplier'];
$parse['forum_url']              = $game_config['forum_url'];
$parse['initial_fields']         = $game_config['initial_fields'];
$parse['metal_basic_income']     = $game_config['metal_basic_income'];
$parse['crystal_basic_income']   = $game_config['crystal_basic_income'];
$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'];
$parse['appolonium_basic_income'] = $game_config['appolonium_basic_income'];
$parse['energy_basic_income']    = $game_config['energy_basic_income'];
$parse['Fleet_Cdr']              = $game_config['Fleet_Cdr'];
$parse['Defs_Cdr']               = $game_config['Defs_Cdr'];
$parse['noobprotection']         = $game_config['noobprotection'];
$parse['noobprotectiontime']     = $game_config['noobprotectiontime'];
$parse['noobprotectionmulti']    = $game_config['noobprotectionmulti'];
$parse['attack_disabled']              = ($game_config['attack_disabled'] == 1) ? " checked = 'checked' ":"";
$parse['SHOW_ADMIN_IN_RECORDS']  = ($game_config['SHOW_ADMIN_IN_RECORDS'] == 1) ? " checked = 'checked' ":"";
$parse['LastSettedGalaxyPos']    = $game_config['LastSettedGalaxyPos'];
$parse['LastSettedSystemPos']    = $game_config['LastSettedSystemPos'];
$parse['LastSettedPlanetPos']    = $game_config['LastSettedPlanetPos'];
$parse['enable_link']            = $game_config['link_enable'];
$parse['name_link']              = $game_config['link_name'];
$parse['url_link']               = $game_config['link_url'];
$parse['enable_announces']       = $game_config['enable_announces'];
$parse['enable_marchand']        = $game_config['enable_marchand'];
$parse['enable_notes']           = $game_config['enable_notes'];
$parse['bot_name']               = stripslashes($game_config['bot_name']);
$parse['bot_adress']             = stripslashes($game_config['bot_adress']);
$parse['ban_duration']           = stripslashes($game_config['ban_duration']);
$parse['enable_bot']             = stripslashes($game_config['enable_bot']);
$parse['enable_bbcode']          = stripslashes($game_config['enable_bbcode']);
$parse['banner_source_post']     = $game_config['banner_source_post'];
$parse['stat_settings']          = stripslashes($game_config['stat_settings']);
$parse['closed']                 = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
$parse['close_reason']           = stripslashes( $game_config['close_reason'] );
$parse['newsframe']              = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
$parse['NewsTextVal']            = stripslashes( $game_config['OverviewNewsText'] );
$parse['chatframe']              = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
$parse['ExtTchatVal']            = stripslashes( $game_config['OverviewExternChatCmd'] );
$parse['googlead']               = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
$parse['GoogleAdVal']            = stripslashes( $game_config['OverviewClickBanner'] );
$parse['debug']                  = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";
$parse['bannerframe']            = ($game_config['ForumBannerFrame'] == 1) ? " checked = 'checked' ":"";
$PageTPL                         = gettemplate('admin/einstellung/einstellung_grund');
$Page                           .= parsetemplate( $PageTPL,  $parse );

display ( $Page, $lang['adm_opt_title'], false, '', true );
} } else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
return $Page;
}

$Page = DisplayGameSettingsPage ( $user );

?>