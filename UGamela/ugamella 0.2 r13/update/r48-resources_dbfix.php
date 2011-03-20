<?php  //r48-resources_dbfix.php :: Añade algunos valores a la tabla config

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');
$no=0;
//Nos fijamos si existe la row 'metal_basic_income'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='metal_basic_income'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='metal_basic_income',config_value='20'",'config');$no=0;}
//Nos fijamos si existe la row 'crystal_basic_income'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='crystal_basic_income'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='crystal_basic_income',config_value='10'",'config');$no=0;}
//Nos fijamos si existe la row 'deuterium_basic_income'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='deuterium_basic_income'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='deuterium_basic_income',config_value='0'",'config');$no=0;}
//Nos fijamos si existe la row 'energy_basic_income'
$query = doquery("SELECT * FROM {{table}} WHERE config_name='energy_basic_income'",'config',true);
if($query){$no++;}
else{doquery("INSERT INTO {{table}} SET config_name='energy_basic_income',config_value='0'",'config');$no=0;}

//ahora los rows de la metalmine_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'metalmine_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE metalmine_porcent '.$resource[1].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}
//ahora los rows de la crystalmine_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'crystalmine_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE crystalmine_porcent '.$resource[2].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}
//ahora los rows de la deuterium_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'deuterium_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE deuterium_porcent '.$resource[3].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}
//ahora los rows de la solarplant_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'solarplant_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE solarplant_porcent '.$resource[4].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}

//ahora los rows de la fusion_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'fusion_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE fusion_porcent '.$resource[12].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}
//ahora los rows de la satelite_porcent
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'satelit_porcent'",'planets',true);
if(!$query){$no++;}
else{doquery('ALTER TABLE {{table}} CHANGE satelit_porcent '.$resource[212].'_porcent INT(11) DEFAULT "0" NOT NULL','planets');$no=0;}

if($no>0) message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
else message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>
