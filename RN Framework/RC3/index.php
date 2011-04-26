<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
$dir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
define('REGURL'                  , "http://".$_SERVER['HTTP_HOST']."".$dir."/");
function mymail($to, $title, $body, $from = '')
{
	$from = trim($from);
	if (!$from)
		$from = ADMINEMAIL;

	$rp = ADMINEMAIL;
	$head = '';
	$head .= "Content-Type: text/html \r\n";
	$head .= "charset: iso-8859-1 \r\n";
	$head .= "Date: " . date('r') . " \r\n";
	$head .= "Return-Path: $rp \r\n";
	$head .= "From: $from \r\n";
	$head .= "Sender: $from \r\n";
	$head .= "Reply-To: $from \r\n";
	$head .= "Organization: $org \r\n";
	$head .= "X-Sender: $from \r\n";
	$head .= "X-Priority: 3 \r\n";
	$body = str_replace("\r\n", "\n", $body);
	$body = str_replace("\n", "\r\n", $body);

	return mail($to, $title, $body, $head);
}
includeLang('PUBLIC');
$parse = $lang;
switch($_GET['page'])
{
	case 'lostpassword':
		function sendnewpassword($mail)
		{
			global $lang;

			$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $mail ."' LIMIT 1;", 'users', true);

			if (empty($ExistMail['email']))
			{
				message($lang['mail_not_exist'], "index.php?page=lostpassword",2, false, false);
			}
			else
			{
				$Caracters="aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count=strlen($Caracters);
				$NewPass="";
				$Taille=6;
				srand((double)microtime()*1000000);
				for($i=0;$i<$Taille;$i++)
				{
					$CaracterBoucle=rand(0,$Count-1);
					$NewPass=$NewPass.substr($Caracters,$CaracterBoucle,1);
				}
				$Title 	= $lang['mail_title'];
				$Body 	= "Hallo ShadoX,\n\n";
				$Body  .= "dein Passwort für ".$game_config['game_name']." lautet:\n\n";
				$Body  .= $NewPass."\n\n";
				$Body  .= "Du kannst dich damit unter ".REGURL." einloggen.\n\n";
				$Body  .= "Wir verschicken Passwörter nur an die von dir im Spiel angegebenen Mailadressen. Solltest du diese Mail nicht angefordert haben kannst du sie also einfach ignorieren.\n\n";
				$Body  .= "Wir wünschen dir weiterhin viel Erfolg beim Spielen von ".$game_config['game_name']."!\n\n";
				$Body  .= "Dein ".$game_config['game_name']."-Team\n\n";
				mymail($mail, $Title, $Body, ADMINEMAIL);				
				
				$NewPassSql = md5($NewPass);
				$QryPassChange = "UPDATE {{table}} SET ";
				$QryPassChange .= "`password` ='". $NewPassSql ."' ";
				$QryPassChange .= "WHERE `email`='". $mail ."' LIMIT 1;";
				doquery( $QryPassChange, 'users');
			}
		}
		if($_POST)
		{
			sendnewpassword($_POST['email']);
			message($lang['mail_sended'], "./",2, false, false);
		}
		else
		{
			$parse['forum_url']    = $game_config['forum_url'];
			display(parsetemplate(gettemplate('public/lostpassword'), $parse), false, '',false, false);
		}
	break;
	case 'reg':

		// Reg_closed Mod by Sycrog
		if($game_config['reg_closed'] === '1') display (parsetemplate(gettemplate('public/registry_closed'), $lang), false, '',false, false);

		if ($_POST)
		{
			$errors = 0;
			$errorlist = "";
			if($game_config['capaktiv'] === '1'){
				require_once('includes/recaptchalib.php');
				$privatekey = $game_config['capprivate'];;
				$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
					$errorlist .= "Sicherheitscode falsch!<br />";
					$errors++;
				}
			}

			$_POST['email'] = strip_tags($_POST['email']);
			if (!is_email($_POST['email']))
			{
				$errorlist .= $lang['invalid_mail_adress'];
				$errors++;
			}

			if (!$_POST['character'])
			{
				$errorlist .= $lang['empty_user_field'];
				$errors++;
			}

			if (strlen($_POST['passwrd']) < 4)
			{
				$errorlist .= $lang['password_lenght_error'];
				$errors++;
			}

			if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1)
			{
				$errorlist .= $lang['user_field_no_alphanumeric'];
				$errors++;
			}

			if ($_POST['rgt'] != 'on')
			{
				$errorlist .= $lang['terms_and_conditions'];
				$errors++;
			}

			$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
			if ($ExistUser)
			{
				$errorlist .= $lang['user_already_exists'];
				$errors++;
			}

			$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '" . mysql_escape_string($_POST['email']) . "' LIMIT 1;", 'users', true);
			if ($ExistMail)
			{
				$errorlist .= $lang['mail_already_exists'];
				$errors++;
			}

			if ($errors != 0)
			{
				message ($errorlist, "index.php?page=reg", "3", false, false);
			}
			else
			{
				$newpass	= $_POST['passwrd'];
				$UserName 	= $_POST['character'];
				$UserEmail 	= $_POST['email'];
				$md5newpass = md5($newpass);

				$characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
				$size=15;
				for($i=0;$i<$size;$i++)
				{
				$clef .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
				}
				$subject = "Noch ein Schritt zur Aktivierung Ihres Usernamen";

				$message_txt .= "Hallo ".$UserName.",<br>vielen Dank, dass Sie sich in unserem Game ".GAMEURL." registriert haben. Bevor Ihr Benutzerkonto aktiviert und Ihre Registrierung abgeschlossen werden kann, müssen Sie noch einen letzten Schritt unternehmen.<br><br>Bitte beachten Sie, dass dieser Schritt zwingend notwendig ist, um ein registrierter Benutzer zu werden. Sie müssen den Link unten nur ein einziges Mal aufrufen, um Ihr Benutzerkonto zu aktivieren.<br><br>Um Ihre Registrierung abzuschließen, klicken Sie bitte auf folgenden Link:<br><br><a href='".REGURL."index.php?page=reg&mode=valid&pseudo=".$UserName."&clef=".$clef."'>".REGURL."index.php?page=reg&mode=valid&pseudo=".$UserName."&clef=".$clef."</a><br><br>Ihre Logindaten:<br><br>Username : ".$UserName."<br>Passwort : ".$newpass."<br><br>Sollten Sie immer noch Probleme mit der Registrierung haben, kontaktieren Sie bitte den Webmaster unter dieser E-Mail-Adresse: <a href='mailto:".ADMINEMAIL."'>".ADMINEMAIL."</a><br><br>Mit freundlichen Grüßen,<br><br>".GAMEURL."";

				mymail($UserEmail, $subject, $message_txt, ADMINEMAIL);

				$QryInsertUser = "INSERT INTO {{table}} SET ";
				$QryInsertUser .= "`username` = '" . mysql_escape_string(strip_tags($UserName)) . "', ";
				$QryInsertUser .= "`email` = '" . mysql_escape_string($UserEmail) . "', ";
				$QryInsertUser .= "`date` = '" . time() . "', ";
				$QryInsertUser .= "`cle` = '" . mysql_escape_string($clef) . "', ";
				$QryInsertUser .= "`password`='" . $md5newpass . "', ";
				$QryInsertUser .= "`ip` = '" . $_SERVER["REMOTE_ADDR"] . "'; ";
				doquery($QryInsertUser, 'users_valid');

				$NewUser = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users_valid', true);
				$iduser = $NewUser['id'];

				$Message = "Danke f&uuml;r ihre Anmeldung! Sie erhalten eine E-Mail.";
			   

				message($Message, "index.php", 10, false, false);
			}
		} elseif($_GET['mode'] == valid) {
		
		$pseudo=$_GET['pseudo'];
			
		$clef=$_GET['clef'];

		$QrySelectvalid = "SELECT * ";
		$QrySelectvalid .= "FROM {{table}} ";
		$QrySelectvalid .= "WHERE ";
		$QrySelectvalid .= "`username` = '" . $pseudo . "'";
		$A_Valider = doquery($QrySelectvalid, 'users_valid', true);
				
		$ExistPseudo = doquery("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_GET['pseudo']) . "' LIMIT 1;", 'users', true);
		if($A_Valider['clef']=$_GET['clef'] && $A_Valider['username']=$_GET['pseudo'] && $A_Valider['username'] != $ExistPseudo['username']){
			$UserName = $A_Valider['username'];
			$UserPass = $A_Valider['password'];
			$UserMail = $A_Valider['email'];
			$UserIP = $A_Valider['ip'];
			
			$QryInsertUser = "INSERT INTO {{table}} SET ";
			$QryInsertUser .= "`username` = '" . mysql_escape_string($UserName) . "', ";
			$QryInsertUser .= "`email` = '" . mysql_escape_string($UserMail) . "', ";
			$QryInsertUser .= "`email_2` = '" . mysql_escape_string($UserMail) . "', ";
			$QryInsertUser .= "`ip_at_reg` = '" . $UserIP . "', ";
			$QryInsertUser .= "`id_planet` = '0', ";
			$QryInsertUser .= "`register_time` = '" . time() . "', ";
			$QryInsertUser .= "`password`='" .  mysql_escape_string($UserPass) . "', ";
			$QryInsertUser .= "`uctime`= '0';";
			doquery($QryInsertUser, 'users');
			
			doquery("DELETE FROM {{table}} WHERE username='$UserName' LIMIT 1;", 'users_valid');
			}else{
			message("User konnte nich aktiviert werden");}

			$subject = "Willkommen bei ". $game_config['game_name'] ."!";

			$message_txt .= "Hallo  ".$UserName.",\n\nDanke, dass Sie sich bei ". $game_config['game_name'] ." als Benutzer registriert haben!\n\nWir freuen uns, dass Sie sich entschieden haben, ein Teil unserer Community zu werden und hoffen, dass es Ihnen gefallen wird.\n\nMit freundlichen Grüßen\n\n". $game_config['game_name'] ."";

			mymail($UserMail, $subject, $message_txt, ADMINEMAIL);
			
			$NewUser = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_escape_string($UserName) . "' LIMIT 1;", 'users', true);

			$LastSettedGalaxyPos = $game_config['LastSettedGalaxyPos'];
			$LastSettedSystemPos = $game_config['LastSettedSystemPos'];
			$LastSettedPlanetPos = $game_config['LastSettedPlanetPos'];

			while (!isset($newpos_checked))
			{
				for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++)
				{
					for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++)
					{
						for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++)
						{
							$Planet = round (rand (4, 12));

							switch ($LastSettedPlanetPos)
							{
								case 1:
									$LastSettedPlanetPos += 1;
								break;
								case 2:
									$LastSettedPlanetPos += 1;
								break;
								case 3:
									if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY)
									{
										$LastSettedGalaxyPos += 1;
										$LastSettedSystemPos = 1;
										$LastSettedPlanetPos = 1;
										break;
									}
									else
									{
										$LastSettedPlanetPos = 1;
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

				$QrySelectGalaxy = "SELECT * ";
				$QrySelectGalaxy .= "FROM {{table}} ";
				$QrySelectGalaxy .= "WHERE ";
				$QrySelectGalaxy .= "`galaxy` = '" . $Galaxy . "' AND ";
				$QrySelectGalaxy .= "`system` = '" . $System . "' AND ";
				$QrySelectGalaxy .= "`planet` = '" . $Planet . "' ";
				$QrySelectGalaxy .= "LIMIT 1;";
				$GalaxyRow = doquery($QrySelectGalaxy, 'galaxy', true);

				if ($GalaxyRow["id_planet"] == "0")
					$newpos_checked = true;

				if (!$GalaxyRow)
				{
					CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
					$newpos_checked = true;
				}
				if ($newpos_checked)
				{
					doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
					doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
					doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
				}
			}
			$PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;" , 'planets', true);

			$QryUpdateUser = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`id_planet` = '" . $PlanetID['id'] . "', ";
			$QryUpdateUser .= "`current_planet` = '" . $PlanetID['id'] . "', ";
			$QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
			$QryUpdateUser .= "`system` = '" . $System . "', ";
			$QryUpdateUser .= "`planet` = '" . $Planet . "' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '" . $NewUser['id'] . "' ";
			$QryUpdateUser .= "LIMIT 1;";
			doquery($QryUpdateUser, 'users');

			$from 		= $lang['welcome_message_from'];
			$sender 	= $lang['welcome_message_sender'];
			$Subject 	= $lang['welcome_message_subject'];
			$message 	= $lang['welcome_message_content'];
			SendSimpleMessage($NewUser['id'], $sender, $Time, 1, $from, $Subject, $message);

			doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
			if($_GET['admin']){
				message("User erfolgreich aktiviert","javascript:window.close()", 3, false, false);
			} else {
			@include('config.php');
			$cookie = $NewUser['id'] . "/%/" . $UserName . "/%/" . md5($UserPass . "--" . $dbsettings["secretword"]) . "/%/" . 0;
			setcookie($game_config['COOKIE_NAME'], $cookie, 0, "/", "", 0);

			unset($dbsettings);

			header("location:game.php?page=overview");
			
			}
		}
		else
		{
			if($game_config['capaktiv'] === '1'){
				require_once('includes/recaptchalib.php');
				$publickey = $game_config['cappublic']; // you got this from the signup page
				$parse['captcha']   =  recaptcha_get_html($publickey);
			}
			$parse['servername']   = $game_config['game_name'];
			$parse['forum_url']    = $game_config['forum_url'];
			display(parsetemplate(gettemplate('public/registry_form'), $parse), false, '', false, false);
		}	
	break;
	case 'agb':
		$parse['servername']   = $game_config['game_name'];
		display(parsetemplate(gettemplate('public/index_agb'), $parse), false, '', false, false);
	break;
	case 'rules':
		$parse['servername']   = $game_config['game_name'];
		display(parsetemplate(gettemplate('public/index_rules'), $parse), false, '', false, false);
	break;
	default:
		if ($_POST)
		{
			$login = doquery("SELECT `id`,`username`,`password`,`banaday` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' AND `password` = '" . md5($_POST['password']) . "' LIMIT 1", "users", true);

			if($login['banaday'] <= time() && $login['banaday'] != '0')
			{
				doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0' WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
				doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
			}

			if ($login)
			{
				if (isset($_POST["rememberme"]))
				{
					$expiretime = time() + 31536000;
					$rememberme = 1;
				}
				else
				{
					$expiretime = 0;
					$rememberme = 0;
				}

				@include('config.php');
				$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);

				doquery("UPDATE `{{table}}` SET `current_planet` = `id_planet` WHERE `id` ='".$login["id"]."'", 'users');

				unset($dbsettings);
				header("Location: ./game.php?page=overview");
				exit;
			}
			else
			{
				message($lang['login_error'], "./", 2, false, false);
			}
		} elseif (!empty($_COOKIE[$game_config['COOKIE_NAME']])) {
            $cookie = explode('/%/',$_COOKIE[$game_config['COOKIE_NAME']]);
            if ($cookie[3] != 1)
            {
                setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
                header("Location: ./");
            }
            else
            {
                $login = doquery("SELECT `password` FROM {{table}} WHERE `username` = '".mysql_escape_string($cookie[1])."' LIMIT 1", "users", true);
                if ($login)
                {
                    @include('config.php');
                    if (md5($login["password"] . "--" . $dbsettings["secretword"]) == $cookie[2])
                    {
                        unset($dbsettings);
                        header("Location: ./game.php?page=overview");
                        exit;
                    }
                }
            }
		} 
		else
		{
			$parse['servername']   = $game_config['game_name'];
			$parse['forum_url']    = $game_config['forum_url'];
			$query = doquery("SELECT * FROM {{table}} ORDER BY id DESC;", 'news');
			while ($NewsRow = mysql_fetch_assoc($query))
			{
				$parse['name']     = $NewsRow['user'];
				$parse['title']    = $NewsRow['title'];				
				$parse['date']     = date("d.m.Y H:i:s",$NewsRow['date']);
				$parse['text'] 	   = $NewsRow['text'];
				$news .= parsetemplate(gettemplate('public/index_news'), $parse);
			}
			$parse['news']         = $news;
			display(parsetemplate(gettemplate('public/index_body'), $parse),false,'',false,false);
		}
}
?>