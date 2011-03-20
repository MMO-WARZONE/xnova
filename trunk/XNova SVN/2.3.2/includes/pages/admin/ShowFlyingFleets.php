<?php



define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$svn_root = './../';
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.' . $phpEx);
include($svn_root . 'includes/functions/classes/class.FlyingFleetsTable.' . $phpEx);

if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

	//$parse				= $lang;
	$FlyingFleetsTable  = new FlyingFleetsTable();
	$parse['flt_table'] = $FlyingFleetsTable->BuildFlyingFleetTable();
 
	display(parsetemplate(gettemplate('adm/fleet_body'), $parse), false, '', true, false);

?>