<?php

/**
 * actualisation.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
if($user['username'] == '') header('Location: login.php');


    includeLang('actualisation');

    $StatDate   = time();
    // Rotation des statistiques
    doquery ( "DELETE FROM {{table}} WHERE `stat_code` = '2';" , 'statpoints');
    doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

    $GameUsers  = doquery("SELECT * FROM {{table}}", 'users');

    while ($CurUser = mysql_fetch_assoc($GameUsers)) {
        // Recuperation des anciennes statistiques
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
        while($o = mysql_fetch_array($OldStatRecord)) {
$OldTotalRank = $o['total_rank'];
$OldTechRank = $o['tech_rank'];
$OldBuildRank = $o['build_rank'];
$OldDefsRank = $o['defs_rank'];
$OldFleetRank = $o['fleet_rank'];
// Suppression de l'ancien enregistrement
doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
} 

        // Total des unit&eacute;es consomm&eacute;e pour la recherche
        $Points         = GetTechnoPoints ( $CurUser );
        $TTechCount     = $Points['TechCount'];
        $TTechPoints    = ($Points['TechPoint'] / 1000);

        // Totalisation des points accumul&eacute;s par planete
        $TBuildCount    = 0;
        $TBuildPoints   = 0;
        $TDefsCount     = 0;
        $TDefsPoints    = 0;
        $TFleetCount    = 0;
        $TFleetPoints   = 0;
        $GCount         = $TTechCount;
        $GPoints        = $TTechPoints;
        $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
        while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
            $Points           = GetBuildPoints ( $CurPlanet );
            $TBuildCount     += $Points['BuildCount'];
            $GCount          += $Points['BuildCount'];
            $PlanetPoints     = ($Points['BuildPoint'] / 1000);
            $TBuildPoints    += ($Points['BuildPoint'] / 1000);

            $Points           = GetDefensePoints ( $CurPlanet );
            $TDefsCount      += $Points['DefenseCount'];;
            $GCount          += $Points['DefenseCount'];
            $PlanetPoints    += ($Points['DefensePoint'] / 1000);
            $TDefsPoints     += ($Points['DefensePoint'] / 1000);

            $Points           = GetFleetPoints ( $CurPlanet );
            $TFleetCount     += $Points['FleetCount'];
            $GCount          += $Points['FleetCount'];
            $PlanetPoints    += ($Points['FleetPoint'] / 1000);
            $TFleetPoints    += ($Points['FleetPoint'] / 1000);

            $GPoints         += $PlanetPoints;
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
            doquery ( $QryUpdatePlanet , 'planets');
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

    // Statistiques des alliances ...
    $GameAllys  = doquery("SELECT * FROM {{table}}", 'alliance');

    while ($CurAlly = mysql_fetch_assoc($GameAllys)) {
        // Recuperation des anciennes statistiques
        $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
        if ($OldStatRecord) {
            $OldTotalRank = $OldStatRecord['total_rank'];
            $OldTechRank  = $OldStatRecord['tech_rank'];
            $OldBuildRank = $OldStatRecord['build_rank'];
            $OldDefsRank  = $OldStatRecord['defs_rank'];
            $OldFleetRank = $OldStatRecord['fleet_rank'];
            // Suppression de l'ancien enregistrement
            doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
        } else {
            $OldTotalRank = 0;
            $OldTechRank  = 0;
            $OldBuildRank = 0;
            $OldDefsRank  = 0;
            $OldFleetRank = 0;
        }

        // Total des unit&eacute;es consomm&eacute;e pour la recherche
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
    message($lang['actualiser'], $lang['Please_Wait'], 'stat.'.$phpEx, "3");
    AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );

    function GetTechnoPoints ( $CurrentUser ) {
    global $resource, $pricelist, $reslist;

    $TechCounts = 0;
    $TechPoints = 0;
    foreach ( $reslist['tech'] as $n => $Techno ) {
        if ( $CurrentUser[ $resource[ $Techno ] ] > 0 ) {
            for ( $Level = 1; $Level < $CurrentUser[ $resource[ $Techno ] ]; $Level++ ) {
                $Units       = $pricelist[ $Techno ]['metal'] + $pricelist[ $Techno ]['crystal'] + $pricelist[ $Techno ]['deuterium'];
                $LevelMul    = pow( $pricelist[ $Techno ]['factor'], $Level );
                $TechPoints += ($Units * $LevelMul);
                $TechCounts += 1;
            }
        }
    }
    $RetValue['TechCount'] = $TechCounts;
    $RetValue['TechPoint'] = $TechPoints;

    return $RetValue;
}

function GetBuildPoints ( $CurrentPlanet ) {
    global $resource, $pricelist, $reslist;

    $BuildCounts = 0;
    $BuildPoints = 0;
    foreach($reslist['build'] as $n => $Building) {
        if ( $CurrentPlanet[ $resource[ $Building ] ] > 0 ) {
            for ( $Level = 1; $Level < $CurrentPlanet[ $resource[ $Building ] ]; $Level++ ) {
                $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'];
                $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                $BuildPoints += ($Units * $LevelMul);
                $BuildCounts += 1;
            }
        }
    }
    $RetValue['BuildCount'] = $BuildCounts;
    $RetValue['BuildPoint'] = $BuildPoints;

    return $RetValue;
}

function GetDefensePoints ( $CurrentPlanet ) {
    global $resource, $pricelist, $reslist;

    $DefenseCounts = 0;
    $DefensePoints = 0;
    foreach($reslist['defense'] as $n => $Defense) {
        if ($CurrentPlanet[ $resource[ $Defense ] ] > 0) {
            $Units          = $pricelist[ $Defense ]['metal'] + $pricelist[ $Defense ]['crystal'] + $pricelist[ $Defense ]['deuterium'];
            $DefensePoints += ($Units * $CurrentPlanet[ $resource[ $Defense ] ]);
            $DefenseCounts += $CurrentPlanet[ $resource[ $Defense ] ];
        }
    }
    $RetValue['DefenseCount'] = $DefenseCounts;
    $RetValue['DefensePoint'] = $DefensePoints;

    return $RetValue;
}

function GetFleetPoints ( $CurrentPlanet ) {
    global $resource, $pricelist, $reslist;

    $FleetCounts = 0;
    $FleetPoints = 0;
    foreach($reslist['fleet'] as $n => $Fleet) {
        if ($CurrentPlanet[ $resource[ $Fleet ] ] > 0) {
            $Units          = $pricelist[ $Fleet ]['metal'] + $pricelist[ $Fleet ]['crystal'] + $pricelist[ $Fleet ]['deuterium'];
            $FleetPoints   += ($Units * $CurrentPlanet[ $resource[ $Fleet ] ]);
            $FleetCounts   += $CurrentPlanet[ $resource[ $Fleet ] ];
        }
    }
    $RetValue['FleetCount'] = $FleetCounts;
    $RetValue['FleetPoint'] = $FleetPoints;

    return $RetValue;
}

?>