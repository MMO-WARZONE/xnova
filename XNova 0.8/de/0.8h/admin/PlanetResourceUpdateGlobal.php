<?php
/**
 * PlanetResourceUpdateGlobal.php
 *
 * @version 1.0
 * by Helmchen for XNova Community
 */
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

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
	echo '<center><font color="red">Beim Update gab es offenbar ein Problem.<br>Es wurden <u>keine</u> Planeten aktualisiert!</font></center>';
}else{
	echo '<center><font color="green">Done!<br>Ingsgesamt wurden '.$count.' Planeten / Monde aktualisiert!</font></center>';
}
?>