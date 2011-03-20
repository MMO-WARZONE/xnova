<?PHP //leftmenu.php :: Menu de la izquierda


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

includeLang('leftmenu');

$mf = "Mainframe";//nombre del frame

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;
$parse['VERSION'] = VERSION;
$rank = doquery("SELECT COUNT(*) FROM {{table}} WHERE points_points>={$user['points_points']}","users",true);
$parse['user_rank'] = $rank[0];

//
//  TODO:
//	Hay que revisar el codigo para crear el link de admin
//
$parse['ADMIN_LINK'] = ($user['authlevel'] == 1||$user['authlevel'] == 3)?'<tr><td><div align="center"><a href="admin/leftmenu.php"><font color="lime">Admin</font></a></div></td></tr>':'';

echo parsetemplate(gettemplate('left_menu'), $parse);


// Created by Perberos. All rights reversed (C) 2006
?>
