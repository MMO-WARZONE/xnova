<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** changelog.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('changelog');
$template = gettemplate('changelog_table');

$parse = $lang;

foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description']    = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse['body'] = $body;

$page .= parsetemplate(gettemplate('changelog_body'), $parse);

display( $page, "Changelog", false, '', true);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>