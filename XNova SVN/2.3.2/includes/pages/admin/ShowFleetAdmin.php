<?php
//version 1


function ShowFleetAdmin($user){
    global $lang,$svn_root,$phpEx,$displays;
include($svn_root . 'includes/functions/classes/class.FlyingFleetsTable.' . $phpEx);

if ($user['authlevel'] < 1){ die($displays->message ($lang['not_enough_permissions']));}
        $displays->assignContent("adm/fleet_body");
	$FlyingFleetsTable  = new FlyingFleetsTable();
	$flota = $FlyingFleetsTable->BuildFlyingFleetTable();
	$displays->assign('flt_table',$flota["flt_table"]);

	$displays->display();
}
?>