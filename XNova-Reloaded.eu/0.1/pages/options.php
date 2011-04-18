<?php

/**
 * options.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

includeLang('options');

$mode = mysql_real_escape_string($_GET['mode']);

if ($_POST && $mode == "change") { // Array ( [db_character]
	$avatar = $_POST["avatar"];

	// Wenn authlevel >0
	if ($user['authlevel'] > 0) {
		if ($_POST['adm_pl_prot'] == 'on') {
			$Query = $DB->prepare("UPDATE ".PREFIX."planets SET id_level = :authlevel WHERE id_owner = :userid");
			$Query->bindParam('authlevel', $user['authlevel']);
			$Query->bindParam('userid', $user['id']);
			$Query->execute();
		} else {
			$Query = $DB->prepare("UPDATE ".PREFIX."planets SET id_level = '0' WHERE id_owner = :userid");
			$Query->bindParam('userid', $user['id']);
			$Query->execute();
		}
	}

	// Usernamen ändern
	if (isset($_POST["db_character"]) && $_POST["db_character"] != '') {
		$username = CheckInputStrings ($_POST['db_character']);
	} else {
		$username = $user['username'];
	}
	// E-Mail Adresse
	if (isset($_POST["db_email"]) && $_POST["db_email"] != '') {
		$db_email = CheckInputStrings ($_POST['db_email']);
	} else {
		$db_email = $user['email'];
	}
	// Anzahl der Spiosonden
	if (isset($_POST["spio_anz"]) && intval($_POST["spio_anz"]) >= 1) {
		$spio_anz = intval($_POST["spio_anz"]);
	} else {
		$spio_anz = "1";
	}
	// Tooltips anzeigen
	if (isset($_POST["settings_tooltiptime"]) && is_numeric(intval($_POST["settings_tooltiptime"]))) {
		$settings_tooltiptime = intval($_POST["settings_tooltiptime"]);
	} else {
		$settings_tooltiptime = "1";
	}
	// Spionage
	if (isset($_POST["settings_esp"]) && $_POST["settings_esp"] == 'on') {
		$settings_esp = "1";
	} else {
		$settings_esp = "0";
	}
	// Nachrichten schreiben
	if (isset($_POST["settings_wri"]) && $_POST["settings_wri"] == 'on') {
		$settings_wri = "1";
	} else {
		$settings_wri = "0";
	}
	// Buddyliste
	if (isset($_POST["settings_bud"]) && $_POST["settings_bud"] == 'on') {
		$settings_bud = "1";
	} else {
		$settings_bud = "0";
	}
	// Raketen
	if (isset($_POST["settings_mis"]) && $_POST["settings_mis"] == 'on') {
		$settings_mis = "1";
	} else {
		$settings_mis = "0";
	}
	// Spioberichte
	if (isset($_POST["settings_rep"]) && $_POST["settings_rep"] == 'on') {
		$settings_rep = "1";
	} else {
		$settings_rep = "0";
	}
	// Umod aktivieren
	if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on') {
		$urlaubs_modus = "1";
		$urlaubs_modus_time = time();
	} else {
		$urlaubs_modus = "0";
		$urlaubs_modus_time = "0";
	}
	// Acc Löschen
	if (isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on') {
		$db_deaktjava = "1";
		$Del_Time = time()+604800;
	} else {
		$db_deaktjava = "0";
		$Del_Time = "0";
	}
	
	$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
	email = :email, 
	avatar = :avatar,
	planet_sort = :planet_sort,
	planet_sort_order = :planet_sort_order,
	spio_anz = :spio_anz,
	settings_tooltiptime = :settings_tooltiptime,
	settings_esp = :settings_esp, 
	settings_wri = :settings_wri, 
	settings_bud = :settings_bud, 
	settings_mis = :settings_mis, 
	urlaubs_modus = :urlaubs_modus, 
	db_deaktjava = :db_deaktjava,
	urlaubs_modus_time = :urlaubs_modus_time,
	deltime = :deltime
	WHERE id = :id");
	$Query->bindParam('email', $db_email);
	$Query->bindParam('avatar', $avatar);
	$Query->bindParam('planet_sort', $_POST['settings_sort']);
	$Query->bindParam('planet_sort_order', $_POST['settings_order']);
	$Query->bindParam('spio_anz', $spio_anz);
	$Query->bindParam('settings_tooltiptime', $settings_tooltiptime);
	$Query->bindParam('settings_esp', $settings_esp);
	$Query->bindParam('settings_wri', $settings_wri);
	$Query->bindParam('settings_bud', $settings_bud);
	$Query->bindParam('settings_mis', $settings_mis);
	$Query->bindParam('urlaubs_modus', $urlaubs_modus);
	$Query->bindParam('db_deaktjava', $db_deaktjava);
	$Query->bindParam('urlaubs_modus_time', $urlaubs_modus_time);
	$Query->bindParam('deltime', $deltime);
	$Query->bindParam('id', $user['id']);
	$Query->execute();


	if (isset($_POST["db_password"]) && md5($_POST["db_password"]) == $user["password"]) {
		if ($_POST["newpass1"] == $_POST["newpass2"] && $_POST["newpass1"] != $user["password"] && $_POST[newpass1] != "") {
			$newpass = md5($_POST["newpass1"]);
			
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET password = :newpass WHERE id = :userid LIMIT 1");
			$Query->bindParam('newpass', $newpass);
			$Query->bindParam('userid', $user['id']);
			$Query->execute();
			setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //Ablaufzeit
			message($lang['succeful_changepass']."<meta http-equiv=\"refresh\" content=\"3; index.php\";/>", $lang['changue_pass']);
		}
	}
	if ($user['username'] != $_POST["db_character"]) {
		$Query = $DB->prepare("SELECT id FROM ".PREFIX."users WHERE username = :db_character");
		$Query->bindParam('db_character', $_POST['db_character']);
		$Query->execute();
		$query = $Query->fetch();
		if (!$query) {
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET username = :username WHERE id = :userid LIMIT 1");
			$Query->bindParam('username', $username);
			$Query->bindParam('userid', $user['id']);
			$Query->execute();
			setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //Ablaufzeit
			message($lang['successfull_change_name']."<meta http-equiv=\"refresh\" content=\"3; index.php\";/>", $lang['change_name']);
		}
		else
		message($lang['unsuccessful_change_name'], $lang['change_name']);
	}
	message($lang['succeful_save'], $lang['Options']);
} else {
	$parse = $lang;



	$parse['opt_lst_ord_data']   = "<option value =\"0\"". (($user['planet_sort'] == 0) ? " selected": "") .">". $lang['opt_lst_ord0'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($user['planet_sort'] == 1) ? " selected": "") .">". $lang['opt_lst_ord1'] ."</option>";
	$parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($user['planet_sort'] == 2) ? " selected": "") .">". $lang['opt_lst_ord2'] ."</option>";

	$parse['opt_lst_cla_data']   = "<option value =\"0\"". (($user['planet_sort_order'] == 0) ? " selected": "") .">". $lang['opt_lst_cla0'] ."</option>";
	$parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($user['planet_sort_order'] == 1) ? " selected": "") .">". $lang['opt_lst_cla1'] ."</option>";

	
	if ($user['authlevel'] > 0) {
		$FrameTPL = gettemplate('options_admadd');
		$Query = $DB->prepare("SELECT id_level FROM ".PREFIX."planets WHERE id_owner = :userid LIMIT 1");
		$Query->bindParam('userid', $user['id']);
		$Query->execute();
		$IsProtOn = $Query->fetch();
		
		$bloc['opt_adm_title']       = $lang['opt_adm_title'];
		$bloc['opt_adm_planet_prot'] = $lang['opt_adm_planet_prot'];
		$bloc['adm_pl_prot_data']    = ($IsProtOn['id_level'] > 0) ? " checked='checked'/":'';
		$parse['opt_adm_frame']      = parsetemplate($FrameTPL, $bloc);
	}

	$parse['opt_usern_data'] = $user['username'];
	$parse['opt_mail1_data'] = $user['email'];
	$parse['opt_mail2_data'] = $user['email_2'];
	$parse['dpath'] 		 = DEFAULT_SKINPATH;
	$parse['opt_avata_data'] = $user['avatar'];
	$parse['opt_probe_data'] = $user['spio_anz'];
	$parse['opt_toolt_data'] = $user['settings_tooltiptime'];
	$parse['opt_fleet_data'] = $user['settings_fleetactions'];
	$parse['opt_delac_data'] = ($user['db_deaktjava'] == 1) ? " checked='checked'/":'';
	$parse['opt_modev_data'] = ($user['urlaubs_modus'] == 1)?" checked='checked'/":'';
	$parse['user_settings_rep'] = ($user['settings_rep'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_esp'] = ($user['settings_esp'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_wri'] = ($user['settings_wri'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_mis'] = ($user['settings_mis'] == 1) ? " checked='checked'/":'';
	$parse['user_settings_bud'] = ($user['settings_bud'] == 1) ? " checked='checked'/":'';
	

	display(parsetemplate(gettemplate('options_body'), $parse), 'Options');
	die();
}
?>