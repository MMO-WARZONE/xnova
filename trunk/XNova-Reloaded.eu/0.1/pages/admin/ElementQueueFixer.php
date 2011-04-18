<?php

/**
 * ElementQueueFixer.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	includeLang('admin');
	
	$AffectedPlanets = $DB->query("SELECT `id`, `id_owner`, `b_hangar`, `b_hangar_id` FROM ".PREFIX."planets WHERE `b_hangar_id` != 0");

	$DeletedQueues    = 0;
	while ( $ActualPlanet = $AffectedPlanets->fetch(PDO::FETCH_ASSOC) ) {
		$HangarQueue = explode (";", $ActualPlanet['b_hangar_id']);
		$bDelQueue   = false;
		if (count($HangarQueue)) {
			for ( $Queue = 0; $Queue < count($HangarQueue); $Queue++) {
				$InQueue = explode (",", $HangarQueue[$Queue]);
				if ($InQueue[1] > MAX_FLEET_OR_DEFS_PER_ROW) {
					$bDelQueue = true;
				}
			}
		}
		if ($bDelQueue) {
			$QryUpdatePlanet = $DB->prepare("UPDATE ".PREFIX."planets SET `b_hangar` = '0', `b_hangar_id` = '0' WHERE `id` = :id");
			$QurUpdatePlanet->bindParam('id', $ActualPlanet['id']);
			$QryUpdatePlanet->execute();
			$DeletedQueues += 1;
		}
	}
	if ($DeletedQueues > 0) {
		$QuitMessage = $lang['adm_cleaned']." ". $DeletedQueues;
	} else {
		$QuitMessage = $lang['adm_done'];
	}

	AdminMessage ($QuitMessage, $lang['adm_cleaner_title']);
?>