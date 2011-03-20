<?php

/**
  * overview.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('resources');
includeLang('menu_01/ubersicht');

$lunarow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '" . $planetrow['id_owner'] . "' AND `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `lunapos` = '" . $planetrow['planet'] . "';", 'lunas', true);

CheckPlanetUsedFields ($lunarow);

$mode = $_GET['mode'];
$pl = mysql_escape_string($_GET['pl']);
$_POST['deleteid'] = intval($_POST['deleteid']);

if ($game_config['enable_bot'] == 1){
    $multi           = $user['multi_validated'];
    $ip              = $user['user_lastip'];
    $time            = time();
    $duree           = $time + (stripslashes($game_config['ban_duration']) * 86400);
    $op              = stripslashes($game_config['bot_name']);
    $mail            = stripslashes($game_config['bot_adress']);
    $sql             = mysql_query("SELECT * FROM game_users WHERE `user_lastip`='{$ip}'");
    $boucle          = 0;
    $username        ='';
    $v               =',&nbsp;';

    while($m = mysql_fetch_array($sql)){
        $username .= $m['username'] . $v;
        $boucle ++;
    }

    if ($boucle > 1 && $multi == 0){
        $ip = $user['user_lastip'];
        $sql = mysql_query("SELECT * FROM game_users WHERE `user_lastip`='{$ip}'");
        while($b = mysql_fetch_array($sql)){
            $QryBanMulti = "INSERT INTO {{table}} SET ";
            $QryBanMulti .= "`who` = '" . mysql_escape_string(strip_tags($user['username'])) . "', ";
            $QryBanMulti .= "`who2` = '" . mysql_escape_string(strip_tags($user['username'])) . "', ";
            $QryBanMulti .= "`theme` = 'Multi-Compte entre " . mysql_escape_string($username) . "', ";
            $QryBanMulti .= "`time` = '" . $time . "', ";
            $QryBanMulti .= "`longer` = '" . $duree . "', ";
            $QryBanMulti .= "`author` = '" . $op . "', ";
            $QryBanMulti .= "`email`='" . $mail . "';";
            doquery($QryBanMulti, 'banned');
            doquery("UPDATE {{table}} SET bana=1 WHERE username='{$user['username']}'","users");
            doquery("UPDATE {{table}} SET banaday='{$duree}' WHERE username='{$user['username']}'","users");
        }
    }
} else {}

switch ($mode) {
    case 'renameplanet':

    if ($_POST['action'] == $lang['over_2009']) {
        $UserPlanet = addslashes(CheckInputStrings ($_POST['newname']));

        if (ctype_alnum($UserPlanet)) {
            $newname = mysql_escape_string(trim($UserPlanet));

            if ($newname != "") {
                $planetrow['name'] = $newname;
                doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $user['current_planet'] . "' LIMIT 1;", "planets");

                if ($planetrow['planet_type'] == 3) {
                    doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `lunapos` = '" . $planetrow['planet'] . "' LIMIT 1;", "lunas");
                }
            }
        } else {
            message($lang['no_number'] , $lang['error'], 'overview.php?mode=renameplanet');
        }

    } elseif ($_POST['action'] == $lang['over_2008']) {
        $parse = $lang;
        $parse['dpath'] = $dpath;
        $parse['planet_id'] = $planetrow['id'];
        $parse['galaxy_galaxy'] = $planetrow['galaxy'];
        $parse['galaxy_system'] = $planetrow['system'];
        $parse['galaxy_planet'] = $planetrow['planet'];
        $parse['planet_name'] = $planetrow['name'];

        $page .= parsetemplate(gettemplate('ubersicht/ubersicht_04'), $parse);
        display($page, $lang['rename_and_abandon_planet']);
    } elseif ($_POST['kolonieloeschen'] == 1 && $_POST['deleteid'] == $user['current_planet']) {

        if (md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet']) {
            include_once($xnova_root_path . 'includes/functions/AbandonColony.' . $phpEx);

            if (CheckFleets($planetrow)){
                $strMessage = $lang['over_3004']; message($strMessage, $lang['over_2008'], 'overview.php?mode=renameplanet',3);
            }

            AbandonColony($user,$planetrow);

            $QryUpdatePlanet = "DELETE FROM {{table}} ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id` = '".$user['current_planet']."' LIMIT 1;";
            doquery( $QryUpdatePlanet , 'planets');

            $QryUpdatePlanet2 = "DELETE FROM {{table}} ";
            $QryUpdatePlanet2 .= "WHERE ";
            $QryUpdatePlanet2 .= "`id_planet` = '".$user['current_planet']."' LIMIT 1;";
            doquery( $QryUpdatePlanet2 , 'galaxy');

            $QryUpdateUser = "UPDATE {{table}} SET ";
            $QryUpdateUser .= "`current_planet` = `id_planet` ";
            $QryUpdateUser .= "WHERE ";
            $QryUpdateUser .= "`id` = '" . $user['id'] . "' LIMIT 1";
            doquery($QryUpdateUser, "users");

            message($lang['over_3001'] , $lang['over_2008'], 'overview.php',3);
        } elseif ($user['id_planet'] == $user["current_planet"]) {
            message($lang['over_3002'], $lang['over_2008'], 'overview.php?mode=renameplanet');
        } else {
            message($lang['over_3003'] , $lang['over_2008'], 'overview.php?mode=renameplanet');
        }
    }

    $parse = $lang;
    $parse['dpath'] = $dpath;
    $parse['planet_id'] = $planetrow['id'];
    $parse['galaxy_galaxy'] = $planetrow['galaxy'];
    $parse['galaxy_system'] = $planetrow['system'];
    $parse['galaxy_planet'] = $planetrow['planet'];
    $parse['planet_name'] = $planetrow['name'];

    $page .= parsetemplate(gettemplate('ubersicht/ubersicht_03'), $parse);
    display($page, $lang['rename_and_abandon_planet']);

    break;
    default:

    if ($user['id'] != '') {
        $XpMinierUp = $user['lvl_minier'] * 5000;
        $XpRaidUp = $user['lvl_raid'] * 100;
        $XpMinier = $user['xpminier'];
        $XPRaid = $user['xpraid'];
        $LvlUpMinier = $user['lvl_minier'] + 1;
        $LvlUpRaid = $user['lvl_raid'] + 1;

        if (($LvlUpMinier + $LvlUpRaid) <= 100) {

            if ($XpMinier >= $XpMinierUp) {
                $QryUpdateUser = "UPDATE {{table}} SET ";
                $QryUpdateUser .= "`lvl_minier` = '" . $LvlUpMinier . "', ";
                $QryUpdateUser .= "`rpg_points` = `rpg_points` + 1 ";
                $QryUpdateUser .= "WHERE ";
                $QryUpdateUser .= "`id` = '" . $user['id'] . "';";
                doquery($QryUpdateUser, 'users');

                $HaveNewLevelMineur  = "" . $lang['over']['0100'] . "";
                $HaveNewLevelMineur2 = "<table style='width:10px'>
                                          <tr><td align='left'><a href=\"javascript:animatedcollapse.toggle('new0006')\" title='".$lang['over_0017']."'><img src='./styl/image/overview/Miener.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
                                      </table>";

           }

            if ($XPRaid >= $XpRaidUp) {
                $QryUpdateUser = "UPDATE {{table}} SET ";
                $QryUpdateUser .= "`lvl_raid` = '" . $LvlUpRaid . "', ";
                $QryUpdateUser .= "`rpg_points` = `rpg_points` + 1 ";
                $QryUpdateUser .= "WHERE ";
                $QryUpdateUser .= "`id` = '" . $user['id'] . "';";
                doquery($QryUpdateUser, 'users');

                $HaveNewLevelRaid  = "" . $lang['over']['0101'] . "";
                $HaveNewLevelRaid2 = "<table style='width:10px'>
                                          <tr><td align='left'><a href=\"javascript:animatedcollapse.toggle('new0005')\" title='".$lang['over_0018']."'><img src='./styl/image/overview/Raid.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
                                      </table>";

            }
        }

        $OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $user['id'] . "';", 'fleets');

        $Record = 0;
        while ($FleetRow = mysql_fetch_array($OwnFleets)){
            $Record++;

            $StartTime = $FleetRow['fleet_start_time'];
            $StayTime  = $FleetRow['fleet_end_stay'];
            $EndTime   = $FleetRow['fleet_end_time'];

            $hedefgalaksi = $FleetRow['fleet_end_galaxy'];
            $hedefsistem = $FleetRow['fleet_end_system'];
            $hedefgezegen = $FleetRow['fleet_end_planet'];
            $mess = $FleetRow['fleet_mess'];
            $filogrubu = $FleetRow['fleet_group'];

            $Label = "fs";

            if ($StartTime > time()){
                $fpage[$StartTime] = BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
            }

            if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10)){
                $Label = "ft";

                if ($StayTime > time()){
                    $fpage[$StayTime] = BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
                }
                $Label = "fe";

                if ($EndTime > time()){
                    $fpage[$EndTime] = BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
                }
            }
        }
        mysql_free_result($OwnFleets);

        $dostfilo = doquery("SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '" . $hedefgalaksi . "' AND `fleet_end_system` = '" . $hedefsistem . "' AND `fleet_end_planet` = '" . $hedefgezegen . "' AND `fleet_group` = '" . $filogrubu . "';", 'fleets');
        $Record1 = 0;
        while ($FleetRow = mysql_fetch_array($dostfilo)) {
            $StartTime = $FleetRow['fleet_start_time'];
            $StayTime = $FleetRow['fleet_end_stay'];
            $EndTime = $FleetRow['fleet_end_time'];

            $hedefgalaksi = $FleetRow['fleet_end_galaxy'];
            $hedefsistem = $FleetRow['fleet_end_system'];
            $hedefgezegen = $FleetRow['fleet_end_planet'];
            $mess = $FleetRow['fleet_mess'];
            $filogrubu = $FleetRow['fleet_group'];

            if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $user['id'])) {
                $Record1++;

                if($mess > 0){
                    $StartTime = "";
                }else{
                    $StartTime = $FleetRow['fleet_start_time'];
                }

                if ($StartTime > time()) {
                    $Label = "ofs";
                    $fpage[$StartTime] = BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1);
                }
            }

            if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $user['id']) && ($filogrubu > 0 ) ){
                $Record++;

                if($mess > 0){
                    $StartTime = "";
                }else{
                    $StartTime = $FleetRow['fleet_start_time'];
                }

                if ($StartTime > time()) {
                    $Label = "ofs";
                    $fpage[$StartTime] =  BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
                }
            }
        }
        mysql_free_result($dostfilo);

        $OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $user['id'] . "';", 'fleets');
        $Record = 2000;

        while ($FleetRow = mysql_fetch_array($OtherFleets)){

            if ($FleetRow['fleet_owner'] != $user['id']){

                if ($FleetRow['fleet_mission'] != 8){
                    $Record++;
                    $StartTime = $FleetRow['fleet_start_time'];
                    $StayTime = $FleetRow['fleet_end_stay'];

                    if ($StartTime > time()){
                        $Label = "ofs";
                        $fpage[$StartTime] = BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
                    }

                    if ($FleetRow['fleet_mission'] == 5){
                        $Label = "oft";

                        if ($StayTime > time()){
                           $fpage[$StayTime] = BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
                        }
                    }
                }
            }
        }
        mysql_free_result($OtherFleets);
        $Order = ($user['planet_sort_order'] == 1) ? "DESC" : "ASC" ;
        $Sort = $user['planet_sort'];
        $QryPlanets = "SELECT * FROM {{table}} WHERE `id_owner` = '" . $user['id'] . "' ORDER BY ";

        if ($Sort == 0) {
            $QryPlanets .= "`id` " . $Order;
        } elseif ($Sort == 1) {
            $QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` " . $Order;
        } elseif ($Sort == 2) {
            $QryPlanets .= "`name` " . $Order;
        }

        $planets_query = doquery ($QryPlanets, 'planets');
        $Colone = 1;

        $AllPlanets = "<tr>";
        while ($UserPlanet = mysql_fetch_array($planets_query)) {
            PlanetResourceUpdate ($user, $UserPlanet, time());

            if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
                $AllPlanets .= "<td  align='right'>";
                $AllPlanets .= "<a href='?cp=" . $UserPlanet['id'] . "&amp;re=0' title='" . $UserPlanet['name'] . "'><img src='" . $dpath . "planeten/small_planet/s_" . $UserPlanet['image'] . ".gif' style='width:50px; height:50px'alt=''></a><br>";
                $AllPlanets .= "</td>";

                if ($Colone <= 0) {
                    $Colone++;
                } else {
                    $AllPlanets .= "</tr><tr>";
                    $Colone = 1;
                }
            }
        }

        $iraks_query = doquery("SELECT * FROM {{table}} WHERE owner = '" . $user['id'] . "'", 'iraks');
        $Record = 4000;
        while ($irak = mysql_fetch_array ($iraks_query)) {
            $Record++;
            $fpage[$irak['zeit']] = '';

            if ($irak['zeit'] > time()) {
                $time = $irak['zeit'] - time();
                $fpage[$irak['zeit']] .= InsertJavaScriptChronoApplet ("fm", $Record, $time, true);
                $planet_start = doquery("SELECT * FROM {{table}} WHERE
                galaxy = '" . $irak['galaxy'] . "' AND
                system = '" . $irak['system'] . "' AND
                planet = '" . $irak['planet'] . "' AND
                planet_type = '1'", 'planets');

                $user_planet = doquery("SELECT * FROM {{table}} WHERE
                galaxy = '" . $irak['galaxy_angreifer'] . "' AND
                system = '" . $irak['system_angreifer'] . "' AND
                planet = '" . $irak['planet_angreifer'] . "' AND
                planet_type = '1'", 'planets', true);

                if (mysql_num_rows($planet_start) == 1) {
                    $planet = mysql_fetch_array($planet_start);
                }



                $fpage[$irak['zeit']] .= "<table style='width:100%' cellspacing='0' cellpadding='0' border='0' >
                                              <tr><td style='width:12%;font-size:80%;' class='sb'>-</td>
                                                  <td style='width:13%; font-size:80%; color:#00FF00;' class='sb'>".date("H:i:s", $irak['zeit'])."</td>
                                                  <td style='width:75%; font-size:80%;' class='sb'> Ein Raketenangriff(".$irak['anzahl'].") von ".$user_planet['name']."";
                $fpage[$irak['zeit']] .= '<a href="galaxy.php?mode=3&amp;galaxy='.$irak["galaxy_angreifer"].'&amp;system='.$irak["system_angreifer"].'&amp;planet='.$irak["planet_angreifer"].'">[' . $irak["galaxy_angreifer"] . ':' . $irak["system_angreifer"] . ':' . $irak["planet_angreifer"] . ']</a>';
                $fpage[$irak['zeit']] .= 'wird auf Planet' . $planet["name"] . ' ';
                $fpage[$irak['zeit']] .= '<a href="galaxy.php?mode=3&amp;galaxy='.$irak["galaxy"].'&amp;system='.$irak["system"].'&amp;planet='.$irak["planet"].'">['.$irak["galaxy"] . ':' . $irak["system"] . ':' . $irak["planet"] . ']</a>';
                $fpage[$irak['zeit']] .= InsertJavaScriptChronoApplet ("fm", $Record, $time, false);
                $fpage[$irak['zeit']] .= "</td></tr></table>";
            }
        }

        $parse = $lang;

        if ($game_config['OverviewNewsFrame'] == '1') {
            $parse['NewsFrame']  = "". stripslashes($game_config['OverviewNewsText']) . "";
            $parse['NewsFrame2'] = "<table style='width:10px'>
                                        <tr><td align='left'><a href=\"javascript:animatedcollapse.toggle('new0004')\" title='".$lang['over_0015']."'><img src='./styl/image/overview/News_01.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
                                    </table>";
        } else {
            $parse['NewsFrame']  = "".$lang['over_0016']."";
            $parse['NewsFrame2'] = "<table style='width:10px'>
                                        <tr><td align='left'><a href=\"javascript:animatedcollapse.toggle('new0004')\" title='".$lang['over_0016']."'><img src='./styl/image/overview/News_02.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
                                    </table>";
        }

        if ($game_config['OverviewExternChat'] == '1') {
            $parse['ExternalTchatFrame'] = "<table><tr><td style='font-size:90%'>" . stripslashes($game_config['OverviewExternChatCmd']) . "</td></tr></table>";
        }

        if ($game_config['OverviewClickBanner'] != '') {
            $parse['ClickBanner'] = stripslashes($game_config['OverviewClickBanner']);
        }

        if ($game_config['ForumBannerFrame'] == '1') {
            $BannerURL = "".dirname($_SERVER["HTTP_REFERER"])."/includes/createbanner.php?id=".$user['id']."";
            $parse['bannerframe'] = "<img src=\"includes/createbanner.php?id=".$user['id']."\" alt=\"\">";
        }

        if ($lunarow['id'] <> 0) {

            if ($planetrow['planet_type'] == 1) {
                $lune = doquery ("SELECT * FROM {{table}} WHERE `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `planet` = '" . $planetrow['planet'] . "' AND `planet_type` = '3'", 'planets', true);
                $parse['moon_img'] = "<a href='?cp=" . $lune['id'] . "&amp;re=0' title='" . $lune['name'] . "'><img src='" . $dpath . "planeten/" . $lune['image'] . ".gif' style='height:70px; width:70px' alt='mond.gif'/></a>";
                $parse['moon'] = $lune['name'];
            } else {
                $parse['moon_img'] = "";
                $parse['moon'] = "";
            }
        } else {
            $parse['moon_img'] = "";
            $parse['moon'] = "";
        }

        $parse['planet_name']                = $planetrow['name'];
        $parse['planet_diameter']            = pretty_number($planetrow['diameter']);
        $parse['planet_field_current']       = $planetrow['field_current'];
        $parse['planet_field_max']           = CalculateMaxPlanetFields($planetrow);
        $parse['planet_temp_min']            = $planetrow['temp_min'];
        $parse['planet_temp_max']            = $planetrow['temp_max'];
        $parse['galaxy_galaxy']              = $planetrow['galaxy'];
        $parse['galaxy_planet']              = $planetrow['planet'];
        $parse['galaxy_system']              = $planetrow['system'];
        $StatRecord  = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $user['id'] . "';", 'statpoints', true);
        $MaxUsers    = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0';", 'users',true);

        $parse['user_points']         = pretty_number($StatRecord['build_points']);
        $parse['user_fleet']          = pretty_number($StatRecord['fleet_points']);
        $parse['user_def']            = pretty_number( $StatRecord['defs_points'] );
        $parse['player_points_tech']  = pretty_number($StatRecord['tech_points']);
        $parse['total_points']        = pretty_number($StatRecord['total_points']);;
        $parse['user_rank']           = $StatRecord['total_rank'];

        $ile = $StatRecord['total_old_rank'] - $StatRecord['total_rank'];
        if ($ile >= 1) {
            $parse['ile'] = "<font color=lime>+" . $ile . "</font>";
        } elseif ($ile < 0) {
            $parse['ile'] = "<font color=red>-" . $ile . "</font>";
        } elseif ($ile == 0) {
            $parse['ile'] = "<font color=lightblue>" . $ile . "</font>";
        }

        $parse['u_user_rank'] = $StatRecord['total_rank'];
        $parse['user_username'] = $user['username'];

        $moved_query = doquery("SELECT `fleet_owner`,`fleet_mission`,SUM(`fleet_resource_metal`) as metal,SUM(`fleet_resource_crystal`) as crystal,SUM(`fleet_resource_deuterium`)as deuterium,SUM(`fleet_resource_appolonium`)as appolonium FROM {{table}} WHERE fleet_owner = ".$user['id']." GROUP BY fleet_mission",'fleets');

        $g_metal= 0;
        $g_crystal= 0;
        $g_deuterium= 0;
        $g_appolonium= 0;
        $g_debris= 0;

        $parse['res_atk_metal']= 0;
        $parse['res_atk_crystal']= 0;
        $parse['res_atk_deuterium']= 0;
        $parse['res_atk_appolonium']= 0;
        $parse['res_trans_metal']= 0;
        $parse['res_trans_crystal']= 0;
        $parse['res_trans_deuterium']= 0;
        $parse['res_trans_appolonium']= 0;
        $parse['res_statio_metal']= 0;
        $parse['res_statio_crystal']= 0;
        $parse['res_statio_deuterium']= 0;
        $parse['res_statio_appolonium']= 0;
        $parse['res_debris_metal']= 0;
        $parse['res_debris_crystal']= 0;
        $parse['res_debris_deuterium']= 0;
        $parse['res_debris_appolonium']= 0;
        while($moved = mysql_fetch_assoc($moved_query)) {

            switch($moved['fleet_mission']) {

                case 1:
                $parse['res_atk_metal']= pretty_number($moved['metal']);
                $parse['res_atk_crystal']= pretty_number($moved['crystal']);
                $parse['res_atk_deuterium']= pretty_number($moved['deuterium']);
                $parse['res_atk_appolonium']= pretty_number($moved['appolonium']);
                $g_metal+= $moved['metal'];
                $g_crystal+= $moved['crystal'];
                $g_deuterium+= $moved['deuterium'];
                $g_appolonium+= $moved['appolonium'];

                break;
                case 3:

                $parse['res_trans_metal']= pretty_number($moved['metal']);
                $parse['res_trans_crystal']= pretty_number($moved['crystal']);
                $parse['res_trans_deuterium']= pretty_number($moved['deuterium']);
                $parse['res_trans_appolonium']= pretty_number($moved['appolonium']);
                $g_metal+= $moved['metal'];
                $g_crystal+= $moved['crystal'];
                $g_deuterium+= $moved['deuterium'];
                $g_appolonium+= $moved['appolonium'];

                break;
                case 4:

                $parse['res_statio_metal']= pretty_number($moved['metal']);
                $parse['res_statio_crystal']= pretty_number($moved['crystal']);
                $parse['res_statio_deuterium']= pretty_number($moved['deuterium']);
                $parse['res_statio_appolonium']= pretty_number($moved['appolonium']);
                $g_metal+= $moved['metal'];
                $g_crystal+= $moved['crystal'];
                $g_deuterium+= $moved['deuterium'];
                $g_appolonium+= $moved['appolonium'];

                break;
                case 8:

                $parse['res_debris_metal']= pretty_number($moved['metal']);
                $parse['res_debris_crystal']= pretty_number($moved['crystal']);
                $parse['res_debris_deuterium']= pretty_number($moved['deuterium']);
                $parse['res_debris_appolonium']= pretty_number($moved['appolonium']);
                $g_metal+= $moved['metal'];
                $g_crystal+= $moved['crystal'];
                $g_deuterium+= $moved['deuterium'];
                $g_appolonium+= $moved['appolonium'];

                break;
            }
        }

        $parse['res_all_metal']= pretty_number($g_metal);
        $parse['res_all_crystal']= pretty_number($g_crystal);
        $parse['res_all_deuterium']= pretty_number($g_deuterium);
        $parse['res_all_appolonium']= pretty_number($g_appolonium);

        if (count($fpage) > 0) {
            ksort($fpage);
            foreach ($fpage as $time => $content) {

                $flotten_anfang ="

                <img src='./".$dpath."balken/menu_56.png' style='width:100%; height:12px' alt='komplettoben.png'><table style='width:700px' cellspacing='0' cellpadding='0' border='0' >
                    <tr><td style='width:12%;' class='sb'>".$lang['over']['0200']." <img src='./styl/image/pfeile/rechtu.png' alt='rechtu.png'></td>
                        <td style='width:13%;' class='sb'>".$lang['over']['0201']." <img src='./styl/image/pfeile/rechtu.png' alt='rechtu.png'></td>
                        <td style='width:75%;' class='sb'>".$lang['over']['0202']." <img src='./styl/image/pfeile/rechtu.png' alt='rechtu.png'></td></tr>

                    <tr><td style='width:100%;' class='sb' colspan='4' >";

                $flotten_mitte .= $content . "\n";

                $flotten_ende = "

                            </td></tr>
                </table><img src='./".$dpath."balken/menu_57.png' style='width:100%; height:12px;' alt=''>";

            }
        }

        $parse['fleet_anfang'] = $flotten_anfang;
        $parse['fleet_mitte'] = $flotten_mitte;
        $parse['fleet_ende'] = $flotten_ende;
        $parse['energy_used'] = $planetrow["energy_max"] - $planetrow["energy_used"];
        $parse['Have_new_message'] = $Have_new_message;

        $parse['mienen'] = $HaveNewLevelMineur2;
        $parse['raid'] = $HaveNewLevelRaid2;

        $parse['Have_new_level_mineur'] = $HaveNewLevelMineur;
        $parse['Have_new_level_raid'] = $HaveNewLevelRaid;
        $parse['time'] = "<div id=\"dateheure\"></div>";
        $parse['dpath'] = $dpath;
        $parse['planet_image'] = $planetrow['image'];
        $parse['anothers_planets'] = $AllPlanets;
        $parse['max_users'] = ($MaxUsers['count']);
        $parse['metal_debris'] = pretty_number($galaxyrow['metal']);
        $parse['crystal_debris'] = pretty_number($galaxyrow['crystal']);
        $parse['appolonium_debris'] = pretty_number($galaxyrow['appolonium']);

        if (($galaxyrow['metal'] != 0 || $galaxyrow['crystal'] != 0 || $galaxyrow['appolonium'] != 0) && $planetrow[$resource[219]] != 0 or $planetrow[$resource[209]] != 0) {
            $parse['get_link'] = " [<a href=\"quickfleet.php?mode=8&amp;g=" . $galaxyrow['galaxy'] . "&amp;s=" . $galaxyrow['system'] . "&amp;p=" . $galaxyrow['planet'] . "&amp;t=2\">" . $lang['type_mission'][8] . "</a>]";
        } else {
            $parse['get_link'] = '';
        }

        if ($planetrow['b_building'] != 0) {
            UpdatePlanetBatimentQueueList ($planetrow, $user);

            if ($planetrow['b_building'] != 0) {
                $BuildQueue     = explode (";", $planetrow['b_building_id']);
                $CurrBuild      = explode (",", $BuildQueue[0]);
                $RestTime       = $planetrow['b_building'] - time();
                $PlanetID       = $planetrow['id'];
                $Build          = countdown('gebaude', $RestTime);
                $Build2         = $lang['tech'][$CurrBuild[0]];
                $parse['build']  = '<table cellspacing="0" cellpadding="0" style="width:100%;">
                                        <tr><td class="sb" align="left" style="width:30%;" valign="top" ><img src="'.$dpath.'gebaeude/'.$CurrBuild[0].'.gif" style="width:40px; height:40px;" alt=""></td>
                                            <td class="sb" align="center" style="width:70%;" valign="middle" >'.$Build.' </td></tr>
                                        <tr><td class="sb" align="center" style="width:30%;" valign="middle" ><img src="./styl/image/pfeile/rechto.png" alt=""></td>
                                            <td class="sb" align="left" style="width:70%;" valign="middle" >'.$Build2.' </td></tr>
                                    </table>';
            } else {
                $parse['build'] = '<table cellspacing="0" style="width:100%;">
                                       <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                                   </table>';
            }
        } else {
            $parse['build'] = '<table cellspacing="0" style="width:100%;">
                                   <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                               </table>';
        }

        if ($planetrow['b_tech'] != 0 ) {
            HandleTechnologieBuild ( $planetrow, $user );

            if ($planetrow['b_tech'] != 0 ) {
                $BuildQueue     = explode (";", $planetrow['b_tech_id']);
                $CurrBuild      = explode (",", $BuildQueue[0]);
                $RestTime       = $planetrow['b_tech'] - time();
                $PlanetID       = $planetrow['id'];
                $Build          = countdown('forschung', $RestTime);
                $Build2         = $lang['tech'][$CurrBuild[0]];
                $parse['tech']  = '<table cellspacing="0" cellpadding="0" style="width:100%;">
                                        <tr><td class="sb" align="left" style="width:30%;" valign="top" ><img src="'.$dpath.'gebaeude/'.$CurrBuild[0].'.gif" style="width:40px; height:40px;" alt=""></td>
                                            <td class="sb" align="center" style="width:70%;" valign="middle" >'.$Build.' </td></tr>
                                        <tr><td class="sb" align="center" style="width:30%;" valign="middle" ><img src="./styl/image/pfeile/rechto.png" alt=""></td>
                                            <td class="sb" align="left" style="width:70%;" valign="middle" >'.$Build2.' </td></tr>
                                    </table>';
            } else {
                $parse['tech'] = '<table cellspacing="0" style="width:100%;">
                                       <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                                   </table>';
            }
        } else {
            $parse['tech'] = '<table cellspacing="0" style="width:100%;">
                                  <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                              </table>';
        }

        if ($planetrow['b_hangar'] != 0 ) {
            HandleTechnologieBuild ( $planetrow, $user );

            if ($planetrow['b_hangar'] != 0 ) {
                $BuildQueue = explode (";", $planetrow['b_hangar_id']);
                $CurrBuild  = explode (",", $BuildQueue[0]);
                $RestTime   = $planetrow['b_hangar'] - time();
                $PlanetID   = $planetrow['id'];
                $Build2 = $lang['tech'][$CurrBuild[0]];
                $parse['hangar']  = '<table cellspacing="0" cellpadding="0" style="width:100%;">
                                        <tr><td class="sb" align="left" style="width:30%;" valign="top" ><img src="'.$dpath.'gebaeude/'.$CurrBuild[0].'.gif" style="width:40px; height:40px;" alt=""></td>
                                            <td class="sb" align="center" style="width:70%;" valign="middle" >'.$Build.' </td></tr>
                                        <tr><td class="sb" align="center" style="width:30%;" valign="middle" ><img src="./styl/image/pfeile/rechto.png" alt=""></td>
                                            <td class="sb" align="left" style="width:70%;" valign="middle" >'.$Build2.' </td></tr>
                                    </table>';
            } else {
                $parse['hangar'] = '<table cellspacing="0" style="width:100%;">
                                       <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                                   </table>';
            }
        } else {
            $parse['hangar'] = '<table cellspacing="0" style="width:100%;">
                                    <tr><td align="center" valign="middle"><b>'.$lang['over']['0300'].'</b></td></tr>
                                </table>';
        }

        $query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true);
        $parse['last_user'] = $query['username'];
        $query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
        $parse['online_users'] = $query[0];
        $parse['users_amount'] = $game_config['users_amount'];
        $parse['xpminier']       = $user['xpminier'];
        $parse['xpraid']         = $user['xpraid'];
        $parse['lvl_minier']     = $user['lvl_minier'];
        $parse['lvl_raid']       = $user['lvl_raid'];
        $LvlMinier               = $user['lvl_minier'];
        $LvlRaid                 = $user['lvl_raid'];
        $parse['lvl_up_minier']  = $LvlMinier * 5000;
        $parse['lvl_up_raid']    = $LvlRaid * 100;

        $parse['Raids']          = $lang['Raids'];
        $parse['NumberOfRaids']  = $lang['NumberOfRaids'];
        $parse['RaidsWin']       = $lang['RaidsWin'];
        $parse['RaidsLoose']     = $lang['RaidsLoose'];

        $parse['raids']          = $user['raids'];
        $parse['raidswin']       = $user['raidswin'];
        $parse['raidsloose']     = $user['raidsloose'];

        $parse['avatar']        = $user['avatar'];
        $parse['angriffszone']  = $user['angriffszone'];
        $parse['servername']    = $game_config['game_name'];
        $parse['username']      = $user['username'];
        $parse['onlinetime']    = $user['onlinetime'];
        $parse['uID']           = $user['id'];
        $parse['regtime']       = date("d.m.Y H:m:s", $user['register_time']);

        $allyinfo               = doquery("SELECT * FROM {{table}} WHERE id = '".$user['ally_id']."';", "alliance");
        while($ally             = mysql_fetch_array($allyinfo)) {
           $parse['ally_name']     = $ally['ally_name'];
           $parse['ally_tag']      = $ally['ally_tag'];
        }

        $OnlineUsers                  = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='".(time()-15*60)."'",'users', 'true');
        $parse['NumberMembersOnline'] = $OnlineUsers[0];
        $PlanetCount                  = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $user['id'] ."' AND `planet_type` = '1'", 'planets'), 0);
        $parse['PlanetCount']         = $PlanetCount;
        $parse['Max_Planets']         = MAX_PLAYER_PLANETS;

        $page = parsetemplate(gettemplate('ubersicht/ubersicht_01'), $parse);

        display($page, '&Uuml;bersicht');
        break;
    }
}

?>