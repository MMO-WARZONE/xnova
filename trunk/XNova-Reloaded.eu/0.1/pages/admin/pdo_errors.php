<?php

/*
 * pdo_errors.php
 *
 * @copyright 2009 by Steggi for xnova-reloaded.de
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);


if ($user['authlevel'] >= 3) {		//Authlevel prüfen

$pfad = "./errors/";	//der Pfad, wo die Logfiles liegen

if (isset($_GET['delete'])) {		//wenn $_GET[delete] gesetzt ist
			$delete = $pfad.htmlentities($_GET['delete']);		//dann basteln wir daraus den Pfad der zu löschenden Datei zusammen
			unlink("$delete");		//und löschen sie.
			AdminMessage ('<meta http-equiv="refresh" content="1; url=?action=administrativeShowPDOerrors">Die Datei wurde gel&ouml;scht', 'L&oum;lschen erfolgreich');	//Anschließende Nachricht mit Weiterleitung
		}


includeLang('admin/pdo_errors');	//Sprachfile includieren
$parse = $lang;

$ausgabe = @opendir($pfad) or die("$pfad konnte nicht gefunden werden");	//falls es den Pfad nicht gibt, gibts nen Error

		while ($datei = htmlentities(readdir($ausgabe)))		//solange es Dateien gibt
			{
				$pfadinfo = pathinfo($pfad."".$datei);
				if(($datei!=".") and ($datei!="..") and ($pfadinfo['extension'] == "txt" ))		//und den hier angegebenen Kriterien entspricht
				{
					$parse['errors_list'] .= "
					<tr>
						<td class=\"n\">
							$pfadinfo[filename]
						</td>
						<td class=\"n\">
							<a href=\"#\" onClick=\"f('$pfad$datei', '');\">$lang[open]</a>
						</td>
						<td class=\"n\">
							<a href=\"?action=administrativeShowPDOerrors&amp;delete=$datei\"><img src=\"images/r1.png\" alt=\"delete\" /></a>
						</td>
					</tr>";
				}		//werden sie ins $parse geschrieben
			}
		
		display(parsetemplate(gettemplate('admin/pdo_errors'), $parse), "PDO Datenbankfehler auflisten", false, '', true);		// und hier ausgegeben
	} else {
		header('Location: indexGame.php');		//wer hier nichts verloren hat, landet wieder auf der indexGame.php
	}
?>