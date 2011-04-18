<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_bann');

$mode      = $_POST['mode'];
$PageTpl   = gettemplate("admin/user/user_bann");

$parse     = $lang;
if ($mode == 'banit') {
$name              = $_POST['name'];
$reas              = $_POST['why'];
$days              = $_POST['days'];
$hour              = $_POST['hour'];
$mins              = $_POST['mins'];
$secs              = $_POST['secs'];

$admin             = $user['username'];
$mail              = $user['email'];

$Now               = time();
$BanTime           = $days * 86400;
$BanTime          += $hour * 3600;
$BanTime          += $mins * 60;
$BanTime          += $secs;
$BannedUntil       = $Now + $BanTime;

$QryInsertBan      = "INSERT INTO {{table}} SET ";
$QryInsertBan     .= "`who` = \"". $name ."\", ";
$QryInsertBan     .= "`theme` = '". $reas ."', ";
$QryInsertBan     .= "`who2` = '". $name ."', ";
$QryInsertBan     .= "`time` = '". $Now ."', ";
$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
$QryInsertBan     .= "`author` = '". $admin ."', ";
$QryInsertBan     .= "`email` = '". $mail ."';";
doquery( $QryInsertBan, 'banned');

$QryUpdateUser     = "UPDATE {{table}} SET ";
$QryUpdateUser    .= "`bana` = '1', ";
$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."' ";
$QryUpdateUser    .= "WHERE ";
$QryUpdateUser    .= "`username` = \"". $name ."\";";
doquery( $QryUpdateUser, 'users');

$PunishThePlanets     = "UPDATE {{table}} SET ";
$PunishThePlanets    .= "`metal_mine_porcent` = '0', ";
$PunishThePlanets    .= "`crystal_mine_porcent` = '0', ";
$PunishThePlanets    .= "`deuterium_sintetizer_porcent` = '0'";
$PunishThePlanets    .= "WHERE ";
$PunishThePlanets    .= "`id_owner` = \"". $GetUserData['id'] ."\";";
doquery( $PunishThePlanets, 'planets');

$DoneMessage       = $lang['adm_bn_thpl'] ." ". $name ." ". $lang['adm_bn_isbn'];
AdminMessage ($DoneMessage, $lang['adm_bn_ttle']);
}

$Page = parsetemplate($PageTpl, $parse);
display( $Page, $lang['adm_bn_ttle'], false, '', true);
} else {
AdminMessage ($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

?>