<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
include($xnova_root_path . 'admin/statfunctions.' . $phpEx);
global $Adminerlaubt,$pirat;

if ($user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
    includeLang('admin');

    $StatDate   = time();

    $AZ = array( // Angriffszonen
        1 =>  $game_config['az1'],
        2 =>  $game_config['az2'],
        3 =>  $game_config['az3'],
        4 =>  $game_config['az4'],
        5 =>  $game_config['az5'],
        6 =>  $game_config['az6'],
        7 =>  $game_config['az7'],
        8 =>  $game_config['az8'],
        9 =>  $game_config['az9'],
       10 => $game_config['az10'],
       11 => $game_config['az11'],
       12 => $game_config['az12'],
       13 => $game_config['az13'],
       14 => $game_config['az14']
    );

    // 1 Tag = 86400 / 2 Tage = 172800 / 3 Tage = 259200 / 4 Tage = 345600 / 5 Tage = 432000

    $spio       = time()-345600; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$spio."' AND `message_type` = '0';", 'messages');   // Spionage Nachrichten
    $play       = time()-432000; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$play."' AND `message_type` = '1';", 'messages');   // User Nachrichten
    $ally       = time()-432000; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$ally."' AND `message_type` = '2';", 'messages');   // Ally Nachrichten
    $kamp       = time()-259200; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$kamp."' AND `message_type` = '3';", 'messages');   // Kampf Nachrichten
    $syte       = time()-259200; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$syte."' AND `message_type` = '4';", 'messages');   // System Nachrichten
    $tran       = time()-86400;  doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$tran."' AND `message_type` = '5';", 'messages');   // Transport Nachrichten
    $expo       = time()-172800; doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$expo."' AND `message_type` = '15';", 'messages');  // Expo Nachrichten
    $baun       = time()-86400;  doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$baun."' AND `message_type` = '99';", 'messages');  // Bau Nachrichten

    $zeit2      = time()-259200; doquery ("DELETE FROM {{table}} WHERE `time` < '".$zeit2."';", 'rw');        // RW Nachrichten
    $zeit3      = time()-864000; doquery ("DELETE FROM {{table}} WHERE `time` < '".$zeit3."';", 'supp');      // Support
    $zeit4      = time()-86400;  doquery ("DELETE FROM {{table}} WHERE `timestamp` < '".$zeit4."';", 'chat'); // Chatnachrichten

    doquery ("DELETE FROM {{table}} WHERE `id_owner` = 0 ;", 'planets'); // Planet mit Id 0 wird sofort gelöscht
    doquery ("DELETE FROM {{table}} WHERE `id_planet` = 0 ;", 'galaxy'); // Galaxieeinträge ohne Planet löschen
    doquery ( "UPDATE {{table}} SET `ally_name` = ' ' WHERE `ally_id` = 0;" , 'users');
    doquery ( "DELETE FROM {{table}} WHERE `stat_code` = '2';" , 'statpoints');
    doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

    $GameUsers  = doquery("SELECT * FROM {{table}} WHERE `authlevel` = '0'" ,  'users');

    while ($CurUser = mysql_fetch_assoc($GameUsers)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

        while($o = mysql_fetch_array($OldStatRecord)) {
            $OldTotalRank = $o['total_rank'];
            $OldTechRank = $o['tech_rank'];
            $OldBuildRank = $o['build_rank'];
            $OldDefsRank = $o['defs_rank'];
            $OldFleetRank = $o['fleet_rank'];

            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        }

        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        $UsrFleets      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');

        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
        }

        while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
            $Points       = GetFleetPointsOnTour ( $CurFleet['fleet_array'] );
            $TFleetCount += $Points['FleetCount'];
            $GCount      += $Points['FleetCount'];
            $TFleetPoints+= ($Points['FleetPoint'] / 1000);
            $PlanetPoints = $Points['FleetPoint'] / 1000;
            $GPoints     += $PlanetPoints;
        }

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
        $QryInsertStats .= "`stat_type` = '1', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');

        if($GPoints < $AZ[1]) {
            $UserAZ = 1;
        } elseif($GPoints > $AZ[1] AND $GPoints < $AZ[2]) {
            $UserAZ = 2;
        } elseif($GPoints > $AZ[2] AND $GPoints < $AZ[3]) {
            $UserAZ = 3;
        } elseif($GPoints > $AZ[3] AND $GPoints < $AZ[4]) {
            $UserAZ = 4;
        } elseif($GPoints > $AZ[4] AND $GPoints < $AZ[5]) {
            $UserAZ = 5;
        } elseif($GPoints > $AZ[5] AND $GPoints < $AZ[6]) {
            $UserAZ = 6;
        } elseif($GPoints > $AZ[6] AND $GPoints < $AZ[7]) {
            $UserAZ = 7;
        } elseif($GPoints > $AZ[7] AND $GPoints < $AZ[8]) {
            $UserAZ = 8;
        } elseif($GPoints > $AZ[8] AND $GPoints < $AZ[9]) {
            $UserAZ = 9;
        } elseif($GPoints > $AZ[9] AND $GPoints < $AZ[10]) {
            $UserAZ = 10;
        } elseif($GPoints > $AZ[10] AND $GPoints < $AZ[11]) {
            $UserAZ = 11;
        } elseif($GPoints > $AZ[11] AND $GPoints < $AZ[12]) {
            $UserAZ = 12;
        } elseif($GPoints > $AZ[12] AND $GPoints < $AZ[13]) {
            $UserAZ = 13;
        } elseif($GPoints > $AZ[13] AND $GPoints < $AZ[14]) {
            $UserAZ = 14;
        } elseif($GPoints > $AZ[14]){
            $UserAZ = 15;
        }
        doquery("UPDATE {{table}} SET `angriffszone` = '".$UserAZ."' WHERE `id` = '".$CurUser['id']."'", "users");
    }

    $GameUsers3  = doquery("SELECT * FROM {{table}} WHERE `volk` = 'A' AND `authlevel` = '0'" ,  'users');   // User Volk A

    while ($CurUser = mysql_fetch_assoc($GameUsers3)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '3' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

        while($o = mysql_fetch_array($OldStatRecord)) {
            $OldTotalRank = $o['total_rank'];
            $OldTechRank = $o['tech_rank'];
            $OldBuildRank = $o['build_rank'];
            $OldDefsRank = $o['defs_rank'];
            $OldFleetRank = $o['fleet_rank'];

            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '3' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        }

        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        $UsrFleets      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');

        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
        }

        while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
            $Points       = GetFleetPointsOnTour ( $CurFleet['fleet_array'] );
            $TFleetCount += $Points['FleetCount'];
            $GCount      += $Points['FleetCount'];
            $TFleetPoints+= ($Points['FleetPoint'] / 1000);
            $PlanetPoints = $Points['FleetPoint'] / 1000;
            $GPoints     += $PlanetPoints;
        }

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
        $QryInsertStats .= "`stat_type` = '3', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');
    }

    $GameUsers4  = doquery("SELECT * FROM {{table}} WHERE `volk` = 'B' AND `authlevel` = '0'" ,  'users');    // User Volk B

    while ($CurUser = mysql_fetch_assoc($GameUsers4)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '4' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

        while($o = mysql_fetch_array($OldStatRecord)) {
            $OldTotalRank = $o['total_rank'];
            $OldTechRank = $o['tech_rank'];
            $OldBuildRank = $o['build_rank'];
            $OldDefsRank = $o['defs_rank'];
            $OldFleetRank = $o['fleet_rank'];

            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '4' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        }

        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        $UsrFleets      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');

        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
        }

        while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
            $Points       = GetFleetPointsOnTour ( $CurFleet['fleet_array'] );
            $TFleetCount += $Points['FleetCount'];
            $GCount      += $Points['FleetCount'];
            $TFleetPoints+= ($Points['FleetPoint'] / $game_config['stat_settings']);
            $PlanetPoints = $Points['FleetPoint'] / $game_config['stat_settings'];
            $GPoints     += $PlanetPoints;
        }

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
        $QryInsertStats .= "`stat_type` = '4', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');
    }

    $GameUsers5  = doquery("SELECT * FROM {{table}} WHERE `volk` = 'C' AND `authlevel` = '0'" ,  'users');     // User Volk C

    while ($CurUser = mysql_fetch_assoc($GameUsers5)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '5' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

        while($o = mysql_fetch_array($OldStatRecord)) {
            $OldTotalRank = $o['total_rank'];
            $OldTechRank = $o['tech_rank'];
            $OldBuildRank = $o['build_rank'];
            $OldDefsRank = $o['defs_rank'];
            $OldFleetRank = $o['fleet_rank'];

            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '5' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        }

        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        $UsrFleets      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');

        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
        }

        while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
            $Points       = GetFleetPointsOnTour ( $CurFleet['fleet_array'] );
            $TFleetCount += $Points['FleetCount'];
            $GCount      += $Points['FleetCount'];
            $TFleetPoints+= ($Points['FleetPoint'] / 1000);
            $PlanetPoints = $Points['FleetPoint'] / 1000;
            $GPoints     += $PlanetPoints;
        }

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
        $QryInsertStats .= "`stat_type` = '5', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');
    }

    $GameUsers6  = doquery("SELECT * FROM {{table}} WHERE `authlevel` > '0'" ,  'users'); // Teammitglieder

    while ($CurUser = mysql_fetch_assoc($GameUsers6)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '6' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

        while($o = mysql_fetch_array($OldStatRecord)) {
            $OldTotalRank = $o['total_rank'];
            $OldTechRank = $o['tech_rank'];
            $OldBuildRank = $o['build_rank'];
            $OldDefsRank = $o['defs_rank'];
            $OldFleetRank = $o['fleet_rank'];

            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '6' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        }

        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        $UsrFleets      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');

        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
            $TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
            $TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
            $TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
        }

        while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
            $Points       = GetFleetPointsOnTour ( $CurFleet['fleet_array'] );
            $TFleetCount += $Points['FleetCount'];
            $GCount      += $Points['FleetCount'];
            $TFleetPoints+= ($Points['FleetPoint'] / $game_config['stat_settings']);
            $PlanetPoints = $Points['FleetPoint'] / $game_config['stat_settings'];
            $GPoints     += $PlanetPoints;
        }

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
        $QryInsertStats .= "`stat_type` = '6', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');

        if($GPoints < $AZ[1]) {
            $UserAZ = 1;
        } elseif($GPoints > $AZ[1] AND $GPoints < $AZ[2]) {
            $UserAZ = 2;
        } elseif($GPoints > $AZ[2] AND $GPoints < $AZ[3]) {
            $UserAZ = 3;
        } elseif($GPoints > $AZ[3] AND $GPoints < $AZ[4]) {
            $UserAZ = 4;
        } elseif($GPoints > $AZ[4] AND $GPoints < $AZ[5]) {
            $UserAZ = 5;
        } elseif($GPoints > $AZ[5] AND $GPoints < $AZ[6]) {
            $UserAZ = 6;
        } elseif($GPoints > $AZ[6] AND $GPoints < $AZ[7]) {
            $UserAZ = 7;
        } elseif($GPoints > $AZ[7] AND $GPoints < $AZ[8]) {
            $UserAZ = 8;
        } elseif($GPoints > $AZ[8] AND $GPoints < $AZ[9]) {
            $UserAZ = 9;
        } elseif($GPoints > $AZ[9] AND $GPoints < $AZ[10]) {
            $UserAZ = 10;
        } elseif($GPoints > $AZ[10] AND $GPoints < $AZ[11]) {
            $UserAZ = 11;
        } elseif($GPoints > $AZ[11] AND $GPoints < $AZ[12]) {
            $UserAZ = 12;
        } elseif($GPoints > $AZ[12] AND $GPoints < $AZ[13]) {
            $UserAZ = 13;
        } elseif($GPoints > $AZ[13] AND $GPoints < $AZ[14]) {
            $UserAZ = 14;
        } elseif($GPoints > $AZ[14]){
            $UserAZ = 15;
        }
        doquery("UPDATE {{table}} SET `angriffszone` = '".$UserAZ."' WHERE `id` = '".$CurUser['id']."'", "users");
    }

    $Rank           = 1;
    $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `tech_points` DESC;", 'statpoints');

    while ($TheRank = mysql_fetch_assoc($RankQry) ) {
        $QryUpdateStats  = "UPDATE {{table}} SET ";
        $QryUpdateStats .= "`tech_rank` = '". $Rank ."' ";
        $QryUpdateStats .= "WHERE ";
        $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        doquery ( $QryUpdateStats , 'statpoints');
        $Rank++;
    }

    $Rank           = 1;
    $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `build_points` DESC;", 'statpoints');

    while ($TheRank = mysql_fetch_assoc($RankQry) ) {
        $QryUpdateStats  = "UPDATE {{table}} SET ";
        $QryUpdateStats .= "`build_rank` = '". $Rank ."' ";
        $QryUpdateStats .= "WHERE ";
        $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        doquery ( $QryUpdateStats , 'statpoints');
        $Rank++;
    }

    $Rank           = 1;
    $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `defs_points` DESC;", 'statpoints');

    while ($TheRank = mysql_fetch_assoc($RankQry) ) {
        $QryUpdateStats  = "UPDATE {{table}} SET ";
        $QryUpdateStats .= "`defs_rank` = '". $Rank ."' ";
        $QryUpdateStats .= "WHERE ";
        $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        doquery ( $QryUpdateStats , 'statpoints');
        $Rank++;
    }

    $Rank           = 1;
    $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `fleet_points` DESC;", 'statpoints');

    while ($TheRank = mysql_fetch_assoc($RankQry) ) {
        $QryUpdateStats  = "UPDATE {{table}} SET ";
        $QryUpdateStats .= "`fleet_rank` = '". $Rank ."' ";
        $QryUpdateStats .= "WHERE ";
        $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        doquery ( $QryUpdateStats , 'statpoints');
        $Rank++;
    }

    $Rank           = 1;
    $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `total_points` DESC;", 'statpoints');

    while ($TheRank = mysql_fetch_assoc($RankQry) ) {
        $QryUpdateStats  = "UPDATE {{table}} SET ";
        $QryUpdateStats .= "`total_rank` = '". $Rank ."' ";
        $QryUpdateStats .= "WHERE ";
        $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        doquery ( $QryUpdateStats , 'statpoints');
        $Rank++;
    }

    $GameAllys  = doquery("SELECT * FROM {{table}}", 'alliance');     // Allianz

    while ($CurAlly = mysql_fetch_assoc($GameAllys)) {
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');

        if ($OldStatRecord) {
            $OldTotalRank = $OldStatRecord['total_rank'];
            $OldTechRank  = $OldStatRecord['tech_rank'];
            $OldBuildRank = $OldStatRecord['build_rank'];
            $OldDefsRank  = $OldStatRecord['defs_rank'];
            $OldFleetRank = $OldStatRecord['fleet_rank'];
            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
        } else {
            $OldTotalRank = 0;
            $OldTechRank  = 0;
            $OldBuildRank = 0;
            $OldDefsRank  = 0;
            $OldFleetRank = 0;
        }

        $QrySumSelect   = "SELECT ";
        $QrySumSelect  .= "SUM(`tech_points`)  as `TechPoint`, ";
        $QrySumSelect  .= "SUM(`tech_count`)   as `TechCount`, ";
        $QrySumSelect  .= "SUM(`build_points`) as `BuildPoint`, ";
        $QrySumSelect  .= "SUM(`build_count`)  as `BuildCount`, ";
        $QrySumSelect  .= "SUM(`defs_points`)  as `DefsPoint`, ";
        $QrySumSelect  .= "SUM(`defs_count`)   as `DefsCount`, ";
        $QrySumSelect  .= "SUM(`fleet_points`) as `FleetPoint`, ";
        $QrySumSelect  .= "SUM(`fleet_count`)  as `FleetCount`, ";
        $QrySumSelect  .= "SUM(`total_points`) as `TotalPoint`, ";
        $QrySumSelect  .= "SUM(`total_count`)  as `TotalCount` ";
        $QrySumSelect  .= "FROM {{table}} ";
        $QrySumSelect  .= "WHERE ";
        $QrySumSelect  .= "`stat_type` = '1' AND ";
        $QrySumSelect  .= "`id_ally` = '". $CurAlly['id'] ."';";
        $Points         = doquery( $QrySumSelect, 'statpoints', true);

        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = $Points['TechPoint'];
        $TBuildCount    = $Points['BuildCount'];
        $TBuildPoints   = $Points['BuildPoint'];
        $TDefsCount     = $Points['DefsCount'];
        $TDefsPoints    = $Points['DefsPoint'];
        $TFleetCount    = $Points['FleetCount'];
        $TFleetPoints   = $Points['FleetPoint'];
        $GCount         = $Points['TotalCount'];
        $GPoints        = $Points['TotalPoint'];

        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner` = '". $CurAlly['id'] ."', ";
        $QryInsertStats .= "`id_ally` = '0', ";
        $QryInsertStats .= "`stat_type` = '2', "; // 1 pour joueur , 2 pour alliance
        $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
        $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
        $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
        $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
        $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
        $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
        $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
        $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
        $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
        $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
        $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
        $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
        $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
        $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
        $QryInsertStats .= "`total_count` = '". $GCount ."', ";
        $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
        $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
        doquery ( $QryInsertStats , 'statpoints');
    }

    $top = doquery ("SELECT * FROM {{table}} ORDER BY `gesamtunits` DESC LIMIT 100;", 'topkb');
    $sql = "TRUNCATE TABLE {{table}}";
    doquery($sql, 'topkb');
    $sql = "OPTIMIZE TABLE {{table}}";
    doquery($sql, 'topkb');

    while($data = mysql_fetch_assoc($top)){
        $QryInsertStats  = "INSERT INTO {{table}} SET ";
        $QryInsertStats .= "`id_owner1` = '". $data['id_owner1'] ."', ";
        $QryInsertStats .= "`angreifer` = '". $data['angreifer'] ."', ";
        $QryInsertStats .= "`id_owner2` = '". $data['id_owner2'] ."', ";
        $QryInsertStats .= "`defender` = '". $data['defender'] ."', ";
        $QryInsertStats .= "`gesamtunits` = '". $data['gesamtunits'] ."', ";
        $QryInsertStats .= "`gesamttruemmer` = '". $data['gesamttruemmer'] ."', ";
        $QryInsertStats .= "`rid` = '". $data['rid'] ."', ";
        $QryInsertStats .= "`raport` = '". $data['raport'] ."', ";
        $QryInsertStats .= "`fleetresult` = '". $data['fleetresult'] ."', ";
        $QryInsertStats .= "`time` = '". $data['time'] ."'; ";
        doquery( $QryInsertStats , 'topkb');
    }


	 //Hier werden jetzt die User Gelöscht wenn der Zeitpunkt gekommen ist!!.
	 if ($user['authlevel'] <= 0 and $user['id']!= in_array ($user['id'],$pirat)){
// Muss nur Aktiviert werden wenn mit Bestätigungsmail gearbeitet wird.
 /*   
	   $Dele_Teme = time()-604800;
       $Del_Timeas = time();
       $Spr_Activate = doquery("SELECT * FROM {{table}} WHERE `time_aktyw`<'{$Del_Timeas}' AND `time_aktyw`>'0'","users");
    while ($Activater = mysql_fetch_assoc($Spr_Activate)){
        doquery("UPDATE {{table}} SET
            `db_deaktjava` = '1',
            `deleteme` = '{$Dele_Teme}'
            WHERE `id` = '{$Activater['id']}'","users");
    }

*/
//Ende Aktivierung



        $Del_TimeS = time()+86400;
        $Time_Online = time()-60*60*24*21;
        $Spr_Online = doquery("SELECT * FROM {{table}} WHERE `onlinetime`<'{$Time_Online}' AND `onlinetime`>'0' AND `urlaubs_modus`='0' AND `bana`='0'","users");
     while ($OnlineS = mysql_fetch_assoc($Spr_Online)){
        doquery("UPDATE {{table}} SET
            `db_deaktjava` = '1',
            `deltime` = '{$Del_TimeS}'
            WHERE `id` = '{$OnlineS['id']}'","users");












    }

        $Del_Time = time();
        $Spr_Del = doquery("SELECT * FROM {{table}} WHERE `deltime`<'{$Del_Time}' AND `deltime`>'0'","users");
        $User_Spra = mysql_num_rows($Spr_Del);
        $Useru_Poza = $game_config['users_amount']-$User_Spra;
    while ($Del = mysql_fetch_assoc($Spr_Del)){
        $UserID = $Del['id'];

        $TheUser = doquery ( "SELECT * FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users', true );
    if ( $TheUser['ally_id'] != 0 ) {
        $TheAlly = doquery ( "SELECT * FROM {{table}} WHERE `id` = '" . $TheUser['ally_id'] . "';", 'alliance', true );
        $TheAlly['ally_members'] -= 1;
        if ( $TheAlly['ally_members'] > 0 ) {
            doquery ( "UPDATE {{table}} SET `ally_members` = '" . $TheAlly['ally_members'] . "' WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );

        } else {
            doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
            doquery ( "DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '" . $TheAlly['id'] . "';", 'statpoints' );
        }
        }
              doquery ( "DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '" . $UserID . "';", 'statpoints' );

              $ThePlanets = doquery ( "SELECT * FROM {{table}} WHERE `id_owner` = '" . $UserID . "';", 'planets' );
        while ( $OnePlanet = mysql_fetch_assoc ( $ThePlanets ) ) {
        if ( $OnePlanet['planet_type'] == 1 ) {
            doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "' AND `system` = '" . $OnePlanet['system'] . "' AND `planet` = '" . $OnePlanet['planet'] . "';", 'galaxy' );
        }elseif ( $OnePlanet['planet_type'] == 3 ) {
            doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "' AND `system` = '" . $OnePlanet['system'] . "' AND `lunapos` = '" . $OnePlanet['planet'] . "';", 'lunas' );
        }
            doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $ThePlanets['id'] . "';", 'planets' );
        }
            doquery("DELETE FROM {{table}} WHERE message_sender = '". $UserID ."' OR message_owner = '". $UserID ."'", 'messages');
            doquery ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'notes' );
            doquery ( "DELETE FROM {{table}} WHERE `fleet_owner` = '" . $UserID . "';", 'fleets' );
            doquery("DELETE FROM {{table}} WHERE id_owner1 = '". $UserID ."' OR id_owner2 = '". $UserID ."'", 'rw');
            doquery("DELETE FROM {{table}} WHERE sender = '". $UserID ."' OR owner = '". $UserID ."'", 'buddy');
            doquery ( "DELETE FROM {{table}} WHERE `user` = '" . $UserID . "';", 'annonce' );
            doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users' );
            doquery( "UPDATE {{table}} SET `config_value`='". $Useru_Poza ."' WHERE `config_name` = 'users_amount';", 'config' );

	}
	}else{
	// Mehr als 7 Tage = Inaktiv    FIX  bearbeitet by mikey
     $Siebentage = time()-60 * 60 * 24 * 7;
     $Inaktiv_setzen = doquery("UPDATE {{table}} SET `inaktivitaet` = 1 WHERE `onlinetime` < '".$Siebentage."' LIMIT 1",'users');
     $Inaktiv_entfernen = doquery("UPDATE {{table}} SET `inaktivitaet` = 0 WHERE `onlinetime` > '".$Siebentage."' LIMIT 1",'users');
			
     }
    AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );
	
} else {
    AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>