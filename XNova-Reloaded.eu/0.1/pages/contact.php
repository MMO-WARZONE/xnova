<?php

/**
 * contact.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen

	includeLang('contact');

	$RowsTPL = gettemplate('contact_body_rows');
	$parse   = $lang;

	foreach($DB->query("SELECT `username`, `email`, authlevel FROM ".PREFIX."users WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;") as $Ops) {
		$bloc['ctc_data_name']	= $Ops['username'];
		$bloc['ctc_data_mail']	= "<a href=mailto:".$Ops['email'].">".$Ops['email']."</a>";
		
		if ($Ops['authlevel'] == 3)
			$bloc['ctc_status']		= $lang['con_ga'];
		elseif ($Ops['authlevel'] == 2)
			$bloc['ctc_status']		= $lang['con_sgo'];
		else
			$bloc['ctc_status']		= $lang['con_go'];
		
		$parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
	}

	display(parsetemplate(gettemplate('contact_body'), $parse), $lang['con_title'], false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>