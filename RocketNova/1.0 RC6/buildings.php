<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	includeLang('buildings');

// Schutz vor unregestrierten Usern
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

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
			BatimentBuildingPage ( $planetrow, $user);
			break;
	}

?>