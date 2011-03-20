<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** multi.php                             **
******************************************/

define('INSIDE' , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin/multi');

		$query   = doquery("SELECT * FROM {{table}}", 'multi');

		$parse                 = $lang;
		$parse['adm_mt_table'] = "";
		$i                     = 0;

		$RowsTPL = gettemplate('admin/multi_rows');
		$PageTPL = gettemplate('admin/multi_body');

		while ($infos = mysql_fetch_assoc($query)) {
			$Bloc['player'] = $infos['player'];
			$Bloc['text']   = $infos['text'];

			$parse['adm_mt_table'] .= parsetemplate( $RowsTPL, $Bloc );
			$i++;
		}

		$parse['adm_mt_count'] = $i;

		$page = parsetemplate( $PageTPL, $parse );
		display( $page, $lang['adm_mt_title'], false, '', true);

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