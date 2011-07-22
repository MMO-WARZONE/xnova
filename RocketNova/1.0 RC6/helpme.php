<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);


	$BodyTPL = gettemplate('helpme');
	$parse   = $lang;

	$page = parsetemplate($BodyTPL, $parse);
	display($page, false);

?>