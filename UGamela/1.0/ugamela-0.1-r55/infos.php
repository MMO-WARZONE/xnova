<?php //infos.php


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.".$phpEx); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);


includeLang('tech');
includeLang('infos');

$info = $lang['info'][$gid];

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

if($gid>=1 &&$gid<=44){$TitleClass = str_replace('%n',$lang['tech'][0],$lang['Information_on']);}
elseif($gid>=106 &&$gid<=199){$TitleClass = str_replace('%n',$lang['tech'][100],$lang['Information_on']);}
elseif($gid>=202 &&$gid<=214){$TitleClass = str_replace('%n',$lang['tech'][200],$lang['Information_on']);}
elseif($gid>=401 &&$gid<=503){$TitleClass = str_replace('%n',$lang['tech'][400],$lang['Information_on']);}

$parse = array();
$parse['TitleClass'] = $TitleClass;
$parse['Name'] = $lang['Name'];
$parse['tech'] = $info['name'];
$parse['dpath'] = $dpath;
$parse['gid'] = $gid;
$parse['description'] = nl2br($info['description']);

$page = parsetemplate(gettemplate('infos_body'), $parse);


display($page,$lang['Information']);

// Created by Perberos. All rights reversed (C) 2006
?>
