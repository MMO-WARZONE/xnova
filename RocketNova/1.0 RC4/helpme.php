<?php

/**
 * helpme.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

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