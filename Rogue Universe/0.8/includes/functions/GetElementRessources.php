<?php

function GetElementRessources ( $Element, $Count ) {
	global $pricelist;

	$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
	$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
	$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);

	return $ResType;
}
?>