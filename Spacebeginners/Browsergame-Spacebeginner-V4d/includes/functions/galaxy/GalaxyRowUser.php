<?php

/**
  * GalaxyRowUser.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowUser ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $user, $game_config, $pirat;

    if ($game_config['angriffszone'] == 1) {  // Anfang Angriffszone
        $Result = "<td style='width:150px; height:30px;' align='center'>";

        if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
            $EigeneAZ  = $user['angriffszone'];
            $GegnerAZ  = $GalaxyRowUser['angriffszone'];

            if ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['bana'] == 1 AND $GalaxyRowUser['urlaubs_modus'] == 1) {
                $Systemtatus2 = "<font color=\"#FF00FF\"> ".$lang['gala']['5000']."".$lang['gala']['0551']." ".$lang['gala']['5004']." ".$lang['gala']['0550']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#FF00FF\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['bana'] == 1) {
                $Systemtatus2 = "<font color=\"#FF00FF\"> ".$lang['gala']['5000']."".$lang['gala']['0551']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#FF00FF\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['urlaubs_modus'] == 1) {
                $Systemtatus2 = "<font color=\"#FFFF00\"> ".$lang['gala']['5000']."".$lang['gala']['0550']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#FFFF00\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['id'] != in_array ($user['id'],$pirat) AND $GalaxyRowUser['onlinetime'] < (time()-604800) AND $GalaxyRowUser['onlinetime'] > (time()-2419200)) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#FFFF00\">";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['id'] != in_array ($user['id'],$pirat) AND $GalaxyRowUser['onlinetime'] < (time()-2419200)) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#FFD700\">";
            } elseif (($EigeneAZ + AZ_ABSTAND) < $GegnerAZ) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#660000\">";
            } elseif (($EigeneAZ - AZ_ABSTAND) > $GegnerAZ) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#00FF00\">";
            } else {
                $Systemtatus2 = "";
                $Systemtatus = "<font color=\"#FFFFFF\">";
            }

            $Systemtatus4 = "".$lang['gala']['0521']."".$lang['gala']['5002']." " . $GalaxyRowUser['angriffszone'];

            $Systemtatus7 = "";
            if ($GalaxyRowUser['authlevel'] == 3) {
                $Systemtatus7 = " <font color=\"#FF0000\"><b> ".$lang['gala']['5000']."".$lang['gala']['0501']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus8 = "";
            if ($GalaxyRowUser['authlevel'] == 2) {
                $Systemtatus8 = " <font color=\"#FF7F00\"><b> ".$lang['gala']['5000']."".$lang['gala']['0502']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus9 = "";
            if ($GalaxyRowUser['authlevel'] == 1) {
                $Systemtatus9 = " <font color=\"#E5E500\"><b> ".$lang['gala']['5000']."".$lang['gala']['0503']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus3 = "";
            if ($GalaxyRowUser['authlevel'] == 0) {
                $Systemtatus3 = $GalaxyRowUser['username'];
            }

            $Systemtart = $User2Points['total_rank'];
            if (strlen($Systemtart) < 3) {
                $Systemtart = 1;
            } else {
                $Systemtart = (floor( $User2Points['total_rank'] / 100 ) * 100) + 1;
            }

            $Result .= "<a style=\"cursor: pointer;\"";
            $Result .= " onmouseover='return overlib(\"";
            $Result .= "<table width=270px cellspacing=0px>";
            $Result .= "<tr><td class=c align=center width=100% colspan=2>".$lang['gala']['0504']."</td></tr>";
            $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0505']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=messages.php?mode=write&amp;id=".$GalaxyRowUser['id'].">  ".$GalaxyRowUser['username']."            </a></td></tr>";

            if ($GalaxyRowUser['id'] != $user['id']) {
                $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0520']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=stat.php?who=player&amp;start=".$Systemtart.">            ".$Systemtatus4."                     </a></td></tr>";
                $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0508']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=buddy.php?mode=2&amp;u=".$GalaxyRowUser['id'].">          ".$lang['gala']['0507']."             </a></td></tr>";
            }

            $Result .= "</table>\"";
            $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
            $Result .= " onmouseout='return nd();'>";

            $Result .= $Systemtatus;
            $Result .= $GalaxyRowUser["username"]."</font></a>";
            $Result .= $Systemtatus6;
            $Result .= $Systemtatus2;
            $Result .= $Systemtatus7." ".$admin;
            $Result .= $Systemtatus8." ".$sgo;
            $Result .= $Systemtatus9." ".$go;

        }
        $Result .= "</td>";
    }  // Ende Angriffszone
        else
    {  // Anfang Ogame-Noobschutz
        $Result = "<td style='width:150px; height:30px;' align='center'>";

        if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
            $NoobProt    = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotection';",      'config', true);
            $NoobTime    = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectiontime';",  'config', true);
            $NoobMulti   = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectionmulti';", 'config', true);
            $UserPoints  = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);
            $User2Points = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowUser['id'] ."';", 'statpoints', true);
            $CurrentPoints = $UserPoints['total_points'];
            $RowUserPoints = $User2Points['total_points'];
            $CurrentLevel = $CurrentPoints * $NoobMulti['config_value'];
            $RowUserLevel = $RowUserPoints * $NoobMulti['config_value'];

            if ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['bana'] == 1 AND $GalaxyRowUser['urlaubs_modus'] == 1) {
                $Systemtatus2 = "<font color=\"#FF00FF\"> ".$lang['gala']['5000']."".$lang['gala']['0551']." ".$lang['gala']['5004']." ".$lang['gala']['0550']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#FF00FF\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['bana'] == 1) {
                $Systemtatus2 = "<font color=\"#FF00FF\"> ".$lang['gala']['5000']."".$lang['gala']['0551']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#FF00FF\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $GalaxyRowUser['urlaubs_modus'] == 1) {
                $Systemtatus2 = "<font color=\"#0000FF\"> ".$lang['gala']['5000']."".$lang['gala']['0550']."".$lang['gala']['5001']." </font>";
                $Systemtatus  = "<font color=\"#0000FF\"> ";
            } elseif ($GalaxyRowUser['authlevel'] < 1 and $GalaxyRowUser['id']!= in_array ($user['id'],$pirat) AND $GalaxyRowUser['onlinetime'] < (time()-604800) AND $GalaxyRowUser['onlinetime'] > (time()-2419200)) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#FFFF00\">";
            } elseif ($GalaxyRowUser['authlevel'] < 1 and $GalaxyRowUser['id']!= in_array ($user['id'],$pirat)  AND $GalaxyRowUser['onlinetime'] < (time()-2419200)) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#FFD700\">";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $RowUserLevel < $CurrentPoints AND $NoobProt['config_value'] == 1 AND $NoobTime['config_value'] * 1000 > $RowUserPoints) {
                $Systemtatus2 = "";
                $Systemtatus =  "<font color=\"#00FF00\">";
            } elseif ($GalaxyRowUser['authlevel'] < 1 AND $RowUserPoints > $CurrentLevel AND $NoobProt['config_value'] == 1 AND $NoobTime['config_value'] * 1000 > $CurrentPoints) {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#660000\">";
            } else {
                $Systemtatus2 = "";
                $Systemtatus  = "<font color=\"#FFFFFF\">";
            }

            $Systemtatus4 = $User2Points['total_rank'];

            if ($Systemtatus2 != '') {
                $Systemtatus6 = "";
                $Systemtatus7 = "";
            }

            $Systemtatus7 = "";
            if ($GalaxyRowUser['authlevel'] == 3) {
                $Systemtatus7 = " <font color=\"#FF0000\"><b> ".$lang['gala']['5000']."".$lang['gala']['0501']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus8 = "";
            if ($GalaxyRowUser['authlevel'] == 2) {
                $Systemtatus8 = " <font color=\"#FF7F00\"><b> ".$lang['gala']['5000']."".$lang['gala']['0502']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus9 = "";
            if ($GalaxyRowUser['authlevel'] == 1) {
                $Systemtatus9 = " <font color=\"#E5E500\"><b> ".$lang['gala']['5000']."".$lang['gala']['0503']."".$lang['gala']['5001']." </b></font>";
            }

            $Systemtatus3 = "";
            if ($GalaxyRowUser['authlevel'] == 0) {
                $Systemtatus3 = $GalaxyRowUser['username'];
            }

            $Systemtart = $User2Points['total_rank'];
            if (strlen($Systemtart) < 3) {
                $Systemtart = 1;
            } else {
                $Systemtart = (floor( $User2Points['total_rank'] / 100 ) * 100) + 1;
            }

            $Result .= "<a style=\"cursor: pointer;\"";
            $Result .= " onmouseover='return overlib(\"";
            $Result .= "<table width=270px cellspacing=0px>";
            $Result .= "<tr><td class=c align=center width=100% colspan=2>".$lang['gala']['0504']."</td></tr>";
            $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0505']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=messages.php?mode=write&amp;id=".$GalaxyRowUser['id'].">  ".$GalaxyRowUser['username']."            </a></td></tr>";

            if ($GalaxyRowUser['id'] != $user['id']) {
                $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0506']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=stat.php?who=player&amp;start=".$Systemtart.">            ".$Systemtatus4."                     </a></td></tr>";
                $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0508']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=buddy.php?mode=2&amp;u=".$GalaxyRowUser['id'].">          ".$lang['gala']['0507']."             </a></td></tr>";
            }

            $Result .= "</table>\"";
            $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
            $Result .= " onmouseout='return nd();'>";

            $Result .= $Systemtatus;
            $Result .= $GalaxyRowUser["username"]."</font></a>";
            $Result .= $Systemtatus6;
            $Result .= $Systemtatus2;
            $Result .= $Systemtatus7." ".$admin;
            $Result .= $Systemtatus8." ".$sgo;
            $Result .= $Systemtatus9." ".$go;
        }
        $Result .= "</td>";
    }  // Ende Ogame-Noobschutz

return $Result;
}

?>