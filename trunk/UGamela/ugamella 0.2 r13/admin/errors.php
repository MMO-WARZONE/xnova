<?php //tools.php :: Herramientas variadas.


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="3"&&$user['authlevel']!="1"){ header("Location: ../login.php");}

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


$parse = $lang;
$parse['dpath'] = $dpath;

//
// Borrar un item de errores
//
if(isset($delete)){
	doquery("DELETE FROM {{table}} WHERE `error_id`=$delete",'errors');
}elseif($deleteall=='yes'){
	doquery("DELETE FROM {{table}}",'errors');
}

//
// Lista de usuarios conectados.
//
$query = doquery("SELECT * FROM {{table}}",'errors');
$i=0;

while($e = mysql_fetch_array($query)){
	$i++;
	$parse['errors_list'] .= "<tr><td class=n rowspan=2>
	<!-- -->
	{$e['error_id']}</td>".
	"<td class=n>{$e['error_type']} [<a href=?delete={$e['error_id']}>x</a>]</td>".
	"<td class=n>{$e['error_sender']}</td>".
	"<td class=n>".date('Y m d h:i:s',$e['error_time'])."</td></tr><tr>".
	"<td class=b colspan=3 width=500>".nl2br($e['error_text'])."</td></tr>";
}

$parse['errors_list'] .= "<tr><th class=b colspan=4>Hay {$i} error(es)...</th></tr>";




display(parsetemplate(gettemplate('admin/errors_body'), $parse),"Errors",true);


// Created by Perberos. All rights reversed (C) 2006
?>
