<?php

/**
 * reg.php
 *
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true); //Definimos inside como verdadero
define('INSTALL' , false); //Definimos install como falso. 

$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)

	//comprobación ESTADO modulo Referido
	$query = doquery("SELECT estado FROM {{table}} where modulo='Referidos'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "1") { $ModuloRef = True; }
	//Fin comprobación
	//comprobación ESTADO modulo MultiCuenta
	$query = doquery("SELECT estado FROM {{table}} where modulo='Un_Registro_por_IP'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "1") { $Un_Registro_por_IP = True; }
	//Fin comprobación

includeLang('reg'); //Incluimos el archivo dfe idioma
	
//Funcion Enviar Email, no envia el mail de verdad
function sendpassemail($emailaddress, $password) {
	global $lang; //Cojemos la variable $lang
	$parse['gameurl']  = GAMEURL; 
	$parse['password'] = $password;
	$email             = parsetemplate($lang['mail_welcome'], $parse);
	$status            = mymail($emailaddress, $lang['mail_title'], $email);
	return $status; //Devolvemos status
}
//Funcion Mymail, no envia mail de verdad
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

if ($_POST) { //Si se envio el formulario
	$errors    = 0; //Ponemos los errores en 0
	$errorlist = ""; //lista de errores vacio
 
	$_POST['email'] = strip_tags($_POST['email']); //Si el Email
	if (!is_email($_POST['email'])) { //Si ya existe 
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	if (!$_POST['planet']) { //Si no existe nombre de planeta
		$errorlist .= $lang['error_planet']; //lista de errores, ponemos el error
		$errors++;  //Sumamos un error
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1) { //Si existe un caracter estraño en el nombre del planeta
		$errorlist .= $lang['error_planetnum']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	if (!$_POST['character']) { //Si no existe el nombre de usuario
		$errorlist .= $lang['error_character']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	if (strlen($_POST['passwrd']) < 4) { //Si no existe contraseña
		$errorlist .= $lang['error_password']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1) { //Si existe algun caracter estraño
		$errorlist .= $lang['error_charalpha']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}
		if($ModuloRef == True) { //Si el modulo esta abierto
	if (preg_match("/[^A-z0-9_\-]/", $_POST['refer']) == 1) {  //Si existe algun caracter estraño
		$errorlist .= "Error Caracteres no validos en el Referido."; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}
		}
	if ($_POST['rgt'] != 'on') { //Si no acepta los terminos
		$errorlist .= $lang['error_rgt']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
	if ($ExistUser) { //Si existe el usuario
		$errorlist .= $lang['error_userexist']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}

	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);
	if ($ExistMail) { //Si existe el mail
		$errorlist .= $lang['error_emailexist']; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}
	
	session_start();
    $capchaoriginal = $_REQUEST["captcha"]; //Pedimos el capcha
    if($_SESSION['captcha'] != $capchaoriginal){ //Si no son iguales 
    $errorlist .= "Codigo de seguridad incorrecto"; //Mostramos error
    $errors++;   //Sumamos error
    }
	
	//Esto es para verificar si existe ya un usuario con esa ip.
	if($Un_Registro_por_IP == True) { //Si el modulo esta ON
	$LaIP = getIP();
	$ExistIP = doquery("SELECT `reg_ip` FROM {{table}} WHERE `reg_ip` = '".$LaIP."' LIMIT 1;", 'users', true);
	if ($ExistIP) { //Si existe al ip
		$errorlist .= "Usted ya se ha registrado, no puede tener multicuenta"; //lista de errores, ponemos el error
		$errors++; //Sumamos un error
	}
	}
	
	if($ModuloRef == True) {
	//Esto comprueba si ahi referer
	$ExistRefer = doquery("SELECT `id`, `username` FROM {{table}} WHERE `username` = '".mysql_escape_string($_POST['refer'])."' LIMIT 1;", 'users', true);
	if($ExistRefer) { $referido = true;	} //Si existe lo ponemos verdadero
	}

	if ($_POST['sex'] != ''  &&
		$_POST['sex'] != 'F' &&
		$_POST['sex'] != 'M') {
		$errorlist .= $lang['error_sex']; //lista de errores, ponemos el error
		$errors++;
	}

	if ($errors != 0) { //Si error no es 0, damos un mensaje con los errores.
		message ($errorlist, $lang['Register']);
	} else { //y si es 0 definimos las variables
		$newpass        = $_POST['passwrd']; 
		$UserName       = CheckInputStrings ( $_POST['character'] );
		$UserEmail      = CheckInputStrings ( $_POST['email'] );
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );
		$IP = getIP(); 
		
		$md5newpass     = md5($newpass); //Contraseña en md5
		// Creamos la query
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '". mysql_escape_string(strip_tags( $UserName )) ."', ";
		$QryInsertUser .= "`email` = '".    mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`email_2` = '".  mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`sex` = '".      mysql_escape_string( $_POST['sex'] )         ."', ";
		$QryInsertUser .= "`reg_ip` = '".$IP."', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		if($referido == True) { $QryInsertUser .= "`refer` = '".$ExistRefer[0]."', "; }
		$QryInsertUser .= "`register_time` = '". time() ."', ";
		$QryInsertUser .= "`password`='". $md5newpass ."';";
		doquery( $QryInsertUser, 'users');
		
		if($referido == true) {
		//Actualizamos los puntos del referido
		$QryInsertUser  = "UPDATE {{table}} SET ";
		$QryInsertUser .= "`metal` = metal+3000, ";
		$QryInsertUser .= "`crystal` = crystal+2500, ";
		$QryInsertUser .= "`deuterium` = deuterium+2000 ";
		$QryInsertUser .= "WHERE `id_owner` = '".$ExistRefer[0]."' order by id asc limit 1;";
		doquery( $QryInsertUser, 'planets');
		}
		
		//Sacamos el id del usuario registrado
		$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
		$iduser         = $NewUser['id'];

		//Sacamos los datos de donde colocar el planeta
		$LastSettedGalaxyPos  = $game_config['LastSettedGalaxyPos'];
		$LastSettedSystemPos  = $game_config['LastSettedSystemPos'];
		$LastSettedPlanetPos  = $game_config['LastSettedPlanetPos'];
		
		while (!isset($newpos_checked)) { //mientras no exista esa variable
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
			//Miramos si el campo esta libre
			$QrySelectGalaxy  =	"SELECT * ";
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = doquery( $QrySelectGalaxy, 'galaxy', true);
			
			//Si es asi, ponemos la variable true
			if ($GalaxyRow["id_planet"] == "0") {
				$newpos_checked = true;
			}
			
			//Creamos el planeta
			if (!$GalaxyRow) {
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
				$newpos_checked = true;
			}
			//Actualizamos la db
			if ($newpos_checked) {
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedGalaxyPos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedSystemPos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedPlanetPos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		
		//Sacamos la id del planeta
		$PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

		//Actualizamos el  planeta
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

		//Actualizamos la cantidad de users
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
	
		//ponemos en la variable menssage el mensaje de bienvenido
		$Message  = $lang['thanksforregistry'];
		if (sendpassemail($_POST['email'], "$newpass")) { //Si se envia el mail
			$Message .= " (" . htmlentities($_POST["email"]) . ")"; //enviamos un mensaje por pantalla
		} else { //y si no
			$Message .= " (" . htmlentities($_POST["email"]) . ")"; //mensaje del email 
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $newpass . "</b>"; //Mensaje de error
		}
		$Message .= "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=index.php\"> "; //refrescamos
		message( $Message, $lang['reg_welldone']); //ponemos el mensaje.
	}
} else {
	//parseamos
	$parse               = $lang;
		if($ModuloRef == True) {
	$parse['celdarefer'] .= "<tr>";
	$parse['celdarefer'] .= "<th>Referido</th>";
	$parse['celdarefer'] .= "<th><input name=\"refer\" size=\"20\" maxlength=\"20\" type=\"text\" onKeypress=\"if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;  if (event.which==60 || event.which==62) return false;\"></th>";
	$parse['celdarefer'] .= "</tr>";
	}
	$parse['elref'] = $_GET['ref'];
	$parse['servername'] = $game_config['game_name'];
	$page                = parsetemplate(gettemplate('registry_form'), $parse);

	display ($page, $lang['registry'], false);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
?>
