<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

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