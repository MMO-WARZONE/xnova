<?php

function GalaxyRowava ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user;

	$Result  = "<th width=30>";
	if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
		if       ($GalaxyRowUser['bana'] == 1 AND
				  $GalaxyRowUser['urlaubs_modus'] == 1) {
			$Systemtatus2 = $lang['vacation_shortcut']." <a href=\"banned.php\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
			$Systemtatus  = "<span class=\"vacation\">";
		
		} else {
			$Systemtatus2 = "";
			$Systemtatus  = "";
		}

				$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table width=190>";
		if ($GalaxyRowUser['id'] != $user['id']) {
		}
		$Result .= " onmouseout='return nd();'>";
		 $Result .= "<img src=".    $GalaxyRowUser['avatar'] ." height=30 width=30>"; 
        $Result .= "</a>"; 


	}
	$Result .= "</th>";

	return $Result;
}
?>