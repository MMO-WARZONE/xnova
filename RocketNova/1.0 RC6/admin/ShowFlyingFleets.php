<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

if($user['authlevel']!="4" && $user['authlevel']!="1"){message("Du hast keine Befugnisse diese Seite aufzurufen", "Fehler");}

	includeLang('admin/fleets');
	$PageTPL            = gettemplate('admin/fleet_body');

	$parse              = $lang;
	$parse['flt_table'] = BuildFlyingFleetTable ();

	$page               = parsetemplate( $PageTPL, $parse );
	display ( $page, $lang['flt_title'], false, '', true);
?>