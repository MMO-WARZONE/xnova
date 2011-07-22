<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = '../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('admin');
$parse = $lang;

	if ($user['authlevel'] >= 3) {

		// Borrar un item de errores
		extract($_GET);
		if (isset($delete)) {
			doquery("DELETE FROM {{table}} WHERE `error_id`=$delete", 'errors');
		} elseif ($deleteall == 'yes') {
			doquery("TRUNCATE TABLE {{table}}", 'errors');
		}

		// Lista de usuarios conectados.
		$query = doquery("SELECT * FROM {{table}}", 'errors');
		$i = 0;
		while ($e = mysql_fetch_array($query)) {
			$i++;
			$parse['errors_list'] .= "
			<tr>
				<td class=n rowspan=2>". $e['error_id'] ."</td>
				<td class=n>". $e['error_type'] ." [<a href=?delete=". $e['error_id'] .">X</a>]</td>
				<td class=n>". $e['error_sender'] ."</td>
				<td class=n>" . date('d/m/Y h:i:s', $e['error_time']) . "</td>
			</tr><tr>
				<td class=b colspan=5 width=500>" . nl2br($e['error_text']) . "</td>
			</tr>";
		}
		$parse['errors_list'] .= "<tr>
			<th class=b colspan=5>". $i ." ". $lang['adm_er_nbs'] ."</th>
		</tr>";

		display(parsetemplate(gettemplate('admin/errors_body'), $parse), "Bledy", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>