<?php
//version 1

if(!defined('INSIDE')){ die(header("location:../../"));}

function fleetback($user){
	global $db;
    if (is_numeric($_POST['fleetid']) )
    {
            $fleetid  = intval($_POST['fleetid']);
            $FleetRow = $db->query("SELECT * FROM {{table}} WHERE `fleet_id` = '". $fleetid ."';", 'fleets', true);
            $i = 0;

            if ($FleetRow['fleet_owner'] == $user['id'])
            {
                    if ($FleetRow['fleet_mess'] == 0 || $FleetRow['fleet_mess'] == 2)
                    {
                            $CurrentFlyingTime = time() - $FleetRow['start_time'];
                            $ReturnFlyingTime  =($FleetRow['fleet_end_stay'] != 0 ) ? $FleetRow['fleet_start_time']-$FleetRow['start_time']+ time() : $CurrentFlyingTime + time();
                            //$ReturnFlyingTime  = $CurrentFlyingTime + time();

                            $QryUpdateFleet  = "UPDATE {{table}} SET ";
                            $QryUpdateFleet .= "`fleet_start_time` = '". (time() - 1) ."', ";
                            $QryUpdateFleet .= "`fleet_end_stay` = '0', ";
                            $QryUpdateFleet .= "`fleet_end_time` = '". ($ReturnFlyingTime + 1) ."', ";
                            $QryUpdateFleet .= "`fleet_target_owner` = '". $user['id'] ."', ";
                            $QryUpdateFleet .= "`fleet_mess` = '1' ";
                            $QryUpdateFleet .= "WHERE ";
                            $QryUpdateFleet .= "`fleet_id` = '" . $fleetid . "';";
                            $db->query( $QryUpdateFleet, 'fleets');
                    }
            }
            $sac=$db->query("SELECT * from {{table}} where `origen_id`='". $fleetid ."'","sac",true);
            if($sac){
                    if($sac["origen_id"]==$FleetRow['fleet_group']){
                            $db->query("UPDATE {{table}} SET `fleet_group`='0',
                                    where `fleet_group`='".$FleetRow['fleet_group']."'","fleets");
                            $db->query("DELETE FROM {{table}} `id`='".$sac["id"]."'","sac");
                    }
            }


    }
    header("location:game.php?page=fleet");
}
?>