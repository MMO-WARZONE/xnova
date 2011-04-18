<?php  //r47-ranks_id_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

//Nos fijamos si existe la row 'metal_basic_income'
doquery('ALTER TABLE {{table}} CHANGE '.$resource["1"].'_porcent '.$resource["1"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');
doquery('ALTER TABLE {{table}} CHANGE '.$resource["2"].'_porcent '.$resource["2"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');
doquery('ALTER TABLE {{table}} CHANGE '.$resource["3"].'_porcent '.$resource["3"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');
doquery('ALTER TABLE {{table}} CHANGE '.$resource["4"].'_porcent '.$resource["4"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');
doquery('ALTER TABLE {{table}} CHANGE '.$resource["12"].'_porcent '.$resource["12"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');
doquery('ALTER TABLE {{table}} CHANGE '.$resource["212"].'_porcent '.$resource["212"].'_porcent INT(11) DEFAULT "10" NOT NULL','planets');

message($lang['Fix_welldone'],$lang['Fix'],'./');
// Created by Perberos. All rights reversed (C) 2006 
?>
