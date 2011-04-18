<?php

/**
 * planetlist.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= "2") {
	includeLang('admin');

		$parse = $lang;
		$query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE planet_type='1'");
		$i = 0;
		while ($u = $query->fetch()) {
			$parse['planetes'] .= "<tr>\n"
			. "<td class=b><center><b>" . $u[0] . "</b></center></td>\n"
			. "<td class=b><center><b>" . $u[2] . "</b></center></td>\n"
			. "<td class=b><center><b>" . $u[1] . "</b></center></td>\n"
			. "<td class=b><center><b>" . $u[4] . "</b></center></td>\n"
			. "<td class=b><center><b>" . $u[5] . "</b></center></td>\n"
			. "<td class=b><center><b>" . $u[6] . "</b></center></td>\n"
			. "</tr>\n";
			$i++;
		}

		if ($i == "1")
			$parse['planetes'] .= "<tr>\n<th class=b colspan=6>".$lang['adm_planetlist_only_one']."</th>\n</tr>\n";
		else
			$parse['planetes'] .= "<tr>\n<th class=b colspan=6>".$lang['adm_planetlist_planets']." {$i} ".$lang['adm_planetlist_planets2']."</th>\n</tr>\n";

		display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), 'Planetlist', false, '', true);
	} else {
		header('Location: indexGame.php');
	}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>