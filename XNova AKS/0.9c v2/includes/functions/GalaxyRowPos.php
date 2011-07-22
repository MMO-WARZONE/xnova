<?php

/**
 * GalaxyRowPos.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function GalaxyRowPos ( $GalaxyRow, $Galaxy, $System, $Planet ) {
	// Pos
	$Result  = "<th width=30>";
    $Result .= "<a href=\"fleet.php?galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=0&target_mission=7\"";
	if ($GalaxyRow) {
		$Result .= " tabindex=\"". ($Planet + 1) ."\"";
	}
	$Result .= ">". $Planet ."</a>";
	$Result .= "</th>";

	return $Result;
}

?>