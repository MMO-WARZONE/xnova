<?php

/**
 * MissionCaseExpedition.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 *
 */

function MissionCaseExpedition ( $FleetRow ) {
        global $lang, $resource, $pricelist, $CombatCaps, $pirat;

        $FleetOwner = $FleetRow['fleet_owner'];
        $MessSender = $lang['sys_mess_qg'];
        $MessTitle  = $lang['sys_expe_report'];
		$Hasard     = 0;

        if ($FleetRow['fleet_mess'] == 0) {
                // Flotte en vol aller
                if ($FleetRow['fleet_end_stay'] < time()) {
                        // La Flotte vient de finir son exploration
                        // Table de ratio de points par type de vaisseau
                        $PointsFlotte = array(
                                202 => 1.0,  // 'Petit transporteur'
                                203 => 1.5,  // 'Grand transporteur'
                                204 => 0.5,  // 'Chasseur léger'
                                205 => 1.5,  // 'Chasseur lourd'
                                206 => 2.0,  // 'Croiseur'
                                207 => 2.5,  // 'Vaisseau de bataille'
                                208 => 0.5,  // 'Vaisseau de colonisation'
                                209 => 1.0,  // 'Recycleur'
                                210 => 0.01, // 'Sonde espionnage'
                                211 => 3.0,  // 'Bombardier'
                                212 => 0.0,  // 'Satellite solaire'
                                213 => 3.5,  // 'Destructeur'
                                214 => 5.0,  // 'Etoile de la mort'
                                215 => 3.2,  // 'Traqueur'
								216 => 6.5,  // 'Lune Noir'
								217 => 1.5,  // 'Evo'
								218 => 8.5,  // 'Sternenzerstoerer'
								219 => 1.5,  // 'Gigarecykler'
                        );

                        // Table de ratio de gains en nombre par type de vaisseau
                        $RatioGain = array (
                                202 => 0.2,     // 'Petit transporteur'
                                203 => 0.2,     // 'Grand transporteur'
                                204 => 0.2,     // 'Chasseur léger'
                                205 => 1.0,     // 'Chasseur lourd'
                                206 => 0.50,    // 'Croiseur'
                                207 => 0.825,   // 'Vaisseau de bataille'
                                208 => 1.5,     // 'Vaisseau de colonisation'
                                209 => 1.1,     // 'Recycleur'
                                210 => 1.1,     // 'Sonde espionnage'
                                211 => 1.0625,  // 'Bombardier'
                                212 => 0.0,     // 'Satellite solaire'
                                213 => 0.0625,  // 'Destructeur'
                                214 => 0.03125, // 'Etoile de la mort'
                                215 => 0.0625,  // 'Traqueur'
								216 => 0.03125,  // 'Lune Noir'
								217 => 0.03125,  // 'Evo'
								218 => 0.01000,  // 'Sternenzerstoerer'
								219 => 0.03125,  // 'Gigarecykler'
                        );

						// Größe des Laderaums
                        $CapacityMaxLow = array (
                               1  => 50000,
                               2  => 100000,
                               3  => 200000,
                               4  => 400000,
                               5  => 800000,
                               6  => 1600000,
                               7  => 3200000,
                               8  => 6400000,
                               9  => 12800000,
                               10 => 25600000,
                               11 => 51200000,
                               12 => 102400000,
                               13 => 204800000,
                               14 => 409600000,
                               15 => 819200000,
                        );
						
                        $FleetStayDuration = ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;

                        // Initialisation du contenu de la Flotte
                        $farray = explode(";", $FleetRow['fleet_array']);
                        foreach ($farray as $Item => $Group) {
                                if ($Group != '') {
                                        $Class = explode (",", $Group);
                                        $TypeVaisseau = $Class[0];
                                        $NbreVaisseau = $Class[1];

                                        $LaFlotte[$TypeVaisseau] = $NbreVaisseau;

                                        //On calcul les ressources maximum qui peuvent être récupéré
                                        $FleetCapacity += $pricelist[$TypeVaisseau]['capacity'];
                                        // Maintenant on calcul en points toute la flotte
                                        $FleetPoints   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
                                }
                        }

                        // Espace deja occupé dans les soutes si ce devait etre le cas
                        $FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium']+ $FleetRow['fleet_resource_appolonium'];
                        $FleetCapacity     -= $FleetUsedCapacity;

                        //On récupère le nombre total de vaisseaux
                        $FleetCount = $FleetRow['fleet_amount'];

                        // Bon on les mange comment ces explorateurs ???
						
                       $Hasard = rand(1,11);
					   

                        $MessSender = $lang['sys_mess_qg']. "(".$Hasard.")";

                        if ($Hasard == 1 ) {
                                // Pas de bol, on les mange tout crus
                                $Hasard     += 1;
                                $LostAmount  = (($Hasard * 33) + 1) / 100;

                                // Message pour annoncer la bonne mauvaise nouvelle
                                if ($LostAmount == 100) {
                                        // Supprimer effectivement la flotte
                                        SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
                                        doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                                } else {
                                        foreach ($LaFlotte as $Ship => $Count) {
                                                $LostShips[$Ship] = intval($Count * $LostAmount);
                                                $NewFleetArray   .= $Ship.",". ($Count - $LostShips[$Ship]) .";";
                                        }

                                        $QryUpdateFleet  = "UPDATE {{table}} SET ";
                                        $QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
                                        $QryUpdateFleet .= "`fleet_mess` = '1'  ";
                                        $QryUpdateFleet .= "WHERE ";
                                        $QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
                                        doquery( $QryUpdateFleet, 'fleets');
                                        SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
                                }

                                } elseif ($Hasard == 2) {
                                    // Ah un tour pour rien
                                    doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                                    SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
                                } elseif ($Hasard == 3 or $Hasard == 4 or $Hasard ==5) {
                                      // Gains de ressources
	                               	    $i = rand(1,15);						    
                                     if ($FleetCapacity <= $CapacityMaxLow[$i]){ 
        								$MinCapacity = $CapacityMaxLow[$i] - $CapacityMaxLow[$i-1];
                                        $MaxCapacity = $CapacityMaxLow[$i];
                                        $FoundGoods  = rand($MinCapacity, $MaxCapacity);
                                        $FoundMetal  = intval($FoundGoods / 2);
                                        $FoundCrist  = intval($FoundGoods / 4);
                                        $FoundDeute  = intval($FoundGoods / 6);
										$FoundAppolo  = intval($FoundGoods / 8);
                                        $QryUpdateFleet  = "UPDATE {{table}} SET ";
                                        $QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
                                        $QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist ."', ";
                                        $QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
										$QryUpdateFleet .= "`fleet_resource_appolonium` = `fleet_resource_appolonium` + '". $FoundAppolo ."', ";
                                        $QryUpdateFleet .= "`fleet_mess` = '1'  ";
                                        $QryUpdateFleet .= "WHERE ";
                                        $QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
                                        doquery( $QryUpdateFleet, 'fleets');
                                        $Message = sprintf($lang['sys_expe_found_goods'],
                                        pretty_number($FoundMetal), $lang['Metal'],
                                        pretty_number($FoundCrist), $lang['Crystal'],
										pretty_number($FoundDeute), $lang['Deuterium'],
                                        pretty_number($FoundAppolo), $lang['Appolonium']);
                                        SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
                                }
						} elseif ($Hasard == 6 or $Hasard == 7 or $Hasard == 8) {
						        if ($FleetRow['fleet_owner'] != in_array ($user['id'],$pirat) ){
	                              shuffle ($pirat);
	                              $owner = doquery('SELECT * FROM {{table}} WHERE id='.$pirat[0],'users', true);							
   						          $fleetarray	= array();
						          $flugzeit = 900; 
                                  $start_time = time()+$flugzeit;
                            	  $end_time	= $start_time + $flugzeit;
                               	  $amount		= 16000;
                             	  $fleetarray	= array( '203,8000;202,2000;206,5000;207,1000;','214,100;215,10000;207,5900;','204,5000;215,5000;205,5000;207,1000;',
								                     '217,10000;215,5000;218,1000;','211,10000;213,5000;216,1000;','211,1000;213,10000;216,5000;','203,16000;','202,16000;',
													 '218,16000;','214,10000;216,4000;218,1000;');
                                  shuffle($fleetarray);
                             	  $QryInsertFleet  = "INSERT INTO {{table}} SET ";
                             	  $QryInsertFleet .= "`fleet_owner` = '" . $pirat[0] . "', ";
                            	  $QryInsertFleet .= "`fleet_mission` = '1', ";
                            	  $QryInsertFleet .= "`fleet_amount` = '". $amount ."', ";
                             	  $QryInsertFleet .= "`fleet_array` = '". $fleetarray[0] ."', ";
								  $QryInsertFleet .= "`fleet_end_stay` = '0', ";
                              	  $QryInsertFleet .= "`fleet_start_time` = '". $start_time ."', ";
                             	  $QryInsertFleet .= "`fleet_start_galaxy` = '" . $owner['galaxy'] . "', ";
                             	  $QryInsertFleet .= "`fleet_start_system` = '" . $owner['system'] . "', ";
                             	  $QryInsertFleet .= "`fleet_start_planet` = '" . $owner['planet'] . "', ";
                              	  $QryInsertFleet .= "`fleet_start_type` = '1', ";
                              	  $QryInsertFleet .= "`fleet_end_time` = '". $end_time ."', ";
                             	  $QryInsertFleet .= "`fleet_end_galaxy` = '". $FleetRow['fleet_start_galaxy'] ."', ";
                              	  $QryInsertFleet .= "`fleet_end_system` = '". $FleetRow['fleet_start_system'] ."', ";
                             	  $QryInsertFleet .= "`fleet_end_planet` = '". $FleetRow['fleet_start_planet'] ."', ";
                              	  $QryInsertFleet .= "`fleet_end_type` = '". $FleetRow['fleet_start_type'] ."', ";
                             	  $QryInsertFleet .= "`fleet_resource_metal` = '0', ";
                            	  $QryInsertFleet .= "`fleet_resource_crystal` = '0', ";
                            	  $QryInsertFleet .= "`fleet_resource_deuterium` = '0', ";
								  $QryInsertFleet .= "`fleet_resource_appolonium` = '0', ";
                              	  $QryInsertFleet .= "`fleet_target_owner` = '". $FleetRow['fleet_owner'] ."', ";
								  $QryInsertFleet .= "`fleet_group` = '0', ";
								  $QryinsertFleet .= "`fleet_mess` = '1' ";
                             	  $QryInsertFleet .= "`start_time` = '". time() ."';";
                             	  doquery( $QryInsertFleet, 'fleets');								
                                  doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
						          SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_found_pirat'] );
							      $Hasard = 0 ;
							    }
						
						      
																	
		                    } elseif ($Hasard == 9) {
                                // Ah un tour pour rien
                                doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                                SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
                            } elseif ($Hasard == 10 or $Hasard == 11) {
                                // Gain de vaisseaux
								$FoundChance = $FleetPoints / $FleetCount;
                                $FoundShip = array();
                                for ($Ship >= 202; $Ship <= 219; $Ship++) {
                                        if ($LaFlotte[$Ship] != 0) {
                                                $FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]);
                                                if ($FoundShip[$Ship] > 0) {
                                                        $LaFlotte[$Ship] += $FoundShip[$Ship];
                                                }
                                        }
                                }
                                $NewFleetArray = "";
                                $FoundShipMess = "";
                                foreach ($LaFlotte as $Ship => $Count) {
                                        if ($Count >= 0) {
                                                $NewFleetArray   .= $Ship.",". $Count .";";
                                        }
                                }
                                foreach ($FoundShip as $Ship => $Count) {
                                        if ($Count != 0) {
                                                $FoundShipMess   .= $Count." ".$lang['tech'][$Ship].",";
                                        }
                                }

                                $QryUpdateFleet  = "UPDATE {{table}} SET ";
                                $QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
                                $QryUpdateFleet .= "`fleet_mess` = '1'  ";
                                $QryUpdateFleet .= "WHERE ";
                                $QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
                                doquery( $QryUpdateFleet, 'fleets');
                                $Message = $lang['sys_expe_found_ships']. $FoundShipMess . "";
                                SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
                        }

                }
				
                    } else {
                // La Flotte est de retour a quai
                        if ($FleetRow['fleet_end_time'] <= time()) {
                        // Reintegration de ce qui se ballade avec la flotte
                        $farray = explode(";", $FleetRow['fleet_array']);
                        foreach ($farray as $Item => $Group) {
                                if ($Group != '') {
                                        $Class = explode (",", $Group);
                                        $FleetAutoQuery .= "`". $resource[$Class[0]]. "` = `". $resource[$Class[0]] ."` + ". $Class[1] .", ";
                                }
                        }
                        // Message pour annoncer le retour de flotte
                        SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );
                        RestoreFleetToPlanet ( $FleetRow, true );
                        // Suppression de la flotte
                        doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                }
        }
}
// Mod Aldimensch eingebaut und gefixt.
// Überarbeitet 04112009 Metusalem
?>