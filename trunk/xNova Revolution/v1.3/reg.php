<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

define('INSIDE' , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

includeLang('PUBLIC');

$parse = $lang;

function sendpassemail($emailaddress, $password)
{
	global $game_config, $lang;

	$email 				= parsetemplate($lang['reg_mail_text_part1'] . $password . $lang['reg_mail_text_part2'] . GAMEURL, $parse);
	$status 			= mymail($emailaddress, $lang['register_at'] . $game_config['game_name'], $email);

	return $status;
}

//Recaptcha (100% antibots  system by adri93)
    include($xgp_root . 'includes/functions/recaptchalib.' . $phpEx);
    // Get a key from http://recaptcha.net/api/getkey
    $publickey = "6LcDfwsAAAAAACI0Ws7BEHz9Dei7XBP0f0jrTEu9";
    $privatekey = "6LcDfwsAAAAAAONV9w9C8S7FPmanddv6WgRuQOJN";
    //Any response from reCAPTCHA?
    $resp = null;
    // Any error from reCAPTCHA?
    $error = null;

function mymail($to, $title, $body, $from = '')
{
	$from = trim($from);

	if (!$from)
		$from = ADMINEMAIL;

	$rp = ADMINEMAIL;

	$head = '';
	$head .= "Content-Type: text/html \r\n";
	$head  .= "charset: iso-8859-1 \r\n";
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

if ($_POST)
{
	$errors = 0;
	$errorlist = "";
	
	//Recaptcha response
        if ($_POST["recaptcha_response_field"])
        {
            $resp = recaptcha_check_answer ($privatekey,
                                            $_SERVER["REMOTE_ADDR"],
                                            $_POST["recaptcha_challenge_field"],
                                            $_POST["recaptcha_response_field"]);
        }

        if (!$resp->is_valid)
        {
            $resp = recaptcha_check_answer ($privatekey,
                                            $_SERVER["REMOTE_ADDR"],
                                            $_POST["recaptcha_challenge_field"],
                                            $_POST["recaptcha_response_field"]);
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
		message ($errorlist, "reg.php", "3", false, false);
	}
	else
	{
		$newpass	= $_POST['passwrd'];
		$UserName 	= $_POST['character'];
		$UserEmail 	= $_POST['email'];
		$md5newpass = md5($newpass);

		$QryInsertUser = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '" . mysql_escape_string(strip_tags($UserName)) . "', ";
		$QryInsertUser .= "`email` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`email_2` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`ip_at_reg` = '" . $_SERVER["REMOTE_ADDR"] . "', ";
		$QryInsertAdm  .= "`user_agent` = '', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '" . time() . "', ";
		$QryInsertUser .= "`password`='" . $md5newpass . "';";
		doquery($QryInsertUser, 'users');

		$NewUser = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);

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

		@include('config.php');
		$cookie = $NewUser['id'] . "/%/" . $UserName . "/%/" . md5($md5newpass . "--" . $dbsettings["secretword"]) . "/%/" . 0;
		setcookie($game_config['COOKIE_NAME'], $cookie, 0, "/", "", 0);

		unset($dbsettings);

		header("location:game.php?page=overview");
	}
}
else
{
	$parse['servername']      = $game_config['game_name'];
	$parse['forum_url']       = $game_config['forum_url'];
	$parse['recap_publickey'] = $publickey;
	display (parsetemplate(gettemplate('public/registry_form'), $parse), false, '',false, false);
}
?>
