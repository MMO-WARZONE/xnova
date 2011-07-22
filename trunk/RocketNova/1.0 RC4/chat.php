<?php

/**
 * chat.php
 *
 * @version 1.1
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

// Schutz vor unregestrierten
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

	includeLang('chat');

	$nick = $user['username'];
	$parse = $lang;

	display(parsetemplate(gettemplate('chat_body'), $parse), $lang['Chat']);

?>