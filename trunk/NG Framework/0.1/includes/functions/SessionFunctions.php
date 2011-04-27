<?php
/**
 * @author Pada - byhoratiss@hotmail.com
 * @package XNova.project.es
 * @version 1
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/*
LITTLE INTRO:
- There is a lot of opinions about using COOKIES or SESSION, but, i preffer SESSIONS, they r more secure,
  and you cant "be" online all the time, not w/o modifying the default session timeout, but i leave
  that to the the server devs :3
*/

if (!defined('INSIDE'))
{
	die();
}

function getIP(){
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
		if ($_SERVER["HTTP_CLIENT_IP"]) {
			$Proxy = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$Proxy = $_SERVER["REMOTE_ADDR"];
		}
		$IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		if ($_SERVER["HTTP_CLIENT_IP"]) {
			$IP = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$IP = $_SERVER["REMOTE_ADDR"];
		}
	}
	
	return $IP;
	
}

function CheckSessions() {
	global $lang, $game_config, $ugamela_root_path, $phpEx;
	
	includeLang('cookies');
	include($ugamela_root_path . 'config.' . $phpEx);

	$UserRow = array();

	if ($_SESSION[USER_SESSION]) {

		$UserRow = doquery("SELECT * FROM {{table}} WHERE `id` = " . $_SESSION[USER_SESSION][id], 'users', true);

		// USER FOUND?
		if (!$UserRow) {
			message($lang['cookies']['Error2']);
		}
		
		// CHECK PASS
		$Hash = md5($UserRow["password"] . "--" . $dbsettings["secretword"]);
		if ($Hash !== $_SESSION[USER_SESSION][password]) {
			message($lang['cookies']['Error3']);
		}
		
		// ONLY 1 IP :D
		if($UserRow['user_lastip'] != $_SESSION[USER_SESSION][ip]){
			message($lang['cookies']['Error1']);
		}
		
		$Qry  = "UPDATE {{table}} SET ";
		$Qry .= "`onlinetime` = UNIX_TIMESTAMP(), ";
		$Qry .= "`user_lastip` = '" . getIP() . "', ";
		$Qry .= "`user_agent` = '" . $_SERVER['HTTP_USER_AGENT'] . "'";
		$Qry .= " WHERE `id` = " . $_SESSION[USER_SESSION][id] . " LIMIT 1;";
		doquery( $Qry, 'users');

		if ($IsUserChecked == false) {
			$IsUserChecked = true;
		} else {
			$IsUserChecked = true;
		}
	}

	unset($dbsettings);

	$Return['state']  = $IsUserChecked;
	$Return['record'] = $UserRow;

	return $Return;
}

function OutputScriptExit($to = '\'logout.php\''){
	echo '<script language="javascript">window.top.location = ' . $to . ';</script>';
	exit();
}
?>