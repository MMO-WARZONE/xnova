<?php  //r13-max_potition_dbfix.php :: Permite extablecer el maximo de posiciones en un systema solar

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');
$no=0;
//Nos fijamos si existe la row 'max_galaxy'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='max_galaxy'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='max_galaxy',config_value='9'",'config');$no=0;}
//Nos fijamos si existe la row 'max_system'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='max_system'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='max_system',config_value='499'",'config');$no=0;}
//Nos fijamos si existe la row 'max_position'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='max_position'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='max_position',config_value='15'",'config');$no=0;}

if($no>0) message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
else message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>

