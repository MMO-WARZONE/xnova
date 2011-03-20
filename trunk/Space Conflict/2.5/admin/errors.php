<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** errors.php                            **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('admin');
$parse = $lang;

	if ($user['authlevel'] >= 3) {

		extract($_GET);
		if (isset($delete)) {
			doquery("DELETE FROM {{table}} WHERE `error_id`=$delete", 'errors');
		} elseif ($deleteall == 'yes') {
			doquery("TRUNCATE TABLE {{table}}", 'errors');
		}

		$query = doquery("SELECT * FROM {{table}}", 'errors');
		$i = 0;
		while ($u = mysql_fetch_array($query)) {
			$i++;
			$parse['errors_list'] .= "
			<tr><td width=\"25\" class=n>". $u['error_id'] ."</td>
			<td width=\"170\" class=n>". $u['error_type'] ."</td>
			<td width=\"230\" class=n>". date('d/m/Y h:i:s', $u['error_time']) ."</td>
			<td width=\"95\" class=n><a href=\"?delete=". $u['error_id'] ."\"><img src=\"../images/r1.png\"></a></td></tr>
			<tr><td colspan=\"4\" class=b>".  nl2br($u['error_text'])."</td></tr>";
		}
		$parse['errors_list'] .= "<tr>
			<th class=b colspan=5>". $i ." ". $lang['adm_er_nbs'] ."</th>
		</tr>";

		display(parsetemplate(gettemplate('admin/errors_body'), $parse), "Bledy", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>