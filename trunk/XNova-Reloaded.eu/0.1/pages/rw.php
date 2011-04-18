<?php

/**
 * rw.php
 *
 * @version 1.0
 * @copyright 2008 by ????? for XNova
 */
 
	$open = true;
	// rw Tabelle auslesen
	$rp = $DB->prepare("SELECT * FROM ".PREFIX."rw WHERE `rid` = :raport ;");
	$rp->bindParam(':raport', $_GET['report']);
	$rp->execute();
	$raportrow = $rp->fetch();
	
	$ID1 = $raportrow["id_owner1"];
	$ID2 = $raportrow["id_owner2"];
	
	
	$username1 = $DB->prepare("SELECT `username` FROM ".PREFIX."users WHERE `id` = :id1"); // Username vom Atter auslesen
	$username1->bindParam(':id1', $ID1);
	$username1->execute();
	$username_atter = $username1->fetch();
	
	$username2 = $DB->prepare("SELECT `username` FROM ".PREFIX."users WHERE `id` = :id2"); // Username vom Deffer auslesen
	$username2->bindParam(':id2', $ID2);
	$username2->execute();
	$username_deffer = $username2->fetch();
	

	if (($ID1 == $user["id"]) or
		($ID2 == $user["id"]) or
		 $open) {
		 
		$Page  = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n<html>\n<head>";
		$Page .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$Page .= "<link rel=\"shortcut icon\" href=\"favicon.ico\">";
		$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stylesheed.css\">";
		$Page .= "<title>Kampfbericht ". $username_atter[username] ." vs ". $username_deffer[username]."</title>";
		$Page .= "</head>";
		$Page .= "<body>";
		$Page .= "<center>";
		$Page .= "<table width=\"100%\">";
		$Page .= "<tr>";
		if (($ID1 == $user["id"]) and
			($raportrow["a_zestrzelona"] == 1)) {
			$Page .= "<td>Der Kontakt zu Deiner Flotte ging in der ersten Runde verloren.<br>";
			$Page .= "(Mit anderen Worten: Sie wurde Vernichtet.)</td>";
		} else {
			$Page .= "<td>". stripslashes( $raportrow["raport"] ) ."</td>";
		}
		$Page .= "</tr>";
		$Page .= "</table>";
		$Page .= "</center>";
		$Page .= "</body>";
		$Page .= "</html>";

		echo $Page;
	}

// -----------------------------------------------------------------------------------------------------------
// History version
?>