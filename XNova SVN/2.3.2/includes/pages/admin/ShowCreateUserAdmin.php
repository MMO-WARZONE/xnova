<?php
//version 1

function ShowCreateUserAdmin($user){
	global $lang,$db, $displays, $users;
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

if ($_POST)
{
	$errors = 0;
	$errorlist = "";

	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email']))
	{
		$errorlist .= $lang['cu_invalid_mail'];
		$errors++;
	}

	if (!$_POST['character'])
	{
		$errorlist .= $lang['cu_empty_user_field'];
		$errors++;
	}

	if (strlen($_POST['passwrd']) < 4)
	{
		$errorlist .= $lang['cu_password_lenght_error'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1)
	{
		$errorlist .= $lang['cu_user_field_no_alphanumeric'];
		$errors++;
	}

	$ExistUser = $db->query("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
	if ($ExistUser)
	{
		$errorlist .= $lang['cu_user_already_exists'];
		$errors++;
	}

	$ExistMail = $db->query("SELECT `email` FROM {{table}} WHERE `email` = '" . mysql_escape_string($_POST['email']) . "' LIMIT 1;", 'users', true);
	if ($ExistMail)
	{
		$errorlist .= $lang['cu_mail_already_exists'];
		$errors++;
	}

	if ($errors != 0)
	{
		$displays->message ($errorlist, "admin.php?page=createuser", "5", false, false);
	}
	else
	{
		$newpass	= $_POST['passwrd'];
		$UserName 	= $_POST['character'];
		$UserEmail 	= $_POST['email'];
		$random 	= $_POST['random'];
		$galaxy 	= $_POST['galaxy'];
		$system 	= $_POST['system'];
		$planet 	= $_POST['planet'];
		$md5newpass = md5($newpass);

		$QryInsertUser = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '" . mysql_escape_string(strip_tags(eregi_replace("'|\"", '', $UserName))) . "', ";
		$QryInsertUser .= "`email` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`email_2` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`ip_at_reg` = '" . $lang['cu_user'] . "', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '" . time() . "', ";
		$QryInsertUser .= "`password`='" . $md5newpass . "';";
		$db->query($QryInsertUser, 'users');

		$NewUser = $db->query("SELECT `id`,`username`,`email_2` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
		
                If($random == 'on'){

		$LastSettedGalaxyPos = $db->game_config['LastSettedGalaxyPos']!=0?$db->game_config['LastSettedGalaxyPos']:1;
		$LastSettedSystemPos = $db->game_config['LastSettedSystemPos']!=0?$db->game_config['LastSettedSystemPos']:1;
		$LastSettedPlanetPos = $db->game_config['LastSettedPlanetPos']!=0?$db->game_config['LastSettedPlanetPos']:1;

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
			$GalaxyRow = $db->query($QrySelectGalaxy, 'galaxy', true);

			if ($GalaxyRow["id_planet"] == "0")
				$newpos_checked = true;

			if (!$GalaxyRow)
			{
				CreateOnePlanetRecord ( $Galaxy, $System, $Planet, $NewUser['id'],
										$UserPlanet,'', '', '', true);
				$newpos_checked = true;
			}
			if ($newpos_checked)
			{
				$db->query("UPDATE {{table}} SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				$db->query("UPDATE {{table}} SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				$db->query("UPDATE {{table}} SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		$PlanetID = $db->query("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;" , 'planets', true);

		$QryUpdateUser = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '" . $PlanetID['id'] . "', ";
		$QryUpdateUser .= "`current_planet` = '" . $PlanetID['id'] . "', ";
		$QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
		$QryUpdateUser .= "`system` = '" . $System . "', ";
		$QryUpdateUser .= "`planet` = '" . $Planet . "' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '" . $NewUser['id'] . "' ";
		$QryUpdateUser .= "LIMIT 1;";
		$db->query($QryUpdateUser, 'users');
                }
                else{

			$QrySelectGalaxy = "SELECT * ";
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '" . $galaxy . "' AND ";
			$QrySelectGalaxy .= "`system` = '" . $system . "' AND ";
			$QrySelectGalaxy .= "`planet` = '" . $planet . "' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = $db->query($QrySelectGalaxy, 'galaxy', true);

			if ($GalaxyRow["id_planet"] == "0")
				$newpos_checked = true;

			if (!$GalaxyRow)
			{
				CreateOnePlanetRecord ( $galaxy, $system, $planet, $NewUser['id'],
										$UserPlanet,'', '', '', true);
				$newpos_checked = true;
			}

		$PlanetID = $db->query("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;" , 'planets', true);

		$QryUpdateUser = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '" . $PlanetID['id'] . "', ";
		$QryUpdateUser .= "`current_planet` = '" . $PlanetID['id'] . "', ";
		$QryUpdateUser .= "`galaxy` = '" . $galaxy . "', ";
		$QryUpdateUser .= "`system` = '" . $system . "', ";
		$QryUpdateUser .= "`planet` = '" . $planet . "' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '" . $NewUser['id'] . "' ";
		$QryUpdateUser .= "LIMIT 1;";
		$db->query($QryUpdateUser, 'users');
                }

		
		if($db->game_config["server_mail"]){
                    $url=dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";
                    $siteurlactivationlink = $url.'activate.php?hash='.base64_encode($NewUser['username']).'&stamp='.base64_encode($NewUser['id']);

                    $body ="Bienvenido a ".$db->game_config["game_name"]."<p>

                            Te has registrado con el siguiente nombre de usuario: ".$NewUser['username'] ."<br>
                            Y su contraseña es: ".$_POST['passwrd']." (conservala bien no podra recuperarlo)<p>

                            Para jugar en ".$db->game_config["game_name"]." es necesario que actives tu cuenta.<p>

                            Has click en el siguiente link para confirmar tu registro.<br>
                            <a href='".$siteurlactivationlink ."'>".$siteurlactivationlink ."</a><p>

                            Si no puedes entrar pulsando el enlace superior.<br>
                            Copia y pega el siguiente enlace en tu navegador y entra para validarte.<p>

                            Desde la Administración de ".$db->game_config["game_name"]." te agradecemos tu confianza<br>
                            Y esperamos que estes aqui durante mucho tiempo.";


                    include($svn_root.'includes/functions/classes/class.phpmailer.php');
                    $mail             = new PHPMailer();
                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->Host       = "mail.gmail.com"; 	// SMTP server
                    $mail->SMTPAuth   = true;               // enable SMTP authentication
                    $mail->SMTPSecure = $db->game_config["sec_mail"];              // sets the prefix to the servier
                    $mail->Host       = "smtp.gmail.com";   // sets GMAIL as the SMTP server
                    $mail->Port       = $db->game_config["port_mail"];                // set the SMTP port for the GMAIL server
                    $mail->Username   = $db->game_config["server_mail"];  // GMAIL username
                    $mail->Password   = $db->game_config["pass_mail"];        // GMAIL password

                    $mail->SetFrom($db->game_config["server_mail"], $db->game_config["game_name"]);
                    $mail->AddAddress($NewUser['email_2'], $NewUser['username']);
                    $mail->Subject    = "Registro de la cuenta.";
                    $mail->MsgHTML($body);
                    $mail->Send();
		}
		$from 		= $lang['cu_welcome_message_from'];
		$sender 	= $lang['cu_welcome_message_sender'];
		$Subject 	= $lang['cu_welcome_message_subject'];
		$message 	= $lang['cu_welcome_message_content'];
		$users->SendSimpleMessage($NewUser['id'], $sender, $Time, 1, $from, $Subject, $message);

		$db->query("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

/*		@include('config.php');
		$cookie = $NewUser['id'] . "/%/" . $UserName . "/%/" . md5($md5newpass . "--" . $dbsettings["secretword"]) . "/%/" . 0;
		setcookie($db->game_config['COOKIE_NAME'], $cookie, 0, "/", "", 0);

		unset($dbsettings);

		header("location:game.php?page=overview"); */
		
                $displays->message ($lang['cu_userok'],"admin.php?page=createuser",1);

	}
}
else
{
        $displays->assignContent("adm/create_user");

	$displays->display();
}

}
?>