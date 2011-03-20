<?php

function MessageForm ($Title, $Message, $Goto = '', $Button = ' ok ', $TwoLines = false) {
	$Form  = "<center>";
	$Form .= "<form action=\"". $Goto ."\" method=\"post\">";
	$Form .= "<table width=\"519\">";
	$Form .= "<tr>";
		$Form .= "<td class=\"c\" colspan=\"2\">". $Title ."</td>";
	$Form .= "</tr><tr>";
	if ($TwoLines == true) {
		$Form .= "<th colspan=\"2\">". $Message ."</th>";
		$Form .= "</tr><tr>";
		$Form .= "<th colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"". $Button ."\"></th>";
	} else {
		$Form .= "<th colspan=\"2\">". $Message ."<input type=\"submit\" value=\"". $Button ."\"></th>";
	}
	$Form .= "</tr>";
	$Form .= "</table>";
	$Form .= "</form>";
	$Form .= "</center>";

	return $Form;
}

?>