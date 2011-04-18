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
$lang['thanksforregistry'] = 'Danke f&uuml;r ihre Anmeldung! Sie erhalten eine E-Mail.';

// Errors
$lang['error_mail']        = 'E-Mail Adresse ung&uuml;ltig!<br />';
$lang['error_hplanet']     = 'Name des Hauptplaneten ung&uuml;ltig!.<br />';
$lang['error_hplanetnum']  = 'Der HP Name darf nur Zahlen und Buchstaben enthalten.<br />';
$lang['error_character']   = 'Username ung&uuml;ltig!<br />';
$lang['error_charalpha']   = 'Bitte nur Buchstaben und Zahlen verwenden!<br />';
$lang['error_password']    = 'Das Passwort muss mindestens 6 Zeichen lang sein und darf nur Zahlen und Buchstaben enthalten!<br />';
$lang['error_rgt']         = 'Sie m&uuml;ssen der AGB zustimmen!<br />';
$lang['error_userexist']   = 'Der User existiert bereits!<br />';
$lang['error_emailexist']  = 'Es existiert bereits ein User mit dieser E-Mail Adresse!<br />';
$lang['error_sex']         = 'Ung&uuml;ltiges Geschlecht.<br />';
$lang['error_mailsend']    = 'Ein Fehler beim versenden der E-Mail das Passwort ist: ';
$lang['reg_welldone']      = 'Registrierung abgeschlossen';
$lang['error_captcha']     = 'Bitte Capcha Code neu eingeben!';
$lang['new_captcha']       = 'Neuer Capcha Code';


// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>