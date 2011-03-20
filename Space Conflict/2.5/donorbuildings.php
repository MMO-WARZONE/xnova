<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donorbuildings.php                    **
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

	$levelcost1 = floor($donorcost['1']   * pow(1.5, $planetrow[$donorid['1']]));
	$levelcost2 = floor($donorcost['2']   * pow(1.5, $planetrow[$donorid['2']]));
	$levelcost3 = floor($donorcost['3']   * pow(1.5, $planetrow[$donorid['3']]));
	$levelcost4 = floor($donorcost['4']   * pow(1.5, $planetrow[$donorid['4']]));
	$levelcost5 = floor($donorcost['5']   * pow(1.5, $planetrow[$donorid['5']]));
	$levelcost12 = floor($donorcost['12']   * pow(1.5, $planetrow[$donorid['12']]));
	$levelcost14 = floor($donorcost['14']   * pow(1.5, $planetrow[$donorid['14']]));
	$levelcost15 = floor($donorcost['15']   * pow(1.5, $planetrow[$donorid['15']]));
	$levelcost21 = floor($donorcost['21']   * pow(1.5, $planetrow[$donorid['21']]));
	$levelcost22 = floor($donorcost['22']   * pow(1.5, $planetrow[$donorid['22']]));
	$levelcost23 = floor($donorcost['23']   * pow(1.5, $planetrow[$donorid['23']]));
	$levelcost24 = floor($donorcost['24']   * pow(1.5, $planetrow[$donorid['24']]));
	$levelcost25 = floor($donorcost['25']   * pow(1.5, $planetrow[$donorid['25']]));
	$levelcost31 = floor($donorcost['31']   * pow(1.5, $planetrow[$donorid['31']]));
	$levelcost33 = floor($donorcost['33']   * pow(1.5, $planetrow[$donorid['33']]));
	$levelcost34 = floor($donorcost['34']   * pow(1.5, $planetrow[$donorid['34']]));
	$levelcost35 = floor($donorcost['35']   * pow(1.5, $planetrow[$donorid['35']]));
	$levelcost44 = floor($donorcost['44']   * pow(1.5, $planetrow[$donorid['44']]));

if ($mode == 'addit') {
	$id			= $TargetPlanet;
	$player			= $TargetUser;
	$metal_mine		= $_POST['metal_mine'];
	$crystal_mine		= $_POST['crystal_mine'];
	$deuterium_sintetizer	= $_POST['deuterium_sintetizer'];
	$tach_accel		= $_POST['tach_accel'];
	$solar_plant		= $_POST['solar_plant'];
	$fusion_plant		= $_POST['fusion_plant'];
	$robot_factory		= $_POST['robot_factory'];
	$nano_factory		= $_POST['nano_factory'];
	$hangar			= $_POST['hangar'];
	$metal_store		= $_POST['metal_store'];
	$crystal_store		= $_POST['crystal_store'];
	$deuterium_store	= $_POST['deuterium_store'];
	$tachyon_store		= $_POST['tachyon_store'];
	$laboratory		= $_POST['laboratory'];
	$terraformer		= $_POST['terraformer'];
	$ally_deposit		= $_POST['ally_deposit'];
	$orb_shipyard		= $_POST['orb_shipyard'];
	$silo			= $_POST['silo'];
	
   	$TotalCost = (($metal_mine		* $levelcost1)
			+($crystal_mine		* $levelcost2)
			+($deuterium_sintetizer	* $levelcost3)
			+($tach_accel		* $levelcost4)
			+($solar_plant		* $levelcost5)
			+($fusion_plant		* $levelcost12)
			+($robot_factory	* $levelcost14)
			+($nano_factory		* $levelcost15)
			+($hangar		* $levelcost21)
			+($metal_store		* $levelcost22)
			+($crystal_store	* $levelcost23)
			+($deuterium_store	* $levelcost24)
			+($tachyon_store	* $levelcost25)
			+($laboratory		* $levelcost31)
			+($terraformer		* $levelcost33)
			+($ally_deposit		* $levelcost34)
			+($orb_shipyard		* $levelcost35)
			+($silo			* $levelcost44)
			);


	if ($TotalCost <= $AvailPoints) {

		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`metal_mine` = `metal_mine` + '". $metal_mine ."', ";
		$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` + '". $crystal_mine ."', ";
		$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` + '". $deuterium_sintetizer ."', ";
		$QryUpdatePlanet .= "`tach_accel` = `tach_accel` + '". $tach_accel ."', ";
		$QryUpdatePlanet .= "`solar_plant` = `solar_plant` + '". $solar_plant ."', ";
		$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` + '". $fusion_plant ."', ";
		$QryUpdatePlanet .= "`robot_factory` = `robot_factory` + '". $robot_factory ."', ";
		$QryUpdatePlanet .= "`nano_factory` = `nano_factory` + '". $nano_factory ."', ";
		$QryUpdatePlanet .= "`hangar` = `hangar` + '". $hangar ."', ";
		$QryUpdatePlanet .= "`metal_store` = `metal_store` + '". $metal_store ."', ";
		$QryUpdatePlanet .= "`crystal_store` = `crystal_store` + '". $crystal_store ."', ";
		$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` + '". $deuterium_store ."', ";
		$QryUpdatePlanet .= "`tachyon_store` = `tachyon_store` + '". $tachyon_store ."', ";
		$QryUpdatePlanet .= "`laboratory` = `laboratory` + '". $laboratory ."', ";
		$QryUpdatePlanet .= "`terraformer` = `terraformer` + '". $terraformer ."', ";
		$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` + '". $ally_deposit ."', ";
		$QryUpdatePlanet .= "`orb_shipyard` = `orb_shipyard` + '". $orb_shipyard ."', ";
		$QryUpdatePlanet .= "`silo` = `silo` + '". $silo ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". $id ."' ";
		doquery( $QryUpdatePlanet, "planets");

		$QryUpdateUser		= "UPDATE {{table}} SET ";
		$QryUpdateUser		.= "`rpg_points` = `rpg_points` - '". $TotalCost ."' ";
		$QryUpdateUser		.= "WHERE ";
		$QryUpdateUser		.= "`id` = '". $player ."' ";
		doquery( $QryUpdateUser, "users");			
	
		AdminMessage ( "Donor Rewards Purchased", "Purchase Donor Rewards" );
	} else {
		AdminMessage ( "Not Enough Dark Matter", "Not Enough Dark Matter" );
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
	$Page .= "<form action=donorbuildings.php method=post><input type=\"hidden\" name=\"mode\" value=\"addit\">";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=4>Purchase Buildings</td></tr>";
	$Page .= "<tr><th>Cost</th><th>Building Name</th><th>Purchase</th><th>Level</th></tr>";

	if ($planetrow['planet_type'] == 1) {

		$Page .= "<tr><th>".$levelcost1."</th><th>".$donorname['1']."</th><th><input name=".$donorid['1']." type=checkbox value=1></th><th>".$planetrow[$donorid['1']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost2."</th><th>".$donorname['2']."</th><th><input name=".$donorid['2']." type=checkbox value=1></th><th>".$planetrow[$donorid['2']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost3."</th><th>".$donorname['3']."</th><th><input name=".$donorid['3']." type=checkbox value=1></th><th>".$planetrow[$donorid['3']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost4."</th><th>".$donorname['4']."</th><th><input name=".$donorid['4']." type=checkbox value=1></th><th>".$planetrow[$donorid['4']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost5."</th><th>".$donorname['5']."</th><th><input name=".$donorid['5']." type=checkbox value=1></th><th>".$planetrow[$donorid['5']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost12."</th><th>".$donorname['12']."</th><th><input name=".$donorid['12']." type=checkbox value=1></th><th>".$planetrow[$donorid['12']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost14."</th><th>".$donorname['14']."</th><th><input name=".$donorid['14']." type=checkbox value=1></th><th>".$planetrow[$donorid['14']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost15."</th><th>".$donorname['15']."</th><th><input name=".$donorid['15']." type=checkbox value=1></th><th>".$planetrow[$donorid['15']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost21."</th><th>".$donorname['21']."</th><th><input name=".$donorid['21']." type=checkbox value=1></th><th>".$planetrow[$donorid['21']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost22."</th><th>".$donorname['22']."</th><th><input name=".$donorid['22']." type=checkbox value=1></th><th>".$planetrow[$donorid['22']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost23."</th><th>".$donorname['23']."</th><th><input name=".$donorid['23']." type=checkbox value=1></th><th>".$planetrow[$donorid['23']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost24."</th><th>".$donorname['24']."</th><th><input name=".$donorid['24']." type=checkbox value=1></th><th>".$planetrow[$donorid['24']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost25."</th><th>".$donorname['25']."</th><th><input name=".$donorid['25']." type=checkbox value=1></th><th>".$planetrow[$donorid['25']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost31."</th><th>".$donorname['31']."</th><th><input name=".$donorid['31']." type=checkbox value=1></th><th>".$planetrow[$donorid['31']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost33."</th><th>".$donorname['33']."</th><th><input name=".$donorid['33']." type=checkbox value=1></th><th>".$planetrow[$donorid['33']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost34."</th><th>".$donorname['34']."</th><th><input name=".$donorid['34']." type=checkbox value=1></th><th>".$planetrow[$donorid['34']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost35."</th><th>".$donorname['35']."</th><th><input name=".$donorid['35']." type=checkbox value=1></th><th>".$planetrow[$donorid['35']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost44."</th><th>".$donorname['44']."</th><th><input name=".$donorid['44']." type=checkbox value=1></th><th>".$planetrow[$donorid['44']]."</th></tr>";
	}
	else if ($planetrow['planet_type'] == 3) {

		$Page .= "<tr><th>".$levelcost5."</th><th>".$donorname['5']."</th><th><input name=".$donorid['5']." type=checkbox value=1></th><th>".$planetrow[$donorid['5']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost12."</th><th>".$donorname['12']."</th><th><input name=".$donorid['12']." type=checkbox value=1></th><th>".$planetrow[$donorid['12']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost14."</th><th>".$donorname['14']."</th><th><input name=".$donorid['14']." type=checkbox value=1></th><th>".$planetrow[$donorid['14']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost15."</th><th>".$donorname['15']."</th><th><input name=".$donorid['15']." type=checkbox value=1></th><th>".$planetrow[$donorid['15']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost21."</th><th>".$donorname['21']."</th><th><input name=".$donorid['21']." type=checkbox value=1></th><th>".$planetrow[$donorid['21']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost22."</th><th>".$donorname['22']."</th><th><input name=".$donorid['22']." type=checkbox value=1></th><th>".$planetrow[$donorid['22']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost23."</th><th>".$donorname['23']."</th><th><input name=".$donorid['23']." type=checkbox value=1></th><th>".$planetrow[$donorid['23']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost24."</th><th>".$donorname['24']."</th><th><input name=".$donorid['24']." type=checkbox value=1></th><th>".$planetrow[$donorid['24']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost25."</th><th>".$donorname['25']."</th><th><input name=".$donorid['25']." type=checkbox value=1></th><th>".$planetrow[$donorid['25']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost31."</th><th>".$donorname['31']."</th><th><input name=".$donorid['31']." type=checkbox value=1></th><th>".$planetrow[$donorid['31']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost33."</th><th>".$donorname['33']."</th><th><input name=".$donorid['33']." type=checkbox value=1></th><th>".$planetrow[$donorid['33']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost34."</th><th>".$donorname['34']."</th><th><input name=".$donorid['34']." type=checkbox value=1></th><th>".$planetrow[$donorid['34']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost35."</th><th>".$donorname['35']."</th><th><input name=".$donorid['35']." type=checkbox value=1></th><th>".$planetrow[$donorid['35']]."</th></tr>";
		$Page .= "<tr><th>".$levelcost44."</th><th>".$donorname['44']."</th><th><input name=".$donorid['44']." type=checkbox value=1></th><th>".$planetrow[$donorid['44']]."</th></tr>";
	}

	$Page .= "<tr><th colspan=3><input type=Submit value=Purchase></th></tr>";
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