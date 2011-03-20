<?php

function GalaxyRowPos ( $Planet, $GalaxyRow ) {
	// Pos
	$Result  = "<th width=30>";
	$Result .= "<a href=\"#\"";
	if ($GalaxyRow) {
		$Result .= " tabindex=\"". ($Planet + 1) ."\"";
	}
	$Result .= ">". $Planet ."</a>";
	$Result .= "</th>";

	return $Result;
}

?>