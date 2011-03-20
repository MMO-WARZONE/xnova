<?php  //r54-energy_used_dbfix.php :: Cambia el nombre de la tabla energy_free

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');
$no=0;



//Nos fijamos si existe la row 'energy_free'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'points_points'",'users',true);
if($query){$no++;}
else{doquery('ALTER TABLE {{table}} ADD points_points BIGINT(20) DEFAULT "0" NOT NULL','users');$no=0;}


//Nos fijamos si existe la row 'energy_free'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'points_tech'",'users',true);
if($query){$no++;}
else{doquery('ALTER TABLE {{table}} ADD points_tech BIGINT(20) DEFAULT "0" NOT NULL','users');$no=0;}

//Nos fijamos si existe la row 'energy_free'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'points_fleet'",'users',true);
if($query){$no++;}
else{doquery('ALTER TABLE {{table}} ADD points_fleet BIGINT(20) DEFAULT "0" NOT NULL','users');$no=0;}

//Nos fijamos si existe la row 'energy_free'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'points'",'planets',true);
if($query){$no++;}
else{doquery('ALTER TABLE {{table}} ADD points BIGINT(20) DEFAULT "0" NOT NULL','planets');$no=0;}

if($no>0) message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
else message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>



