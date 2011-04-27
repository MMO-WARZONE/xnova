<?php
/**
 * @author SainT
 *
 * @package XNova
 * @copyright (c)  XNova Group
 * 1 = ON || 0 = OFF
 **/

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
	if($_GET['activar']) { //Si existe esta variable
	$id = $_GET['activar']; //Fijamos la variable
	doquery("UPDATE {{table}} SET estado = 1 where id={$id}", "modulos"); //activamos el modulo
	}
	if($_GET['desactivar']) { //Si existe esta variable
	$id = $_GET['desactivar']; //Fijamos la variable
	doquery("UPDATE {{table}} SET estado = 0 where id={$id}", "modulos"); //activamos el modulo
	}
	$consulta = doquery("SELECT id,modulo,estado FROM {{table}} order by modulo asc", 'modulos'); //Sacamos los modulos ordenados alfabeticamente
	while ($resultado = mysql_fetch_assoc($consulta)) { //Hacemos un while (lee 1 por 1)	
	$resultado['modulo'] = str_replace("_"," ",$resultado['modulo']);
	if($resultado['estado'] == "1") { //Si el modulo esta activado
	$parse['modulos'] .= "<tr>";
	$parse['modulos'] .= "<td class=\"c\" style=\"color:#FFFFFF\">".$resultado['modulo']."</td>";
	$parse['modulos'] .= "<td align=\"left\" class=\"c\" style=\"color:green\"><b>AKTIVIERT</b></td>";
	$parse['modulos'] .= "<td align=\"center\" class=\"c\" width=\"20px\" style=\"color:#FFFFFF\"><a href=\"modulos.php?desactivar=".$resultado['id']."\"><img title=\"Desactivar\" alt=\"Desactivar\" src=\"../images/r7.png\"></a></td>";
	$parse['modulos'] .= "</tr>";
	} else { //si esta desactivado
	$parse['modulos'] .= "<tr>";
	$parse['modulos'] .= "<td class=\"c\" style=\"color:#FFFFFF\">".$resultado['modulo']."</td>";
	$parse['modulos'] .= "<td align=\"left\" class=\"c\" style=\"color:red\"><b>DEAKTIVIERT</b></td>";
	$parse['modulos'] .= "<td align=\"center\" class=\"c\" width=\"20px\" style=\"color:#FFFFFF\"><a href=\"modulos.php?activar=".$resultado['id']."\"><img title=\"Desactivar\" alt=\"Activar\" src=\"../images/r7.png\"></a></td>";
	$parse['modulos'] .= "</tr>";
	}
	} //Fin while

$opcion = $_GET['opcion']; //Recojemos la variable de la url y la ponemos como $opcion.


	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/modulos_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administración de los modulos', '', false);
?>
