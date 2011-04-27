<?php
	//######################################################//
	//# Name:      config-stats.php 					   #//
    //# Authors:   SainT  								   #//
	//# Copyright: OgameRC.com 							   #//
	//# Website:   http://www.xnova.saint-rc.es            #//
	//######################################################//
	//					Datos Array							//
	// $CStats[0] => Alianzas  								//
	// $CStats[1] => Flota									//
	// $CStats[2] => Investigaciones						//
	// $CStats[3] => Edificios 								//
	// $CStats[4] => Defensas  								//
	//														//
	//######################################################//
	
	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 
	define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

	$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	includeLang('admin'); //Incluimos el archivo del lenguaje

	$parse = $lang; 
	//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

	$Consulta = doquery("SELECT * FROM {{table}} WHERE config_name = 'configstats'", 'config', true); //Sacamos el config.

	$CStats = explode("|" ,$Consulta[1]); //metemos en un array los datos separados por |
	// 1 => Activado || 0 => Desactivado
	if ($CStats[0] == 1) { $parse['Alianzas'] = "Checked"; } else { $parse['Alianzas'] = ""; } //Alianzas
	if ($CStats[1] == 1) { $parse['Flotas'] = "Checked"; } else { $parse['Flotas'] = ""; } //Flotas
	if ($CStats[2] == 1) { $parse['Investigaciones'] = "Checked"; } else { $parse['Investigaciones'] = ""; } //Investigaciones
	if ($CStats[3] == 1) { $parse['Edificios'] = "Checked"; } else { $parse['Edificios'] = ""; } //Edificios
	if ($CStats[4] == 1) { $parse['Defensas'] = "Checked"; } else { $parse['Defensas'] = ""; } //Defensas
		if($_POST) {

		//Si enviaron el formulario
		$NCStats = "";
		if(isset($_POST['Alianzas'])) { $NCStats .= "1|"; } else { $NCStats .= "0|"; } //Alianzas
		if(isset($_POST['Flotas'])) { $NCStats .= "1|"; } else { $NCStats .= "0|"; } //Flotas
		if(isset($_POST['Investigaciones'])) { $NCStats .= "1|"; } else { $NCStats .= "0|"; } //Investigaciones
		if(isset($_POST['Edificios'])) { $NCStats .= "1|"; } else { $NCStats .= "0|"; } //Edificios
		if(isset($_POST['Defensas'])) { $NCStats .= "1"; } else { $NCStats .= "0"; } //Defensas
		
		doquery("UPDATE {{table}} SET config_value='".$NCStats."' where config_name='configstats'", "config"); //Actualizamos 
		header("Location: ./config-stats.php?op=1"); //reidirigimos a config-stats.php
		}
		if($_GET['op'] == 1) {
							//mensaje a mostrar
		$parse['mensaje'] .= "<tr>";
		$parse['mensaje'] .= "<td class=\"mensaje\" colspan=\"2\">Datos Guardaos Correctamente</td>";
		$parse['mensaje'] .= "</tr>";
		}
	
	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/config_stats_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administracion de Stats', '', false);
	
	
?>