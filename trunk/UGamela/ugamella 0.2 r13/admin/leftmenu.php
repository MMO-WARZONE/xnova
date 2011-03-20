<?PHP //leftmenu.php :: Menu de la izquierda


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="3"&&$user['authlevel']!="1"){ header("Location: ../login.php");}

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

includeLang('leftmenu');

$mf = "Mainframe";//nombre del frame

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;
$parse['VERSION'] = VERSION;
$parse['user_rank'] = ($user['rank']==0)?1:$user['rank'];

echo parsetemplate(gettemplate('admin/left_menu'), $parse);


// Created by Perberos. All rights reversed (C) 2006
?>
