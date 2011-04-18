<?php

/**
 * reg.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen
define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!

define('XNOVA_ROOT_PATH', './');

include(XNOVA_ROOT_PATH . 'pages/common.php');

includeLang('reg');


$Code = md5(rand(10000,9000000));

//Email für die Registrierung versenden
function sendpassemail($emailaddress, $password, $username) {
	global $lang, $Code;

	$parse['gameurl']  = GAMEURL;
	$parse['password'] = $password;
	$email             = parsetemplate($lang['mail_welcome'], $parse);
	$status            = mymail($emailaddress, $lang['mail_title'], $username, $password);
	return $status;
}

function mymail($to, $title, $username, $password) {
	global $game_config;
	
	$from = trim($from);

	if(!$from) {
		$from = ADMINEMAIL;
	}

		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$header .= 'From: '.$game_config['game_name'].' <'.$from.'>' . "\r\n";
		$body = "Willkommen beim Spiel <b>".$game_config['game_name']."</b><br>
		Deine Accountdaten lauten:<br>
		<b>Username:</b> ".$username." <br />
		<b>Passwort:</b> ".$password." <br /><br />
		Mit diesen Daten kannst du dich jetzt auf ".GAMEURL." anmelden.<br />
		Viel Spa&szlig; beim spielen =)";

	return mail($to, $title, $body, $header);
}

/*Wenn POST-Daten gefüllt sind*/
    if($_POST) {
	
		$errors    = 0;
		$errorlist = "";

		//Falsche Emailadresse
	    if(!is_email($_POST['email'])) {
			$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
			$errors++;
		}

		//Unerlaubte Zeichen im Planetennamen
		if (preg_match("/[^A-z0-9_\-]/", $_POST['planet']) == 1 && isset($_POST['planet'])) {
			$errorlist .= $lang['error_planetnum'];
			$errors++;
		}

		//Kein Username angegeben
		if (!$_POST['character']) {
			$errorlist .= $lang['error_character'];
			$errors++;
		}

		//Zu kurzes Passwort, mindestens 5 Zeichen
		if (strlen($_POST['passwrd']) < 4) {
			$errorlist .= $lang['error_password'];
			$errors++;
		}

		//Ungültige Zeichen im Usernamen
		if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1 && isset($_POST['character'])) {
			$errorlist .= $lang['error_charalpha'];
			$errors++;
		}

		//Regeln und AGB werden nicht akzeptiert!
		if ($_POST['rgt'] != 'on') {
			$errorlist .= $lang['error_rgt'];
			$errors++;
		}

	
	    $Query = $DB->prepare("SELECT `username` FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1");
		$Query->bindParam('username', $_POST['character']);
		$Query->execute();
		$ExistUser = $Query->fetch(PDO::FETCH_ASSOC);
	
	    //Username existiert schon?
		if(isset($ExistUser) && is_array($ExistUser)) {
			$errorlist .= $lang['error_userexist'];
			$errors++;
		}
	
	    $Query = $DB->prepare("SELECT `email` FROM `".PREFIX."users` WHERE `email` = :email LIMIT 1");
		$Query->bindParam('email', $_POST['email']);
		$Query->execute();
		$ExistMail = $Query->fetch(PDO::FETCH_ASSOC);
	
	    //Überprüfen ob Email existiert
		if($ExistMail) {
			$errorlist .= $lang['error_emailexist'];
			$errors++;
		}

		//Keine Sprache angegeben
		if ($_POST['langer'] != ''  &&
			$_POST['langer'] != 'de') {
			$errorlist .= $lang['error_lang'];
			$errors++;
		}

		//Fehleranalyse
		if($errors != 0) {
		
		    //Fehler ausgeben
			message ($errorlist, $lang['Register']);

		} else {
		

			$UserName       = CheckInputStrings ( $_POST['character'] );
			$UserEmail      = CheckInputStrings ( $_POST['email'] );
			$UserPlanet     = CheckInputStrings ( $_POST['planet'] );


		$Killer = $game_config['aktywacjen'];
		$killers = md5($Killer);
		$aktywacja = time()+2678400;

		
		
		$QryInsertUser  = "INSERT INTO `".PREFIX."users` SET ";
		$QryInsertUser .= "`username`       = :username, ";
		$QryInsertUser .= "`email`          = :email, ";
		$QryInsertUser .= "`email_2`        = :email, ";
		$QryInsertUser .= "`id_planet`      = '0', ";
		$QryInsertUser .= "`register_time`  = '".time()."' ,";
		$QryInsertUser .= "`password`       = '". md5($_POST['passwrd']) ."';";
		
		$Query = $DB->prepare($QryInsertUser);
		$Query->bindParam('username', $_POST['character']);
		$Query->bindParam('email',    $_POST['email']);
		//Spieler in die Datenbank eintragen
		$Query->execute();

		
	    $Query = $DB->prepare("SELECT `id` FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1");
		$Query->bindParam('username', $_POST['character']);
		$Query->execute();
		$NewUser = $Query->fetch(PDO::FETCH_ASSOC);
		//ID des neuen Spielers auslesen
		$iduser         = $NewUser['id'];

		//Position des Hauptplaneten berechnen
		$LastSettedGalaxyPos  = $game_config['LastSettedGalaxyPos'];
		$LastSettedSystemPos  = $game_config['LastSettedSystemPos'];
		$LastSettedPlanetPos  = $game_config['LastSettedPlanetPos'];
		while (!isset($newpos_checked)) {
			for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
				for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
					for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
						$Planet = round (rand ( 4, 12) );

						switch ($LastSettedPlanetPos) {
							case 1:
								$LastSettedPlanetPos += 1;
								break;
							case 2:
								$LastSettedPlanetPos += 1;
								break;
							case 3:
								if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
									$LastSettedGalaxyPos += 1;
									$LastSettedSystemPos  = 1;
									$LastSettedPlanetPos  = 1;
									break;
								} else {
									$LastSettedPlanetPos  = 1;
								}
								$LastSettedSystemPos += 1;
								break;
						}
						break;
					}
					break;
				}
				break;
			}

			$QrySelectGalaxy  =	"SELECT * ";
			$QrySelectGalaxy .= "FROM `".PREFIX."galaxy` ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$Query = $DB->query($QrySelectGalaxy);
			$GalaxyRow = $Query->fetch();

			if ($GalaxyRow["id_planet"] == "0") {
				$newpos_checked = true;
			}

			if (!$GalaxyRow) {
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
				$newpos_checked = true;
			}
			if ($newpos_checked) {
			    $Query = $DB->prepare("UPDATE `".PREFIX."config` SET `config_value` = :value WHERE `config_name` = :name ");
			    $Query->bindParam('value', $LastSettedGalaxyPos);
				$Name = "LastSettedGalaxyPos";
			    $Query->bindParam('name' , $Name);
			    $Query->execute();
			    $Query->bindParam('value', $LastSettedSystemPos);
				$Name = "LastSettedSystemPos";
			    $Query->bindParam('name' , $Name);
			    $Query->execute();
			    $Query->bindParam('value', $LastSettedPlanetPos);
				$Name = "LastSettedPlanetPos";
			    $Query->bindParam('name' , $Name);
			    $Query->execute();
			}
		}
		
		//ID des Hauptplaneten auslesen
	    $Query = $DB->prepare("SELECT `id` FROM `".PREFIX."planets` WHERE `id_owner` = :id ");
		$Query->bindParam('id', $NewUser['id']);
		$Query->execute();
		$PlanetID = $Query->fetch(PDO::FETCH_ASSOC);
		
		//game_users updaten
		$QryUpdateUser  = "UPDATE `".PREFIX."users` SET ";
		$QryUpdateUser .= "`id_planet`      = :planetid, ";
		$QryUpdateUser .= "`current_planet` = :current, ";
		$QryUpdateUser .= "`galaxy`         = :gala, ";
		$QryUpdateUser .= "`system`         = :sys, ";
		$QryUpdateUser .= "`planet`         = :planet ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = :id ";
		$QryUpdateUser .= "LIMIT 1;";
		
		$Query = $DB->prepare($QryUpdateUser);
		$Query->bindParam('planetid',$PlanetID['id']);
		$Query->bindParam('current', $PlanetID['id']);
		$Query->bindParam('gala',    $Galaxy);
		$Query->bindParam('sys',     $System);
		$Query->bindParam('planet',  $Planet);
		$Query->bindParam('id',      $NewUser['id']);
		//Spieler in die Datenbank eintragen
		$Query->execute();

		$Message  = $lang['thanksforregistry'];
		if (sendpassemail($_POST['email'], $_POST['passwrd'], $_POST['character'])) {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
		} else {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $_POST['passwrd'] . "</b>";
		}
		$Message .= "<meta http-equiv=\"refresh\" content=\"5; index.php\";/>";
		message( $Message, $lang['reg_welldone']);
	}
} else {
	//Defaultanzeige
	$parse               = $lang;
	$parse['servername'] = $game_config['game_name'];

	display(parsetemplate(gettemplate('registry_form'), $parse), $lang['registry'], false);
}


?>