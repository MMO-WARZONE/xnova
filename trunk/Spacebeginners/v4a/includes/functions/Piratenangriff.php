<?php

/**
  * Piratenangriff.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

function Piratenangriff ( $FleetRow ) {
        global $lang, $resource, $pricelist, $CombatCaps, $user, $pirat;

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
								}
                            }								
?>