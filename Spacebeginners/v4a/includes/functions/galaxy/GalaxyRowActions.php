<?php

/**
  * GalaxyRowActions.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowActions ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $user, $dpath, $CurrentMIP, $CurrentSystem, $CurrentGalaxy;

    $Result  = "<td style='white-space:nowrap; width:150px;' align='center'>";

    if ($GalaxyRowPlayer['id'] != $user['id']) {

        if ($CurrentMIP <> 0) {

            if ($GalaxyRowUser['id'] != $user['id']) {

                if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
                    $Range = GetMissileRange();
                    $SystemLimitMin = $CurrentSystem - $Range;

                        if ($SystemLimitMin < 1) {
                            $SystemLimitMin = 1;
                        }

                    $SystemLimitMax = $CurrentSystem + $Range;

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

        if ($GalaxyRowPlayer && $GalaxyRowPlanet["destruyed"] == 0) {

            if ($user["settings_esp"] == "1" && $GalaxyRowPlayer['id']) {
                $Result .= "<a href=\"#\" onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
                $Result .= "<img src=\"". $dpath ."img/e.gif\" alt=\"e.gif\" title=\"".$lang['gala']['0701']."\" border=\"0\"></a>";
                $Result .= "&nbsp;";
            }

            if ($user["settings_wri"] == "1" && $GalaxyRowPlayer['id']) {
                $Result .= "<a href=\"messages.php?mode=write&amp;id=".$GalaxyRowPlayer["id"]."\">";
                $Result .= "<img src=\"". $dpath ."img/m.gif\" alt=\"m.gif\" title=\"".$lang['gala']['0702']."\" border=\"0\"></a>";
                $Result .= "&nbsp;";
            }

            if ($user["settings_bud"] == "1" && $GalaxyRowPlayer['id']) {
                $Result .= "<a href=\"buddy.php?mode=2&amp;u=".$GalaxyRowPlayer['id']."\" >";
                $Result .= "<img src=\"". $dpath ."img/b.gif\" alt=\"b.gif\" title=\"".$lang['gala']['0703']."\" border=\"0\"></a>";
                $Result .= "&nbsp;";
            }

            if ($user["settings_mis"] == "1" AND $MissileBtn == true && $GalaxyRowPlayer['id']) {
                $Result .= "<a href=\"galaxy.php?mode=2&amp;galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;current=".$user['current_planet']."\" >";
                $Result .= "<img src=\"". $dpath ."img/r.gif\" alt=\"r.gif\" title=\"".$lang['gala']['0704']."\" border=\"0\"></a>";
            }
        }
    }
    $Result .= "</td>";
    return $Result;
}

?>