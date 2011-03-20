<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** MissionCaseExpedition.php             **
******************************************/

function MissionCaseExpedition ( $FleetRow ) {
	global $lang, $resource, $pricelist;

	$FleetOwner = $FleetRow['fleet_owner'];
	$MessSender = $lang['sys_mess_qg'];
	$MessTitle  = $lang['sys_expe_report'];

	if ($FleetRow['fleet_mess'] == 0) {
		if ($FleetRow['fleet_end_stay'] < time()) {
			$PointsFlotte = array(
				202 => 1.0, 
				203 => 1.5,  
				204 => 0.5,  
				205 => 1.5,  
				206 => 2.0,  
				207 => 2.5,  
				208 => 0.5,  
				209 => 1.0,  
				210 => 0.1,
				211 => 3.0,  
				212 => 0.0,  
				213 => 3.5,  
				214 => 5.0, 
				215 => 3.2,  
				216 => 2.0, 
				217 => 2.0, 
				218 => 2.0, 
			);

			$RatioGain = array (
				202 => 0.5,     
				203 => 0.5,     
				204 => 0.5,     
				205 => 0.75,     
				206 => 0.5,    
				207 => 0.25,   
				208 => 0.75,     
				209 => 0.25,     
				210 => 0.25,     
				211 => 0.1,  
				212 => 0.0,     
				213 => 0.1,  
				214 => 0.05, 
				215 => 0.1,  
				216 => 0.5,
				217 => 0.25,
				218 => 0.25,    
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

			$FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_tachyon'];
			$FleetCapacity     -= $FleetUsedCapacity;
			$FleetCount = $FleetRow['fleet_amount'];
			$Hasard = rand(0, 10);
			$MessSender = $lang['sys_mess_qg']. "(".$Hasard.")";

			if ($Hasard < 3) {
				$Hasard     += 1;
				$LostAmount  = (($Hasard * 33) + 1) / 100;

				if ($LostAmount == 100) {
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

			} elseif ($Hasard == 3) {
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
			} elseif ($Hasard >= 4 && $Hasard < 7) {
				if ($FleetCapacity > 5000) {
					$MinCapacity = $FleetCapacity - 5000;
					$MaxCapacity = $FleetCapacity;
					$FoundGoods  = rand($MinCapacity, $MaxCapacity);
					$FoundMetal  = intval($FoundGoods / 2);
					$FoundCrist  = intval($FoundGoods / 4);
					$FoundDeute  = intval($FoundGoods / 6);
					$FoundTach   = intval($FoundGoods / 8);

					$QryUpdateFleet  = "UPDATE {{table}} SET ";
					$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
					$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist ."', ";
					$QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
					$QryUpdateFleet .= "`fleet_resource_tachyon` = `fleet_resource_tachyon` + '". $FoundTach ."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					doquery( $QryUpdateFleet, 'fleets');
					$Message = sprintf($lang['sys_expe_found_goods'],
						pretty_number($FoundMetal), $lang['Metal'],
						pretty_number($FoundCrist), $lang['Crystal'],
						pretty_number($FoundDeute), $lang['Deuterium'],
						pretty_number($FoundTach), $lang['Tachyon']);
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
				}
			} elseif ($Hasard == 7) {
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
			} elseif ($Hasard >= 8 && $Hasard < 11) {
				$FoundChance = $FleetPoints / $FleetCount;
				for ($Ship = 202; $Ship < 218; $Ship++) {
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
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] .", ";
			$QryUpdatePlanet .= "`tachyon` = `tachyon` + ". $FleetRow['fleet_resource_tachyon'] ." ";
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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>