<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('startseite');

$wylosuj = rand(100000,9000000); 
$kod = md5($wylosuj);
function sendpassemail($emailaddress, $password) {
	global $lang, $kod;

	$parse['gameurl']  = GAMEURL;
	$parse['password'] = $password;
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
	$head  .= "Content-Type: text/plain \r\n";
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

		$girilen = $_REQUEST["captcha"]; 
	if($_SESSION['captcha'] == $girilen){ 
	}else{ 
		$errorlist .= $lang['error_captcha']; 
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

	if ($_POST['sex'] != '' && $_POST['sex'] != 'M' && $_POST['sex'] != 'F') {
        $errorlist .= $lang['error_sex'];
        $errors++;
    } 

	if ($_POST['langer'] != ''  &&
		$_POST['langer'] != 'de' &&
		$_POST['langer'] != 'en') {
		$errorlist .= $lang['error_lang'];
		$errors++;
	}

	if ($errors != 0) {
		message ($errorlist, $lang['Register']);
	} else {
		$newpass        = mysql_escape_string($_POST['passwrd']);
		$UserName       = mysql_escape_string($_POST['character']);
		$UserEmail      = mysql_escape_string($_POST['email']);
		$UserPlanet     = mysql_escape_string($_POST['planet']);

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
		$QryInsertUser .= "`aktywnosc` = '0', ";
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
						$Planet = START_PLANET_POSITION;

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
		if (sendpassemail($_POST['email'], "$newpass")) {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
		} else {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $newpass . "</b>";
		}
		message( $Message, $lang['reg_welldone']);
	}
} else {
    // Afficher le formulaire d'enregistrement
    $parse               = $lang;
    $parse['servername'] = $game_config['game_name'];
    $query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true); 
$parse['last_user'] = $query['username']; 
$query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
    $parse['online_users'] = $query[0]; 
$parse['users_amount'] = $game_config['users_amount']; 
    $parse['lm_tx_serv']      = $game_config['resource_multiplier'];
    $parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
    $parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
    $parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;

	display(parsetemplate(gettemplate('startseite/registry_form'), $parse), $lang['registry'], false);
}

?>