<?php
$lang['Version']     = 'Version';
$lang['Description'] = 'Beschreibung';
$lang['CHANGELOG_TITLE'] = "Change Log";
$lang['changelog']   = array(

'<font color="red">Team</font>' => '<font color="yellow">MMOGbay.com Team Members</font>
Mori - Erweiterungen und Fixe
Inforcer - Grafik, PR und Delegation
col_burton - Codeoptimierung & Codebasing
Pudel - Mod Entwickling
Sycrog - Codebasing
<font color="yellow">Forum & Showcase Game Team</font>
Krixli - General Administrator SpaceGenerals.com
<font color="yellow">International Language Team</font>
Hoegarden31 - Dutch, French, English
Inforcer - English, German, Greek
Jenny - Polish, German, Russian
<font color="yellow">Wir danken:</font>
Steggi - meikel - cookie - Slaver - etic_wum - Metusalem - mwieners - Perry - xire',

'<font color="lime">1.8 alpha</font>' => 'MMOGbay.com Team
- FIX: Multiple post-RC7 Fixe
- FIX: Mondentstehung
- FIX: Mondzerstörung
- FIX: Galaxieansicht
- DIV: Neues Layout
- DIV: Copyrightfreie Grafiken
- FIX: Aufgegebene Planeten werden wieder kolonisierbar',

'' => '<font color="green">RocketNova 1.0 RC7 ist nun SpaceGenerals 1.7</font>',


'1.0 RC7' => 'Team Rocket
- FIX: Multiple post-RC6 Fixe
-- includes/functions.php
--- added function Nr2Str()
--- added function str_makerand()
-- admin/
--- included a check before writing to log file to avoid warnings
-- includes/functions/SendNewPassword.php
--- changed password generation
-- include/functions/ResearchBuildingsPage.php
--- replaced all strchr checks with one preg_match
- FIX: Inaktive in allen AZ angreifbar
- FIX: Flugzeiten Bug
- FIX: SQL Fix in Planeten bearbeiten
- FIX: Offiziersbonus Spion und Kommandant
- DIV: S&auml;mtliche Textausgaben nun 100% in .mo
- DIV: Neue .mo erstellt, Umwandlung in UTF-8
- DIV: Mehrsprachigkeit vorbereitet',

'1.0 RC6' => 'Team Rocket
- DIV: Energiebonus in Wirtschaft bei Energietechnik und Ingenieur
- FIX: Admin kann nun automatisch gesperrte User entsperren
- MOD: Playercard 3.0
- MOD: Galaxy 2.0
- MOD: Techtree 2.0
- DIV: Skin überarbeitet
- FIX: Flottenpunkte in StatBuilder
- FIX: Strings in Ally Rundmail',

'1.0 RC5' => 'Team Rocket
- FIX: Multiple post-RC4 Fixe
- MOD: Galaxy 2.0
- MOD: Playercard 2.0
- FIX: Jumpgate Fix
- FIX: Planetlist & Moonlist
- DIV: Template Power update
- FIX: Ressz&auml;hler nun durchgehend 1 Punkt pro 1.000 verbaute Ress, ausser Deuterium',

'1.0 RC4' => 'Team Rocket
- FIX: Multiple post-RC3 Fixe
- FIX: Wirtschaft und Topnav Ressz&auml;hler nun synchron
- FIX: Energiequellen werden nun richtig ber&uuml;cksichtigt
- FIX: Energiebug (nur ein Kraftwerk und trotzdem 100% Produktion) behoben
- FIX: Playercard zeigt nun richtige Werte
- FIX: Galaxie Cache Fehler behoben
- FIX: Nachrichtenmen&uuml; und Maske werden wieder richtig angezeigt
- FIX: Magic Quotes und Register Globals (php.ini) werden nun lokal unterbunden, per .htaccess
- FIX: Allianzen R&auml;nge k&ouml;nnen wieder umbenannt und gel&ouml;scht werden
- FIX: Planetennamen k&ouml;nnen nur noch A-Z und 0-9 enthalten
- FIX: Planetensuche verbessert
- FIX: Planeten k&ouml;nnen wieder umbenannt und gel&ouml;scht werden',

'1.0 RC3' => 'Team Rocket
- MOD: Angriffszonen eingebaut (AZ 1 - 50, KS Interaktion nur noch +/- 2 AZ)
- MOD: Wirtschaft zeigt nun wieviele Schiffe / Deff man t&auml;glich, w&ouml;chentlich und monatlich bauen k&ouml;nnte
- FIX: Minus Ress Bug
- FIX: Spionage Bug
- FIX: Energie Bug (Produktion ohne Energie)
- FIX: Offizier Bug (Offiziere wurden teilweise nicht ber&uuml;cksichtigt in Wirtschaft)
- MOD: Admin, SGO, GO online werden angezeigt
- FIX: Ressourcen Verteilung im KS
- DIV: Galaxieansicht auf Netbook Aufl&ouml;sung angepasst
- DIV: Rechtschreibfehler behoben
- FIX: Raiderpunkte zur Funktion gebracht
- MOD: IP Bann System steuerbar im Adminpanel
- FIX: [Post RC 2] wing.php nicht mehr anf&auml;llig f&uuml;r SQL Injects
- DIV: Flugzeiten realistischer gestaltet (R&uuml;ckkehr)
- FIX: Bewerbungstext, Allianzen abgeben, $_post/$_GET abfragen abgesichert
- DIV: Templates &uuml;berarbeitet
- DIV: Neue Bilder f&uuml;r Geb&auml;ude, Forschung, Schiffe und Verteidigung (um Multilinguale Versionen zu erm&ouml;glichen)
- DIV: Template Power Klassen Update auf PHP5
- DIV: Javascripts geupdated
- DIV: Hall of Fame an neues KS angepasst
- FIX: Datenbank Optimierungen
- FIX: Verschiedene kleinere Bugfixes',

'1.0 RC2' => 'Team Rocket
- MOD: Umbennenung des Root-paths
- DIV: Favicon angepasst
- DIV: Ordner Umbennenungen
- MOD: Cache Control
- MOD: Sessions eingebunden
- MOD: Template Power eingebunden
- FIX: Schutz vor unregestrierten Usern
- FIX: Diverse Fixes bei den flotten.php Dateien
- FIX: SQL-Injections verhindert
- MOD: IP Bann System (automatisches Bannen beim Cheatversuch)
- MOD: Neues Koloniescript',

'1.0 RC1' => 'Inforcer
- MOD: Changed look and feel to match SpaceInvasion
- MOD: Final artworks
- MOD: Modified Installer and surrounding peripheral functions to match the new GDI
- DIV: Added FlashChat
- MOD: Added user base compatibility to connect to Subdreamer CMS and SMF 2.x Forums
- FIX: Enhanced resources.php
- MOD: Added Alliance Diplomacy
- FIX: Added Alliance Diplomacy SQL inserts to Installer
- MOD: Added Support Ticket system
- MOD: Added IP Match declaration system
- MOD: Added Hall of Fame with avatar display
- MOD: Added FightSim based on used war engine
- MOD: Added calculator to preview costs for Buildings, Research, Fleet and Defense
- DIV: Added comprehensive tutorial
- DIV: Added links to image hosting and email/SMS service',

);

?>