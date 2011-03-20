<?php

function IsOfficierAccessible ($CurrentUser, $Officier) {
	global $requeriments, $resource, $pricelist;

	if (isset($requeriments[$Officier])) {
		$enabled = true;
		foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel) {
			if ($CurrentUser[$resource[$ReqOfficier]] &&
				$CurrentUser[$resource[$ReqOfficier]] >= $OfficierLevel) {
				$enabled = 1;
			} else {
				return 0;
			}
		}
	}
	if ($CurrentUser[$resource[$Officier]] < $pricelist[$Officier]['max']  ) {
		return 1;
	} else {
		return -1;
	}
}
?>