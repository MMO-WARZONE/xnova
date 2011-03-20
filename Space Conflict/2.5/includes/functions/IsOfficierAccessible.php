<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** IsOfficierAccessible.php              **
******************************************/

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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>