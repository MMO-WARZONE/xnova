<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('credit');

$parse   = $lang;

display(parsetemplate(gettemplate('credit_body'), $parse), $lang['cred_credit'], false);
?>