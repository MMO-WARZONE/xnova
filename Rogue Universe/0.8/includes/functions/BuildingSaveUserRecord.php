<?php

function BuildingSaveUserRecord ( $CurrentUser ) {

	$QryUpdateUser  = "UPDATE {{table}} SET ";
	$QryUpdateUser .= "`xpminier` = '".      $CurrentUser['xpminier']      ."' ";
	$QryUpdateUser .= "WHERE ";
	$QryUpdateUser .= "`id` = '".            $CurrentUser["id"]            ."';";
	doquery( $QryUpdateUser, 'users');

	return;
}
?>