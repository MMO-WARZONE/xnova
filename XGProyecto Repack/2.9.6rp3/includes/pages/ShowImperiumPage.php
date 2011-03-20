<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function sumar_array($array1, $array2){
	foreach($array2 as $Key => $Value){
		if(isset($array1[$Key])){
			$array1[$Key] += $Value;
		}else{
			$array1[$Key] = $Value;
		}
	}
	return $array1;
}

function planet_empire_sort($val1, $val2){
	if($val1 === 'sum'){
		return 1;
	}elseif($val2 === 'sum'){
		return -1;
	}elseif($val1 < $val2){
		return -1;
	}elseif($val1 > $val2){
		return 1;
	}elseif($val1 == $val2){
		return 0;
	}
}

function ShowImperiumPage($CurrentUser)
{
	global $lang, $resource, $reslist, $dpath;
	$lang['imperium_vision'] = 'Visi&oacute;n general del Imperio';
	$lang['name'] = 'Planeta';
	$lang['coordinates'] = 'Coordenadas';
	$lang['fields'] = 'Campos';
	$lang['resources'] = 'Recursos';
	$lang['buildings'] = 'Edificios';
	$lang['investigation'] = 'Investigaciones';
	$lang['ships'] = 'Flotas';
	$lang['defense'] = 'Defensas';
			$parse  = $lang;
			if(isset($_GET['planet_type'])){
				if($_GET['planet_type'] == 1){
					$planettype = " AND `planet_type` = '1'";
					$parse['select1'] = ' selected';
				}elseif($_GET['planet_type'] == 3){
					$planettype = "AND `planet_type` = '3'";
					$parse['select3'] = ' selected';
				}else{
					$planettype = '';
					$parse['select0'] = ' selected';
				}				
			}else{
				$planettype = '';
				$parse['select0'] = ' selected';
			}
			$planetsrow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$CurrentUser['id']."'$planettype;",'planets');

		$planet = array();
		while ($p =  mysql_fetch_array($planetsrow)) {
			PlanetResourceUpdate($CurrentUser, $p, time());
			$planet['sum'] = sumar_array($planet['sum'], $p);
			$planet[] = $p;
		}
		uksort ($planet, 'planet_empire_sort');
		$parse['mount'] = count($planet) + 3;
		// primera tabla, con las imagenes y coordenadas
		$row  = gettemplate('empire/imperium_row');
		$row2 = gettemplate('empire/imperium_row2');		
		foreach ($planet as $ID => $p) {
			if($ID !== 'sum'){
				UpdatePlanetBatimentQueueList ( $p, $CurrentUser );
				$AllPlanets = '';
								if ( $p['b_building'] != 0 ) {
									$BuildQueue      = $p['b_building_id'];
									$QueueArray      = explode ( ";", $BuildQueue );
									$CurrentBuild    = explode ( ",", $QueueArray[0] );
									$BuildElement    = $CurrentBuild[0];
									$BuildLevel      = $CurrentBuild[1];
									$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
									$AllPlanets     .= $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
									$AllPlanets     .= "<br/><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
								} else {
									CheckPlanetUsedFields ($p);
									$AllPlanets     .= "<a href='game.php?page=buildings'>Libre</a>";
								}
				// {file_images}
				$parse['build'] .= '<th width="75">'.$AllPlanets.'</th>';
				
				$data['text'] = '<a href="game.php?page=overview&cp=' . $p['id'] . '&re=0"><img src="' . $dpath . 'planeten/' . $p['image'] . '.jpg" border="0" height="75" width="75"></a><br/>';
				$parse['file_images'] .= parsetemplate($row, $data);
				// {file_names}
				$data['text'] = '<a href="game.php?page=overview&cp=' . $p['id'] . '&re=0">' .$p['name'] .' </a>';
				if ($p['planet_type'] == 3) {
				$data['text'] = '<a href="game.php?page=overview&cp=' . $p['id'] . '&re=0">' .$p['name'] .' (Luna)</a>';
				}
				$parse['file_names'] .= parsetemplate($row2, $data);
				// {file_type}
				$data['text'] = GetPlanetType($p);
				$parse['file_type'] .= parsetemplate($row2, $data);
				// {file_coordinates}
				$data['text'] = "[<a href=\"game.php?page=galaxy&mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]";
				$parse['file_coordinates'] .= parsetemplate($row2, $data);
				// {file_fields}
				$data['text'] = $p['field_current'] . '/' . CalculateMaxPlanetFields($p).'<br/>'. GetPercentBar($p['field_current'], CalculateMaxPlanetFields($p));
				$parse['file_fields'] .= parsetemplate($row2, $data);
				// {file_metal}
				$data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&re=0&planettype=' . $p['planet_type'] . '">'. pretty_number($p['metal']) .'</a><br/>'. GetPercentBar($p['metal'], $p['metal_max'] * MAX_OVERFLOW);
				$parse['file_metal'] .= parsetemplate($row2, $data);
				// {file_crystal}
				$data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&re=0&planettype=' . $p['planet_type'] . '">'. pretty_number($p['crystal']) .'</a><br/>'. GetPercentBar($p['crystal'], $p['crystal_max'] * MAX_OVERFLOW);
				$parse['file_crystal'] .= parsetemplate($row2, $data);
				// {file_deuterium}
				$data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&re=0&planettype=' . $p['planet_type'] . '">'. pretty_number($p['deuterium']) .'</a><br/>'. GetPercentBar($p['deuterium'], $p['deuterium_max'] * MAX_OVERFLOW);
				$parse['file_deuterium'] .= parsetemplate($row2, $data);
				// {file_hidrogeno}
				$data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&re=0&planettype=' . $p['planet_type'] . '">'. pretty_number($p['tritium']) .'</a><br/>'. GetPercentBar($p['tritium'], $p['tritium_max'] * MAX_OVERFLOW);
				$parse['file_tritium'] .= parsetemplate($row2, $data);
				// {file_energy}
				$data['text'] = pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']).'<br/>'. GetPercentBar($p['energy_max'],  $p['energy_max'] - $p['energy_used']);
				$parse['file_energy'] .= parsetemplate($row2, $data);
				$Queue = ShowBuildingsPage::ShowBuildingQueue ( $p, $CurrentUser );
				foreach ($resource as $i => $res) {
					if (in_array($i, $reslist['build'])){			
						if($Queue['buildingarray'][$i] > $p[$resource[$i]]){
							$p[$resource[$i]] = $p[$resource[$i]]." <span style='color:lime;'>+".($Queue['buildingarray'][$i] - $p[$resource[$i]])."</span>";
						}
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : "<a href=\"game.php?page=buildings&cp={$p['id']}&re=0&planettype={$p['planet_type']}\">".pretty_number($p[$resource[$i]])."</a>";
						if(IsElementBuyable ($CurrentUser, $p, $i, true, false) and IsTechnologieAccessible($CurrentUser, $p, $i) and $p["field_current"] < CalculateMaxPlanetFields($p) ){
							$data['text'] .= " <a href=\"game.php?page=buildings&cmd=insert&cp={$p['id']}&re=0&building=". $i ."\"><font color=lime>+</font></a>";
						}
					}elseif (in_array($i, $reslist['tech'])){
						$data['text'] = ($CurrentUser[$resource[$i]] == 0) ? '' : "<a href=\"game.php?page=buildings&mode=research&cp={$p['id']}&re=0&planettype={$p['planet_type']}\">{$CurrentUser[$resource[$i]]}</a>";
						if(IsElementBuyable ($CurrentUser, $p, $i, true, false) and IsTechnologieAccessible($CurrentUser, $p, $i) and $CurrentUser["b_tech_planet"] == 0 ){
							$data['text'] .= " <a href=\"game.php?page=buildings&mode=research&cmd=search&cp={$p['id']}&re=0&tech=". $i ."\"><font color=lime>+</font></a>";
						}
					}elseif (in_array($i, $reslist['fleet'])){
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : "<a href=\"game.php?page=buildings&mode=fleet&cp={$p['id']}&re=0&planettype={$p['planet_type']}\">".pretty_number($p[$resource[$i]])."</a>";
					}elseif (in_array($i, $reslist['defense'])){
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : "<a href=\"game.php?page=buildings&mode=defense&cp={$p['id']}&re=0&planettype={$p['planet_type']}\">".pretty_number($p[$resource[$i]])."</a>";
					}
					$r[$i] .= parsetemplate($row2, $data);
				}
			}else{

				$parse['build'] .= '<th width="75">-</th>';
				
				$data['text'] = '<span style="font-size:48px;font-weight:normal;">&Sigma;</span><br/>';
				$parse['file_images'] .= parsetemplate($row, $data);
				// {file_names}
				$data['text'] = '-';
				$parse['file_names'] .= parsetemplate($row2, $data);
				// {file_type}
				$data['text'] = "-";
				$parse['file_type'] .= parsetemplate($row2, $data);
				// {file_coordinates}
				$data['text'] = "-";
				$parse['file_coordinates'] .= parsetemplate($row2, $data);
				// {file_fields}
				$data['text'] = $p['field_current'] . '/' . CalculateMaxPlanetFields($p).'<br/>'. GetPercentBar($p['field_current'], CalculateMaxPlanetFields($p));
				$parse['file_fields'] .= parsetemplate($row2, $data);
				// {file_metal}
				$data['text'] = pretty_number($p['metal']) .'<br/>'. GetPercentBar($p['metal'], $p['metal_max'] * MAX_OVERFLOW);
				$parse['file_metal'] .= parsetemplate($row2, $data);
				// {file_crystal}
				$data['text'] = pretty_number($p['crystal']) .'<br/>'. GetPercentBar($p['crystal'], $p['crystal_max'] * MAX_OVERFLOW);
				$parse['file_crystal'] .= parsetemplate($row2, $data);
				// {file_deuterium}
				$data['text'] = pretty_number($p['deuterium']) .'<br/>'. GetPercentBar($p['deuterium'], $p['deuterium_max'] * MAX_OVERFLOW);
				$parse['file_deuterium'] .= parsetemplate($row2, $data);
				// {file_hidrogeno}
				$data['text'] =  pretty_number($p['tritium']) .'<br/>'. GetPercentBar($p['tritium'], $p['tritium_max'] * MAX_OVERFLOW);
				$parse['file_tritium'] .= parsetemplate($row2, $data);
				// {file_energy}
				$data['text'] = pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']).'<br/>'. GetPercentBar($p['energy_max'],  $p['energy_max'] - $p['energy_used']);
				$parse['file_energy'] .= parsetemplate($row2, $data);
				foreach ($resource as $i => $res) {
					if (in_array($i, $reslist['build'])){			
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : pretty_number($p[$resource[$i]]);
					}elseif (in_array($i, $reslist['tech'])){
						$data['text'] = ($CurrentUser[$resource[$i]] == 0) ? '' : $CurrentUser[$resource[$i]];
					}elseif (in_array($i, $reslist['fleet'])){
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : pretty_number($p[$resource[$i]]);
					}elseif (in_array($i, $reslist['defense'])){
						$data['text'] = ($p[$resource[$i]]    == 0) ? '' : pretty_number($p[$resource[$i]]);
					}
					$r[$i] .= parsetemplate($row2, $data);
				}		
			
			}
		}

		// {building_row}
		foreach ($reslist['build'] as $a => $i) {
		$data['text'] = $lang['tech'][$i];
		$parse['building_row'] .= '<tr><th width="15"><span style="float:center;width: 16px;"><a title="'.$lang['tech'][$i].'"><img style="border: 1px solid rgb(46, 52, 54);vertical-align: bottom;padding: 0px;width: 15px;height: 15px;" src="'.$dpath.'gebaeude/'.$i.'.gif"></a></span></th>' . parsetemplate($row2, $data) . $r[$i] . "</tr>";
		}
		// {technology_row}
		foreach ($reslist['tech'] as $a => $i) {
			$data['text'] = $lang['tech'][$i];
			$parse['technology_row'] .= '<tr><th width="15"><span style="float:center;width: 16px;"><a title="'.$lang['tech'][$i].'"><img style="border: 1px solid rgb(46, 52, 54);vertical-align: bottom;padding: 0px;width: 15px;height: 15px;" src="'.$dpath.'gebaeude/'.$i.'.gif"></a></span></th>' . parsetemplate($row2, $data) . $r[$i] . "</tr>";
		}
		// {fleet_row}
		foreach ($reslist['fleet'] as $a => $i) {
			$data['text'] = $lang['tech'][$i];
			$parse['fleet_row'] .= '<tr><th width="15"><span style="float:center;width: 16px;"><a title="'.$lang['tech'][$i].'"><img style="border: 1px solid rgb(46, 52, 54);vertical-align: bottom;padding: 0px;width: 15px;height: 15px;" src="'.$dpath.'gebaeude/'.$i.'.gif"></a></span></th>' . parsetemplate($row2, $data) . $r[$i] . "</tr>";
		}
		// {defense_row}
		foreach ($reslist['defense'] as $a => $i) {
			$data['text'] = $lang['tech'][$i];
			$parse['defense_row'] .= '<tr><th width="15"><span style="float:center;width: 15px;"><a title="'.$lang['tech'][$i].'"><img style="border: 1px solid rgb(46, 52, 54);vertical-align: bottom;padding: 0px;width: 15px;height: 15px;" src="'.$dpath.'gebaeude/'.$i.'.gif"></a></span></th>' . parsetemplate($row2, $data) . $r[$i] . "</tr>";
		}

		$page .= parsetemplate(gettemplate('empire/imperium_table'), $parse);

		display($page, false);
}
?>
