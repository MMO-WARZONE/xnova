<?php

/**
 * banned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= 1) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/banned");

		$parse     = $lang;
		
		
/*$sql = $DB->prepare("SELECT `username`, `id` FROM `".PREFIX."users` WHERE `username` LIKE :username");
 
$sql->execute(array( 
	':username' => "%".$_REQUEST['name']."%", 
)); 
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

$result = array_fill(0,10,array(
		'username' => $_REQUEST['name'].' #1',
		'id' => 'test'
	));

echo '<ul style="overflow:auto;height:150px">';
foreach($result as $row) {
	printf('<li><b>%s</b> %s</li>', $row['username'], $row['id']);
}
echo '</ul>';
*/
		
		if ($mode == 'banit') {
			$name              = $_POST['name'];
			$reas              = $_POST['why'];
			$days              = intval($_POST['days']);
			$hour              = intval($_POST['hour']);
			$mins              = intval($_POST['mins']);
			$secs              = intval($_POST['secs']);

			$admin             = $user['username'];
			$mail              = $user['email'];

			$Now               = time();
			$BanTime           = $days * 86400;
			$BanTime          += $hour * 3600;
			$BanTime          += $mins * 60;
			$BanTime          += $secs;
			$BannedUntil       = $Now + $BanTime;
			
			$Query = $DB->prepare("SELECT `username` FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1");
			$Query->bindParam('username', $name);
			$Query->execute();
			$UserVorhanden = $Query->fetch(PDO::FETCH_ASSOC);

			//gibts den User?
			if(isset($UserVorhanden) && is_array($UserVorhanden)) { //wenn ja, dann weitermachen
			
				$Query2 = $DB->prepare("SELECT `who` FROM `".PREFIX."banned` WHERE `who` = :username LIMIT 1");
				$Query2->bindParam('username', $name);
				$Query2->execute();
				$UserVorhanden2 = $Query2->fetch(PDO::FETCH_ASSOC);

				//ist der User bereits gesperrt?
					if(isset($UserVorhanden2) && is_array($UserVorhanden2)) { //wenn ja, dann fehlermeldung
						AdminMessage ($lang['adm_bn_is_banned'].'<meta http-equiv="refresh" content="3; url=?action=administrativePlayerBanning">', 'Error');
					}
			
					$QryInsertBan = $DB->prepare("INSERT INTO `".PREFIX."banned` SET `who` = :name , `theme` = :reas , `who2` = :name , `time` = :Now , `longer`= :BannedUntil , `author` = :admin , `email` = :mail");
					$QryInsertBan->bindParam('name', $name);
					$QryInsertBan->bindParam('reas', $reas);
					$QryInsertBan->bindParam('Now', $Now);
					$QryInsertBan->bindParam('BannedUntil', $BannedUntil);
					$QryInsertBan->bindParam('admin', $admin);
					$QryInsertBan->bindParam('mail', $mail);
					$QryInsertBan->execute();
					
					$QryUpdateUser = $DB->prepare("UPDATE `".PREFIX."users` SET `bana` = 1 , `urlaubs_modus` = 1 , `banaday` = :BannedUntil WHERE `username` = :username");
					$QryUpdateUser->bindParam('BannedUntil', $BannedUntil);
					$QryUpdateUser->bindParam('username', $name);
					$QryUpdateUser->execute();

					$DoneMessage       = $lang['adm_bn_thpl'] ." ". $name ." ". $lang['adm_bn_isbn'];
					AdminMessage ($DoneMessage.'<meta http-equiv="refresh" content="3; url=?action=administrativePlayerBanning">', $lang['adm_bn_ttle']);
		}
		else
		AdminMessage ($lang['adm_bn_na'].'<meta http-equiv="refresh" content="3; url=?action=administrativePlayerBanning">', 'Error');
		}
		$Page = parsetemplate($PageTpl, $parse);
		display( $Page, $lang['adm_bn_ttle'], false, '', true);
	} else {
		header('Location: indexGame.php');
	}
?>