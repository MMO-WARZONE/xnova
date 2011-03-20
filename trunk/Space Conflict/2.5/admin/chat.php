<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** chat.php                              **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('admin');
$parse = $lang;

	if ($user['authlevel'] >= 3) {

		extract($_GET);
		if (isset($delete)) {
			doquery("DELETE FROM {{table}} WHERE `messageid`=$delete", 'chat');
		} elseif ($deleteall == 'yes') {
			doquery("DELETE FROM {{table}}", 'chat');
		}

		$query = doquery("SELECT * FROM {{table}} ORDER BY messageid DESC LIMIT 25", 'chat');
		$i = 0;
		while ($e = mysql_fetch_array($query)) {
			$i++;
			$parse['msg_list'] .= stripslashes("<tr><th class=b>" . date('h:i:s', $e['timestamp']) . "</th>".
			"<th class=b>". $e['user'] . "</th>".
			"<td class=b>" . nl2br($e['message']) . "</td>".
			"<th class=b><a href=?delete=".$e['messageid']."><img src=\"../images/r1.png\" border=\"0\"></a></th></tr>");
		}
		$parse['msg_list'] .= "<tr><th class=b colspan=4>{$i} ".$lang['adm_ch_nbs']."</th></tr>";

		display(parsetemplate(gettemplate('admin/chat_body'), $parse), "Chat", false, '', true);

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