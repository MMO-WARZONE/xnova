<?php

/**
 * lostpassword.php
 *
 * @version 1.0
 * @copyright 2008 by Tom1991 for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen
define('LEFTMENU_NICHT_ANZEIGEN', true);

define('XNOVA_ROOT_PATH', './');

include(XNOVA_ROOT_PATH . 'pages/common.php');

	includeLang('lostpassword');

	if ($action != 1) {
		$parse               = $lang;
		$parse['servername'] = $game_config['game_name'];
		$page .= parsetemplate(gettemplate('lostpassword'), $parse);
		display($page, $lang['system'], false);
	}
	if ($action == 1) {
		$email               = $_POST['email'];
		sendnewpassword($email);
		message($lang['lostpw_done'], 'OK', "index.php");
	}

// History version
// 1.0 Création (Tom)
?>