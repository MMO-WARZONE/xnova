<?php //index.php :: Pagina inicial


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//Index con dos frames
echo parsetemplate(gettemplate('index_frames'), $lang);




// Created by Perberos. All rights reserved (C) 2006
?>
