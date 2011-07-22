<?php

// func.ban.php
//created by lyra
//galacticbattles.org
//lyra.bd@hotmail.com

// chequea si la ip esta baneada

function checkban($ip)
{
	global $lang;
	// consultas de la base de datos
	$q = doquery ("SELECT * FROM {{table}} WHERE `ip` = '". $ip ."' LIMIT 1", "bannedip");

	$get = mysql_num_rows($q);

	if ($get == "1")
	{

		// denegar accesos

		$r=mysql_fetch_array($q);
		$lang['log_ip_banned'] = str_replace('%s', $r['long'], $lang['log_ip_banned']);
		message($lang['log_ip_banned'], $lang['log_you_are_banned']);

	}

}

// agrega una ip baneada

function addban($ip,$reason,$length)
{
	global $lang;
	// get current time

	$time = time();

	// insertamos en la base de datos

	$insert = doquery ("INSERT INTO {{table}} (`ip`,`time`,`long`,`reason`) VALUES ('". $ip ."','". $time ."', '". $length ."', '". $reason ."')", "bannedip");

	message(str_replace('%s', $ip, $lang['add_ip_ban_ok']), $lang['add_ip_ban']);

}

// elimina un registro de la base de datos

function delban($id)
{
	global $lang;
	$delete = doquery ("DELETE FROM {{table}} WHERE `id` = '". $id ."' LIMIT 1", "bannedip");

	message(str_replace('%s', $ip, $lang['rem_ip_ban_ok']), $lang['rem_ip_ban']);

}
?>