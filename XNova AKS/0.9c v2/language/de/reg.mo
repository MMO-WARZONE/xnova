<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registrieren';
$lang['form']              = 'Anmeldung';
$lang['Register']          = 'XNova Registrieren';
$lang['Undefined']         = 'Bitte waehlen';
$lang['Male']              = 'Maenlich';
$lang['Female']            = 'Weiblich';
$lang['Multiverse']        = '<b>XNova</b> Beta Uni';
$lang['E-Mail']            = 'E-Mail Adresse (z.B. addy@mail.com)';
$lang['MainPlanet']        = 'Name des Hauptplanets (keine Sonderzeichen)';
$lang['GameName']          = 'Username';
$lang['Sex']               = 'Geschlecht';
$lang['accept']            = 'Ich akzeptiere die <a href="help.php?conditions">Regeln &amp; AGB</a>';
$lang['signup']            = 'Registrieren';
$lang['neededpass']        = 'Passwort';

// Send
$lang['mail_welcome']      = 'Vielen Dank fuer ihre Anmeldung bei uns ({gameurl}) \n Ihr Passwort lautet : {password}\n\Viel Spass !\n{gameurl}';
$lang['mail_title']        = 'Anmeldung erfolgreich';
$lang['thanksforregistry'] = 'Danke fuer ihre Anmeldung! Sie erhalten eine E-Mail.';

// Errors
$lang['error_mail']        = 'E-Mail Adresse ungueltig!<br />';
$lang['error_hplanet']     = 'Name des Hauptplaneten ungueltig!.<br />';
$lang['error_hplanetnum']  = 'Der HP Name enthaelt ungueltige Zeichen.<br />';
$lang['error_character']   = 'Username ungueltig!<br />';
$lang['error_charalpha']   = 'Bitte nur Buchstaben und Zahlen verwenden!<br />';
$lang['error_password']    = 'Das Passwort muss mindestens 4 Zeichen lang sein!<br />';
$lang['error_rgt']         = 'Sie muessen die AGB zustimmen.<<br />';
$lang['error_userexist']   = 'Der User existiert bereits!<br />';
$lang['error_emailexist']  = 'Es existiert bereits ein User mit dieser E-Mail Adresse!<br />';
$lang['error_sex']         = 'Ungueltiges Geschlecht.<br />';
$lang['error_mailsend']    = 'Ein Fehler beim versenden der mail das Passwort ist: ';
$lang['reg_welldone']      = 'Registrierung abgeschlossen';

// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>