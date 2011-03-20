<?php
//version 1.1

function ShowBannedAdmin($user){
	global $lang,$db, $displays;
if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

//	$parse = $lang;

	if($_POST && $_POST['ban_name'])
	{
		$name              = $_POST['ban_name'];
		$reas              = $_POST['why'];
		$days              = $_POST['days'];
		$hour              = $_POST['hour'];
		$mins              = $_POST['mins'];
		$secs              = $_POST['secs'];
		$admin             = $user['username'];
		$mail              = $user['email'];
		$Now               = time();
		$BanTime           = $days * 86400;
		$BanTime          += $hour * 3600;
		$BanTime          += $mins * 60;
		$BanTime          += $secs;
		$BannedUntil       = $Now + $BanTime;

		$QryInsertBan      = "INSERT INTO {{table}} SET ";
		$QryInsertBan     .= "`who` = \"". $name ."\", ";
		$QryInsertBan     .= "`theme` = '". $reas ."', ";
		$QryInsertBan     .= "`who2` = '". $name ."', ";
		$QryInsertBan     .= "`time` = '". $Now ."', ";
		$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
		$QryInsertBan     .= "`author` = '". $admin ."', ";
		$QryInsertBan     .= "`email` = '". $mail ."';";
		$db->query( $QryInsertBan, 'banned');

		$QryUpdateUser     = "UPDATE {{table}} SET ";
		$QryUpdateUser    .= "`bana` = '1', ";
		$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."', ";

		if(isset($_POST['vacat'])){
			$QryUpdateUser    .= "`urlaubs_modus` = '1'";
		}else{
			$QryUpdateUser    .= "`urlaubs_modus` = '0'";
		}

		$QryUpdateUser    .= "WHERE ";
		$QryUpdateUser    .= "`username` = \"". $name ."\";";
		$db->query( $QryUpdateUser, 'users');

		$PunishThePlanets     = "UPDATE {{table}} SET ";
		$PunishThePlanets    .= "`metal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`crystal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`deuterium_sintetizer_porcent` = '0'";
		$PunishThePlanets    .= "WHERE ";
		$PunishThePlanets    .= "`id_owner` = \"". $GetUserData['id'] ."\";";
		$db->query( $PunishThePlanets, 'planets');

		$displays->message ($lang['bo_the_player'] . $name . $lang['bo_banned'],"admin.php?page=banned",2);
		

	}elseif($_POST && $_POST['nam'] && $_POST["desban"])	{
		$name = $_POST['nam'];

		$db->query("DELETE FROM {{table}} WHERE who2='".$name."'", 'banned');
		$db->query("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='".$name."'", "users");
		$displays->message ($lang['bo_the_player'] . $name . $lang['bo_unbanned'],"admin.php?page=banned",2);
	}else{
		$baned = $db->query("Select * From {{table}} ;", 'banned');
		$lang['baneados'] = '<select name="nam">';




		while($ba =  mysql_fetch_array($baned)){
                  

			$lang['baneados'] .= "<option value=".$ba['who2'].">".$ba['who2']."</option>";



		}
		$lang['baneados'] .= '</select>';
//		display( parsetemplate(gettemplate("adm/banoptions"), $parse), false, '', true, false);
	}
                $displays->assignContent("adm/banoptions");

	$displays->display();

}
?>