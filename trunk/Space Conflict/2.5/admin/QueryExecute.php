<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** QueryExecute.php                      **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "1") {
		includeLang('admin/Queries');

		$parse   = $lang;

		if ($_POST['really_do_it'] == 'on') {

			mysql_query ($_POST['qry_sql']);
			AdminMessage ($lang['qry_succesful'], 'Succes', '?');
			
		} else {

		}
		
		$PageTpl = gettemplate("admin/exec_query");
		$Page    = parsetemplate( $PageTpl, $parse);

		display( $Page, $lang['qry_title'], false, '', true );
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