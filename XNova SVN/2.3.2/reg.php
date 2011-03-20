<?php
//version 1.2
session_start();


define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$svn_root = './';
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.' . $phpEx);

includeLang('PUBLIC');

if ($_POST)
{
	$errors = 0;
	$errorlist = "";

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

        if(function_exists("gd_info") && $db->game_config["captcha"]!=0){
            if (!preg_match("/(".$_SESSION['CAPTCHAString'].")/i",$_POST['captchastring'])
                     ){
                $errorlist .= $lang['error_captcha'];
                $errors++;
            }
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

	$ExistUser = $db->query("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
	if ($ExistUser)
	{
		$errorlist .= $lang['user_already_exists'];
		$errors++;
	}

	$ExistMail = $db->query("SELECT `email` FROM {{table}} WHERE `email` = '" . mysql_escape_string($_POST['email']) . "' LIMIT 1;", 'users', true);
	if ($ExistMail)
	{
		$errorlist .= $lang['mail_already_exists'];
		$errors++;
	}

	if ($errors != 0)
	{
		//$displays->message ($errorlist, "reg.php", "3", false, false);
                
                echo "1||".$errorlist;
	}
	else
	{
                $darkmatter="10000";
                if($_POST['ref']!=""){
                   $comp1 = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". $_POST['ref'] ."';", 'users', true);
                   if($comp1['id']!="")
                      doquery("UPDATE {{table}} SET `darkmatter`= darkmatter + {$darkmatter} WHERE `id`='".$comp1['id']."' limit 1;", "users");
                }
		$newpass	= $_POST['passwrd'];
		$UserName 	= $_POST['character'];
		$UserEmail 	= $_POST['email'];
		$md5newpass = md5($newpass);

		$QryInsertUser = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '" . mysql_escape_string(strip_tags(preg_replace("('|\")", '', $UserName))) . "', ";
		$QryInsertUser .= "`email` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`email_2` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`ip_at_reg` = '" . $_SERVER["REMOTE_ADDR"] . "', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '" . time() . "', ";
                $activacion=explode(",",$db->game_config["act_mail"]);
                if(!$activacion[0]){
                    $QryInsertUser .= "`activate_status` = '" . time() . "', ";
                }
		$QryInsertUser .= "`password`='" . $md5newpass . "';";

		$db->query($QryInsertUser, 'users');

		$NewUser = $db->query("SELECT `id`,`username`,`email_2` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
		

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



		$act_mail=explode(",",$db->game_config["act_mail"]);
		if($act_mail[0]==1){
                    $url=dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";
                    $siteurlactivationlink = $url.'activate.php?hash='.base64_encode($NewUser['username']).'&stamp='.base64_encode($NewUser['id']);

                    $body =$lang["op_confirmation"];
			$body=preg_replace("(:server:)",$db->game_config["game_name"], $body);
                        
                        $pass=preg_replace("(:pass:)",$_POST['passwrd'], $lang['op_confimation_pass']);
                        $body=preg_replace("({pass})",$pass, $body);
			$body=preg_replace("(:url_link:)",$siteurlactivationlink, $body);
                        $body=preg_replace("(:username:)",$CurrentUser['username'], $body);


                    include($svn_root.'includes/functions/classes/class.phpmailer.php');
                    $mail             = new PHPMailer();
                    $mail->ContentType = "text/html";
                    $mail->CharSet = "utf-8";
                        (string)$user_mail=$db->game_config["user_mail"]."@".$db->game_config["smtp_mail"];
                    if($act_mail[1]==1){
                        (string)$smtp_mail="mail.".$db->game_config["smtp_mail"];
                        (string)$smtp_mail_2="smtp.".$db->game_config["smtp_mail"];
                        $mail->IsSMTP(); // telling the class to use SMTP
                        $mail->Host       = $smtp_mail; 	// SMTP server
                        $mail->SMTPAuth   = true;               // enable SMTP authentication
                        $mail->SMTPSecure = $db->game_config['sec_mail'];              // sets the prefix to the servier
                        $mail->Host       = $smtp_mail_2; 	// SMTP server
                        $mail->Port       = $db->game_config["port_mail"];                // set the SMTP port for the GMAIL server
                        $mail->Username   = $user_mail;  // GMAIL username
                        $mail->Password   = $db->game_config["pass_mail"];        // GMAIL password
                    }
                    $mail->SetFrom($user_mail, $db->game_config["game_name"]);
                    $mail->AddAddress($NewUser['email'], $NewUser['username']);
                    $mail->Subject    = "Registro de la cuenta.";
                    $mail->MsgHTML($body);
                    $mail->Send();
		}
		$from 		= $lang['welcome_message_from'];
		$sender 	= $lang['welcome_message_sender'];
		$Subject 	= $lang['welcome_message_subject'];
		$message 	= $lang['welcome_message_content'];
		$users->SendSimpleMessage($NewUser['id'], $sender, $Time, 1, $from, $Subject, $message);
                
                $user_mount = $db->query("SELECT count(id) as count FROM {{table}}", 'users', true);
		$user_mounts =$user_mount["count"]+1;

                $db->query("UPDATE {{table}} SET `config_value` = '{$user_mounts}' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
                echo "0||Cuenta Creada con exito";
	}
}else{
    header("location: ./");
}
    /*
}
else
{
        $displays->assignContent("login/registry_form");
        if($db->game_config["captcha"]!=0 && function_exists("gd_info")){
            $displays->newblock("captcha");
        }
	$lang['servername']   = $db->game_config['game_name'];
	$lang['forum_url']    = $db->game_config['forum_url'];
        
	$displays->display();
}*/
?>