<?php
/**
 * @author angelus_ira - angelus_ira@hotmail.com
 * @package XnovaDuo www.multinova.co.cc
 * @version 0.3
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Based on StatBuilder.php by Chlorel for XNova copyright 2008 
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

if ($user['authlevel'] >= 2) 
{
	// tiempo
	$mtime        = microtime();
	$mtime        = explode(" ", $mtime);
	$mtime        = $mtime[1] + $mtime[0];
	$starttime    = $mtime;
	//Change the last stats time
	$stats_time   = time();
	// löscht alte Nachrichten
	$del_before = time() - (14 * 24 * 60 * 60);
	doquery ("DELETE FROM {{table}} WHERE `message_time` < '". $del_before ."' ;", 'messages');
	doquery ("DELETE FROM {{table}} WHERE `time` < '". $del_before ."' ;", 'rw');
	doquery ("DELETE FROM {{table}} WHERE `id_owner` = '0' ;", 'planets');
	doquery ("DELETE FROM {{table}} WHERE `id_planet` = '0' ;", 'galaxy');

	$select_defenses	=	'';
	foreach($reslist['defense'] as $n => $Defense) 
	{
		if ($resource[ $Defense ] != 'small_protection_shield' && $resource[ $Defense ] != 'big_protection_shield') 
		{
			$select_defenses	.= " SUM(p.".$resource[ $Defense ].") AS ".$resource[ $Defense ].",";
		}
	}
	$select_buildings	=	'';
	foreach($reslist['build'] as $n => $Building) 
	{
		$select_buildings	.= " p.".$resource[ $Building ].",";
	}
	$selected_tech	=	'';
	foreach($reslist['tech'] as $n => $Techno) 
	{
			$selected_tech	.= " u.".$resource[ $Techno ].",";
	}
	$select_fleets	=	'';
	foreach($reslist['fleet'] as $n => $Fleet) 
	{
			$select_fleets	.= " SUM(p.".$resource[ $Fleet ].") AS ".$resource[ $Fleet ].",";
	}
	//If you have some data type enmu is better if you put it here, because that data give a error in the SUM function.
	$selected_enum	=	"p.small_protection_shield, p.big_protection_shield";//For now...
	$select_planet		= "p.id_owner";
	//For Stats table..
	$select_old_ranks	= "id_owner, stat_type,tech_rank AS old_tech_rank, build_rank AS old_build_rank, defs_rank AS old_defs_rank, fleet_rank AS old_fleet_rank, total_rank AS old_total_rank";
	//For users table
	$select_user		= " u.id, u.username, u.ally_id, u.authlevel ";
	$sql	=	"SELECT  $select_planet, $select_defenses $selected_tech $select_fleets $select_user  
				FROM {{table}}planets as p 
				INNER JOIN {{table}}users as u ON u.id = p.id_owner
				GROUP BY p.id_owner, u.id, u.username, u.authlevel;";
	$total_data	=	doquery ($sql,'');
	$sql_parcial = "SELECT $select_buildings $select_planet, $selected_enum, id FROM {{table}}planets as p ORDER BY id_owner ASC;";
	$parcial_data	= doquery($sql_parcial, '');
	//We delete now the old stats of the users
	$sql_old_stats	=	"SELECT $select_old_ranks FROM {{table}} WHERE stat_type = 1 AND stat_code = 1";
	$old_stats		=	 doquery($sql_old_stats, 'statpoints');
	//We take the data of flying fleets
	$sql_flying_fleets	=	"SELECT fleet_array, fleet_owner, fleet_id FROM {{table}}";
	$flying_fleets		=	doquery($sql_flying_fleets, 'fleets');
	//Here we make the array with the planets buildings array and the user id and planet id for use in the next step...
	while ($CurPlanet = mysql_fetch_assoc($parcial_data)) 
	{
		$Buildings_array[$CurPlanet['id_owner']][$CurPlanet['id']]	=	$CurPlanet;
		
	}
	unset($CurPlanet, $parcial_data);
	while ($CurStats = mysql_fetch_assoc($old_stats)) 
	{
		$old_stats_array[$CurStats['id_owner']]	=	$CurStats;
		
	}
	while ($CurFleets = mysql_fetch_assoc($flying_fleets)) 
	{
		$flying_fleets_array[$CurFleets['fleet_owner']][$CurFleets['fleet_id']]	=	$CurFleets['fleet_array'];
		
	}
	unset($CurStats, $old_stats, $flying_fleets);
	doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1';",'statpoints');
	while ($CurUser = mysql_fetch_assoc($total_data)) 
	{
		$OldTotalRank = (($old_stats_array[$CurUser['id']]['old_total_rank'])? $old_stats_array[$CurUser['id']]['old_total_rank']:0);
		$OldTechRank  = (($old_stats_array[$CurUser['id']]['old_tech_rank'])? $old_stats_array[$CurUser['id']]['old_tech_rank']:0);
		$OldBuildRank = (($old_stats_array[$CurUser['id']]['old_build_rank'])? $old_stats_array[$CurUser['id']]['old_build_rank']:0);
		$OldDefsRank  = (($old_stats_array[$CurUser['id']]['old_defs_rank'])? $old_stats_array[$CurUser['id']]['old_defs_rank']:0);
		$OldFleetRank = (($old_stats_array[$CurUser['id']]['old_fleet_rank'])? $old_stats_array[$CurUser['id']]['old_fleet_rank']:0);

		$Points			= GetTechnoPoints ( $CurUser );
		$TTechCount		= $Points['TechCount'];
		$TTechPoints	= ($Points['TechPoint'] / 1000);
		$Points			= GetDefensePoints ( $CurUser );
		$TDefsCount		= $Points['DefenseCount'];
		$TDefsPoints	= ($Points['DefensePoint'] / 1000);
		$Points			= GetFleetPoints ( $CurUser );
		$TFleetCount	= $Points['FleetCount'];
		$TFleetPoints	= ($Points['FleetPoint'] / 1000);
		if($flying_fleets_array[$CurUser['id']])
		{
			foreach($flying_fleets_array[$CurUser['id']] as $fleet_id => $fleet_array)
			{
				print_r($fleet_array);
				$Points			= GetFlyingFleetPoints ( $fleet_array );
				$TFleetCount  	+= $Points['FleetCount'];
				$TFleetPoints 	+= ($Points['FleetPoint'] / 1000);
			}
		}
		$TBuildCount    = 0;
		$TBuildPoints   = 0;
		foreach($Buildings_array[$CurUser['id']] as $planet_id => $building)
		{
			$Points				= GetBuildPoints ( $building );
			$TBuildCount		+= $Points['BuildCount'];
			$TBuildPoints		+= ($Points['BuildPoint'] / 1000);
			$Points				= GetDefensePoints ( $building );
			$TDefsCount			+= $Points['DefenseCount'];
			$TDefsPoints		+= ($Points['DefensePoint'] / 1000);
			
		}
		$GCount			= $TDefsCount  + $TTechCount  + $TFleetCount  + $TBuildCount;
		$GPoints		= $TTechPoints + $TDefsPoints + $TFleetPoints + $TBuildPoints;
		
		if (($CurUser['authlevel'] >= $game_config['stat_level']&& $game_config['stat']==1 ) || $CurUser['bana']==1) 
		{
			$TTechPoints="0";
			$TTechCount="0";
			$OldTechRank="0";
			$TBuildPoints="0";
			$TBuildCount="0";
			$OldBuildRank="0";
			$TDefsPoints="0";
			$TDefsCount="0";
			$OldDefsRank="0";
			$TFleetPoints="0";
			$TFleetCount="0";
			$OldFleetRank="0";
			$GPoints="0";
			$GCount="0";
			$OldTotalRank="0";
		}
		$QryInsertStats  = "INSERT INTO {{table}} SET ";
		$QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
		$QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
		$QryInsertStats .= "`stat_type` = '1', "; 
		$QryInsertStats .= "`stat_code` = '1', ";
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

	unset($insert_user_query, $total_data, $CurUser, $old_stats_array, $Buildings_array, $flying_fleets_array);

	doquery("DELETE FROM {{table}} WHERE ally_members='0'", "alliance");
	$ally_check  = doquery("SELECT * FROM {{table}}", 'alliance');
	while ($CurAlly = mysql_fetch_assoc($ally_check)) 
	{
		$ally_check_value[$CurAlly['id']]=1;
	}
	unset($ally_check);
	$select_old_a_ranks	=	"s.id_owner , s.stat_type,	s.tech_rank AS old_tech_rank, 
							s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, 
							s.total_rank AS old_total_rank";

	$select_ally		= " a.id ";
	
	$sql_ally	=	"SELECT  $select_ally, $select_old_a_ranks 
					FROM {{table}}alliance AS a 
					INNER JOIN {{table}}statpoints AS s ON a.id = s.id_owner AND s.stat_type = 2;";
	$ally_data	=	doquery ($sql_ally,'');
	
	$ally_sql_points	="SELECT 
						s.stat_type, s.id_ally, Sum(s.tech_points) AS TechPoint,
						Sum(s.tech_count) AS TechCount, Sum(s.build_points) AS BuildPoint,
						Sum(s.build_count) AS BuildCount, Sum(s.defs_points) AS DefsPoint,
						Sum(s.defs_count) AS DefsCount, Sum(s.fleet_points) AS FleetPoint,
						Sum(s.fleet_count) AS FleetCount, Sum(s.total_points) AS TotalPoint,
						Sum(s.total_count) AS TotalCount
						FROM
						{{table}}statpoints AS s 
						WHERE	s.stat_type =  '1' AND s.id_ally > 0
						GROUP BY	s.id_ally;";
	$ally_points	=	doquery ($ally_sql_points,'');
	doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2';",'statpoints');
	while ($CurAlly = mysql_fetch_assoc($ally_data)) 
	{
		$ally_old_data[$CurAlly['id']]=$CurAlly;
	}
	unset($$CurAlly, $ally_data);
	while ($CurAlly = mysql_fetch_assoc($ally_points)) 
	{
		if ($ally_check_value[$CurAlly['id_ally']] == 1)
		{
			$OldTotalRank = (($ally_old_data[$CurAlly['id_ally']]['old_total_rank'])? $ally_old_data[$CurAlly['id_ally']]['old_total_rank']:0);
			$OldTechRank  = (($ally_old_data[$CurAlly['id_ally']]['old_tech_rank'])? $ally_old_data[$CurAlly['id_ally']]['old_tech_rank']:0);
			$OldBuildRank = (($ally_old_data[$CurAlly['id_ally']]['old_build_rank'])? $ally_old_data[$CurAlly['id_ally']]['old_build_rank']:0);
			$OldDefsRank  = (($ally_old_data[$CurAlly['id_ally']]['old_defs_rank'])? $ally_old_data[$CurAlly['id_ally']]['old_defs_rank']:0);
			$OldFleetRank = (($ally_old_data[$CurAlly['id_ally']]['old_fleet_rank'])? $ally_old_data[$CurAlly['id_ally']]['old_fleet_rank']:0);
			$TTechCount     = $CurAlly['TechCount'];
			$TTechPoints    = $CurAlly['TechPoint'];
			$TBuildCount    = $CurAlly['BuildCount'];
			$TBuildPoints   = $CurAlly['BuildPoint'];
			$TDefsCount     = $CurAlly['DefsCount'];
			$TDefsPoints    = $CurAlly['DefsPoint'];
			$TFleetCount    = $CurAlly['FleetCount'];
			$TFleetPoints   = $CurAlly['FleetPoint'];
			$GCount         = $CurAlly['TotalCount'];
			$GPoints        = $CurAlly['TotalPoint'];
		
			$QryInsertStats  = "INSERT INTO {{table}} SET ";
			$QryInsertStats .= "`id_owner` = '". $CurAlly['id_ally'] ."', ";
			$QryInsertStats .= "`id_ally` = '0', ";
			$QryInsertStats .= "`stat_type` = '2', ";
			$QryInsertStats .= "`stat_code` = '1', "; 
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
		else
		{
			doquery ( "UPDATE {{table}}	SET `ally_id`=0, `ally_name` = '', 	`ally_register_time`= 0, `ally_rank_id`= 0 	WHERE `ally_id`='{$CurAlly['id_ally']}'", "users");
		}
	}

	unset($insert_ally_query, $ally_old_data, $CurAlly, $ally_points);
	$mtime        = microtime();
	$mtime        = explode(" ", $mtime);
	$mtime        = $mtime[1] + $mtime[0];
	$endtime      = $mtime;
	$totaltime    = ($endtime - $starttime);
	print_r("Ausgef&uuml;hrt in<br>".$totaltime." Sekunden");
	AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );
} 
else 
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
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