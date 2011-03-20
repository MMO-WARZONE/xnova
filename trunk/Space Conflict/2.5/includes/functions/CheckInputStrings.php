<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** CheckInputStrings.php                 **
******************************************/

function CheckInputStrings ( $String ) {
	global $ListCensure;

	$ValidString = $String;
	for ($Mot = 0; $Mot < count($ListCensure); $Mot++) {
		$ValidString = eregi_replace( "$ListCensure[$Mot]", "*", $ValidString );
	}
	return ($ValidString);
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>