<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

	$open = true;

	$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_escape_string($_GET["raport"]))."';", 'rw', true);

	if (($raportrow["id_owner1"] == $user["id"]) or
		($raportrow["id_owner2"] == $user["id"]) or
		 $open) {
		$Page  = "<html>";
		$Page .= "<head>";
		$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$dpath."/formate.css\">";
		$Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />";
		$Page .= "</head>";
		$Page .= "<body>";
		$Page .= "<center>";
		$Page .= "<table width=\"99%\">";
		$Page .= "<tr>";

		if (($raportrow["id_owner1"] == $user["id"]) and
			($raportrow["a_zestrzelona"] == 1)) {
			$Page .= "<td>Contact with the attacking fleet has been lost.<br>";
			$Page .= "(This means that is was destroyed in the first round.)</td>";
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