<?php

function ShowGalaxyFooter ( $Galaxy, $System,  $CurrentMIP, $CurrentRC, $CurrentSP) {
	global $lang, $maxfleet_count, $fleetmax, $planetcount;

	$Result  = "";
	if ($planetcount == 1) {
		$PlanetCountMessage = $planetcount ." ". $lang['gf_cntmone'];
	} elseif ($planetcount == 0) {
		$PlanetCountMessage = $lang['gf_cntmnone'];
	} else {
		$PlanetCountMessage = $planetcount." " . $lang['gf_cntmsome'];
	}
	
	$Recyclers   = pretty_number($CurrentRC);
	$SpyProbes   = pretty_number($CurrentSP);


	$Result .= "";
	$Result .= "<table><tbody>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"295\" colspan=3><span id=\"slots\">". $maxfleet_count ."</span>/". $fleetmax ." ". $lang['gf_fleetslt'] ."</td>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"295\" colspan=2><span id=\"recyclers\">". $Recyclers ."</span> ". $lang['gf_rc_title'] ."</td>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"290\" colspan=2><span id=\"probes\">". $SpyProbes ."</span> ". $lang['gf_sp_title'] ."</td>";
	$Result .= "</tr>";
	$Result .= "<tr style=\"display: none;\" id=\"fleetstatusrow\">";
	$Result .= "<th class=c colspan=8><!--<div id=\"fleetstatus\"></div>-->";
	$Result .= "<table style=\"font-weight: bold\" width=\"90%\" id=\"fleetstatustable\">";
	$Result .= "<!-- will be filled with content later on while processing ajax replys -->";
	$Result .= "</tr></tbody></table>";
	$Result .= "</tr>";
/*
<tr style=\"display: none;\" id=\"fleetstatusrow\"><th colspan="8"><!--<div id="fleetstatus"></div>-->
<table style="font-weight: bold;" width=100% id="fleetstatustable">
<!-- will be filled with content later on while processing ajax replys -->
</table>
</th>
</tr>
*/
	return $Result;
}


function ShowGalaxyFooterlist ( $Galaxy, $System,  $CurrentMIP, $CurrentRC, $CurrentSP) {
	global $lang, $maxfleet_count, $fleetmax, $planetcount;

	$Result  = "";
	if ($planetcount == 1) {
		$PlanetCountMessage = $planetcount ." ". $lang['gf_cntmone'];
	} elseif ($planetcount == 0) {
		$PlanetCountMessage = $lang['gf_cntmnone'];
	} else {
		$PlanetCountMessage = $planetcount." " . $lang['gf_cntmsome'];
	}
	
	$Recyclers   = pretty_number($CurrentRC);
	$SpyProbes   = pretty_number($CurrentSP);


	$Result .= "<table ><tbody>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"180\" colspan=3><span id=\"slots\">". $maxfleet_count ."</span>/". $fleetmax ." ". $lang['gf_fleetslt'] ."&nbsp;</td>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"180\" colspan=2><span id=\"recyclers\">". $Recyclers ."</span> ". $lang['gf_rc_title'] ."&nbsp;</td>";
	$Result .= "<td class=l style=\"font-weight: bold\" height=\"15\" width=\"170\" colspan=2><span id=\"probes\">". $SpyProbes ."</span> ". $lang['gf_sp_title'] ."&nbsp;</td>";
	$Result .= "</tr>";
	$Result .= "<tr style=\"display: none;\" id=\"fleetstatusrow\">";
	$Result .= "<th class=c colspan=8><!--<div id=\"fleetstatus\"></div>-->";
	$Result .= "<table style=\"font-weight: bold\" width=\"90%\" id=\"fleetstatustable\">";
	$Result .= "<!-- will be filled with content later on while processing ajax replys -->";
	$Result .= "</tr></tbody></table>";
	$Result .= "</tr>";
/*
<tr style=\"display: none;\" id=\"fleetstatusrow\"><th colspan="8"><!--<div id="fleetstatus"></div>-->
<table style="font-weight: bold;" width=100% id="fleetstatustable">
<!-- will be filled with content later on while processing ajax replys -->
</table>
</th>
</tr>
*/
	return $Result;
}

?>