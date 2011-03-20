<?php //changelog.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Puedes agregar el link que quieras,
//
//header('Location: ./chat/');
header('Location: http://perberos.pe.funpic.de/chat/');

// Created by Perberos. All rights reversed (C) 2006
?>
