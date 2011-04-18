<?php

/**
 * moonlist.php
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
		$query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE planet_type='3'");
		$i = 0;
		while ($u = $query->fetch()) {
			$parse['moon'] .= "<tr>"
			. "<td class=b><center><b>" . $u[0] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[2] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[1] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[4] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[5] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[6] . "</center></b></td>"
			. "</tr>";
			$i++;
		}

		if ($i == "1")
			$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['adm_moonlist_only_one']."</th></tr>";
		else
			$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['adm_moonlist_moons']." {$i} ".$lang['adm_moonlist_moons2']."</th></tr>";

		display(parsetemplate(gettemplate('admin/moonlist_body'), $parse), 'Lunalist' , false, '', true);
	} else {
		header('Location: indexGame.php');
	}
?>