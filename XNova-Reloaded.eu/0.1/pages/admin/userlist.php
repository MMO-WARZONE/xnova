<?php

/**
 * userlist.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= 2) {		//authlevelprüfung
		includeLang('admin');
		if ($_GET['cmd'] == 'dele') {	//Wenn der User gelöscht werden soll
			DeleteSelectedUser ( intval($_GET['user']) );	//dann passiert das hier
		}
		if ($_GET['cmd'] == 'sort') {	//Sortierung
			$TypeSort = mysql_real_escape_string($_GET['type']);	// je nach Typ
		} else {
			$TypeSort = "id";	//ansonsten nach ID
		}

		$PageTPL = gettemplate('admin/userlist_body');
		$RowsTPL = gettemplate('admin/userlist_rows');

		$query   = $DB->query("SELECT * FROM ".PREFIX."users ORDER BY `". $TypeSort ."` ASC"); //alle werte auslesen
		$parse                 = $lang;
		$parse['adm_ul_table'] = "";
		$i                     = 0;
		$Color                 = "lime";
		while ($u = $query->fetch(PDO::FETCH_ASSOC) ) {	// und durch die Schleife schicken
			if ($PrevIP != "") {
				if ($PrevIP == $u['user_lastip']) {
					$Color = "red";
				} else {
					$Color = "lime";
				}
			}
			$monde = $DB->query("SELECT id FROM ".PREFIX."lunas WHERE id_owner= '".$u['id']."'");	//monde auslesen
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

		if(isset($_GET['mode']) && isset($_GET['id'])) {	//wenn modus gewählt
			$id = intval($_GET['id']);
			
			$Query  				= $DB->query("SELECT * FROM ".PREFIX."users WHERE id='".$id."' LIMIT 1");	//dann hole alles benötigte für diesen User aus der DB
			$users 					= $Query->fetch();	// mach daraus ein Array
			$users['umodchecked'] 	= $users['urlaubs_modus'] ? 'checked=checked' : '';
			$users['banchecked']		= ( $users['bana'] == 1 ) ? 'checked=checked' : ''; // und parse die Werte fürs Template
			$parse['show_edit_form'] = parsetemplate(gettemplate('admin/user_edit_form'),$users);
		}
		if(isset($_POST['submit'])) {	//wird das Formular abgeschickt
			
			$edit_id 	= intval($_POST['currid']);
			$username 	= mysql_real_escape_string($_POST['username']);
			$email 		= mysql_real_escape_string($_POST['email']);
            $bantime    =  intval($_POST['ban_days'] * 86400);
            $bantime    += intval($_POST['ban_hours'] * 3600);
            $bantime    += intval($_POST['ban_mins'] * 60);
            $bantime    += intval($_POST['ban_secs']);
            $bantime    = time() + $bantime;	//Bastel die Sperrzeit zusammen
            
			if($_POST['gesperrt'] == 1 && $_POST['gesperrt'] != $users['bana']) {	//wenn der User gesperrt werden soll (und es nicht schon ist)...
				$bana = '`bana` = 1, `banaday` = :bantime'; //wird für den Update des Users Tabelle benötigt
								
				$bann = $DB->prepare("INSERT INTO `".PREFIX."banned` SET `who` = :name , `theme` = :reas , `who2` = :name , `time` = :Now , `longer`= :BannedUntil , `author` = :admin , `email` = :mail");
					$bann->bindParam('name', $username);
					$bann->bindParam('reas', $_POST['reason']);
					$bann->bindParam('Now', time());
					$bann->bindParam('BannedUntil', $bantime);
					$bann->bindParam('admin', $user['username']);
					$bann->bindParam('mail', $user['email']);
					$bann->execute(); //...trage es in die DB ein
			}else{
				$bana = '`bana` = 0,`banaday` = 0'; //wird auch für die Users Tabelle benötigt
			}
			if($_POST['umod'] == 1) {	//wenn der Umod gesetzt wird
				$umod = '`urlaubs_modus` = 1,`urlaubs_modus_time` = :time';	//mach ihn an
			}else{
				$umod = '`urlaubs_modus` = 0,`urlaubs_modus_time` = 0';		// oder mach ihn aus
			}
			
			//und jetzt die User Tabelle updaten
			$update = "UPDATE `".PREFIX."users` SET
									`username`				= :username,
									`email`					= :email,
									`spy_tech`				= :spy_tech,
									`computer_tech`			= :computer_tech,
									`military_tech`			= :military_tech,
									`defence_tech`			= :defence_tech,
									`shield_tech`			= :shield_tech,
									`energy_tech`			= :energy_tech,
									`hyperspace_tech`		= :hyperspace_tech,
									`combustion_tech`		= :combustion_tech,
									`impulse_motor_tech`	= :impulse_motor_tech,
									`hyperspace_motor_tech`	= :hyperspace_motor_tech,
									`laser_tech`			= :laser_tech,
									`ionic_tech`			= :ionic_tech,
									`buster_tech`			= :buster_tech,
									`intergalactic_tech`	= :intergalactic_tech,
									`expedition_tech`		= :expedition_tech,
									`graviton_tech`			= :graviton_tech";
									if  ($_POST['gesperrt'] != $users['bana'])	//wenn der abgeschickte wert nicht dem schon vorhandenen entspricht
									$update .= ",".$bana."";					//dann update auch die Sperre
									if ($_POST['umod'] != $users['urlaubs_modus'])	//selbiges gilt auch hier
									$update .= ",".$umod."";
									
									$update .= " WHERE `id` = :edit_id LIMIT 1";

								$dbupdate = $DB->prepare($update);
								$dbupdate->bindParam('username', $username);	//Variablen anbinden
								$dbupdate->bindParam('email', $email);
								$dbupdate->bindParam('spy_tech', intval($_POST['spy_tech']));
								$dbupdate->bindParam('computer_tech', intval($_POST['computer_tech']));
								$dbupdate->bindParam('military_tech', intval($_POST['military_tech']));
								$dbupdate->bindParam('defence_tech', intval($_POST['defence_tech']));
								$dbupdate->bindParam('shield_tech', intval($_POST['shield_tech']));
								$dbupdate->bindParam('energy_tech', intval($_POST['energy_tech']));
								$dbupdate->bindParam('hyperspace_tech', intval($_POST['hyperspace_tech']));
								$dbupdate->bindParam('combustion_tech', intval($_POST['combustion_tech']));
								$dbupdate->bindParam('impulse_motor_tech', intval($_POST['impulse_motor_tech']));
								$dbupdate->bindParam('hyperspace_motor_tech', intval($_POST['hyperspace_motor_tech']));
								$dbupdate->bindParam('laser_tech', intval($_POST['laser_tech']));
								$dbupdate->bindParam('ionic_tech', intval($_POST['ionic_tech']));
								$dbupdate->bindParam('buster_tech', intval($_POST['buster_tech']));
								$dbupdate->bindParam('intergalactic_tech', intval($_POST['intergalactic_tech']));
								$dbupdate->bindParam('expedition_tech', intval($_POST['expedition_tech']));
								$dbupdate->bindParam('graviton_tech', intval($_POST['graviton_tech']));
								$dbupdate->bindParam('edit_id', $edit_id);
								if  ($_POST['gesperrt'] == 1 && $_POST['gesperrt'] != $users['bana'])	//siehe oben
								$dbupdate->bindParam('bantime', $bantime);
								if ($_POST['umod'] ==1 && $_POST['umod'] != $users['urlaubs_modus'])
								$dbupdate->bindParam('time', time());
								$dbupdate->execute();	// und ausführen
			//bei Erfolg Admin Message ausgeben, und weiterleiten  
			AdminMessage ('<meta http-equiv="refresh" content="1; url=?action=administrativeUserlist">Spieler wurde erfolgreich ge&auml;ndert', 'Spieler bearbeiten');
		}
		$page = parsetemplate( $PageTPL, $parse );
		display( $page, $lang['adm_ul_title'], false, '', true);
	} else {
		header('Location: indexGame.php');
	}
?>













