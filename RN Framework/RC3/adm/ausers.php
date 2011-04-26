<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] >= "2") {

	$parse = $lang;
	$query = doquery("SELECT * FROM {{table}} ORDER BY id ASC", "users_valid");
	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b>" . $u['id'] . "</center></b></td>"
		. "<td class=b><center><b>" . $u['username'] . "</center></b></td>"
		. "<td class=b><center><b><nobr>" . date("d.m.Y H:i:s",$u['date']) . "</nobr></center></b></td>"
		. "<td class=b><center><b>" . $u['email'] . "</center></b></td>"
		. "<td class=b><center><b>" . $u['ip'] . "</center></b></td>"
		. "<td class=b align=\"center\"><a href=\"#\" onclick=\"javascript:window.open('../index.php?page=reg&mode=valid&pseudo=" . $u['username'] . "&clef=" . $u['cle'] . "&admin=1',this.target,'width=650,height=200,resizable=0,status=0,menubar=0,location=0,directories=0,toolbar=0,copyhistory=0,scrollbars=0');\">Aktivieren</a></td>"
		. "<td class=b align=\"center\"><a href='?action=delete&id=".$u['id'] ."' onclick=\"return confirm('Bist du sicher, dass du den User " . $u['username'] . " entfernen willst?');\"><img border=\"0\" src=\"../styles/images/r1.png\"></a></td>"
		. "</tr>";
		$i++;
	}
	$parse['planetes'] .= "<tr><th class=\"b\" colspan=\"8\">Insgesamt {$i} nicht aktivierte User vorhanden</th></tr>";

	if(($_GET['action'] == 'delete') && isset($_GET['id'])) {
		doquery("DELETE FROM {{table}} WHERE `id` = '".$_GET['id']."' LIMIT 1;", "users_valid");
		header("location:ausers.php");
	}
	display(parsetemplate(gettemplate('adm/auser_body'), $parse), false, '', true, false);
} else {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>