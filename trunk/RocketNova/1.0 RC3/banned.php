<?php

/**
 * banned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

includeLang('banned');



$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;

	$RowsTPL = gettemplate('contact_body_rows');


	$QrySelectUser  = "SELECT `username`, `email`, `authlevel`, `id`  ";
	$QrySelectUser .= "FROM {{table}} ";
	$QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
	$GameOps = doquery ( $QrySelectUser, 'users');

	while( $Ops = mysql_fetch_assoc($GameOps) ) {
		$bloc['ctc_data_name']    = $Ops['username'];
		$bloc['ctc_data_auth']    = $lang['user_level'][$Ops['authlevel']];
		$bloc['ctc_data_mail']    = "<a href=mailto:".$Ops['email']."?subject=Anfrage_AG-XNova_Uni1_>".$Ops['email']."</a>";
            if(empty($user['authlevel'])) {
    		$bloc['ctc_data_pn']	= "login";
		} else {
    		$bloc['ctc_data_pn']	= "<a href=messages.php?mode=write&id=".$Ops['id'].">".$lang['ctc_pn']."</a>";
            }
		$parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
	}

$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;",'banned');
$i=0;
while($u = mysql_fetch_array($query)){
	$parse['banned'] .=
        "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[4])."</center></b></td>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[5])."</center></b></td>".
	"<td class=b><center><b>".$u[2]."</center></b></td>".
	"<td class=b><center><b>".$u[6]."</center></b></td></tr>";
	$i++;
	
}	

if ($i=="0")
 $parse['banned'] .= "<tr><th class=b colspan=6>Noch kein Spieler Gesperrt</th></tr>";
else
  $parse['banned'] .= "<tr><th class=b colspan=6>Es sind {$i} Spieler Gesperrt</th></tr>";

display(parsetemplate(gettemplate('banned'), $parse), 'Banned');

// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
?>