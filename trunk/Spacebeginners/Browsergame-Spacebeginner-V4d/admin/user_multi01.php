<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;
if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_multi');
$parse = $lang;

extract($_GET);
if (isset($delete)) {

doquery("DELETE FROM {{table}} WHERE `declarator_name` = '".$delete."';", 'declared');
AdminMessage("Die Anmeldung von: ".$delete." wurde erfolgreich entfernt!<br><a href=\"user_multi.php\">Zur&uuml;ck</a>.","Nachricht");

} elseif ($deleteall == 'yes') {
doquery("TRUNCATE TABLE {{table}}", 'declared');
}
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>