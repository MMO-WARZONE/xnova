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
$parse['user_rank'] = ($user['rank']==0)?1:$user['rank'];

//$link['Admin'] = array("href" => "admin.php", "accesskey" => "9", "target" => $mf);

//
//  TODO:
//	Hay que revisar el corigo para crear el link de admin
//
$parse['ADMIN_LINK'] = ($user['authlevel'] == 1||$user['authlevel'] == 3)?'':'';

echo parsetemplate(gettemplate('left_menu'), $parse);


// Created by Perberos. All rights reversed (C) 2006
?>
