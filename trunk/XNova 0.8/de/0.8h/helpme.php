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

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


	$BodyTPL = gettemplate('helpme');
	$parse   = $lang;

	$page = parsetemplate($BodyTPL, $parse);
	display($page, false);

?>