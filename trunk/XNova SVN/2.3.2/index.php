<?php
//version 1.2


define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$svn_root = './';
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.' . $phpEx);

includeLang('PUBLIC');



switch($_GET[page])
{
	case'lostpassword':
		
                //variables 1= error; 0=correcto
		if($_POST)
		{
                        $ExistMail = $db->query("SELECT `email`,`username` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST["email"]) ."' LIMIT 1;", 'users', true);

			if (empty($ExistMail['email']))
			{
				echo "1||".$lang['mail_not_exist'];
			}
			else
			{
                                $act_mail=explode(",",$db->game_config["act_mail"]);
                                if($act_mail[0]==1){
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


                                    $NewPassSql = md5($NewPass);
                                    
                                    $body =$lang['mail_pass'];
                                    $body=preg_replace("(:server:)",$db->game_config["game_name"], $body);
                                    $body=preg_replace("({pass})",$NewPass, $body);
                                    $body=preg_replace("(:username:)",$ExistMail['username'], $body);

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
                                    $mail->AddAddress($ExistMail['email'], $ExistMail['username']);                                   
                                    $mail->Subject    = "Recuperación de contraseña.";
                                    $mail->MsgHTML($body);
                                    if(!$mail->Send()){
                                         echo "1||Error en el envio";
                                    }else{
                                        $QryPassChange = "UPDATE {{table}} SET ";
                                        $QryPassChange .= "`password` ='". $NewPassSql ."' ";
                                        $QryPassChange .= "WHERE `email`='". $ExistMail['email'] ."' LIMIT 1;";
                                        $db->query( $QryPassChange, 'users');
                                        echo "0||".$lang['mail_sended'];
                                        exit;
                                    }
                                    
                                }else{
                                    echo "1||No esta activado la recuperacion de contraseña";
                                    exit;
                                }
                                
                    }
		}else{
                    header("location: ./");
                }
		
	break;
	default:

		if ($_POST)
		{
			$login = $db->query("SELECT `id`,`username`,`password`,`banaday`
					 FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "'
					 AND `password` = '" . md5(mysql_escape_string($_POST['password'])) . "' LIMIT 1", "users", true);

			if($login['banaday'] <= time() && $login['banaday'] != '0')
			{
				$db->query("UPDATE {{table}} SET `banaday` = '0', `bana` = '0' WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
				$db->query("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
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

				//@include('config.php');
				$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie($db->game_config['COOKIE_NAME'],  encrypt($cookie) , $expiretime, "/", "", 0);

				$db->query("UPDATE `{{table}}` SET `current_planet` = `id_planet` WHERE `id` ='".$login["id"]."'", 'users');

                                // Guardar ultimo loguin
                                $Upd  = "UPDATE {{table}} SET ";
                                $Upd .= "`user_lastlogin` = '". time() ."' ";
                                $Upd .= " WHERE ";
                                $Upd .= "`id` = " . $login['id'] . " LIMIT 1;";
                                $db->query($Upd, 'users');
                                //Fin ultimo login

                                // Guardar log de ip
                                $QryInsertlogip  = "INSERT INTO {{table}} SET ";
                                $QryInsertlogip .= "`username` = '". mysql_escape_string($login['username'] ) ."', ";
                                $QryInsertlogip .= "`userid` = '".    mysql_escape_string($login['id']) ."', ";
                                $QryInsertlogip .= "`user_ip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
                                $QryInsertlogip .= "`date` = '". time() ."' ";
                                $db->query( $QryInsertlogip, 'iplog');
                                //fin log de ip



				unset($dbsettings);
				header("Location: ./game.php?page=overview");
				exit;
			}
			else
			{
				$displays->message($lang['login_error'],false,false,false,false);
			}
		}
		else
		{
                        $displays->assignContent("login/index_body",false,false,false,false);
			$displays->assign('servername', $db->game_config['game_name']);
			$displays->assign('forum_url', $db->game_config['forum_url']);
                        $displays->assign('ref', $_GET["ref"]);
                        if($db->game_config["captcha"]!=0 && function_exists("gd_info")){
                            $displays->newblock("captcha");
                        }
                        $displays->display();
                }

}

?>