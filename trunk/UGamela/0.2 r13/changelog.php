<?php //changelog.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

includeLang('changelog');
//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

/*
	simple array donde se iran colocando las diferentes versiones del juego
*/

$template = gettemplate('changelog_table');


foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description'] = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse = $lang;
$parse['body'] = $body;

$page .= parsetemplate(gettemplate('changelog_body'), $parse);

display($page,"Change Log");

// Created by Perberos. All rights reversed (C) 2006
?>