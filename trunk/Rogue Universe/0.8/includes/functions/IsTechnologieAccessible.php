<?php

function IsTechnologieAccessible($user, $planet, $Element) {
	global $requeriments, $resource;

	if (isset($requeriments[$Element])) {
		$enabled = true;
		foreach($requeriments[$Element] as $ReqElement => $EleLevel) {
			if (@$user[$resource[$ReqElement]] && $user[$resource[$ReqElement]] >= $EleLevel) {
				// break;
			} elseif ($planet[$resource[$ReqElement]] && $planet[$resource[$ReqElement]] >= $EleLevel) {
				$enabled = true;
			} else {
				return false;
			}
		}
		return $enabled;
	} else {
		return true;
	}
}
?>