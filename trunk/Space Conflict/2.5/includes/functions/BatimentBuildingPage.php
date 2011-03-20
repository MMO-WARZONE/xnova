<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** batimentsbuildingpage.php             **
******************************************/

function BatimentBuildingPage (&$CurrentPlanet, $CurrentUser) {
	global $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET;

	CheckPlanetUsedFields ( $CurrentPlanet );

	$Allowed['1'] = array(  1,  2,  3,  4,  5, 12, 14, 15, 21, 22, 23, 24, 25, 31, 33, 34, 35, 44);
	$Allowed['3'] = array( 14, 15, 21, 22, 23, 24, 25, 34, 41, 42, 43);

	if (isset($_GET['cmd'])) {
		$bThisIsCheated = false;
		$bDoItNow       = false;
		$TheCommand     = $_GET['cmd'];
		$Element        = $_GET['building'];
		$ListID         = $_GET['listid'];
		if       ( isset ( $Element )) {
			if ( !strchr ( $Element, " ") ) {
				if ( !strchr ( $Element, ",") ) {
					if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']])) {
						$bDoItNow = true;
					} else {
						$bThisIsCheated = true;
					}
				} else {
					$bThisIsCheated = true;
				}
			} else {
				$bThisIsCheated = true;
			}
		} elseif ( isset ( $ListID )) {
			$bDoItNow = true;
		}
		if ($bDoItNow == true) {
			switch($TheCommand){
				case 'cancel':
					CancelBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
					break;
				case 'remove':
					RemoveBuildingFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
					break;
				case 'insert':
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
					break;
				case 'destroy':
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, false );
					break;
				default:
					break;
			} 
		} elseif ($bThisIsCheated == true) {
			ResetThisFuckingCheater ( $CurrentUser['id'] );
		}
	}

	SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );

	BuildingSavePlanetRecord ( $CurrentPlanet );
	BuildingSaveUserRecord ( $CurrentUser );

	if ($Queue['lenght'] < MAX_BUILDING_QUEUE_SIZE) {
		$CanBuildElement = true;
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
				$parse['time']         = ShowBuildTime($ElementBuildTime);
				$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
				$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
				$parse['click']        = '';
				$NextBuildLevel        = $CurrentPlanet[$resource[$Element]] + 1;

				if ($Element == 31) {
					if ($CurrentUser["b_tech_planet"] != 0 &&     
						$game_config['BuildLabWhileRun'] != 1) {  
						$parse['click'] = "<font color=#FF0000>". $lang['in_working'] ."</font>";
					} 
				} elseif ($Element == 4) {
					if ($CurrentPlanet ["tach_accel"] >= "50")
					$parse['click'] = "<font color=#FF0000>You Can Not<br>Build Any More</font>";
				} elseif ($Element == 25) {
					if ($CurrentPlanet ["tachyon_store"] >= "50")
					$parse['click'] = "<font color=#FF0000>You Can Not<br>Build Any More</font>";
					}

				if       ($parse['click'] != '') {
				} elseif ($RoomIsOk && $CanBuildElement) {
					if ($Queue['lenght'] == 0) {
						if ($NextBuildLevel == 1) {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"?cmd=insert&building=". $Element ."\"><font color=#00FF00>". $lang['BuildFirstLevel'] ."</font></a>";
							} else {
								$parse['click'] = "<font color=#FF0000>". $lang['BuildFirstLevel'] ."</font>";
							}
						} else {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"?cmd=insert&building=". $Element ."\"><font color=#00FF00>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font></a>";
							} else {
								$parse['click'] = "<font color=#FF0000>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
							}
						}
					} else {
						$parse['click'] = "<a href=\"?cmd=insert&building=". $Element ."\"><font color=#00FF00>". $lang['InBuildQueue'] ."</font></a>";
					}
				} elseif ($RoomIsOk && !$CanBuildElement) {
					if ($NextBuildLevel == 1) {
						$parse['click'] = "<font color=#FF0000>". $lang['BuildFirstLevel'] ."</font>";
					} else {
						$parse['click'] = "<font color=#FF0000>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
					}
				} else {
					$parse['click'] = "<font color=#FF0000>". $lang['NoMoreSpace'] ."</font>";
				}

				$BuildingPage .= parsetemplate($SubTemplate, $parse);
			}
		}
	}

	$parse                         = $lang;
	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = InsertBuildListScript ( "buildings" );
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}
  $parse['planet_field_current'] = $CurrentPlanet["field_current"];
  $parse['planet_field_max']     = $CurrentPlanet['field_max'] + ($CurrentPlanet[$resource[33]] * FIELDS_BY_TERRAFORMER_LEVEL);
  $parse['field_libre']          = $parse['planet_field_max']  - $CurrentPlanet['field_current'];
	$parse['BuildingsList']        = $BuildingPage;

	$page                         .= parsetemplate(gettemplate('buildings_builds'), $parse);

	display($page, $lang['Builds']);
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>