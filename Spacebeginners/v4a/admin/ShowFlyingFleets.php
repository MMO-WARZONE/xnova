<?php

/**
 * ShowFlyingFleets.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

	if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {
		includeLang('admin/fleets');
		$PageTPL            = gettemplate('admin/fleet_body');

		$parse              = $lang;
		$parse['flt_table'] = BuildFlyingFleetTable ();

		$page               = parsetemplate( $PageTPL, $parse );
		display ( $page, $lang['flt_title'], false, '', true);

	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>