<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** empire.php                            **
******************************************/
     
define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('imperium');

	$planetsrow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$user['id']."';",'planets');

	$planet = array();
	$parse  = $lang;

while ($p = mysql_fetch_array($planetsrow)) {
	$planet[] = $p;
}

$parse['mount'] = count($planet) + 1;
   $row  = gettemplate('imperium_row');
   $row2 = gettemplate('imperium_row2');

foreach ($planet as $p) {
	$data['text'] = '<a href="overview.php?cp=' . $p['id'] . '&amp;re=0"><img src="' . $dpath . 'planeten/small/s_' . $p['image'] . '.jpg" border="0" height="71" width="75"></a>';
	$parse['file_images'] .= parsetemplate($row, $data);

	$data['text'] = $p['name'];
	$parse['file_names'] .= parsetemplate($row2, $data);

	$data['text'] = "[<a href=\"galaxy.php?mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]";
	$parse['file_coordinates'] .= parsetemplate($row2, $data);

	$data['text'] = $p['field_current'] . '/' . $p['field_max'];
	$parse['file_fields'] .= parsetemplate($row2, $data);

	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['metal']) .'</a> / '. pretty_number($p['metal_perhour']);
	$parse['file_metal'] .= parsetemplate($row2, $data);

	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['crystal']) .'</a> / '. pretty_number($p['crystal_perhour']);
	$parse['file_crystal'] .= parsetemplate($row2, $data);

	$data['text'] = '<a href="resources.php?cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['deuterium']) .'</a> / '. pretty_number($p['deuterium_perhour']);
	$parse['file_deuterium'] .= parsetemplate($row2, $data);

	$data['text'] = pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']);
	$parse['file_energy'] .= parsetemplate($row2, $data);

	foreach ($resource as $i => $res) {
		if (in_array($i, $reslist['build']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['tech']))
			$data['text'] = ($user[$resource[$i]] == 0) ? '-' : "<a href=\"buildings.php?mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$user[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['fleet']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['defense']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"buildings.php?mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";

		$r[$i] .= parsetemplate($row2, $data);
	}
}

foreach ($reslist['build'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['building_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

foreach ($reslist['tech'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['technology_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

foreach ($reslist['fleet'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['fleet_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

foreach ($reslist['defense'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['defense_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

$page .= parsetemplate(gettemplate('imperium_table'), $parse);

display($page, $lang['Imperium'], false);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>