<?php

/*
indexGame.php
Copyright by Steggi  for Xnova-reloaded.de

Diese Seite wird aufgerufen, nachdem man sich erfolgreich eingelogt hat, und holt sich alle weiteren Dateien über einen Switcher herbei
*/

ignore_user_abort(true);
define('INSIDE'  , true);
define('INSTALL' , false);
define('XNOVA_ROOT_PATH', './');	//Der Root Path wird einmalig definiert

if ($_GET['action'] == ShowReport)	// Wenn ein KB aufgerufen wird, muss der User nicht angemeldet sein.
define('USER_MUSS_REGISTRIERT_SEIN', false);
		
if ($user['authlevel'] != 0 && $user['id'] != 1)
die("kommst hier net rein");
		

include(XNOVA_ROOT_PATH . 'pages/common.php');

	if ($user['authlevel'] != 0 && $user['id'] != 1){

		$Query = $DB->prepare("DELETE FROM ".PREFIX."planets WHERE `id_owner` = :owner");
		$Query->bindParam('owner', $user['id']);
		$Query->execute;

		DeleteSelectedUser ($user['id']);

		header('Location: indexGame.php');

	}

if($game_config['game_disable'] == 1 && $user['authlevel'] != 3)
{
	define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
	exit(message(
					$game_config['close_reason'].
					"<tr><th><a href=\"index.php\">Zur&uuml;ck zum Login</a></th></tr>"
					,'Game closed'));
}
include(XNOVA_ROOT_PATH . 'switch.php');
//und die entsprechenden Dateien includiert, die zum Betreiben der weiteren Seiten benötigt werden.



?>