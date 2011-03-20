<?php
// einstellung_reset.php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('admin/einstellung/einstellung_reset');

function XNovaResetUnivers ( $CurrentUser ) {
global $lang, $Adminerlaubt, $user;

if ($user['username'] == Metusalem and in_array ($user['id'],$Adminerlaubt) ) {

doquery( "RENAME TABLE {{table}} TO {{table}}_s", 'planets' );
doquery( "RENAME TABLE {{table}} TO {{table}}_s", 'users' );
doquery( "CREATE  TABLE IF NOT EXISTS {{table}} ( LIKE {{table}}_s );", 'planets');
doquery( "CREATE  TABLE IF NOT EXISTS {{table}} ( LIKE {{table}}_s );", 'users');

doquery( "TRUNCATE TABLE {{table}}", 'aks');
doquery( "TRUNCATE TABLE {{table}}", 'alliance');
doquery( "TRUNCATE TABLE {{table}}", 'annonce');
doquery( "TRUNCATE TABLE {{table}}", 'banned');
doquery( "TRUNCATE TABLE {{table}}", 'buddy');
doquery( "TRUNCATE TABLE {{table}}", 'chat');
doquery( "TRUNCATE TABLE {{table}}", 'galaxy');
doquery( "TRUNCATE TABLE {{table}}", 'errors');
doquery( "TRUNCATE TABLE {{table}}", 'fleets');
doquery( "TRUNCATE TABLE {{table}}", 'iraks');
doquery( "TRUNCATE TABLE {{table}}", 'lunas');
doquery( "TRUNCATE TABLE {{table}}", 'messages');
doquery( "TRUNCATE TABLE {{table}}", 'notes');
doquery( "TRUNCATE TABLE {{table}}", 'rw');
doquery( "TRUNCATE TABLE {{table}}", 'statpoints');

$AllUsers  = doquery ("SELECT `username`,`password`,`email`, `email_2`,`authlevel`,`galaxy`,`system`,`planet`, `volk`, `sex`, `avatar`, `dpath`, `onlinetime`, `register_time`, `id_planet` FROM {{table}} WHERE 1;", 'users_s');
$LimitTime = time() - (15 * (24 * (60 * 60)));
$TransUser = 0;
while ( $TheUser = mysql_fetch_assoc($AllUsers) ) {
if ( $TheUser['onlinetime'] > $LimitTime ) {
$UserPlanet     = doquery ("SELECT `name` FROM {{table}} WHERE `id` = '". $TheUser['id_planet']."';", 'planets_s', true);
if ($UserPlanet['name'] != "") {

$QryInsertUser  = "INSERT INTO {{table}} SET ";
$QryInsertUser .= "`username` = '".      $TheUser['username']      ."', ";
$QryInsertUser .= "`email` = '".         $TheUser['email']         ."', ";
$QryInsertUser .= "`email_2` = '".       $TheUser['email_2']       ."', ";
$QryInsertUser .= "`volk` = '".          $TheUser['volk']        ."', ";
$QryInsertUser .= "`sex` = '".           $TheUser['sex']           ."', ";
$QryInsertUser .= "`avatar` = '".        $TheUser['avatar']        ."', ";
$QryInsertUser .= "`id_planet` = '1', ";
$QryInsertUser .= "`authlevel` = '".     $TheUser['authlevel']     ."', ";
$QryInsertUser .= "`dpath` = '".         $TheUser['dpath']         ."', ";
$QryInsertUser .= "`galaxy` = '".        $TheUser['galaxy']        ."', ";
$QryInsertUser .= "`system` = '".        $TheUser['system']        ."', ";
$QryInsertUser .= "`planet` = '".        $TheUser['planet']        ."', ";
$QryInsertUser .= "`register_time` = '". $TheUser['register_time'] ."', ";
$QryInsertUser .= "`password` = '".      $TheUser['password']      ."';";
doquery( $QryInsertUser, 'users');

$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". $TheUser['username'] ."' LIMIT 1;", 'users', true);
CreateOnePlanetRecord ($TheUser['galaxy'], $TheUser['system'], $TheUser['planet'], $NewUser['id'], $UserPlanet['name'], true);
$PlanetID       = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

$QryUpdateUser  = "UPDATE {{table}} SET ";
$QryUpdateUser .= "`id_planet` = '".      $PlanetID['id'] ."', ";
$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."' ";
$QryUpdateUser .= "WHERE ";
$QryUpdateUser .= "`id` = '".             $NewUser['id']  ."';";
doquery( $QryUpdateUser, 'users');
$TransUser++;
} } }

doquery("UPDATE {{table}} SET `config_value` = '". $TransUser ."' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
//Piraten einfügen in Galaxy
$QryTableGalaxypirat      = "INSERT INTO `{{table}}` (`galaxy`, `system`, `planet`, `id_planet`, `metal`, `crystal`,  `deuterium`, `appolonium`,`id_luna`, `luna`) VALUES";
$QryTableGalaxypirat     .= "(1, 22, 7, 2, 0, 0, 0, 0, 0, 0),";
$QryTableGalaxypirat     .= "(1, 27, 12, 3, 0, 0, 0, 0, 0, 0),";
$QryTableGalaxypirat     .= "(1, 40, 6, 4, 0, 0, 0, 0, 0, 0);";
doquery( $QryTableGalaxypirat, 'galaxy');
//Ende
//Pirat einfügen in Planets
$QryTablePlanetspirat     = "INSERT INTO `{{table}}` (`id`, `name`, `id_owner`, `id_level`, `galaxy`, `system`, `planet`, `last_update`, `planet_type`, `destruyed`, `b_building`, `b_building_id`, `b_tech`, `b_tech_id`, `b_hangar`, `b_hangar_id`, `b_hangar_plus`, `image`, `diameter`, `points`, `ranks`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `metal_perhour`, `metal_max`, `crystal`, `crystal_perhour`, `crystal_max`, `deuterium`, `deuterium_perhour`, `deuterium_max`, `appolonium`, `appolonium_perhour`, `appolonium_max`, `energy_used`, `energy_max`, `metal_mine`, `crystal_mine`, `deuterium_sintetizer`, `appolonium_mine`,`solar_plant`, `fusion_plant`, `robot_factory`, `nano_factory`, `hangar`, `defence_factory`, `metal_store`, `crystal_store`, `deuterium_store`, `appolonium_store`, `laboratory`, `technodrom`, `ressgate`, `mondtransformer`, `terraformer`, `ally_deposit`, `silo`, `small_ship_cargo`, `big_ship_cargo`, `light_hunter`, `heavy_hunter`, `crusher`, `battle_ship`, `colonizer`, `recycler`, `spy_sonde`, `bomber_ship`, `solar_satelit`, `destructor`, `dearth_star`, `battleship`, `lune_noir`, `ev_transporter`, `star_crasher`, `giga_recykler`, `misil_launcher`, `small_laser`, `big_laser`, `gauss_canyon`, `ionic_canyon`, `buster_canyon`, `Gravitonka`, `small_protection_shield`, `big_protection_shield`, `gig_protection_shield`, `interceptor_misil`, `interplanetary_misil`, `metal_mine_porcent`, `crystal_mine_porcent`, `deuterium_sintetizer_porcent`, `appolonium_mine_porcent`, `solar_plant_porcent`, `fusion_plant_porcent`, `solar_satelit_porcent`, `mondbasis`, `phalanx`, `sprungtor`, `last_jump_time`, `last_beam_time`, `deuterium_used`) VALUES";
$QryTablePlanetspirat    .= "(2, 'Piratentraum', 2, 0, 1, 22, 7, 1269344553, 1, 0, 0, '0', 0, 0, 0, '', 0, 'piratenplanet', 74475, 844901055, 0, 292, 1000, -11, 29, 1373487083, 222862, 60455000000, 1093524482, 148574, 60455000000, 756888034, 90557, 60455000000, 0, 0, 15000000, -314091, 1643471, 30, 30, 30, 0, 50, 0, 16, 12, 22, 1, 20, 20, 20, 0, 20, 0, 0, 1, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1000, 0, 10000, 0, 5000, 5000, 10000, 1000, 0, 1893, 19367, 0, 1851, 1537, 5726, 5700, '', '', '', 0, 0, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0, 0, 0, 0, '0'),";
$QryTablePlanetspirat    .= "(3, 'Piratenbay', 3, 0, 1, 27, 12, 1268088532, 1, 0, 0, '0', 0, 0, 0, '', 0, 'piratenplanet', 74475, 79382496920, 0, 126, 1000, -68, -28, 7625585342, 0, 15000000, 3786419255, 0, 15000000, 209142083, 0, 15000000, 15428405293, 0, 15000000, 0, 0, 0, 0, 0, 0, 0, 0, 11, 25, 20, 18, 0, 0, 0, 0, 22, 0, 0, 0, 30, 23898, 95964, 10000, 10000, 20000, 21996, 0, 0, 0, 12000, 0, 25000, 30300, 53003, 23000, 30000, 54000, 0, 0, 0, 0, 0, 0, 0, 0, '0', '0', '0', 0, 0, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0, 0, 0, 0, '0'),";
$QryTablePlanetspirat    .= "(4, 'Pirateninsel', 4, 0, 1, 40, 6, 1268088673, 1, 0, 0, '0', 0, 0, 0, '', 0, 'piratenplanet', 74475, 25536577446, 0, 319, 1000, 65, 105, 19814353549, 7820799, 154750000000, 2399046214, 4093531, 154750000000, 2935250625, 1714689, 154750000000, 12384079222, 0, 15000000, -7991672, 16904282, 40, 38, 0, 36, 50, 0, 18, 20, 22, 0, 22, 22, 22, 0, 16, 0, 0, 1, 12, 1832, 0, 0, 0, 0, 0, 0, 0, 0, 4113, 0, 5545, 24254, 0, 12276, 0, 50150, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', 0, 0, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0, 0, 0, 0, '0');";
doquery( $QryTablePlanetspirat, 'planets');
//Ende
//Pirat einfügen in Users
$QryTableUserspirat       = "INSERT INTO `{{table}}` (`id`, `username`, `password`, `email`, `email_2`, `lang`, `authlevel`, `volk`, `sex`, `avatar`, `sign`, `id_planet`, `galaxy`, `system`, `planet`, `current_planet`, `user_lastip`, `ip_at_reg`, `user_agent`, `current_page`, `register_time`, `onlinetime`, `dpath`, `design`, `noipcheck`, `planet_sort`, `planet_sort_order`, `spio_anz`, `settings_tooltiptime`, `settings_fleetactions`, `settings_allylogo`, `settings_esp`, `settings_wri`, `settings_bud`, `settings_mis`, `settings_rep`, `urlaubs_modus`, `urlaubs_modus_time`, `urlaubs_until`, `db_deaktjava`, `new_message`, `fleet_shortcut`, `b_tech_planet`, `spy_tech`, `prod_op`, `computer_tech`, `military_tech`, `defence_tech`, `shield_tech`, `energy_tech`, `hyperspace_tech`, `combustion_tech`, `impulse_motor_tech`, `hyperspace_motor_tech`, `laser_tech`, `ionic_tech`, `buster_tech`, `intergalactic_tech`, `expedition_tech`, `graviton_tech`, `ally_id`, `ally_name`, `ally_request`, `ally_request_text`, `ally_register_time`, `ally_rank_id`, `current_luna`, `kolorminus`, `kolorplus`, `kolorpoziom`, `rpg_geologue`, `rpg_amiral`, `rpg_ingenieur`, `rpg_technocrate`, `rpg_espion`, `rpg_constructeur`, `rpg_scientifique`, `rpg_commandant`, `rpg_points`, `rpg_stockeur`, `rpg_defenseur`, `rpg_destructeur`, `rpg_general`, `rpg_bunker`, `rpg_raideur`, `rpg_empereur`, `lvl_minier`, `lvl_raid`, `xpraid`, `xpminier`, `raids`, `p_infligees`, `mnl_alliance`, `mnl_joueur`, `mnl_attaque`, `mnl_spy`, `mnl_exploit`, `mnl_transport`, `mnl_expedition`, `mnl_general`, `mnl_buildlist`, `bana`, `multi_validated`, `banaday`, `raids1`, `raidswin`, `raidsloose`, `wons`, `loos`, `draws`, `kbmetal`, `kbcrystal`, `kbappolonium`, `lostunits`, `desunits`, `inaktivitaet`, `deltime`, `NoteOp`, `angriffszone`) VALUES";
$QryTableUserspirat      .= "(2, 'Sorry', 'd3e9a99a09a8c6d7fb8c78cf4e5a9a2c', 'pirat1@gmx.de', 'pirat1@gmx.de', 'de', 0, 'A', 'M', 'A', NULL, 2, 1, 22, 7, 2, '101.96.157.19', '', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)', '/V4/galaxy.php?mode=0', 1262876845, 1269344553, '', 1, 1, 0, 0, 1, 5, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, NULL, 0, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 9, 0, ' ', 0, NULL, 0, 0, 0, 'red', '#00FF00', 'yellow', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 22, 0, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 10, 12, 16, 11, 1, 826982958900, 404100470600, 0, 1663651468000, 528635861544, 1, 0, NULL, 15),";
$QryTableUserspirat      .= "(3, 'Piratenbraut', 'd3e9a99a09a8c6d7fb8c78cf4e5a9a2c', 'pirat2@gmx.de', 'pirat2@gmx.de', 'de', 0, 'B', 'F', 'http://metusalem.spacequadrat.de/XNovav3/images/Piratenbraut.gif', NULL, 3, 1, 27, 12, 3, '102.130.71.234', '', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)', '/V4/logout.php', 1264720663, 1268088537, '', 1, 1, 0, 0, 1, 5, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, NULL, 0, 40, 22, 20, 30, 30, 30, 20, 20, 30, 28, 26, 25, 20, 20, 14, 20, 9, 0, ' ', 0, NULL, 0, 0, 0, '', '', '', 13, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 1, 18, 357, 0, 357, 0, 0, 5, 436, 13, 0, 2, 0, 0, 2, 0, NULL, 0, NULL, 59, 298, 60, 303, 6, 78538938741600, 39038059820800, 0, 181926332209000, 5103990687710, 1, 0, NULL, 15),";
$QryTableUserspirat      .= "(4, 'Rotzloeffel', 'd3e9a99a09a8c6d7fb8c78cf4e5a9a2c', 'pirat3@gmx.de', 'pirat3@gmx.de', 'de', 0, 'C', 'M', 'C', NULL, 4, 1, 40, 6, 4, '103.130.71.234', '', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)', '/V4/overview.php', 1266780179, 1268088673, '', 1, 1, 0, 0, 1, 5, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, NULL, 0, 30, 22, 20, 33, 33, 33, 22, 20, 22, 21, 20, 25, 20, 20, 14, 15, 9, 0, ' ', 0, NULL, 0, 0, 0, 'red', '#00FF00', 'yellow', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 28, 0, 28, 0, 0, 1, 44, 2, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 11, 17, 20, 13, 0, 2937103255370, 1754575698710, 0, 7528558047000, 1484141972300, 0, 0, NULL, 15);";
doquery( $QryTableUserspirat, 'users');
//Ende

doquery("DROP TABLE {{table}}", 'planets_s');
doquery("DROP TABLE {{table}}", 'users_s');

AdminMessage ( $TransUser . $lang['adm_rz_done'], $lang['adm_rz_ttle'] );
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
return $Page;
}

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/einstellung/einstellung_reset");
$parse     = $lang;

if ($mode == 'reset') {
XNovaResetUnivers ( $user );
} else {
$Page = parsetemplate($PageTpl, $parse);
display ($Page, $lang['Reset'], false, '', true);
}

?>