<?php  //r47-ranks_id_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

//Nos fijamos si existe la columna 'ally_request_notallow'
$query = doquery("SHOW COLUMNS FROM {{table}} LIKE 'ally_rank_id'",'users',true);

if($query){
	message($lang['There_is_not_need_fix'],$lang['Fix'],'./');
}
else{
	doquery('ALTER TABLE {{table}} CHANGE ally_range_id ally_rank_id TEXT','users');
	message($lang['Fix_welldone'],$lang['Fix'],'./');
}



// Created by Perberos. All rights reversed (C) 2006 
?>
