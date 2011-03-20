<?php

function GetMissileRange () {
	global $resource, $user;

	if ($user[$resource[117]] > 0) {
		$MissileRange = ($user[$resource[117]] * 5) - 1;
	} elseif ($user[$resource[117]] == 0) {
		$MissileRange = 0;
	}

	return $MissileRange;
}
?>