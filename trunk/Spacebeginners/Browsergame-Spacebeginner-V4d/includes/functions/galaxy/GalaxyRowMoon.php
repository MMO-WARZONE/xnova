<?php

/**
  * GalaxyRowMoon.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowMoon ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $user, $dpath, $HavePhalanx, $CurrentSystem, $CurrentGalaxy, $CanDestroy;

    $Result  = "<td style='white-space: nowrap; width:30px; height:30px;' align='center'>";

    if ($GalaxyRowUser['id'] != $user['id']) {
        $MissionType6Link = "<a href=# onclick=&#039;javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$user["spio_anz"].");&#039; >            ". $lang['type_mission'][6] ."</a>";


    } elseif ($GalaxyRowUser['id'] == $user['id']) {
        $MissionType6Link = "";
    }

    if ($GalaxyRowUser['id'] != $user['id']) {
        $MissionType1Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>     ". $lang['type_mission'][1] ."</a>";
    } elseif ($GalaxyRowUser['id'] == $user['id']) {
        $MissionType1Link = "";
    }

    if ($GalaxyRowUser['id'] != $user['id']) {
        $MissionType5Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=5>     ". $lang['type_mission'][5] ."</a>";
    } elseif ($GalaxyRowUser['id'] == $user['id']) {
        $MissionType5Link = "";
    }

    if ($GalaxyRowUser['id'] == $user['id']) {
        $MissionType4Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=4>     ". $lang['type_mission'][4] ."</a>";
    } elseif ($GalaxyRowUser['id'] != $user['id']) {
        $MissionType4Link = "";
    }

    if ($GalaxyRowUser['id'] != $user['id']) {

        if ($CanDestroy > 0) {
            $MissionType9Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=9> ". $lang['type_mission'][9] ."</a>";
        } else {
            $MissionType9Link = "";
        }
    } elseif ($GalaxyRowUser['id'] == $user['id']) {
        $MissionType9Link = "";
    }

    $MissionType3Link = "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=3>         ". $lang['type_mission'][3] ."</a>";

    if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0 && $GalaxyRow["id_luna"] != 0) {


        $Result .= "<a style=\"cursor: pointer;\"";
        $Result .= " onmouseover='return overlib(\"";
        $Result .= "<table width=270px cellspacing=0px>";
        $Result .= "<tr><td class=c align=center rowspan=5 width=60px><img src=". $dpath ."planeten/". $GalaxyRowPlanet["image"] .".gif height=60px width=60px alt=mond.gif>                                                                                                                                             </td></tr>";
        $Result .= "<tr><td class=c align=left width=140px>".$lang['gala']['5003']."".$lang['gala']['0301']."".$lang['gala']['5002']." </td><td class=c align=left width=140px> ".$lang['gala']['5000']."".$Galaxy."".$lang['gala']['5003']."".$System."".$lang['gala']['5003']."".$Planet."".$lang['gala']['5001']."    </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']."".$lang['gala']['0302']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". $GalaxyRowPlanet["name"] ."                                                                                                           </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']."".$lang['gala']['0303']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". number_format($GalaxyRowPlanet['diameter'], 0, '', '.') ." ".$lang['gala']['0305']."                                                  </td></tr>";
        $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']."".$lang['gala']['0304']."".$lang['gala']['5002']." </td><td class=c align=left width=110px> ". number_format($GalaxyRowPlanet['temp_min'], 0, '', '.') ." ".$lang['gala']['0306']."                                                  </td></tr>";

        $Result .= "</table><table width=270px cellspacing=0px><tr>";

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
        $Result .= $MissionType9Link;   // Mond zerstören
        $Result .= "</td></tr> ";

        $Result .= "</table>\"";
        $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
        $Result .= " onmouseout='return nd();'>";
        $Result .= "<img src='". $dpath ."planeten/". $GalaxyRowPlanet["image"] .".gif' style='height:28px; width:28px;' alt='mond.gif'>";
        $Result .= "</a>";

    } else {

        $bild = array('mond_01.gif','mond_02.gif','mond_03.gif','mond_04.gif','mond_05.gif');
        shuffle($bild);

        $Result .= "<img src='". $dpath ."planeten/mond/".$bild[0]."' style='height:15px; width:15px;' alt='mond_01.gif'>";

    }
$Result .= "</td>";
return $Result;
}

?>