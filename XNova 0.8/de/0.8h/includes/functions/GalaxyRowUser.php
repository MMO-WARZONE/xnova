<?php

/**
 * GalaxyRowUser.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyRowUser ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $game_config, $lang, $user;

	// Joueur
	$Result  = "<th width=150>";
	if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
$NoobTime = $game_config['noobprotectiontime'];
$NoobMulti = $game_config['noobprotectionmulti'];
		$UserPoints    = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);
		$User2Points   = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowUser['id'] ."';", 'statpoints', true);
		$CurrentPoints = $UserPoints['total_points'];
		$RowUserPoints = $User2Points['total_points'];
		$CurrentLevel  = $CurrentPoints * $NoobMulti['config_value'];
		$RowUserLevel  = $RowUserPoints * $NoobMulti['config_value'];
		if       ($GalaxyRowUser['bana'] == 1 AND
				  $GalaxyRowUser['urlaubs_modus'] == 1) {
			$Systemtatus2 = $lang['vacation_shortcut']." <a href=\"banned.php\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
			$Systemtatus  = "<span class=\"vacation\">";
		} elseif ($GalaxyRowUser['bana'] == 1) {
			$Systemtatus2 = "<a href=\"banned.php\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
			$Systemtatus  = "";
		} elseif ($GalaxyRowUser['urlaubs_modus'] == 1) {
			$Systemtatus2 = "<span class=\"vacation\">".$lang['vacation_shortcut']."</span>";
			$Systemtatus  = "<span class=\"vacation\">";
		} elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 7) AND
				  $GalaxyRowUser['onlinetime'] > (time()-60 * 60 * 24 * 28)) {
			$Systemtatus2 = "<span class=\"inactive\">".$lang['inactif_7_shortcut']."</span>";
			$Systemtatus  = "<span class=\"inactive\">";
		} elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 28)) {
			$Systemtatus2 = "<span class=\"inactive\">".$lang['inactif_7_shortcut']."</span><span class=\"longinactive\"> ".$lang['inactif_28_shortcut']."</span>";
			$Systemtatus  = "<span class=\"longinactive\">";
		} elseif ($RowUserLevel < $CurrentPoints AND
				  $NoobMulti['config_value'] > 0) {
			$Systemtatus2 = "<span class=\"noob\">".$lang['weak_player_shortcut']."</span>";
			$Systemtatus  = "<span class=\"noob\">";
		} elseif ($RowUserPoints > $CurrentLevel AND
				  $NoobMulti['config_value'] > 0) {
			$Systemtatus2 = $lang['strong_player_shortcut'];
			$Systemtatus  = "<span class=\"strong\">";
		}elseif ($CurrentPoints > $NoobTime AND
			$RowUserPoints < $NoobTime AND
			$NoobTime > 0) {
			$Systemtatus2 = "<span class=\"noob\">".$lang['weak_player_shortcut']."</span>";
			$Systemtatus  = "<span class=\"noob\">";
		}elseif ($CurrentPoints < $NoobTime AND
			$RowUserPoints > $NoobTime AND
			$NoobTime > 0) {
			$Systemtatus2 = "<span class=\"strong\">".$lang['strong_player_shortcut']."</span>";
			$Systemtatus  = "<span class=\"strong\">";
		} else {
			$Systemtatus2 = "";
			$Systemtatus  = "";
		}


		$Systemtatus4 = $User2Points['total_rank'];
		if ($Systemtatus2 != '') {
			$Systemtatus6 = "<font color=\"white\">(</font>";
			$Systemtatus7 = "<font color=\"white\">)</font>";
		}
		if ($Systemtatus2 == '') {
			$Systemtatus6 = "";
			$Systemtatus7 = "";
		}
		$admin = "";
		if ($GalaxyRowUser['authlevel'] == 4) {
			$admin = "<font color=\"red\">A</font>";
		}
		$sgo = "";
		if ($GalaxyRowUser['authlevel'] == 3) {
			$sgo = "<font color=\"orange\">SGo</font>";
		}
		$go = "";
		if ($GalaxyRowUser['authlevel'] == 2) {
			$go = "<font color=\"green\">Go</font>";
		}
		$mod = "";
		if ($GalaxyRowUser['authlevel'] == 1) {
			$mod = "<font color=\"green\">Mod</font>";
		}
		$Systemtatus7 = "";
		if ($GalaxyRowUser['authlevel'] == 4) {
			$Systemtatus7 = "<font color=\"red\">".$GalaxyRowUser['username']."</font>";
		}
		$Systemtatus8 = "";
		if ($GalaxyRowUser['authlevel'] == 3) {
			$Systemtatus8 = "<font color=\"orange\">".$GalaxyRowUser['username']."</font>";
		}
		$Systemtatus9 = "";
		if ($GalaxyRowUser['authlevel'] == 2) {
			$Systemtatus9 = "<font color=\"green\">".$GalaxyRowUser['username']."</font>";
		}
		$Systemtatus10 = "";
		if ($GalaxyRowUser['authlevel'] == 1) {
			$Systemtatus10 = "<font color=\"green\">".$GalaxyRowUser['username']."</font>";
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
		$Result .= "<table width=190>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>".$lang['Player']." ".$GalaxyRowUser['username']." ".$lang['Place']." ".$Systemtatus4."</td>";
		$Result .= "</tr><tr>";
		if ($GalaxyRowUser['id'] != $user['id']) {
			$Result .= "<td><a href=messages.php?mode=write&id=".$GalaxyRowUser['id'].">".$lang['gl_sendmess']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=buddy.php?a=2&u=".$GalaxyRowUser['id'].">".$lang['gl_buddyreq']."</a></td>";
			$Result .= "</tr><tr>";
		}
		$Result .= "<td><a href=stat.php?who=player&start=".$Systemtart.">".$lang['gl_stats']."</a></td>";
		$Result .= "</tr>";
		$Result .= "</table>\"";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		$Result .= $Systemtatus;
		$Result .= $Systemtatus3;
		$Result .= $Systemtatus6;
		$Result .= $Systemtatus;
		$Result .= $Systemtatus2;
		$Result .= $Systemtatus7." ".$admin;
		$Result .= $Systemtatus8." ".$sgo;
		$Result .= $Systemtatus9." ".$go;
		$Result .= $Systemtatus10." ".$mod;
		$Result .= "</span></a>";
	}
	$Result .= "</th>";

	return $Result;
}

?>