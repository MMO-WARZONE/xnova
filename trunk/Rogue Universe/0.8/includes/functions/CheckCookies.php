<?php

function CheckCookies ( $IsUserChecked ) {
	global $lang, $game_config, $ugamela_root_path, $phpEx;

	includeLang('cookies');

	$UserRow = array();

	include($ugamela_root_path . 'config.' . $phpEx);

	if (isset($_COOKIE[$game_config['COOKIE_NAME']])) {
		$TheCookie  = explode("/%/", $_COOKIE[$game_config['COOKIE_NAME']]);
		$UserResult = doquery("SELECT * FROM {{table}} WHERE `username` = '". $TheCookie[1]. "';", 'users');

		if (mysql_num_rows($UserResult) != 1) {
			message( $lang['cookies']['Error1'] );
		}

		$UserRow    = mysql_fetch_array($UserResult);

		if ($UserRow["id"] != $TheCookie[0]) {
			message( $lang['cookies']['Error2'] );
		}

		if (md5($UserRow["password"] . "--" . $dbsettings["secretword"]) !== $TheCookie[2]) {
			message( $lang['cookies']['Error3'] );
		}

		$NextCookie = implode("/%/", $TheCookie);

		// 3600 = 1 Hrs // 86400 = 1 day // 31536000 = 365 days
		if ($TheCookie[3] == 1) {
			$ExpireTime = time() + 31536000;
		} else {
			$ExpireTime = 0;
		}

		if ($IsUserChecked == false) {
			setcookie ($game_config['COOKIE_NAME'], $NextCookie, $ExpireTime, "/", "", 0);
			$QryUpdateUser  = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
			$QryUpdateUser .= "`user_lastip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
			$QryUpdateUser .= "`user_agent` = '". $_SERVER['HTTP_USER_AGENT'] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $TheCookie[0] ."' LIMIT 1;";
			doquery( $QryUpdateUser, 'users');
			$IsUserChecked = true;
		} else {
			$QryUpdateUser  = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
			$QryUpdateUser .= "`user_lastip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
			$QryUpdateUser .= "`user_agent` = '". $_SERVER['HTTP_USER_AGENT'] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $TheCookie[0] ."' LIMIT 1;";
			doquery( $QryUpdateUser, 'users');
			$IsUserChecked = true;
		}
	}

	unset($dbsettings);

	$Return['state']  = $IsUserChecked;
	$Return['record'] = $UserRow;

	return $Return;
}
?>