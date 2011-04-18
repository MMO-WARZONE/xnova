<?php  //reg.php :: Registro v1.0 beta build.3


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

define('ADMINEMAIL',"ugamela@");
define('GAMEURL',"http://".$_SERVER['HTTP_HOST']."/");

includeLang('reg');


function sendpassemail($emailaddress, $password) {

	$gamename = "Ugamela";
	$staff = "The Rout Team ";
	$email = ADMINEMAIL;
	$gameurl = GAMEURL;

	$email = "Tu o alguien se registro en $gamename ($gameurl).

La siguiente contrase&ntilde;a se te envia para poder ingresar en el juego.

Tu nueva contrase&ntilde;a es: $password

Gracias por jugar, $staff.
$gameurl";

    $status = mymail($emailaddress, "Registro en $gamename", $email);
    return $status;
    
}

function mymail($to, $title, $body, $from = '') {

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
	if(!is_email($_POST['email'])){
		
		$errorlist .= "\"".$_POST['email']."\" ".$lang['error_mail'];
		$errors++;
		
	}
	if(!$_POST['hplanet']){
		$errorlist .= $lang['error_hplanet'];
		$errors++;
	}
	if(preg_match("/[^A-z0-9_\-]/", $_POST['hplanet'])==1) {
		$errorlist .= $lang['error_hplanetnum'];
		$errors++;
	}
	if(!$_POST['character']){
		$errorlist .= $lang['error_character'];
		$errors++;
	}
	if (preg_match("/[^A-z0-9_\-]/", $_POST['character'])==1){
		$errorlist .= "El nombre de usuario debe ser alfanuméico.<br />";
		$errors++;
	}
	if($_POST['v'] != 2){
		$errorlist .= $lang['error_v'];
		$errors++;
	}
	if($_POST['agb'] != 'on'){
		$errorlist .= $lang['error_agb'];
		$errors++;
	}
	//Comprueba el nombre de usuario
	$user_array = doquery("SELECT `username` FROM {{table}} WHERE `username` = '{$_POST['character']}' LIMIT 1","users",true);
	
	if($user_array){
		$errorlist .= $lang['error_userexist'];
		$errors++;
	}
	//Comprueba el E-Mail
	$user_array = doquery("SELECT `email` FROM {{table}} WHERE `email` = '{$_POST['email']}' LIMIT 1","users",true);
	
	if($user_array){
		$errorlist .= $lang['error_emailexist'];
		$errors++;
	}
	
	if($_POST['sex'] != '' && $_POST['sex'] != 'F' && $_POST['sex'] != 'M'){
		$errorlist .= $lang['error_sex'];
		$errors++;
	}
	if($errors != 0){
		//se muestra los errores
		message($errorlist,$lang['Register']);
		
	}else{
		//creamos la contraseña
		$newpass = '';
		for ($i=0; $i<8; $i++) {
			$newpass .= chr(rand(65,90));
		}
		$md5newpass = md5($newpass);
		//creamos temporalmente el user
		doquery("INSERT INTO {{table}} SET 
			`username`='{$_POST['character']}',
			`password`='{$md5newpass}',
			`email`='{$_POST['email']}',
			`email_2`='{$_POST['email']}',
			`sex`='{$_POST['sex']}',
			`id_planet`='',
			`register_time`='".time()."'"
			,'users');
		//obtenemos el id del user
		$iduser_array = doquery("SELECT `id` FROM {{table}} WHERE `username` = '{$_POST['character']}' LIMIT 1","users",true);
		$iduser = $iduser_array['id'];
		//Seleccionamos una posicion
		while(!isset($newpos_checked)){
			
			//$g = round(rand(1,9));
			//$s = round(rand(1,499));
			//$p = round(rand(4,12));
			
			$id_g = $game_config['id_g'];
			$id_s = $game_config['id_s'];
			$id_p = $game_config['id_p'];
			
			for($x=$id_g;$x<=10;$x++)
			{
				for($y=$id_s;$y<=500;$y++)
				{									
					for($z=id_p;$z<=4;$z++)
					{
						$g = $x;
						$s = $y;
						$p = round(rand(4,12));
						
						
						switch($id_p)
						{
							case 1: $id_p = $id_p +1;break;
							case 2: $id_p = $id_p +1;break;
							case 3: if($id_s == 499)
									{
										$id_g = $id_g +1;	
										$id_s = 1;
										$id_p = 1;break;
									}else 
									$id_p =1;
									$id_s=$id_s+1;break;
									
						}
						
						
						
						break;
					}
					break;
				}
				break;
			}
			
			
			doquery("UPDATE {{table}} SET `config_value`='{$id_g}' WHERE `config_name`='id_g'",'config');
			doquery("UPDATE {{table}} SET `config_value`='{$id_s}' WHERE `config_name`='id_s'",'config');
			doquery("UPDATE {{table}} SET `config_value`='{$id_p}' WHERE `config_name`='id_p'",'config');
			
			$newpos = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$g' AND `system` = '$s' AND `planet` = '$p'  LIMIT 1","galaxy",true);
			
			if($newpos["id_planet"] == "0"){$newpos_checked = true;}
			
			if(!$newpos){
				//esta funcion crea un planeta? o una colonia?
				make_planet($g,$s,$p,$iduser,$_POST['hplanet']);
				$newpos_checked = true;
			}
			
		}
		//Ahora agregamos los campos maximos
		$diameter = ($game_config['initial_fields'] ^ (14 / 1.5)) * 75 ;
		doquery("UPDATE {{table}} SET
			diameter='{$diameter}',
			field_max='{$game_config['initial_fields']}'
			WHERE id_owner='{$iduser}' LIMIT 1",'planets');
		//
		//obtenemos el id planet
		$idplanet_array = doquery("SELECT `id` FROM {{table}} WHERE id_owner='{$iduser}' LIMIT 1",'planets',true);
		
		$idplanet = $idplanet_array['id'];
		//actualizamos el id planet del user
		doquery("UPDATE {{table}} SET
			id_planet='{$idplanet}',
			current_planet='{$idplanet}',
			galaxy='{$g}',
			system='{$s}',
			planet='{$p}'
			WHERE `id` = '{$iduser}' LIMIT 1","users");
		//agregamos un contador de usuario,
		doquery("UPDATE {{table}} SET config_value=config_value+1 WHERE config_name='users_amount' LIMIT 1","config");
		
		//nos fijamos si es una cuenta admin
		if($_POST['character'] == 'admin'){
			doquery("UPDATE {{table}} SET `authlevel` = '1' WHERE `username` = 'admin' LIMIT 1","users");
		}
		
		
		if(sendpassemail($_POST['email'],"$newpass"))
		//mostramos el mensaje de que se creo correctamente
		message($lang['thanksforregistry']." ($newpass)",$lang['reg_welldone']);
		else
		
		//mostramos el mensaje de que se creo correctamente
		message($lang['thanksforregistry']." ($newpass)Error",$lang['reg_welldone']);
		
	}

}else{ //Formulario simple de registro

	$parse = $lang;
	$page = parsetemplate(gettemplate('registry_form'), $parse);
	
	display($page,$lang['registry']);
}


// Created by Perberos. All rights reversed (C) 2006
?>
