<?php

/**
 * galaxy.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

// Schutz vor unregestrierten
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

	includeLang('galaxy');

	$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."';", 'planets', true);
	$lunarow       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_luna'] ."';", 'lunas', true);
	$galaxyrow     = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $CurrentPlanet['id'] ."';", 'galaxy', true);

	$dpath         = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
	$fleetmax      = $user['computer_tech'] + ($user['rpg_commandant'] * 3) + 1;
	$CurrentPlID   = $CurrentPlanet['id'];
	$CurrentMIP    = $CurrentPlanet['interplanetary_misil'];
	$CurrentRC     = $CurrentPlanet['recycler'];
	$CurrentSP     = $CurrentPlanet['spy_sonde'];
	$HavePhalanx   = $CurrentPlanet['phalanx'];
	$CurrentSystem = $CurrentPlanet['system'];
	$CurrentGalaxy = $CurrentPlanet['galaxy'];
	$CanDestroy    = $CurrentPlanet[$resource[213]] + $CurrentPlanet[$resource[214]];

	$maxfleet       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
	$maxfleet_count = mysql_num_rows($maxfleet);

	CheckPlanetUsedFields($CurrentPlanet);
	CheckPlanetUsedFields($lunarow);

	// Imperatif, dans quel mode suis-je (pour savoir dans quel etat j'ere)
	if (!isset($mode)) {
		if (isset($_GET['mode'])) {
			$mode          = intval($_GET['mode']);
		} else {
			// ca ca sent l'appel sans parametres a plein nez
			$mode          = 0;
		}
	}

	if ($mode == 0) {
		// On vient du menu
		// Y a pas de parametres de passé
		// On met ce qu'il faut pour commencer là ou l'on se trouve

		$galaxy        = $CurrentPlanet['galaxy'];
		$system        = $CurrentPlanet['system'];
		$planet        = $CurrentPlanet['planet'];
	} elseif ($mode == 1) {
		// On vient du selecteur de galaxie
		// Il nous poste :
		// $_POST['galaxy']      => Galaxie affichée dans la case a saisir
		// $_POST['galaxyLeft']  => <- A ete cliqué
		// $_POST['galaxyRight'] => -> A ete cliqué
		// $_POST['system']      => Systeme affiché dans la case a saisir
		// $_POST['systemLeft']  => <- A ete cliqué
		// $_POST['systemRight'] => -> A ete cliqué

		if ($_POST["galaxyLeft"]) {
			if ($_POST["galaxy"] < 1) {
				$_POST["galaxy"] = 1;
				$galaxy          = 1;
			} elseif ($_POST["galaxy"] == 1) {
				$_POST["galaxy"] = 1;
				$galaxy          = 1;
			} else {
				$galaxy = $_POST["galaxy"] - 1;
			}
		} elseif ($_POST["galaxyRight"]) {
			if ($_POST["galaxy"]      > MAX_GALAXY_IN_WORLD OR
				$_POST["galaxyRight"] > MAX_GALAXY_IN_WORLD) {
				$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
				$_POST["galaxyRight"] = MAX_GALAXY_IN_WORLD;
				$galaxy               = MAX_GALAXY_IN_WORLD;
			} elseif ($_POST["galaxy"] == MAX_GALAXY_IN_WORLD) {
				$_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
				$galaxy               = MAX_GALAXY_IN_WORLD;
			} else {
				$galaxy = $_POST["galaxy"] + 1;
			}
		} else {
			$galaxy = $_POST["galaxy"];
		}

		if ($_POST["systemLeft"]) {
			if ($_POST["system"] < 1) {
				$_POST["system"] = 1;
				$system          = 1;
			} elseif ($_POST["system"] == 1) {
				$_POST["system"] = 1;
				$system          = 1;
			} else {
				$system = $_POST["system"] - 1;
			}
		} elseif ($_POST["systemRight"]) {
			if ($_POST["system"]      > MAX_SYSTEM_IN_GALAXY OR
				$_POST["systemRight"] > MAX_SYSTEM_IN_GALAXY) {
				$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
				$system               = MAX_SYSTEM_IN_GALAXY;
			} elseif ($_POST["system"] == MAX_SYSTEM_IN_GALAXY) {
				$_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
				$system               = MAX_SYSTEM_IN_GALAXY;
			} else {
				$system = $_POST["system"] + 1;
			}
		} else {
			$system = $_POST["system"];
		}
	} elseif ($mode == 2) {
		// Mais c'est qu'il mordrait !
		// A t'on idée de vouloir lancer des MIP sur ce pauvre bonhomme !!

		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
		$planet        = $_GET['planet'];
	} elseif ($mode == 3) {
		// Appel depuis un menu avec uniquement galaxy et system de passé !
		$galaxy        = $_GET['galaxy'];
		$system        = $_GET['system'];
	} else {
		// Si j'arrive ici ...
		// C'est qu'il y a vraiment eu un bug
		$galaxy        = 1;
		$system        = 1;
	}

	$planetcount = 0;
	$lunacount   = 0;

	

	echo InsertGalaxyScripts ( $CurrentPlanet );


	echo ShowGalaxySelector ( $galaxy, $system );
	
	
	
//	echo  ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

	

	
	if ($mode == 2) {
		$CurrentPlanetID = $_GET['current'];
	echo ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
	}

	echo "<table width=569><tbody>";

//	$page .= ShowGalaxyTitles ( $galaxy, $system );
//   $page .= ShowGalaxyRows   ( $galaxy, $system );
//   $page .= ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

	echo "</center></tbody></table></div>";


echo "

<div id=\"raum_3\" style=\"z-index: 0; position: absolute; top: 50px; height: 0px;\"><img src=\"images/galaxy/gala.jpg\" border=\"4\" height=\"600\" width=\"916\"></div>
";

$e = 0; $f = 1; $g = 1;

$position = array(
"276;577; 347;590; 350;138; 593;590; 444;502; 110;400; 661;351; 725;150; 40;280; 751;483; 300;347; 186;182; 206;540; 494;380; 516;220;",
"350;308; 533;608; 444;472; 37;487; 176;610; 347;570; 641;351; 755;150; 444;320; 546;240; 126;200; 701;483; 240;347; 336;142; 246;500;",
"546;340; 176;597; 347;570; 350;138; 524;220; 533;600; 444;412; 70;530; 246;480; 641;351; 755;150; 106;230; 701;483; 380;347; 236;282;",
"533;428; 444;472; 137;450; 611;351; 755;150; 106;230; 701;483; 380;347; 236;282; 246;500; 584;550; 546;240; 46;607; 347;570; 350;138;",
"350;288; 533;588; 444;472; 36;607; 347;570; 107;450; 641;351; 755;150; 106;200; 701;483; 380;347; 306;162; 246;500; 240;280; 546;240;",
"187;470; 661;351; 755;150; 56;607; 347;570; 350;138; 533;588; 304;472; 546;240; 60;230; 701;503; 340;327; 524;400; 196;282; 166;500;");

$randomquote = mt_rand(0,count($position)-1);

$pos  = " . $position[$randomquote] . ";
 $count = 1;
 while($count < 16)
{
$missiontime = explode(";", $pos);
$pos1 = $missiontime[ $e ] +80;
$pos2 = $missiontime[ $f ]-50;

echo "<div id=\"$e\" style=\"z-index: 6; position: absolute; left: ".$pos1."px; top: ".$pos2."px; width: 10px; height: 10px; visibility: visible;\">";
$leer = '';$img = '';

$query = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$count' AND planet_type =  '1';", 'planets');
while($row = mysql_fetch_assoc($query)){
$leer = $row['planet'];
$img = $row['image'];



//$planet_name = $row['name'];


$query1 = doquery("SELECT ally_id, ally_name, username, authlevel, onlinetime, id,bana  FROM {{table}} WHERE `id` = '".$row['id_owner']."';", 'users');
while($row1 = mysql_fetch_assoc($query1)){

if ($row1['ally_id'] == '0'){$ally = '';} else {
$ally = "Ally: <a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">".$row1['ally_name']."</a><br />";}

		if ($row1['authlevel'] == 3)
			{$username = "<font color=red>".$row1['username']."</font>";
			$planetname = "<font color=red>".$row['name']."</font>";
			
			
	} elseif ($row1['urlaubs_modus'] == 1) 
			{$username = "<font color=skyblue>".$row1['username']."</font>";
			$planetname = "<font color=skyblue>".$row['name']."</font>";
			
	} elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 7) AND
			$row1['onlinetime'] > (time()-60 * 60 * 24 * 28)) 
			{$username = "<font color=#aaaaaa>".$row1['username']."(i)</font>";
			$planetname = "<font color=#aaaaaa>".$row['name']."</font>";
			
	} elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 28)) 
			{$username = "<font color=#cccccc>".$row1['username']."(Ii)</font>";
			$planetname = "<font color=#cccccc>".$row['name']."</font>";
			
	} elseif ($row1['bana'] == 1) 
			{$username = "<font color=line-through>".$row1['username']."</font>";
			$planet_name = "<font color=line-through>".$row['name']."</font>";
			
	} else {$username = "<font color=limegreen>".$row1['username']."</font>";
			$planetname = "<font color=limegreen>".$row['name']."</font>";
			}

if ($row1['id'] != $user['id'])
{$buddy ="<a href=buddy.php?a=".$row['id_owner']."&u=".$row['id_owner']."><font color=red>Buddyanfrage</a><br></font>";} else {$buddy ='';}

if ($row1['id'] != $user['id'])
{$mail ="<a href=messages.php?mode=write&id=".$row['id_owner']."><font color=red>Nachricht Schreiben</a><br></font>";} else {$mail ='';}
}


$query2 = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$g' Limit 1;", 'galaxy');
while($row2 = mysql_fetch_assoc($query2)){

if ($row2['id_luna'] != '0'){$mond = "<font color=yellow>Mond: ja</font><br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=3&target_mission=9><font color=red>Mond Zerstören</font></a><br>";}else{$mond = "<font color=yellow>Mond: nein</font><br>";}
if ($row2['id_luna'] != '0'){$mond1 = 1;}else{$mond1 = 0;}

if ($row2['metal'] > '0'){
if ($row2['crystal'] > '0'){
$tr = "<a style=\"cursor: crosshair;\" onmouseover='return overlib(\" <table width=150><tr><td class=c colspan=2> TF: <br> Metall: ".$row2['metal']."<br>Kristall: ".$row2['crystal']."</th></tr><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=2&target_mission=8>Abbau</a></th></tr>  </table>\",STICKY, MOUSEOFF, DELAY, 150, CENTER, OFFSETX, -20, OFFSETY, -50 );' onmouseout='return nd();'><img src=images/galaxy/debris.gif>";


}else {

$galaxy = $row2['galaxy'];

$tr = "";}
}
}

/**/

echo"<th width=30><a style=\"cursor: crosshair;\" onmouseover='return overlib(\" <table width=250><tr><td class=c colspan=2>Planet ".$row['name']." [".$row['galaxy'].":".$row['system'].":".$row['planet']."]</td></tr><tr><th width=80><img src=images/galaxy/sp".$g.".gif height=75 width=75 /></th><th align=left>Pos. ".$row['planet']."<br>Name: ".$row['name']."<br> Besitzer: <a href=stat.php?who=player&start=".$row['id_owner']." title=Statistik alt=Statistik> $username </a><br>$mond  $ally $buddy $mail<hr><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=4>Spionage</a><br /><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=3>Transport</a><br/><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=1>Angriff</a></th></tr>  </table>\",STICKY, MOUSEOFF, DELAY, 100, CENTER, OFFSETX, -100, OFFSETY, -150 );' onmouseout='return nd();'>";}

/*if ($leer ==''){
echo"<th width=30><a style=\"cursor: crosshair;\" onmouseover='return overlib(\" <table width=250><tr><td class=c colspan=2><center>Der Planet ist noch nicht <br>besiedelt [$galaxy : $system : $count]</center></td></tr> <th align=left>$tr <hr><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=7>Kolonisieren</a></th></tr>  </table>\",STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' onmouseout='return nd();'>

";}*/

if ($img != '') {

echo "$username $ally <a href=# onclick='javascript:doit(6, $galaxy, $system, $g, 1, {$user["spio_anz"]});'><img src=images/galaxy/sp".$g.".gif  height=\"30\" width=\"30\">($planetname)$count</a><table  width=\"100\" height=\"50\"><tr><td><p><a href=# onclick='javascript:doit(6, $galaxy, $system, $g, 3, {$user["spio_anz"]});'><img src=images/galaxy/mond".$mond1.".gif><p></a></td><td>".$tr."</td></tr></table></div>";

} else {
 echo"<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=7><img src=images/galaxy/sp".$g.".gif height=\"40\" width=\"40\">(Frei)$count</a></th></div>";}

echo "<div id=\"99\" style=\" position: absolute; left: 20px; top: 130px; width: 10px; height: 10px;\"><a href=fleet.php?galaxy=$galaxy&system=$system&planet=16&planettype=1&target_mission=15><img src=images/galaxy/wurmloch.png height=\"30\" width=\"30\">Wurmloch</a></th></div>";


$e++;$e++; $f++; $f++; $g++;
    $count++;
    }


	display ($page, $lang[''], false, '', false);


?>