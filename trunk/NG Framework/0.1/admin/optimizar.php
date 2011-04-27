<?php
	//######################################################//
	//# Name:      optimizar.php 					   #//
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

	$parse = $lang;  //cargamos el idioma en el parse 
	
	//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
	
	if(!$_POST['Optimizar']) { //Si no se le dio a optimizar
	$Tablas = doquery("SHOW TABLES","todas"); //mostramos las tablas
	while ($row = mysql_fetch_assoc($Tablas))  { //While de las tablas 
	foreach ($row as $opcion => $tabla) {	//Buscamos en el array
	$parse['tabla'] .= "<tr>";
	$parse['tabla'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#FFFFFF\"><strong>".$tabla."</strong></td>";
	$parse['tabla'] .= "</tr>";
	} //Fin foreach
} //Fin while
} else {
	$Tablas = doquery("SHOW TABLES",'todas');
	while ($row = mysql_fetch_assoc($Tablas))  {
	foreach ($row as $opcion => $tabla) {	
		doquery("OPTIMIZE TABLE ".$tabla."", "Optimizar");
		if (mysql_errno()){
	$parse['tabla'] .= "<tr>";
	$parse['tabla'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#FFFFFF\"><strong>".$tabla."</strong></td>";
	$parse['tabla'] .= "<td class=\"b\" colspan=\"2\" style=\"color:red\"><strong>NO OPTIMIZADA</strong></td>";
	$parse['tabla'] .= "</tr>";
		}else{
			$parse['tabla'] .= "<tr>";
	$parse['tabla'] .= "<td class=\"c\" style=\"color:#FFFFFF\"><strong>".$tabla."</strong></td>";
	$parse['tabla'] .= "<td class=\"b\" style=\"color:green\"><strong>OPTIMIZADA</strong></td>";
	$parse['tabla'] .= "</tr>";
		}
	}
}
}

	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/optimizar'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Optimizar la base de datos', '', false);

?>
	