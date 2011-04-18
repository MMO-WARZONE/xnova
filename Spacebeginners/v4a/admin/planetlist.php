<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin');
$parse = $lang;
$query = doquery("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM {{table}} WHERE planet_type=1 ORDER BY id ASC", "planets");
$i = 0;
while ($u = mysql_fetch_array($query)) {
$parse['planetes'] .= "<tr>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['id'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['id_owner'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['name'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['field_max'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['field_current'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['galaxy'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['system'] . "</a></center></b></td>"
. "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."'>" . $u['planet'] . "</a></center></b></td>"
. "</tr>";
$i++;
}

if ($i == "1")
$parse['planetes'] .= "<tr><th class=b colspan=8>1nsgesamt 1 Planet</th></tr>";
else
$parse['planetes'] .= "<tr><th class=b colspan=8>Insgesamt {$i} Planeten</th></tr>";

if(isset($_GET['action']) && isset($_GET['id'])) {
$id = intval($_GET['id']);
$query  = doquery("SELECT * FROM {{table}} WHERE planet_type=1 AND id='".$id."' LIMIT 1", "planets");
$planet = mysql_fetch_array($query);

$parse['show_edit_form'] = parsetemplate(gettemplate('admin/planet_edit_form'),$planet);
}
if(isset($_POST['submit'])) {

$edit_id         = intval($_POST['currid']);
$planetname = mysql_real_escape_string($_POST['planetname']);
$fields_max = intval($_POST['felder']);
$query = doquery("UPDATE {{table}} SET

`name`                      = '".$planetname."',
`field_max`                 = '".$fields_max."',
`metal`                     = '".($_POST['metal'])."',
`crystal`                   = '".($_POST['crystal'])."',
`deuterium`                 = '".($_POST['deuterium'])."',
`appolonium`                 = '".($_POST['appolonium'])."',
`small_ship_cargo`         = '".intval($_POST['small_ship_cargo'])."',
`big_ship_cargo`         = '".intval($_POST['big_ship_cargo'])."',
`light_hunter`                = '".intval($_POST['light_hunter'])."',
`heavy_hunter`                = '".intval($_POST['heavy_hunter'])."',
`crusher`                        = '".intval($_POST['crusher'])."',
`battle_ship`                = '".intval($_POST['battle_ship'])."',
`colonizer`                        = '".intval($_POST['colonizer'])."',
`recycler`                        = '".intval($_POST['recycler'])."',
`spy_sonde`                        = '".intval($_POST['spy_sonde'])."',
`bomber_ship`                = '".intval($_POST['bomber_ship'])."',
`solar_satelit`                = '".intval($_POST['solar_satelit'])."',
`destructor`                = '".intval($_POST['destructor'])."',
`dearth_star`                = '".intval($_POST['dearth_star'])."',
`battleship`                = '".intval($_POST['battleship'])."',
`lune_noir`                    = '".intval($_POST['lune_noir'])."',
`ev_transporter`    = '".intval($_POST['ev_transporter'])."',
`star_crasher`                = '".intval($_POST['star_crasher'])."',
`giga_recykler`                = '".intval($_POST['giga_recykler'])."',
`misil_launcher`        = '".intval($_POST['misil_launcher'])."',
`small_laser`                = '".intval($_POST['small_laser'])."',
`big_laser`                        = '".intval($_POST['big_laser'])."',
`gauss_canyon`                = '".intval($_POST['gauss_canyon'])."',
`ionic_canyon`                = '".intval($_POST['ionic_canyon'])."',
`buster_canyon`                = '".intval($_POST['buster_canyon'])."',
`Gravitonka`                = '".intval($_POST['Gravitonka'])."',
`small_protection_shield`         = '".intval($_POST['small_protection_shield'])."',
`big_protection_shield`         = '".intval($_POST['big_protection_shield'])."',
`gig_protection_shield`         = '".intval($_POST['gig_protection_shield'])."',
`interceptor_misil`                 = '".intval($_POST['interceptor_misil'])."',
`interplanetary_misil`                 = '".intval($_POST['interplanetary_misil'])."',
`metal_mine`                                = '".intval($_POST['metal_mine'])."',
`crystal_mine`                                = '".intval($_POST['crystal_mine'])."',
`deuterium_sintetizer`                = '".intval($_POST['deuterium_sintetizer'])."',
`solar_plant`                                = '".intval($_POST['solar_plant'])."',
`fusion_plant`                                = '".intval($_POST['fusion_plant'])."',
`robot_factory`                                = '".intval($_POST['robot_factory'])."',
`nano_factory`                                = '".intval($_POST['nano_factory'])."',
`hangar`                                        = '".intval($_POST['hangar'])."',
`metal_store`                                = '".intval($_POST['metal_store'])."',
`crystal_store`                                = '".intval($_POST['crystal_store'])."',
`deuterium_store`                        = '".intval($_POST['deuterium_store'])."',
`appolonium_store`                        = '".intval($_POST['appolonium_store'])."',
`laboratory`                                = '".intval($_POST['laboratory'])."',
`technodrom`                                = '".intval($_POST['technodrom'])."',
`ressgate`                                = '".intval($_POST['ressgate'])."',
`mondtransformer`                                = '".intval($_POST['mondtransformer'])."',
`terraformer`                                = '".intval($_POST['terraformer'])."',
`ally_deposit`                                = '".intval($_POST['ally_deposit'])."',
`silo`                                                = '".intval($_POST['silo'])."'
WHERE `id` = '".$edit_id."' LIMIT 1",'planets');
// AdminLOG - Helmchen
$fp = @fopen('logs/adminlog_'.date('d.m.Y').'.php','a');
fwrite($fp, " <?php\n");
fwrite($fp, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
fwrite($fp, "\$Logtext = ' \n");
fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values  from planet with ID ".$edit_id." with user ID: ".$user['id']."';\n");
fwrite($fp, " ?>\n");
fclose($fp);
// AdminLOG ENDE

AdminMessage ('<meta http-equiv="refresh" content="1; url=planetlist.php">Planet wurde erfolgreich geaendert', 'Planeten anpassen');
}
display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), 'Planetlist', false, '', true);
} else {
message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>