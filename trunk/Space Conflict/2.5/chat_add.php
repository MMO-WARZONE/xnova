<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** chat_add.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if (isset($_POST["msg"]) && isset($user['username'])) {
	   $nick = trim (str_replace ("+","plus",$user['username']));
	   $msg  = trim (str_replace ("+","plus",$_POST["msg"]));
	   $msg  = addslashes ($_POST["msg"]);
	   $nick = addslashes ($user['username']);
	   if ($user['authlevel'] >= 3) {
	   	$auth = "[ADMIN] ";
	   } else {
	   	$auth = "";
	   }
	} else {
	   $msg="";
	   $nick="";
	}

	if ($msg!="" && $nick!="") {
	   $query = doquery("INSERT INTO {{table}}(user, message, timestamp) VALUES ('".$auth."".$nick."', '".$msg."', '".time()."')", "chat");
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>