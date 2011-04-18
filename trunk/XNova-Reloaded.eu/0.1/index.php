<?php

/*
 * @index.php
 * @Version: Xnova-Reloaded 0.1
 * @copyright 2009 by Steggi
 * @Beschreibung:
 * @Der Abschnitt 1 dient dem eigentlichen Login
 * @und der Abschnitt 2 (der immer ausgeführt wird)
 * @dient zur allgemeinen Darstellung der Seite
 */

 // wenn die Config.php leer ist
 if (filesize('pages/config.php') == 0) {
	header('location: install/'); // weiterleitung zur Installation
	exit();
}

// Konstanten setzen
define('INSIDE' , true); 
define('INSTALL' , false);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen
define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
define('KEIN_SCROLLDIV' , true);
define('XNOVA_ROOT_PATH', './');

$InLogin = true; 
include(XNOVA_ROOT_PATH . '/pages/common.php');
includeLang("login"); //Spachfile includieren

// Abschnitt 1 (Login)
if ($_POST && $_POST['Uni'] != "no") // wenn das Formular abgeschickt wird...
{
		// ... lese die DB aus
		$Query = $DB->prepare("SELECT id, username, password FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1");
		$Query->bindParam('username', $_POST['username']);
		$Query->execute();
		$UserVorhanden = $Query->fetch();
		
		if ($UserVorhanden) // wenns den User gibt...
		{
			if ($UserVorhanden['password'] == md5($_POST['password'])) //... und das Passwort stimmt...
			{
				// gib dem User nen Keks
				$cookie = $UserVorhanden["id"] . "/%/" . $UserVorhanden["username"] . "/%/" . md5($UserVorhanden["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);
				unset($dbsettings);
				// und setze die Session
				$_SESSION['username']	= $UserVorhanden['username'];
				$_SESSION['password']	= $UserVorhanden['password'];
				$_SESSION['id']			= $UserVorhanden['id'];
				// anschließend weiterleiten ins Game
				header('Location: indexGame.php?action=internalHome');
				exit; // und das Script beenden
				
			} else { // Bei nem falschen Passwort gibts ne Meldung
				message($lang['Login_FailPassword'], $lang['Login_Error']);
			}
		} else { // Und bei nem nicht existierenden User auch
			message($lang['Login_FailUser'], $lang['Login_Error']);
		}
}

// Abschnitt 2 (Seitendarstellung)
else {

	$parse = $lang;
	
	//Letzten registrierten User auslesen
	$Query   = $DB->query("SELECT `username` FROM `".PREFIX."users` ORDER BY `register_time` DESC LIMIT 1");
	$Spieler = $Query->fetch(PDO::FETCH_ASSOC);

	$parse['last_user'] = $Spieler['username'];

	//Online-Spieler auslesen
	$Query   = $DB->query("SELECT COUNT(DISTINCT(id)) AS `0` FROM `".PREFIX."users` WHERE `onlinetime` > '" . (time()-900) ."'");
	$Spieler = $Query->fetch(PDO::FETCH_ASSOC);

	$parse['online_users']  = $Spieler[0];
	$parse['time']          = date("d.m.Y H:i:s", time());

	//Anzahl der Spieler auslesen
	$Query = $DB->query("SELECT COUNT(DISTINCT(id)) AS `0` FROM `".PREFIX."users`");
	$Spieler = $Query->fetch(PDO::FETCH_ASSOC);

	$parse['users_amount'] = $Spieler[0];
	$parse['servername'] = $game_config['game_name']; 
	$parse['forum_url'] = $game_config['forum_url']; 
	$parse['PasswordLost'] = $lang['PasswordLost'];

	// Wenn das Game offline ist
	if($game_config['game_disable'] == 1)
	{
		$parse['status'] = $lang['offline']; // Zeige die Info an
		$parse['reason'] = "<tr><td>".$lang['close_reason'].nl2br($game_config['close_reason'])."</td></tr>";
	}
	else // Ansonsten zeige das Game als online
		$parse['status'] = $lang['online'];
	
	// Wenn kein Universum ausgewählt wurde
	if (isset($_POST) && $_POST['Uni'] == "no")
		$parse['no_universe_selected'] = $lang['universe_error']; // teile das dem User mit
	else
		$parse['no_universe_selected'] = "&nbsp;";

	$page = parsetemplate(gettemplate('login_body'), $parse); 
	display($page, $lang['Login']);
}
?>