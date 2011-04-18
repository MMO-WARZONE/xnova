<?php

/**
 * BatimentBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

function BatimentBuildingPage (&$CurrentPlanet, $CurrentUser) {
	global $lang, $resource, $reslist, $dpath, $game_config, $_GET;

	CheckPlanetUsedFields ( $CurrentPlanet );

	// Tables des batiments possibles par type de planete
	$Allowed['1'] = array(  1,  2,  3,  4, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44);
	$Allowed['3'] = array( 12, 14, 21, 22, 23, 24, 34, 41, 42, 43);

	// Boucle d'interpretation des eventuelles commandes
	if (isset($_GET['cmd'])) {
		// On passe une commande
		$bThisIsCheated = false;
		$bDoItNow       = false;
		$TheCommand     = $_GET['cmd'];
		
		
		if       ( isset ( $_GET['building'] )) { //Wenn Variable gefüllt ist
					$Element = intval ($_GET['building']); // Muss ne Zahl sein
					
						if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']])) {
							$bDoItNow = true; // Ist true wenns vorhanden ist und eine Zahl aus der Whitelist des jeweiligen Typs enthält.
						} else {
							$bThisIsCheated = true;
						}    
		}		
		
		if ( isset ( $_GET['listid'] )) { //Wenn Variable gefüllt ist...
			$ListID   = intval ($_GET['listid']);	// Das hier muss ne Zahl sein
			$bDoItNow = true; // Und ist auch true wenn $ListID vorhanden ist
		}
		
		if ($bDoItNow == true) { // Wenn True dann mach hier weiter
			switch($TheCommand){
				case 'cancel':
					// Bricht den aktuell laufenden Auftrag ab
					CancelBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
					break;
				case 'remove':
					// Entfernt ein wartendes Element aus der Bauschleife
					RemoveBuildingFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
					break;
				case 'insert':
					// Fügt ein Element zur Bauschleife hinzu
					if ($Element == 31) {
						if ($CurrentUser["b_tech_planet"] == 0 || $game_config['BuildLabWhileRun'] == 1) { 
							AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
						}
					}
					else
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
					break;
				case 'destroy':
					// Baut ein Gebäude eine Stufe ab
					if ($Element == 31) {
						if ($CurrentUser["b_tech_planet"] == 0 || $game_config['BuildLabWhileRun'] == 1) { 
							AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, false );
						}
					}
					else
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, false );
					break;
				default:
					break;
			}
		}
	header('Location: ?action=internalBuildings'); //Nach nem Klick Weiterleitung auf die Bauseite um Doppelklicke zu vermeiden
	}

	SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );

	// Änderungen in den Planeten Rekorden übernehmen
	BuildingSavePlanetRecord ( $CurrentPlanet );
	// Änderungen in den Userrekorden übernehmen
	BuildingSaveUserRecord ( $CurrentUser );

	if ($Queue['lenght'] < MAX_BUILDING_QUEUE_SIZE) { //Solange noch Platz in der Bauischleife ist...
		$CanBuildElement = true;	// ...kann man bauen
	} else {
		$CanBuildElement = false;
	}

	$SubTemplate         = gettemplate('buildings_builds_row');
	$BuildingPage        = "";
	foreach($lang['tech'] as $Element => $ElementName) {
		if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']])) {
			$CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet);
			if ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) {
				$RoomIsOk = true;
			} else {
				$RoomIsOk = false;
			}

			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				$HaveRessources        = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
				$parse                 = array();
				$parse['dpath']        = $dpath;
				$parse['i']            = $Element;
				$BuildingLevel         = $CurrentPlanet[$resource[$Element]];
				$parse['nivel']        = ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
				$parse['n']            = $ElementName;
				$parse['descriptions'] = $lang['res']['descriptions'][$Element];
				$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$ElementBuildTimeWithoutTechs = GetBuildingTimeWithoutTechs($CurrentUser, $CurrentPlanet, $Element);
				
				//Bauzeiten parsen
				$parse['timewithouttechs']	= ShowBuildTimeWithoutTechs($ElementBuildTimeWithoutTechs);
				$parse['technobonus']		= ShowBuildTime($ElementBuildTimeWithoutTechs - $ElementBuildTime);
				$parse['time']				= ShowBuildTime($ElementBuildTime);
				
				//Sprachvariablen für die Bauzeit laden
				$parse['BuildingTime']		= $lang['BuildingTime'];
				$parse['NeededRess']		= $lang['NeededRess'];
				$parse['ConstructionTimeWithoutTechs'] = $lang['ConstructionTimeWithoutTechs'];
				$parse['TechBonus']			= $lang['TechBonus'];
				$parse['ConstructionTime']	= $lang['ConstructionTime'];

				
				$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
				$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
				$parse['click']        = '';
				$NextBuildLevel        = $CurrentPlanet[$resource[$Element]] + 1;

				if ($Element == 31) {
					// Sonderstatus fürs FOrschungslabor
					if ($CurrentUser["b_tech_planet"] != 0 &&     // Wenn nicht 0 dann wird gerade geforscht
					$game_config['BuildLabWhileRun'] != 1) {  // Config Einstellung die das Forschen während des Ausbaus erlaubt
						$parse['click'] = "<font color=\"#FF0000\">". $lang['in_working'] ."</font>";
					}
				}
				if       ($parse['click'] != '') {
					
				} elseif ($RoomIsOk && $CanBuildElement) {
					if ($Queue['lenght'] == 0) {
						if ($NextBuildLevel == 1) {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"?action=internalBuildings&amp;cmd=insert&amp;building=". $Element ."\"><font color=\"#00FF00\">". $lang['BuildFirstLevel'] ."</font></a>";
							} else {
								$parse['click'] = "<font color=\"#FF0000\">". $lang['BuildFirstLevel'] ."</font>";
							}
						} else {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"?action=internalBuildings&amp;cmd=insert&amp;building=". $Element ."\"><font color=\"#00FF00\">". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font></a>";
							} else {
								$parse['click'] = "<font color=\"#FF0000\">". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
							}
						}
					} else {
						$parse['click'] = "<a href=\"?action=internalBuildings&amp;cmd=insert&amp;building=". $Element ."\"><font color=\"#00FF00\">". $lang['InBuildQueue'] ."</font></a>";
					}
				} elseif ($RoomIsOk && !$CanBuildElement) {
					if ($NextBuildLevel == 1) {
						$parse['click'] = "<font color=\"#FF0000\">". $lang['BuildFirstLevel'] ."</font>";
					} else {
						$parse['click'] = "<font color=\"#FF0000\">". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
					}
				} else {
					$parse['click'] = "<font color=\"#FF0000\">". $lang['NoMoreSpace'] ."</font>";
				}

				$BuildingPage .= parsetemplate($SubTemplate, $parse);
			}
		}
	}

	$parse                         = $lang;


	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = InsertBuildListScript ( "?action=internalBuildings" );
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}

    $parse['planet_field_current'] = $CurrentPlanet["field_current"];
    $parse['planet_field_max']     = $CurrentPlanet['field_max'] + ($CurrentPlanet[$resource[33]] * 5);
    $parse['field_libre']          = $parse['planet_field_max']  - $CurrentPlanet['field_current'];

	$parse['BuildingsList']        = $BuildingPage;

	$page                         .= parsetemplate(gettemplate('buildings_builds'), $parse);

	display($page, $lang['Builds']);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 Mise en module initiale (creation)
// 1.1 FIX interception cheat +1
// 1.2 FIX interception cheat destruction a -1
?>