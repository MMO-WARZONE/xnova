<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 3 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_unbann');    

$parse = $lang;
$mode = $_GET['mode'];

if ($mode != 'change') {
$parse['Name'] = "Name des Spielers";
} elseif ($mode == 'change') {
$nam = $_POST['nam'];
doquery("DELETE FROM {{table}} WHERE who2='{$nam}'", 'banned');
doquery("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='{$nam}'", "users");
AdminMessage("Der User {$nam} wurde endsperrt!", 'Information');
}

display(parsetemplate(gettemplate('admin/user/user_unbann'), $parse), "Overview", false, '', true);
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>