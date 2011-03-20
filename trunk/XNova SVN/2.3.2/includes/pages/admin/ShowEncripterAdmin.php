<?php
//version 1

function ShowEncripterAdmin($user){
	global $lang, $displays;
if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

	if ($_POST['md5q'] != "")
	{
		$lang['md5_md5'] = $_POST['md5q'];
		$lang['md5_enc'] = md5 ($_POST['md5q']);
	}
	else
	{
		$lang['md5_md5'] = "";
		$lang['md5_enc'] = md5 ("");
	}
	$displays->assignContent('adm/encripter');
	$displays->display();
	display(parsetemplate(gettemplate('adm/encripter'), $parse), false, '', true, false);
}
?>