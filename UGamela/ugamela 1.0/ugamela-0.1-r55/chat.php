<?php //changelog.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);


display("comming soon ;)","Chat");

// Created by Perberos. All rights reversed (C) 2006
?>
