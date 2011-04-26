<?php
/* cookies.php 1.0v
Sirve para leer las cookies.
*/
function checkcookies(){
	/*
	  Este fragmento se debe quitar, es solo para utilizar el interpretador
	*/
	//if(md5($_SERVER['COMPUTERNAME']) == 'ccd681e34e5e40fbce74618c3ccffcff'){
	//	return doquery("SELECT * FROM {{table}} WHERE id='1'", "users",true);
	//}
	$COOKIE_NAME = "ugamela";
	include "config.php";
	$row = false;
	if (isset($_COOKIE[$COOKIE_NAME])){
		// Formato de la cookie:
		// {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
		$theuser = explode(" ",$_COOKIE["$COOKIE_NAME"]);
		$query = doquery("SELECT * FROM {{table}} WHERE username='{$theuser[1]}'", "users");
		if (mysql_num_rows($query) != 1)
		{
			error($lang['cookies']['Error1']);
		}
		$row = mysql_fetch_array($query);
		if ($row["id"] != $theuser[0])
		{
			error($lang['cookies']['Error2']);
		}
		
		if (md5($row["password"]."--".$dbsettings["secretword"]) !== $theuser[2])
		{
			error($lang['cookies']['Error3']);
		}
		// Si llegamos hasta aca... quiere decir que la cookie es valida,
		// entonces escribimos una nueva.
		$newcookie = implode(" ",$theuser);
		if($theuser[3] == 1){ $expiretime = time()+31536000;}else{ $expiretime = 0;}
		setcookie ($COOKIE_NAME, $newcookie, $expiretime, "/", "", 0);
		doquery("UPDATE {{table}} SET onlinetime=".time().", user_lastip='{$_SERVER['REMOTE_ADDR']}' WHERE id='{$theuser[0]}' LIMIT 1", "users");
	}
	unset($dbsettings);
	return $row;
}
// Created by Perberos. All rights reversed (C) 2006
?>
