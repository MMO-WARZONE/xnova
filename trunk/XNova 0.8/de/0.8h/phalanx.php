<?php

/**
 * phalanx.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


global $planetrow;
$deuterium = $planetrow['deuterium'];
$phalangelvl = $planetrow['phalanx'];
$consomation = $phalangelvl * 10000;
$deuteriumtotal = $deuterium - $consomation;
if ($planetrow['planet_type'] != '3')
{
message("Der Sensor funktioniert nur auf dem Mond", "Erreur", "overview." . $phpEx, 1);
}
elseif ($planetrow['phalanx'] == '0')
{
message("Sie bauen grad Ihre Phalanx aus", "Erreur", "overview." . $phpEx, 1);
}
elseif ($deuterium < $consomation)
{
message ("<b>Sie haben nicht genug deuterium!!!!</b>", "Erreur", "overview." . $phpEx, 2);
}
else
{
doquery("UPDATE {{table}} SET deuterium=$deuteriumtotal WHERE id='{$user['current_planet']}'", 'planets');
}
$poziom = $planetrow['phalanx'];
$systemdol = $system - $phalangelvl * 3;
$systemgora = $system + $phalangelvl * 3;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$g  = $_GET["galaxy"];
	$s  = $_GET["system"];
	$i  = $_GET["planet"];
	$id = $_GET["id"];
	$id_owner = $_GET['id_owner'];
}

$planetas = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $g ."' AND `system` = '". $s ."' AND `planet` = '". $i ."';", 'planets');
while ($row_planetas = mysql_fetch_array($planetas)) {
	$nome = $row_planetas['name'];
}

$missiontype = array(
	1 => 'Angrif',
	2 => '2',
	3 => 'Transport',
	4 => 'Stationieren',
	5 => 'Halten',
	6 => '6',
	7 => 'Kolonisieren',
	8 => 'TF abbauen',
	9 => 'Mond Zerst&ouml;ren',
	15 => 'Expedition',
	);

$fq = doquery("SELECT * FROM {{table}} WHERE  (
		( fleet_start_galaxy=$g AND fleet_start_system=$s AND fleet_start_planet=$i AND fleet_start_type!='3')
		OR
		    ( fleet_end_galaxy=$g AND fleet_end_system=$s AND fleet_end_planet=$i AND fleet_end_type!='3' AND fleet_end_type!='2')
		) ORDER BY `fleet_start_time`", 'fleets');

if (mysql_num_rows($fq) == "0") {
	$page .= "<table width=519>
	<tr>
	  <td class=c colspan=7>Dernière manoeuvres sur la Planete</td>
	</tr><th>Es wurde keine Bewegende Flotte entdeckt</th></table>";
} else {
	$page .= "<center><table>";
	$parse = $lang;

	while ($row = mysql_fetch_array($fq)) {
		$i++;
		$timerek    = $row['fleet_start_time'];
		$timerekend = $row['fleet_end_time'];

		if ($row['fleet_mission'] == 1) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 2) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 3) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 4) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 5) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 6) { $kolormisjido = orange; }
		if ($row['fleet_mission'] == 7) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 8) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 9) { $kolormisjido = lime;   }
		if ($row['fleet_mission'] == 1) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 2) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 3) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 4) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 5) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 6) { $kolormisjiz = B45D00;  }
		if ($row['fleet_mission'] == 7) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 8) { $kolormisjiz = green;   }
		if ($row['fleet_mission'] == 9) { $kolormisjiz = green;   }

		// variable avec les coordoner d'origine
		$g1 = $row['fleet_start_galaxy'];
		$s1 = $row['fleet_start_system'];
		$i1 = $row['fleet_start_planet'];
		$t1 = $row['fleet_start_type'];

		// variable avec les coordoner de destination
		$g2 = $row['fleet_end_galaxy'];
		$s2 = $row['fleet_end_system'];
		$i2 = $row['fleet_end_planet'];
		$t2 = $row['fleet_end_type'];

		$parse['manobras'] .= "<tr><th><div id=\"bxxfs$i\" class=\"z\"></div><font color=\"lime\">" . date('d/m : H\h i\m\i\n s\s', $timerek) . "</font> </th><th colspan=\"3\">";
		$parse['manobras'] .= "<th><font color=\"$kolormisjido\">Eine "; 
		$parse['manobras'] .= '(<a title="';
		/*
		  Il faut faire une liste de flotte
		*/
		$fleet = explode(";", $row['fleet_array']);
		$e = 0;
		foreach($fleet as $a => $b) {
			if ($b != '') {
				$e++;
				$a = explode(",", $b);
				$parse['manobras'] .= "{$lang['tech']{$a[0]}}: {$a[1]}, \n";
				if ($e > 1) {
					$parse['manobras'] .= "\t";
				}
			}
		}
		$parse['manobras'] .= "\">Flotte</a>)";
		if ($t1 == '3')
		{
		$type = "Mond";
		}
		else
		{
		$type = "Planet";
		}
		$planetas = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $g1 ."' AND `system` = '". $s1 ."' AND `planet` = '". $i1 ."' AND `planet_type` = '". $t1 ."';", 'planets');
while ($row_planetas = mysql_fetch_array($planetas)) {
	$name = $row_planetas['name'];
}
		if ($t2 == '3')
		{
		$type2 = "Mond";
		}
		else
		{
		$type2 = "Planet";
		}
		$planetas = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $g2 ."' AND `system` = '". $s2 ."' AND `planet` = '". $i2 ."' AND `planet_type` = '". $t2 ."';", 'planets');
while ($row_planetas = mysql_fetch_array($planetas)) {
	$name2 = $row_planetas['name'];
}
		$parse['manobras'] .= " Von dem $type $name <font color=\"white\">[$g1:$s1:$i1]</font>erreicht den $type2 $name2 <font color=\"white\">[$g2:$s2:$i2]</font>. Die Mission Lautet:";
		$parse['manobras'] .= " <font color=\"white\">{$missiontype[$row['fleet_mission']]}</font></th><br>";

		$parse['manobras'] .= "<tr><th><div id=\"bxxfs$i\" class=\"z\"></div><font color=\"green\">" . date('d/m : H\h i\m\i\n s\s', $timerekend) . "</font></th><th colspan=\"3\">";
		$parse['manobras'] .= "<th><font color=\"$kolormisjido\">Eine ";
		$parse['manobras'] .= '(<a title="';
		/*
		  Il faut faire une liste de flotte
		*/
		$fleet = explode(";", $row['fleet_array']);
		$e = 0;
		foreach($fleet as $a => $b) {
			if ($b != '') {
				$e++;
				$a = explode(",", $b);
				$parse['manobras'] .= "{$lang['tech']{$a[0]}}: {$a[1]}, \n";
				if ($e > 1) {
					$parse['manobras'] .= "\t";
				}
			}
		}
		$parse['manobras'] .= "\">flotte</a>)";

		$parse['manobras'] .= " Von dem $type2 $name2 <font color=\"white\">[$g2:$s2:$i2]</font> zurück zum $type $name <font color=\"white\">[$g1:$s1:$i1]</font>. Die Mission Lautet:";
		$parse['manobras'] .= " <font color=\"white\">{$missiontype[$row['fleet_mission']]}</font></th></tr><br>";
	}

	$page = parsetemplate(gettemplate('phalanx_body'), $parse);
}

display($page, "phalanx");

// Créer par Bladegame et TMD
?>
