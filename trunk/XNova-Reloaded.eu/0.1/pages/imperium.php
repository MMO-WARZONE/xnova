<?php

/**
 * imperium.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */
 
includeLang('imperium');

	$planet = array();
	$parse  = $lang;
	$parse['mount'] = 1;

//Templates includieren
$row  = gettemplate('imperium_row');
$row2 = gettemplate('imperium_row2');
	
//Planeten auslesen
foreach($DB->query("SELECT * FROM `".PREFIX."planets` WHERE `id_owner` = '".$user['id']."'") as $p) {
    //Spalten-Anzahl erhöhen
    $parse['mount']++;

	// {file_images}
	$data['text'] = '<a href="?action=internalHome&amp;cp=' . $p['id'] . '&amp;re=0"><img src="images/planeten/gross/' . $p['image'] . '.jpg" alt="' . $p['image'] . '.jpg" border="0" height="75" width="75"></a>';
	$parse['file_images'] .= parsetemplate($row, $data);
	// {file_names}
	$data['text'] = $p['name'];
	$parse['file_names'] .= parsetemplate($row2, $data);
	// {file_coordinates}
	$data['text'] = "[<a href=\"?action=internalGalaxy&amp;mode=3&amp;galaxy={$p['galaxy']}&amp;system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]";
	$parse['file_coordinates'] .= parsetemplate($row2, $data);
	// {file_fields}
	$data['text'] = $p['field_current'] . '/' . $p['field_max'];
	$parse['file_fields'] .= parsetemplate($row2, $data);
	// {file_metal}
	$data['text'] = '<a href="?action=internalResources&amp;cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['metal']) .'</a> / '. pretty_number($p['metal_perhour']);
	$parse['file_metal'] .= parsetemplate($row2, $data);
	// {file_crystal}
	$data['text'] = '<a href="?action=internalResources&amp;cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['crystal']) .'</a> / '. pretty_number($p['crystal_perhour']);
	$parse['file_crystal'] .= parsetemplate($row2, $data);
	// {file_deuterium}
	$data['text'] = '<a href="?action=internalResources&amp;cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['deuterium']) .'</a> / '. pretty_number($p['deuterium_perhour']);
	$parse['file_deuterium'] .= parsetemplate($row2, $data);
	// {file_energy}
	$data['text'] = pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']);
	$parse['file_energy'] .= parsetemplate($row2, $data);

	foreach ($resource as $i => $res) {
		if (in_array($i, $reslist['build']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"?action=internalBuildings&amp;cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['fleet']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"?action=internalBuildings&amp;mode=fleet&amp;cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
		elseif (in_array($i, $reslist['defense']))
			$data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"?action=internalBuildings&amp;mode=defense&amp;cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";

		$r[$i] .= parsetemplate($row2, $data);
	}
}

// {building_row}
foreach ($reslist['build'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['building_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
// {fleet_row}
foreach ($reslist['fleet'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['fleet_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}
// {defense_row}
foreach ($reslist['defense'] as $a => $i) {
	$data['text'] = $lang['tech'][$i];
	$parse['defense_row'] .= "<tr>" . parsetemplate($row2, $data) . $r[$i] . "</tr>";
}

	display(parsetemplate(gettemplate('imperium_table'), $parse), $lang['Imperium']);

?>