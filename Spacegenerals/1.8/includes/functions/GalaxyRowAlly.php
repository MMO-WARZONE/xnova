<?php

/**
 * GalaxyRowAlly.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyRowAlly ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user;

	// Alliances
	$Result  = "<th width=80>";
	if ($GalaxyRowUser['ally_id'] && $GalaxyRowUser['ally_id'] != 0) {
		$allyquery = doquery("SELECT * FROM {{table}} WHERE id=" . $GalaxyRowUser['ally_id'], "alliance", true);
		if ($allyquery) {
			$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=" . $allyquery['id'] . ";", "users", true);
			
			#############################
			# Pakt der Ally SQL Abfrage #
			#############################
			
			$ally_pakt_query = doquery("SELECT * FROM {{table}} WHERE".
			" `pakt_owner_id_1`='" . $user['ally_id']."' or".
			" `pakt_owner_id_2`='" . $user['ally_id']."'", "diplo");
			$color = mysql_fetch_array($ally_pakt_query);
			
			$ally_owner = doquery("SELECT `ally_owner` FROM {{table}} WHERE `id` = '". $user['ally_id'] ."'", "alliance");  
			$id_owner = mysql_fetch_array($ally_owner);
			
			
			if ($members_count[0] > 1) {
				$add = "s";
			} else {
				$add = "";
			}

			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c>".$lang['Alliance']." ". $allyquery['ally_name'] ." ".$lang['gl_with']." ". $members_count[0] ." ". $lang['gl_membre'] . $add ."</td>";
			$Result .= "</tr>";
			$Result .= "<th>";
			$Result .= "<table>";
			$Result .= "<tr>";
			$Result .= "<td><a href=alliance.php?mode=ainfo&a=". $allyquery['id'] .">".$lang['gl_ally_internal']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=stat.php?start=101&who=ally>".$lang['gl_stats']."</a></td>";
			if ($allyquery["ally_web"] != "") {
				$Result .= "</tr><tr>";
				$Result .= "<td><a href=". $allyquery["ally_web"] ." target=_new>".$lang['gl_ally_web']."</td>";
			}
			$Result .= "</tr>";
			
			#####################################################################
			# Pakt direkt durch Galaxyansicht eintragen (nur als Leader möglich #
			#####################################################################

			if(($user['id'] == $id_owner['ally_owner']) && ($allyquery['ally_name'] != $user['ally_name'])) {
				$Result .= "<tr>";
				$Result .= "<td><a href=alliance_diplo.php?add=".$allyquery['id'].">".$lang['gl_ally_diplo']."</a></td>";
				$Result .= "</tr>";
			}
			
			$Result .= "</table>";
			$Result .= "</th>";
			
			####################################
			# Die bisjetzt vorhandene Pakt art #
			####################################
			//mysql_num_rows
			$Result .= "<tr>";
			if(($allyquery['ally_name'] == $user['ally_name']) || ($allyquery['ally_name'] == $user['ally_name'])){
				$Result .= "<td class=c>".$lang['gl_ally_own']."</td>";
			}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 1)){
				$Result .= "<td class=c>".$lang['gl_ally_diplo_ally']." </td>";
			}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 2)){
				$Result .= "<td class=c>".$lang['gl_ally_diplo_peace']." </td>";
			}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 3)){
				$Result .= "<td class=c>".$lang['gl_ally_diplo_war']." </td>";
			}else{
				$Result .= "<td class=c>".$lang['gl_ally_diplo_neutral']." </td>";
			}
			$Result .= "</tr>";
			
			
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			if ($user['ally_id'] == $GalaxyRowPlayer['ally_id']) {
				$Result .= "<font color=\"#33FF00\"><span class=\"allymember\">". $allyquery['ally_tag'] ."</span></font></a>";
			} else {
					
					###############################
					# Die Einfährbung der Allyanz #
					###############################
					
					if(($allyquery['ally_name'] == $user['ally_name']) || ($allyquery['ally_name'] == $user['ally_name'])){
						$Result .= "<font color=\"#a9a9a9\">" . $allyquery['ally_tag'] ."</font></a>";
					}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 1)){
						$Result .= "<font color=\"#FF9900\">" . $allyquery['ally_tag'] ."</font></a>";
					}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 2)){
						$Result .= "<font color=\"#FFFF00\">" . $allyquery['ally_tag'] ."</font></a>";
					}elseif((($allyquery['ally_name'] == $color['pakt_name_1']) || ($allyquery['ally_name'] == $color['pakt_name_2'])) && ($color['pakt'] == 3)){
						$Result .= "<font color=\"#FF0000\">" . $allyquery['ally_tag'] ."</font></a>";
					}else{
						$Result .= $allyquery['ally_tag'] ."</a>";
					}
			}
		}
	}
	$Result .= "</th>";

	return $Result;
}
?>