<?php

function MissionCaseAttack ( $FleetRow) {
global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;

includelang('tech');
includelang('system');

if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time()) {

if (!isset($CombatCaps[202]['sd'])) {
message('<font color=red>'. $lang['sys_no_vars'] .'</font><br />(Error: <font color=red>(!isset($pricelist[202][\'sd\']))</font>. Please report this to an admin.)', $lang['sys_error'], 'fleet.php', 15);
}

include($xnova_root_path."includes/functions/MissionCaseEvoAttack.php");

$strunitsgesamt      = $result['lost']['att'] + $result['lost']['def'];
$user1lostunits      = $result['lost']['att'];
$user1shotunits      = $result['lost']['def'];
$user2lostunits      = $result['lost']['def'];
$user2shotunits      = $result['lost']['att'];
$strtruemmerfeld     = $result['debree']['att'][0]+$result['debree']['def'][0]+$result['debree']['att'][1]+$result['debree']['def'][1]+$result['debree']['att'][2]+$result['debree']['def'][2];
$strtruemmermetal    = $result['debree']['att'][0]+$result['debree']['def'][0];
$strtruemmercrystal  = $result['debree']['att'][1]+$result['debree']['def'][1];
$strtruemmerappolonium  = $result['debree']['att'][2]+$result['debree']['def'][2];
$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1]+ $result['debree']['att'][2] + $result['debree']['def'][2];
$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal'], $result['debree']['def'][2] + $result['debree']['att'][2], $lang['Appolonium']);
$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
$MoonChance       = $FleetDebris / 100000;
if ($FleetDebris > 2000000) {
$MoonChance = 20;
}
if ($FleetDebris < 100000) {
$UserChance = 0;
$ChanceMoon = "";
} elseif ($FleetDebris >= 100000) {
$UserChance = mt_rand(1, 100);
$ChanceMoon       = sprintf ($lang['sys_moonproba'], $MoonChance);
}

    if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetGalaxy['id_luna'] == 0)) {
       $TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
       $GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
       $GottenMoon .= "<br />";
	 //Abfrage der Größe des Trümmerfeldes?  
	   $QrySelectGalaxy  = "SELECT * FROM {{table}} ";
	   $QrySelectGalaxy .= "WHERE ";
	   $QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
	   $QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
	   $QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
	   $QrySelectGalaxy .= "LIMIT 1;";
	   $TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);
	 // Trümmerfeld wird gelöscht da der Mond aus den Trümmern entstanden ist!.  
       $QryUpdateGalaxy  = "UPDATE {{table}} SET ";
       $QryUpdateGalaxy .= "`metal` = `metal` - '".$TargetGalaxy["metal"]."', ";
	   $QryUpdateGalaxy .= "`crystal` = `crystal` - '".$TargetGalaxy["crystal"]."',";
	   $QryUpdateGalaxy .= "`appolonium` = `appolonium` - '".$TargetGalaxy["appolonium"]."' ";
	   $QryUpdateGalaxy .= "WHERE ";
	   $QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
	   $QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
	   $QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
	   $QryUpdateGalaxy .= "LIMIT 1;";
	   doquery( $QryUpdateGalaxy, 'galaxy');
} elseif ($UserChance = 0 or $UserChance > $MoonChance) {
$GottenMoon = "";
}
$OwnedUser = doquery('SELECT * FROM {{table}} WHERE id='.$FleetRow['fleet_owner'],'users', true);

$formatted_cr = formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
$raport = $formatted_cr['html'];

$rid   = md5($raport);
$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
foreach ($attackFleets as $fleetID => $attacker) {
$users2[$attacker['user']['id']] = $attacker['user']['id'];
}
foreach ($defense as $fleetID => $defender) {
$users2[$defender['user']['id']] = $defender['user']['id'];
}
$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
$QryInsertRapport .= '`rid` = "'. $rid .'", ';
$QryInsertRapport .= '`raport` = "'. mysql_real_escape_string( $raport ) .'"';
doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());
$angreifer = $formatted_cr['angreifer'];
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$rid   = md5($raport);
$QryInserttopkb  = "INSERT INTO {{table}} SET ";
$QryInserttopkb .= "`time` = UNIX_TIMESTAMP(), ";
$QryInserttopkb .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";
$QryInserttopkb .= "`angreifer` = '". $angreifer ."', ";
$QryInserttopkb .= "`id_owner2` = '". $targetUser['id'] ."', ";
$QryInserttopkb .= "`defender` = '". $targetUser['username'] ."', ";
$QryInserttopkb .= "`gesamtunits` = '". $strunitsgesamt ."', ";
$QryInserttopkb .= "`gesamttruemmer` = '". $strtruemmerfeld ."', ";
$QryInserttopkb .= "`rid` = '". $rid ."', ";
$QryInserttopkb .= "`a_zestrzelona` = '". $a_zestrzelona ."', ";
$QryInserttopkb .= "`raport` = '". mysql_real_escape_string( $raport ) ."',";
$QryInserttopkb .= "`fleetresult` = '". $result['won'] ."';";
doquery("LOCK TABLE {{table}} WRITE", 'topkb');
doquery( $QryInserttopkb , 'topkb');
doquery("UNLOCK TABLES", '');
$user1stat = $FleetRow['fleet_owner'];
$user2stat = $TargetUserID;

$raport  = '<a href # OnClick=\'f( "rw.php?raport='. $rid .'", "");\' >';
$raport .= '<center>';
if       ($result['won'] == "a") {
$raport .= '<font color=\'green\'>';
} elseif ($result['won'] == "w") {
$raport .= '<font color=\'orange\'>';
} elseif ($result['won'] == "r") {
$raport .= '<font color=\'red\'>';
}
$raport .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br /><br />';
$raport .= '<font color=\'red\'>'. $lang['sys_perte_attaquant'] .': '. $result['lost']['att'] .'</font>';
$raport .= '<font color=\'green\'>   '. $lang['sys_perte_defenseur'] .': '. $result['lost']['def'] .'</font><br />' ;
$raport .= $lang['sys_gain'] .' '. $lang['Metal'] .':<font color=\'#adaead\'>'. $steal['metal'] .'</font>   '. $lang['Crystal'] .':<font color=\'#ef51ef\'>'. $steal['crystal'] .'</font>   '. $lang['Deuterium'] .':<font color=\'#f77542\'>'. $steal['deuterium'] .'</font>   '. $lang['Appolonium'] .':<font color=\'#ffa07a\'>'. $steal['appolonium'] .'</font><br />';
$raport .= $lang['sys_debris'] .' '. $lang['Metal'] .': <font color=\'#adaead\'>'. ($result['debree']['att'][0]+$result['debree']['def'][0]) .'</font>   '. $lang['Crystal'] .': <font color=\'#ef51ef\'>'. ($result['debree']['att'][1]+$result['debree']['def'][1]) .'</font>   '. $lang['Appolonium'] .': <font color=\'#ef51ef\'>'. ($result['debree']['att'][2]+$result['debree']['def'][2]) .'</font><br /></center>';

SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport );

$raport2  = '<a href # OnClick=\'f( "rw.php?raport='. $rid .'", "");\' >';
$raport2 .= '<center>';
if       ($result['won'] == "a") {
$raport2 .= '<font color=\'red\'>';
} elseif ($result['won'] == "w") {
$raport2 .= '<font color=\'orange\'>';
} elseif ($result['won'] == "r") {
$raport2 .= '<font color=\'green\'>';
}
$raport2 .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br /><br />';

foreach ($users2 as $id) {
if ($id != $FleetRow['fleet_owner'] && $id != 0) {
SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );
}
}

$user1   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user1stat ."';", 'users');
while($user1data = mysql_fetch_assoc($user1))
{
$strtruemmermetaluser1       = $strtruemmermetal + $user1data['kbmetal'];
$strtruemmercrystaluser1     = $strtruemmercrystal + $user1data['kbcrystal'];
$strtruemmerappoloniumuser1  = $strtruemmerappolonium + $user1data['kbappolonium'];
$user1lostunits              = $user1lostunits + $user1data['lostunits'];
$user1shotunits              = $user1shotunits + $user1data['desunits'];
$user1wons                   = $user1data['wons'];
$user1loos                   = $user1data['loos'];
$user1draws                  = $user1data['draws'];
}
$user2   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user2stat ."';", 'users');
while($user2data = mysql_fetch_assoc($user2))
{
$strtruemmermetaluser2       = $strtruemmermetal + $user2data['kbmetal'];
$strtruemmercrystaluser2     = $strtruemmercrystal + $user2data['kbcrystal'];
$strtruemmerappoloniumuser2  = $strtruemmerappolonium + $user2data['kbappolonium'];
$user2lostunits              = $user2lostunits + $user2data['lostunits'];
$user2shotunits              = $user2shotunits + $user2data['desunits'];
$user2wons                   = $user2data['wons'];
$user2loos                   = $user2data['loos'];
$user2draws                  = $user2data['draws'];
}

if   ($result['won'] == "a") {
$user1wons  = $user1wons + 1;
$user2loos  = $user2loos + 1;
} elseif ($result['won'] == "w") {
$user1draws = $user1draws + 1;
$user2draws = $user2draws + 1;
} elseif ($result['won'] == "r") {
$user1loos = $user1loos + 1;
$user2wons = $user2wons + 1;
}
$QryUpdateuserstat  = "UPDATE {{table}} SET ";
$QryUpdateuserstat .= "`wons` = '". $user1wons ."', ";
$QryUpdateuserstat .= "`loos` = '". $user1loos ."', ";
$QryUpdateuserstat .= "`draws` = '". $user1draws  ."', ";
$QryUpdateuserstat .= "`kbmetal` = '". $strtruemmermetaluser1 ."', ";
$QryUpdateuserstat .= "`kbcrystal` = '". $strtruemmercrystaluser1 ."', ";
$QryUpdateuserstat .= "`kbappolonium` = '". $strtruemmerappoloniumuser1 ."', ";
$QryUpdateuserstat .= "`lostunits` = '". $user1lostunits ."', ";
$QryUpdateuserstat .= "`desunits` = '". $user1shotunits ."' ";
$QryUpdateuserstat .= "WHERE ";
$QryUpdateuserstat .= "`id` = '". $FleetRow['fleet_owner'] ."';";
doquery ( $QryUpdateuserstat , 'users');
$QryUpdateuser2stat  = "UPDATE {{table}} SET ";
$QryUpdateuser2stat .= "`wons` = '". $user2wons ."', ";
$QryUpdateuser2stat .= "`loos` = '". $user2loos ."', ";
$QryUpdateuser2stat .= "`draws` = '". $user2draws  ."', ";
$QryUpdateuser2stat .= "`kbmetal` = '". $strtruemmermetaluser2 ."', ";
$QryUpdateuser2stat .= "`kbcrystal` = '". $strtruemmercrystaluser2 ."', ";
$QryUpdateuser2stat .= "`kbappolonium` = '". $strtruemmerappoloniumuser2 ."', ";
$QryUpdateuser2stat .= "`lostunits` = '". $user2lostunits ."', ";
$QryUpdateuser2stat .= "`desunits` = '". $user2shotunits ."' ";
$QryUpdateuser2stat .= "WHERE ";
$QryUpdateuser2stat .= "`id` = '". $targetUser['id'] ."';";
doquery ( $QryUpdateuser2stat , 'users');

$CurrentUser = doquery("SELECT * FROM {{table}} WHERE id = ". $FleetRow['fleet_owner'], 'users', true);
$CurrentUserID    = $CurrentUser['id'];
$AddPoint = $CurrentUser['xpraid'] + 1;

$QryUpdateOfficier = "UPDATE {{table}} SET ";
$QryUpdateOfficier .= "`xpraid` = '" . $AddPoint . "' ";
$QryUpdateOfficier .= "WHERE id = '" . $CurrentUserID . "' ";
$QryUpdateOfficier .= "LIMIT 1 ;";
doquery($QryUpdateOfficier, 'users');

$RaidsTotal = $CurrentUser['raids'] + 1;
if ($result['won'] == "a") {
$RaidsWin = $CurrentUser['raidswin'] + 1;
$QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
$QryUpdateRaidsCompteur .= "`raidswin` ='" . $RaidsWin . "', ";
$QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
$QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
$QryUpdateRaidsCompteur .= "LIMIT 1 ;";
doquery($QryUpdateRaidsCompteur, 'users');
} elseif ($result['won'] == "r" || $result['won'] == "w") {
$RaidsLoose = $CurrentUser['raidsloose'] + 1;
$QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
$QryUpdateRaidsCompteur .= "`raidsloose` ='" . $RaidsLoose . "', ";
$QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
$QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
$QryUpdateRaidsCompteur .= "LIMIT 1 ;";
doquery($QryUpdateRaidsCompteur, 'users');
}
} elseif ($FleetRow['fleet_end_time'] <= time()) {
$Message         = sprintf( $lang['sys_tran_mess_angriffback'],
$TargetName, GetTargetAdressLink($FleetRow, ''),
pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'],
pretty_number($FleetRow['fleet_resource_appolonium']), $lang['Appolonium'] );
SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
RestoreFleetToPlanet($FleetRow);
doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
			//Piratenangriff nach Zufallsprinzip
	        $zufall = 0 ;
     	    $zufall = rand(1,10);
	        if ($zufall == 7){
	        Piratenangriff( $FleetRow );
	        $zufall = 0 ;
	        }
            // Ende Piratenangriff
} }

?>