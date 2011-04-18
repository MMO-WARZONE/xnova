<?php //leftmenu.php :: Menu de la izquierda de admin


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="3"&&$user['authlevel']!="1"){ header("Location: ../login.php");}

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

includeLang('overview');



$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;
//
// Obtenemos la ultima version,  pidiendo un pequeño archivo.
//
$parse['version'] = @file_get_contents('http://ugamela.sourceforge.net/lastversion.php?v='.VERSION);

if($parse['version']!=VERSION){
	$parse['VERSION'] = colorRed(VERSION);
}else{
	$parse['VERSION'] = colorGreen(VERSION);
}

//
// Lista de usuarios conectados.
//
$query = doquery("SELECT * FROM {{table}} WHERE onlinetime>='".(time()-15*60)."'",'users');
$i=0;

while($u = mysql_fetch_array($query)){
	
	$parse['online_list'] .= "<tr><td class=b>".
	'<a href="../messages.php?mode=write&id='.$u['id'].'"><img src="'.$dpath.'img/m.gif" alt="Escribir mensaje" title="Escribir mensaje" border="0"></a> '.
	"<a href=\"\">{$u['username']}</a> ".
	//IP tool
	"<a style=\"color:#7f7f7f;\" href=\"http://network-tools.com/default.asp?prog=trace&host={$u['user_lastip']}\">[{$u['user_lastip']}]</a></td>".
	"<td class=b>{$u['ally_name']}</td>".
	"<td class=m>".pretty_number($u['points_points']/1000)."</td>".
	"<td class=b>".pretty_time(time()-$u['onlinetime'])."</td></tr>";
	$i++;
}

$parse['online_list'] .= "<tr><th class=b colspan=4>Hay {$i} usuario(s) en linea.</th></tr>";




display(parsetemplate(gettemplate('admin/overview_body'), $parse),"Overview",true);


// Created by Perberos. All rights reversed (C) 2006
?>
