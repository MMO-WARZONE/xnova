<?php

/**
 * server.php
 *
 * @version 1.0
 * @copyright 2008 By gianluca311 for XNova
 */


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 3) {
		includeLang('server');
		$PageTpl   = gettemplate("admin/server");
		$parse     = $lang;
		$parse['server_ip'] = $_SERVER['SERVER_ADDR'];
		$parse['serversoft'] = $_SERVER['SERVER_SOFTWARE'];
		$parse['server_os'] = $_ENV['OS'];
		$parse['php'] = phpversion();
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['server_information'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>