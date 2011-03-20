<?php

function SendSimpleMessage ( $Owner, $Sender, $Time, $Type, $From, $Subject, $Message) {
	global $messfields;

	if ($Time == '') {
		$Time = time();
	}

	$QryInsertMessage  = "INSERT INTO {{table}} SET ";
	$QryInsertMessage .= "`message_owner` = '". $Owner ."', ";
	$QryInsertMessage .= "`message_sender` = '". $Sender ."', ";
	$QryInsertMessage .= "`message_time` = '" . $Time . "', ";
	$QryInsertMessage .= "`message_type` = '". $Type ."', ";
	$QryInsertMessage .= "`message_from` = '". addslashes( $From ) ."', ";
	$QryInsertMessage .= "`message_subject` = '". addslashes( $Subject ) ."', ";
	$QryInsertMessage .= "`message_text` = '". addslashes( $Message ) ."';";
	doquery( $QryInsertMessage, 'messages');

	$QryUpdateUser  = "UPDATE {{table}} SET ";
	$QryUpdateUser .= "`".$messfields[$Type]."` = `".$messfields[$Type]."` + 1, ";
	$QryUpdateUser .= "`".$messfields[100]."` = `".$messfields[100]."` + 1 ";
	$QryUpdateUser .= "WHERE ";
	$QryUpdateUser .= "`id` = '". $Owner ."';";
	doquery( $QryUpdateUser, 'users');

}

?>