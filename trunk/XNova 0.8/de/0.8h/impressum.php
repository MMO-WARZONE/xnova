<?php

/**
 * impressum.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	$impress = doquery("SELECT * FROM {{table}}", 'impressum', true);

	includeLang('credit');
	

	$parse   = $lang;
	
	$parse['vorname']        = $impress['vorname'];
	$parse['nachname']       = $impress['nachname'];
	$parse['strasse_nummer'] = $impress['strasse_nummer'];
	$parse['plz_stadt']      = $impress['plz_stadt'];
	$parse['email']          = $impress['email'];
    $parse['telefon']        = $impress['telefon'];
	
	display(parsetemplate(gettemplate('impressum'), $parse), $lang['cred_credit'], false);
?>