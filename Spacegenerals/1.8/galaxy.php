<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

// Schutz vor unregestrierten
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

####
ob_start();
$page = '';
####

includeLang('galaxy');

$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."';", 'planets', true);
$lunarow      = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_luna'] ."';", 'lunas', true);
$galaxyrow    = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $CurrentPlanet['id'] ."';", 'galaxy', true);
$userrow 	 = doquery("SELECT galaxyansicht  FROM {{table}} WHERE `id` = '".$user['id']."';", 'users', true);

$dpath        = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$fleetmax      = $user['computer_tech'] + ($user['rpg_commandant'] * 3) + 1;
$CurrentPlID  = $CurrentPlanet['id'];
$CurrentMIP    = $CurrentPlanet['interplanetary_misil'];
$CurrentRC    = $CurrentPlanet['recycler'];
$CurrentSP    = $CurrentPlanet['spy_sonde'];
$HavePhalanx  = $CurrentPlanet['phalanx'];
$CurrentSystem = $CurrentPlanet['system'];
$CurrentGalaxy = $CurrentPlanet['galaxy'];
$CanDestroy    = $CurrentPlanet[$resource[213]] + $CurrentPlanet[$resource[214]];

$maxfleet      = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
$maxfleet_count = mysql_num_rows($maxfleet);

CheckPlanetUsedFields($CurrentPlanet);
CheckPlanetUsedFields($lunarow);

// Imperatif, dans quel mode suis-je (pour savoir dans quel etat j'ere)
if (empty($mode)) {
if (isset($_GET['mode'])) {
	$mode          = intval($_GET['mode']);
} else {
	// ca ca sent l'appel sans parametres a plein nez
	$mode          = 0;
}
}

if ($mode == 0) {
	// On vient du menu
	// Y a pas de parametres de passÃ©
	// On met ce qu'il faut pour commencer lÃ  ou l'on se trouve

	$galaxy        = $CurrentPlanet['galaxy'];
	$system        = $CurrentPlanet['system'];
	$planet        = $CurrentPlanet['planet'];
} elseif ($mode == 1) {
	// On vient du selecteur de galaxie
	// Il nous poste :
	// $_POST['galaxy']      => Galaxie affichÃ©e dans la case a saisir
	// $_POST['galaxyLeft']  => <- A ete cliquÃ©
	// $_POST['galaxyRight'] => -> A ete cliquÃ©
	// $_POST['system']      => Systeme affichÃ© dans la case a saisir
	// $_POST['systemLeft']  => <- A ete cliquÃ©
	// $_POST['systemRight'] => -> A ete cliquÃ©

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
	// A t'on idÃ©e de vouloir lancer des MIP sur ce pauvre bonhomme !!

	$galaxy        = $_GET['galaxy'];
	$system        = $_GET['system'];
	$planet        = $_GET['planet'];
} elseif ($mode == 3) {
	// Appel depuis un menu avec uniquement galaxy et system de passÃ© !
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

////////////////////
// Galaxy auswahl //
////////////////////

if ($userrow['galaxyansicht'] == 0 or $userrow['galaxyansicht'] == '')
{
$ansicht = $game_config['standart_galaxyansicht'];
}
else
{
$ansicht = $userrow['galaxyansicht'];
}

if ($ansicht == 1)
{

///////////////////
// Listenansicht //
///////////////////

$page  = InsertGalaxyScripts ( $CurrentPlanet );

$page .= "<body style=\"overflow: hidden;\" onUnload=\"\">";
$page .= ShowGalaxySelectorlist ( $galaxy, $system );

if ($mode == 2) {
	$CurrentPlanetID = $_GET['current'];
	$page .= ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
}

$page .= "<table width=569><tbody>";

$page .= ShowGalaxyTitles ( $galaxy, $system );
$page .= ShowGalaxyRows   ( $galaxy, $system );
$page .= ShowGalaxyFooterlist ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

$page .= "</tbody></table></div>";


display ($page, $lang[''], false, '', false);


}
elseif ($ansicht == 3)
{


//////////////////
//  3D Ansicht  //
//////////////////


echo InsertGalaxyScripts ( $CurrentPlanet );
echo ShowGalaxySelector ( $galaxy, $system );
echo ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);





if ($mode == 2) {
$CurrentPlanetID = $_GET['current'];
echo ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
}

echo "<table width=569><tbody>";

echo "</tbody></table></div>";


echo "	<div id=\"raum_3\" style=\"z-index: 0; position: absolute; left: 0px; right: 0px; top: 30px; height: 0px;\">
		<img src=\"images/galaxy/gala2.jpg\" border=\"4\" height=\"600\" width=\"900\">
		</div>
		";

$e = 0; $f = 1; $g = 1;

$position = array(
//	1		 2		  3		   4		5		 6		  7		   8		9		10		 11		  12		13		14		 15
"276;577; 347;590; 350;138; 593;590; 444;502; 110;400; 661;351; 725;150; 40;280;  751;483; 300;347; 186;182; 206;540; 494;380; 516;220;",
"350;308; 533;608; 444;472; 37;487;  176;610; 347;570; 641;351; 755;150; 444;320; 546;240; 126;200; 701;483; 240;347; 336;142; 246;500;",
"546;340; 176;597; 347;570; 350;138; 524;220; 533;600; 444;412; 70;530;  246;480; 641;351; 755;150; 106;230; 701;483; 380;347; 236;282;",
"187;470; 661;351; 755;150; 56;607;  347;570; 350;138; 533;588; 304;472; 546;240; 60;230;  701;503; 340;327; 524;400; 196;282; 166;500;");


$randomquote = mt_rand(0,count($position)-1);
$pos  = " . $position[$randomquote] . ";
$count = 1;
while($count < 16)
{
$missiontime = explode(";", $pos);
$pos1 = $missiontime[ $e ] + 80;
$pos2 = $missiontime[ $f ] - 50;

$pos1minus = $missiontime[ $e ] + 80 - 916;
$pos1minus = $pos1minus * -1;

echo "<div id=\"$e\" style=\"z-index: 6; position: absolute; left: ".$pos1."px; right: ".$pos1minus."px; top: ".$pos2."px; height: 10px; visibility: visible;\">";
$leer = '';
$userid = '';

$query = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$count' AND planet_type =  '1';", 'planets');
while($row = mysql_fetch_assoc($query))
{
	$leer = 1;
	$userid = $row['id_owner'];
	$Punkte = "-";
	$command  = "";

	$query1 = doquery("SELECT 	angriffszone, ally_id, ally_name, username, authlevel, onlinetime, id,bana  FROM {{table}} WHERE `id` = '".$row['id_owner']."';", 'users');
	while($row1 = mysql_fetch_assoc($query1))
	{
		if ($row1['ally_id'] == '0')
		{
			$ally    = '';
			$allytag = '';
			$allytag2 = $lang['Alliance']." ---<br>";
		}
		else
		{
			$ally = "<br>".$lang['Alliance']."<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$row1['ally_name']."&nbsp;</a>";

			$query3 = doquery("SELECT ally_tag FROM {{table}} WHERE `id` = '".$row1['ally_id']."';", 'alliance');
			while($row3 = mysql_fetch_assoc($query3))
			{
			$allytag  = "<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$lang['Alliance']." ".$row3['ally_tag']."&nbsp;</a><br>";
			$allytag2 = "<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$lang['Alliance']." ".$row3['ally_tag']."&nbsp;</a><br>";
			}
		}

		if ($row1['authlevel'] == 3)
		{
			$username = "<font color=red>&nbsp;".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=red>".$row['name']."</font>";
		}
		elseif ($row1['urlaubs_modus'] == 1)
		{
			$username = "<font color=skyblue>".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=skyblue>".$row['name']."</font>";
		}
		elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 7) AND $row1['onlinetime'] > (time()-60 * 60 * 24 * 28))
		{
			$username = "<font color=#aaaaaa>&nbsp;".$row1['username']."(i)&nbsp;</font>";
			$planetname = "<font color=#aaaaaa>".$row['name']."</font>";
		}
		elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 28))
		{
			$username = "<font color=#cccccc>&nbsp;".$row1['username']."(I)&nbsp;</font>";
			$planetname = "<font color=#cccccc>".$row['name']."</font>";
		}
		elseif ($row1['bana'] == 1) {
			$username = "<font color=ffffff>".$row1['username']."(G)</font>";
			$planetname = "<font color=ffffff>".$row['name']."</font>";
		}
		else
		{
			$username = "<font color=limegreen>&nbsp;".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=limegreen>".$row['name']."</font>";
		}

		if ($row1['id'] != $user['id'])
		{
			$buddy    = "<hr>";
			$buddy   .= "<a href=buddy.php?a=".$row['id_owner']."&u=".$row['id_owner']."><font color=red>&nbsp;".$lang['Buddy']."&nbsp;</a><br></font>";
			$buddy   .= "<a href=messages.php?mode=write&id=".$row['id_owner']."><font color=red>&nbsp;".$lang['msg']."&nbsp;</a><br></font>";
			$command .= "<hr>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=6>&nbsp;".$lang['spionage']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=3>&nbsp;".$lang['transport']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=1>&nbsp;".$lang['angriff']."&nbsp;</a>";
		}
		elseif ($row['id'] != $user['current_planet'])
		{
			$buddy    = "";
			$command .= "<hr>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=3>&nbsp;".$lang['transport']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=4>&nbsp;".$lang['stationiren']."&nbsp;</a>";
		}
		else
		{
			$buddy    = "";
		}
		$angriffszone 	= "<br>".$lang['angriffszone']." <font color=#CCFF33>".$row1['angriffszone']."&nbsp;</font><br>";
	}



	$query2 = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$g' Limit 1;", 'galaxy');
	while($row2 = mysql_fetch_assoc($query2))
	{
		$TFMET = "";
		$TFCRY = "";
		$TFMET = $row2['metal'];
		$TFCRY = $row2['crystal'];
		if ($row2['id_luna'] != '0' and $row1['id'] != $user['id'])
		{
			$mond     = "<font color=yellow>&nbsp;".$lang['GALAXY_MOON']."&nbsp;</font><br>";
			$command .= "<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=3&target_mission=9><font color=red>&nbsp;".$lang['GALAXY_DESTROY_MOON']."&nbsp;</font></a>";
			$mond3    = "&nbsp;<img src=images/galaxy/mond1.gif>";
		}
		else
		{
			$mond  = "<font color=yellow>&nbsp;".$lang['GALAXY_NO_MOON']."&nbsp;</font><br>";
			$mond3 = "";
		}
		if ($row2['metal'] == '0' && $row2['crystal'] == '0')
		{
			$tf = "";
			$trbild = "";
		}
		else
		{
			$trbild = "tr";
			$tf = "<hr>&nbsp;".$lang['GALAXY_DEBRIS']."&nbsp;<br>&nbsp;".$TFMET." ".$lang['GALAXY_METAL']."&nbsp;<br>&nbsp;".$TFCRY." ".$lang['GALAXY_CRYSTAL']."&nbsp;<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=2&target_mission=8><br>".$lang['GALAXY_RECYCLE']."</a><br><br>";
		}
	}



	$query2 = doquery("SELECT total_points  FROM {{table}} WHERE `id_owner` = '".$row['id_owner']."';", 'statpoints');
	while($row2 = mysql_fetch_assoc($query2))
	{
		$Punkte = $row2['total_points']."&nbsp;";
	}



	echo "<a href=\"playercard.php?playerid=" . $userid . "&ownid=" . $user['id'] . "\">$username</a> <br> $allytag ";
	echo "<th width=30><a style=\"cursor: crosshair;\" onmouseover='return overlib(\"<table width=150><tr><td class=c><b>&nbsp;[".$row['galaxy'].":".$row['system'].":".$row['planet']."]&nbsp;</b></td></tr><tr><th>".$lang['Player'].$username."<br>".$lang['Planet']." ".$planetname."<br>".$allytag2.$lang['Points']." ".$Punkte."</th></tr></table>\");' onclick='return overlib(\" <table width=250><tr><td class=c colspan=2>Planet ".$row['name']." [".$row['galaxy'].":".$row['system'].":".$row['planet']."]</td></tr><tr><th width=80><img src=images/galaxy/sp".$g.$trbild.".gif height=75 width=75 /></th><th align=left>&nbsp;".$lang['Pos']." ".$row['planet']."&nbsp;<br>&nbsp;".$lang['Planet']." ".$planetname."&nbsp;<br>&nbsp;".$lang['Player']." <a href=playercard.php?playerid=$userid&ownid=" . $user['id'] . ">$username</a>".$ally.$angriffszone.$mond.$buddy.$command.$tf."</th></tr>  </table>\",STICKY, MOUSEOFF, DELAY, 100, CENTER, OFFSETX, -75, OFFSETY, -25 );' onmouseout='return nd();'>";
}



if ($planetrow['colonizer'] >= 1){
	$siedeln = "<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=7>&nbsp;".$lang['siedeln']."&nbsp;</a><br>";
} else {
	$siedeln = "";
}

if ($leer == '')
{
	echo "<td width=30><a style=\"cursor: crosshair;\" onclick='return overlib(\"<table width=250><tr><td class=c>&nbsp;[".$galaxy.":".$system.":".$count."]&nbsp;</td></tr><tr><th>&nbsp;<br>&nbsp;".$lang['Free_Planet']."<br>".$siedeln."&nbsp;</th></tr></table>\",STICKY, MOUSEOFF, CENTER, OFFSETX, -75, OFFSETY, -25 );' onmouseover='return overlib(\"<table width=100><tr><td class=c>&nbsp;[".$galaxy.":".$system.":".$count."]&nbsp;</td></tr><tr><th>&nbsp;".$lang['Free']."&nbsp;</th></tr></table>\");' onmouseout='return nd();'>";
	echo "<img src=images/galaxy/sp".$g.".gif height=\"30\" width=\"30\"><br>$count<br></a></td></div>";
}
else
{
	echo "<img src=images/galaxy/sp".$g.$trbild.".gif  height=\"30\" width=\"30\">".$mond3." <br> (".$planetname.") <br> $count <table  width=\"100\" height=\"50\"></table></div>";
}



echo "<div id=\"99\" style=\" position: absolute; left: 20px; right: 824px; top: 100px; height: 10px;\"><a href=fleet.php?galaxy=$galaxy&system=$system&planet=16&planettype=1&target_mission=15><img src=images/galaxy/wurmloch.png height=\"30\" width=\"30\"><br>".$lang['GALAXY_WORMHOLE']."</a></th></div>";



$e++; $e++;
$f++; $f++;
$g++;
$count++;
}

$page .= ob_get_clean();

display ($page, $lang[''], false, '', false);

}
else
{


//////////////////
//  2D Ansicht  //
//////////////////


echo InsertGalaxyScripts ( $CurrentPlanet );
echo ShowGalaxySelector ( $galaxy, $system );
echo  ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

if ($mode == 2) {
	$CurrentPlanetID = $_GET['current'];
	echo ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
}

echo "<table width=569><tbody>";

//  $page .= ShowGalaxyTitles ( $galaxy, $system );
//  $page .= ShowGalaxyRows  ( $galaxy, $system );
//  $page .= ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentSP);

echo "</tbody></table></div>";


echo "	<div id=\"raum_3\" style=\"z-index: 0; position: absolute; left: 0px; right: 0px; top: 30px; height: 0px;\">
		<img src=\"images/galaxy/gala.jpg\" border=\"4\" height=\"600\" width=\"900\">
		</div>
		";

$e = 0; $f = 1; $g = 1;

$position = array(
//	1		 2		  3		   4		5		 6		  7		   8		9		10		 11		  12		13		14		 15
"276;577; 347;590; 350;138; 593;590; 444;502; 110;400; 661;351; 725;150; 40;280; 751;483; 300;347; 186;182; 206;540; 494;380; 516;220;",
"350;308; 533;608; 444;472; 37;487; 176;610; 347;570; 641;351; 755;150; 444;320; 546;240; 126;200; 701;483; 240;347; 336;142; 246;500;",
"546;340; 176;597; 347;570; 350;138; 524;220; 533;600; 444;412; 70;530; 246;480; 641;351; 755;150; 106;230; 701;483; 380;347; 236;282;",
"187;470; 661;351; 755;150; 56;607; 347;570; 350;138; 533;588; 304;472; 546;240; 60;230; 701;503; 340;327; 524;400; 196;282; 166;500;");

//	v-----v NEU v-----v
// Die ausgewählte Galaxy und das System werden nun zu einer zahl addirt diese zahl wird in eine Deximalzahl umgewandelt
// nun werden vor der zahl so viele nullen gesetzt bis es 10 stellen sind z.b. 1 = 0000000001; 2 = 0000000010 usw.
// jetzt werden die ersten 8 stellen einfach weg gestrichen und es bleiben die letzten 2 also sind nurnoch
// 00, 01, 10 und 11 über und die werden mit 0-3 erstezt daraus ergiebt sich nun für jedes Sonnensystem eine ganz eigene nummer.

$randomquote = substr ( str_pad ( decbin ( $system + $galaxy ), 10, '0', STR_PAD_LEFT ) , 8 );
$randomquote = str_replace ( "00" , "0" , $randomquote );
$randomquote = str_replace ( "01" , "1" , $randomquote );
$randomquote = str_replace ( "10" , "2" , $randomquote );
$randomquote = str_replace ( "11" , "3" , $randomquote );

//$randomquote = mt_rand(0,count($position)-1);				<----- Aktiviren um immer eine neue zufällige anordnung der planeten in der Galaxy zu zeigen.
//$randomquote = 0;											<----- Aktiviren um immer die gleiche anordnung der planeten in der Galaxy zu zeigen.

$pos  = " . $position[$randomquote] . ";
$count = 1;
while($count < 16)
{
$missiontime = explode(";", $pos);
$pos1 = $missiontime[ $e ] + 80;
$pos2 = $missiontime[ $f ] - 50;

$pos1minus = $missiontime[ $e ] + 80 - 916;
$pos1minus = $pos1minus * -1;

echo "<div id=\"$e\" style=\"z-index: 6; position: absolute; left: ".$pos1."px; right: ".$pos1minus."px; top: ".$pos2."px; height: 10px; visibility: visible;\">";
$leer = '';
$userid = '';

$query = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$count' AND planet_type =  '1';", 'planets');
while($row = mysql_fetch_assoc($query))
{
	$leer = 1;
	$userid = $row['id_owner'];
	$Punkte = "-";
	$command  = "";

	$query1 = doquery("SELECT 	angriffszone, ally_id, ally_name, username, authlevel, onlinetime, id,bana  FROM {{table}} WHERE `id` = '".$row['id_owner']."';", 'users');
	while($row1 = mysql_fetch_assoc($query1))
	{
		if ($row1['ally_id'] == '0')
		{
			$ally    = '';
			$allytag = '';
			$allytag2 = $lang['Alliance']." ---<br>";
		}
		else
		{
			$ally = "<br>".$lang['Alliance']."<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$row1['ally_name']."&nbsp;</a>";

			$query3 = doquery("SELECT ally_tag FROM {{table}} WHERE `id` = '".$row1['ally_id']."';", 'alliance');
			while($row3 = mysql_fetch_assoc($query3))
			{
			$allytag  = "<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$lang['Alliance']." ".$row3['ally_tag']."&nbsp;</a><br>";
			$allytag2 = "<a href=alliance.php?mode=ainfo&a=".$row1['ally_id'].">&nbsp;".$lang['Alliance']." ".$row3['ally_tag']."&nbsp;</a><br>";
			}
		}

		if ($row1['authlevel'] == 3)
		{
			$username = "<font color=red>&nbsp;".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=red>".$row['name']."</font>";
		}
		elseif ($row1['urlaubs_modus'] == 1)
		{
			$username = "<font color=skyblue>".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=skyblue>".$row['name']."</font>";
		}
		elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 7) AND $row1['onlinetime'] > (time()-60 * 60 * 24 * 28))
		{
			$username = "<font color=#aaaaaa>&nbsp;".$row1['username']."(i)&nbsp;</font>";
			$planetname = "<font color=#aaaaaa>".$row['name']."</font>";
		}
		elseif ($row1['onlinetime'] < (time()-60 * 60 * 24 * 28))
		{
			$username = "<font color=#cccccc>&nbsp;".$row1['username']."(I)&nbsp;</font>";
			$planetname = "<font color=#cccccc>".$row['name']."</font>";
		}
		elseif ($row1['bana'] == 1) {
			$username = "<font color=ffffff>".$row1['username']."(G)</font>";
			$planetname = "<font color=ffffff>".$row['name']."</font>";
		}
		else
		{
			$username = "<font color=limegreen>&nbsp;".$row1['username']."&nbsp;</font>";
			$planetname = "<font color=limegreen>".$row['name']."</font>";
		}

		if ($row1['id'] != $user['id'])
		{
			$buddy    = "<hr>";
			$buddy   .= "<a href=buddy.php?a=".$row['id_owner']."&u=".$row['id_owner']."><font color=red>&nbsp;".$lang['Buddy']."&nbsp;</a><br></font>";
			$buddy   .= "<a href=messages.php?mode=write&id=".$row['id_owner']."><font color=red>&nbsp;".$lang['msg']."&nbsp;</a><br></font>";
			$command .= "<hr>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=6>&nbsp;".$lang['spionage']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=3>&nbsp;".$lang['transport']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=1>&nbsp;".$lang['angriff']."&nbsp;</a>";
		}
		elseif ($row['id'] != $user['current_planet'])
		{
			$buddy    = "";
			$command .= "<hr>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=3>&nbsp;".$lang['transport']."&nbsp;</a><br>";
			$command .= "<a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=4>&nbsp;".$lang['stationiren']."&nbsp;</a>";
		}
		else
		{
			$buddy    = "";
		}
		$angriffszone 	= "<br>".$lang['angriffszone']." <font color=#CCFF33>".$row1['angriffszone']."&nbsp;</font><br>";
	}



	$query2 = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '$galaxy' AND `system` = '$system' AND planet = '$g' Limit 1;", 'galaxy');
	while($row2 = mysql_fetch_assoc($query2))
	{
		$TFMET = "";
		$TFCRY = "";
		$TFMET = $row2['metal'];
		$TFCRY = $row2['crystal'];
		if ($row2['id_luna'] != '0' and $row1['id'] != $user['id'])
		{
			$mond     = "<font color=yellow>&nbsp;".$lang['GALAXY_MOON']."&nbsp;</font><br>";
			$command .= "<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=3&target_mission=9><font color=red>&nbsp;".$lang['GALAXY_DESTROY_MOON']."&nbsp;</font></a>";
			$mond3    = "&nbsp;<img src=images/galaxy/mond1.gif>";
		}
		else
		{
			$mond  = "<font color=yellow>&nbsp;".$lang['GALAXY_NO_MOON']."&nbsp;</font><br>";
			$mond3 = "";
		}
		if ($row2['metal'] == '0' && $row2['crystal'] == '0')
		{
			$tf = "";
			$trbild = "";
		}
		else
		{
			$trbild = "tr";
			$tf = "<hr>&nbsp;".$lang['GALAXY_DEBRIS']."&nbsp;<br>&nbsp;".$TFMET." ".$lang['GALAXY_METAL']."&nbsp;<br>&nbsp;".$TFCRY." ".$lang['GALAXY_CRYSTAL']."&nbsp;<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=2&target_mission=8><br>".$lang['GALAXY_RECYCLE']."</a><br><br>";
		}
	}



	$query2 = doquery("SELECT total_points  FROM {{table}} WHERE `id_owner` = '".$row['id_owner']."';", 'statpoints');
	while($row2 = mysql_fetch_assoc($query2))
	{
		$Punkte = $row2['total_points']."&nbsp;";
	}



	echo "<a href=\"playercard.php?playerid=" . $userid . "&ownid=" . $user['id'] . "\">$username</a> <br> $allytag ";
	echo "<th width=30><a style=\"cursor: crosshair;\" onmouseover='return overlib(\"<table width=150><tr><td class=c><b>&nbsp;[".$row['galaxy'].":".$row['system'].":".$row['planet']."]&nbsp;</b></td></tr><tr><th>".$lang['Player'].$username."<br>".$lang['Planet']." ".$planetname."<br>".$allytag2.$lang['Points']." ".$Punkte."</th></tr></table>\");' onclick='return overlib(\" <table width=250><tr><td class=c colspan=2>Planet ".$row['name']." [".$row['galaxy'].":".$row['system'].":".$row['planet']."]</td></tr><tr><th width=80><img src=images/galaxy/sp".$g.$trbild.".gif height=75 width=75 /></th><th align=left>&nbsp;".$lang['Pos']." ".$row['planet']."&nbsp;<br>&nbsp;".$lang['Planet']." ".$planetname."&nbsp;<br>&nbsp;".$lang['Player']." <a href=playercard.php?playerid=$userid&ownid=" . $user['id'] . ">$username</a>".$ally.$angriffszone.$mond.$buddy.$command.$tf."</th></tr>  </table>\",STICKY, MOUSEOFF, DELAY, 100, CENTER, OFFSETX, -75, OFFSETY, -25 );' onmouseout='return nd();'>";
}



if ($planetrow['colonizer'] >= 1) {
	$siedeln = "<br><a href=fleet.php?galaxy=$galaxy&system=$system&planet=$count&planettype=1&target_mission=7>&nbsp;".$lang['siedeln']."&nbsp;</a><br>";
} else {
	$siedeln = "";
}

if ($leer == '')
{
	echo "<td width=30><a style=\"cursor: crosshair;\" onclick='return overlib(\"<table width=250><tr><td class=c>&nbsp;[".$galaxy.":".$system.":".$count."]&nbsp;</td></tr><tr><th>&nbsp;<br>&nbsp;".$lang['Free_Planet']."<br>".$siedeln."&nbsp;</th></tr></table>\",STICKY, MOUSEOFF, CENTER, OFFSETX, -75, OFFSETY, -25 );' onmouseover='return overlib(\"<table width=100><tr><td class=c>&nbsp;[".$galaxy.":".$system.":".$count."]&nbsp;</td></tr><tr><th>&nbsp;".$lang['Free']."&nbsp;</th></tr></table>\");' onmouseout='return nd();'>";
	echo "<img src=images/galaxy/sp".$g.".gif height=\"30\" width=\"30\"><br>$count<br></a></td></div>";
}
else
{
	echo "<img src=images/galaxy/sp".$g.$trbild.".gif  height=\"30\" width=\"30\">".$mond3." <br> (".$planetname.") <br> $count <table  width=\"100\" height=\"50\"></table></div>";
}



echo "<div id=\"99\" style=\" position: absolute; left: 20px; right: 824px; top: 100px; height: 10px;\"><a href=fleet.php?galaxy=$galaxy&system=$system&planet=16&planettype=1&target_mission=15><img src=images/galaxy/wurmloch.png height=\"30\" width=\"30\"><br>".$lang['GALAXY_WORMHOLE']."</a></th></div>";



$e++; $e++;
$f++; $f++;
$g++;
$count++;
}

$page .= ob_get_clean();

display ($page, $lang[''], false, '', false);
}
?>