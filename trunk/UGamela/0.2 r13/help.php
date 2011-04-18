<?php  //help.php :: Archivo de ayuda.

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

switch(implode('/',array_keys($_GET))){

	case 'conditions':display(gettemplate('agreement'));
	case 'agreement':display(gettemplate('agreement'));

	default:
	display('');
}
// Created by Perberos. All rights reserved (C) 2006
?>
