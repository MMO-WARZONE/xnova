<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** ShowGalaxyTitles.php                  **
******************************************/

function ShowGalaxyTitles ( $Galaxy, $System ) {
	global $lang;

	$Result  = "\n";
	$Result .= "<tr>";
	$Result .= "<td class=c colspan=8>".$lang['Solar_system']." ".$Galaxy.":".$System."</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td class=c>".$lang['Pos']."</td>";
	$Result .= "<td class=c>".$lang['Planet']."</td>";
	$Result .= "<td class=c>".$lang['Name']."</td>";
	$Result .= "<td class=c>".$lang['Moon']."</td>";
	$Result .= "<td class=c>".$lang['Debris']."</td>";
	$Result .= "<td class=c>".$lang['Player']."</td>";
	$Result .= "<td class=c>".$lang['Alliance']."</td>";
	$Result .= "<td class=c>".$lang['Actions']."</td>";
	$Result .= "</tr>";

	return $Result;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>