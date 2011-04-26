<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 2) die(message ($lang['not_enough_permissions']));

	function DeleteSelectedUser($UserID)
	{
		$TheUser = doquery ( "SELECT * FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users', true );

		if ( $TheUser['ally_id'] != 0 )
		{
			$TheAlly = doquery ( "SELECT * FROM {{table}} WHERE `id` = '" . $TheUser['ally_id'] . "';", 'alliance', true );
			$TheAlly['ally_members'] -= 1;

			if ($TheAlly['ally_members'] > 0)
			{
				doquery ( "UPDATE {{table}} SET `ally_members` = '" . $TheAlly['ally_members'] . "' WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
			}
			else
			{
				doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
				doquery ( "DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '" . $TheAlly['id'] . "';", 'statpoints' );
			}
		}

		doquery ( "DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '" . $UserID . "';", 'statpoints' );

		$ThePlanets = doquery ( "SELECT * FROM {{table}} WHERE `id_owner` = '" . $UserID . "';", 'planets' );

		while ( $OnePlanet = mysql_fetch_assoc ( $ThePlanets ) )
		{
			if ( $OnePlanet['planet_type'] == 1 )
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "' AND `system` = '" . $OnePlanet['system'] . "' AND `planet` = '" . $OnePlanet['planet'] . "';", 'galaxy' );
			elseif ( $OnePlanet['planet_type'] == 3 )
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "' AND `system` = '" . $OnePlanet['system'] . "' AND `lunapos` = '" . $OnePlanet['planet'] . "';", 'lunas' );

			doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $OnePlanet['id'] . "';", 'planets' );
		}

		doquery ( "DELETE FROM {{table}} WHERE `message_sender` = '" . $UserID . "';", 'messages' );
		doquery ( "DELETE FROM {{table}} WHERE `message_owner` = '" . $UserID . "';", 'messages' );
		doquery ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'notes' );
		doquery ( "DELETE FROM {{table}} WHERE `fleet_owner` = '" . $UserID . "';", 'fleets' );
		//doquery ( "DELETE FROM {{table}} WHERE `id_owner1` = '" . $UserID . "';", 'rw' );
		//doquery ( "DELETE FROM {{table}} WHERE `id_owner2` = '" . $UserID . "';", 'rw' );
		doquery ( "DELETE FROM {{table}} WHERE `sender` = '" . $UserID . "';", 'buddy' );
		doquery ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'buddy' );
		doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users' );
		doquery ( "UPDATE `{{table}}` SET `config_value` = `config_value` - '1' WHERE `config_name` = 'users_amount' LIMIT 1 ;", "config" );
	}

	$parse	= $lang;

	if ($_GET['cmd'] == 'dele')
		DeleteSelectedUser ($_GET['user']);
	if ($_GET['cmd'] == 'sort')
		$TypeSort = $_GET['type'];
	else
		$TypeSort = "id";

	$query   = doquery("SELECT `id`,`id_planet`,`username`,`email`,`ip_at_reg`,`user_lastip`,`register_time`,`onlinetime`,`bana`,`banaday`,`urlaubs_modus`,`galaxy`,`system`,`planet`,`urlaubs_until` FROM {{table}} ORDER BY `". $TypeSort ."` ASC", 'users');

	$parse['adm_ul_table'] = "";
	$i                     = 0;
	$Color                 = "green ";
	while ($u = mysql_fetch_assoc($query))
	{
		if ($PrevIP != "")
		{
			if ($PrevIP == $u['user_lastip'])
				$Color = "red";
			else
				$Color = "green";
		}

		$Bloc['adm_ul_data_id']     		= $u['id'];
		$Bloc['adm_ul_data_pid']     		= $u['id_planet'];
		$Bloc['adm_ul_data_name']   		= $u['username'];
		$Bloc['adm_ul_data_mail']   		= $u['email'];
		$Bloc['adm_ul_data_hp']				= "[".$u['galaxy'].":".$u['system'].":".$u['planet']."]";
		$Bloc['ip_adress_at_register']   	= $u['ip_at_reg'];
		$Bloc['adm_ul_data_adip']   		= ($user['authlevel'] > 3) ? "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>" : "-";
		$Bloc['adm_ul_data_regd']   		= date ( "d.m.Y G:i:s", $u['register_time'] );
		$Bloc['adm_ul_data_lconn']  		= date ( "d.m.Y G:i:s", $u['onlinetime'] );
		$Bloc['adm_ul_data_banna']  		= ($u['bana'] == 1) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">".$lang['ul_yes']."</a>" : $lang['ul_no'];
		$Bloc['adm_ul_data_umod']  			= ($u['urlaubs_modus'] == 1) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['urlaubs_until']) ."\">".$lang['ul_yes']."</a>" : $lang['ul_no'];
		$Bloc['adm_ul_data_actio']  		= ($u['id'] != $user['id'] && $user['authlevel'] >= 3) ? "<a href=\"userlist.php?cmd=dele&user=".$u['id']."\" border=\"0\" onclick=\"return confirm('".$lang['ul_sure_you_want_dlte']."  $u[username]?');\"><img border=\"0\" src=\"../styles/images/r1.png\"></a>" : "-";
		$PrevIP                     		= $u['user_lastip'];
		$parse['adm_ul_table']     			.= parsetemplate(gettemplate('adm/userlist_rows'), $Bloc);
		$i++;
	}
	$parse['adm_ul_count'] 					= $i;
	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$query  				= doquery("SELECT * FROM {{table}} WHERE id='".$id."' LIMIT 1", "users");
		$users 					= mysql_fetch_array($query);
		$users['umodchecked'] 	= $users['urlaubs_modus'] ? 'checked=checked' : '';
		$users['banchecked']		= ( $users['bana'] == 1 ) ? 'checked=checked' : '';
		$parse['show_edit_form'] = parsetemplate(gettemplate('adm/user_edit_form'),$users);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$username 	= mysql_real_escape_string($_POST['username']);
		$email 		= mysql_real_escape_string($_POST['email']);
		$bantime    =  intval($_POST['ban_days'] * 86400);
		$bantime    += intval($_POST['ban_hours'] * 3600);
		$bantime    += intval($_POST['ban_mins'] * 60);
		$bantime    += intval($_POST['ban_secs']);
		$bantime    = time() + $bantime;

		if($_POST['gesperrt'] == 1) {
			$bana = '`bana` = 1,`urlaubs_modus` = 1,`banaday` = '. $bantime;

			$bann = doquery("INSERT INTO {{table}} SET
								`who` 		= '".$username."',
								`theme`		= '".mysql_real_escape_string($_POST['reason'])."',
								`who2`		= '".$username."',
								`time`		= '".time()."',
								`longer`	= '".$bantime."',
								`author`	= '".$user['username']."',
								`email`		= '".$user['email']."'",'banned');
		}else{
			$bana = '`bana` = NULL,`banaday` = NULL';
		}
		if($_POST['umod'] == 1) {
			$umod = '`urlaubs_modus` = 1,`urlaubs_until` = '.time();
		}else{
			$umod = '`urlaubs_modus` = 0,`urlaubs_until` = 0';
		}

		$query = doquery("UPDATE {{table}} SET
							`username`		= '".$username."',
							`email`			= '".$email."',
							`spy_tech` 				= '".intval($_POST['spy_tech'])."',
							`computer_tech` 		= '".intval($_POST['computer_tech'])."',
							`military_tech` 		= '".intval($_POST['military_tech'])."',
							`defence_tech` 			= '".intval($_POST['defence_tech'])."',
							`shield_tech` 			= '".intval($_POST['shield_tech'])."',
							`energy_tech` 			= '".intval($_POST['energy_tech'])."',
							`hyperspace_tech` 		= '".intval($_POST['hyperspace_tech'])."',
							`combustion_tech` 		= '".intval($_POST['combustion_tech'])."',
							`impulse_motor_tech` 	= '".intval($_POST['impulse_motor_tech'])."',
							`hyperspace_motor_tech` = '".intval($_POST['hyperspace_motor_tech'])."',
							`laser_tech` 			= '".intval($_POST['laser_tech'])."',
							`ionic_tech` 			= '".intval($_POST['ionic_tech'])."',
							`buster_tech` 			= '".intval($_POST['buster_tech'])."',
							`intergalactic_tech` 	= '".intval($_POST['intergalactic_tech'])."',
							`expedition_tech` 		= '".intval($_POST['expedition_tech'])."',
							`graviton_tech` 		= '".intval($_POST['graviton_tech'])."',
							 ".$bana.",
							 ".$umod."  
							 WHERE `id` = '".$edit_id."' LIMIT 1",'users');
		// AdminLOG - Helmchen
		$fp = @fopen('logs/adminlog_'.date('d.m.Y').'.txt','a');
		fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values of user with ID: ".$edit_id."\n");
		fclose($fp);
		// AdminLOG ENDE

		header("location:userlist.php");
	}
	display( parsetemplate( gettemplate('adm/userlist_body'), $parse ), false, '', true, false);

?>