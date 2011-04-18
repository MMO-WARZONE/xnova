<?php  //r54-energy_used_dbfix.php :: Cambia el nombre de la tabla energy_free

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');
$no=0;

//Nos fijamos si existe la row 'id_g'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='id_g'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='id_g',config_value='1'",'config');$no=0;}

//Nos fijamos si existe la row 'id_s'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='id_s'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='id_s',config_value='2'",'config');$no=0;}

//Nos fijamos si existe la row 'id_p'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='id_p'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='id_p',config_value='1'",'config');$no=0;}

if($no>0) message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
else message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>
