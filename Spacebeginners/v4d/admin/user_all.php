<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ($user['authlevel'] >= "1") {
includeLang('admin/grund_elemente');      
includeLang('admin/user/user_all');

$PanelMainTPL = gettemplate('admin/user/user_all01');
$parse        = $lang;

switch($_GET[page])
{
//--------------------------------------------------------------------------------------------------------------------------//
case "add_ress":

if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all02");
$parse     = $lang;
if ($mode == 'addit') {

$id          = $_POST['id'];
$metal       = $_POST['metal'];
$cristal     = $_POST['cristal'];
$deut        = $_POST['deut'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`metal`            = `metal`       + '". $metal ."', ";
$QryUpdatePlanet .= "`crystal`          = `crystal`     + '". $cristal ."', ";
$QryUpdatePlanet .= "`deuterium`        = `deuterium`   + '". $deut ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_all_aa'], $lang['user_all_ab'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_ab'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "add_fleet":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all04");
$parse     = $lang;
if ($mode == 'addit') {

$id                      = $_POST['id'];
$light_hunter            = $_POST['light_hunter'];
$heavy_hunter            = $_POST['heavy_hunter'];
$small_ship_cargo        = $_POST['small_ship_cargo'];
$big_ship_cargo          = $_POST['big_ship_cargo'];
$crusher                 = $_POST['crusher'];
$battle_ship             = $_POST['battle_ship'];
$colonizer               = $_POST['colonizer'];
$recycler                = $_POST['recycler'];
$spy_sonde               = $_POST['spy_sonde'];
$bomber_ship             = $_POST['bomber_ship'];
$solar_satelit           = $_POST['solar_satelit'];
$destructor              = $_POST['destructor'];
$dearth_star             = $_POST['dearth_star'];
$battleship              = $_POST['battleship'];
$lune_noir               = $_POST['lune_noir'];
$ev_transporter          = $_POST['ev_transporter'];
$star_crasher            = $_POST['star_crasher'];
$giga_recykler           = $_POST['giga_recykler'];
$QryUpdatePlanet         = "UPDATE {{table}} SET ";

$QryUpdatePlanet .= "`giga_recykler`     = `giga_recykler`       + '". $giga_recykler ."', ";
$QryUpdatePlanet .= "`star_crasher`      = `star_crasher`        + '". $star_crasher ."', ";
$QryUpdatePlanet .= "`ev_transporter`    = `ev_transporter`      + '". $ev_transporter ."', ";
$QryUpdatePlanet .= "`lune_noir`         = `lune_noir`           + '". $lune_noir  ."', ";
$QryUpdatePlanet .= "`battleship`        = `battleship`          + '". $battleship ."', ";
$QryUpdatePlanet .= "`dearth_star`       = `dearth_star`         + '". $dearth_star ."', ";
$QryUpdatePlanet .= "`destructor`        = `destructor`          + '". $destructor ."', ";
$QryUpdatePlanet .= "`solar_satelit`     = `solar_satelit`       + '". $solar_satelit ."', ";
$QryUpdatePlanet .= "`bomber_ship`       = `bomber_ship`         + '". $bomber_ship ."', ";
$QryUpdatePlanet .= "`spy_sonde`         = `spy_sonde`           + '". $spy_sonde ."', ";
$QryUpdatePlanet .= "`recycler`          = `recycler`            + '". $recycler ."', ";
$QryUpdatePlanet .= "`colonizer`         = `colonizer`           + '". $colonizer ."', ";
$QryUpdatePlanet .= "`battle_ship`       = `battle_ship`         + '". $battle_ship ."', ";
$QryUpdatePlanet .= "`crusher`           = `crusher`             + '". $crusher ."', ";
$QryUpdatePlanet .= "`small_ship_cargo`  = `small_ship_cargo`    + '". $small_ship_cargo ."', ";
$QryUpdatePlanet .= "`big_ship_cargo`    = `big_ship_cargo`      + '". $big_ship_cargo ."', ";
$QryUpdatePlanet .= "`heavy_hunter`      = `heavy_hunter`        + '". $heavy_hunter ."', ";
$QryUpdatePlanet .= "`light_hunter`      = `light_hunter`        + '". $light_hunter ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_all_ac'], $lang['user_all_ad'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_ad'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "add_deff":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all06");
$parse     = $lang;
if ($mode == 'addit') {

$id                              = $_POST['id'];
$misil_launcher                  = $_POST['misil_launcher'];
$small_laser                     = $_POST['small_laser'];
$big_laser                       = $_POST['big_laser'];
$gauss_canyon                    = $_POST['gauss_canyon'];
$ionic_canyon                    = $_POST['ionic_canyon'];
$buster_canyon                   = $_POST['buster_canyon'];
$small_protection_shield         = $_POST['small_protection_shield'];
$big_protection_shield           = $_POST['big_protection_shield'];
$gig_protection_shield           = $_POST['gig_protection_shield'];
$Gravitonka                      = $_POST['Gravitonka'];
$interceptor_misil               = $_POST['interceptor_misil'];
$interplanetary_misil            = $_POST['interplanetary_misil'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`misil_launcher`            = `misil_launcher`              + '". $misil_launcher ."', ";
$QryUpdatePlanet .= "`small_laser`               = `small_laser`                 + '". $small_laser ."', ";
$QryUpdatePlanet .= "`big_laser`                 = `big_laser`                   + '". $big_laser ."', ";
$QryUpdatePlanet .= "`gauss_canyon`              = `gauss_canyon`                + '". $gauss_canyon ."', ";
$QryUpdatePlanet .= "`ionic_canyon`              = `ionic_canyon`                + '". $ionic_canyon ."', ";
$QryUpdatePlanet .= "`buster_canyon`             = `buster_canyon`               + '". $buster_canyon ."', ";
$QryUpdatePlanet .= "`small_protection_shield`   = `small_protection_shield`     + '". $small_protection_shield ."', ";
$QryUpdatePlanet .= "`big_protection_shield`     = `big_protection_shield`       + '". $big_protection_shield ."', ";
$QryUpdatePlanet .= "`gig_protection_shield`     = `gig_protection_shield`       + '". $gig_protection_shield ."', ";
$QryUpdatePlanet .= "`Gravitonka`                = `Gravitonka`                  + '". $Gravitonka  ."', ";
$QryUpdatePlanet .= "`interceptor_misil`         = `interceptor_misil`           + '". $interceptor_misil ."', ";
$QryUpdatePlanet .= "`interplanetary_misil`      = `interplanetary_misil`        + '". $interplanetary_misil ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_all_ae'], $lang['user_all_af'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_af'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "add_gebaude":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all08");
$parse     = $lang;
if ($mode == 'addit') {

$id                      = $_POST['id'];
$metal_mine              = $_POST['metal_mine'];
$crystal_mine            = $_POST['crystal_mine'];
$deuterium_sintetizer    = $_POST['deuterium_sintetizer'];
$solar_plant             = $_POST['solar_plant'];
$fusion_plant            = $_POST['fusion_plant'];
$robot_factory           = $_POST['robot_factory'];
$nano_factory            = $_POST['nano_factory'];
$hangar                  = $_POST['hangar'];
$metal_store             = $_POST['metal_store'];
$crystal_store           = $_POST['crystal_store'];
$deuterium_store         = $_POST['deuterium_store'];
$laboratory              = $_POST['laboratory'];
$terraformer             = $_POST['terraformer'];
$ally_deposit            = $_POST['ally_deposit'];
$silo                    = $_POST['silo'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`metal_mine`                = `metal_mine`                  + '". $metal_mine ."', ";
$QryUpdatePlanet .= "`crystal_mine`              = `crystal_mine`                + '". $crystal_mine ."', ";
$QryUpdatePlanet .= "`deuterium_sintetizer`      = `deuterium_sintetizer`        + '". $deuterium_sintetizer ."', ";
$QryUpdatePlanet .= "`solar_plant`               = `solar_plant`                 + '". $solar_plant ."', ";
$QryUpdatePlanet .= "`fusion_plant`              = `fusion_plant`                + '". $fusion_plant ."', ";
$QryUpdatePlanet .= "`robot_factory`             = `robot_factory`               + '". $robot_factory ."', ";
$QryUpdatePlanet .= "`nano_factory`              = `nano_factory`                + '". $nano_factory ."', ";
$QryUpdatePlanet .= "`hangar`                    = `hangar`                      + '". $hangar ."', ";
$QryUpdatePlanet .= "`metal_store`               = `metal_store`                 + '". $metal_store ."', ";
$QryUpdatePlanet .= "`crystal_store`             = `crystal_store`               + '". $crystal_store ."', ";
$QryUpdatePlanet .= "`deuterium_store`           = `deuterium_store`             + '". $deuterium_store ."', ";
$QryUpdatePlanet .= "`laboratory`                = `laboratory`                  + '". $laboratory ."', ";
$QryUpdatePlanet .= "`terraformer`               = `terraformer`                 + '". $terraformer ."', ";
$QryUpdatePlanet .= "`ally_deposit`              = `ally_deposit`                + '". $ally_deposit ."', ";
$QryUpdatePlanet .= "`silo`                      = `silo`                        + '". $silo ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_all_ag'], $lang['user_all_ah'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_ah'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "add_forsch":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all10");
$parse     = $lang;
if ($mode == 'addit') {

$id                      = $_POST['id'];
$spy_tech                = $_POST['spy_tech'];
$prod_op                 = $_POST['prod_op'];
$computer_tech           = $_POST['computer_tech'];
$military_tech           = $_POST['military_tech'];
$defence_tech            = $_POST['defence_tech'];
$shield_tech             = $_POST['shield_tech'];
$energy_tech             = $_POST['energy_tech'];
$hyperspace_tech         = $_POST['hyperspace_tech'];
$combustion_tech         = $_POST['combustion_tech'];
$impulse_motor_tech      = $_POST['impulse_motor_tech'];
$hyperspace_motor_tech   = $_POST['hyperspace_motor_tech'];
$laser_tech              = $_POST['laser_tech'];
$ionic_tech              = $_POST['ionic_tech'];
$buster_tech             = $_POST['buster_tech'];
$intergalactic_tech      = $_POST['intergalactic_tech'];
$expedition_tech         = $_POST['expedition_tech'];
$graviton_tech           = $_POST['graviton_tech'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`spy_tech`                  = `spy_tech`                    + '". $spy_tech ."', ";
$QryUpdatePlanet .= "`prod_op`                   = `prod_op`                     + '". $prod_op ."', ";
$QryUpdatePlanet .= "`computer_tech`             = `computer_tech`               + '". $computer_tech ."', ";
$QryUpdatePlanet .= "`military_tech`             = `military_tech`               + '". $military_tech ."', ";
$QryUpdatePlanet .= "`defence_tech`              = `defence_tech`                + '". $defence_tech ."', ";
$QryUpdatePlanet .= "`shield_tech`               = `shield_tech`                 + '". $shield_tech ."', ";
$QryUpdatePlanet .= "`energy_tech`               = `energy_tech`                 + '". $energy_tech ."', ";
$QryUpdatePlanet .= "`hyperspace_tech`           = `hyperspace_tech`             + '". $hyperspace_tech ."', ";
$QryUpdatePlanet .= "`combustion_tech`           = `combustion_tech`             + '". $combustion_tech ."', ";
$QryUpdatePlanet .= "`impulse_motor_tech`        = `impulse_motor_tech`          + '". $impulse_motor_tech ."', ";
$QryUpdatePlanet .= "`hyperspace_motor_tech`     = `hyperspace_motor_tech`       + '". $hyperspace_motor_tech ."', ";
$QryUpdatePlanet .= "`laser_tech`                = `laser_tech`                  + '". $laser_tech ."', ";
$QryUpdatePlanet .= "`ionic_tech`                = `ionic_tech`                  + '". $ionic_tech ."', ";
$QryUpdatePlanet .= "`buster_tech`               = `buster_tech`                 + '". $buster_tech ."', ";
$QryUpdatePlanet .= "`intergalactic_tech`        = `intergalactic_tech`          + '". $intergalactic_tech ."', ";
$QryUpdatePlanet .= "`expedition_tech`           = `expedition_tech`             + '". $expedition_tech ."', ";
$QryUpdatePlanet .= "`graviton_tech`             = `graviton_tech`               + '". $graviton_tech ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "users");

AdminMessage ( $lang['user_all_ai'], $lang['user_all_aj'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_aj'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "add_offis":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all12");
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
$QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` + '". $rpg_empereur ."', ";
$QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` + '". $rpg_ingenieur ."', ";
$QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` + '". $rpg_raideur ."', ";
$QryUpdatePlanet .= "`rpg_general` = `rpg_general` + '". $rpg_general ."', ";
$QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` + '". $rpg_destructeur ."', ";
$QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` + '". $rpg_commandant ."', ";
$QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` + '". $rpg_espion ."', ";
$QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` + '". $rpg_bunker ."', ";
$QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` + '". $rpg_defenseur ."', ";
$QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` + '". $rpg_stockeur ."', ";
$QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` + '". $rpg_scientifique ."', ";
$QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` + '". $rpg_constructeur ."', ";
$QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` + '". $rpg_amiral ."', ";
$QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` + '". $rpg_technocrate ."', ";
$QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` + '". $rpg_geologue ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "users");

AdminMessage ( $lang['user_all_ak'], $lang['user_all_al'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_all_al'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_ress":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all03");
$parse     = $lang;
if ($mode == 'addit') {

$id          = $_POST['id'];
$metal       = $_POST['metal'];
$cristal     = $_POST['cristal'];
$deut        = $_POST['deut'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`metal`             = `metal`       - '". $metal ."', ";
$QryUpdatePlanet .= "`crystal`           = `crystal`     - '". $cristal ."', ";
$QryUpdatePlanet .= "`deuterium`         = `deuterium`   - '". $deut ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_del_ab'], $lang['user_del_aa'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_aa'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_fleet":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all05");
$parse     = $lang;
if ($mode == 'addit') {

$id                      = $_POST['id'];
$light_hunter            = $_POST['light_hunter'];
$heavy_hunter            = $_POST['heavy_hunter'];
$small_ship_cargo        = $_POST['small_ship_cargo'];
$big_ship_cargo          = $_POST['big_ship_cargo'];
$crusher                 = $_POST['crusher'];
$battle_ship             = $_POST['battle_ship'];
$colonizer               = $_POST['colonizer'];
$recycler                = $_POST['recycler'];
$spy_sonde               = $_POST['spy_sonde'];
$bomber_ship             = $_POST['bomber_ship'];
$solar_satelit           = $_POST['solar_satelit'];
$destructor              = $_POST['destructor'];
$dearth_star             = $_POST['dearth_star'];
$battleship              = $_POST['battleship'];
$lune_noir               = $_POST['lune_noir'];
$ev_transporter          = $_POST['ev_transporter'];
$star_crasher            = $_POST['star_crasher'];
$giga_recykler           = $_POST['giga_recykler'];
$QryUpdatePlanet         = "UPDATE {{table}} SET ";

$QryUpdatePlanet .= "`giga_recykler`     = `giga_recykler`       - '". $giga_recykler ."', ";
$QryUpdatePlanet .= "`star_crasher`      = `star_crasher`        - '". $star_crasher ."', ";
$QryUpdatePlanet .= "`ev_transporter`    = `ev_transporter`      - '". $ev_transporter ."', ";
$QryUpdatePlanet .= "`lune_noir`         = `lune_noir`           - '". $lune_noir  ."', ";
$QryUpdatePlanet .= "`battleship`        = `battleship`          - '". $battleship ."', ";
$QryUpdatePlanet .= "`dearth_star`       = `dearth_star`         - '". $dearth_star ."', ";
$QryUpdatePlanet .= "`destructor`        = `destructor`          - '". $destructor ."', ";
$QryUpdatePlanet .= "`solar_satelit`     = `solar_satelit`       - '". $solar_satelit ."', ";
$QryUpdatePlanet .= "`bomber_ship`       = `bomber_ship`         - '". $bomber_ship ."', ";
$QryUpdatePlanet .= "`spy_sonde`         = `spy_sonde`           - '". $spy_sonde ."', ";
$QryUpdatePlanet .= "`recycler`          = `recycler`            - '". $recycler ."', ";
$QryUpdatePlanet .= "`colonizer`         = `colonizer`           - '". $colonizer ."', ";
$QryUpdatePlanet .= "`battle_ship`       = `battle_ship`         - '". $battle_ship ."', ";
$QryUpdatePlanet .= "`crusher`           = `crusher`             - '". $crusher ."', ";
$QryUpdatePlanet .= "`big_ship_cargo`    = `big_ship_cargo`      - '". $big_ship_cargo ."', ";
$QryUpdatePlanet .= "`small_ship_cargo`  = `small_ship_cargo`    - '". $small_ship_cargo ."', ";
$QryUpdatePlanet .= "`heavy_hunter`      = `heavy_hunter`        - '". $heavy_hunter ."', ";
$QryUpdatePlanet .= "`light_hunter`      = `light_hunter`        - '". $light_hunter ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_del_ac'], $lang['user_del_ad'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_ad'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_deff":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all07");
$parse     = $lang;
if ($mode == 'addit') {

$id          = $_POST['id'];
$misil_launcher       = $_POST['misil_launcher'];
$small_laser    = $_POST['small_laser'];
$big_laser        = $_POST['big_laser'];
$gauss_canyon        = $_POST['gauss_canyon'];
$ionic_canyon    = $_POST['ionic_canyon'];
$buster_canyon        = $_POST['buster_canyon'];
$small_protection_shield      = $_POST['small_protection_shield'];
$big_protection_shield        = $_POST['big_protection_shield'];
$gig_protection_shield       = $_POST['gig_protection_shield'];
$Gravitonka        = $_POST['Gravitonka'];
$interceptor_misil       = $_POST['interceptor_misil'];
$interplanetary_misil      = $_POST['interplanetary_misil'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` - '". $misil_launcher ."', ";
$QryUpdatePlanet .= "`small_laser` = `small_laser` - '". $small_laser ."', ";
$QryUpdatePlanet .= "`big_laser` = `big_laser` - '". $big_laser ."', ";
$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` - '". $gauss_canyon ."', ";
$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` - '". $ionic_canyon ."', ";
$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` - '". $buster_canyon ."', ";
$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` - '". $small_protection_shield ."', ";
$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` - '". $big_protection_shield ."', ";
$QryUpdatePlanet .= "`gig_protection_shield` = `gig_protection_shield` - '". $gig_protection_shield ."', ";
$QryUpdatePlanet .= "`Gravitonka` = `Gravitonka` - '". $Gravitonka  ."', ";
$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` - '". $interceptor_misil ."', ";
$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` - '". $interplanetary_misil ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_del_ae'], $lang['user_del_af'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_af'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_gebaude":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all09");
$parse     = $lang;
if ($mode == 'addit') {

$id          = $_POST['id'];
$metal_mine       = $_POST['metal_mine'];
$crystal_mine    = $_POST['crystal_mine'];
$deuterium_sintetizer        = $_POST['deuterium_sintetizer'];
$solar_plant        = $_POST['solar_plant'];
$fusion_plant    = $_POST['fusion_plant'];
$robot_factory        = $_POST['robot_factory'];
$nano_factory      = $_POST['nano_factory'];
$hangar        = $_POST['hangar'];
$metal_store       = $_POST['metal_store'];
$crystal_store      = $_POST['crystal_store'];
$deuterium_store     = $_POST['deuterium_store'];
$laboratory       = $_POST['laboratory'];
$terraformer       = $_POST['terraformer'];
$ally_deposit      = $_POST['ally_deposit'];
$silo      = $_POST['silo'];

$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= "`metal_mine` = `metal_mine` - '". $metal_mine ."', ";
$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` - '". $crystal_mine ."', ";
$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` - '". $deuterium_sintetizer ."', ";
$QryUpdatePlanet .= "`solar_plant` = `solar_plant` - '". $solar_plant ."', ";
$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` - '". $fusion_plant ."', ";
$QryUpdatePlanet .= "`robot_factory` = `robot_factory` - '". $robot_factory ."', ";
$QryUpdatePlanet .= "`nano_factory` = `nano_factory` - '". $nano_factory ."', ";
$QryUpdatePlanet .= "`hangar` = `hangar` - '". $hangar ."', ";
$QryUpdatePlanet .= "`metal_store` = `metal_store` - '". $metal_store ."', ";
$QryUpdatePlanet .= "`crystal_store` = `crystal_store` - '". $crystal_store ."', ";
$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` - '". $deuterium_store ."', ";
$QryUpdatePlanet .= "`laboratory` = `laboratory` - '". $laboratory ."', ";
$QryUpdatePlanet .= "`terraformer` = `terraformer` - '". $terraformer ."', ";
$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` - '". $ally_deposit ."', ";
$QryUpdatePlanet .= "`silo` = `silo` - '". $silo ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "planets");

AdminMessage ( $lang['user_del_ag'], $lang['user_del_ah'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_ah'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_forsch":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all11");
$parse     = $lang;
if ($mode == 'addit') {

$id          = $_POST['id'];
$spy_tech       = $_POST['spy_tech'];
$prod_op    = $_POST['prod_op'];
$computer_tech    = $_POST['computer_tech'];
$military_tech        = $_POST['military_tech'];
$defence_tech        = $_POST['defence_tech'];
$shield_tech    = $_POST['shield_tech'];
$energy_tech        = $_POST['energy_tech'];
$hyperspace_tech      = $_POST['hyperspace_tech'];
$combustion_tech        = $_POST['combustion_tech'];
$impulse_motor_tech       = $_POST['impulse_motor_tech'];
$hyperspace_motor_tech      = $_POST['hyperspace_motor_tech'];
$laser_tech     = $_POST['laser_tech'];
$ionic_tech       = $_POST['ionic_tech'];
$buster_tech       = $_POST['buster_tech'];
$intergalactic_tech     = $_POST['intergalactic_tech'];
$expedition_tech     = $_POST['expedition_tech'];
$graviton_tech     = $_POST['graviton_tech'];
$QryUpdatePlanet  = "UPDATE {{table}} SET ";

$QryUpdatePlanet .= "`spy_tech` = `spy_tech` - '". $spy_tech ."', ";
$QryUpdatePlanet .= "`prod_op` = `prod_op` - '". $prod_op ."', ";
$QryUpdatePlanet .= "`computer_tech` = `computer_tech` - '". $computer_tech ."', ";
$QryUpdatePlanet .= "`military_tech` = `military_tech` - '". $military_tech ."', ";
$QryUpdatePlanet .= "`defence_tech` = `defence_tech` - '". $defence_tech ."', ";
$QryUpdatePlanet .= "`shield_tech` = `shield_tech` - '". $shield_tech ."', ";
$QryUpdatePlanet .= "`energy_tech` = `energy_tech` - '". $energy_tech ."', ";
$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` - '". $hyperspace_tech ."', ";
$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` - '". $combustion_tech ."', ";
$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` - '". $impulse_motor_tech ."', ";
$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` - '". $hyperspace_motor_tech ."', ";
$QryUpdatePlanet .= "`laser_tech` = `laser_tech` - '". $laser_tech ."', ";
$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` - '". $ionic_tech ."', ";
$QryUpdatePlanet .= "`buster_tech` = `buster_tech` - '". $buster_tech ."', ";
$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` - '". $intergalactic_tech ."', ";
$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` - '". $expedition_tech ."', ";
$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` - '". $graviton_tech ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $id ."' ";
doquery( $QryUpdatePlanet, "users");

AdminMessage ( $lang['user_del_ai'], $lang['user_del_aj'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_aj'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//
case "del_offis":

if ($user['authlevel'] >= 2) {

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_all13");
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

AdminMessage ( $lang['user_del_ai'], $lang['user_del_aj'] );
}
$Page = parsetemplate($PageTpl, $parse);

display ($Page, $lang['user_del_aj'], false, '', true);
} else {
AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

break;
//--------------------------------------------------------------------------------------------------------------------------//

default:
}

$page = parsetemplate( $PanelMainTPL, $parse );
display( $page, $lang['panel_mainttl'], false, '', true );
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>