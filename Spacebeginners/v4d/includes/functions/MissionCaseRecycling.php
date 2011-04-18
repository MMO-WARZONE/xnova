<?php

 /**
* MissionCaseRecycling.php
* @Licence GNU (GPL)
* @version 2.2
* @copyright 2009 
* @Team Space Beginner
*/

function MissionCaseRecycling ($FleetRow) {
	global $pricelist, $lang;

	if ($FleetRow["fleet_mess"] == 0) {
		if ($FleetRow['fleet_start_time'] <= time()) {
			$QrySelectGalaxy  = "SELECT * FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
			$QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
			$QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);

			$FleetRecord         = explode(";", $FleetRow['fleet_array']);
			$RecyclerCapacity    = 0;
			$OtherFleetCapacity  = 0;
			foreach ($FleetRecord as $Item => $Group) {
				if ($Group != '') {
					$Class        = explode (",", $Group);
					if ($Class[0] == 209 or $Class[0] == 219) {
						$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
					} else {
						$OtherFleetCapacity += $pricelist[$Class[0]]["capacity"] * $Class[1];
					}
				}
		}

			$IncomingFleetGoods = $FleetRow["fleet_resource_metal"] + $FleetRow["fleet_resource_crystal"]+ $FleetRow["fleet_resource_deuterium"] + $FleetRow["fleet_resource_appolonium"];
			if ($IncomingFleetGoods > $OtherFleetCapacity) {
				$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);
			}
			

			if (($TargetGalaxy["metal"] + $TargetGalaxy["crystal"] + $TargetGalaxy["appolonium"]) <= $RecyclerCapacity) {
				$RecycledGoods["metal"]   = $TargetGalaxy["metal"];
				$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
				$RecycledGoods["appolonium"] = $TargetGalaxy["appolonium"];
			} else {
				if (($TargetGalaxy["metal"]   >= $RecyclerCapacity / 3) AND
					($TargetGalaxy["crystal"] >= $RecyclerCapacity / 3) AND
					($TargetGalaxy["appolonium"] >= $RecyclerCapacity / 3)) {
					$RecycledGoods["metal"]   = $RecyclerCapacity / 3;
					$RecycledGoods["crystal"] = $RecyclerCapacity / 3;
					$RecycledGoods["appolonium"] = $RecyclerCapacity / 3;
				}else{
                if ($TargetGalaxy["appolonium"]   >= $RecyclerCapacity ){
                    $RecycledGoods["appolonium"]   = $RecyclerCapacity ;
					$RecycledGoods["metal"] = 0;
					$RecycledGoods["crystal"] = 0;
                    }else{
                if ($TargetGalaxy["crystal"]   >= $RecyclerCapacity ){
                    $RecycledGoods["crystal"]   = $RecyclerCapacity ;
					$RecycledGoods["metal"] = 0;
					$RecycledGoods["appolonium"] = 0;
                    }else{
					
                if ($TargetGalaxy["metal"]   >= $RecyclerCapacity ){
                    $RecycledGoods["metal"]   = $RecyclerCapacity ;
					$RecycledGoods["crystal"] = 0;
					$RecycledGoods["appolonium"] = 0;
                   }else {
				
                if ($TargetGalaxy["appolonium"]   <= $RecyclerCapacity  AND $TargetGalaxy["appolonium"]> 0){
                    $RecycledGoods["appolonium"]   = $TargetGalaxy["appolonium"] ;
					if ($TargetGalaxy["metal"] >= $RecyclerCapacity - $RecycledGoods["appolonium"]){
					$RecycledGoods["metal"]        = $RecyclerCapacity - $RecycledGoods["appolonium"];
					}
					if ($TargetGalaxy["crystal"] >= $RecyclerCapacity - $RecycledGoods["appolonium"] - $RecycledGoods["metal"]){
					$RecycledGoods["crystal"]      = $RecyclerCapacity - $RecycledGoods["appolonium"] - $RecycledGoods["metal"];
					}
                    }else{
                if ($TargetGalaxy["crystal"]    <= $RecyclerCapacity AND $TargetGalaxy["crystal"]> 0){
                    $RecycledGoods["crystal"]    = $TargetGalaxy["crystal"] ;
					if ($TargetGalaxy["metal"] >= $RecyclerCapacity - $RecycledGoods["crystal"]){
					$RecycledGoods["metal"]      = $RecyclerCapacity - $RecycledGoods["crystal"];
					}
					if ($TargetGalaxy["appolonium"] >= $RecyclerCapacity - $RecycledGoods["crystal"] - $RecycledGoods["metal"]){
					$RecycledGoods["appolonium"] = $RecyclerCapacity - $RecycledGoods["crystal"] - $RecycledGoods["metal"];
					}
                    }else{
					
                if ($TargetGalaxy["metal"]      <= $RecyclerCapacity AND $TargetGalaxy["metal"] > 0){
                    $RecycledGoods["metal"]      = $TargetGalaxy["metal"] ;
					if ($TargetGalaxy["crystal"] >= $RecyclerCapacity - $RecycledGoods["metal"]){
					$RecycledGoods["crystal"]    = $RecyclerCapacity - $RecycledGoods["metal"];
					}
					if ($TargetGalaxy["appolonium"] >= $RecyclerCapacity - $RecycledGoods["crystal"] - $RecycledGoods["metal"]){
					$RecycledGoods["appolonium"] =  $RecyclerCapacity - $RecycledGoods["crystal"] - $RecycledGoods["metal"];
					}
                        }					
				       }  
		              }	
                     }
        	       }					
				  }  
		        }	
               }
        	  
			$NewCargo['Metal']        = $FleetRow["fleet_resource_metal"]   + $RecycledGoods["metal"];
			$NewCargo['Crystal']      = $FleetRow["fleet_resource_crystal"] + $RecycledGoods["crystal"];
			$NewCargo['Appolonium']   = $FleetRow["fleet_resource_appolonium"] + $RecycledGoods["appolonium"];
			$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= "`metal` = `metal` - '".$RecycledGoods["metal"]."', ";
			$QryUpdateGalaxy .= "`crystal` = `crystal` - '".$RecycledGoods["crystal"]."', ";
			$QryUpdateGalaxy .= "`appolonium` = `appolonium` - '".$RecycledGoods["appolonium"]."' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
			$QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
			$QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			doquery( $QryUpdateGalaxy, 'galaxy');

			$Message = sprintf($lang['sys_recy_gotten'], pretty_number($RecycledGoods["metal"]), $lang['Metal'], pretty_number($RecycledGoods["crystal"]), $lang['Crystal'], pretty_number($RecycledGoods["appolonium"]), $lang['Appolonium']);
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_mess_tower'], $lang['sys_recy_report'], $Message);
		

		    $QryUpdateFleet  = "UPDATE {{table}} SET ";
            $QryUpdateFleet .= "`fleet_resource_metal` = '".$NewCargo['Metal']."', ";
			$QryUpdateFleet .= "`fleet_resource_crystal` = '".$NewCargo['Crystal']."', ";
			$QryUpdateFleet .= "`fleet_resource_appolonium` = '".$NewCargo['Appolonium']."', ";
            $QryUpdateFleet .= "`fleet_mess` = '1' ";
            $QryUpdateFleet .= "WHERE ";
            $QryUpdateFleet .= "`fleet_id` = '".$FleetRow['fleet_id']."' ";
            $QryUpdateFleet .= "LIMIT 1;";
            doquery( $QryUpdateFleet, 'fleets');

		}
	} else {
		if ($FleetRow['fleet_end_time'] <= time()) {
			// Mettre le message de retour de flotte
			$Message         = sprintf( $lang['sys_tran_mess_recback'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'] ,
						pretty_number($FleetRow['fleet_resource_appolonium']), $lang['Appolonium'] );
            SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			RestoreFleetToPlanet ( $FleetRow, true );
						//Piratenangriff nach Zufallsprinzip
	        $zufall = 0;
     	    $zufall = rand(1,10);
	        if ($zufall == 7){
	        Piratenangriff( $FleetRow );
	        $zufall = 0 ;
	        }
            // Ende Piratenangriff
			doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
		}
	}
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 Mise en module initiale

?>