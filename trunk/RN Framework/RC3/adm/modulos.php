<?php
/**
 * @author SainT
 *
 * @package XNova
 * @copyright (c)  XNova Group
 * 1 = ON || 0 = OFF
 **/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

includeLang('ADMIN'); //Incluimos el archivo del lenguaje

$parse = $lang; 
//Si no tiene permiso no entra
if ($user['authlevel'] < 3) die(message($lang['not_enough_permissions']));

    if($_GET['activar']) { //Si existe esta variable
    $id = $_GET['activar']; //Fijamos la variable
    doquery("UPDATE {{table}} SET estado = 1 where id={$id}", "modulos"); //activamos el modulo
    }
    if($_GET['desactivar']) { //Si existe esta variable
    $id = $_GET['desactivar']; //Fijamos la variable
    doquery("UPDATE {{table}} SET estado = 0 where id={$id}", "modulos"); //activamos el modulo
    }
    $consulta = doquery("SELECT id,modulo,estado FROM {{table}} order by modulo asc", 'modulos'); //Sacamos los modulos ordenados
    while ($resultado = mysql_fetch_assoc($consulta)) { //Hacemos un while (lee 1 por 1)    
    if($resultado['estado'] == "1") { //Si el modulo esta activado
    $parse['modulos'] .= "<tr>";
    $parse['modulos'] .= "<td class=\"c\">".$resultado['modulo']."</td>";
    $parse['modulos'] .= "<td align=\"left\" class=\"c\" style=\"color:green\"><b>AKTIV</b></td>";
    $parse['modulos'] .= "<td align=\"center\" class=\"c\" width=\"20px\"><a href=\"modulos.php?desactivar=".$resultado['id']."\">Deaktivieren</a></td>";
    $parse['modulos'] .= "</tr>";
    } else { //si esta desactivado
    $parse['modulos'] .= "<tr>";
    $parse['modulos'] .= "<td class=\"c\">".$resultado['modulo']."</td>";
    $parse['modulos'] .= "<td align=\"left\" class=\"c\" style=\"color:red\"><b>NICHT AKTIV</b></td>";
    $parse['modulos'] .= "<td align=\"center\" class=\"c\" width=\"20px\"><a href=\"modulos.php?activar=".$resultado['id']."\">Aktivieren</a></td>";
    $parse['modulos'] .= "</tr>";
    }
    } //Fin while

$opcion = $_GET['opcion']; //Recojemos la variable de la url y la ponemos como $opcion.


    //Finalizamos el Parsing
    $tpl_menu = gettemplate('adm/modulos_body'); //Definimos el tpl a usar
    $menu = parsetemplate($tpl_menu, $parse); 
    display($menu, false, '' , true, false);
?> 