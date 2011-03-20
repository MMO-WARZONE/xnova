<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('admin/fleets');
	$PageTPL            = gettemplate('admin/fleet_body');

	$parse              = $lang;
	$parse['flt_table'] = BuildFlyingFleetTable ();

	$page               = parsetemplate( $PageTPL, $parse );
	display ( $page, $lang['flt_title'], false, '', true);
?>