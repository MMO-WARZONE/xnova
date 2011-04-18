<?php

/**
 * mats.php
 *
 * @version 1.0
 * @copyright 2008 by Xire -AlteGarde-
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

	if ($user['authlevel'] >= "1") {
		includeLang('admin/mats');
		$PanelMainTPL = gettemplate('admin/mats');
		$parse                  = $lang;
		$page = parsetemplate( $PanelMainTPL, $parse );
		display( $page, $lang['panel_mainttl'], false, '', true );
	} else {
		header('Location: indexGame.php');
	}

?>