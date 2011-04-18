<?php
    //######################################################
    //# Name:      AbandonColony.php
	//######################################################

    function AbandonColony($user,$planetrow) {
       global $phpEx, $xnova_root_path;
       $destruyed = time() + 60 * 60 * 24;
       $DeleteMoon = false;
       if ($planetrow["planet_type"]==1){
          // chekear si el planeta tiene luna
          $QryWithMoon  = "SELECT * FROM {{table}} ";
          $QryWithMoon .= "WHERE ";
          $QryWithMoon .= "`destruyed` = '0' AND ";
          $QryWithMoon .= "`galaxy` = '". $planetrow['galaxy'] ."' AND ";
          $QryWithMoon .= "`system` = '". $planetrow['system'] ."' AND ";
          $QryWithMoon .= "`lunapos` = '". $planetrow['planet'] ."' AND ";
          $QryWithMoon .= "`id_owner` = '". $user['id'] ."' ;";
          $IsMoon = doquery( $QryWithMoon , 'lunas',true);
          if($IsMoon){
                $DeleteMoon = true; // borrar luna
            }
          
          // ponemos el planeta como destruido
          $QryUpdatePlanet = "UPDATE {{table}} SET ";
          $QryUpdatePlanet .= "`destruyed` = '" . $destruyed . "', ";
          $QryUpdatePlanet .= "`id_owner` = '0' ";
          $QryUpdatePlanet .= "WHERE ";
          $QryUpdatePlanet .= "`id` = '" . $user['current_planet'] . "' LIMIT 1;";
          doquery($QryUpdatePlanet , 'planets');
       
       }elseif($planetrow["planet_type"]==3){
          $DeleteMoon = true; //borrar luna
       }
       
       if ($DeleteMoon){
          // borro la luna de la tabla planets
          // Porque carajo la borro y no la pongo destruida como a los planetas?
          /*  .- Porque es al pedo tener este record ya que no se muestra en ningun lado, lo de los planetas sirve para lo ponga destruido en galaxia
                supongo que se puede dejar para un eventual caso de ver algo desde la adminstracion o algo, pero como yo no lo necesito la borro
                (espero no estar equivocado :s)
          */
          $QryDeleteMoon = "DELETE FROM {{table}} ";
          $QryDeleteMoon .= "WHERE ";
          $QryDeleteMoon .= "`galaxy` = '". $planetrow['galaxy'] ."' AND ";
          $QryDeleteMoon .= "`system` = '". $planetrow['system'] ."' AND ";
          $QryDeleteMoon .= "`planet` = '". $planetrow['planet'] ."' AND ";
          $QryDeleteMoon .= "`planet_type` = '3' AND ";
          $QryDeleteMoon .= "`id_owner` = '". $user['id'] ."' ;";
          doquery($QryDeleteMoon , 'planets');

          // borro la luna de la tabla lunas
          $Qrydestructionlune  = "DELETE FROM {{table}} ";
          $Qrydestructionlune .= "WHERE ";
          $Qrydestructionlune .= "`galaxy` = '". $planetrow['galaxy'] ."' AND ";
          $Qrydestructionlune .= "`system` = '". $planetrow['system'] ."' AND ";
          $Qrydestructionlune .= "`lunapos` = '". $planetrow['planet'] ."' AND ";
          $Qrydestructionlune .= "`id_owner` = '". $user['id'] ."' ;";
          doquery( $Qrydestructionlune , 'lunas');
          
          //saco la luna de la vista de galaxia
          $Qrydestructionlune2  = "UPDATE {{table}} SET ";
          $Qrydestructionlune2 .= "`id_luna` = '0' ";
          $Qrydestructionlune2 .= "WHERE ";
          $Qrydestructionlune2 .= "`galaxy` = '". $planetrow['galaxy'] ."' AND ";
          $Qrydestructionlune2 .= "`system` = '". $planetrow['system'] ."' AND ";
          $Qrydestructionlune2 .= "`planet` = '". $planetrow['planet'] ."' ;";
          doquery( $Qrydestructionlune2 , 'galaxy');
       
       }

    }

    function CheckFleets($planetrow){

       $QryFleet = "SELECT * FROM {{table}} WHERE ";
       $QryFleet .= "(`fleet_start_galaxy` = '".$planetrow["galaxy"]."' AND ";
       $QryFleet .= "`fleet_start_system` = '".$planetrow["system"]."' AND ";
       $QryFleet .= "`fleet_start_planet` = '".$planetrow["planet"]."'";
       if ($planetrow["planet_type"]==3){
          $QryFleet .= " AND `fleet_start_type` = '3'";
       }
       $QryFleet .= ") OR ";
       $QryFleet .= "(`fleet_end_galaxy` = '".$planetrow["galaxy"]."' AND ";
       $QryFleet .= "`fleet_end_system` = '".$planetrow["system"]."' AND ";
       $QryFleet .= "`fleet_end_planet` = '".$planetrow["planet"]."'";
       if ($planetrow["planet_type"]==3){
          $QryFleet .= " AND `fleet_end_type` = '3'";
       }
       $QryFleet .= " AND `fleet_mess` <> 1 ); ";
       $fleets = doquery($QryFleet, 'fleets',true);
       if($fleets){
          return true;
       }
       return false;
    }

    ?>