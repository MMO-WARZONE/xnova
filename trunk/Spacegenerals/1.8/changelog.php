<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

includeLang('changelog');

// Schutz vor unregestrierten Usern
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

$template = gettemplate('changelog_table');


foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description'] = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse = $lang;
$parse['body'] = $body;

display(parsetemplate(gettemplate('changelog_body'), $parse), $lang['CHANGELOG_TITLE']);

?>