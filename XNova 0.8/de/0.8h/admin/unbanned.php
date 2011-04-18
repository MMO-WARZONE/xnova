<?php

/**
 * unbanned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 * überarbeitet by kleinerzwerg
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= "2") {

		$parse['dpath'] = $dpath;
		$parse = $lang;

		$mode = $_GET['mode'];

		if ($mode != 'change') {
			$parse['Name'] = "Namen des Spielers";
		} elseif ($mode == 'change') {
			$nam = $_POST['nam'];
			doquery("DELETE FROM {{table}} WHERE who2='{$nam}'", 'banned');
			doquery("UPDATE {{table}} SET bana=0, urlaubs_modus=0, banaday=0 WHERE username='{$nam}'", "users");
			message("Der Spieler{$nam} wurde entbannet!", 'Information');
		}

		display(parsetemplate(gettemplate('admin/unbanned'), $parse), "Overview", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>