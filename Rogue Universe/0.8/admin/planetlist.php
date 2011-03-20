<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "2") {

		$parse = $lang;
		$query = doquery("SELECT * FROM {{table}} WHERE planet_type='1'", "planets");
		$i = 0;
		while ($u = mysql_fetch_array($query)) {
			$parse['planetes'] .= "<tr>"
			. "<td class=b><center><b>" . $u[0] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[1] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[4] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[5] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[6] . "</center></b></td>"
			. "</tr>";
			$i++;
		}

		if ($i == "1")
			$parse['planetes'] .= "<tr><th class=b colspan=5>Planet list</th></tr>";
		else
			$parse['planetes'] .= "<tr><th class=b colspan=5>Planet list</th></tr>";

		display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), 'Planetlist', false, '', true);
	} else {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

?>