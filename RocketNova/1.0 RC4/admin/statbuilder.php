<?php

/**
 * StatBuilder.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

include($rocketnova_root_path . 'admin/statfunctions.' . $phpEx);

	// Angriffszonen aktualisieren
	$AZ = array( 
	    1 =>      100,
		2 =>      250,
		3 =>      500,
		4 =>      750,
		5 =>     1250,
		6 =>     1800,
		7 =>     3000,
		8 =>     4500,
		9 =>     6000,
	   10 =>     8000,
	   11 =>    10000,
	   12 =>    12500,
	   13 =>    16000,
	   14 =>    20000,
	   15 =>    25000,
	   16 =>    30000,
	   17 =>    37000,
	   18 =>    45000,
	   19 =>    55000,
	   20 =>    70000,
	   21 =>    85000,
	   22 =>   100000,
	   23 =>   120000,
	   24 =>   150000,
	   25 =>   185000,
	   26 =>   225000,
	   27 =>   275000,
	   28 =>   350000,
	   29 =>   400000,
	   30 =>   500000,
	   31 =>   625000,
	   32 =>   700000,
	   33 =>   800000,
	   34 =>   900000,
	   35 =>  1000000,
	   36 =>  1150000,
	   37 =>  1250000,
	   38 =>  1400000,
	   39 =>  1600000,
	   40 =>  1850000,
	   41 =>  2000000,
	   42 =>  2500000,
	   43 =>  3000000,
	   44 =>  4200000,
	   45 =>  6500000,
	   46 =>  8500000,
	   47 => 12000000,
	   48 => 16000000,
	   49 => 20000000,
	   50 => 25000000
		);

$Query = doquery("SELECT * FROM {{table}} WHERE `stat_type` =1", 'statpoints');
$i = 0;	
while ($Stats = mysql_fetch_assoc($Query)) {
	if($Stats['total_points'] < $AZ[1]) 
	{
	$UserAZ = 1;
	}
	elseif($Stats['total_points'] > $AZ[1] AND $Stats['total_points'] < $AZ[2])
	{
	$UserAZ = 2;
	}
	elseif($Stats['total_points'] > $AZ[2] AND $Stats['total_points'] < $AZ[3])
	{
	$UserAZ = 3;
	}
	elseif($Stats['total_points'] > $AZ[3] AND $Stats['total_points'] < $AZ[4])
	{
	$UserAZ = 4;
	}
	elseif($Stats['total_points'] > $AZ[4] AND $Stats['total_points'] < $AZ[5])
	{
	$UserAZ = 5;
	}
	elseif($Stats['total_points'] > $AZ[5] AND $Stats['total_points'] < $AZ[6])
	{
	$UserAZ = 6;
	}
	elseif($Stats['total_points'] > $AZ[6] AND $Stats['total_points'] < $AZ[7])
	{
	$UserAZ = 7;
	}
	elseif($Stats['total_points'] > $AZ[7] AND $Stats['total_points'] < $AZ[8])
	{
	$UserAZ = 8;
	}
	elseif($Stats['total_points'] > $AZ[8] AND $Stats['total_points'] < $AZ[9])
	{
	$UserAZ = 9;
	}
	elseif($Stats['total_points'] > $AZ[9] AND $Stats['total_points'] < $AZ[10])
	{
	$UserAZ = 10;
	}
	elseif($Stats['total_points'] > $AZ[10] AND $Stats['total_points'] < $AZ[11])
	{
	$UserAZ = 11;
	}
	elseif($Stats['total_points'] > $AZ[11] AND $Stats['total_points'] < $AZ[12])
	{
	$UserAZ = 12;
	}
	elseif($Stats['total_points'] > $AZ[12] AND $Stats['total_points'] < $AZ[13])
	{
	$UserAZ = 13;
	}
	elseif($Stats['total_points'] > $AZ[13] AND $Stats['total_points'] < $AZ[14])
	{
	$UserAZ = 14;
	}
	elseif($Stats['total_points'] > $AZ[14] AND $Stats['total_points'] < $AZ[15])
	{
	$UserAZ = 15;
	}
	elseif($Stats['total_points'] > $AZ[15] AND $Stats['total_points'] < $AZ[16])
	{
	$UserAZ = 16;
	}
	elseif($Stats['total_points'] > $AZ[16] AND $Stats['total_points'] < $AZ[17])
	{
	$UserAZ = 17;
	}
	elseif($Stats['total_points'] > $AZ[17] AND $Stats['total_points'] < $AZ[18])
	{
	$UserAZ = 18;
	}
	elseif($Stats['total_points'] > $AZ[18] AND $Stats['total_points'] < $AZ[19])
	{
	$UserAZ = 19;
	}
	elseif($Stats['total_points'] > $AZ[19] AND $Stats['total_points'] < $AZ[20])
	{
	$UserAZ = 20;
	}
	elseif($Stats['total_points'] > $AZ[20] AND $Stats['total_points'] < $AZ[21])
	{
	$UserAZ = 21;
	}
	elseif($Stats['total_points'] > $AZ[21] AND $Stats['total_points'] < $AZ[22])
	{
	$UserAZ = 22;
	}
	elseif($Stats['total_points'] > $AZ[22] AND $Stats['total_points'] < $AZ[23])
	{
	$UserAZ = 23;
	}
	elseif($Stats['total_points'] > $AZ[23] AND $Stats['total_points'] < $AZ[24])
	{
	$UserAZ = 24;
	}
	elseif($Stats['total_points'] > $AZ[24] AND $Stats['total_points'] < $AZ[25])
	{
	$UserAZ = 25;
	}
	elseif($Stats['total_points'] > $AZ[25] AND $Stats['total_points'] < $AZ[26])
	{
	$UserAZ = 26;
	}
	elseif($Stats['total_points'] > $AZ[26] AND $Stats['total_points'] < $AZ[27])
	{
	$UserAZ = 27;
	}
	elseif($Stats['total_points'] > $AZ[27] AND $Stats['total_points'] < $AZ[28])
	{
	$UserAZ = 28;
	}
	elseif($Stats['total_points'] > $AZ[28] AND $Stats['total_points'] < $AZ[29])
	{
	$UserAZ = 29;
	}
	elseif($Stats['total_points'] > $AZ[29] AND $Stats['total_points'] < $AZ[30])
	{
	$UserAZ = 30;
	}
	elseif($Stats['total_points'] > $AZ[30] AND $Stats['total_points'] < $AZ[31])
	{
	$UserAZ = 31;
	}
	elseif($Stats['total_points'] > $AZ[31] AND $Stats['total_points'] < $AZ[32])
	{
	$UserAZ = 32;
	}
	elseif($Stats['total_points'] > $AZ[32] AND $Stats['total_points'] < $AZ[33])
	{
	$UserAZ = 33;
	}
	elseif($Stats['total_points'] > $AZ[33] AND $Stats['total_points'] < $AZ[34])
	{
	$UserAZ = 34;
	}
	elseif($Stats['total_points'] > $AZ[34] AND $Stats['total_points'] < $AZ[35])
	{
	$UserAZ = 35;
	}
	elseif($Stats['total_points'] > $AZ[35] AND $Stats['total_points'] < $AZ[36])
	{
	$UserAZ = 36;
	}
	elseif($Stats['total_points'] > $AZ[36] AND $Stats['total_points'] < $AZ[37])
	{
	$UserAZ = 37;
	}
	elseif($Stats['total_points'] > $AZ[37] AND $Stats['total_points'] < $AZ[38])
	{
	$UserAZ = 38;
	}
	elseif($Stats['total_points'] > $AZ[38] AND $Stats['total_points'] < $AZ[39])
	{
	$UserAZ = 39;
	}
	elseif($Stats['total_points'] > $AZ[39] AND $Stats['total_points'] < $AZ[40])
	{
	$UserAZ = 40;
	}
	elseif($Stats['total_points'] > $AZ[40] AND $Stats['total_points'] < $AZ[41])
	{
	$UserAZ = 41;
	}
	elseif($Stats['total_points'] > $AZ[41] AND $Stats['total_points'] < $AZ[42])
	{
	$UserAZ = 42;
	}
	elseif($Stats['total_points'] > $AZ[42] AND $Stats['total_points'] < $AZ[43])
	{
	$UserAZ = 43;
	}
	elseif($Stats['total_points'] > $AZ[43] AND $Stats['total_points'] < $AZ[44])
	{
	$UserAZ = 44;
	}
	elseif($Stats['total_points'] > $AZ[44] AND $Stats['total_points'] < $AZ[45])
	{
	$UserAZ = 45;
	}
	elseif($Stats['total_points'] > $AZ[45] AND $Stats['total_points'] < $AZ[46])
	{
	$UserAZ = 46;
	}
	elseif($Stats['total_points'] > $AZ[46] AND $Stats['total_points'] < $AZ[47])
	{
	$UserAZ = 47;
	}
	elseif($Stats['total_points'] > $AZ[47] AND $Stats['total_points'] < $AZ[48])
	{
	$UserAZ = 48;
	}
	elseif($Stats['total_points'] > $AZ[48] AND $Stats['total_points'] < $AZ[49])
	{
	$UserAZ = 49;
	}
	elseif($Stats['total_points'] > $AZ[49])
	{
	$UserAZ = 50;
	}
	doquery("UPDATE {{table}} SET `angriffszone` = '".$UserAZ."' WHERE `id` = '".$Stats['id_owner']."'", 'users');
$i++;
}

	includeLang('admin');
	
	$StatDate   = time();
	
	//Schildkuppeln groesser als 1 zuruecksetzen
    doquery ( "UPDATE {{table}} SET `small_protection_shield` = '1' WHERE `small_protection_shield` > 1;" , 'planets');
    doquery ( "UPDATE {{table}} SET `big_protection_shield` = '1' WHERE `big_protection_shield` > 1;" , 'planets');

	// x Tage bis zur löschung
	$zeit = time()-60*60*24*4;

	//Nachrichten älter als x Tage löschen
	doquery ("DELETE FROM {{table}} WHERE `message_time` < '".$zeit."';", 'messages');

	//Kampfberichte älter als x tage löschen
	doquery ("DELETE FROM {{table}} WHERE `time` < '".$zeit."';", 'rw');

	//Planeten ohne Besitzer löschen
	doquery ("DELETE FROM {{table}} WHERE `id_owner` = 0 ;", 'planets');

	//Galaxieeinträge ohne Planet löschen
	doquery ("DELETE FROM {{table}} WHERE `id_planet` = 0 ;", 'galaxy');


	$GameUsers  = doquery("SELECT * FROM {{table}} `game_users` WHERE `bana` != '1'", "users");
	
	// Rotation des statistiques
	doquery ( "DELETE FROM {{table}} WHERE `stat_code` = '2';" , 'statpoints');
	doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

	$GameUsers  = doquery("SELECT * FROM {{table}}", 'users');

	while ($CurUser = mysql_fetch_assoc($GameUsers)) {
		// Recuperation des anciennes statistiques
		$OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints', true);
		if ($OldStatRecord) {
			$OldTotalRank = $OldStatRecord['total_rank'];
			$OldTechRank  = $OldStatRecord['tech_rank'];
			$OldBuildRank = $OldStatRecord['build_rank'];
			$OldDefsRank  = $OldStatRecord['defs_rank'];
			$OldFleetRank = $OldStatRecord['fleet_rank'];
			// Suppression de l'ancien enregistrement
			doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
		} else {
			$OldTotalRank = 0;
			$OldTechRank  = 0;
			$OldBuildRank = 0;
			$OldDefsRank  = 0;
			$OldFleetRank = 0;
		}

		// Total des unitées consommée pour la recherche
		$Points         = GetTechnoPoints ( $CurUser );
		$TTechCount     = $Points['TechCount'];
		$TTechPoints    = ($Points['TechPoint'] / 2000);

		// Totalisation des points accumulés par planete
		$TBuildCount    = 0;
		$TBuildPoints   = 0;
		$TDefsCount     = 0;
		$TDefsPoints    = 0;
		$TFleetCount    = 0;
		$TFleetPoints   = 0;
		$GCount         = $TTechCount;
		$GPoints        = $TTechPoints;
		$UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
		$UsrFleets  = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $CurUser['id'] ."';", 'fleets');
		while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
			$Points           = GetBuildPoints ( $CurPlanet );
			$TBuildCount     += $Points['BuildCount'];
			$GCount          += $Points['BuildCount'];
			$PlanetPoints     = ($Points['BuildPoint'] / 2000);
			$TBuildPoints    += ($Points['BuildPoint'] / 2000);

			$Points           = GetDefensePoints ( $CurPlanet );
			$TDefsCount      += $Points['DefenseCount'];;
			$GCount          += $Points['DefenseCount'];
			$PlanetPoints    += ($Points['DefensePoint'] / 2000);
			$TDefsPoints     += ($Points['DefensePoint'] / 2000);

			$Points           = GetFleetPoints ( $CurPlanet );
			$TFleetCount     += $Points['FleetCount'];
			$GCount          += $Points['FleetCount'];
			$PlanetPoints    += ($Points['FleetPoint'] / 2000);
			$TFleetPoints    += ($Points['FleetPoint'] / 2000);

			$GPoints         += $PlanetPoints;
			while ($CurFleet = mysql_fetch_assoc($UsrFleets)) {
			$Points           = GetFlyingFleetPoints ( $CurFleet['fleet_array'] );
			$TFleetCount 	+= $Points['FleetCount'];
			$GCount      	+= $Points['FleetCount'];
			$TFleetPoints	+= ($Points['FleetPoint'] / 2000);
			$PlanetPoints	 = $Points['FleetPoint'] / 2000;

			$GPoints     	+= $PlanetPoints;
			}
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
		$OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints', true);
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

		// Total des unitées consommée pour la recherche
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
	
	$Dele_Teme = time()-604800;
$Del_Timeas = time();
$Spr_Activate = doquery("SELECT * FROM {{table}} WHERE `time_aktyw`<'{$Del_Timeas}' AND `time_aktyw`>'0'","users");
	while ($Activater = mysql_fetch_assoc($Spr_Activate)){
		doquery("UPDATE {{table}} SET
			`db_deaktjava` = '1',
			`deleteme` = '{$Dele_Teme}'
			WHERE `id` = '{$Activater['id']}'","users");
	}

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
		} elseif ( $OnePlanet['planet_type'] == 3 ) {
			doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "' AND `system` = '" . $OnePlanet['system'] . "' AND `lunapos` = '" . $OnePlanet['planet'] . "';", 'lunas' );
		}
		doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $ThePlanets['id'] . "';", 'planets' );
	}
	doquery ( "DELETE FROM {{table}} WHERE `message_sender` = '" . $UserID . "';", 'messages' );
	doquery ( "DELETE FROM {{table}} WHERE `message_owner` = '" . $UserID . "';", 'messages' );
	doquery ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'notes' );
	doquery ( "DELETE FROM {{table}} WHERE `fleet_owner` = '" . $UserID . "';", 'fleets' );
	doquery ( "DELETE FROM {{table}} WHERE `id_owner1` = '" . $UserID . "';", 'rw' );
	doquery ( "DELETE FROM {{table}} WHERE `id_owner2` = '" . $UserID . "';", 'rw' );
	doquery ( "DELETE FROM {{table}} WHERE `sender` = '" . $UserID . "';", 'buddy' );
	doquery ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'buddy' );
	doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users' );
	doquery ( "UPDATE {{table}} SET `config_value`='". $Useru_Poza ."' WHERE `config_name` = 'users_amount';", 'config' );

}

	AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );
//KB Datenbank aufbereiten
 $top = doquery ("SELECT * FROM {{table}} ORDER BY `gesamtunits` DESC LIMIT 100;", 'topkb');
 $sql = "TRUNCATE TABLE {{table}}";
doquery($sql, 'topkb');
 $sql = "OPTIMIZE TABLE {{table}}";
doquery($sql, 'topkb');
while($data = mysql_fetch_assoc($top))
{
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
// Ende KB Datenbank aufbereiten
?>
