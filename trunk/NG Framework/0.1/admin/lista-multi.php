<?php
	//######################################################//
	//# Name:      lista-multi.php 					   	   #//
    //# Authors:   SainT  								   #//
	//# Copyright: OgameRC.com 							   #//
	//# Website:   http://www.xnova.saint-rc.es            #//
	//######################################################//
	
	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 
	define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

	$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	includeLang('admin'); //Incluimos el archivo del lenguaje
	
	$Tban = "999"; //En dias
	$Tban = time() + ((($Tban*24)*60)*60); //Ahora paso a segundos xD
	
	$parse = $lang; 
	//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
	if(isset($_GET['banear'])) { //Si le dieron a banear 
	$query = doquery("SELECT user_lastip,username FROM {{table}} where user_lastip='{$_GET['banear']}'", 'users'); 
	$Baneados = mysql_fetch_row(doquery("SELECT user_lastip,username FROM {{table}} where user_lastip='{$_GET['banear']}'", 'users')); //total baneados
	$c = 0;
	while ($ban = mysql_fetch_assoc($query)) {
	$c++;
	doquery("INSERT INTO {{table}} SET who='{$ban['username']}', who2='{$ban['username']}', theme='Multicuenta {$c}/{$Baneados[0]}', longer='{$Tban}', author='{$user['username']}', email='Protecion@Multicuentas.com'","banned");

	}
		doquery("UPDATE {{table}} SET user_lastip='000.000.000' where user_lastip='{$_GET['banear']}'","users");
		$parse['mensaje'] .= "<tr>";
		$parse['mensaje'] .= "<td class=\"mensaje\" colspan=\"2\">Usuarios Baneados Correctamente</td>";
		$parse['mensaje'] .= "</tr>";
	}
	
	$query = doquery("SELECT user_lastip, count(user_lastip) as numips FROM {{table}} group by user_lastip order by user_lastip asc", 'users'); //Sacamos los usuarios ordenados por IP
	
	while ($row = mysql_fetch_assoc($query)) {	//MIRAMOS 1 POR 1
	if($row['numips'] > 1 AND $row['user_lastip'] != NULL AND $row['user_lastip'] != 0000) { //Si esta ip tiene mas de 1 ultimo login
	$query2 = doquery("SELECT id,username,user_lastip FROM {{table}} where user_lastip='{$row['user_lastip']}' order by username asc", 'users'); //Sacamos los usuarios que usan la ip
	$parse['multi'] .= "<tr>";
	$parse['multi'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#FFFFFF\"><strong>{$row['user_lastip']} </strong> <a href=\"lista-multi.php?banear={$row['user_lastip']}\"> [Banearlos]</A></td>";
	$parse['multi'] .= "</tr>";
	
	while ($row2 = mysql_fetch_assoc($query2)) {
	$parse['multi'] .= "<tr>";
	$parse['multi'] .= "<td class=\"c\" align=\"center\"><a href=\"http://s1.ogamerc.com/messages.php?mode=write&id={$row2['id']}\"><img src=\"../skins/xnova/img/m.gif\"></a></td>";
	$parse['multi'] .= "<td class=\"b\" style=\"color:#FFFFFF\"><strong>{$row2['username']}</strong></td>";
	$parse['multi'] .= "</tr>";	
	}

	}
	}
	
	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/lista_multicuentas'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administracion de MultiCuentas', '', false);
	
	
?>