<?php
#         #      ##            #     #####    #                   #       ##               ##
 #   #         #   #         #     #         #      #               #       #    #           ##
  #            #      #      #     #         #        #           #       #        #       ##
 #   #        #         #   #      #         #          #      #       ## ## ## ##
#        #      #           ##      #####             ##        #                 ##
#####################################
## allianzadmin.php created by RedFighter                 ######
## Copyright by Xnova-Germany                                  #####
## Final Version: 12.October.2008 // 12.10.08         ####
#################################
## Fehler bitte melden unter folgender URL               ##
## http://www.xnova-germany.de                            ##
##############################

####################################################################
# Überprüft ob $variable eine Zahl ist! Wenn ja gehts nochmal durch Intval, wenn nein wird das Skript abgebrochen #
###################################################################
function IstZahl($variable)
{
	global $lang;
	if(is_numeric($variable)) //Wenn true ...
	{
		$Zahl = intval($variable); // wird die Zahl durch intval() gejagt...
	}
	else // wenn nicht...
	{
		exit($lang['ABORT_DUE_HACKING']); // Skript abgebrochen, da Parameterverfälschung!
	}
	return $Zahl;
}
#############################
# Escaped bestimmte Zeichen aus der Variable! #
############################
function escape($variable)
{
	$Text1 = stripslashes($variable); //Entfernt aus einem gequoteten String alle Quotes (vorbereitung auf mysql_real....()
		//Wieso? => Ist magic_quotes_gpc aktiviert, wenden Sie zuerst stripslashes() auf die Daten an. (Auszug aus mysql_real_escape_string() erklärung)
	$Text2 = htmlspecialchars($Text1); //Wandelt Sonderzeichen in HTML-Codes um
	$Text3 = mysql_real_escape_string($Text2); //Maskiert spezielle Zeichen innerhalb eines Strings für die Verwendung in einer SQL-Anweisung
	$Text4 = ereg_replace(";", " ", $Text3); //Ersetzt in alle ; in der Variable durch ein Leerzeichen. Die Teile haben da nix zu suchen und stellen nur eine Gefajr da!
	$Text5 = ereg_replace("{{table}}", " ", $Text4);//Ohne ein {{table}} kann man in unseren SQL-Anweisungen nicht viel anstellen.
	$Text6 = ereg_replace("--", " ", $Text5); //Gefährliche SQL-Zeichenkette also gleich mal entfernen

	return $Text6; //Escapter String zurückgeben.
}
##################################
# Zählt alle Elemente aus einem Array außer dem ersten! #
#################################
function PakteZaehlen($array) 
{
	foreach($array as $key => $value) {
		if(is_array($value)) {
			$count += PakteZaehlen($value);
		} else {
			if((strlen($value) > 0) && ($value != " ")) {
				$count++;
			}
		}
	}
	return $count;
}
###########################
# Pakte mit der anderen Allianz überprüfen #
##########################
function CheckAllyPakt($SpielerID, $GegnerID) {
	// Schritt 1 - Allianzdaten auslesen!
	$SpielerPakteQuery = doquery("SELECT * FROM {{table}} WHERE `id` = '" . $SpielerID."'", "allianz",true);
	$GegnerPakteQuery  = doquery("SELECT * FROM {{table}} WHERE `id` = '" . $GegnerID ."'", "allianz", true);
	//if($SpielerPakteQuery AND $GegnerPakteQuery) { echo "Geht doch!"; } else { echo "Geht net!"; }
	// Schritt 2 - Allianzpakte entpacken und in einem Array speichern!
	$SpielerPakte = unserialize($SpielerPakteQuery['pakte']);
	$GegnerPakte  = unserialize( $GegnerPakteQuery['pakte']);
	//if($SpielerPakte AND $GegnerPakte) { echo "Geht doch!"; } else { echo "Geht net!"; }
	if($SpielerPakte AND $GegnerPakte) {
		// Schritt 3 - Überprüfen ob ein Pakt mit der anderen Allianz besteht!
		if(array_key_exists($GegnerID, $SpielerPakte)) {
			// Wenn ja = true
			$SpielerTrue = true;
		} else {
			// Wenn nein = false
			$SpielerTrue = false;
		}
		// Schritt 4 - Überprüfen ob andere Allianz ein Pakt mit eigener Allianz hat
		if(array_key_exists($SpielerID, $GegnerPakte) AND $SpielerTrue = true) {
			//Wenn ja = RÜCKGABEWERT = PaktID
			$PaktID        = $SpielerPakte[$GegnerID];
		}
	} else {
		$PaktID        = 0;
	}
	// So, nun wissen wir, ob ein Pakt besteht und welche. Jetzt müssen wir der PakID nurnoch die Pakt-Farbe geben und dann gehts back to the script =)
	//Farbe und ID in array festhalten bzw. definieren.
	$Pakt   = array(0 => "0", 1 => "bnd", 2 => "nap", 3 => "war", 4 => "wing");
	//Und der "RückgabeVariable" die Farbe geben.
	$Return = $Pakt[$PaktID];
	//Und zum Schluß wie gesagt: back to the script;
	return $Return;
	### Created by RedFighter for XNova-Germany ###
}
?>