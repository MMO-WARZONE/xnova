<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** unbanned.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "2") {

		$parse['dpath'] = $dpath;
		$parse = $lang;

		$mode = $_GET['mode'];

		if ($mode != 'change') {
			$parse['Name'] = "Name of Player";
		} elseif ($mode == 'change') {
			$nam = $_POST['nam'];
			doquery("DELETE FROM {{table}} WHERE who2='{$nam}'", 'banned');
			doquery("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='{$nam}'", "users");
			message("Le joueur {$nam} a bien &eacute;t&eacute; d&eacute;banni!", 'Information');
		}

		display(parsetemplate(gettemplate('admin/unbanned'), $parse), "Overview", false, '', true);
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