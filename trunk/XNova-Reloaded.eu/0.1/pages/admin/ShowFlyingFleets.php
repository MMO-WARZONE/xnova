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

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	includeLang('admin/fleets');
	$PageTPL            = gettemplate('admin/fleet_body');

	$parse              = $lang;
	$parse['flt_table'] = BuildFlyingFleetTable ();

	$page               = parsetemplate( $PageTPL, $parse );
	display ( $page, $lang['flt_title'], false, '', true);
?>