<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowImperiumPage($CurrentUser)
{
	global $lang, $resource, $reslist, $dpath;

	$planetsrow = doquery("
	SELECT `id`,`name`,`galaxy`,`system`,`planet`,`planet_type`,
	`image`,`field_current`,`field_max`,`metal`,`metal_perhour`,
	`crystal`,`crystal_perhour`,`deuterium`,`deuterium_perhour`,`darkmatter`,`darkmatter_perhour`,
	`energy_used`,`energy_max`,`metal_mine`,`crystal_mine`,`deuterium_sintetizer`,`darkmatter_mine`,
	`solar_plant`,`fusion_plant`,`robot_factory`,`nano_factory`,`hangar`,`metal_store`,
	`crystal_store`,`deuterium_store`,`darkmatter_store`,`laboratory`,`terraformer`,`ally_deposit`,`silo`,
	`small_ship_cargo`,`big_ship_cargo`,`light_hunter`,`heavy_hunter`,`crusher`,`battle_ship`,
	`colonizer`,`recycler`,`spy_sonde`,`bomber_ship`,`solar_satelit`,`destructor`,`dearth_star`,
	`battleship`,`misil_launcher`,`small_laser`,`big_laser`,`gauss_canyon`,`ionic_canyon`,
	`buster_canyon`,`small_protection_shield`,`big_protection_shield`,`interceptor_misil`,
	`interplanetary_misil`, `mondbasis`, `phalanx`, `sprungtor` FROM {{table}} WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `destruyed` = 0;", 'planets');

	$parse 	= $lang;
	$planet = array();

	while ($p = mysql_fetch_array($planetsrow))
	{
		$planet[] = $p;
	}

	$parse['mount'] = count($planet) + 1;

	foreach ($planet as $p)
	{
		$datat = array('<a href="game.php?page=overview&cp=' . $p['id'] . '&amp;re=0"><img src="' . $dpath . 'planeten/small/s_' . $p['image'] . '.jpg" border="0" height="80" width="80"></a>', $p['name'], "[<a href=\"game.php?page=galaxy&mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]", $p['field_current'] . '/' . $p['field_max'], '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['metal']) . '</a> / ' . pretty_number($p['metal_perhour']), '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'  . pretty_number($p['darkmatter']) . '</a> / ' . pretty_number($p['darkmatter_perhour']), '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['crystal']) . '</a> / ' . pretty_number($p['crystal_perhour']), '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['deuterium']) . '</a> / ' . pretty_number($p['deuterium_perhour']), pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']));
		$f = array('file_images', 'file_names', 'file_coordinates', 'file_fields', 'file_metal', 'file_darkmatter', 'file_crystal', 'file_deuterium','file_energy');
		for ($k = 0; $k < 8; $k++)
		{
			$data['text'] = $datat[$k];
			$parse[$f[$k]] .= parsetemplate(gettemplate('empire/empire_row'), $data);
		}

		foreach ($resource as $i => $res)
		{
			$data['text'] = ($p[$resource[$i]] == 0 && $CurrentUser[$resource[$i]] == 0) ? '-' : ((in_array($i, $reslist['build'])) ? "<a href=\"game.php?page=buildings&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['tech'])) ? "<a href=\"game.php?page=buildings&mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$CurrentUser[$resource[$i]]}</a>" : ((in_array($i, $reslist['fleet'])) ? "<a href=\"game.php?page=buildings&mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['defense'])) ? "<a href=\"game.php?page=buildings&mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : '-'))));
			$r[$i] .= parsetemplate(gettemplate('empire/empire_row'), $data);
		}
	}

	$m = array('build', 'tech', 'fleet', 'defense');

	$n = array('building_row', 'technology_row', 'fleet_row', 'defense_row');

	for ($j = 0; $j < 4; $j++)
	{
		foreach ($reslist[$m[$j]] as $a => $i)
		{
			$data['text'] = $lang['tech'][$i];
			$parse[$n[$j]] .= "<tr>" . parsetemplate(gettemplate('empire/empire_row'), $data, $parse) . $r[$i] . "</tr>";
		}
	}

	return display(parsetemplate(gettemplate('empire/empire_table'), $parse));
}
?>
