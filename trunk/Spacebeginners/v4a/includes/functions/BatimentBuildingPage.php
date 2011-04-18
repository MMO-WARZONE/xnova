<?php

/**
 * BatimentBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

function BatimentBuildingPage (&$CurrentPlanet, $CurrentUser) {
	global $ProdGrid, $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET, $user;

	CheckPlanetUsedFields ( $CurrentPlanet );
    PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );

	// Was gebaut werden darf in Abhängikeit zum gewählten Volk.
	    switch ($user['volk']) {
        case "A":
             $Allowed['1'] = array(  1,  2,  3,  11, 12, 14, 15, 21, 22, 23, 24, 25, 26, 27, 31, 33, 34, 44 );
	         $Allowed['3'] = array(  4, 12, 14, 15, 21, 25, 26, 34, 41, 42, 43);
        break;

        case "B":
             $Allowed['1'] = array(  1,  2,  3,  11, 12, 14, 15, 21, 22, 23, 24, 25, 26, 31, 33, 34, 44, 45);
	         $Allowed['3'] = array(  4, 12, 14, 15, 21, 25, 26, 34, 41, 42, 43);
        break;

        case "C":
             $Allowed['1'] = array(  1,  2,  3,  11, 12, 14, 15, 21, 22, 23, 24, 25, 26, 31, 33, 34, 44 ,46);
	         $Allowed['3'] = array(  4, 12, 14, 15, 21, 25, 26, 34, 41, 42, 43, 46);
        break;
      }
	
	
    //Werte auf null setzen
	    $bThisIsCheated = 0;
		$bDoItNow       = 0;
		$TheCommand     = 0;
		$Element        = 0;
		$ListID         = 0;

	// Boucle d'interpretation des eventuelles commandes
	if (isset($_GET['cmd'])) {
		// On passe une commande
		$bThisIsCheated = false;
		$bDoItNow       = false;
		$TheCommand     = $_GET['cmd'];
		$Element        = $_GET['building'];
		$ListID         = $_GET['listid'];
		if       ( isset ( $Element )) {
			if ( !strchr ( $Element, " ") ) {
				if ( !strchr ( $Element, ",") ) {
                  if ( !strchr ( $Element, ";") ) {
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
                   } else {
                $bThisIsCheated = true;
            }
		} elseif ( isset ( $ListID )) {
			$bDoItNow = true;
		}
		if ($bDoItNow == true) {
		   $Element = abs($Element);
			switch($TheCommand){
				case 'cancel':
					// Interrompre le premier batiment de la queue
					CancelBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
					break;
				case 'remove':
					// Supprimer un element de la queue (mais pas le premier)
					// $RemID -> element de la liste a supprimer
					RemoveBuildingFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
					break;
				case 'insert':
					// Insere un element dans la queue
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
					break;
				case 'destroy':
					// Detruit un batiment deja construit sur la planete !
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, false );
					break;
				default:
					break;
			} // switch
		} elseif ($bThisIsCheated == true) {
			ResetThisFuckingCheater ( $CurrentUser['id'] );
		}
	sleep (1) ;// es wird 1 sekunde geschlafen
	}

	SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );

	// On enregistre ce que l'on a modifi&eacute; dans planet !
	BuildingSavePlanetRecord ( $CurrentPlanet );
	// On enregistre ce que l'on a eventuellement modifi&eacute; dans users
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
			if ($CurrentPlanet['field_current'] < ($CurrentMaxFields - $Queue['lenght'])) {
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
			

				// show energy on BuildingPage
                                //================================
                                $BuildLevelFactor     = $CurrentPlanet[ $resource[$Element]."_porcent" ];
                                $BuildTemp            = $CurrentPlanet[ 'temp_max' ];
                                $CurrentBuildtLvl     = $BuildingLevel;
                                $BuildLevel         = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
                               
                                $Prod[3]         = (floor(eval($ProdGrid[$Element]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
                                $Prod[11]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                               
                                if ($Element != 12) {
                                    $ActualNeed     = floor($Prod[11]);
                                } else {
                                    $ActualNeed     = floor($Prod[3]);
                                }
                               
                                $BuildLevel++;
                               
                                $Prod[3]         = (floor(eval($ProdGrid[$Element]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
                                $Prod[11]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                                 if ($Element != 12) {
                                   
                                     $bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
                                    $bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
                                    $bloc['build_need']      = colorNumber( pretty_number(floor($Prod[11])) );
                                    $EnergyNeed = colorNumber( pretty_number(floor($Prod[11] - $ActualNeed)) );
                                } else {
                                   
                                    $bloc['build_prod']      = pretty_number(floor($Prod[11]));
                                    $bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[11] - $ActualProd)) );
                                    $bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
                                    $EnergyNeed = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
                                }
                               
                                if ($Element >= 1 && $Element <= 4) {
                                    $parse['build_need_diff'] = "("."<font color=#FF0000>". $EnergyNeed." ".$lang['Energy']."</font>".")";
                                    $BuildLevel = 0;
                                }elseif ($Element == 11 || $Element == 12) {
                                    $parse['build_need_diff'] = "("."<font color=#00FF00>+". $EnergyNeed." ".$lang['Energy']."</font>".")";
                                    $BuildLevel = 0;
                                }
                               
                                //================================
				
				if ($Element == 31) {
					// Sp&eacute;cial Laboratoire
					if ($CurrentUser['b_tech_planet'] != 0 &&     // Si pas 0 y a une recherche en cours
						$game_config['BuildLabWhileRun'] != 1) {  // Variable qui contient le parametre
						// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
						$parse['click'] = "<font color=#FF0000>". $lang['in_working'] ."</font>";
					}
				}
				if ($Element == 15) {
					// Spezialgebäude Nanitenfabrik
					if ($CurrentPlanet['robot_factory'] <= 9 ){
						// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
						$parse['click'] = "<font color=#FF0000>". $lang['no Nani'] ."</font>";
					}
				}
					if ($Element == 45) {
					// Spezialgebäude Mondtransformer
					if ( $CurrentPlanet['mondtransformer'] == 1){
						// Es darf nur ein Mondtransformer pro Planet gebaut werden
						$parse['click'] = "<font color=#FF0000>". $lang['only_one_mondtransformer'] ."</font>";
					}
				}
				if       ($parse['click'] != '') {
					// Bin on ne fait rien, vu que l'on l'a deja fait au dessus !!
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

	// Faut il afficher la liste de construction ??
	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = InsertBuildListScript ( "buildings" );
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}

    $parse['planet_field_current'] = $CurrentPlanet['field_current'];    	  	
    $parse['planet_field_max']     = $CurrentPlanet['field_max'] ;
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
