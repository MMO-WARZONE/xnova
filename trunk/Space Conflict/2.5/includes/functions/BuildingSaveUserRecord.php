<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** BuildingSaveUserRecord.php            **
******************************************/

function BuildingSaveUserRecord ( $CurrentUser ) {

	$QryUpdateUser  = "UPDATE {{table}} SET ";
	$QryUpdateUser .= "`xpminier` = '".      $CurrentUser['xpminier']      ."' ";
	$QryUpdateUser .= "WHERE ";
	$QryUpdateUser .= "`id` = '".            $CurrentUser["id"]            ."';";
	doquery( $QryUpdateUser, 'users');

	return;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>