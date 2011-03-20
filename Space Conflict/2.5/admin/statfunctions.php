<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** statfunctions.php                     **
******************************************/

function GetTechnoPoints ( $CurrentUser ) {
	global $resource, $pricelist, $reslist;

	$TechCounts = 0;
	$TechPoints = 0;
	foreach ( $reslist['tech'] as $n => $Techno ) {
		if ( $CurrentUser[ $resource[ $Techno ] ] > 0 ) {
			for ( $Level = 1; $Level < $CurrentUser[ $resource[ $Techno ] ]; $Level++ ) {
				$Units       = $pricelist[ $Techno ]['metal'] + $pricelist[ $Techno ]['crystal'];
				$LevelMul    = pow( $pricelist[ $Techno ]['factor'], $Level )/$Level;
				$TechPoints += ($Units * $LevelMul);
				$TechCounts += 1;
			}
		}
	}
	$RetValue['TechCount'] = $TechCounts;
	$RetValue['TechPoint'] = $TechPoints;

	return $RetValue;
}

function GetBuildPoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$BuildCounts = 0;
	$BuildPoints = 0;
	foreach($reslist['build'] as $n => $Building) {
		if ( $CurrentPlanet[ $resource[ $Building ] ] > 0 ) {
			for ( $Level = 1; $Level < $CurrentPlanet[ $resource[ $Building ] ]; $Level++ ) {
				$Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'];
				$LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level )/$Level;
				$BuildPoints += ($Units * $LevelMul);
				$BuildCounts += 1;
			}
		}
	}
	$RetValue['BuildCount'] = $BuildCounts;
	$RetValue['BuildPoint'] = $BuildPoints;

	return $RetValue;
}

function GetDefensePoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$DefenseCounts = 0;
	$DefensePoints = 0;
	foreach($reslist['defense'] as $n => $Defense) {
		if ($CurrentPlanet[ $resource[ $Defense ] ] > 0) {
			$Units          = $pricelist[ $Defense ]['metal'] + $pricelist[ $Defense ]['crystal'];
			$DefensePoints += ($Units * $CurrentPlanet[ $resource[ $Defense ] ]);
			$DefenseCounts += $CurrentPlanet[ $resource[ $Defense ] ];
		}
	}
	$RetValue['DefenseCount'] = $DefenseCounts;
	$RetValue['DefensePoint'] = $DefensePoints;

	return $RetValue;
}

function GetFleetPoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$FleetCounts = 0;
	$FleetPoints = 0;
	foreach($reslist['fleet'] as $n => $Fleet) {
		if ($CurrentPlanet[ $resource[ $Fleet ] ] > 0) {
			$Units          = $pricelist[ $Fleet ]['metal'] + $pricelist[ $Fleet ]['crystal'];
			$FleetPoints   += ($Units * $CurrentPlanet[ $resource[ $Fleet ] ]);
			$FleetCounts   += $CurrentPlanet[ $resource[ $Fleet ] ];
		}
	}
	$RetValue['FleetCount'] = $FleetCounts;
	$RetValue['FleetPoint'] = $FleetPoints;

	return $RetValue;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>