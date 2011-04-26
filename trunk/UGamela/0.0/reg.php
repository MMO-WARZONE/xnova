<?php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

	
/* reg.php
perberos@hotmail.com
reg.php v1.0 beta build.3


*/
define('ADMINEMAIL',"ogamela@mihost.eu");
define('GAMEURL',"http://".$_SERVER['HTTP_HOST']."/");
include("common.php");
include(INCLUDES_PATH."lang/".DEFAULT_LANG."/lang_reg.php");
function sendpassemail($emailaddress, $password) {
$gamename = "Ugamela";
$staff = "The Rout Team ©";
$email = ADMINEMAIL;
$gameurl = GAMEURL;

$email = "Tu o alguien se registro en $gamename ($gameurl).

La siguiente contraseña se te envia para poder ingresar en el juego.

Tu nueva contraseña es: $password

Gracias por jugar, $staff.
$gameurl";

    $status = mymail($emailaddress, "Registro en $gamename", $email);
    return $status;
    
}

function mymail($to, $title, $body, $from = '') { // thanks to arto dot PLEASE dot DO dot NOT dot SPAM at artoaaltonen dot fi.

  $from = trim($from);

  if (!$from) {
   $from = '<'. ADMINEMAIL .'>';
  }

  $rp    = ADMINEMAIL;
  $org    = GAMEURL;
  $mailer = 'PHP';

  $head  = '';
  $head  .= "Content-Type: text/plain \r\n";
  $head  .= "Date: ". date('r'). " \r\n";
  $head  .= "Return-Path: $rp \r\n";
  $head  .= "From: $from \r\n";
  $head  .= "Sender: $from \r\n";
  $head  .= "Reply-To: $from \r\n";
  $head  .= "Organization: $org \r\n";
  $head  .= "X-Sender: $from \r\n";
  $head  .= "X-Priority: 3 \r\n";
  $head  .= "X-Mailer: $mailer \r\n";

  $body  = str_replace("\r\n", "\n", $body);
  $body  = str_replace("\n", "\r\n", $body);

  return mail($to, $title, $body, $head);
  
}



if($_POST){

  /*include("common.php");*/
 
  $errors = 0;
  $errorlist = "";
  
  //Diferentes errores que pueden surgir
  if(!is_email($_POST['email'])){ $errorlist .= "\"".$_POST['email']."\" No es un E-Mail valido.<br />"; $errors++; }
  if(!$_POST['hplanet']){ $errorlist .= "Falta el nombre del planeta principal.<br />"; $errors++; }
  if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet'])==1) { $errorlist .= "El nombre del planeta debe ser alfanumérico.<br />"; $errors++; }
  if(!$_POST['character']){ $errorlist .= "Falta el nombre de usuario.<br />"; $errors++; }
  //if (preg_match("/[^A-z0-9_\-]/", $_POST['character'])==1) { $errorlist .= "El nombre de usuario debe ser alfanumérico.<br />"; $errors++; }
  if($_POST['v'] != 2){ $errorlist .= "Utiliza el formulario del propio juego<br />"; $errors++; }
  if($_POST['agb'] != 'on'){ $errorlist .= "Tenes que aceptar el contrato de licencia.<br />" ; $errors++; }
  //Comprueba el nombre de usuario
  $user_array = doquery("SELECT `username` FROM {{table}} WHERE `username` = '{$_POST['character']}' LIMIT 1","users",true);
  if($user_array){ $errorlist .= "El nombre de usuario ya existe.<br />"; $errors++;}
  //Comprueba el E-Mail
  $user_array = doquery("SELECT `email` FROM {{table}} WHERE `email` = '{$_POST['email']}' LIMIT 1","users",true);
  if($user_array){ $errorlist .= "El E-Mail ya se encuentra registrado.<br />"; $errors++;}
  if($_POST['sex'] != '' && $_POST['sex'] != 'F' && $_POST['sex'] != 'M'){ $errorlist .= "Elegi un tipo de sexo.<br />"; $errors++;}
  if($errors != 0){
    //se muestra los errores
    error($errorlist,"Registrar");
	
  }else{
    //creamos la contraseña
    $newpass = '';
    for ($i=0; $i<8; $i++) { $newpass .= chr(rand(65,90)); }
    
	$md5newpass = md5($newpass);
    //creamos temporalmente el user
	doquery("INSERT INTO {{table}} (`id`, `username`, `password`, `email`, `email_2`, `sex`, `id_planet`, `register_time`) VALUES ('', '{$_POST['character']}', '$md5newpass', '{$_POST['email']}', '{$_POST['email']}', '{$_POST['sex']}', '0','".time()."');","users");

    //obtenemos el id del user
	$iduser_array = doquery("SELECT `id` FROM {{table}} WHERE `username` = '{$_POST['character']}' LIMIT 1","users",true);
	$iduser = $iduser_array['id'];
	//Seleccionamos una posicion
	while(!isset($newpos_checked)){
		$g = round(rand(1,9));
		$s = round(rand(1,499));
		$p = round(rand(1,15));
		
		$newpos = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$g' AND `system` = '$s' AND `planet` = '$p'  LIMIT 1","galaxy",true);
		if($newpos["id_planet"] == "0"){$newpos_checked = true;}
		if(!$newpos){
			doquery("INSERT INTO {{table}} ( `galaxy` , `system` , `planet` , `id_planet` , `metal` , `crystal`) VALUES ('$g', '$s', '$p', '0', '0', '0');","galaxy");
			$newpos_checked = true;
		}
		
	}
	//creamos el planeta
	doquery("INSERT INTO {{table}} (`id`, `galaxy` , `system` , `planet` , `name`, `id_owner`, `last_update`,`metal_perhour`, `crystal_perhour`) VALUES ('', '$g', '$s', '$p', '".$_POST['hplanet']."', '$iduser','".time()."','20','10');","planets");
	//obtenemos el id planet
	$idplanet_array = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '$iduser' LIMIT 1","planets",true);
	$idplanet = $idplanet_array['id'];
	//actualizamos el id planet del user
	doquery("UPDATE {{table}} SET `id_planet` = '$idplanet' , `current_planet` = '$idplanet', `galaxy` = '$g' , `system` = '$s' , `planet` = '$p' WHERE `id` = '$iduser' LIMIT 1","users");
	//actualizamos la galaxy
	doquery("UPDATE {{table}} SET `id_planet` = '$idplanet' WHERE `galaxy` = '$g' AND `system` = '$s' AND `planet` = '$p' LIMIT 1","galaxy");

	sendpassemail($_POST['email'],"$newpass");
	
	//mostramos el mensaje de que se creo correctamente
    message("Muchas Gracias por elegirnos.<br />En unos instantes recibiras un email con la contraseña ($newpass)","Registro completo");
    
  }
}else{ //Formulario simple de registro

echo_head("Registro");
echo <<<HTML
  <center>
  <h1><font size="24">{$lang['Register']}</font></h1>
  <h2>{$lang['Multiverse']}</h2>
  <p>
      <form action="" method="post">
    <table width="519" border="0" cellspacing="0" cellpadding="4">
     <tr>
      <td>{$lang['E-Mail']}</td>
      <td><input type="text" name="email" size="20" maxlength="40" /></td>
     </tr>
     <tr>
      <td>{$lang['MainPlanet']}</td>
       <td><input type="text" name="hplanet" size="20" maxlength="20" /></td>
     </tr>
     <tr>
      <td>{$lang['GameName']}</td>
      <td><input type="text" name="character" size="20" maxlength="20" /></td>
     </tr>
     <tr>
      <td>{$lang['Sex']}</td>
      <td><select name="sex">
          <option value="">{$lang['Indefinide']}</option>
          <option value="M">{$lang['Male']}</option>
          <option value="F">{$lang['Female']}</option>
        </select></td>
     </tr>
     <tr><td></td></tr>
               <input type="hidden" name="v" value="2" />
     <input type="hidden" name="partnerid" value="0" />
     <tr>
      <td colspan="2"><input type="checkbox" name="agb" />{$lang['accept']}</td>
     </tr>
     <tr>
      <td colspan="2"><center><input type="submit" value="{$lang['signup']}" /></center></td>
     </tr>
    </table>
      </form>
     </p>
  <center>
  </body>
<html>
HTML;
}

//  Timer, para comprobar la velocidad del scriptd
if ( isset($userrow['authlevel']) && $userrow['authlevel']== 3 ) {
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
