<?php

/**
 * install.mo
 *
 * @version 0.5
 * @copyright 2008
 * // Übersetzt by Dr.Isaacs XNova Team Germany. All rights reversed (C) 2008
 */

$lang['ins_appname']      = "XNova-Reloaded";
$lang['ins_tx_state']     = "Schritt";
$lang['ins_tx_sys']       = "Installer";
$lang['ins_btn_next']     = "Weiter";
$lang['ins_btn_back']     = "Zur&uuml;ck";
$lang['ins_btn_retry']    = "Wiederholen";
$lang['ins_btn_inst']     = "Installieren";
$lang['ins_btn_creat']    = "Erstellen";
$lang['ins_btn_login']    = "Anmelden";
$lang['ins_btn_prev']     = "Vorige";

$lang['ins_mnu_intro']    = "Einleitung";
$lang['ins_mnu_inst']     = "Neu Installation";
$lang['ins_mnu_goto']     = "Daten Transfer";
$lang['ins_mnu_upgr']     = "Update";
$lang['ins_mnu_quit']     = "Beenden";

$lang['ins_error']        = "Fehler";
$lang['ins_error1']       = "Die Verbindung zur Datenbank ist fehlgeschlagen";
$lang['ins_error2']       = "Die Datei config.php nicht ersetzten";

$lang['ins_tx_welco']     = "Willkommen bei der Installation von XNova-Reloaded<br><br>XNova-Reloaded ist in Browsergame, dass im Weltraum spielt.<br>Es ist kostenlos, OpenSource und unterliegt dem GPL Lizenzvertrag<br>(siehe: <a href=\"http://www.gnu.org/licenses/gpl.html\" target=\"_blanc\">http://www.gnu.org/licenses/gpl.html</a>)<br> Du hast somit das Recht den Quellcode zu &auml;ndern und nach Deinen W&uuml;nschen anzupassen.<br>";
$lang['ins_tx_intr1']     = "Aus Respekt von den Proggern, Grafikern und allen anderen, die zu diemsem Projekt<br>beigetragen haben, bitten wir Dich, dass Copyright in den Scripten nicht zu l&ouml;schen.<br>";
$lang['ins_tx_intr2']     = "Bevor Du XNova-Reloaded installieren kannst, gebe dem Ordner \"install\"<br>und der Datei \"\\pages\\config.php\" die Schreibrechte CHMOD 777<br>";
$lang['ins_tx_intr3']     = "Im n&auml;chsten Schritt wird der Installer Deinen Server &uuml;berpr&uuml;fen. Eventuell auftretende<br>Fehler m&uuml;ssen vor dem Fortsetzen der Installation behoben werden.<br><br> Klicke auf \"Weiter\" um mit der Installation zu starten.";

$lang['check_server']			= "&Uuml;berpr&uuml;fe den Server...";
$lang['check_php']				= "PHP-Version: ";
$lang['check_mysql']			= "MySQL-Version: ";
$lang['check_config']			= "config.php beschreibbar: ";
$lang['check_installer_dir']	= "install Verzeichniss beschreibbar: ";
$lang['check_savemode']			= "PHP Save-mode deaktiviert: ";
$lang['check_ok']				= "Dein Server erf&uuml;llt alle Bedingungen. Setze die Installation mit einem Klick auf \"Weiter\" fort.";
$lang['check_error']			= "Es sind nicht alle Bedingungen erf&uuml;llt. Behebe die obrigen Fehler, und klicke <br>anschlie&szlig;end auf \"Wiederholen\" um die &Uuml;berpr&uuml;fung erneut zu starten.";



$lang['ins_tx_inst1']     = "Du ben&ouml;tigst f&uuml;r die Installation eine MySQL oder PostgreSQL(experimentell) Datenbank.";
$lang['ins_tx_inst2']     = "Gebe im folgenden Formular die Zugangsdaten f&uuml;r die Datenbank ein.";
$lang['ins_tx_inst3']     = "Klicke anschlie&szlig;end auf \"Installieren\" um die Datenbank anzulegen.";

$lang['ins_tx_acc1']      = "F&uuml;lle das folgende Formular mit den Daten f&uuml; den Administrator Account aus.<br>Klicke anschlie&szlig;end auf \"Weiter\"";

$lang['ins_tx_done1']     = "Die Basis Insterllation wurde abgeschlossen!";
$lang['ins_tx_done2']     = "Der Administrator Account wurde erfolgreich erstellt!";
$lang['ins_tx_done3']     = "Der Ordner \"install\" wird nun vom Installer mit einer .htaccess vor Zugriff gesch&uuml;tzt.<br> Alternativ kannst Du ihn auch l&ouml;schen wenn Du ihn nicht mehr ben&ouml;tigst.";
$lang['ins_tx_done4']     = "Die &Uuml;bertragung wurde erfolgreich durchgef&uuml;hrt!";

$lang['ins_form_server']  = "SQL Server";
$lang['ins_form_db']      = "Datenbankname";
$lang['ins_form_prefix']  = "Prefix";
$lang['ins_form_login']   = "DB Login";
$lang['ins_form_pass']    = "DB Passwort";
$lang['ins_form_install'] = "Insterllieren";

$lang['ins_acc_user']     = "Name";
$lang['ins_acc_pass']     = "Passwort";
$lang['ins_acc_email']    = "E-Mail Adresse";
$lang['ins_acc_planet']   = "Hauptplaneten Name";

$lang['ins_tx_conf_universe']				= "Kofiguiere nun das Universum. Es werden bereits einige default Werte vorgegeben, aber es bleibt nat&uuml;rlich Dir &uuml;berlassen,<br>diese anzupassen ;-) Alles was Du hier einstellst kannst du sp&auml;ter im Adminpanel unter \"Einstellungen\" auch wieder &auml;ndern.<br>Um Fehler zu vermeiden solltest du aber z.B Werte wie die Gr&ouml;&szlig;e der Galaxien und Systeme im Nachhinein nicht mehr verringern!";
$lang['ins_conf_email']		   = "Absender f&uuml;r Reg und PW vergessen E-Mails";
$lang['ins_conf_max_galaxy_in_world']		= "Galaxien im Universum";
$lang['ins_conf_max_system_in_galaxy']		= "Systeme pro Galaxie";
$lang['ins_conf_max_planet_in_system']		= "Planeten pro System";
$lang['ins_conf_spy_report_row']				= "Zeilen im Spionagebericht";
$lang['ins_conf_fields_by_moonbasis_level']	= "Felder pro Stufe der Mondbasis";
$lang['ins_conf_max_player_planets']			= "Max Planeten pro Spieler";
$lang['ins_conf_max_building_queue_size']	= "Gr&ouml;&szlig;e der Bauschleife bei Geb&auml;uden";
$lang['ins_conf_max_fleet_or_defs_per_row']	= "Gr&ouml;&szlig;e der Bauschleife bei Flotten und Verteidigung";
$lang['ins_conf_max_overflow']				= "Lager&uuml;berf&uuml;llung (1.0 == 100 % 1.1 == 110% usw)";
$lang['ins_conf_base_storage_size']			= "Basisgr&ouml;&szlig;e der Lager";
$lang['ins_conf_build_metal']				= "Metall auf neuen Planeten";
$lang['ins_conf_build_cristal']				= "Kristall auf neuen Planeten";
$lang['ins_conf_build_deuterium']			= "Deuterium auf neuen Planeten";



?>