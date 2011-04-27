<?php

/**
 * login.php
 * copyright  by ?????? for XNova
 * Comentado por SainT
 **/

define('INSIDE'  , true); //Definimos inside como verdadero
define('INSTALL' , false); //Definimos install como falso. 


@session_destroy();  //Borramos las sesiones (@ para que no muestre si ahi algun error)

$InLogin = true; //ponemos la variable $InLogin como verdadera

$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
includeLang('login'); //incluimos el archivo de idioma login ( atraves de una funcion )

	checkban($_SERVER['REMOTE_ADDR']); //es una funcion que comprueba si la ip esta baneada ( MOD por lyra )

	if ($_POST) { //Si existe $_POST (Enviaron el formulario mediante el metodo _POST)
		$login = doquery("SELECT * FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' LIMIT 1", "users", true); //Buscamos los datos en la db del usuario puesto en el formulario.

		if ($login) { //Si se encontro algun resultado.
			if ($login['password'] == md5($_POST['password'])) { //Si la contraseña coincide con la de la db (codificada en md5).
				
				include($ugamela_root_path . 'config.' . $phpEx); //incluimos el archivo config
				
				$_SESSION[USER_SESSION][id] = $login['id']; //Creamos la sesion id.
				$_SESSION[USER_SESSION][username] = $login['username']; //Creamos la sesion username.
				$_SESSION[USER_SESSION][password] = md5($login["password"] . "--" . $dbsettings["secretword"]); //Creamos la sesion password.
				$_SESSION[USER_SESSION][ip] = getIP(); //Creamos la sesion ip.
				
				// || Se actualiza en la base de datos la ultima ip que uso ee nick. 
				$Upd  = "UPDATE {{table}} SET ";
				$Upd .= "`user_lastip` = '" . $_SESSION[USER_SESSION][ip] . "'";
				$Upd .= " WHERE ";
				$Upd .= "`id` = " . $login['id'] . " LIMIT 1;";
				doquery($Upd, 'users');
					
				unset($dbsettings); //se borra la variable $dbsettings (por seguridad)
				header("Location: ./frames.php"); //reidirigimos a frames.php
				exit; //Salimos.
			} else { //si las contraseñas no son iguales.
				message($lang['Login_FailPassword'], $lang['Login_Error']); //Mensaje de error.
			}
		} else { //Si no se encontro ningun usuario.
			message($lang['Login_FailUser'], $lang['Login_Error']); //Mensaje de error
		}
	} else { //Si no se envio el formulario aun....
		$parse = $lang; //Cargamos en la variable $parse, la variable $lang (Son arrays ambos)
		$query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true); //Sacamos el ultimo usuario registrados
		$parse['last_user'] = $query['username']; //y lo definimos como last_user
		$query = mysql_fetch_row(doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-(15*60)), 'users')); //Sacamos la cantidad de usuarios conectados en los ultimos 15 minutos.
		$parse['online_users'] = $query[0]; //lo definimos como online_users
		$MaxUsers = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0' OR `db_deaktjava` = '1';", 'users', true); //Sacamos los usuarios registrados
		$parse['users_amount'] = $MaxUsers['count']; //lo definimos como users_amount
		$parse['servername'] = $game_config['game_name']; //definimos el nombre del servidor ocmo servername
		$parse['forum_url'] = $game_config['forum_url']; //Definimos la url del foro como forum url
		$parse['PasswordLost'] = $lang['PasswordLost']; //definimos contraseña perdida, en el idioma escojido

		$page = parsetemplate(gettemplate('login_body'), $parse); //Guardamos en la variable $page, todo el codigo a mostrar y elejimos el tpl
		display($page, $lang['Login']); //Con la funcion display mostramos todo, y ponemos el titulo a la pagina.
	}


?>
