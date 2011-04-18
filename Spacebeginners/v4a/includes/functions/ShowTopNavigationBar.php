<?php

/**
  * ShowTopNavigationsBar.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) {
    global $lang, $_GET, $game_config, $dpath;

    includeLang('menu');

    if ($CurrentUser) {

        if (!$CurrentPlanet) {
            $CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets', true);
        }

        if ($CurrentPlanet["metal"]  < 0  ) {
            $CurrentPlanet["metal"] = 1;
        }

        if ( $CurrentPlanet["crystal"]  < 0  ) {
            $CurrentPlanet["crystal"] = 1;
        }

        if ( $CurrentPlanet["deuterium"]  < 0  ) {
            $CurrentPlanet["deuterium"] = 1;
        }

                if ( $CurrentPlanet["appolonium"]  < 0  ) {
             $CurrentPlanet["appolonium"] = 1;
        }

        if ($CurrentUser['urlaubs_modus'] == 0) {
            PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );
        }else{
            doquery("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0,`appolonium_mine_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".$CurrentUser['id'],"planets");
        }

        $NavigationTPL                   = gettemplate('menu/menu');
        $dpath                           = (!$CurrentUser["dpath"]) ? DEFAULT_SKINPATH : $CurrentUser["dpath"];
        $parse                           = $lang;
        $parse['dpath']                  = $dpath;
        $parse['image']                  = $CurrentPlanet['image'];
        $parse['username']               = $CurrentUser['username'];
        $parse['user-id']                = $CurrentUser['id'];
        $parse['user-zone']              = $CurrentUser['angriffszone'];
        $parse['name']                   = $game_config['game_name'];
        $parse['nummer']                 = $game_config['VERSION'];
        $parse['forum_url']              = $game_config['forum_url'];
        $parse['lm_tx_serv']             = $game_config['resource_multiplier'];
        $parse['lm_tx_game']             = $game_config['game_speed'] / 2500;
        $parse['lm_tx_fleet']            = $game_config['fleet_speed'] / 2500;
        $parse['lm_tx_queue']            = MAX_FLEET_OR_DEFS_PER_ROW;
        $parse['show_umod_notice']       = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 1px solid red; text-align:center;"><tr><td>Urlaubsmodus</td></tr></table>' : '';
        $parse['show_attacklock_notice'] = $game_config['attack_disabled'] ? '<table width="100%" style="border: 3px solid red; text-align:center;text-decoration:blink;color: #ff0000;"><tr><td>Angriffsperre aktiviert Informationen im Forum</td></tr></table>' : '';

        switch ($CurrentUser['volk']) {
            case "A":

            switch ($CurrentUser['avatar']) {
                case "0":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_01.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                case "A":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_01.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                default:

                $parse['volk'] = "<img src=\"".$CurrentUser['avatar']."\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
            }

            $parse['volk1'] = "".$lang['menu']['401']."";

            break;
            case "B":

            switch ($CurrentUser['avatar']) {
                case "0":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_02.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                case "B":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_02.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                default:

                $parse['volk'] = "<img src=\"".$CurrentUser['avatar']."\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
            }

            $parse['volk1'] = "".$lang['menu']['402']."";

            break;
            case "C":

            switch ($CurrentUser['avatar']) {
                case "0":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_03.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                case "C":

                $parse['volk'] = "<img src=\"./styl/image/volk/volk_03.jpg\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
                default:

                $parse['volk'] = "<img src=\"".$CurrentUser['avatar']."\" style=\"height:33px; width:33px;\" alt=\"\">";

                break;
            }

            $parse['volk1'] = "".$lang['menu']['403']."";

            break;
            case "0":

            $parse['volk'] = "<img src=\"./styl/image/volk/volk_04.png\" style=\"height:33px; width:33px;\" alt=\"\">";
            $parse['volk1'] = "".$lang['menu']['404']."";


            break;
        }

        if ($CurrentUser['authlevel'] > 0) {
            $parse['ADMIN_LINK']  = "<a href=\"admin/index.php\" target=\"_blank\"><font size=\"1\" color=\"red\"><b>".$lang['menu']['506']."</b></font></a> -";
        } else {
            $parse['ADMIN_LINK']  = "";
        }

        $OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='".(time()-15*60)."'",'users', 'true');
        if ($CurrentUser['authlevel'] > 0) {
            $parse['NumberMembersOnline']  = "".$lang['menu']['900']."".$lang['menu']['501']." ".$OnlineUsers[0]."";
        } else {
            $parse['NumberMembersOnline']  = "";
        }

        $Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","messages"));
        if ($CurrentUser['authlevel'] > 0) {
            $parse['cantmessa']  = "".$lang['menu']['502']." ".$Consulta[0]."";
        } else {
            $parse['cantmessa']  = "";
        }

        $Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","supp"));
        if ($CurrentUser['authlevel'] > 0) {
            $parse['cantsupp']  = "".$lang['menu']['504']." ".$Consulta[0]."";
        } else {
            $parse['cantsupp']  = "";
        }

        $Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","errors"));
        if ($CurrentUser['authlevel'] > 0) {
            $parse['canterror']  = "".$lang['menu']['505']." ".$Consulta[0]."".$lang['menu']['901']."";
        } else {
            $parse['canterror']  = "";
        }

        if ($game_config['angriffszone'] == 1) {
            $parse['info_01'] = "".$lang['menu']['300']."";
        } else {
            $parse['info_01'] = "".$lang['menu']['301']."";
        }

        if ($game_config['over'] == 1) {
            $parse['1be_aa']  = "<a href=\"overview.php\" target=\"_self\">                      ".$lang['menu']['101']."</a>";
        } else {
            $parse['1be_aa']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['gala'] == 1) {
            $parse['1be_ab']  = "<a href=\"galaxy.php?mode=0\" target=\"_self\">             ".$lang['menu']['102']."</a>";
        } else {
            $parse['1be_ab']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['fleet'] == 1) {
            $parse['1be_ac']  = "<a href=\"fleet.php\" target=\"_self\">                         ".$lang['menu']['103']."</a>";
        } else {
            $parse['1be_ac']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['mess'] == 1) {
            $parse['1be_ad']  = "<a href=\"messages.php\" target=\"_self\">                      ".$lang['menu']['104']."</a>";
        } else {
            $parse['1be_ad']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['gebau'] == 1) {
            $parse['2be_aa']  = "<a href=\"buildings.php\" target=\"_self\">                     ".$lang['menu']['105']."</a>";
        } else {
            $parse['2be_aa']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['forsch'] == 1) {
            $parse['2be_ab']  = "<a href=\"buildings.php?mode=research\" target=\"_self\">       ".$lang['menu']['106']."</a>";
        } else {
            $parse['2be_ab']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['armada'] == 1) {
            $parse['2be_ac']  = "<a href=\"buildings.php?mode=fleet\" target=\"_self\">          ".$lang['menu']['107']."</a>";
        } else {
            $parse['2be_ac']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['abwehr'] == 1) {
            $parse['2be_ad']  = "<a href=\"buildings.php?mode=defense\" target=\"_self\">        ".$lang['menu']['108']."</a>";
        } else {
            $parse['2be_ad']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['officier'] == 1) {
            $parse['3be_aa']  = "<a href=\"officier.php\" target=\"_self\">                      ".$lang['menu']['109']."</a>";
        } else {
            $parse['3be_aa']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['marchand'] == 1) {
            $parse['3be_ab']  = "<a href=\"marchand.php\" target=\"_self\">                      ".$lang['menu']['110']."</a>";
        } else {
            $parse['3be_ab']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['annonce'] == 1) {
            $parse['3be_ac']  = "<a href=\"annonce.php\" target=\"_self\">                       ".$lang['menu']['111']."</a>";
        } else {
            $parse['3be_ac']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['schrotti'] == 1) {
            $parse['3be_ad']  = "<a href=\"schrotti.php\" target=\"_self\">                      ".$lang['menu']['112']."</a>";
        } else {
            $parse['3be_ad']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['imperium'] == 1) {
            $parse['4be_aa']  = "<a href=\"imperium.php\" target=\"_self\">                      ".$lang['menu']['113']."</a>";
        } else {
            $parse['4be_aa']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['alliance'] == 1) {
            $parse['4be_ab']  = "<a href=\"alliance.php\" target=\"_self\">                      ".$lang['menu']['114']."</a>";
        } else {
            $parse['4be_ab']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['resources'] == 1) {
            $parse['4be_ac']  = "<a href=\"resources.php\" target=\"_self\">                     ".$lang['menu']['115']."</a>";
        } else {
            $parse['4be_ac']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['techtree'] == 1) {
            $parse['4be_ad']  = "<a href=\"techtree.php\" target=\"_self\">                      ".$lang['menu']['116']."</a>";
        } else {
            $parse['4be_ad']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['reco'] == 1) {
            $parse['1be_ba']  = "<a href=\"records.php\" target=\"_self\">                       ".$lang['menu']['201']."</a>";
        } else {
            $parse['1be_ba']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['stat'] == 1) {
            $parse['1be_bb']  = "<a href=\"game.php?page=stat\" target=\"_self\">                ".$lang['menu']['202']."</a>";
        } else {
            $parse['1be_bb']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['topk'] == 1) {
            $parse['1be_bc']  = "<a href=\"game.php?page=ruhm\" target=\"_self\">                ".$lang['menu']['203']."</a>";
        } else {
            $parse['1be_bc']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['simu'] == 1) {
            $parse['1be_bd']  = "<a href=\"simulator.php\" target=\"_self\">                     ".$lang['menu']['204']."</a>";
        } else {
            $parse['1be_bd']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['note'] == 1) {
            $parse['2be_ba']  = "<a href=\"notes.php\" target=\"_self\">                         ".$lang['menu']['205']."</a>";
        } else {
            $parse['2be_ba']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['budd'] == 1) {
            $parse['2be_bb']  = "<a href=\"buddy.php\" target=\"_self\">                         ".$lang['menu']['206']."</a>";
        } else {
            $parse['2be_bb']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['chat'] == 1) {
            $parse['2be_bc']  = "<a href=\"chat.php\" target=\"_self\">                          ".$lang['menu']['207']."</a>";
        } else {
            $parse['2be_bc']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['sear'] == 1) {
            $parse['2be_bd']  = "<a href=\"search.php\" target=\"_self\">                        ".$lang['menu']['208']."</a>";
        } else {
            $parse['2be_bd']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['decl'] == 1) {
            $parse['3be_ba']  = "<a href=\"add_declare.php\" target=\"_self\">                   ".$lang['menu']['209']."</a>";
        } else {
            $parse['3be_ba']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['rule'] == 1) {
           $parse['3be_bb']  = "<a href=\"rules.html\" target=\"_self\">                         ".$lang['menu']['210']."</a>";
        } else {
           $parse['3be_bb']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['conn'] == 1) {
            $parse['3be_bc']  = "<a href=\"contact.php\" target=\"_self\">                       ".$lang['menu']['211']."</a>";
        } else {
            $parse['3be_bc']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['supp'] == 1) {
            $parse['3be_bd']  = "<a href=\"support.php\" target=\"_self\">                       ".$lang['menu']['212']."</a>";
        } else {
            $parse['3be_bd']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['bann'] == 1) {
            $parse['4be_ba']  = "<a href=\"banned.php\" target=\"_self\">                        ".$lang['menu']['213']."</a>";
        } else {
            $parse['4be_ba']  = " <u>".$lang['menu']['500']."</u>";
        }

        if ($game_config['opti'] == 1) {
            $parse['4be_bb']  = "<a href=\"options.php\" target=\"_self\">                       ".$lang['menu']['214']."</a>";
        } else {
            $parse['4be_bb']  = " <u>".$lang['menu']['500']."</u>";
        }

        $parse['planetlist'] = '';
        $ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
        while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {

            if ($CurPlanet["destruyed"] == 0) {
                $parse['planetlist'] .= "\n<option ";

                if ($CurPlanet['id'] == $CurrentUser['current_planet']) {
                    $parse['planetlist'] .= "selected=\"selected\" ";
                }

                 $parse['planetlist'] .= "value=\"?cp=".$CurPlanet['id']."";
                 $parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
                 $parse['planetlist'] .= "&amp;re=0\">";
                 $parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
                 $parse['planetlist'] .= "".$CurPlanet['system'].":";
                 $parse['planetlist'] .= "".$CurPlanet['planet'];
                 $parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
            }
        }

        $parse['planet_name'] = "".$CurrentPlanet['name'];

        $energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);

        if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
            $parse['energy'] = colorRed($energy);
        } else {
            $parse['energy'] = $energy;
        }

        $metal = pretty_number($CurrentPlanet["metal"]);

        if (($CurrentPlanet["metal"] > $CurrentPlanet["metal_max"])) {
            $parse['metal'] = colorRed($metal);
        } else {
            $parse['metal'] = $metal;
        }

        $crystal = pretty_number($CurrentPlanet["crystal"]);

        if (($CurrentPlanet["crystal"] > $CurrentPlanet["crystal_max"])) {
            $parse['crystal'] = colorRed($crystal);
        } else {
            $parse['crystal'] = $crystal;
        }

        $deuterium = pretty_number($CurrentPlanet["deuterium"]);

        if (($CurrentPlanet["deuterium"] > $CurrentPlanet["deuterium_max"])) {
            $parse['deuterium'] = colorRed($deuterium);
        } else {
            $parse['deuterium'] = $deuterium;
        }

                $appolonium = pretty_number($CurrentPlanet["appolonium"]);

        if (($CurrentPlanet["appolonium"] > $CurrentPlanet["appolonium_max"])) {
            $parse['appolonium'] = colorRed($appolonium);
        } else {
            $parse['appolonium'] = $appolonium;
        }
        $energy_max= pretty_number($CurrentPlanet["energy_max"] + (($CurrentPlanet['energy_max'] / 100) * $CurrentUser['energy_tech'])  );

        if (($CurrentPlanet["energy_max"] > $CurrentPlanet["energy_max"])) {
            $parse['energy_max'] = colorRed($energy_max);
        } else {
            $parse['energy_max'] = $energy_max;
        }

        $parse['energy_total'] = colorNumber( pretty_number( floor(($CurrentPlanet['energy_max']+$CurrentPlanet['energy_used']) +( ($CurrentPlanet['energy_max'] / 100) * $CurrentUser['energy_tech']))));

        if (($CurrentPlanet["metal_max"] ) < $CurrentPlanet["metal"]) {
            $parse['metal_max'] = '<font color="#ff0000">';
        } else {
            $parse['metal_max'] = '<font color="#00ff00">';
        }
        $parse['metal_max'] .= pretty_number($CurrentPlanet["metal_max"]) . " {$lang['']}</font>";

        if (($CurrentPlanet["crystal_max"] ) < $CurrentPlanet["crystal"]) {
            $parse['crystal_max'] = '<font color="#ff0000">';
        } else {
            $parse['crystal_max'] = '<font color="#00ff00">';
        }
        $parse['crystal_max'] .= pretty_number($CurrentPlanet["crystal_max"] ) . " {$lang['']}</font>";

        if (($CurrentPlanet["deuterium_max"] ) < $CurrentPlanet["deuterium"]) {
            $parse['deuterium_max'] = '<font color="#ff0000">';
        } else {
            $parse['deuterium_max'] = '<font color="#00ff00">';
        }
        $parse['deuterium_max'] .= pretty_number($CurrentPlanet["deuterium_max"]) . " {$lang['']}</font>";

        if (($CurrentPlanet["appolonium_max"] ) < $CurrentPlanet["appolonium"]) {
            $parse['appolonium_max'] = '<font color="#ff0000">';
        } else {
            $parse['appolonium_max'] = '<font color="#00ff00">';
        }
        $parse['appolonium_max'] .= pretty_number($CurrentPlanet["appolonium_max"]) . " {$lang['']}</font>";


        $parse['metal_perhour']      .= $CurrentPlanet["metal_perhour"]      + ($game_config['metal_basic_income']      * $game_config['resource_multiplier']);
        $parse['crystal_perhour']    .= $CurrentPlanet["crystal_perhour"]    + ($game_config['crystal_basic_income']    * $game_config['resource_multiplier']);
        $parse['deuterium_perhour']  .= $CurrentPlanet["deuterium_perhour"]  + ($game_config['deuterium_basic_income']  * $game_config['resource_multiplier']);
        $parse['appolonium_perhour'] .= $CurrentPlanet["appolonium_perhour"] + ($game_config['appolonium_basic_income'] * $game_config['resource_multiplier']);

        $parse['metalh']      .= round($CurrentPlanet["metal"]);
        $parse['crystalh']    .= round($CurrentPlanet["crystal"]);
        $parse['deuteriumh']  .= round($CurrentPlanet["deuterium"]);
        $parse['appoloniumh'] .= round($CurrentPlanet["appolonium"]);

        $parse['metal_mmax']      .= $CurrentPlanet["metal_max"]      * MAX_OVERFLOW;
        $parse['crystal_mmax']    .= $CurrentPlanet["crystal_max"]    * MAX_OVERFLOW;
        $parse['deuterium_mmax']  .= $CurrentPlanet["deuterium_max"]  * MAX_OVERFLOW;
        $parse['appolonium_mmax'] .= $CurrentPlanet["appolonium_max"] * MAX_OVERFLOW;

        if ($CurrentUser['new_message'] > 0) {
            $parse['message'] = "<a href=\"messages.php\"><img src=\"./images/info.gif\" style=\"height:33px; width:33px;\" alt=\"info.gif\"/></a>";
        } else {
            $parse['message'] = "";
        }

        $TopBar = parsetemplate( $NavigationTPL, $parse);
    } else {
        $TopBar = "";
    }
    return $TopBar;
}

?>