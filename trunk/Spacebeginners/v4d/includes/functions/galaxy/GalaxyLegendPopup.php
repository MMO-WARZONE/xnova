<?php

/**
  * GalaxyLegendPopup.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyLegendPopup () {
    global $lang, $dpath;

    $Result  = "<a style=\"cursor: pointer;\"";
    $Result .= " onmouseover='return overlib(\"";

    $Result .= "<img width=100% height=12px src=".$dpath."balken/oben.png align=right alt=oben.png ><table width=350px cellspacing=0 cellpadding=0>";
    $Result .= "<tr><td colspan=2 height=12px align=center></td></tr>";
    $Result .= "<tr><td class=c colspan=2 align=center>".$lang['gala']['0801']."</td></tr>";

    // Teammitglieder
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0810']."</td><td class=c align=center width=50%>".$lang['gala']['0814']." ".$lang['gala']['5010']."".$lang['gala']['5000']."".$lang['gala']['0850']."".$lang['gala']['5001']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0811']."</td><td class=c align=center width=50%>".$lang['gala']['0814']." ".$lang['gala']['5011']."".$lang['gala']['5000']."".$lang['gala']['0851']."".$lang['gala']['5001']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0812']."</td><td class=c align=center width=50%>".$lang['gala']['0814']." ".$lang['gala']['5012']."".$lang['gala']['5000']."".$lang['gala']['0852']."".$lang['gala']['5001']."</td></tr>";

    // Schwach / Angreifbar /  Zu Stark
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0853']."</td><td class=c align=center width=50%>".$lang['gala']['5013']." ".$lang['gala']['0814']."".$lang['gala']['5030']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0854']."</td><td class=c align=center width=50%>".$lang['gala']['0814']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0855']."</td><td class=c align=center width=50%>".$lang['gala']['5014']." ".$lang['gala']['0814']."".$lang['gala']['5030']."</td></tr>";

    // Inaktive
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0856']."</td><td class=c align=center width=50%>".$lang['gala']['5015']." ".$lang['gala']['0814']."".$lang['gala']['5030']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0857']."</td><td class=c align=center width=50%>".$lang['gala']['5016']." ".$lang['gala']['0814']."".$lang['gala']['5030']."</td></tr>";

    // Urlaubsmodus / Gesperrt
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0858']."</td><td class=c align=center width=50%>".$lang['gala']['5017']." ".$lang['gala']['0814']." ".$lang['gala']['5000']."".$lang['gala']['0862']."".$lang['gala']['5001']."".$lang['gala']['5030']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0859']."</td><td class=c align=center width=50%>".$lang['gala']['5018']." ".$lang['gala']['0814']." ".$lang['gala']['5000']."".$lang['gala']['0861']."".$lang['gala']['5001']."".$lang['gala']['5030']."</td></tr>";
    $Result .= "<tr><td class=c align=left width=50%>".$lang['gala']['5003']." ".$lang['gala']['0813']." ".$lang['gala']['5003']." ".$lang['gala']['0860']."</td><td class=c align=center width=50%>".$lang['gala']['5018']." ".$lang['gala']['0814']." ".$lang['gala']['5000']."".$lang['gala']['0862']." ".$lang['gala']['5003']." ".$lang['gala']['0861']."".$lang['gala']['5001']."".$lang['gala']['5030']."</td></tr>";

    $Result .= "</table><img width=100% height=12px src=".$dpath."balken/unten.png align=right alt=unten.png >";
    $Result .= "\");' onmouseout='return nd();'>";

    $Result .= $lang['gala']['0800']."</a>";
    return $Result;
}

?>