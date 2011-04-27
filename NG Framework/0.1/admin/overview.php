<?php

/**
 * overview.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

if ($user['authlevel'] < 1) {
	AdminMessage ($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

includeLang('admin');

if ($_GET['cmd'] == 'sort') {
	$TypeSort = $_GET['type'];
} else {
	$TypeSort = 'id';
}

$PageTPL  = gettemplate('admin/overview_body');
$RowsTPL  = gettemplate('admin/overview_rows');

$parse                      = $lang;
$parse['dpath']             = $dpath;
$parse['mf']                = $mf;
$parse['adm_ov_data_yourv'] = colorRed(VERSION);


//Usuarios Registrados
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","users")); //Guarda en la variable los usuarios online
$parse['Usersregs']  = $Consulta[0]; //Guarda para pasarlo al tpl los usuariosregistrados

//Numero de errores
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","errors")); //Guarda en la variable los Errores
$parse['canterrores']  = $Consulta[0]; //Guarda para pasarlo al tpl los errores

//Numero de Baneados
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","banned")); //Guarda en la variable los banned
$parse['cantban']  = $Consulta[0]; //Guarda para pasarlo al tpl los banned

//Numero de Alianzas
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","alliance")); //Guarda en la variable las Alianzas
$parse['cantalis']  = $Consulta[0]; //Guarda para pasarlo al tpl las Alianzas

//Numero de Planetas
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where planet_type='1'","planets")); //Guarda en la variable los planetas
$parse['cantplan']  = $Consulta[0]; //Guarda para pasarlo al tpl los planetas

//Numero de Lunas
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where planet_type='3'","planets")); //Guarda en la variable las Lunas
$parse['cantlunas']  = $Consulta[0]; //Guarda para pasarlo al tpl las lunas

//Numero de Flotas en vuelo
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","fleets")); //Guarda en la variable las flotas en vuelo
$parse['cantfleets']  = $Consulta[0]; //Guarda para pasarlo al tpl las flotas en vuelo

//Cantidad de Mensajes
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","messages")); //Guarda en la variable 
$parse['cantmessa']  = $Consulta[0]; //Guarda para pasarlo al tpl

//Cantidad de Mensajes
$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","rw")); //Guarda en la variable 
$parse['cantbata']  = $Consulta[0]; //Guarda para pasarlo al tpl

//Cantidad de visitas unica y visionados de paginas de hoy
 $fecha = date("Y/m/d");  //Cojemos la fecha en formato 2009/09/28
$Consulta = doquery("SELECT * FROM {{table}} where fecha='{$fecha}' ","visitas",true); //Guarda en la variable 
$parse['vunicas']  = $Consulta[2]; //Guarda para pasarlo al tpl
$parse['vpaginas']  = $Consulta[3]; //Guarda para pasarlo al tpl






//Conectados
$Last15Mins = doquery("SELECT * FROM {{table}} WHERE `onlinetime` >= '". (time() - 1200) ."' ORDER BY `". mysql_escape_string($TypeSort) ."` ASC;", 'users');
$Count      = 0;
$Color      = "lime";

while ($TheUser = mysql_fetch_array($Last15Mins)) {
	
	if ($PrevIP != "") {
		if ($PrevIP == $TheUser['user_lastip']) {
			$Color = "red";
		} else {
			$Color = "lime";
		}
	}

	$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $TheUser['id'] . "';", 'statpoints', true);
	$Bloc['dpath']               = $dpath;
	$Bloc['adm_ov_altpm']        = $lang['adm_ov_altpm'];
	$Bloc['adm_ov_wrtpm']        = $lang['adm_ov_wrtpm'];
	$Bloc['adm_ov_data_id']      = $TheUser['id'];
	$Bloc['adm_ov_data_name']    = $TheUser['username'];
	$Bloc['adm_ov_data_agen']    = $TheUser['user_agent'];
	$Bloc['adm_ov_data_clip']    = $Color;
	$Bloc['adm_ov_data_adip']    = $TheUser['user_lastip'];
	$Bloc['adm_ov_data_ally']    = $TheUser['ally_name'];
	$Bloc['adm_ov_data_point']   = pretty_number($UserPoints['total_points']);
	$Bloc['adm_ov_data_activ']   = pretty_time(time() - $TheUser['onlinetime']);
	$Bloc['adm_ov_data_pict']    = 'm.gif';
	$PrevIP                      = $TheUser['user_lastip'];

	$parse['adm_ov_data_table'] .= parsetemplate($RowsTPL, $Bloc);
	$Count++;
}

$parse['adm_ov_data_count']  = $Count;
$Page = parsetemplate($PageTPL, $parse);

display($Page, $lang['sys_overview'], false, '', true);

?>
