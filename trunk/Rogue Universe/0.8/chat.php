<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

includeLang('chat');
$body = gettemplate('chat_body');

$nick  = $user['username'];
$parse = $lang;

$page = parsetemplate($body, $parse);
display($page, $lang['Chat'], false);

?>

