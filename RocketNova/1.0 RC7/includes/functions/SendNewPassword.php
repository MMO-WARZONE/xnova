<?php

/**
 * SendNewPassword.php
 *
 * @version 1.0
 * @copyright 2008 by Tom1991 for XNova
 */



function sendnewpassword($mail){

	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $mail ."' LIMIT 1;", 'users', true);

	if (empty($ExistMail['email']))	{
		message($lang['EMAIL_NOT_EXIST'],$lang['ERROR']);
	} else {
		// generate new password
		$NewPass = str_makerand();

		// send mail
		$Title = $lang['SENDPASS_EMAIL_SUBJECT'];
		$Body = $lang['SENDPASS_EMAIL_TEXT'] . $NewPass;

		mail($mail,$lang['SENDPASS_EMAIL_SUBJECT'],$Body);

		// save password to db
		$NewPassSql = md5($NewPass);

		$QryPassChange = "UPDATE {{table}} SET ";
		$QryPassChange .= "`password` ='". $NewPassSql ."' ";
		$QryPassChange .= "WHERE `email`='". $mail ."' LIMIT 1;";

		doquery( $QryPassChange, 'users');
	}
}
?>