<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** changepassword.php                    **
******************************************/

define('INSIDE', true);
define('INSTALL' , false);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
includeLang('changepassword');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

$checkurl = $_GET['checkID'];
$nwpwd = $_POST['newpwd'];
$isexist = doquery("SELECT `passwdurl` FROM {{table}} WHERE `passwdurl` = '".$checkurl."' LIMIT 1;", 'users', true);
if($isexist){
	$query = doquery("SELECT * FROM {{table}} WHERE `passwdurl` = '".$checkurl."'", 'users');
	$userdata = mysql_fetch_array($query);
	if($nwpwd != ""){
		$md5newPassword = md5($nwpwd);
		
		doquery("UPDATE {{table}} SET `password` = '".$md5newPassword."', `passwdurl` = '0' WHERE `id` = '".$userdata['id']."' LIMIT 1;", 'users');

		message($lang['sucess'], $lang['all_done'], "login.php", 2);
	}else{
	$parse['check_id'] = $checkurl;
	$parse['changepw_title'] = $lang['changepw_title'];
	$parse['change_passwd'] = $lang['change_passwd']."for user '".$userdata['username']."'";
	$parse['new_passwd'] = $lang['new_passwd'];
	$parse['pwd_change'] = $lang['pwd_change'];
	
	$PageTpl = gettemplate("changepassword");
	$Page    = parsetemplate($PageTpl, $parse);

	display($Page, $lang['change_password'],false);
	}
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>