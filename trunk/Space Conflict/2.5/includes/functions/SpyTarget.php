<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** SpyTarget.php                         **
******************************************/

function SpyTarget ( $TargetPlanet, $Mode, $TitleString ) {
	global $lang, $resource;

	$LookAtLoop = true;
	if       ($Mode == 0) {
		$String  = "<table width=\"440\"><tr><td class=\"c\" colspan=\"5\">";
		$String .= $TitleString ." ". $TargetPlanet['name'];
		$String .= " <a href=\"galaxy.php?mode=3&galaxy=". $TargetPlanet["galaxy"] ."&system=". $TargetPlanet["system"]. "\">";
		$String .= "[". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."]</a>";
		$String .= " le ". gmdate("d-m-Y H:i:s", time() + 2 * 60 * 60) ."</td>";
		$String .= "</tr><tr>";
		$String .= "<td width=220>". $lang['Metal']     ."</td><td width=220 align=right>". pretty_number($TargetPlanet['metal'])      ."</td><td>&nbsp;</td>";
		$String .= "<td width=220>". $lang['Crystal']   ."</td></td><td width=220 align=right>". pretty_number($TargetPlanet['crystal'])    ."</td>";
		$String .= "</tr><tr>";
		$String .= "<td width=220>". $lang['Deuterium'] ."</td><td width=220 align=right>". pretty_number($TargetPlanet['deuterium'])  ."</td><td>&nbsp;</td>";
		$String .= "<td width=220>". $lang['Tachyon']   ."</td><td width=220 align=right>". pretty_number($TargetPlanet['tachyon'])         ."</td>";
		$String .= "</tr><tr>";
		$String .= "<td width=220>". $lang['Energy']    ."</td><td width=220 align=right>". pretty_number($TargetPlanet['energy_max']) ."</td><td>&nbsp;</td>";
		$String .= "<td>&nbsp;</td><td>&nbsp;</td>";
		$String .= "</tr>";
		$LookAtLoop = false;
	} elseif ($Mode == 1) {
		$ResFrom[0] = 200;
		$ResTo[0]   = 299;
		$Loops      = 1;
	} elseif ($Mode == 2) {
		$ResFrom[0] = 400;
		$ResTo[0]   = 499;
		$ResFrom[1] = 500;
		$ResTo[1]   = 599;
		$Loops      = 2;
	} elseif ($Mode == 3) {
		$ResFrom[0] = 1;
		$ResTo[0]   = 99;
		$Loops      = 1;
	} elseif ($Mode == 4) {
		$ResFrom[0] = 100;
		$ResTo[0]   = 199;
		$Loops      = 1;
	}

	if ($LookAtLoop == true) {
		$String  = "<table width=\"440\" cellspacing=\"1\"><tr><td class=\"c\" colspan=\"". ((2 * SPY_REPORT_ROW) + (SPY_REPORT_ROW - 1))."\">". $TitleString ."</td></tr>";
		$Count       = 0;
		$CurrentLook = 0;
		while ($CurrentLook < $Loops) {
			$row     = 0;
			for ($Item = $ResFrom[$CurrentLook]; $Item <= $ResTo[$CurrentLook]; $Item++) {
				if ( $TargetPlanet[$resource[$Item]] > 0) {
					if ($row == 0) {
						$String  .= "<tr>";
					}
					$String  .= "<td align=left>".$lang['tech'][$Item]."</td><td align=right>".$TargetPlanet[$resource[$Item]]."</td>";
					if ($row < SPY_REPORT_ROW - 1) {
						$String  .= "<td>&nbsp;</td>";
					}
					$Count   += $TargetPlanet[$resource[$Item]];
					$row++;
					if ($row == SPY_REPORT_ROW) {
						$String  .= "</tr>";
						$row      = 0;
					}
				}
			}

			while ($row != 0) {
				$String  .= "<td>&nbsp;</td><td>&nbsp;</td>";
				$row++;
				if ($row == SPY_REPORT_ROW) {
					$String  .= "</tr>";
					$row      = 0;
				}
			}
			$CurrentLook++;
		} 
	}
	$String .= "</table>";

	$return['String'] = $String;
	$return['Count']  = $Count;
	return $return;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>