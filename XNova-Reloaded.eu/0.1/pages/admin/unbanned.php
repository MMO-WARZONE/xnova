<?php

/**
 * unbanned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= "2") 
	{
		includeLang('admin');
		$parse = $lang;

		$mode = $_GET['mode'];

		if ($mode != 'change') {
			$parse['Name'] = $lang['adm_unbann_playername'];
		} elseif ($mode == 'change')
			{
				$name = $_POST['name'];
				
				$Query = $DB->prepare("SELECT `who` FROM `".PREFIX."banned` WHERE `who` = :username LIMIT 1");
				$Query->bindParam('username', $name);
				$Query->execute();
				$UserVorhanden = $Query->fetch(PDO::FETCH_ASSOC);

				//gibts den User?
				if(isset($UserVorhanden) && is_array($UserVorhanden)) { //wenn ja, dann weitermachen
				
				$DB->query("DELETE FROM ".PREFIX."banned WHERE who = '".$name."'");//aus der Banned Tabelle löschen.
				$update = $DB->prepare("UPDATE ".PREFIX."users SET bana= 0, urlaubs_modus=0, banaday= 0 WHERE username = :username");
				$update->bindParam('username', $name);
				$update->execute();
				message($lang['adm_bn_thpl']." ".$name .$lang['adm_bn_unbn'].'<meta http-equiv="refresh" content="3; url=?action=administrativePlayerUnbanning">', 'Information');
			}
			else
			AdminMessage ($lang['adm_unbann_not_banned'].'<meta http-equiv="refresh" content="3; url=?action=administrativePlayerUnbanning">', 'Error');
		}

		display(parsetemplate(gettemplate('admin/unbanned'), $parse), $lang['adm_unbann_title'], false, '', true);
	} else {
		header('Location: indexGame.php');
	}
?>