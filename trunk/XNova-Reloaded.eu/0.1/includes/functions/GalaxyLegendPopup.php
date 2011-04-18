<?php

/**
 * GalaxyLegendPopup.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyLegendPopup () {
	global $lang;

	$Result  = "<a href=# style=\"cursor: pointer;\"";
	$Result .= " onmouseover='return overlib(\"";

	$Result .= "<table width=160>";
	$Result .= "<tr>";
	$Result .= "<td class=c colspan=2>".$lang['Legend']."</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=#ff7168>".$lang['normal_player']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=red>".$lang['Strong_player']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=#276fb7>".$lang['Weak_player']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=#96b9dc>".$lang['Way_vacation']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=#b7b7b7>".$lang['Pendent_user']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=yellow>".$lang['Inactive']."</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=red>Admin</font></td><td><font color=red>A</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=green>Game Operator</font></td><td><font color=green>GO</font></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td><font color=orange>Super GameOperator</font></td><td><font color=orange>SGO</font></td>";
	$Result .= "</tr>";
	$Result .= "</table>";
	$Result .= "\", STICKY, MOUSEOFF, OFFSETX, -80, OFFSETY, -80 );' onmouseout='return nd();'>";
	$Result .= $lang['Legend']."</a>";




	return $Result;
}

?>