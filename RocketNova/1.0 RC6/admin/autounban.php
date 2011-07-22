<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = '../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

	if ($user['authlevel'] >= 3) {
		$lang['PHP_SELF'] = 'options.'.$phpEx;
		doquery("UPDATE {{table}} SET `banaday` =` banaday` - '1' WHERE `banaday` != '0';",'users');
		doquery("UPDATE {{table}} SET `bana` = '0' WHERE `banaday` < '1';",'users');
		$parse = $game_config;
		$parse['dpath'] = $dpath;
		$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
	} else {
		message ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>