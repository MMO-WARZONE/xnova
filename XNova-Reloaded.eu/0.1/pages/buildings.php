<?php

/**
 * buildings.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

	includeLang('buildings');

	// Mise a jour de la liste de construction si necessaire
	UpdatePlanetBatimentQueueList ( $planetrow, $user );
	$IsWorking = HandleTechnologieBuild ( $planetrow, $user );

	switch ($_GET['mode']) {
		case 'fleet':
			// --------------------------------------------------------------------------------------------------
			FleetBuildingPage ( $planetrow, $user );
			break;

		case 'research':
			// --------------------------------------------------------------------------------------------------
			ResearchBuildingPage ( $planetrow, $user, $IsWorking['OnWork'], $IsWorking['WorkOn'] );
			break;

		case 'defense':
			// --------------------------------------------------------------------------------------------------
			DefensesBuildingPage ( $planetrow, $user );
			break;

		default:
			// --------------------------------------------------------------------------------------------------
			BatimentBuildingPage ( $planetrow, $user );
			break;
	}

?>