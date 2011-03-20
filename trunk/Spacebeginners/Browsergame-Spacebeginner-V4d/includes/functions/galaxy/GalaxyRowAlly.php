<?php

/**
  * GalaxyRowAlly.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowAlly ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $user;

    $Result  = "<td style='white-space:nowrap; width:150px;' align='center'>";
    if ($GalaxyRowUser['ally_id'] && $GalaxyRowUser['ally_id'] != 0) {
        $allyquery = doquery("SELECT * FROM {{table}} WHERE id=" . $GalaxyRowUser['ally_id'], "alliance", true);

        if ($allyquery) {
            $members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=" . $allyquery['id'] . ";", "users", true);

            if ($members_count[0] > 1) {
                $add = "s";
            } else {
                $add = "";
            }

            $Result .= "<a style=\"cursor: pointer;\"";
            $Result .= " onmouseover='return overlib(\"";
            $Result .= "<table width=270px cellspacing=0px>";
            $Result .= "<tr><td class=c align=center width=100% colspan=2>".$lang['gala']['0601']."</td></tr>";
            $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0602']."".$lang['gala']['5002']."</td><td class=c align=center width=50%><a href=alliance.php?mode=ainfo&amp;a=". $allyquery['id'] .">". htmlspecialchars($allyquery['ally_name'], ENT_QUOTES) ."</a></td></tr>";
            $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0603']."".$lang['gala']['5002']."</td><td class=c align=center width=50%>". $members_count[0] ."</td></tr>";

            $Result .= "</table>\"";
            $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
            $Result .= " onmouseout='return nd();'>";

            if ($user['ally_id'] == $GalaxyRowPlayer['ally_id']) {
                $Result .= "<span class=\"allymember\">". $allyquery['ally_tag'] ."</span></a>";
            } else {
                $Result .= $allyquery['ally_tag'] ."</a>";
            }
        }
    }
    $Result .= "</td>";
    return $Result;
}

?>