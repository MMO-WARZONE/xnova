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
	global $lang, $game_config, $DB;

	includeLang('cookies');

	$UserRow = array();

	include(XNOVA_ROOT_PATH . 'pages/config.php');

	if (isset($_COOKIE[$game_config['COOKIE_NAME']]) && isset($_SESSION['username'])) {
		$TheCookie  = explode("/%/", $_COOKIE[$game_config['COOKIE_NAME']]);
		$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE `username` = :username;");
		$Query->bindParam(":username", $_SESSION['username']);
		$Query->execute();


		// Prüfen, obs diesen User überhaupt gibt
		if (sql_num_rows($Query) != 1) {
			setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
			session_destroy();
			header('Location: index.php');
			
		}
		
		
		$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE `username` = :username;");
		$Query->bindParam(":username", $_SESSION['username']);
		$Query->execute();
		$UserRow = $Query->fetch();

		// Prüfen ob die User ID STimmt
		if ($UserRow["id"] != $_SESSION['id']) {
			setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
			session_destroy();
			header('Location: index.php');
			
		}

		// Prüfen, ob das Passwort passt
		if ($UserRow["password"] != $_SESSION['password']) {
			setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
			session_destroy();
			header('Location: index.php');
			//message( $lang['cookies']['Error3'] );
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
			
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
			onlinetime = :time, 
			user_lastip = :ip,
			user_agent = :agent 
			WHERE `id` = :id LIMIT 1
			");
			$Query -> bindParam('time', time());
			$Query -> bindParam('ip', $_SERVER['REMOTE_ADDR']);
			$Query -> bindParam('agent', $_SERVER['HTTP_USER_AGENT']);
			$Query -> bindParam('id', $_SESSION['id']);
			$Query->execute();
			
			$IsUserChecked = true;
		} else {
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
			onlinetime = :time, 
			user_lastip = :ip,
			user_agent = :agent 
			WHERE `id` = :id LIMIT 1
			");
			$Query -> bindParam('time', time());
			$Query -> bindParam('ip', $_SERVER['REMOTE_ADDR']);
			$Query -> bindParam('agent', $_SERVER['HTTP_USER_AGENT']);
			$Query -> bindParam('id', $_SESSION['id']);
			$UpdateUserSql->execute();
			$IsUserChecked = true;
		}
	}

	unset($dbsettings);

	$Return['state']  = $IsUserChecked;
	$Return['record'] = $UserRow;

	return $Return;
}
?>