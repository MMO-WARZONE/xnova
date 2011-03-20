<?php
//version 1

function ShowChangePassAdmin($user){
           global $lang,$db,$displays;
if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

	if ($_POST['md5q'] != ""){
		$db->query ("UPDATE {{table}} SET `password` = '" . md5 ($_POST['md5q']) . "' WHERE `username` = '".$_POST['user']."';", 'users');
                $displays->message("Pass cambiada");
        }
        $displays->assignContent("adm/changepassword");

        $displays->display();



}
?>