<?php

/**
 * changelog.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

includeLang('changelogold');

$template = gettemplate('changelog_table');


foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description'] = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse = $lang;
$parse['body'] = $body;

	display(parsetemplate(gettemplate('changelog_body'), $parse), "Change Log");

?>