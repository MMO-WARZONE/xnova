<?php

/**
 * install.mo
 *
 * @version 0.5
 * @copyright 2008
 * @ueberarbeitet Metusalem 20062009
 */

$lang['ins_appname']      = "CMS Installations Version von<a href=\"http://www.xnova-reloaded.de\" target=\"_blank\"> XNova</a>";
$lang['ins_tx_state']     = "Schritt";
$lang['ins_tx_sys']       = "Management System";
$lang['ins_btn_next']     = "Weiter";
$lang['ins_btn_inst']     = "Installieren";
$lang['ins_btn_creat']    = "Erstellen";
$lang['ins_btn_login']    = "Anmelden";
$lang['ins_btn_prev']     = "Voherige";

$lang['ins_mnu_intro']    = "Einleitung";
$lang['ins_mnu_inst']     = "Installation";
$lang['ins_mnu_goto']     = "Upgrade";
$lang['ins_mnu_upgr']     = "Update";
$lang['ins_mnu_quit']     = "Beenden";

$lang['ins_error']        = "Fehler";
$lang['ins_error1']       = "Die Verbindung zur Datenbank ist fehlgeschlagen";
$lang['ins_error2']       = "Die config.php wurde nicht ersetzten";

$lang['ins_tx_welco']     = "<p align=\"center\"><strong>Willkommen zur CMS Version von XNova.</strong></p>
<p align=\"center\"><strong>Mit diesem Assistenten koennen Sie ihr Spiel ganz einfach Installieren und das erste Administrator-Konto erstellen..</strong></p>
<p align=\"center\"><strong>XNova ist ein...<a href=\"http://de.wikipedia.org/wiki/Open_Source\" target=\"_blank\">OPEN SOURCE...</a>Projekt...<a href=\"http://creativecommons.org/licenses/by-nc/3.0/de/\" target=\"_blank\">Mit diesen Lizensbedingungen von Creative Common.</a></strong></p>
<p align=\"center\"><strong>Das bedeutet, das das Loeschen der Links und das Endfernen des Copyrights  eine Straftat und eine Verletzung der Lizensbedingungen ist.</strong></p>
<p align=\"center\"><strong>Nachdem sie dieses jetzt gelesen haben wuenschen wir ihnen eine erfolgreiche Installation und viel Spielspass mit XNova.</strong></p>";
$lang['ins_tx_intr1']     = "Das Projekt XNova ist, ein Klon der schon fast perfekt ist.";
$lang['ins_tx_intr2']     = "Das Projekt XNova ist kostenlos und OpenSource. Bitte nicht fuer die kommerzielle Nutzung verwenden.";
$lang['ins_tx_intr3']     = "Aus Respekt von den XNova Teams, werden Sie gebeten, nicht die Copyright-Quelldaten zu loeschen.";
$lang['ins_tx_inst1']     = "Bitte setzen die bei config.php die schreib rechte CHMOD 777";
$lang['ins_tx_inst2']     = "Sie benoetigen eine MySQL-Datenbank";
$lang['ins_tx_inst3']     = "Fuellen Sie das folgende Formular korrekt fuer die Installation aus:";
$lang['ins_tx_acc1']      = "Sie sind im Begriff, einen Administrator-Account zu erstellen.";
$lang['ins_tx_acc2']      = "Fuellen Sie das folgende Formular mit den Daten des Administrator Kontos aus:";
$lang['ins_tx_goto1']     = "Bei der Auswahl dieser Installations-metode, wird eine Umwandlung von den Daten von UGamela in die Datenbank von XNova Intregiert.";
$lang['ins_tx_goto2']     = "Diese Option funktioniert, aber es waere doch besser, eine vollstaendige Installation von XNova durchzufueren.";
$lang['ins_tx_goto3']     = "Sie gehen ein Risiko durch die Umwandlung Ihrer Datenbank ein, sichern sie zuvor ihre alte Datenbank!.";
$lang['ins_tx_goto4']     = "Sie muessen bereits UGamela installiert haben!.";
$lang['ins_tx_goto5']     = "Fuellen Sie das folgende Formular mit den genauen Informationen der Datenbank aus wo UGamela installiert wurde:";
$lang['ins_tx_done1']     = "Die Basis Installation wurde abgeschlossen!.";
$lang['ins_tx_done2']     = "Das Administrator-Konto wurde erfolgreich erstellt!";
$lang['ins_tx_done3']     = "Es wird empfohlen, den Ordner <i> install </i> zu loeschen, wenn Sie ihn nicht mehr benoetigen!.";
$lang['ins_tx_done4']     = "Die Uebertragung wurde erfolgreich durchgefuehrt!.";

$lang['ins_form_server']  = "SQL Server";
$lang['ins_form_db']      = "Datenbank";
$lang['ins_form_prefix']  = "Prefix";
$lang['ins_form_login']   = "DB Login";
$lang['ins_form_pass']    = "DB Passwort";
$lang['ins_form_install'] = "Installieren";

$lang['ins_acc_user']     = "Name";
$lang['ins_acc_pass']     = "Passwort";
$lang['ins_acc_email']    = "E-Mail Adresse";
$lang['ins_acc_planet']   = "Hauptplaneten Name";
$lang['ins_acc_sex']      = "Geschlecht";
$lang['ins_acc_sex0']     = "Keine Angaben";
$lang['ins_acc_sex1']     = "Maennlich";
$lang['ins_acc_sex2']     = "Weiblich";

//Bono entre en sc&egrave;ne avec sa r&eacute;volution du setup !
$lang['txt_1'] = "<p>Herzlich Willkommen zu der CMS XNova Installation .<br>Dieser Assistent erlaubt ihnen eine einfache Server Installation.<br>
Bei Fragen oder Problemen wenden sie sich bitte an das Forum!.";
$lang['txt_2'] = "<p>Bei dieser Installatin muss die <i>config.php</i> <u>umbedingt auf </u> \"CHMOD 777\" gesetzt sein!.";
$lang['txt_3'] = "Adresse des MySQL Servers!.";
$lang['txt_4'] = "Name der Datenbank!.";
$lang['txt_5'] = "<p>Bitte hier den Datenbank Login Namen sowie  das Datenbank Passwort eingeben!.<br>Tip!:Der Login ist meistens der gleiche wie der Datenbank Name.";
$lang['txt_6'] = "Hier geben sie bitte den Prefix an zb: game_ oder rocketxnova_";

$lang['create_aks'] = "Erzeuge Tabelle \"aks\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_annonce'] = "Erzeuge Tabelle\"annonce\"........<b><font color=\"lime\">Erfolgreich !</font></b>";		
$lang['create_alliance'] = "Erzeuge Tabelle \"alliance\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_banned'] = "Erzeuge Tabelle  \"banned\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_buddy'] = "Erzeuge Tabelle  \"buddy\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_chat'] = " Erzeuge Tabelle \"chat\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_config'] = "Erzeuge Tabelle  \"config\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['populate_config'] = "Schreibe Inhalt \"config\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_declared'] = "Erzeuge Tabelle  \"declared\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_errors'] = "Erzeuge Tabelle  \"errors\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_fleets'] = "Erzeuge Tabelle  \"fleets\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_galaxy'] = "Erzeuge Tabelle  \"galaxy\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_iraks'] = "Erzeuge Tabelle  \"iraks\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_lunas'] = "Erzeuge Tabelle  \"lunas\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_messages'] = "Erzeuge Tabelle  \"messages\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_notes'] = "Erzeuge Tabelle  \"notes\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
 $lang['create_planets'] = "Erzeuge Tabelle  \"planets\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_rw'] = "Erzeuge Tabelle  \"rw\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_statpoints'] = "Erzeuge Tabelle  \"statpoints\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_users'] = "Erzeuge Tabelle  \"users\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
$lang['create_multi'] = "Erzeuge Tabelle  \"multi\"........<b><font color=\"lime\">Erfolgreich !</font></b>";
?>