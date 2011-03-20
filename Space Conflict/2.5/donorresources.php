<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donorresources.php                    **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
include($xnova_root_path . 'includes/donorvars.' . $phpEx);
	$TargetPlanet = $user['current_planet'];
	$TargetUser   = $user['id'];
	$AvailPoints  = $user['rpg_points'];
	$PlanetName   = $planetrow['name'];
	$PlayerName   = $user['username'];
	$mode         = $_POST['mode'];	

if ($mode == 'addit') {
	if (($_POST['metal'] < 0) || ($_POST['crystal'] < 0) || ($_POST['deuterium'] < 0) || ($_POST['tachyon'] < 0)) {
		AdminMessage ( "Invalid Value", "Filthy Cheater" );
	} else {

	$id			= $TargetPlanet;
	$player			= $TargetUser;
	$metal			= $_POST['metal'];
	$crystal		= $_POST['crystal'];
	$deuterium		= $_POST['deuterium'];
	$tachyon		= $_POST['tachyon'];
   	$TotalCost = (($metal			* $donorcost['996'])
			+($crystal		* $donorcost['997'])
			+($deuterium		* $donorcost['998'])
			+($tachyon		* $donorcost['999']));

		if ($TotalCost <= $AvailPoints) {
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = `metal` + '". ($metal * 5000000) ."', ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + '". ($crystal * 5000000) ."', ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". ($deuterium * 5000000) ."', ";
			$QryUpdatePlanet .= "`tachyon` = `tachyon` + '". ($tachyon * 5000000) ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			$QryUpdateUser		= "UPDATE {{table}} SET ";
			$QryUpdateUser		.= "`rpg_points` = `rpg_points` - '". $TotalCost ."' ";
			$QryUpdateUser		.= "WHERE ";
			$QryUpdateUser		.= "`id` = '". $player ."' ";
			doquery( $QryUpdateUser, "users");			
	
			AdminMessage ( "Resources Purchased", "Purchase Resources" );
		} else {
			AdminMessage ( "Not Enough Dark Matter", "Not Enough Dark Matter" );
		}	
	}			
}

	$Page .= "<br><br><h2>Donor Store</h2>";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=3>Donor Store</td></tr>";
	$Page .= "<tr><th width=33%><font color=skyblue> ".$PlayerName."</font></th>";
	$Page .= "<th width=33%><font color=skyblue> ".$PlanetName."</font></th>";
	$Page .= "<th width=33%><font color=skyblue> ".$AvailPoints."</font> DM</th></tr>";
	$Page .= "</tbody></table>";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<tr><td class=c><div align=center><a href=\"donorresources.php\"><font color=lime>Resources</font></a></div></td>";
	$Page .= "<td class=c><div align=center><a href=\"donorships.php\"><font color=lime>Ships</font></a></div></th>";
	$Page .= "<td class=c><div align=center><a href=\"donordefenses.php\"><font color=lime>Defenses</font></a></div></td></tr>";
	$Page .= "<tr><td class=c><div align=center><a href=\"donorbuildings.php\"><font color=lime>Buildings</font></a></div></td>";
	$Page .= "<td class=c><div align=center><a href=\"donorresearch.php\"><font color=lime>Research</font></a></div></td>";
	$Page .= "<td class=c><div align=center><a href=\"donorspecial.php\"><font color=red>Special Items</font></a></div></td></tr>";
	$Page .= "</tbody></table>";
	$Page .= "<form action=donorresources.php method=post><input type=\"hidden\" name=\"mode\" value=\"addit\">";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=4>Purchase Resources</td></tr>";
	$Page .= "<tr><th>Cost</th><th>Resource Name</th><th>Quantity</th><th>Current</th></tr>";
	$Page .= "<tr><th>".$donorcost['996']."</th><th>".$donorname['996']." x5M</th><th><input name=".$donorid['996']." type=text value=0></th><th>".floor($planetrow[$donorid['996']])."</th></tr>";
	$Page .= "<tr><th>".$donorcost['997']."</th><th>".$donorname['997']." x5M</th><th><input name=".$donorid['997']." type=text value=0></th><th>".floor($planetrow[$donorid['997']])."</th></tr>";
	$Page .= "<tr><th>".$donorcost['998']."</th><th>".$donorname['998']." x5M</th><th><input name=".$donorid['998']." type=text value=0></th><th>".floor($planetrow[$donorid['998']])."</th></tr>";
	$Page .= "<tr><th>".$donorcost['999']."</th><th>".$donorname['999']." x5M</th><th><input name=".$donorid['999']." type=text value=0></th><th>".floor($planetrow[$donorid['999']])."</th></tr>";
	$Page .= "<tr><th colspan=4><input type=Submit value=Purchase></th></tr>";
	$Page .= "</tbody></tr></table></form>";

// Show Adsense Ad
	if ($adsense_config['donorstore_on'] == 1) {
		$Page .= "<div>".$adsense_config['overview_script']."</div>";
	} else {
		$Page .= "";
	}

	display($Page, $lang['donor'], true, '', false);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>