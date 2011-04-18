<?php

/**
 * edit_impress.php
 *
 * @version 1.0
 * @copyright 2008 by RedFighter for XNova Germany
 * überarbeitet by kleinerzwerg
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] == 4) {

	$impress = doquery("SELECT * FROM {{table}}", 'impressum', true);
	
	if($_POST['vorname']) {
	
	$vorname        = mysql_real_escape_string($_POST['vorname']); 
	$nachname       = mysql_real_escape_string($_POST['nachname']); 
	$strasse_nummer = mysql_real_escape_string($_POST['strasse_nummer']); 
	$plz_stadt      = mysql_real_escape_string($_POST['plz_stadt']); 
	$email          = mysql_real_escape_string($_POST['email']); 
	$telefon        = mysql_real_escape_string($_POST['telefon']); 
	
	doquery("UPDATE {{table}} SET `vorname` = '$vorname'", 'impressum');
	doquery("UPDATE {{table}} SET `nachname` = '$nachname'", 'impressum');
	doquery("UPDATE {{table}} SET `strasse_nummer` = '$strasse_nummer'",   'impressum');
	doquery("UPDATE {{table}} SET `plz_stadt` = '$plz_stadt'", 'impressum');
	doquery("UPDATE {{table}} SET `email` = '$email'", 'impressum');
	doquery("UPDATE {{table}} SET `telefon` = '$telefon'", 'impressum');
	
	message('Deine Daten wurden erfolgreich eingetragen und sind nun in der impressum.php sichtbar!','Erfolgreich');	
	
	} else {
        display (parsetemplate(gettemplate("admin/edit_impress"), $lang), $lang['ress_all'], false, '', true);
}
} else {
		message ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>