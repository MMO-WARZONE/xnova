<?php

/**
 * chat.php
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

	includeLang('chat');

	$nick = $user['username'];
	$parse = $lang;

	display(parsetemplate(gettemplate('chat_body'), $parse), $lang['Chat']);

?>