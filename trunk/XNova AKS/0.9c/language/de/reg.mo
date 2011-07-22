<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registrieren';
$lang['form']              = 'Anmeldung';
$lang['Register']          = 'XNova Registrieren';
$lang['Undefined']         = '- Bitte Waehlen -';
$lang['Male']              = 'Mann';
$lang['Female']            = 'Frau';
$lang['Multiverse']        = 'XNova';
$lang['E-Mail']            = 'E-Mail Adresse<br>(Sie bekommen eine Anmeldebestaetigung<br> per E-Mail!';
$lang['MainPlanet']        = 'Hauptplaneten Name';
$lang['GameName']          = 'Spielername';
$lang['Sex']               = 'Geschlecht';
$lang['accept']            = 'Ich akzeptiere die <a href="agb.php">AGB</a> und die <a href="rules.html">Regeln</a>';
$lang['signup']            = ' Registrieren ';
$lang['neededpass']        = 'Passwort';
$lang['error_captcha']     = 'Falscher Code. <br />'; 

// Send
$lang['mail_welcome']      = 'Vielen Dank fuer ihre Anmeldung bei uns ({gameurl}) \nIhr Passwort : {password}\n\nViel Spass !\n{gameurl} !';
$lang['mail_title']        = 'Anmeldung Erfolgreich';
$lang['thanksforregistry'] = 'Danke fuer ihre Anmeldung! Ihre Daten werden an ihre E-Mail Adresse gesendet.Wenn sie sich einloggen moechten mussen sie ihren Account
                               Freischalten.Dieses erfolgt durch den Aktivierungslink in der E-Mail die sie bekommen!<a href="login.php">Zurueck</a>.';
$lang['sender_message_ig'] = 'Admin';
$lang['subject_message_ig']= 'Willkommen';
$lang['text_message_ig']   = 'Willkommen zu Xnova, 	
Wir wünschen Ihnen schoenes Spiel und viel Erfolg !';


// Errors
$lang['error_mail']        = 'E-Mail Adresse ungueltig !<br />';
$lang['error_planet']      = 'Name des Hauptplaneten nicht moeglich !.<br />';
$lang['error_hplanetnum']  = 'Der Name des Hauptplaneten enthaelt ungultige Satz Zeichen !<br />';
$lang['error_character']   = 'Spielername ungueltig!<br />';
$lang['error_charalpha']   = 'Bitte nur Buchstaben und Zahlen verwenden !<br />';
$lang['error_password']    = 'Das Passwort muss mindestens 4 Zeichen lang sein !<br />';
$lang['error_rgt']         = 'Sie muessen den Regeln und den AGB zustimmen<<br />';
$lang['error_userexist']   = 'Der Spieler exestiert schon !<br />';
$lang['error_emailexist']  = 'Es existiert bereits ein User mit dieser E-Mail Adresse !<br />';
$lang['error_sex']         = 'Ungueltiges Geschlecht !<br />';
$lang['error_mailsend']    = 'Ein Fehler ist beim versenden der E-Mail aufgetreten  das Passwort ist : ';
$lang['reg_welldone']      = 'Registrierung abgeschlossen !';

$lang['a_valider']         = 'Anmeldung beendet!, Sie erhalten eine Bestaetiguns E-Mail mit ihrem Passwort';
$lang['inscription_fini']  = 'Anmeldung beendet! sie koennen ohne Probleme Einloggen';
$lang['Erreur_inscription'] = 'Der Acount ist bereits Aktiviert, oder es wird mit dem selben Spielernamen gespielt.';

// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>