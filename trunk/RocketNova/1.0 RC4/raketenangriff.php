<?php

/**
 * raketenangriff.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

//HEAD revision svn
define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

//POST /~ljubisa/raketenangriff.php?c=1mode=2galaxy=1system=3planet=11SendMI=5Target=allaktion=Attack

$planet    = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."'", 'planets', true);
$iraks = $planet['interplanetary_misil'];


$g = intval($_GET['galaxy']);
$s = intval($_GET['system']);
$i = intval($_GET['planet']);
$anz = intval($_POST['SendMI']);
$pziel = $_POST['Target'];

$currentplanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."'",'planets',true);

$planet = doquery("SELECT * FROM {{table}} WHERE galaxy = ".$g." AND
			system = ".$s." AND
			planet = ".$i." AND
			planet_type = '1'", 'planets', true);

$ziel_id = $planet['id_owner'];

//$tempvar1 = abs(($s - $currentplanet['system'])+1);
$tempvar1 = abs($s - $currentplanet['system']);
$tempvar2 = ($user['impulse_motor_tech'] * 2) - 1;
$tempvar3 = doquery("SELECT * FROM {{table}} WHERE galaxy = ".$g." AND
			system = ".$s." AND
			planet = ".$i." AND
			planet_type = '1'", 'planets');
if ($planet['silo'] < 4) { 	$error = 1;  
}elseif ($user['impulse_motor_tech'] == 0) {; 	$error = 1;  
}elseif ($tempvar1 >= $tempvar2 || $g != $currentplanet['galaxy']) { 	$error = 1; 
}elseif (mysql_num_rows($tempvar3) != 1) { 	$error = 1; 
}elseif ($anz > $iraks || $anz <= 0 ) { 	$error = 2; 
}elseif ($ziel_id == $user['current_planet']) { 	$error = 3; 
}elseif ((!is_numeric($pziel) && $pziel != "all") OR ($pziel < 0 && $pziel > 7 && $pziel != "all")) { 	$error = 1; } 
if ($error == 1) { 	message('Dein Impulstriebwerk ist nicht f&uuml;r diese Distanz ausgebaut.', 'Error'); 	exit(); }
if ($error == 2) { 	message('Du hast zu wenige Raketen um einen Angriff zu starten.', 'Error'); 	exit(); }
if ($error == 3) { 	message('Du kannst dich nicht selbst angreifen.', 'Error'); 	exit(); }

$iraks_anzahl = $iraks;

if ($pziel == "all"){
	$pziel = 0;
}else{
	$pziel = intval($pziel);
}



$select = doquery("SELECT * FROM {{table}} WHERE id = ".$ziel_id, 'users', true);

$verteidiger_panzerung = $select['defence_tech'];
$angreifer_waffen = $user['military_tech'];
 
$primaerziel = $pziel;
 
$iraks = $anz;
 
$def = array(
			0 => $planet['misil_launcher'], // Raketenwerfer
			1 => $planet['small_laser'], // Leichtes Lasergeschï¿½tz
			2 => $planet['big_laser'], // Schweres Lasergeschï¿½tz
			3 => $planet['gauss_canyon'], // Gauï¿½kanone
			4 => $planet['ionic_canyon'], // Ionengeschï¿½tz
			5 => $planet['buster_canyon'], // Plasmawerfer
			6 => $planet['small_protection_shield'], // Kleine Schildkuppel
			7 => $planet['big_protection_shield'], // Groï¿½e Schildkuppel
			8 => $planet['interplanetary_misil'], // Interplanetarrakete
			9 => $planet['interceptor_misil'], // Abfangrakete
		);

$lang = array(
			0 => $lang['tech'][401],
			1 => $lang['tech'][402],
			2 => $lang['tech'][403],
			3 => $lang['tech'][404],
			4 => $lang['tech'][405],
			5 => $lang['tech'][406],
			6 => $lang['tech'][407],
			7 => $lang['tech'][408],
			8 => $lang['tech'][502],
			9 => $lang['tech'][503],
	 	);

$flugzeit = round(((30 + (60 * $tempvar1)) * 2500) / $game_config['game_speed']);



/*
include("./includes/raketenangriff.php");


$irak = raketenangriff($verteidiger_panzerung, $angreifer_waffen, $iraks, $def, $primaerziel);

 $ids = array(
		0 => 401,
		1 => 402,
		2 => 403,
		3 => 404,
		4 => 405,
		5 => 406,
		6 => 407,
		7 => 408,
		8 => 502,
		9 => 503
	);





foreach ($irak['verbleibt'] as $id => $anzahl) {
	if ($id < 10) {

		$x = $resource[$ids[$id]];

		doquery("UPDATE {{table}} SET ".$x." = '".$anzahl."' WHERE id = ".$ziel_id, 'planets');


	}


}
*/

doquery("INSERT INTO {{table}} SET
		`zeit` = '".(time() + $flugzeit)."',
		`galaxy` = '".$g."',
		`system` = '".$s."',
		`planet` = '".$i."',
		`galaxy_angreifer` = '".$currentplanet['galaxy']."',
		`system_angreifer` = '".$currentplanet['system']."',
		`planet_angreifer` = '".$currentplanet['planet']."',
		`owner` = '".$user['id']."',
		`zielid` = '".$ziel_id."',
		`anzahl` = '".$anz."',
		`primaer` = '".$primaerziel."'", 'iraks');

//die("INESRT IN TABLE");

doquery("UPDATE {{table}} SET interplanetary_misil = '".($iraks_anzahl - $anz)."' WHERE id = '".$user['current_planet']."'", 'planets');

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

if ($anz == 1){
	$n = "";
}else{
	$n = "n";
}

?>
<html>
<head>
<title>Interplanetarraketen-Angriff</title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $dpath; ?>formate.css" />
<meta http-equiv="refresh" content="3; URL=galaxy.php?mode=3&galaxy=<?php echo $g; ?>&system=<?php echo $s; ?>&target=<?php echo $i; ?>">


</head>
<body>
<br><br><br>
  <center>

<table border="0">
  <tbody><tr>
    <td>
      <table>
        <tbody>
        <tr>
         <td class="c" colspan="1">Interplanetarraketen-Angriff</td>
	</tr>
        <tr>
	<td class="l"><?php echo "<b>".$anz."</b> Interplanetarrakete".$n." abgeschossen !"; ?>
        </tr>
       </tbody></table>
      </td>
      </tr>
     </tbody></table>

</form>


 </body></html>
<?php

?>
