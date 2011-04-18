<?php

/**
 * add_ress.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 * portion to e-Zobar
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= 2) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_ress");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$metal       = $_POST['metal'];
			$cristal     = $_POST['cristal'];
			$deut        = $_POST['deut'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_am_done'].'<meta http-equiv="refresh" content="3; url=?action=administrativeMats">', $lang['adm_am_ttle'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		header('Location: indexGame.php');
	}

?>