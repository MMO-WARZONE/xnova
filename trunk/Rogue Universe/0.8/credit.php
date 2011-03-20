<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('credit');

	$parse   = $lang;

	display(parsetemplate(gettemplate('credit_body'), $parse), $lang['cred_credit'], false);
?>