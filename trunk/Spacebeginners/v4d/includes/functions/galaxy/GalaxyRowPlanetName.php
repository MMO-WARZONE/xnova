<?php

/**
  * GalaxyRowPlanetName.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $user, $HavePhalanx, $CurrentSystem, $CurrentGalaxy;

    $Result  = "<td align='center' style='white-space: nowrap; width:150px; height:30px; font-size:100%;'>";

    if ($GalaxyRowUser['ally_id'] == $user['ally_id'] AND
        $GalaxyRowUser['id']      != $user['id']      AND
        $user['ally_id']          != '') {
        $TextColor = "<font color=\"#33B200\"><b>";
        $EndColor  = "</b></font>";
    } elseif ($GalaxyRowUser['id'] == $user['id']) {
        $TextColor = "<font color=\"#00FF00\"><b>";
        $EndColor  = "</b></font>";
    } else {
        $TextColor = "<b>";
        $EndColor  = "</b>";
    }

    if ($GalaxyRowPlanet['last_update'] > (time()-59 * 60) AND
        $GalaxyRowUser['id'] != $user['id']) {
        $Inactivity = pretty_time_hour(time() - $GalaxyRowPlanet['last_update']);
    }

    if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0) {

        if ($HavePhalanx <> 0) {

            if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
                $Range = GetPhalanxRange ( $HavePhalanx );

                if ($CurrentGalaxy + $Range <= $CurrentSystem AND
                    $CurrentSystem >= $CurrentGalaxy - $Range) {
                    $PhalanxTypeLink = "<a href=# onclick=fenster(&#039;phalanx.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&#039;) >".$GalaxyRowPlanet['name']."</a>";
                } else {
                    $PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
                }
            } else {
                $PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
            }
        } else {
            $PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
        }

        $Result .= $TextColor . $PhalanxTypeLink . $EndColor;

    } elseif ($GalaxyRowPlanet["destruyed"] != 0) {
        $Result .= $lang['gl_destroyedplanet'];
    }

    $Result .= "</td>";
    return $Result;
}
?>