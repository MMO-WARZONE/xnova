<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = true;

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('login');

	if ($_POST) {
		$login = doquery("SELECT * FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' LIMIT 1", "users", true);
		if ($login) {
			if ($login['password'] == md5($_POST['password'])) {
				if (isset($_POST["rememberme"])) {
					$expiretime = time() + 31536000;
					$rememberme = 1;
				} else {
					$expiretime = 0;
					$rememberme = 0;
				}

				@include('config.php');
				$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);

				unset($dbsettings);
				header("Location: ./frames.php");
				exit;
			} else {
				message($lang['Login_FailPassword'], $lang['Login_Error']);
			}
		} else {
			message($lang['Login_FailUser'], $lang['Login_Error']);
		}
	} else {
		$parse = $lang;
		$query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true);
		$parse['last_user'] = $query['username'];
		$query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
		$parse['online_users'] = $query[0];
		$parse['users_amount'] = $game_config['users_amount'];
		$parse['servername'] = $game_config['game_name'];
		$parse['forum_url'] = $game_config['forum_url'];
		$parse['PasswordLost'] = $lang['PasswordLost'];

		$page = parsetemplate(gettemplate('login_body'), $parse);
		display($page, $lang['Login']);
	}


?>
