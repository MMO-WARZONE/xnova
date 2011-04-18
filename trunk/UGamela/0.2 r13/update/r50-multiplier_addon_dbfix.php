<?php  //r50-multiplier_addon_dbfix.php :: Agrega la propiedad multiplicar recursos

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');
$no=0;
//Nos fijamos si existe la row 'metal_basic_income'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='resource_multiplier'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='resource_multiplier',config_value='1'",'config');$no=0;}

if($no>0) message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
else message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>
