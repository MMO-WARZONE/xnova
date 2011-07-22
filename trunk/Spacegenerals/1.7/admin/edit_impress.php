<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('admin');

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

		message($lang['edit_impress_done'],$lang['edit_impress_success']);

	} else {
		display (parsetemplate(gettemplate("admin/edit_impress"), $lang), $lang['ress_all'], false, '', true);
	}
} else {
		message ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>