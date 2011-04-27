<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package XNova
 * @version 0.2
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

includeLang('changelog');

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
//TODO: put "Change Log" in 'changelog.mo'
display($page,"Change Log");

// Created by Perberos. All rights reversed (C) 2006
?>
