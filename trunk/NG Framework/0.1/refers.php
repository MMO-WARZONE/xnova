<?php
//######################################################//
//# Name:      refers.php 							   #//
//# Date:      31/03/2098 							   #//
//# Authors:   SainT-RC 							   #//
//# Copyright: OgameRC.com 							   #//
//# Website:   http://www.xnova.saint-rc.es             #//
//######################################################//

define('INSIDE'  , true); //Definimos inside como verdadero
define('INSTALL' , false); //Definimos install como falso. 

$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Referidos'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación


if ($IsUserChecked == false) {//Si el usuario no esta logeado
	includeLang('login'); //incluimos el archivo de lenguaje de login.
	message($lang['Login_Ok'], $lang['log_numbreg']); //Mostramos Error.
}
	$ReferTpl = gettemplate('refers_body'); //cargamos el tpl de referidos
   	$Consulta = doquery("SELECT `username`, `refer` FROM {{table}} WHERE `refer` = '".$user['id']."';", 'users');
	$c = 0; //Contador en 0
	while ($row = mysql_fetch_array($Consulta)) { //vamos 1 por 1
	$c++; //Sumamos 1 al contador 
	$parse['Referidos'] .= "- ".$row['username']."<br />"; //mostramos el usuario referido
	}
	$parse['cantidad'] = $c; //parseamos en numero de referidos
	$parse['link'] = $user['username']; //El link del usuario
	
	//parseamos
   $page = parsetemplate( $ReferTpl, $parse );
   display($page, "Referidos");
?>
