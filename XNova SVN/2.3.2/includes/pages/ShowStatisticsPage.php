<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowStatisticsPage($CurrentUser)
{
	global $db,$lang, $dpath,$svn_root,$displays;
	
	$displays->assignContent("/stat/stat");
	
	$displays->newBlock("stat");
	
	$who   	= (isset($_POST['who']))   ? $_POST['who']   : $_GET['who'];
	if (!isset($who)){
		$who   = 1;
	}

	$type  	= (isset($_POST['type']))  ? $_POST['type']  : $_GET['type'];
	if (!isset($type)){
		$type  = 1;
	}

	$range 	= (isset($_POST['range'])) ? $_POST['range'] : $_GET['range'];
	if (!isset($range)){
		$range = 1;
	}

	$parse['who']    = "<option value=\"1\"". (($who == "1") ? " SELECTED" : "") .">".$lang['st_player']."</option>";
	$parse['who']   .= "<option value=\"2\"". (($who == "2") ? " SELECTED" : "") .">".$lang['st_alliance']."</option>";

	$parse['type']   = "<option value=\"1\"". (($type == "1") ? " SELECTED" : "") .">".$lang['st_points']."</option>";
	$parse['type']  .= "<option value=\"2\"". (($type == "2") ? " SELECTED" : "") .">".$lang['st_fleets']."</option>";
	$parse['type']  .= "<option value=\"3\"". (($type == "3") ? " SELECTED" : "") .">".$lang['st_researh']."</option>";
	$parse['type']  .= "<option value=\"4\"". (($type == "4") ? " SELECTED" : "") .">".$lang['st_buildings']."</option>";
	$parse['type']  .= "<option value=\"5\"". (($type == "5") ? " SELECTED" : "") .">".$lang['st_defenses']."</option>";
	foreach($parse as $name => $trans){
                $displays->assign($name, $trans);
        }
	unset($parse);
	switch ($type)
	{
		case 1:
			$Order   = "s.total_points";
			$Points  = "total_points";
			$Counts  = "total_count";
			$Rank    = "total_rank";
			$OldRank = "total_old_rank";
		break;
		case 2:
			$Order   = "s.fleet_points";
			$Points  = "fleet_points";
			$Counts  = "fleet_count";
			$Rank    = "fleet_rank";
			$OldRank = "fleet_old_rank";
		break;
		case 3:
			$Order   = "s.tech_points";
			$Points  = "tech_points";
			$Counts  = "tech_count";
			$Rank    = "tech_rank";
			$OldRank = "tech_old_rank";
		break;
		case 4:
			$Order   = "s.build_points";
			$Points  = "build_points";
			$Counts  = "build_count";
			$Rank    = "build_rank";
			$OldRank = "build_old_rank";
		break;
		case 5:
			$Order   = "s.defs_points";
			$Points  = "defs_points";
			$Counts  = "defs_count";
			$Rank    = "defs_rank";
			$OldRank = "defs_old_rank";
		break;
		default:
			$Order   = "s.total_points";
			$Points  = "total_points";
			$Counts  = "total_count";
			$Rank    = "total_rank";
			$OldRank = "total_old_rank";
		break;
	}
	
	if ($who == 2)
	{
		$MaxAllys = $db->query ("SELECT COUNT(*) AS `count` FROM {{table}};", 'alliance', true);

		if ($MaxAllys['count'] > 100)
		{
			$LastPage = floor($MaxAllys['count'] / 100);
		}

		$alliance['range'] = "";

		for ($Page = 0; $Page <= $LastPage; $Page++)
		{
			$PageValue      = ($Page * 100) + 1;
			$PageRange      = $PageValue + 99;
			$alliance['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
		}
		
		
		$start = floor($range / 100 % 100) * 100;
		$stats_sql ='SELECT s.*, a.id, a.ally_members, a.ally_tag, a.ally_name
		FROM {{table}}alliance as a
		LEFT JOIN {{table}}statpoints as s ON a.id = s.id_owner AND s.stat_type = 2 AND s.stat_code = 1
		GROUP BY s.id_owner ORDER BY '. $Order .' DESC LIMIT '. $start .',100;';

		$start++;
		$alliance['stat_date']   = date("Y-m-d, H:i:s",$db->game_config['stat_last_update']);
		$alliance['stat_values'] = "";
		$query = $db->query($stats_sql, '');
		
		
		foreach($alliance as $name => $trans){
                        $displays->assign($name, $trans);
                }
		
		unset($alliance);
		$displays->newBlock("alliance");
		while ($StatRow = mysql_fetch_assoc($query))
		{
                    
			$displays->newBlock("alliancelist");
			$allystat['ally_rank']       = $start;
			if ( $StatRow[ $OldRank ] == 0 || $StatRow[ $Rank ] == 0)
			{
				$rank_old		= $start;
				$QryUpdRank		= $db->query("UPDATE {{table}} SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
				$StatRow[ $OldRank ]	= $start;
				$StatRow[ $Rank ]	= $start;
			}
			
			$ranking                  = $StatRow[ $OldRank ] - $StatRow[ $Rank ];
			
			if ($ranking == 0)
			{
				$allystat['ally_rankplus']   = "<font color=#87CEEB>*</font>";
			}
			
			if ($ranking < 0)
			{
				$allystat['ally_rankplus']   = "<font color=red>-".$ranking."</font>";
			}
			
			if ($ranking > 0)
			{
				$allystat['ally_rankplus']   = "<font color=green>+".$ranking."</font>";
			}
			
			$allystat['ally_tag']        	  = $StatRow['ally_tag'];
			$allystat['ally_name']       	  = $StatRow['ally_name'];
			$allystat['ally_mes']        	  = '';
			$allystat['ally_members']    	  = $StatRow['ally_members'];
			$allystat['ally_points']     	  = pretty_number( $StatRow[ $Points ] );
			$allystat['ally_members_points'] 	  =  pretty_number( floor($StatRow[ $Points ] / $StatRow['ally_members']) );
			
			$start++;
			foreach($allystat as $name => $trans){
				$displays->assign($name, $trans);
			}
			unset($allystat,$StatRow);
		}
	}
	else
	{
		
		$MaxUsers = $db->query ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0';", 'users', true);
		if ($MaxUsers['count'] > 100)
		{
			$LastPage = floor($MaxUsers['count'] / 100);
		}

		$parse['range'] = "";

		for ($Page = 0; $Page <= $LastPage; $Page++)
		{
			$select="";
			$PageValue      = ($Page * 100) + 1;
			$PageRange      = $PageValue + 99;
			
			if($PageValue<=$range && $range<=$PageRange){
				$select="SELECTED";
			}
			$parse['range'] .= "<option value=\"". $PageValue ."\"". $select .">". $PageValue ."-". $PageRange ."</option>";
		}
		$start = ceil(floor($range / 100 % 100) * 100);

		$stats_sql= 'SELECT s.*, u.id, u.username, u.ally_id, u.ally_name
		FROM {{table}}users as u
		LEFT JOIN {{table}}statpoints as s ON u.id=s.id_owner AND s.stat_type = 1 AND s.stat_code = 1
		GROUP BY s.id_owner ORDER BY '. $Order .' DESC LIMIT '. $start .',100;';
		$query = $db->query($stats_sql, '');

                $start++;

		$parse['stat_date']   = date("Y-m-d, H:i:s",$db->game_config['stat_last_update']);
		$parse['stat_values'] = "";
		
		foreach($parse as $name => $trans){
                        $displays->assign($name, $trans);
                }
		unset($parse);
                
		$displays->newBlock("users");
		while ($StatRow = mysql_fetch_assoc($query))
		{
			$displays->newBlock("userslist");
			
			$usersstat['player_rank']     = $start;
			if ( $StatRow[ $OldRank ] == 0 || $StatRow[ $Rank ] == 0)
			{
				$rank_old		= $start;
				$QryUpdRank		= $db->query("UPDATE {{table}} SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
				$StatRow[ $OldRank ]	= $start;
				$StatRow[ $Rank ]	= $start;
			}
			$ranking = $StatRow[ $OldRank ] - $StatRow[ $Rank ];

			if ($ranking == 0)
			{
				$usersstat['player_rankplus'] = "<font color=#87CEEB>*</font>";
			}

			if ($ranking < 0){
				$usersstat['player_rankplus'] = "<font color=red>".$ranking."</font>";
			}

			if ($ranking > 0){
				$usersstat['player_rankplus'] = "<font color=green>+".$ranking."</font>";
			}

			if ($StatRow['id'] == $CurrentUser['id']){
				$usersstat['player_name']     = "<font color=\"lime\">".$StatRow['username']."</font>";
			}else{
				$usersstat['player_name']     = $StatRow['username'];
			}

			if ($StatRow['id'] != $CurrentUser['id']){
				//$usersstat['player_mes']      = "<a href=\"game.php?page=messages&mode=write&id=" . $StatRow['id'] . "\"><img src=\"" . $dpath . "img/m.gif\" border=\"0\" title=\"Escribir un mensaje\" /></a>";
				$usersstat['player_mes']      = "<a href=\"#\" onclick=\"new_mensaje('".$StatRow['username']."','".$StatRow['id']."','Sin Asunto','')\"><img src=\"" . $dpath . "img/m.gif\" border=\"0\" title=\"Escribir un mensaje\" /></a>";
                        }else{
				$usersstat['player_mes']      = "";
                        }
			if ($UsrRow['ally_name'] == $CurrentUser['ally_name'])
			{
				$usersstat['player_alliance'] = "<a href=\"game.php?page=alliance&mode=ainfo&a=".$StatRow['ally_id']."\"><font color=\"#33CCFF\">".$StatRow['ally_name']."</font></a>";
			}
			else
			{
				$usersstat['player_alliance'] = "<a href=\"game.php?page=alliance&mode=ainfo&a=".$StatRow['ally_id']."\">".$StatRow['ally_name']."</a>";
			}
			$usersstat['player_points']   = pretty_number( $StatRow[ $Points ] );
			foreach($usersstat as $name => $trans){
				$displays->assign($name, $trans);
			}
			unset($usersstat,$StatRow);
			$start++;
		}
	}

	$displays->display($page);
}
?>