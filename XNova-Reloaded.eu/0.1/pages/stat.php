<?php

/**
 * stat.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

$avataranzeige = 5;
	includeLang('stat');

	$parse = $lang;
	$who   = (isset($_POST['who']))   ? $_POST['who']   : $_GET['who'];
	if (!isset($who)) {
		$who   = 1;
	}
	$type  = (isset($_POST['type']))  ? $_POST['type']  : $_GET['type'];
	if (!isset($type)) {
		$type  = 1;
	}
	$range = (isset($_POST['range'])) ? $_POST['range'] : $_GET['range'];
	if (!isset($range)) {
		$range = 1;
	}

	$parse['who']    = "<option value=\"1\"". (($who == "1") ? " SELECTED" : "") .">". $lang['stat_player'] ."</option>";
	$parse['who']   .= "<option value=\"2\"". (($who == "2") ? " SELECTED" : "") .">". $lang['stat_allys']  ."</option>";

	$parse['type']   = "<option value=\"1\"". (($type == "1") ? " SELECTED" : "") .">". $lang['stat_main']     ."</option>";
	$parse['type']  .= "<option value=\"2\"". (($type == "2") ? " SELECTED" : "") .">". $lang['stat_fleet']    ."</option>";
	$parse['type']  .= "<option value=\"3\"". (($type == "3") ? " SELECTED" : "") .">". $lang['stat_research'] ."</option>";
	$parse['type']  .= "<option value=\"4\"". (($type == "4") ? " SELECTED" : "") .">". $lang['stat_building'] ."</option>";
	$parse['type']  .= "<option value=\"5\"". (($type == "5") ? " SELECTED" : "") .">". $lang['stat_defenses'] ."</option>";

	if       ($type == 1) {
		$Order   = "total_count";
		$Points  = "total_points";
		$Counts  = "total_count";
		$Rank    = "total_rank";
		$OldRank = "total_old_rank";
	} elseif ($type == 2) {
		$Order   = "fleet_count";
		$Points  = "fleet_points";
		$Counts  = "fleet_count";
		$Rank    = "fleet_rank";
		$OldRank = "fleet_old_rank";
	} elseif ($type == 3) {
		$Order   = "tech_count";
		$Points  = "tech_points";
		$Counts  = "tech_count";
		$Rank    = "tech_rank";
		$OldRank = "tech_old_rank";
	} elseif ($type == 4) {
		$Order   = "build_count";
		$Points  = "build_points";
		$Counts  = "build_count";
		$Rank    = "build_rank";
		$OldRank = "build_old_rank";
	} elseif ($type == 5) {
		$Order   = "defs_count";
		$Points  = "defs_points";
		$Counts  = "defs_count";
		$Rank    = "defs_rank";
		$OldRank = "defs_old_rank";
	}

	if ($who == 2) {
		$Query = $DB->query("SELECT `id` FROM `".PREFIX."alliance`");
		$MaxAllys = sql_num_rows($Query);
		
		if ($MaxAllys['count'] > 100) {
			$LastPage = floor($MaxAllys['count'] / 100);
		}
		$parse['range'] = "";
		for ($Page = 0; $Page <= $LastPage; $Page++) {
			$PageValue      = ($Page * 100) + 1;
			$PageRange      = $PageValue + 99;
			$parse['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
		}

		$parse['stat_header'] = parsetemplate(gettemplate('stat_alliancetable_header'), $parse);

		$start = floor($range / 100 % 100) * 100;
		
		$parse['stat_date']   = $game_config['stats'];
		$parse['stat_values'] = "";
        
		foreach($DB->query("SELECT * FROM `".PREFIX."statpoints` WHERE `stat_type` = '2' AND `stat_code` = '1' ORDER BY `". $Points ."` DESC LIMIT ". $start .",100") as $StatRow) {
			
			$start++;
			$parse['stat_date']       = date("d M Y - H:i:s", $StatRow['stat_date']);
			$parse['ally_rank']       = $start;

			$Query                    = $DB->query("SELECT * FROM `".PREFIX."alliance` WHERE `id` = '". $StatRow['id_owner'] ."'");
            $AllyRow                  = $Query->fetch();
			
			
			
			
			$rank_old                 = $StatRow[ $OldRank ];
			if ( $rank_old == 0) {
				$rank_old             = $start;
				$DB->query("UPDATE `".PREFIX."statpoints` SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '2' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."'");
			} else {
				$DB->query("UPDATE `".PREFIX."statpoints` SET `".$Rank."` = '".$start."' WHERE `stat_type` = '2' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."'");
			}
			$rank_new                 = $start;
			$ranking                  = $rank_old - $rank_new;
			if ($ranking == "0") {
				$parse['ally_rankplus']   = "";
			}
			if ($ranking < "0") {
				$parse['ally_rankplus']   = "<font color=\"red\">".$ranking."</font>";
			}
			if ($ranking > "0") {
				$parse['ally_rankplus']   = "<font color=\"green\">+".$ranking."</font>";
			}
			
			$counti= $parse['ally_rank'];
            if ($counti <= $avataranzeige)
			{
                $parse['allianz_logo']   = $AllyRow['ally_image'];
                $ally_image = $parse['allianz_logo'];
                if ($ally_image) 
					$parse['allianz_logo'] = "<th height=\"85\" width=\"85\"><img src='$ally_image' width='80' height='80' alt='$AllyRow[ally_name]'></th>";
				else
					$parse['allianz_logo'] = "<th height=\"85\" width=\"85\">".$AllyRow['ally_name']."</th>";
				
            }
            else {
                $parse['allianz_logo'] = "<th width=\"85\"><b>-</b></th>";
                    }
                $parse['id']      = $AllyRow['id'];
			
			$parse['ally_tag']        = $AllyRow['ally_tag'];
			$parse['ally_name']       = $AllyRow['ally_name'];
			$parse['ally_mes']        = '';
			$parse['ally_members']    = $AllyRow['ally_members'];
			$parse['ally_points']     = pretty_number( $StatRow[ $Points ] );
			$parse['ally_members_points'] =  pretty_number( floor($StatRow[ $Points ] / $AllyRow['ally_members']) );

			$parse['stat_values']    .= parsetemplate(gettemplate('stat_alliancetable'), $parse);
			
		}
	} else {
		$Query    = $DB->query ("SELECT `id` FROM `".PREFIX."users`");
		$MaxUsers['count'] = sql_num_rows($Query);
		
		if ($MaxUsers['count'] > 100) {
			$LastPage = floor($MaxUsers['count'] / 100);
		}
		$parse['range'] = "";
		for ($Page = 0; $Page <= $LastPage; $Page++) {
			$PageValue      = ($Page * 100) + 1;
			$PageRange      = $PageValue + 99;
			$parse['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
		}

		$parse['stat_header'] = parsetemplate(gettemplate('stat_playertable_header'), $parse);

		$start = floor($range / 100 % 100) * 100;
		
		$parse['stat_date']   = $game_config['stats'];
		$parse['stat_values'] = "";

		foreach($DB->query("SELECT * FROM `".PREFIX."statpoints` WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `". $Points ."` DESC LIMIT ". $start .",100") as $StatRow) {
            
			$start++;
			$parse['stat_date']       = date("d M Y - H:i:s", $StatRow['stat_date']);
			$parse['player_rank']     = $start;

			$Query                    = $DB->query("SELECT * FROM `".PREFIX."users` WHERE `id` = '". $StatRow['id_owner'] ."'");
			$UsrRow                   = $Query->fetch();



			$rank_old                 = $StatRow[ $OldRank ];
			if ( $rank_old == 0) {
				$rank_old             = $start;
				$DB->query("UPDATE `".PREFIX."statpoints` SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."'");
			} else {
				$DB->query("UPDATE `".PREFIX."statpoints` SET `".$Rank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."'");
			}
			$rank_new                 = $start;
			$ranking                  = $rank_old - $rank_new;
			if ($ranking == "0") {
				$parse['player_rankplus'] = "";
			}
			if ($ranking < "0") {
				$parse['player_rankplus'] = "<font color=\"red\">".$ranking."</font>";
			}
			if ($ranking > "0") {
				$parse['player_rankplus'] = "<font color=\"green\">+".$ranking."</font>";
			}
		
        if ($start <= $avataranzeige) {
            $parse['avatar'] = $UsrRow['avatar'];
            $useravatar = $parse['avatar'];
            if (!$useravatar) $useravatar = "images/noavatar.jpg";
            $parse['player_avatar'] = "<img src='$useravatar' width='80' height='80'>";
        }
        else {
            $parse['player_avatar'] = "<b>-</b>";
             }
			if ($UsrRow['id'] == $user['id']) {
				$parse['player_name']     = "<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=" . $UsrRow['id'] . "', '');\"><font color=\"lime\">".$UsrRow['username']."</font></a>";
			} else {
				$parse['player_name']     = "<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=" . $UsrRow['id'] . "', '');\">".$UsrRow['username']."</a>";
			}
			$parse['player_mes']      = "<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=" . $UsrRow['id'] . "', '');\"><img src=\"" . $dpath . "img/m.gif\" border=\"0\" alt=\"". $lang['Ecrire'] ."\"></a>";
			$tag = $DB->query ("SELECT `ally_tag` FROM `".PREFIX."alliance` WHERE `ally_name` = '". $UsrRow['ally_name'] ."'");
			$tag = $tag->fetch();
			
			if ($UsrRow['ally_name'] == $user['ally_name']) {
				$parse['player_alliance'] = "<a href=\"?action=internalAlliance&amp;mode=ainfo&amp;tag=".$tag['ally_tag']."\"><font color=\"#33CCFF\">".$tag['ally_tag']."</font></a>";
			} elseif ($tag['ally_tag']) {
				$parse['player_alliance'] = "<a href=\"?action=internalAlliance&amp;mode=ainfo&amp;tag=".$tag['ally_tag']."\">".$tag['ally_tag']."</a>";
			}
			else {
				$parse['player_alliance'] = "-";
				}
			$parse['player_points']   = pretty_number( $StatRow[ $Points ] );
			$parse['stat_values']    .= parsetemplate(gettemplate('stat_playertable'), $parse);
		}
	}

	display(parsetemplate(gettemplate('stat_body'), $parse), $lang['stat_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture module
?>