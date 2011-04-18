<?php

/**
 * userlist.php
 *
 * @version 1.0
 * @copyright 2009 by gianluca311 for xnova-reloaded.de
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= 2) {
		includeLang('admin');
		if ($_GET['cmd'] == 'dele') {
			DeleteSelectedUser ( intval($_GET['user']) );
		}
		if ($_GET['cmd'] == 'sort') {
			$TypeSort = mysql_real_escape_string($_GET['type']);
		} 
		
		$PageTPL = gettemplate('admin/userlistmulti_body');
		$RowsTPL = gettemplate('admin/userlistmulti_rows');
		
		$query = $DB->query("SELECT DISTINCT(user_lastip) AS user, COUNT(user_lastip) AS userCount, username, id, galaxy,system,planet,register_time,onlinetime,banaday,urlaubs_modus FROM ".PREFIX."users GROUP BY user_lastip HAVING userCount > 1");

		$parse                 = $lang;
		$parse['adm_ul_table'] = "";
		$i                     = 0;
		$Color                 = "lime";
		while ($u = $query->fetch(PDO::FETCH_ASSOC) ) {

			if ($PrevIP != "") {
				if ($PrevIP == $u['user_lastip']) {
					$Color = "red";
				} else {
					$Color = "lime";
				}
			}

			$monde = $DB->query("SELECT id FROM ".PREFIX."lunas WHERE id_owner= '".$u['id']."'");
				$Bloc['adm_ul_data_id']     = $u['id'];
				$Bloc['adm_ul_data_name']   = $u['username'];
				$Bloc['adm_ul_data_hp']		= $u['galaxy'].':'.$u['system'].':'.$u['planet'];
				$Bloc['adm_ul_data_asteroids']	= sql_num_rows($monde); 
				$Bloc['adm_ul_data_mail']   = $u['email'];
				$Bloc['adm_ul_data_adip']   = "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>";
				$Bloc['adm_ul_data_regd']   = date ( "d/m/Y G:i:s", $u['register_time'] );
				$Bloc['adm_ul_data_lconn']  = date ( "d/m/Y G:i:s", $u['onlinetime'] );
				$Bloc['adm_ul_data_banna']  = ( $u['bana'] == 1 ) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">". $lang['adm_ul_yes'] ."</a>" : $lang['adm_ul_no'];
				$Bloc['adm_ul_data_umod']  	= $u['urlaubs_modus'] ? 'Ja' : 'Nein';
				$Bloc['adm_ul_data_actio']  = "<a href=\"?action=administrativeUserlist&amp;cmd=dele&amp;user=".$u['id']."\"><img src=\"../images/r1.png\" alt=\"L&ouml;schen\"></a>"; // Lien vers actions 'effacer'
				$PrevIP                     = $u['user_lastip'];
				$parse['adm_ul_table']     .= parsetemplate( $RowsTPL, $Bloc );
				$i++;
		}
		$parse['adm_ul_count'] = $i;

		if(isset($_GET['mode']) && isset($_GET['id'])) {
			$id = intval($_GET['id']);
			
			$Query  				= $DB->query("SELECT * FROM ".PREFIX."users WHERE id='".$id."' LIMIT 1");
			$users 					= $Query->fetch();
			$users['umodchecked'] 	= $users['urlaubs_modus'] ? 'checked=checked' : '';
			$users['banchecked']		= ( $users['bana'] == 1 ) ? 'checked=checked' : ''; 
			$parse['show_edit_form'] = parsetemplate(gettemplate('admin/user_edit_form'),$users);
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
				$umod = '`urlaubs_modus` = 1,`urlaubs_modus_time` = '.time();
			}else{
				$umod = '`urlaubs_modus` = 0,`urlaubs_modus_time` = 0';
			}
			
			$query = doquery("UPDATE {{table}} SET 
							`username`		= '".$username."',
							`email`			= '".$email."',
							`spy_tech` 				= '".intval($_POST['spionage_tech'])."',
							`computer_tech` 		= '".intval($_POST['computer_tech'])."',
							`military_tech` 		= '".intval($_POST['waffen_tech'])."',
							`defence_tech` 			= '".intval($_POST['abwehr_tech'])."',
							`shield_tech` 			= '".intval($_POST['schild_tech'])."',
							`energy_tech` 			= '".intval($_POST['energie_tech'])."',
							`hyperspace_tech` 		= '".intval($_POST['antriebs_tech'])."',
							`combustion_tech` 		= '".intval($_POST['verbrennungstriebwerk'])."',
							`impulse_motor_tech` 	= '".intval($_POST['impulstriebwerk'])."',
							`hyperspace_motor_tech` = '".intval($_POST['warpantrieb'])."',
							`laser_tech` 			= '".intval($_POST['graviton_tech'])."',
							`ionic_tech` 			= '".intval($_POST['ionen_tech'])."',
							`buster_tech` 			= '".intval($_POST['plasma_tech'])."',
							`intergalactic_tech` 	= '".intval($_POST['intergalaktisches_forschungszentrum'])."',
							`expedition_tech` 		= '".intval($_POST['expedition_tech'])."',
							`graviton_tech` 		= '".intval($_POST['schwarzes_loch_forschung'])."',
							 ".$bana.",
							 ".$umod."  
							 WHERE `id` = '".$edit_id."' LIMIT 1",'users');
			
			AdminMessage ('<meta http-equiv="refresh" content="1; url=?action=administrativeUserlist">Spieler wurde erfolgreich geändert', 'Spieler bearbeiten');
		}
		
		$page = parsetemplate( $PageTPL, $parse );
		display( $page, $lang['adm_ul_title'], false, '', true);
	} else {
		header('Location: indexGame.php');
	}
?>













