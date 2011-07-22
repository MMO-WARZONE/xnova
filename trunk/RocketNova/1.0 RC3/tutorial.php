<?php
//----Tutorial PHP Script V1.0a Release---------------------------------------------------------------------tutorial.php----
//----Copyright by DecaySoft Scripte. Alle Rechte vorbehalten.--------------------------------------------------------------
//----Bereitgestellt für Xnova ab V0.8a und WarsAttack ab V0.1b-------------------------------------------------------------
//----Script Anfang---------------------------------------------------------------------------------------------------------

define('INSIDE'  , true);
define('INSTALL' , false);

//----Zugriff auf diese Seite auch wenn man nicht eingeloggt ist------------------------------------------------------------
$InLogin = true;

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

		includeLang('tutorial');

		$parse = $lang;
		$parse['dpath'] = $dpath;
		
$actions = $_GET['action'];
//---Teil 1---Start---------------------------------------------------------------------------------------------------------
if($actions == 1){
		$page =

   	$page .= parsetemplate(gettemplate('tutorial_teil1'), $parse);
		;
		
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 1---Ende----------------------------------------------------------------------------------------------------------

//---Teil 2---Start---------------------------------------------------------------------------------------------------------
if($actions == 2){
		$page =
   	$page = parsetemplate(gettemplate('tutorial_teil2'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 2---Ende----------------------------------------------------------------------------------------------------------

//---Teil 3---Start---------------------------------------------------------------------------------------------------------
if($actions == 3){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil3'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 3---Ende----------------------------------------------------------------------------------------------------------

//---Teil 4---Start---------------------------------------------------------------------------------------------------------
if($actions == 4){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil4'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 4---Ende----------------------------------------------------------------------------------------------------------

//---Teil 5---Start---------------------------------------------------------------------------------------------------------
if($actions == 5){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil5'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 5---Ende----------------------------------------------------------------------------------------------------------

//---Teil 6---Start---------------------------------------------------------------------------------------------------------
if($actions == 6){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil6'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 6---Ende----------------------------------------------------------------------------------------------------------

//---Teil 7---Start---------------------------------------------------------------------------------------------------------
if($actions == 7){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil7'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 7---Ende----------------------------------------------------------------------------------------------------------

//---Teil 8---Start---------------------------------------------------------------------------------------------------------
if($actions == 8){
		$page =
   	$page .= parsetemplate(gettemplate('tutorial_teil8'), $parse);
		;
		display ($page, $lang['tutorial'], false, '', false);}
//---Teil 8---Ende----------------------------------------------------------------------------------------------------------
		
//---Tutorial_body laden. Erste Seite---------------------------------------------------------------------------------------
   	$page = parsetemplate(gettemplate('tutorial_body'), $parse);
		display ($page, $lang['tutorial'], false, '', false);
	
//----Script Ende-----------------------------------------------------------------------------------------------------------
?>
	