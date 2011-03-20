<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** credit.php                            **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('credit');
$parse   = $lang;

if ($user['authlevel'] >= 3) {
	if ($_POST['opt_save'] == "1") {
		if (isset($_POST['ExtCopyFrame']) && $_POST['ExtCopyFrame'] == 'on') {
			$game_config['ExtCopyFrame'] = "1";
			$game_config['ExtCopyOwner'] = $_POST['ExtCopyOwner'];
			$game_config['ExtCopyFunct'] = $_POST['ExtCopyFunct'];
		} else {
			$game_config['ExtCopyFrame'] = "0";
			$game_config['ExtCopyOwner'] = "";
			$game_config['ExtCopyFunct'] = "";
		}

		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFrame'] ."' WHERE `config_name` = 'ExtCopyFrame';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyOwner'] ."' WHERE `config_name` = 'ExtCopyOwner';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ExtCopyFunct'] ."' WHERE `config_name` = 'ExtCopyFunct';", 'config');

		AdminMessage ($lang['cred_done'], $lang['cred_ext']);

	} else {
		$parse['ExtCopyFrame'] = ($game_config['ExtCopyFrame'] == 1) ? " checked = 'checked' ":"";
		$parse['ExtCopyOwnerVal'] = $game_config['ExtCopyOwner'];
		$parse['ExtCopyFunctVal'] = $game_config['ExtCopyFunct'];

		$BodyTPL = gettemplate('admin/credit_body');
		$page = parsetemplate($BodyTPL, $parse);
		display($page, $lang['cred_credit'], false);
	}

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>