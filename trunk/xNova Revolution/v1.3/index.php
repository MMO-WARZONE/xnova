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

define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

includeLang('PUBLIC');
$parse = $lang;
switch($_GET[page])
{
	case'lostpassword':
		function sendnewpassword($mail)
		{
			global $lang;

			$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $mail ."' LIMIT 1;", 'users', true);

			if (empty($ExistMail['email']))
			{
				message($lang['mail_not_exist'], "index.php?modo=claveperdida",2, false, false);
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
				$Body 	= $lang['mail_text'];
				$Body  .= $NewPass;
				mail($mail,$Title,$Body);
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
		    $parse['servername']   = $game_config['game_name'];
			$parse['forum_url']    = $game_config['forum_url'];
			display(parsetemplate(gettemplate('public/lostpassword'), $parse), false, '',false, false);
		}
	break;
	default:
	$Sum    =    doquery("SELECT COUNT(*) AS `fleets` FROM {{table}} WHERE 1", "fleets", true);
        $parse['suma']    =    $Sum['fleets'];  
        $reg_users                = doquery('SELECT COUNT(*) as `players` FROM {{table}} WHERE 1', 'users', true);
        $parse['users_amount']     = $reg_users['players'];
        $last_user                = doquery('SELECT `username` FROM {{table}} ORDER BY `register_time` DESC', 'users', true);
        $parse['last_user']        = $last_user['username'];
        $online_users             = doquery("SELECT COUNT(DISTINCT(id)) as `onlinenow` FROM {{table}} WHERE `onlinetime` > '" . (time()-900) ."';", 'users', true);
        $parse['online_users']     = $online_users['onlinenow'];
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
		}
		else
		{
			$parse['servername']   = $game_config['game_name'];
			$parse['forum_url']    = $game_config['forum_url'];

		display(parsetemplate(gettemplate('public/index_body'), $parse), false, '',false, false);
		}
}
?>
