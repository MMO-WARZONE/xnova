<?php

/**
 * melden.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

		$MODE = $_POST['mode'];
		$MODE2 = $_POST['mode2'];
	if($MODE == 'mel'){
			$page  = "<form action=\"melden.php\" method=\"POST\">";
			$page .= "<center>";
			$page .= "<br>";
			$page .= "<table width=\"500\">";
			$page .= "<tr><td class=\"c\" colspan=\"2\">Nachricht Melden</td></tr>";
			$page .= "<input type=\"hidden\" name=\"1melder\" value=\"{$user['username']} ID={$user['id']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1id\" value=\"{$_POST['messid']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1sender\" value=\"{$_POST['id']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1subject\" value=\"{$_POST['nachrichtmelden1']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1text\" value=\"{$_POST['nachrichtmelden']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1time\" value=\"{$_POST['time']}\"> ";
			$page .= "<input type=\"hidden\" name=\"1meldetime\" value=\"". (time() + 60 * 60 * 24) ."\"> ";
			$page .= "<tr><th>Grund des Meldens</th><th>";
			$page .= "<select name=\"1grund\">";
			$page .= "<option value=\"Multi\">Multi</option>";
			$page .= "<option value=\"Beleidigung\">Beleidigung</option>";
			$page .= "<option value=\"Bugusing\">Bugusing</option>";
			$page .= "<option value=\"Weiteres\">Weiteres</option>";
			$page .= "</select></th></tr>";
			$page .= "<tr><th colspan=\"2\">Kommentar zum Melden:</th></tr>";
			$page .= "<tr><th colspan=\"2\"><textarea name=\"1kommentar\" width=\"100%\" rows=\"5\"></textarea></th></tr>";
			$page .= "<tr><th colspan=\"2\">Gemeldete Nachricht:</th></tr>";
			$page .= "<tr><th colspan=\"2\"><textarea name=\"\" width=\"100%\" rows=\"5\" disabled readonly=\"readonly\">{$_POST['nachrichtmelden']}</textarea></th></tr>";
			$page .= "<tr><th colspan=\"2\"><input type=\"submit\" name=\"mode2\" value=\"Melden\"></form></th></tr></table></center>";
	}elseif($MODE == 'del'){
						$MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $_POST['messid'] ."' AND `message_owner` = '". $user['id'] ."';", 'messages');
						if ($MessHere) {
							doquery("DELETE FROM {{table}} WHERE `message_id` = '".$_POST['messid']."';", 'messages');
							message('Nachricht erfolgreich gel&ouml;scht!','Erfolgreich!');
						} 
						
	}elseif($MODE2 == 'Melden'){
				$Melden = doquery("INSERT INTO {{table}} (`id`,`message_melder` ,`message_sender` ,`message_subject` ,`message_text`, `message_time`, `message_melde_time`, `message_grund`, `message_kommentar`) VALUES ('{$_POST['1id']}','{$_POST['1melder']}','{$_POST['1sender']}','{$_POST['1subject']}','{$_POST['1text']}','{$_POST['1time']}','{$_POST['1meldetime']}','{$_POST['1grund']}','{$_POST['1kommentar']}')", 'messages'); message('Nachricht gemeldet!','Erfolgreich!');
	
			}else{
			header('location: messages.php');
			}
		$MessCategory = $_POST['category'];
	display($page, $lang['mess_pagetitle']);


?>