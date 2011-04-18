<?php

/**
  * GalaxyRowPlanet.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowPlanet ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $dpath, $user, $CurrentMIP, $HavePhalanx, $CurrentSystem, $CurrentGalaxy, $game_config;

    $Result = "<td style='width:30px; height:30px;' align='center'>";
    $GalaxyRowUser = doquery("SELECT * FROM {{table}} WHERE id='".$GalaxyRowPlanet['id_owner']."';", 'users', true);

    if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0 && $GalaxyRow["id_planet"] != 0) {

        if ($HavePhalanx <> 0) {

            if ($GalaxyRowUser['id'] != $user['id']) {

                if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
                    $PhRange = GetPhalanxRange ( $HavePhalanx );
                    $SystemLimitMin = $CurrentSystem - $PhRange;

                                        if ($SystemLimitMin < 1) {
                        $SystemLimitMin = 1;
                    }

                    $SystemLimitMax = $CurrentSystem + $PhRange;

                    if ($System <= $SystemLimitMax) {

                        if ($System >= $SystemLimitMin) {
                             $PhalanxTypeLink = "<a href=# onclick=fenster(&#039;phalanx.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&#039;) >".$lang['gala']['0207']."</a>";
                        } else {
                             $PhalanxTypeLink = "";
                        }
                    } else {
                        $PhalanxTypeLink = "";
                    }
                } else {
                    $PhalanxTypeLink = "";
                }
            } else {
                $PhalanxTypeLink = "";
            }
        } else {
            $PhalanxTypeLink = "";
        }

        if ($CurrentMIP <> 0) {

            if ($GalaxyRowUser['id'] != $user['id']) {

                if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
                    $MiRange = GetMissileRange();
                    $SystemLimitMin = $CurrentSystem - $MiRange;

                    if ($SystemLimitMin < 1) {
                        $SystemLimitMin = 1;
                    }

                    $SystemLimitMax = $CurrentSystem + $MiRange;

                    if ($System <= $SystemLimitMax) {

                        if ($System >= $SystemLimitMin) {
                            $MissileBtn = true;
                        } else {
                            $MissileBtn = false;
                        }
                    } else {
                        $MissileBtn = false;
                    }
                } else {
                    $MissileBtn = false;
                }
            } else {
                $MissileBtn = false;
            }
        } else {
            $MissileBtn = false;
        }

        if ($GalaxyRowUser['id'] != $user['id']) {
            $MissionType6Link = "<a href=# onclick=&#039;javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039; >              ". $lang['type_mission'][6] ."</a>";
        } elseif ($GalaxyRowUser['id'] == $user['id']) {
            $MissionType6Link = "";
        }

        if ($GalaxyRowUser['id'] != $user['id']) {
            $MissionType1Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>         ". $lang['type_mission'][1] ."</a>";
        } elseif ($GalaxyRowUser['id'] == $user['id']) {
            $MissionType1Link = "";
        }

        if ($GalaxyRowUser['id'] != $user['id']) {
            $MissionType5Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=5>         ". $lang['type_mission'][5] ."</a>";
        } elseif ($GalaxyRowUser['id'] == $user['id']) {
            $MissionType5Link = "";
        }

        if ($GalaxyRowUser['id'] == $user['id']) {
            $MissionType4Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=4>         ". $lang['type_mission'][4] ."</a>";
        } elseif ($GalaxyRowUser['id'] != $user['id']) {
            $MissionType4Link = "";
        }

        if ($user["settings_mis"] == "1" AND $MissileBtn == true && $GalaxyRowUser['id']){
            $MissionType10Link = "<a href=galaxy.php?mode=2&amp;galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;current=".$user['current_planet']." >       ". $lang['type_mission'][10]."</a>";
        } elseif ($GalaxyRowUser['id'] != $user['id']) {
            $MissionType10Link = "";
        }

        $MissionType3Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=3>             ". $lang['type_mission'][3] ."</a>";

        $Result .= "<a style=\"cursor: pointer;\"";
        $Result .= " onmouseover='return overlib(\"";
        $Result .= "<table width=270px cellspacing=0px>";
        $Result .= "<tr><td class=c align=center rowspan=5 width=60px><img src=". $dpath ."planeten/". $GalaxyRowPlanet["image"] .".gif height=60px width=60px alt=planet.gif>                                                                                                                                           </td></tr>";
        $Result .= "<tr><td class=c align=left width=140px>".$lang['gala']['5003']." ".$lang['gala']['0201']."".$lang['gala']['5002']." </td><td class=c align=left width=140px> ".$lang['gala']['5000']."".$Galaxy."".$lang['gala']['5003']."".$System."".$lang['gala']['5003']."".$Planet."".$lang['gala']['5001']."   </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0202']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". $GalaxyRowPlanet["name"] ."                                                                                                          </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0203']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". number_format($GalaxyRowPlanet['diameter'], 0, '', '.') ." ".$lang['gala']['0205']."                                                 </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0204']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". number_format($GalaxyRowPlanet['temp_min'], 0, '', '.') ." ".$lang['gala']['0206']."                                                 </td></tr>";

        $Result .= "</table><table width=270px cellspacing=0px>";

        $Result .= "<tr><td class=c align=left width=50%> ".$lang['gala']['5003']." ";
        $Result .= $MissionType1Link;   // Angreifen
        $Result .= "</td><td class=c align=left width=50%>".$lang['gala']['5003']." ";
        $Result .= $MissionType5Link;   // Halten
        $Result .= "</td></tr> ";

        $Result .= "<tr><td class=c align=left width=50%> ".$lang['gala']['5003']." ";
        $Result .= $MissionType3Link;   // Transportieren
        $Result .= "</td><td class=c align=left width=50%>".$lang['gala']['5003']." ";
        $Result .= $MissionType6Link;   // Spionage
        $Result .= "</td></tr> ";

        $Result .= "<tr><td class=c align=left width=50%> ".$lang['gala']['5003']." ";
        $Result .= $MissionType4Link;   // Stationieren
        $Result .= "</td><td class=c align=left width=50%>".$lang['gala']['5003']." ";
        $Result .= $PhalanxTypeLink;
        $Result .= "</td></tr> ";

        $Result .= "</table>\"";
        $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
        $Result .= " onmouseout='return nd();'>";
        $Result .= "<img src='".$dpath ."planeten/". $GalaxyRowPlanet["image"] .".gif' style='width:28px; height:28px;' alt='planet.gif'>";
        $Result .= "</a>";

    } else {

        $bild = array('s_dschjungelplanet01.gif','s_dschjungelplanet02.gif','s_dschjungelplanet03.gif','s_dschjungelplanet04.gif','s_dschjungelplanet05.gif','s_dschjungelplanet06.gif', 's_dschjungelplanet07.gif','s_dschjungelplanet08.gif','s_dschjungelplanet09.gif','s_dschjungelplanet10.gif',
                      's_eisplanet01.gif','s_eisplanet02.gif','s_eisplanet03.gif','s_eisplanet04.gif','s_eisplanet05.gif','s_eisplanet06.gif', 's_eisplanet07.gif','s_eisplanet08.gif','s_eisplanet09.gif','s_eisplanet10.gif',
                      's_gasplanet01.gif','s_gasplanet02.gif','s_gasplanet03.gif','s_gasplanet04.gif','s_gasplanet05.gif','s_gasplanet06.gif', 's_gasplanet07.gif','s_gasplanet08.gif','s_gasplanet09.gif',
                      's_normaltempplanet01.gif','s_normaltempplanet02.gif','s_normaltempplanet03.gif','s_normaltempplanet04.gif','s_normaltempplanet05.gif','s_normaltempplanet06.gif', 's_normaltempplanet07.gif','s_normaltempplanet08.gif',
                      's_trockenplanet01.gif','s_trockenplanet02.gif','s_trockenplanet03.gif','s_trockenplanet04.gif','s_trockenplanet05.gif','s_trockenplanet06.gif', 's_trockenplanet07.gif','s_trockenplanet08.gif','s_trockenplanet09.gif','s_trockenplanet10.gif',
                      's_wasserplanet01.gif','s_wasserplanet02.gif','s_wasserplanet03.gif','s_wasserplanet04.gif','s_wasserplanet05.gif','s_wasserplanet06.gif', 's_wasserplanet07.gif','s_wasserplanet08.gif','s_wasserplanet09.gif',
                      's_wuestenplanet01.gif','s_wuestenplanet02.gif','s_wuestenplanet03.gif','s_wuestenplanet04.gif', );
        shuffle($bild);

        $Result .= "<img src='".$dpath ."planeten/small_planet/".$bild[0]."' style='height:20px; width:20px;' alt='planet01.gif'>";
    }
$Result .= "</td>";
return $Result;
}

?>