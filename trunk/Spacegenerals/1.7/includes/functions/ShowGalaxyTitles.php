<?php

/**
 * ShowGalaxyTitles.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxyTitles ( $Galaxy, $System ) {
	global $lang;

	$Result  = "\n";
	$Result .= "<tr>";
	$Result .= "<td class=c colspan=10>".$lang['Solar_system']." ".$Galaxy.":".$System."&nbsp;</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td class=c align=center>".$lang['Pos']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Planet']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Name']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Moon']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Debris']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['aava']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Player']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Alliance']."&nbsp;</td>";
	$Result .= "<td class=c align=center>".$lang['Actions']."&nbsp;</td>";
	$Result .= "</tr>";

	return $Result;
}
?>