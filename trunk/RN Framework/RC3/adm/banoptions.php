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

if ($user['authlevel'] < 1) die(message ($lang['not_enough_permissions']));

	$parse = $lang;

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
		doquery( $QryInsertBan, 'banned');

		$QryUpdateUser     = "UPDATE {{table}} SET ";
		$QryUpdateUser    .= "`bana` = '1', ";
		$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."', ";

		if(isset($_POST['vacat']))
			$QryUpdateUser    .= "`urlaubs_modus` = '1'";
		else
			$QryUpdateUser    .= "`urlaubs_modus` = '0'";

		$QryUpdateUser    .= "WHERE ";
		$QryUpdateUser    .= "`username` = \"". $name ."\";";
		doquery( $QryUpdateUser, 'users');

		$PunishThePlanets     = "UPDATE {{table}} SET ";
		$PunishThePlanets    .= "`metal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`crystal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`deuterium_sintetizer_porcent` = '0'";
		$PunishThePlanets    .= "WHERE ";
		$PunishThePlanets    .= "`id_owner` = \"". $GetUserData['id'] ."\";";
		doquery( $PunishThePlanets, 'planets');

		message ($lang['bo_the_player'] . $name . $lang['bo_banned'],"banoptions.php",2);
	}
	elseif($_POST && $_POST['unban_name'])
	{
		$name = $_POST['unban_name'];
		doquery("DELETE FROM {{table}} WHERE who2='{$name}'", 'banned');
		doquery("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='{$name}'", "users");
		message ($lang['bo_the_player'] . $name . $lang['bo_unbanned'],"banoptions.php",2);
	}
	else
		display( parsetemplate(gettemplate("adm/banoptions"), $parse), false, '', true, false);
?>