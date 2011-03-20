<?php

/**
 * CheckCookies.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */
// TheCookie[0] = `id`
// TheCookie[1] = `username`
// TheCookie[2] = Password + Hashcode
// TheCookie[3] = 1rst Connexion time + 365 J

function CheckCookies ( $IsUserChecked ) {
	global $lang, $game_config, $basic_pages;

	getLang('cookies');

	$UserRow = array();
	include(ROOT_PATH . 'config'.UNIVERSE.'.php');

	if (isset($_COOKIE[$game_config['COOKIE_NAME']])) {
		$TheCookie  = explode("/%/", $_COOKIE[$game_config['COOKIE_NAME']]);
		$UserResult = doquery("SELECT * FROM {{table}} WHERE `username` = '". cleanstring($TheCookie[1]). "';", 'users');

		// On verifie s'il y a qu'un seul enregistrement pour ce nom
		if (mysql_num_rows($UserResult) == 0) {
			message( sprintf($lang['cookies']['Error1'],cleanstring($TheCookie[1])) );
		}

		$UserRow    = FetchArray($UserResult);

		// On teste si on a bien le bon UserID
		if ($UserRow["id"] != $TheCookie[0]) {
			message( $lang['cookies']['Error2'] );
		}

		// On teste si le mot de passe est correct !
		if (sha($UserRow["password"] . "--" . $dbsettings["secretword"]) !== $TheCookie[2]) {
			message( $lang['cookies']['Error3'] );
		}

		$NextCookie = implode("/%/", $TheCookie);
		// Au cas ou dans l'ancien cookie il etait question de se souvenir de moi
		// 3600 = 1 Heure // 86400 = 1 Jour // 31536000 = 365 Jours
		// on ajoute au compteur!
		if ($TheCookie[3] == 1) {
			$ExpireTime = time() + 31536000;
		} else {
			$ExpireTime = 0;
		}

		if ($IsUserChecked == false) {
			setcookie ($game_config['COOKIE_NAME'], $NextCookie, $ExpireTime, "/", "", 0);
		}
		if(SMALL_LOAD){
			//Just a small query
			doquery("UPDATE {{table}} SET `onlinetime` = '". time() ."' WHERE `id` = '". $TheCookie[0] ."' LIMIT 1;", 'users');
		}else{
			$QryUpdateUser  = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
			$QryUpdateUser .= "`current_page` = '". mysql_real_escape_string($_GET['page']) ."', ";
			$QryUpdateUser .= "`user_lastip` = '". mysql_real_escape_string($_SERVER['REMOTE_ADDR']) ."', ";
			$QryUpdateUser .= "`user_agent` = '". mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']) ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '". $TheCookie[0] ."' LIMIT 1;";
			doquery( $QryUpdateUser, 'users');
		}
		$IsUserChecked = true;
	}

	unset($dbsettings);

	$Return['state']  = $IsUserChecked;
	$Return['record'] = $UserRow;

	return $Return;
}

?>
