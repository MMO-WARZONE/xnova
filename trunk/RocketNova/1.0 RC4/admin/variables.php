<?php

/**
 * overview.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for Xnova
 */

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
