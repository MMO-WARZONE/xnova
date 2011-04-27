<?php
	//######################################################//
	//# Name:      visitas.php 					  		   #//
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

	$parse = $lang; 
	//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
	
	 $fecha = date("Y-m-d");  //Cojemos la fecha en formato 2009/09/28
	 $año = date("Y");
	 $mes = date("m");

	$Consulta = doquery("SELECT * FROM {{table}} where fecha='{$fecha}' ","visitas",true); //Guarda en la variable las visitas de hoy
	$parse['vunicash']  = $Consulta[2]; //Guarda para pasarlo al tpl, las de hoy
	$parse['vpaginash']  = $Consulta[3]; //Guarda para pasarlo al tpl, las de hoy
	
	$Consulta = doquery("SELECT id,fecha,SUM(vunicas) as totalunicas,SUM(vpaginas) as totalpaginas FROM {{table}} where fecha>'{$año}/{$mes}/01' group by id","visitas",true); //Guarda en la variable las visitas del mes
	$parse['vunicasm']  = $Consulta['totalunicas']; //Guarda para pasarlo al tpl, las del mes
	$parse['vpaginasm']  = $Consulta['totalpaginas']; //Guarda para pasarlo al tpl, las del mes
	
	$Consulta = doquery("SELECT * FROM {{table}} order by fecha desc limit 30","visitas"); //Sacamos las visitas de 30 dias descendientente
	while ($datos = mysql_fetch_array($Consulta)) { //1 por 1 hasta llegar a 30
		$parse['todas'] .= "<tr>";
		$parse['todas'] .= "<td  align=\"center\"class=\"c\" style=\"color:#FFFFFF\"><strong>{$datos['fecha']}</strong></td>";
		$parse['todas'] .= "<td align=\"right\"class=\"b\" style=\"color:#FFFFFF\"><font color=\"green\">{$datos['vunicas']}</font> / <font color=\"red\">{$datos['vpaginas']}</font></td>";
		$parse['todas'] .= "</tr>";
	} //Fin while
	
	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/visitas_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Visitas', '', false);
	
?>