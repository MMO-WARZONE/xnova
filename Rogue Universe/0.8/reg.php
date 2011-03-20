<?php

define('INSIDE'  , true);
define('INSTALL' , false);

include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';

$securimage = new Securimage();

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

includeLang('reg');

$wylosuj = rand(100000,9000000); 
$kod = md5($wylosuj);
function sendpassemail($emailaddress, $password, $UserName) {
	global $lang, $kod;

	$parse['gameurl']  = GAMEURL;
	$parse['password'] = $password;
	$parse['character'] = $UserName;
	$parse['kod']      = $kod;
	$email             = parsetemplate($lang['mail_welcome'], $parse);
	$status            = mymail($emailaddress, $lang['mail_title'], $email);
	return $status;
}

function mymail($to, $title, $body, $from = '') {
	$from = trim($from);

	if (!$from) {
		$from = ADMINEMAIL;
	}

	$rp     = ADMINEMAIL;

	$head   = '';
	$head  .= "Content-Type: text/html \r\n";
	$head  .= "Date: " . date('r') . " \r\n";
	$head  .= "Return-Path: $rp \r\n";
	$head  .= "From: $from \r\n";
	$head  .= "Sender: $from \r\n";
	$head  .= "Reply-To: $from \r\n";
	$head  .= "Organization: $org \r\n";
	$head  .= "X-Sender: $from \r\n";
	$head  .= "X-Priority: 3 \r\n";
	$body   = str_replace("\r\n", "\n", $body);
	$body   = str_replace("\n", "\r\n", $body);

	return mail($to, $title, $body, $head);
}

if ($_POST) {
	$errors    = 0;
	$errorlist = "";

	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email'])) {
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
		$errors++;
	}


	if (!$_POST['planet']) {
		$errorlist .= $lang['error_planet'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1) {
		$errorlist .= $lang['error_planetnum'];
		$errors++;
	}

	if (!$_POST['character']) {
		$errorlist .= $lang['error_character'];
		$errors++;
	}

	if (strlen($_POST['passwrd']) < 4) {
		$errorlist .= $lang['error_password'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1) {
		$errorlist .= $lang['error_charalpha'];
		$errors++;
	}

	if ($_POST['rgt'] != 'on') {
		$errorlist .= $lang['error_rgt'];
		$errors++;
	}

	// Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
	$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
	if ($ExistUser) {
		$errorlist .= $lang['error_userexist'];
		$errors++;
	}

	// Si l'on verifiait que l'adresse email n'existe pas encore ???
	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);
	if ($ExistMail) {
		$errorlist .= $lang['error_emailexist'];
		$errors++;
	}

	if ($_POST['sex'] != ''  &&
		$_POST['sex'] != 'F' &&
		$_POST['sex'] != 'M') {
		$errorlist .= $lang['error_sex'];
		$errors++;
	}

	if ($_POST['langer'] != ''  &&
		$_POST['langer'] != 'se' &&
		$_POST['langer'] != 'pl' &&
		$_POST['langer'] != 'fr' &&
		$_POST['langer'] != 'es' &&
		$_POST['langer'] != 'de' &&
		$_POST['langer'] != 'en' &&
		$_POST['langer'] != 'it') {
		$errorlist .= $lang['error_lang'];
		$errors++;
	}

	if ($errors != 0) {
		message ($errorlist, $lang['Register']);
	} else {
		$newpass        = $_POST['passwrd'];
		$UserName       = CheckInputStrings ( $_POST['character'] );
		$UserEmail      = CheckInputStrings ( $_POST['email'] );
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );

		$md5newpass     = md5($newpass);
		$Killer = $game_config['aktywacjen'];
		$killers = md5($Killer);
		$aktywacja = time()+2678400;
		// Creation de l'utilisateur
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '". mysql_escape_string(strip_tags( $UserName )) ."', ";
		$QryInsertUser .= "`email` = '".    mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`email_2` = '".  mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`lang` = '".     mysql_escape_string( $_POST['langer'] )      ."', ";
		$QryInsertUser .= "`sex` = '".      mysql_escape_string( $_POST['sex'] )         ."', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '". time() ."', ";
		$QryInsertUser .= "`password`='". $md5newpass ."', ";
		$QryInsertUser .= "`aktywnosc` = '1', ";
		$QryInsertUser .= "`kod_aktywujacy`='". mysql_escape_string( $kod )              ."', ";
		$QryInsertUser .= "`kiler`='".          mysql_escape_string( $killers )          ."', ";
		$QryInsertUser .= "`time_aktyw`='".     mysql_escape_string( $aktywacja )        ."';";
		doquery( $QryInsertUser, 'users');

		// On cherche le numero d'enregistrement de l'utilisateur fraichement créé
		$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
		$iduser         = $NewUser['id'];

		// Recherche d'une place libre !
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
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = doquery( $QrySelectGalaxy, 'galaxy', true);

			if ($GalaxyRow["id_planet"] == "0") {
				$newpos_checked = true;
			}

			if (!$GalaxyRow) {
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
				$newpos_checked = true;
			}
			if ($newpos_checked) {
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedGalaxyPos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedSystemPos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedPlanetPos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		// Recherche de la reference de la nouvelle planete (qui est unique normalement !
		$PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

		// Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`galaxy` = '". $Galaxy ."', ";
		$QryUpdateUser .= "`system` = '". $System ."', ";
		$QryUpdateUser .= "`planet` = '". $Planet ."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $NewUser['id'] ."' ";
		$QryUpdateUser .= "LIMIT 1;";
		doquery( $QryUpdateUser, 'users');

		// Mise a jour du nombre de joueurs inscripts
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'aktywacjen' LIMIT 1;", 'config');

		$Message  = $lang['thanksforregistry'];
		if (sendpassemail($_POST['email'], "$newpass", "$UserName")) {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
		} else {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $newpass . " and your IGN is: " . $UserName ."</b>";
		}
		message( $Message, $lang['reg_welldone']);

	}
		$Message = "Hi, Welcome to Rogue Universe. We hope you have fun playing this game. If you have any problems please submit a support ticket. As a general tip we would recomend you start by building up your mines. Start with metal mines and Crystal mines as well as a Solar Plant. Good Luck.";
		SendSimpleMessage ( $NewUser['id'], 1, time(), 1, "Rogue Universe", "Welcome", $Message);
} else {
	// Afficher le formulaire d'enregistrement
	$parse               = $lang;
	$parse['servername'] = $game_config['game_name'];

	display(parsetemplate(gettemplate('registry_form'), $parse), $lang['registry'], false);
}

if ($securimage->check($_POST['captcha_code']) == false) {
  die('The code you entered was incorrect.  Go back and try again.');
}
      
?>