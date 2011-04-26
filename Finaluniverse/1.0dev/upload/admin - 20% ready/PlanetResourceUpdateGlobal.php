<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('admin');

//DEBUG AUSGABE (Es werden nur die neuen Werte angezeigt, ohne sie in die Datenbank zu schreiben)
// true 	= nur Ausgabe
// false	= keine Debugausgabe + Daten werden in die Datenbank geschrieben.
$debugUpdate = false;
/////////////////////////////////////////////////////////////////////////////////////////////////

$count 		= 0; //affected planets/moons
$GameUsers 	= doquery("SELECT * FROM {{table}}", 'users');

while ($CurUser = mysql_fetch_assoc($GameUsers)) {
	$UsrPlanets = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
	while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
    	$update = PlanetResourceUpdate ($CurUser, $CurPlanet, time(),$debugUpdate);
    	$count  = $count + 1;
    }
}

if($count <= 0) {
	AdminMessage( $lang['res_update_failed'], $lang['res_update_title'] );
} else {
	AdminMessage( str_replace('##count##', ''.$count, $lang['res_update_done']), $lang['res_update_title'] );
}
?>