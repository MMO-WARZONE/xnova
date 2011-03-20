<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** add_money.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 2) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_money");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$metal       = $_POST['metal'];
			$cristal     = $_POST['cristal'];
			$deut        = $_POST['deut'];
			$tach        = $_POST['tach'];

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."', ";
			$QryUpdatePlanet .= "`tachyon` = `tachyon` + '". $tach ."' ";

			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_am_done'], $lang['adm_am_ttle'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>