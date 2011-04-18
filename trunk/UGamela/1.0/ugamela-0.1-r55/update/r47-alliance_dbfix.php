<?php  //r47-alliance_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

//Nos fijamos si existe la columna 'ally_request_notallow'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'ally_request_text'",'users',true);

if($query){
	message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
}
else{
	doquery('ALTER TABLE {{table}} ADD ally_request_text TEXT AFTER ally_request','users');
	doquery('ALTER TABLE {{table}} CHANGE ally_ranges ally_ranks TEXT','alliance');
	message($lang['Fix_welldone'],$lang['Fix'],'./');
}



// Created by Perberos. All rights reversed (C) 2006 
?>
