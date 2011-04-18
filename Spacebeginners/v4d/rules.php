<?php



define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('rules');

	$parse = $lang;
	$parse['servername']   = $game_config['game_name'];

	$PageTPL  = gettemplate('rules_body');
	$page     = parsetemplate( $PageTPL, $parse);

display ($page, $lang['rules'], true, '', false);

?>