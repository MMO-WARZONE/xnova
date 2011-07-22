<?php

$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";",'planets', true);
if (!isset($targetPlanet['id'])) {
	if ($FleetRow['fleet_group'] > 0) {
		//MadnessRed Code
		doquery('DELETE FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'aks');
		doquery('UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
	} else {
		doquery('UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id='.$FleetRow['fleet_id'],'fleets');
	}
	return;
}
$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);

// ACS function: put all fleet into an array
$attackFleets = array();
// attackFleets[id] = array('fleet' => $FleetRow, 'user' => $user);

if ($FleetRow['fleet_group'] != 0) {
	$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
	while ($fleet = mysql_fetch_assoc($fleets)) {
		$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
		$attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$fleet['fleet_owner'],'users', true);
		$attackFleets[$fleet['fleet_id']]['detail'] = array();
		$temp = explode(';', $fleet['fleet_array']);
		foreach ($temp as $temp2) {
			$temp2 = explode(',', $temp2);

			if ($temp2[0] < 100) continue;

			if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]])) $attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;
			$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
		}
	}

} else {
	$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
	$attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$FleetRow['fleet_owner'],'users', true);
	$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
	$temp = explode(';', $FleetRow['fleet_array']);
	foreach ($temp as $temp2) {
		$temp2 = explode(',', $temp2);

		if ($temp2[0] < 100) continue;

		if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]])) $attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;
		$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
	}
}

$defense = array();
// defense[id] = array('def' => $defRow); (id 0 = planet)
$def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
while ($defRow = mysql_fetch_assoc($def)) {
	$defRowDef = explode(';', $defRow['fleet_array']);
	foreach ($defRowDef as $Element) {
		$Element = explode(',', $Element);

		if ($Element[0] < 100) continue;

		if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]])) $defense[$defRow['fleet_id']][$Element[0]] = 0;
		$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
		$defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$defRow['fleet_owner'],'users', true);
	}
}

$defense[0]['def'] = array();
$defense[0]['user'] = $targetUser;
for ($i = 200; $i < 500; $i++) {
	if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]])) {
		$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
	}
}

$start = microtime(true);

//Debug
//echo "<font color=\"red\">A combat report has been generated. Please post any errors below on the forums. Thanks</font><br />";
$result = calculateAttack($attackFleets, $defense);
$totaltime = microtime(true) - $start;

$steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
if ($result['won'] == 1) {
	// Calculate new fleet maximum resources for base attacker
	$max_resources = 0;
	foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount) {
		$max_resources += $pricelist[$Element]['capacity'] * $amount;
	}

	if ($max_resources > 0) {
		$metal   = $targetPlanet['metal'] / 2;
		$crystal = $targetPlanet['crystal'] / 2;
		$deuter  = $targetPlanet['deuterium'] / 2;
		if ($metal > $max_resources / 3) {
			$steal['metal']		 = $max_resources / 3;
			$max_resources		 = $max_resources - $steal['metal'];
		} else {
			$steal['metal']		 = $metal;
			$max_resources		-= $steal['metal'];
		}

		if ($crystal > $max_resources / 2) {
			$steal['crystal'] = $max_resources / 2;
			$max_resources   -= $steal['crystal'];
		} else {
			$steal['crystal'] = $crystal;
			$max_resources   -= $steal['crystal'];
		}

		if ($deuter > $max_resources) {
			$steal['deuterium']	 = $max_resources;
			$max_resources		-= $steal['deuterium'];
		} else {
			$steal['deuterium']	 = $deuter;
			$max_resources		-= $steal['deuterium'];
		}
	}

	$steal = array_map('round', $steal);


	$QryUpdateFleet  = 'UPDATE {{table}} SET ';
	$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
	$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
	$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .' ';
	$QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
	$QryUpdateFleet .= 'LIMIT 1 ;';
	doquery( $QryUpdateFleet,'fleets' );
}

// Update galaxy (debree)
if ($targetUser['authlevel'] == 0) doquery('UPDATE {{table}} SET metal=metal+'.($result['debree']['att'][0]+$result['debree']['def'][0]).' , crystal=crystal+'.($result['debree']['att'][1]+$result['debree']['def'][1]).' WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'],'galaxy');


$totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];

// Update fleets & planets
foreach ($attackFleets as $fleetID => $attacker) {
	$fleetArray = '';
	$totalCount = 0;
	foreach ($attacker['detail'] as $element => $amount) {
		if ($amount) $fleetArray .= $element.','.$amount.';';
		$totalCount += $amount;
	}

	if ($totalCount <= 0) {
		doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');

	} else {
		doquery('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
	}
}

foreach ($defense as $fleetID => $defender) {
	if ($fleetID != 0) {
		$fleetArray = '';
		$totalCount = 0;
		foreach ($defender['def'] as $element => $amount) {
			if ($amount) $fleetArray .= $element.','.$amount.';';
			$totalCount += $amount;
		}

		if ($totalCount <= 0) {
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');

		} else {
			doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
		}

	} else {
		$fleetArray = '';
		$totalCount = 0;
		foreach ($defender['def'] as $element => $amount) {
			$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
		}

		doquery('UPDATE {{table}} SET '.$fleetArray.'metal=metal-'.$steal['metal'].', crystal=crystal-'.$steal['crystal'].', deuterium=deuterium-'.$steal['deuterium'].' WHERE id='.$targetPlanet['id'],'planets');
	}
}
// TvdW (c) 2008
?>
