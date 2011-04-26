<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

	if ($user['authlevel'] >= "2") {
    $parse = $lang;

		$mode = $_GET['mode'];
		if ($mode != 'change') {
		} elseif ($mode == 'change') {
			$nam = $_POST['nam'];
			$yeni = $_POST['yeni'];
			doquery("UPDATE {{table}} SET `ally_tag` = '{$yeni}' , `ally_name` = '{$yeni}' WHERE ally_tag='{$nam}'", "alliance");
					message( $lang['ittiismidegis'], "onlineusers.php" );
		}
		
		display( parsetemplate(gettemplate("adm/alliancename"), $parse), false, '', true, false);
	} 
?>