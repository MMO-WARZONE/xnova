<?php
/**
* imperium.php
*
* @version 1
* @copyright 2008 by Chlorel for XNova
*/


define('INSIDE', true);
define('INSTALL', false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('imperium');

if ($IsUserChecked == false) {
   includeLang('fehler');
   message($lang['check01'], $lang['check02']);
}

if ($user['urlaubs_modus'] == 1){
   includeLang('fehler');
   message($lang['Urlaub01'], $lang['Urlaub02']);
}

$planetsrow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '" . $user['id'] . "';", 'planets');

$planet = array();
$parse = $lang;

while ($p = mysql_fetch_array($planetsrow)) {
$planet[] = $p;
}

$parse['mount'] = count($planet) + 1;
$row = gettemplate('imperium_row');
$row2 = gettemplate('imperium_row2');

foreach ($planet as $p) {
$datat = array('<a href="overview.php?cp=' . $p['id'] . '&amp;re=0"><img src="' . $dpath . 'planeten/' . $p['image'] . '.gif" border="0" height="80" width="80"></a>', $p['name'], "[<a href=\"galaxy.php?mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]", $p['field_current'] . '/' . $p['field_max'], '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['metal']) . '</a> / ' . pretty_number($p['metal_perhour']), '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['crystal']) . '</a> / ' . pretty_number($p['crystal_perhour']),'<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['deuterium']) . '</a> / ' . pretty_number($p['deuterium_perhour']), '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['appolonium']) . '</a> / ' . pretty_number($p['appolonium_perhour']), pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']));
$f = array('file_images', 'file_names', 'file_coordinates', 'file_fields', 'file_metal', 'file_crystal', 'file_deuterium', 'file_appolonium', 'file_energy');
for ($k = 0; $k < 9; $k++) {
$data['text'] = $datat[$k];
$parse[$f[$k]] .= parsetemplate($row, $data);
}

foreach ($resource as $i => $res) {
$data['text'] = ($p[$resource[$i]] == 0) ? '-' : ((in_array($i, $reslist['build'])) ? "<a href=\"buildings.php?cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['tech'])) ? "<a href=\"buildings.php?mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$user[$resource[$i]]}</a>" : ((in_array($i, $reslist['fleet'])) ? "<a href=\"buildings.php?mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['defense'])) ? "<a href=\"buildings.php?mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : '-'))));
$r[$i] .= parsetemplate($row2, $data);
}
}
$m = array('build', 'tech', 'fleet', 'defense');
$n = array('building_row', 'technology_row', 'fleet_row', 'defense_row');
for ($j = 0; $j < 4; $j++) {
foreach ($reslist[$m[$j]] as $a => $i) {
$data['text'] = $lang['tech'][$i];
$parse[$n[$j]] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
}


$page .= parsetemplate(gettemplate('imperium_table'), $parse);

display($page, $lang['Imperium']);
// Created by Perberos. All rights reserved (C) 2006
//Modified by BenjaminV
?>