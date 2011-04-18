<?php

/**
 * logout.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */
define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!

	includeLang('logout');

	setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
	$_SESSION = array();
	session_destroy();
	message("<font color=\"lime\"><b>".$lang['see_you']."</b></font><meta http-equiv=\"refresh\" content=\"5; index.php\";/>", $lang['session_closed']);

?>