<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('options');

$lang['PHP_SELF'] = 'options.' . $phpEx;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$mode = $_GET['mode'];

if ($_POST && $mode == "change") { // Array ( [db_character]
	$iduser 	= $user["id"];
	$avatar 	= mysql_real_escape_string($_POST["avatar"]);
	$dpath 		= mysql_real_escape_string($_POST["dpath"]);
	$languese 	= mysql_real_escape_string($_POST["langer"]);

	// Gestion des options speciales pour les admins
	if ($user['authlevel'] >= 4) {
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
	// Modo vacaciones
if ($user['urlaubs_modus_time'] >= time() && $user['urlaubs_modus'] == 0)  {
   }elseif ($user['urlaubs_modus'] == 1)  {
	$urlaubs_modus_time = time() + URLAUBS_MODUS_SPERRE;
       doquery("UPDATE {{table}} SET `urlaubs_modus` = 0, `urlaubs_modus_time` = $urlaubs_modus_time WHERE `id` = ".$user['id'],"users");
   }else{
	if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on') {
		$urlaubs_modus = "1";
		$urlaubs_modus_time = time();

	doquery("UPDATE {{table}} SET
	`urlaubs_modus` = '$urlaubs_modus',
	`urlaubs_modus_time` = '$urlaubs_modus_time'
	WHERE `id` = '$iduser' LIMIT 1", "users");

	} else {
	}
}
	// Borrar cuenta
	if (isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on') {
		$db_deaktjava = "1";
		$Del_Time = time()+604800;
	} else {
		$db_deaktjava = "0";
		$Del_Time = "0";
	}
	$galaxyansicht  = $_POST['galaxyansicht'];
	$SetSort  = $_POST['settings_sort'];
	$SetOrder = $_POST['settings_order'];

	doquery("UPDATE {{table}} SET
	`email` = '$db_email',
	`lang` = '$languese',
	`avatar` = '$avatar',
	`dpath` = '$dpath',
	`design` = '$design',
	`galaxyansicht` = '$galaxyansicht',
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
	`db_deaktjava` = '$db_deaktjava',
	`kolorminus` = '$kolorminus',
	`kolorplus` = '$kolorplus',
	`kolorpoziom` = '$kolorpoziom',
	`deltime` = '$Del_Time'
	WHERE `id` = '$iduser' LIMIT 1", "users");

if (isset($_POST["db_password"]) && md5($_POST["db_password"]) == $user["password"]) {
        if ($_POST["newpass1"]  !=  "" && $_POST["newpass1"] == $_POST["newpass2"] ) {
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
	message($lang['succeful_save'], $lang['Options']);
} else {
	$parse = $lang;

	$parse['dpath'] = $dpath;
	$parse['opt_skin_dat1']  = "<option value =\"skins/xnova/\">skins/xnova/</option>";
	$parse['opt_skin_dat2']  = "<option value =\"skins/alysium/\">skins/alysium/</option>";
	
	$parse['opt_gala_ansicht_dat']  = "<option value =\"0\"".    (($user['galaxyansicht'] == 0) ? " selected": "") .">Standart</option>";
	$parse['opt_gala_ansicht_dat'] .= "<option value =\"1\"".    (($user['galaxyansicht'] == 1) ? " selected": "") .">Listenansicht</option>";
	$parse['opt_gala_ansicht_dat'] .= "<option value =\"2\"".    (($user['galaxyansicht'] == 2) ? " selected": "") .">2D Ansicht</option>";
	$parse['opt_gala_ansicht_dat'] .= "<option value =\"3\"".    (($user['galaxyansicht'] == 3) ? " selected": "") .">3D Ansicht</option>";

	$parse['opt_lst_ord_data']   = "<option value =\"0\"". (($user['planet_sort'] == 0) ? " selected": "") .">". $lang['opt_lst_ord0'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($user['planet_sort'] == 1) ? " selected": "") .">". $lang['opt_lst_ord1'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($user['planet_sort'] == 2) ? " selected": "") .">". $lang['opt_lst_ord2'] ."</option>";

	$parse['opt_lst_cla_data']   = "<option value =\"0\"". (($user['planet_sort_order'] == 0) ? " selected": "") .">". $lang['opt_lst_cla0'] ."</option>";
	$parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($user['planet_sort_order'] == 1) ? " selected": "") .">". $lang['opt_lst_cla1'] ."</option>";

	$parse['opt_lst_lang_data']   = "<option value =\"pl\"". (($user['lang'] == pl) ? " selected": "") .">". $lang['pl'] ."</option>";
	$parse['opt_lst_lang_data']  .= "<option value =\"fr\"". (($user['lang'] == fr) ? " selected": "") .">". $lang['fr'] ."</option>";
	$parse['opt_lst_lang_data']  .= "<option value =\"es\"". (($user['lang'] == es) ? " selected": "") .">". $lang['es'] ."</option>";
	$parse['opt_lst_lang_data']  .= "<option value =\"de\"". (($user['lang'] == de) ? " selected": "") .">". $lang['de'] ."</option>";
	$parse['opt_lst_lang_data']  .= "<option value =\"en\"". (($user['lang'] == en) ? " selected": "") .">". $lang['en'] ."</option>";
	$parse['opt_lst_lang_data']  .= "<option value =\"it\"". (($user['lang'] == it) ? " selected": "") .">". $lang['it'] ."</option>";
	
	
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
//	$parse['opt_modev_data'] = ($user['urlaubs_modus'] == 1)?" checked='checked'/":'';
	$parse['user_settings_rep'] = ($user['settings_rep'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_esp'] = ($user['settings_esp'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_wri'] = ($user['settings_wri'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_mis'] = ($user['settings_mis'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_bud'] = ($user['settings_bud'] == 1) ? " checked='checked'/":'';
	$parse['kolorminus']  = $user['kolorminus'];
	$parse['kolorplus']   = $user['kolorplus'];
	$parse['kolorpoziom'] = $user['kolorpoziom'];
	
//	if($user['urlaubs_modus'] == 0) {
		display(parsetemplate(gettemplate('options_body'), $parse), 'Options');
		die();
//	}
}
?>