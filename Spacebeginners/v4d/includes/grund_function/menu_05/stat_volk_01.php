<?php

includeLang('menu_05/stat');

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

$parse['who']    = "<option value=\"1\"". (($who == "1") ? " SELECTED" : "") ."> ". $lang['stat']['9006'] ."</option>";
$parse['who']   .= "<option value=\"2\"". (($who == "2") ? " SELECTED" : "") ."> ". $lang['stat']['9007'] ."</option>";
$parse['who']   .= "<option value=\"3\"". (($who == "3") ? " SELECTED" : "") ."> ". $lang['stat']['9008'] ."</option>";
$parse['type']   = "<option value=\"1\"". (($type == "1") ? " SELECTED" : "") .">". $lang['stat']['9001'] ."</option>";
$parse['type']  .= "<option value=\"3\"". (($type == "3") ? " SELECTED" : "") .">". $lang['stat']['9002'] ."</option>";
$parse['type']  .= "<option value=\"4\"". (($type == "4") ? " SELECTED" : "") .">". $lang['stat']['9003'] ."</option>";

if ($type == 1) {
    $Order   = "total_points";
    $Points  = "total_points";
    $Counts  = "total_count";
    $Rank    = "total_rank";
    $OldRank = "total_old_rank";
} elseif ($type == 2) {
    $Order   = "fleet_points";
    $Points  = "fleet_points";
    $Counts  = "fleet_count";
    $Rank    = "fleet_rank";
    $OldRank = "fleet_old_rank";
} elseif ($type == 3) {
    $Order   = "build_points";
    $Points  = "build_points";
    $Counts  = "build_count";
    $Rank    = "build_rank";
    $OldRank = "build_old_rank";
} elseif ($type == 4) {
    $Order   = "tech_points";
    $Points  = "tech_points";
    $Counts  = "tech_count";
    $Rank    = "tech_rank";
    $OldRank = "tech_old_rank";
} elseif ($type == 5) {
    $Order   = "defs_points";
    $Points  = "defs_points";
    $Counts  = "defs_count";
    $Rank    = "defs_rank";
    $OldRank = "defs_old_rank";
}

if ($who == 2) {
    $MaxAllys = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE 1;", 'alliance', true);

    if ($MaxAllys['count'] > 100) {
        $LastPage = floor($MaxAllys['count'] / 100);
    }

    $dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    $parse['dpath'] = $dpath;
    $parse['info_03'] = "<img src='./styl/image/stat/allianz.png' style='height:70px; width:197px;' alt=''>";  

    $parse['range'] = "";
    for ($Page = 0; $Page <= $LastPage; $Page++) {
        $PageValue      = ($Page * 100) + 1;
        $PageRange      = $PageValue + 99;
        $parse['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
    }

    $parse['stat_header'] = parsetemplate(gettemplate('stat/stat_alli_01'), $parse);
    $start = floor($range / 100 % 100) * 100;
    $query = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `stat_code` = '1' ORDER BY `". $Order ."` DESC LIMIT ". $start .",100;", 'statpoints');

    $start++;
    $parse['stat_date']   = $game_config['stats'];
    $parse['stat_values'] = "";

    while ($StatRow = mysql_fetch_assoc($query)) {
        $parse['stat_date']       = date("d M Y - H:i:s", $StatRow['stat_date']);
        $parse['ally_rank']       = $start;
        $AllyRow                  = doquery("SELECT * FROM {{table}} WHERE `id` = '". $StatRow['id_owner'] ."';", 'alliance',true);
        $rank_old                 = $StatRow[ $OldRank ];

        if ($rank_old == 0) {
            $rank_old             = $start;
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '2' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        } else {
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."' WHERE `stat_type` = '2' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        }

        $rank_new                 = $start;
        $ranking                  = $rank_old - $rank_new;

        if ($ranking == "0") {
            $parse['ally_rankplus'] = "".$lang['stat']['0004']."";
            $parse['color_anf'] = "<a href='alliance.php?mode=ainfo&amp;tag=".$AllyRow['ally_tag']."' target='_self'><font color='#FFFFFF'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking < "0") {
            $parse['ally_rankplus'] = "".$lang['stat']['0005']." ".$ranking." ".$lang['stat']['0006']."";
            $parse['color_anf'] = "<a href='alliance.php?mode=ainfo&amp;tag=".$AllyRow['ally_tag']."' target='_self'><font color='#FF0000'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking > "0") {
            $parse['ally_rankplus'] = "".$lang['stat']['0005']." +".$ranking." ".$lang['stat']['0007']."";
            $parse['color_anf'] = "<a href='alliance.php?mode=ainfo&amp;tag=".$AllyRow['ally_tag']."' target='_self'><font color='#0000FF'>";
            $parse['color_end'] = "</font></a>";
        }

        $parse['info_01'] = "".$lang['stat']['0001']."";
        $parse['info_02'] = "".$lang['stat']['0002']."";

        $parse['ally_tag']        = $AllyRow['ally_tag'];
        $parse['ally_name']       = $AllyRow['ally_name'];
        $parse['ally_mes']        = '';
        $parse['ally_members']    = $AllyRow['ally_members'];
        $parse['ally_points']     = pretty_number( $StatRow[ $Order ] );
        $parse['ally_members_points'] =  pretty_number( floor($StatRow[ $Order ] / $AllyRow['ally_members']) );

        $parse['stat_values']    .= parsetemplate(gettemplate('stat/stat_alli_02'), $parse);
        $start++;
    }

} elseif ($who == 3) {
    $MaxUsers = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0';", 'users', true);

    $dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    $parse['dpath'] = $dpath;
    $parse['info_03'] = "<img src='./styl/image/stat/gesamt.png' style='height:70px; width:197px;' alt=''>";

    if ($MaxUsers['count'] > 100) {
        $LastPage = floor($MaxUsers['count'] / 100);
    }

    $parse['range'] = "";
    for ($Page = 0; $Page <= $LastPage; $Page++) {
        $PageValue      = ($Page * 100) + 1;
        $PageRange      = $PageValue + 99;
        $parse['range'] .= "<option value=\"". $PageValue ."\"". (($start == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
    }

    $parse['stat_header'] = parsetemplate(gettemplate('stat/stat_volk_02'), $parse);
    $start = floor($range / 100 % 100) * 100;
    $query = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `". $Order ."` DESC LIMIT ". $start .",100;", 'statpoints');

    $start++;
    $parse['stat_date']   = $game_config['stats'];
    $parse['stat_values'] = "";

    while ($StatRow = mysql_fetch_assoc($query)) {
        $parse['stat_date']       = date("d M Y - H:i:s", $StatRow['stat_date']);
        $parse['player_rank']     = $start;
        $UsrRow                   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $StatRow['id_owner'] ."';", 'users',true);

        $QryUpdateStats .= "`stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        $rank_old                 = $StatRow[ $OldRank ];

        if ( $rank_old == 0) {
            $rank_old             = $start;
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        } else {
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."' WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        }

        $rank_new                 = $start;
        $ranking                  = $rank_old - $rank_new;

        if ($ranking == "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0004']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#FFFFFF'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking < "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0005']." ".$ranking." ".$lang['stat']['0006']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#FF0000'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking > "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0005']." +".$ranking." ".$lang['stat']['0007']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#0000FF'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($UsrRow['id'] == $user['id']) {
            $parse['player_name'] = "<font color=\"#00DF00\">".$UsrRow['username']."</font>";
        } else {
            $parse['player_name'] = "".$UsrRow['username']."";
        }

        if ($UsrRow['id'] == $user['id']) {
            $parse['player_angriffszone'] = "<font color=\"#00DF00\">".$UsrRow['angriffszone']."</font>";
        } else {
            $parse['player_angriffszone'] = $UsrRow['angriffszone'];
        }

        if ($UsrRow['ally_name'] == $user['ally_name']) {
            $parse['player_alliance'] = "".$user['ally_name']."";
        } else {
            $parse['player_alliance'] = "".$lang['stat']['0003']."";
        }

        $parse['info_01'] = "".$lang['stat']['0001_05']."";
        $parse['info_02'] = "".$lang['stat']['0002']."";


        $parse['player_points'] = pretty_number( $StatRow[ $Order ] );
        $parse['stat_values']  .= parsetemplate(gettemplate('stat/stat_volk_03'), $parse);
        $start++;
    }

} else {
    $MaxUsers = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0';", 'users', true);

    $dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    $parse['dpath'] = $dpath;
    $parse['info_03'] = "<img src='./styl/image/stat/zyraten.png' style='height:70px; width:197px;' alt=''>";

    if ($MaxUsers['count'] > 100) {
        $LastPage = floor($MaxUsers['count'] / 100);
    }

    $parse['range'] = "";
    for ($Page = 0; $Page <= $LastPage; $Page++) {
        $PageValue      = ($Page * 100) + 1;
        $PageRange      = $PageValue + 99;
        $parse['range'] .= "<option value=\"". $PageValue ."\"". (($start == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
    }

    $parse['stat_header'] = parsetemplate(gettemplate('stat/stat_volk_02'), $parse);
    $start = floor($range / 100 % 100) * 100;
    $query = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '3' AND `stat_code` = '1' ORDER BY `". $Order ."` DESC LIMIT ". $start .",100;", 'statpoints');

    $start++;
    $parse['stat_date']   = $game_config['stats'];
    $parse['stat_values'] = "";

    while ($StatRow = mysql_fetch_assoc($query)) {
        $parse['stat_date']       = date("d M Y - H:i:s", $StatRow['stat_date']);
        $parse['player_rank']     = $start;
        $UsrRow                   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $StatRow['id_owner'] ."';", 'users',true);

        $QryUpdateStats .= "`stat_type` = '3' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
        $rank_old                 = $StatRow[ $OldRank ];

        if ( $rank_old == 0) {
            $rank_old             = $start;
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."', `".$OldRank."` = '".$start."' WHERE `stat_type` = '3' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        } else {
            $QryUpdRank           = doquery("UPDATE {{table}} SET `".$Rank."` = '".$start."' WHERE `stat_type` = '3' AND `stat_code` = '1' AND `id_owner` = '". $StatRow['id_owner'] ."';" , "statpoints");
        }

        $rank_new                 = $start;
        $ranking                  = $rank_old - $rank_new;

        if ($ranking == "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0004']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#FFFFFF'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking < "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0005']." ".$ranking." ".$lang['stat']['0006']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#FF0000'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($ranking > "0") {
            $parse['player_rankplus'] = "".$lang['stat']['0005']." +".$ranking." ".$lang['stat']['0007']."";
            $parse['color_anf'] = "<a href='messages.php?mode=write&amp;id=". $UsrRow['id'] ."'><font color='#0000FF'>";
            $parse['color_end'] = "</font></a>";
        }

        if ($UsrRow['id'] == $user['id']) {
            $parse['player_name'] = "<font color=\"#00DF00\">".$UsrRow['username']."</font>";
        } else {
            $parse['player_name'] = "".$UsrRow['username']."";
        }

        if ($UsrRow['id'] == $user['id']) {
            $parse['player_angriffszone'] = "<font color=\"#00DF00\">".$UsrRow['angriffszone']."</font>";
        } else {
            $parse['player_angriffszone'] = $UsrRow['angriffszone'];
        }

        if ($UsrRow['ally_name'] == $user['ally_name']) {
            $parse['player_alliance'] = "".$user['ally_name']."";
        } else {
            $parse['player_alliance'] = "".$lang['stat']['0003']."";
        }

        $parse['info_01'] = "".$lang['stat']['0001_01']."";
        $parse['info_02'] = "".$lang['stat']['0002']."";


        $parse['player_points'] = pretty_number( $StatRow[ $Order ] );
        $parse['stat_values']  .= parsetemplate(gettemplate('stat/stat_volk_03'), $parse);
        $start++;
    }
}

$page = parsetemplate( gettemplate('stat/stat_volk_01'), $parse );
display($page, $lang['Stat']);

?>