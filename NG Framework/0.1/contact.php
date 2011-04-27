<?php

/**
 * contact.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Contacto'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación

	includeLang('contact');

	$BodyTPL = gettemplate('contact_body');
	$RowsTPL = gettemplate('contact_body_rows');
	$parse   = $lang;

	$QrySelectUser  = "SELECT `username`, `email`, `authlevel` ";
	$QrySelectUser .= "FROM {{table}} ";
	$QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
	$GameOps = doquery ( $QrySelectUser, 'users');

	while( $Ops = mysql_fetch_assoc($GameOps) ) {
		$bloc['ctc_data_name']    = $Ops['username'];
		$bloc['ctc_data_auth']    = $lang['user_level'][$Ops['authlevel']];
		$bloc['ctc_data_mail']    = "<a href=mailto:".$Ops['email'].">".$Ops['email']."</a>";
		$parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
	}

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['ctc_title'], false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

