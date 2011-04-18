<?php

/**
 * BatimentBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 *
 * fix by vomi, zeus (team xorbit) for XNova
 */

function BatimentBuildingPage (&$CurrentPlanet, $CurrentUser) {
        global $ProdGrid, $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET;

        CheckPlanetUsedFields ( $CurrentPlanet );
		
        // Tables des batiments possibles par type de planete
        $Allowed['1'] = array(  1,  2,  3,  4, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44);
        $Allowed['3'] = array( 12, 14, 21, 22, 23, 24, 34, 41, 42, 43);

        // Boucle d'interpretation des eventuelles commandes
        if($CurrentUser['urlaubs_modus'] == 0) {
        if (isset($_GET['cmd'])) {
                // On passe une commande
                $bDoItNow   = false;
                $TheCommand = $_GET['cmd'];



    $Gebaude=false;
    if(IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $_GET['building']))
        $Gebaude    = IsElementBuyable($CurrentUser, $CurrentPlanet, $_GET['building'], true, false);
        
        $Element    = $_GET['building'];

        
if(!$Gebaude) {
message("www.xorbit.de Anticheat Systems<<", "Anticheat");

die();
}                
        $ListID = $_GET['listid'];



                if       ( isset ( $Element )) {
                        if ( !strchr ( $Element, ",") ) {
                                if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']])) {
                                        $bDoItNow = true;
                                }
                        }
                } elseif ( isset ( $ListID )) {
                        $bDoItNow = true;
                }


		//Hier wird geprüft ob ein ; in die URL(GET)Geschrieben wurde
		foreach ($_GET as $check_url) {
 		 if (eregi(";", $check_url)){
 		   echo "Anti Cheat by www.xorbit.de";
 		   die();
 		 }
		}
		//Hier wird gescheckt ob ein user das zeichen ; in einen INPUT schreibt
		foreach ($_POST as $check_pos) {
 		 if (eregi(";", $check_post ,$check_url)){
 		   echo "Anti Cheat by www.xorbit.de";
 		   die();
 		 }
		}


                if ($bDoItNow == true) {
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
                }
        }
        }

        SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

        $Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );

        // On enregistre ce que l'on a modifiï¿½ dans planet !
        BuildingSavePlanetRecord ( $CurrentPlanet );
        // On enregistre ce que l'on a eventuellement modifiï¿½ dans users
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
                                
								// show energy on BuildingPage
								$BuildLevelFactor      = $CurrentPlanet[ $resource[$Element]."_porcent" ];
								$BuildTemp            = $CurrentPlanet[ 'temp_max' ];
								$CurrentBuildtLvl     = $BuildingLevel;
								$BuildLevel           = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
								
								$Prod[4]          = (floor(eval($ProdGrid[$Element]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
								$ActualNeed       = floor($Prod[4]);
								$BuildLevel++;
								$Prod[4]          = (floor(eval($ProdGrid[$Element]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
								$EnergyNeed       = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
								
								if ($Element >= 1 && $Element <= 3) {
									$parse['build_need_diff'] = "("."<font color=#FF0000>". $EnergyNeed." ".$lang['Energy']."</font>".")";
								    $BuildLevel = 0;
								}elseif ($Element == 4 || $Element == 12) {
								    $parse['build_need_diff'] = "("."<font color=#00FF00>+". $EnergyNeed." ".$lang['Energy']."</font>".")";
								    $BuildLevel = 0;
								}
								// end of 'show energy on BuildingPage'
                                
                                $parse['n']            = $ElementName;
                                $parse['descriptions'] = $lang['res']['descriptions'][$Element];
                                $ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                                $parse['time']         = ShowBuildTime($ElementBuildTime);
                                $parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
                                $parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
                                $parse['click']        = '';
                                $NextBuildLevel        = $CurrentPlanet[$resource[$Element]] + 1;

                                if ($Element == 31) {
                                        // Spï¿½cial Laboratoire
                                        if ($CurrentUser["b_tech_planet"] != 0 &&     // Si pas 0 y a une recherche en cours
                                                $game_config['BuildLabWhileRun'] != 1) {  // Variable qui contient le parametre
                                                // On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
                                                $parse['click'] = "<font color=#FF0000>". $lang['in_working'] ."</font>";
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