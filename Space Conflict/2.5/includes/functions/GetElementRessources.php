<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** GetElementRessources.php              **
******************************************/

function GetElementRessources ( $Element, $Count ) {
	global $pricelist;

	$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
	$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
	$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
	$ResType['tachyon']   = ($pricelist[$Element]['tachyon']   * $Count);

	return $ResType;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>