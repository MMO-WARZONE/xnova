<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_multi');

if ($_GET['cmd'] == 'dele') {
DeleteSelectedUser ( $_GET['user'] );
}
if ($_GET['cmd'] == 'sort') {
$TypeSort = $_GET['type'];
} else {
$TypeSort = "id";
}

$PageTPL = gettemplate('admin/user/user_multi01');
$RowsTPL = gettemplate('admin/user/user_multi02');

$query   = doquery("SELECT * FROM {{table}} ORDER BY `declarator` DESC", 'declared');

$parse                 = $lang;
$parse['adm_ul_table'] = "";
$i                     = 0;
$Color                 = "lime";

while ($u = mysql_fetch_assoc ($query) ) {
if ($PrevIP != "") {
if ($PrevIP == $u['declarator']) {
$Color = "red";
} else {
$Color = "lime";
} }

$Bloc['adm_ul_data_id']     = stripslashes($u['declarator_name']);
$Bloc['adm_ul_data_name']   = stripslashes($u['declarator']);
$Bloc['adm_ul_data_mail']   = stripslashes($u['declared_1']);
$Bloc['adm_ul_data_adip']   = stripslashes($u['declared_2']);
$Bloc['adm_ul_data_detai']  = stripslashes($u['declared_3']);
$Bloc['adm_ul_data_regd']   = stripslashes($u['reason']);
$parse['adm_ul_table']     .= parsetemplate( $RowsTPL, $Bloc );

$i++;
}
$parse['adm_ul_count'] = $i;

$page = parsetemplate( $PageTPL, $parse );
display( $page, "Liste des joueurs ayant declare une IP collective", false, '', true);
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>