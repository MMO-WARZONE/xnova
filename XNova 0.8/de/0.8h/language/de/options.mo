<?php

// Messages
$lang['changue_pass'] 							= 'Passowort ge&auml;ndert';
$lang['Download'] 							= 'Download';
$lang['Search'] 								= 'Suchen';
$lang['succeful_changepass'] 						= 'Passwort erfolgreich ge&auml;ndert.<br /><a href="index.php" target="_self">Weiter</a>';
$lang['succeful_save'] 							= 'Einstellungen erfolgreich ge&auml;ndert.<br /><a href="options.php">Weiter</a>';

// Form
$lang['userdata'] 							= 'Benutzerdaten';
$lang['username'] 							= 'Benutzername';
$lang['lastpassword'] 							= 'Altes Passwort';
$lang['newpassword'] 							= 'Neues Passwort (min. 6 Zeichen)';
$lang['newpasswordagain'] 						= 'Neues Passwort (wiederholen)';
$lang['emaildir'] 							= 'E-Mail Adresse';
$lang['emaildir_tip'] 							= 'Diese Mailadresse kann jederzeit von Dir ge&auml;ndert werden. Nach 7 Tagen ohne &Auml;nderung wird diese auch als permanente Adresse eingetragen.';
$lang['permanentemaildir'] 						= 'Permanente E-Mail Adresse';

$lang['opt_lst_ord']  							= "Planeten sortieren nach";
$lang['opt_lst_ord0'] 							= "Reihenfolge der Entstehung";
$lang['opt_lst_ord1'] 							= "Koordinaten";
$lang['opt_lst_ord2'] 							= "Alphabet";
$lang['opt_lst_cla']  							= "Sortierungsreihenfolge";
$lang['opt_lst_cla0'] 							= "Aufsteigend";
$lang['opt_lst_cla1'] 							= "Absteigend";
$lang['opt_chk_skin'] 							= "Skin anzeigen";

// Admin Options
$lang['opt_adm_title'] 							= "Administator Option";
$lang['opt_adm_planet_prot'] 						= "Angriffsschutz der Admins";

// General options
$lang['thanksforregistry'] 						= 'Vielen Dank f&uuml;r die Registrierung.<br />In ein paar Minuten solltest du eine E-Mail mit deinem Passwort erhalten.';
$lang['general_settings'] 						= 'Generelle Einstellungen';
$lang['skins_example'] 							= 'Grafikpfad (z.B. C:/ogame/bilder/)';
$lang['avatar_example'] 						= 'Avatar (z.B. /img/avatar.jpg)';
$lang['untoggleip'] 							= 'IP-Check deaktivieren';
$lang['untoggleip_tip'] 						= 'IP-Check bedeutet, dass automatisch ein Sicherheitslogout erfolgt, wenn die IP gewechselt wird oder zwei Leute gleichzeitig unter verschiedenen IPs in einem Account eingeloggt sind. 
Den IP-Check zu deaktivieren kann ein Sicherheitsrisiko darstellen!';

// Option galaxy
$lang['galaxyvision_options'] 					= 'Galaxieansicht Einstellungen';
$lang['spy_cant'] 							= 'Spionagesonden Anzahl';
$lang['spy_cant_tip'] 							= 'Anzahl der Spionagesonden, die bei jedem Scan aus dem Galaxiemen&uuml; direkt verschickt wird.';
$lang['tooltip_time'] 							= 'Zeige Tooltip f&uuml;r X';
$lang['mess_ammount_max'] 						= 'Maximale Flottennachrichten';
$lang['show_ally_logo'] 						= 'Allianzlogo Anzeigen';
$lang['seconds'] 								= 'Sekunden';

//Rapport acces
$lang['shortcut'] 							= 'Shortcuts';
$lang['show'] 								= '<a href=fleetshortcut.php target="_blank">Anzeigen</a>';
$lang['write_a_messege'] 						= 'Nachricht schreiben';
$lang['spy'] 								= 'Spionieren';
$lang['add_to_buddylist'] 						= 'Zur Buddyliste hinzuf&uuml;gen';
$lang['attack_with_missile'] 						= 'Raketenangriff';
$lang['show_report'] 							= 'Spionagereport';

//Vacations mod
$lang['delete_vacations'] 						= 'Urlaubsmodus / Account l&ouml;schen';


if ($user['urlaubs_modus_time'] >= time() && $user['urlaubs_modus'] == 0)  {
  $lang['mode_vacations'] 						= 'Urlaubsmodus gesperrt';
}elseif ($user['urlaubs_modus'] ==1) {
  $lang['mode_vacations'] 						= 'Urlaubsmodus Verlassen';
}else{
  $lang['mode_vacations'] 						= 'Urlaubsmodus';
}




$lang['vacations_tip'] 							= 'Der Urlaubsmodus soll euch w&auml;hrend l&auml;ngerer Abwesenheitszeiten sch&uuml;tzen. Man kann ihn nur aktivieren, wenn nichts gebaut (Flotte, Geb&auml;ude oder Verteidigung) und  nichts geforscht wird und auch keine eigenen Flotten unterwegs sind.
Ist er aktiviert, sch&uuml;tzt er euch vor neuen Angriffen, bereits begonnene Angriffe werden jedoch fortgesetzt. W&auml;hrend des Urlaubsmodus wird die Produktion auf Null gesetzt und muss nach Beenden des Urlaubsmodus manuell wieder auf 100% gesetzt werden. Der Urlaubsmodus dauert mindestens 2 Tage, erst danach k&ouml;nnt ihr ihn wieder deaktivieren.';
$lang['deleteaccount'] 							= 'Account l&ouml;schen';
$lang['deleteaccount_tip'] 						= 'Wenn du hier ein H&auml;kchen setzt, wird dein Account nach 7 Tagen automatisch komplett gel&ouml;scht.';
$lang['save_settings'] 							= 'Einstellungen speichern';


// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
// Übersetzt by Dr.Isaacs XNova Team Germany. All rights reversed (C) 2008
?>