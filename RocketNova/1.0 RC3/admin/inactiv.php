<?php

/**
########################################################
© Copyright by RedFighter 
überarbeitet by kleinerzwerg
überarbeitet by zeus
########################################################
**/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] == 4) {

	$table = doquery("SELECT `id`, `inaktiv`, `username`, `onlinetime` FROM {{table}} WHERE `authlevel`= '0'", "users");
	        $i = 0;
			while ($u = mysql_fetch_assoc($table)) {		
			$inaktiv = time() - $u['onlinetime'];
			$time    = gmdate ( "d", $inaktiv);
			$parse['liste'] .= "<tr>"
			. "<td class=b>".$u['id'] ."</td>"
			. "<td class=b>".$u['username'] ."</td>"
			. "<td class=b>vor <b>".$time." Tagen</b></td>"
			. "</tr>";
			$i++; 
			}

	$table = doquery("SELECT `id`, `inaktiv`, `username`, `onlinetime` FROM {{table}} WHERE `authlevel` > '0'", "users"); // keine spieler, sind ganz unten
	        $i = 0;
			while ($u = mysql_fetch_assoc($table)) {		
			$inaktiv = time() - $u['onlinetime'];
			$time    = gmdate ( "d", $inaktiv);
			$parse['liste'] .= "<tr>"
			. "<td class=b>".$u['id'] ."</td>"
			. "<td class=b>".$u['username'] ."</td>"
			. "<td class=b>vor <b>".$time." Tagen</b></td>"
			. "</tr>";
			$i++; 
			}
	
	
$query = doquery("SELECT `id`, `onlinetime` FROM {{table}}", "users");
$i = 0;
		while ($a = mysql_fetch_assoc($query)) {
 $inaktive_zeit = time() - $a['onlinetime'];
doquery("UPDATE {{table}} SET `inaktiv` = '". $inaktive_zeit ."' WHERE `id` = '".$a['id']."'",'users'); 
$i++;
}

$query2 = doquery("SELECT `id`, `inaktiv` FROM {{table}} WHERE `authlevel` = '0'", "users");

$g = 0;
		while ($del= mysql_fetch_assoc($query2)) {
$config = doquery("SELECT `config_name`, `config_value` FROM {{table}}", "config");

	if($del['inaktiv'] < $config['inaktiv_time']) {

	doquery("DELETE FROM {{table}} WHERE `id` = '".$del['id']."'", "users");

}


$g++;
}

if(isset($_POST['inaktiv_time'])) {
$time = $_POST['inaktiv_time'] * 24 * 60 * 60;
doquery("UPDATE {{table}} SET `config_value` = '".$time."' WHERE `config_name` = 'inaktiv_time'",'config'); 
AdminMessage ('<meta http-equiv="refresh" content="1; url=inactiv.php">Die Zeit wurde gespeichert!', 'Erfolgreich');
}


	 		display(parsetemplate(gettemplate('admin/inaktiv'), $parse), 'Inaktive Spieler', false, '', true);

}		 else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	    }
?>