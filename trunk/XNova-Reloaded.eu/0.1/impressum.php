<?php

/**
 * impressum.php
 *
 * @version 1.0
 * @copyright 2009 for Xnova Reloaded
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen
define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!

define('XNOVA_ROOT_PATH', './');

include(XNOVA_ROOT_PATH . 'pages/common.php');

	includeLang('impressum');

	$BodyTPL = gettemplate('impressum');
	$parse   = $lang;

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['impressum'], false);

?>