<?php

/**
 * options.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 * Comentado por saint
 */


	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 

	$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	includeLang('options'); //cargamos el .mo de options

//bloqueamos usuarios que no esten logeados
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

$lang['PHP_SELF'] = 'options.' . $phpEx; //ponemos la direcion del archivo como options.php en el array

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"]; //si el usuario no tiene ningun skin definido se le pone uno default
$mode = $_GET['mode']; //modo, el que defina la variable de la url

//FIX MODOD VACACIONES
if ($_POST && $mode == "exit") { // Si enviaron formulario, y el modo es exit

   if (isset($_POST["exit_modus"]) && $_POST["exit_modus"] == 'on' and $user['urlaubs_until'] <= time()){ //
      $urlaubs_modus = "0";
      doquery("UPDATE {{table}} SET   
         `urlaubs_modus` = '0',
         `urlaubs_until` = '0'
         WHERE `id` = '".$user['id']."' LIMIT 1", "users");   
      $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
      message($lang['succeful_save'], $lang['Options'],"options.php",1);
   }else{
   $urlaubs_modus = "1";
   $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
   message($lang['You_cant_exit_vmode'], $lan['Error'] ,"options.php",1);
   }
}
//FIN FIX
if ($_POST && $mode == "change") { // Array ( [db_character]
if (isset($_POST['halloffame'])) {
doquery("UPDATE {{table}} SET hof='1' where id='{$user['id']}';", 'users');
} else {
doquery("UPDATE {{table}} SET hof='0' where id='{$user['id']}';", 'users');
}
if($_POST['vis_galaxy'] != $user['vis_galaxy']) {  //Si enviaron el post y es distinto a el que estaba
doquery("UPDATE {{table}} SET vis_galaxy='{$_POST['vis_galaxy']}' where id='{$user['id']}';", 'users');
}
if($_POST['vis_messages'] != $user['vis_messages']) {  //Si enviaron el post y es distinto a el que estaba
doquery("UPDATE {{table}} SET vis_messages='{$_POST['vis_messages']}' where id='{$user['id']}';", 'users');
}
	$iduser = $user["id"];
	$avatar = $_POST["avatar"];
	$dpath = $_POST["dpath"];

	// Gestion des options speciales pour les admins
	if ($user['authlevel'] > 0) {
		if ($_POST['adm_pl_prot'] == 'on') {
			doquery ("UPDATE {{table}} SET `id_level` = '".$user['authlevel']."' WHERE `id_owner` = '".$user['id']."';", 'planets');
		} else {
			doquery ("UPDATE {{table}} SET `id_level` = '0' WHERE `id_owner` = '".$user['id']."';", 'planets');
		}
	}

	// Mostrar skin
	if (isset($_POST["design"]) && $_POST["design"] == 'on') {
		$design = "1";
	} else {
		$design = "0";
	}
	// Desactivar comprobaci? de IP
	if (isset($_POST["noipcheck"]) && $_POST["noipcheck"] == 'on') {
		$noipcheck = "1";
	} else {
		$noipcheck = "0";
	}
//INICIO FIX Usuarios y correos el options.php
   // Nombre de usuario
   if ($_POST["db_character"] <> $user["username"] AND $_POST["db_character"] <> '') {
      $checkuser = doquery("SELECT username FROM {{table}} WHERE username = '$_POST[db_character]'", 'users');
      $user_exist = mysql_num_rows($checkuser);
      if ($user_exist > 0) {
          $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
         message('El nombre de usuario ya esta en uso','Error', 'options.php');
      } else {
         $username = CheckInputStrings ( $_POST['db_character'] );
      }
   } else {
      $username = $user['username'];
   }
   // Adresse e-Mail
   if ($_POST["db_email"] <> $user["email"] AND $_POST["db_email"] <> '') {
      $checkemail = doquery("SELECT email, email_2 FROM {{table}} WHERE email = '$_POST[db_email]' OR email_2 = '$_POST[db_email]'", 'users');
      $email_exist = mysql_num_rows($checkemail);
      if ($email_exist > 0) {
          $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
         message('La cuenta de correo ya esta en uso','Error', 'options.php');
      } else {
         $db_email = CheckInputStrings ( $_POST['db_email'] );
      }
   } else {
      $db_email = $user['email'];
   }
//FIN FIX   
	// Cantidad de sondas de espionaje
	if (isset($_POST["spio_anz"]) && is_numeric($_POST["spio_anz"])) {
		$spio_anz = $_POST["spio_anz"];
	} else {
		$spio_anz = "1";
	}
	// Mostrar tooltip durante
	if (isset($_POST["settings_tooltiptime"]) && is_numeric($_POST["settings_tooltiptime"])) {
		$settings_tooltiptime = $_POST["settings_tooltiptime"];
	} else {
		$settings_tooltiptime = "1";
	}
	// Maximo mensajes de flotas
	if (isset($_POST["settings_fleetactions"]) && is_numeric($_POST["settings_fleetactions"])) {
		$settings_fleetactions = $_POST["settings_fleetactions"];
	} else {
		$settings_fleetactions = "1";
	} //
	// Mostrar logos de los aliados
	if (isset($_POST["settings_allylogo"]) && $_POST["settings_allylogo"] == 'on') {
		$settings_allylogo = "1";
	} else {
		$settings_allylogo = "0";
	}
	// Espionaje
	if (isset($_POST["settings_esp"]) && $_POST["settings_esp"] == 'on') {
		$settings_esp = "1";
	} else {
		$settings_esp = "0";
	}
	// Escribir mensaje
	if (isset($_POST["settings_wri"]) && $_POST["settings_wri"] == 'on') {
		$settings_wri = "1";
	} else {
		$settings_wri = "0";
	}
	// A?dir a lista de amigos
	if (isset($_POST["settings_bud"]) && $_POST["settings_bud"] == 'on') {
		$settings_bud = "1";
	} else {
		$settings_bud = "0";
	}
	// Ataque con misiles
	if (isset($_POST["settings_mis"]) && $_POST["settings_mis"] == 'on') {
		$settings_mis = "1";
	} else {
		$settings_mis = "0";
	}
	// Ver reporte
	if (isset($_POST["settings_rep"]) && $_POST["settings_rep"] == 'on') {
		$settings_rep = "1";
	} else {
		$settings_rep = "0";
	}
	// FIX MODO VACACIONES
	if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on') {
		if(CheckIfIsBuilding($user)){
		$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			message($lang['Building_something'], $lang['Error'], "options.php",1);

		}          
		$urlaubs_modus = "1";
          $time = time() + 86400;
           doquery("UPDATE {{table}} SET   
          `urlaubs_modus` = '$urlaubs_modus',
          `urlaubs_until` = '$time'
          WHERE `id` = '$iduser' LIMIT 1", "users");

          $query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$user['id']}'", 'planets');
          while($id = mysql_fetch_array($query)){
             doquery("UPDATE {{table}} SET
               metal_perhour = '".$game_config['metal_basic_income']."',
               crystal_perhour = '".$game_config['metal_basic_income']."',
               deuterium_perhour = '".$game_config['metal_basic_income']."',
               energy_used = '0',
               energy_max = '0',
               metal_mine_porcent = '0',
               crystal_mine_porcent = '0',
               deuterium_sintetizer_porcent = '0',
               solar_plant_porcent = '0',
               fusion_plant_porcent = '0',
               solar_satelit_porcent = '0'
             WHERE id = '{$id['id']}' AND `planet_type` = 1 ", 'planets');
          }
	  } else {
		$urlaubs_modus = "0";
	}
	// Borrar cuenta
	if (isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on') {
		$db_deaktjava = "1";
	} else {
		$db_deaktjava = "0";
	}
	//INICIO FIX AGREGAR SKINS LOCALES
	$dpaths = CheckInputStrings ( $_POST["dpaths"] );
    if (isset($_POST["dpaths"]) && $_POST["dpaths"] <> '') {
      $dpath = $dpaths;
    }else{
    }	
	//FIN FIX AGREGAR SKINS LOCALES
	$SetSort  = $_POST['settings_sort'];
	$SetOrder = $_POST['settings_order'];

	doquery("UPDATE {{table}} SET
	`email` = '$db_email',
	`avatar` = '$avatar',
	`dpath` = '$dpath',
	`design` = '$design',
	`noipcheck` = '$noipcheck',
	`planet_sort` = '$SetSort',
	`planet_sort_order` = '$SetOrder',
	`spio_anz` = '$spio_anz',
	`settings_tooltiptime` = '$settings_tooltiptime',
	`settings_fleetactions` = '$settings_fleetactions',
	`settings_allylogo` = '$settings_allylogo',
	`settings_esp` = '$settings_esp',
	`settings_wri` = '$settings_wri',
	`settings_bud` = '$settings_bud',
	`settings_mis` = '$settings_mis',
	`settings_rep` = '$settings_rep',
	`urlaubs_modus` = '$urlaubs_modus',
	`db_deaktjava` = '$db_deaktjava',
	`kolorminus` = '$kolorminus',
	`kolorplus` = '$kolorplus',
	`kolorpoziom` = '$kolorpoziom'
	WHERE `id` = '$iduser' LIMIT 1", "users");

	if (isset($_POST["db_password"]) && md5($_POST["db_password"]) == $user["password"]) {
//INICIO FIX EVITAR QUE CAMBIE SOLO CONTRASEÑA
		if ($_POST["newpass1"] == $_POST["newpass2"] && $_POST["newpass1"] != NULL ) {
//FIN FIX
			$newpass = md5($_POST["newpass1"]);
			doquery("UPDATE {{table}} SET `password` = '{$newpass}' WHERE `id` = '{$user['id']}' LIMIT 1", "users");
			setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //le da el expire
			message($lang['succeful_changepass'], $lang['changue_pass']);
		}
	}
	if ($user['username'] != $_POST["db_character"]) {
		$query = doquery("SELECT id FROM {{table}} WHERE username='{$_POST["db_character"]}'", 'users', true);
		if (!$query) {
			doquery("UPDATE {{table}} SET username='{$username}' WHERE id='{$user['id']}' LIMIT 1", "users");
			setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //le da el expire
			message($lang['succeful_changename'], $lang['changue_name']);
		}
	}

	display(parsetemplate(gettemplate('options_savechanges'), $parse), 'Salvado Correctamente', true);
} else {
	$parse = $lang;

	$parse['dpath'] = $dpath;
	$parse['opt_lst_skin_data']  = "<option value =\"skins/xnova/\">skins/xnova/</option>";
	//INICIO FIX AGREGAR  SKINS LOCALES
	$parse['opt_lst_skin_data']  = "<option value =\"skins/reloaded/\">skins/reloaded/</option>";
	//FIN FIX AGREGAR SKINS LOCALES
	$parse['opt_lst_ord_data']   = "<option value =\"0\"". (($user['planet_sort'] == 0) ? " selected": "") .">". $lang['opt_lst_ord0'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($user['planet_sort'] == 1) ? " selected": "") .">". $lang['opt_lst_ord1'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($user['planet_sort'] == 2) ? " selected": "") .">". $lang['opt_lst_ord2'] ."</option>";

	$parse['opt_lst_cla_data']   = "<option value =\"0\"". (($user['planet_sort_order'] == 0) ? " selected": "") .">". $lang['opt_lst_cla0'] ."</option>";
	$parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($user['planet_sort_order'] == 1) ? " selected": "") .">". $lang['opt_lst_cla1'] ."</option>";

	if ($user['authlevel'] > 0) {
		$FrameTPL = gettemplate('options_admadd');
		$IsProtOn = doquery ("SELECT `id_level` FROM {{table}} WHERE `id_owner` = '".$user['id']."' LIMIT 1;", 'planets', true);
		$bloc['opt_adm_title']       = $lang['opt_adm_title'];
		$bloc['opt_adm_planet_prot'] = $lang['opt_adm_planet_prot'];
		$bloc['adm_pl_prot_data']    = ($IsProtOn['id_level'] > 0) ? " checked='checked'/":'';
		$parse['opt_adm_frame']      = parsetemplate($FrameTPL, $bloc);
	}

	$parse['opt_usern_data'] = $user['username'];
	$parse['opt_mail1_data'] = $user['email'];
	$parse['opt_mail2_data'] = $user['email_2'];
	$parse['opt_dpath_data'] = $user['dpath'];
	$parse['opt_avata_data'] = $user['avatar'];
	$parse['opt_probe_data'] = $user['spio_anz'];
	$parse['opt_toolt_data'] = $user['settings_tooltiptime'];
	$parse['opt_fleet_data'] = $user['settings_fleetactions'];
	$parse['opt_sskin_data'] = ($user['design'] == 1) ? " checked='checked'":'';
	$parse['opt_noipc_data'] = ($user['noipcheck'] == 1) ? " checked='checked'":'';
	$parse['opt_allyl_data'] = ($user['settings_allylogo'] == 1) ? " checked='checked'/":'';
	$parse['opt_delac_data'] = ($user['db_deaktjava'] == 1) ? " checked='checked'/":'';
	$parse['opt_modev_data'] = ($user['urlaubs_modus'] == 1)?" checked='checked'/":'';
//FIX MODO VACACIONES
    $parse['opt_modev_exit'] = ($user['urlaubs_modus'] == 0)?" checked='1'/":'';
    $parse['Vaccation_mode'] = $lang['Vaccation_mode'];
    $parse['vacation_until'] = date("d.m.Y G:i:s",$user['urlaubs_until']);
//FIN FIX MODO VACACIONES
    $parse['user_settings_rep'] = ($user['settings_rep'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_esp'] = ($user['settings_esp'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_wri'] = ($user['settings_wri'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_mis'] = ($user['settings_mis'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_bud'] = ($user['settings_bud'] == 1) ? " checked='checked'/":'';
	$parse['kolorminus']  = $user['kolorminus'];
	$parse['kolorplus']   = $user['kolorplus'];
	$parse['kolorpoziom'] = $user['kolorpoziom'];
	//Mod hall of fame
if($user['hof'] == "1") { 
$parse['checked'] = "checked";
}
	//Sistema de vision galaxya
	if($user['vis_galaxy'] == 1) { $parse['vis_galaxy_1'] = "selected=\"selected\""; } else { $parse['vis_galaxy_2'] = "selected=\"selected\""; } 
	if($user['vis_messages'] == 1) { $parse['vis_mess_1'] = "selected=\"selected\""; } else { $parse['vis_mess_2'] = "selected=\"selected\""; } 
	
	if($user['urlaubs_modus']){

		display(parsetemplate(gettemplate('options_body_vmode'), $parse), 'Options', false);
	}else{
	display(parsetemplate(gettemplate('options_body'), $parse), 'Options', true);
	}



	die();
}

?>
