<?php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

includeLang('stat');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

$parse = $lang;
$who = (isset($_POST["who"]))?$_POST["who"]:$_GET["who"];
$type = (isset($_POST["type"]))?$_POST["type"]:$_GET["type"];
$start = (isset($_POST["start"]))?$_POST["start"]:$_GET["start"];
//
//  Formulario donde se muestran los diferentes tipos de categoria
//  y los rangos
//
$parse['who'] = '<option value="player"'.
	(($who == "player") ? " SELECTED" : "").'>Jugadores</option>
  <option value="ally"'.
	(($who == "ally") ? " SELECTED" : "").'>Alianzas</option>';
  
  
$parse['type'] = '
  <option value="pts"'.
	(($type == "pts") ? " SELECTED" : "").'>Puntos</option>
		<option value="flt"'.
	(($type == "flt") ? " SELECTED" : "").'>Flotas</option>
  <option value="res"'.
	(($type == "res") ? " SELECTED" : "").'>Investigacion</option>';
  
$parse['start'] = '
	   <option value="1"'.
	(($start == "1") ? " SELECTED" : "").'>1-100</option>
	   <option value="101"'.
	(($start == "101") ? " SELECTED" : "").'>101-200</option>
	   <option value="201"'.
	(($start == "201") ? " SELECTED" : "").'>201-300</option>
	   <option value="301"'.
	(($start == "301") ? " SELECTED" : "").'>301-400</option>
	   <option value="401"'.
	(($start == "401") ? " SELECTED" : "").'>401-500</option>
	   <option value="501"'.
	(($start == "501") ? " SELECTED" : "").'>501-600</option>
	   <option value="601"'.
	(($start == "601") ? " SELECTED" : "").'>601-700</option>
	   <option value="701"'.
	(($start == "701") ? " SELECTED" : "").'>701-800</option>
	   <option value="801"'.
	(($start == "801") ? " SELECTED" : "").'>801-900</option>
	   <option value="901"'.
	(($start == "901") ? " SELECTED" : "").'>901-1000</option>
	   <option value="1001"'.
	(($start == "1001") ? " SELECTED" : "").'>1001-1100</option>
	   <option value="1101"'.
	(($start == "1101") ? " SELECTED" : "").'>1101-1200</option>
	   <option value="1201"'.
	(($start == "1201") ? " SELECTED" : "").'>1201-1300</option>
	   <option value="1301"'.
	(($start == "1301") ? " SELECTED" : "").'>1301-1400</option>
	   <option value="1401"'.
	(($start == "1401") ? " SELECTED" : "").'>1401-1500</option>';

//
//  Parece que fuera ayer, que solo el juego era una fachada.
//  Bueno, Here we go!
//


if($who == "ally"){
	
	$parse['body_table'] = parsetemplate(gettemplate('stat_alliancetable_header'), $parse);
	//peque� fix para prevenir desastres
	$start = (is_numeric($start)&&$start>1)?round($start):1;
	//Realizamos la quiery en la table de jugadores
	$query = doquery('SELECT * FROM {{table}} LIMIT '.($start-1).',100','alliance');
	
	$parse['body_values'] = '';//en caso de que no hubieran datos...
	
	while ($row = mysql_fetch_assoc($query)){
		$parse['ally_rank'] = $start;
		
		$parse['ally_rankplus'] = '<font color="lime">?</font>';
		$parse['ally_name'] = '<a href="alliance.php?mode=ainfo&tag='.$row['ally_tag'].'">'.$row['ally_name'].'</a>';
		$parse['ally_mes'] = '';//'<a href="alliance.php?mode=apply&tag='.$row['ally_tag'].'">
	  //<img src="http://ogame321.de/evolution/img/m.gif" border="0" alt="Escribir mensaje" /></a>';
		$parse['ally_members'] = $row['ally_members'];
		$parse['ally_points'] = $row['ally_points'];
		$parse['ally_members_points'] = $row['ally_members_points'];
		$parse['body_values'] .= parsetemplate(gettemplate('stat_alliancetable'), $parse);
		$start++;
	}
	
	
}else{
	
	$parse['body_table'] = parsetemplate(gettemplate('stat_playertable_header'), $parse);
	
	//peque� fix para prevenir desastres
	$start = (is_numeric($start)&&$start>1)?round($start):1;
	//Realizamos la quiery en la table de jugadores
	$query = doquery('SELECT * FROM {{table}} LIMIT '.($start-1).',100','users');
	
	$parse['body_values'] = '';//en caso de que no hubieran datos...
	
	while ($row = mysql_fetch_assoc($query)){
		$parse['player_rank'] = $start;
		$parse['player_rankplus'] = '<font color="87CEEB">?</font>';
		$parse['player_name'] = $row['username'];
		$parse['player_mes'] = '<a href="messages.php?mode=write&id='.$row['id'].'">
		<img src="http://ogame321.de/evolution/img/m.gif" border="0" alt="Escribir mensaje" /></a>';
		$parse['player_alliance'] = $row['ally_name'];
		$parse['player_points'] = round($row['points']/1000);
		$parse['body_values'] .= parsetemplate(gettemplate('stat_playertable'), $parse);
		$start++;
	}
	
}

$page = parsetemplate(gettemplate('stat_body'), $parse);

display($page,$lang['Resources']);
//
//  bueno, no se pudo hacer mucho que digamos ...
//
// Created by Perberos. All rights reversed (C) 2006
?>
