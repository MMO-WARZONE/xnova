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

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

include(XNOVA_ROOT_PATH . 'pages/admin/statfunctions.php');
include(XNOVA_ROOT_PATH . 'pages/admin/az.php');


includeLang('admin');

$StatDate   = time();

if ($user['authlevel'] >= 2) 
{

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
	$select_old_a_ranks	=	"s.id_owner , s.stat_type, s.tech_rank AS old_tech_rank,
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
	AdminMessage ( $lang['adm_done'], $lang['adm_stat_title'] );
} 
?>