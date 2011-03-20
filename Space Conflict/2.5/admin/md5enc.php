<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** md5enc.php                            **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "1") {
		includeLang('admin/md5enc');

		$parse   = $lang;

		if ($_POST['md5q'] != "") {
			$parse['md5_md5'] = $_POST['md5q'];
			$parse['md5_enc'] = md5 ($_POST['md5q']);
		} else {
			$parse['md5_md5'] = "";
			$parse['md5_enc'] = md5 ("");
		}

		$PageTpl = gettemplate("admin/md5enc");
		$Page    = parsetemplate( $PageTpl, $parse);

		display( $Page, $lang['md5_title'], false, '', true );
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