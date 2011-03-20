<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('lostpassword');

	if (empty($_POST['email'])) {
		$parse               = $lang;
		$parse['servername'] = $game_config['game_name'];
		$page .= parsetemplate(gettemplate('lostpassword'), $parse);
		display($page, $lang['system'], false);


	}
	else {
		$email               = $_POST["email"];
		sendnewpassword($email);
		message('Nytt lösenord har skickats!', 'OK');


	}
	setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

	message ( $lang['see_you'], $lang['session_closed'], "login.".$phpEx );

// History version
// 1.0 Création (Tom)
?>
