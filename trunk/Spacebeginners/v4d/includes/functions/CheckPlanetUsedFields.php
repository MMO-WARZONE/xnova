<?php

/**
 *
 * CheckPlanetUsedFields.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// Verification du nombre de cases utilisées sur la planete courrante
function CheckPlanetUsedFields ( &$planet ) {
	global $resource;

	// Tous les batiments
	$cfc  = $planet[$resource[1]]  + $planet[$resource[2]]   + $planet[$resource[3]]  ;
	$cfc += $planet[$resource[4]]  + $planet[$resource[11]]  + $planet[$resource[12]] ;
	$cfc += $planet[$resource[14]] + $planet[$resource[15]]  + $planet[$resource[21]] ;
	$cfc += $planet[$resource[22]] + $planet[$resource[23]]  + $planet[$resource[24]] ;
	$cfc += $planet[$resource[25]] + $planet[$resource[26]]  + $planet[$resource[27]] ;
	$cfc += $planet[$resource[31]] + $planet[$resource[33]]  + $planet[$resource[34]] ;
    $cfc += $planet[$resource[44]] + $planet[$resource[45]]  + $planet[$resource[46]] ;
	// Si on se trouve sur une lune ... Y a des choses a ajouter aussi
	if ($planet['planet_type'] == '3') {
		$cfc += $planet[$resource[41]] + $planet[$resource[42]] + $planet[$resource[43]];
	}

	// Mise a jour du nombre de case dans la BDD si incorrect
	if ($planet['field_current'] != $cfc) {
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}", 'planets');
	}
}

?>