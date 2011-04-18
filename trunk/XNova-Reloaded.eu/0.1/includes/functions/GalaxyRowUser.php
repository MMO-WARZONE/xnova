<?php

/**
 * GalaxyRowUser.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyRowUser ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user;

	// Joueur
	$Result  = "<th width=150>";
	if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
		$EigeneAZ  = $user['angriffszone'];
		$GegnerAZ  = $GalaxyRowUser['angriffszone'];
		if	($GalaxyRowUser['bana'] == 1 AND
			$GalaxyRowUser['urlaubs_modus'] == 1) {
			$Systemtatus = "<font color=\"#b7b7b7\">".$GalaxyRowUser['username']."</font>";
		} elseif ($GalaxyRowUser['bana'] == 1) {
			$Systemtatus = "<font color=\"#b7b7b7\">".$GalaxyRowUser['username']."</font>";
		} elseif ($GalaxyRowUser['urlaubs_modus'] == 1) {
			$Systemtatus = "<font color=\"#96b9dc\">".$GalaxyRowUser['username']."</font>";
		} elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 7) AND
				  $GalaxyRowUser['onlinetime'] > (time()-60 * 60 * 24 * 28)) {
			$Systemtatus = "<font color=\"yellow\">".$GalaxyRowUser['username']."</font>";
		} 
		elseif (($EigeneAZ + AZ_ABSTAND) < $GegnerAZ) 
		{
		$Systemtatus = "<font color=\"red\">".$GalaxyRowUser['username']."</font>";
		}
		elseif (($EigeneAZ - AZ_ABSTAND) > $GegnerAZ) 
		{
		$Systemtatus = "<font color=\"#276fb7\">".$GalaxyRowUser['username']."</font>";
		} else {
			$Systemtatus = "<font color=\"#ff7168\">".$GalaxyRowUser['username']."</font>";
		}
		$Systemtatus4 = $User2Points['total_rank'];
		
		$admin = "";
		if ($GalaxyRowUser['authlevel'] == 3) {
			$admin = "<font color=\"red\"> A</font>";
		}
		$sgo = "";
		if ($GalaxyRowUser['authlevel'] == 2) {
			$sgo = "<font color=\"orange\"> SGo</font>";
		}
		$go = "";
		if ($GalaxyRowUser['authlevel'] == 1) {
			$go = "<font color=\"green\"> Go</font>";
		}
		
		if ($GalaxyRowUser['authlevel'] == 3) {
			$Systemtatus = "<font color=\"red\">".$GalaxyRowUser['username']."</font>";
		}
		
		if ($GalaxyRowUser['authlevel'] == 2) {
			$Systemtatus = "<font color=\"orange\">".$GalaxyRowUser['username']."</font>";
		}
		if ($GalaxyRowUser['authlevel'] == 1) {
			$Systemtatus = "<font color=\"green\">".$GalaxyRowUser['username']."</font>";
		}
		$Systemtart = $User2Points['total_rank'];
		if (strlen($Systemtart) < 3) {
			$Systemtart = 1;
		} else {
			$Systemtart = (floor( $User2Points['total_rank'] / 100 ) * 100) + 1;
		}
		$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table width=190>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>".$lang['Player']." ".$GalaxyRowUser['username']." ".$lang['Place']." ".$Systemtatus4."</td>";
		$Result .= "</tr><tr>";
		if ($GalaxyRowUser['id'] != $user['id']) {
			$Result .= "<td><a href=?action=internalMessages&amp;mode=write&amp;id=".$GalaxyRowUser['id'].">".$lang['gl_sendmess']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=?action=internalBuddy&amp;a=2&amp;u=".$GalaxyRowUser['id'].">".$lang['gl_buddyreq']."</a></td>";
			$Result .= "</tr><tr>";
		}
		$Result .= "<td><a href=?action=internalStats&amp;who=player&amp;start=".$Systemtart.">".$lang['gl_stats']."</a></td>";
		$Result .= "</tr>";
		$Result .= "</table>\"";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		$Result .= $Systemtatus;
		$Result .= $admin;
		$Result .= $sgo;
		$Result .= $go;
		$Result .= "</span></a>";
	}
	$Result .= "</th>";

	return $Result;
}

?>