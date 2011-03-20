<?php


    function MissionCaseExpedition ( $FleetRow ) {
       global $lang, $resource, $pricelist;

       $FleetOwner = $FleetRow['fleet_owner'];
       $MessSender = $lang['sys_mess_qg'];
       $MessTitle  = $lang['sys_expe_report'];

       if ($FleetRow['fleet_mess'] == 0) {

          if ($FleetRow['fleet_end_stay'] < time()) {
             $PointsFlotte = array(
                202 => 1.0,  // 'Petit transporteur'
                203 => 1.5,  // 'Grand transporteur'
                204 => 0.5,  // 'Chasseur leger'
                205 => 1.5,  // 'Chasseur lourd'
                206 => 2.0,  // 'Croiseur'
                207 => 2.5,  // 'Vaisseau de bataille'
                208 => 0.5,  // 'Vaisseau de colonisation'
                209 => 1.0,  // 'Recycleur'
                210 => 0.01, // 'Sonde espionnage'
                211 => 3.0,  // 'Bombardier'
                212 => 0.0,  // 'Satellite solaire'
                213 => 4.0,  // 'Destructeur'
                214 => 10.0,  // 'Etoile de la mort'
                215 => 3.2,  // 'Traqueur'
             //  216 => X,  // 'Votre 1er vaisseau'
             //  217 => X,  // 'Votre 2e vaisseau'
             //  218 => X,  // 'Votre 3e vaisseau'
             //  219 => X,  // 'Votre 4e vaisseau'
             //  220 => X,  // 'Votre 5e vaisseau'
             //  Etc...
             );

             // Table de ratio de gains en nombre par type de vaisseau
             $RatioGain = array (
                202 => 75.0,     // 'Petit transporteur'
                203 => 25.0,     // 'Grand transporteur'
                204 => 80.0,     // 'Chasseur leger'
                205 => 20.0,     // 'Chasseur lourd'
                206 => 11.0,    // 'Croiseur'
                207 => 7.0,   // 'Vaisseau de bataille'
                208 => 2.0,     // 'Vaisseau de colonisation'
                209 => 6.0,     // 'Recycleur'
                210 => 90.0,     // 'Sonde espionnage'
                211 => 4.5,  // 'Bombardier'
                212 => 0.0,     // 'Satellite solaire'
                213 => 2.0,  // 'Destructeur'
                214 => 0.1, // 'Etoile de la mort'
                215 => 4.0,  // 'Traqueur'
             //  216 => X,  // 'Votre 1er vaisseau'
             //  217 => X,  // 'Votre 2e vaisseau'
             //  218 => X,  // 'Votre 3e vaisseau'
             //  219 => X,  // 'Votre 4e vaisseau'
             //  220 => X,  // 'Votre 5e vaisseau'
             //  Etc...
             );

             $FleetStayDuration = ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;

             $farray = explode(";", $FleetRow['fleet_array']);
             foreach ($farray as $Item => $Group) {
                if ($Group != '') {
                   $Class = explode (",", $Group);
                   $TypeVaisseau = $Class[0];
                   $NbreVaisseau = $Class[1];

                   $LaFlotte[$TypeVaisseau] = $NbreVaisseau;

                   $FleetCapacity += $pricelist[$TypeVaisseau]['capacity'];
                   $FleetPoints   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
                }
             }

             $FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
             $FleetCapacity     -= $FleetUsedCapacity;

             $FleetCount = $FleetRow['fleet_amount'];

             $Hasard = rand(1, 25);

             $MessSender = $lang['sys_mess_qg']. "(".$Hasard.")";

             if ($Hasard == 1 or $Hasard == 2) {

                $Hasard     += 1;
                $LostAmount  = (($Hasard * 99) + 1);

                if ($LostAmount == 100) {
                   SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
                   doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                } else {
                   doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');   
                   SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
                }

             } elseif ($Hasard >= 3 && $Hasard <= 10) {
                $Hasard = rand(1, 10);
               
                doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');   
                SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_'.$Hasard] );
                         
             } elseif ($Hasard >= 11 && $Hasard <= 15) {

                if ($FleetCapacity > 50000) {
                   $MinCapacity = $FleetCapacity - 1000;
                   $MaxCapacity = $FleetCapacity;
                   $FoundGoods  = rand($MinCapacity, $MaxCapacity);
                   $FoundMetal  = intval($FoundGoods / 1);
                   $FoundCrist  = intval($FoundGoods / 2);
                   $FoundDeute  = intval($FoundGoods / 3);

                   $QryUpdateFleet  = "UPDATE {{table}} SET ";
                   $QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
                   $QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist ."', ";
                   $QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
                   $QryUpdateFleet .= "`fleet_mess` = '1'  ";
                   $QryUpdateFleet .= "WHERE ";
                   $QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
                   doquery( $QryUpdateFleet, 'fleets');
                   $Message = sprintf($lang['sys_expe_found_goods'],
                      pretty_number($FoundMetal), $lang['Metal'],
                      pretty_number($FoundCrist), $lang['Crystal'],
                      pretty_number($FoundDeute), $lang['Deuterium']);
                   SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
                }
             } elseif ($Hasard >= 16 && $Hasard <= 19) {
                $Hasard = rand(11, 20);
               
                doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');   
                SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_'.$Hasard] );
                     
             } elseif ($Hasard >= 20 && $Hasard <= 25) {
                $FoundChance = $FleetPoints / $FleetCount;
                for ($Ship = 202; $Ship < 240; $Ship++) {
                   if ($LaFlotte[$Ship] != 0) {
                      $FoundShip[$Ship] = round(sqrt($LaFlotte[$Ship] * $RatioGain[$Ship]));
                      if ($FoundShip[$Ship] > 0) {
                         $LaFlotte[$Ship] += $FoundShip[$Ship];
                      }
                   }
                }
                $NewFleetArray = "";
                $FoundShipMess = "";
                foreach ($LaFlotte as $Ship => $Count) {
                   if ($Count > 0) {
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
          if ($FleetRow['fleet_end_time'] < time()) {
             $farray = explode(";", $FleetRow['fleet_array']);
             foreach ($farray as $Item => $Group) {
                if ($Group != '') {
                   $Class = explode (",", $Group);
                   $FleetAutoQuery .= "`". $resource[$Class[0]]. "` = `". $resource[$Class[0]] ."` + ". $Class[1] .", ";
                }
             }
             $QryUpdatePlanet  = "UPDATE {{table}} SET ";
             $QryUpdatePlanet .= $FleetAutoQuery;
             $QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
             $QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
             $QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
             $QryUpdatePlanet .= "WHERE ";
             $QryUpdatePlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
             $QryUpdatePlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
             $QryUpdatePlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
             $QryUpdatePlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
             $QryUpdatePlanet .= "LIMIT 1 ;";
             doquery( $QryUpdatePlanet, 'planets');

             SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );

             doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
          }
       }
    }


?>