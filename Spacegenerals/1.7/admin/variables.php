<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = '../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

if ($user['authlevel'] >= 4) {

	$parse['phpinfo'] = phpinfo();

	$Page = parsetemplate($PageTPL, $parse);

	display ( $Page, "PhpInfo", false, '', true);
} else {
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>
