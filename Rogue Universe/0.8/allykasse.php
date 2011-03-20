<?php

/**
 * allianzkasse.php
 *
 * @version 1.2
 * @copyright 2008 By marceld12 & Mwieners
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id='{$user['current_planet']}'",'planets',true);
$ally = doquery("SELECT * FROM {{table}} WHERE ally_name='{$user['ally_name']}'",'alliance',true);

$parse = $lang;
$select = doquery("SELECT * FROM {{table}} WHERE ally_id ={$ally['id']}",'users');
$usernamen = '';
while($data = mysql_fetch_assoc($select))
{
$haupt = doquery("SELECT * FROM {{table}} WHERE id= '".$data['id_planet']."'",'planets');
while($hauptplanet = mysql_fetch_assoc($haupt))
{	
	
	 $parse['username'] .= '<option value=' . $hauptplanet['id'] . '>'.$data['username'].'('.$hauptplanet['name'].')</option>';
	 }
	 }
$parse['vonmetall'] = $ally['allykasse_metall'];
$parse['vonkristall'] = $ally['allykasse_kristall'];
$parse['vondeuterium'] = $ally['allykasse_deuterium'];
if ($_GET['auszahlen'] == 1 & $ally['ally_owner'] == $user['id']) {


if ($_POST['submit']) {
$planetrow2 = doquery("SELECT * FROM {{table}} WHERE id={$_POST['planetid']}",'planets',true);
$ally = doquery("SELECT * FROM {{table}} WHERE ally_name='{$user['ally_name']}'","alliance",true);

if (!$_POST['metall'] & !$_POST['kristall'] & !$_POST['deuterium']) {
message('You couldnt deposit to the bank!','Error!');
}

if ($_POST['metall'] > $ally['allykasse_metall']) {
message('The Alliance Bank doesnt have enough resources','Error');
}
if (!$_POST['planetid']) {
message('You didnt set a planetID!','Error');
}
if ($_POST['kristall'] > $ally['allykasse_kristall']) {
message('The Alliance Bank doesnt have enough resources','Error');
}
if ($_POST['deuterium'] > $ally['allykasse_deuterium']) {
message('The Alliance Bank doesnt have enough resources','Error');
}
$metallweg = $planetrow2['metal'] + $_POST['metall'];
$kristallweg = $planetrow2['crystal'] + $_POST['kristall'];
$deutweg = $planetrow2['deuterium'] + $_POST['deuterium'];

$metalldazu = $ally['allykasse_metall'] - $_POST['metall'];
$kristalldazu = $ally['allykasse_kristall'] - $_POST['kristall'];
$deutdazu = $ally['allykasse_deuterium'] - $_POST['deuterium'];

$updateress = doquery("UPDATE {{table}} SET `metal` = '$metallweg', `crystal` = '$kristallweg', `deuterium` = '$deutweg' WHERE `id` = '{$user['current_planet']}'", 'planets');
$updateress = doquery("UPDATE {{table}} SET `allykasse_metall` = '$metalldazu', `allykasse_kristall` = '$kristalldazu', `allykasse_deuterium` = '$deutdazu' WHERE `id` = '" . $ally['id'] . "'", 'alliance');
message('Your deposit has been sent. <blink><a href="alliance.php">Go Back</a></blink>','Success');
}







$page = parsetemplate(gettemplate('allykasse_auszahlen'), $parse ,$lang);
display($page);
exit();
}


if ($_POST['submit']) {
if (!$_POST['metall'] & !$_POST['kristall'] & !$_POST['deuterium']) {
message('You couldnt deposit any resources!','Error!');
}

if ($_POST['metall'] > $planetrow['metal']) {
message('You dont have enough resources','Error');
}
if ($_POST['kristall'] > $planetrow['crystal']) {
message('You dont have enough resources','Error');
}
if ($_POST['deuterium'] > $planetrow['deuterium']) {
message('You dont have enough resources','Error');
}
$metallweg = $planetrow['metal'] - $_POST['metall'];
$kristallweg = $planetrow['crystal'] - $_POST['kristall'];
$deutweg = $planetrow['deuterium'] - $_POST['deuterium'];

$metalldazu = $ally['allykasse_metall'] + $_POST['metall'];
$kristalldazu = $ally['allykasse_kristall'] + $_POST['kristall'];
$deutdazu = $ally['allykasse_deuterium'] + $_POST['deuterium'];

$updateress = doquery("UPDATE {{table}} SET `metal` = '$metallweg', `crystal` = '$kristallweg', `deuterium` = '$deutweg' WHERE `id` = '{$user['current_planet']}'", 'planets');
$updateress = doquery("UPDATE {{table}} SET `allykasse_metall` = '$metalldazu', `allykasse_kristall` = '$kristalldazu', `allykasse_deuterium` = '$deutdazu' WHERE `id` = '" . $ally['id'] . "'", 'alliance');
message('Your deposit have been sent. <blink><a href="alliance.php">Go Back</a></blink>','Success');
}




$parse = $lang;
$page = parsetemplate(gettemplate('allykasse_body'), $parse);

 
	display($page);
	
	?>