<?php
	//######################################################//
	//# Name:      config-loteria.php 					   #//
	//# Date:      31/03/2098 							   #//
	//# Authors:   SainT  								   #//
	//# Copyright: OgameRC.com 							   #//
	//# Website:   http://www.xnova.saint-rc.es            #//
	//######################################################//
	//					Datos Array							//
	// $Cloteria[0] => Tiempo    							//
	// $Cloteria[1] => Tickets								//
	// $Cloteria[2] => Premio metal 						//
	// $Cloteria[3] => premio cristal						//
	// $Cloteria[4] => premio deuterio						//
	// $Cloteria[5] => tickets por persona					//
	//														//
	//######################################################//
	
	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 
	define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

	$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	includeLang('admin'); //Incluimos el archivo del lenguaje

	$parse[0] = $lang; 
	//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

	$Consulta = doquery("SELECT * FROM {{table}} WHERE config_name = 'configloteria'", 'config', true); //Sacamos el config.

	$Cloteria = explode("|" ,$Consulta[1]); //metemos en un array los datos separados por |
	$parse['Tiempo'] =  $Cloteria[0]; //tiempo
	$parse['tickets'] =  $Cloteria[1]; //tickets
	$parse['pmetal'] =  $Cloteria[2]; //premio en metal
	$parse['pcristal'] =  $Cloteria[3]; //premio en cristal
	$parse['pdeuterio'] =  $Cloteria[4]; //premio en deuterio
	$parse['ticketsxper'] =  $Cloteria[5]; //tickets por persona
	
	
		if($_POST) { //Si enviaron el formulario
		if(!is_numeric($_POST['Tiempo']) or !is_numeric($_POST['tickets']) or !is_numeric($_POST['pmetal']) or !is_numeric($_POST['pcristal']) or !is_numeric($_POST['pdeuterio']) or !is_numeric($_POST['ticketsxper'])) { 
		message("Error, solo Numeros","Error, solo Numeros");
		}
		$NCloteria = "";
		$NCloteria .= "".$_POST['Tiempo']."|".$_POST['tickets']."|".$_POST['pmetal']."|".$_POST['pcristal']."|".$_POST['pdeuterio']."|".$_POST['ticketsxper']."|"; 
		
		doquery("UPDATE {{table}} SET config_value='".$NCloteria."' where config_name='configloteria'", "config"); //Actualizamos 
		header("Location: ./config-loteria.php?op=1"); //reidirigimos a config-loteria.php
		}
			if($_GET['op'] == 1) {
							//mensaje a mostrar
		$parse['mensaje'] .= "<tr>";
		$parse['mensaje'] .= "<td class=\"mensaje\" colspan=\"2\">Datos Guardaos Correctamente</td>";
		$parse['mensaje'] .= "</tr>";
		}
	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/config_loteria_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administracion de loteria', '', false);
	
	
?>