<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donordefenses.php                     **
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
	if (($_POST['misil_launcher'] < 0) || ($_POST['small_laser'] < 0) || ($_POST['big_laser'] < 0) || ($_POST['gauss_canyon'] < 0) || ($_POST['ionic_canyon'] < 0) || ($_POST['buster_canyon'] < 0) || ($_POST['small_protection_shield'] < 0) || ($_POST['big_protection_shield'] < 0) || ($_POST['orb_def_plat'] < 0)) {
		AdminMessage ( "Invalid Value", "Filthy Cheater" );
	} else {

		$id			= $TargetPlanet;
		$player			= $TargetUser;
		$misil_launcher		= $_POST['misil_launcher'];
		$small_laser		= $_POST['small_laser'];
		$big_laser		= $_POST['big_laser'];
		$gauss_canyon		= $_POST['gauss_canyon'];
		$ionic_canyon		= $_POST['ionic_canyon'];
		$buster_canyon		= $_POST['buster_canyon'];
		$small_protection_shield  = $_POST['small_protection_shield'];
		$big_protection_shield	= $_POST['big_protection_shield'];
		$orb_def_plat		= $_POST['orb_def_plat'];
	   	$TotalCost = (($misil_launcher		* $donorcost['401'])
				+($small_laser		* $donorcost['402'])
				+($big_laser		* $donorcost['403'])
				+($gauss_canyon		* $donorcost['404'])
				+($ionic_canyon		* $donorcost['405'])
				+($buster_canyon	* $donorcost['406'])
				+($small_protection_shield   * $donorcost['407'])
				+($big_protection_shield     * $donorcost['408'])
				+($orb_def_plat		* $donorcost['409']));

		if ($TotalCost <= $AvailPoints) {
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` + '". $misil_launcher ."', ";
			$QryUpdatePlanet .= "`small_laser` = `small_laser` + '". $small_laser ."', ";
			$QryUpdatePlanet .= "`big_laser` = `big_laser` + '". $big_laser ."', ";
			$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` + '". $gauss_canyon ."', ";
			$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` + '". $ionic_canyon ."', ";
			$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` + '". $buster_canyon ."', ";
			$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` + '". $small_protection_shield ."', ";
			$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` + '". $big_protection_shield ."', ";
			$QryUpdatePlanet .= "`orb_def_plat` = `orb_def_plat` + '". $orb_def_plat ."' ";
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
	$Page .= "<form action=donordefenses.php method=post><input type=\"hidden\" name=\"mode\" value=\"addit\">";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=4>Purchase Defenses</td></tr>";
	$Page .= "<tr><th>Cost</th><th>Defense Name</th><th>Quantity</th><th>Current</th></tr>";
	$Page .= "<tr><th>".$donorcost['401']."</th><th>".$donorname['401']."</th><th><input name=".$donorid['401']." type=text value=0></th><th>".$planetrow[$donorid['401']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['402']."</th><th>".$donorname['402']."</th><th><input name=".$donorid['402']." type=text value=0></th><th>".$planetrow[$donorid['402']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['403']."</th><th>".$donorname['403']."</th><th><input name=".$donorid['403']." type=text value=0></th><th>".$planetrow[$donorid['403']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['404']."</th><th>".$donorname['404']."</th><th><input name=".$donorid['404']." type=text value=0></th><th>".$planetrow[$donorid['404']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['405']."</th><th>".$donorname['405']."</th><th><input name=".$donorid['405']." type=text value=0></th><th>".$planetrow[$donorid['405']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['406']."</th><th>".$donorname['406']."</th><th><input name=".$donorid['406']." type=text value=0></th><th>".$planetrow[$donorid['406']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['407']."</th><th>".$donorname['407']."</th><th><input name=".$donorid['407']." type=text value=0></th><th>".$planetrow[$donorid['407']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['408']."</th><th>".$donorname['408']."</th><th><input name=".$donorid['408']." type=text value=0></th><th>".$planetrow[$donorid['408']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['409']."</th><th>".$donorname['409']."</th><th><input name=".$donorid['409']." type=text value=0></th><th>".$planetrow[$donorid['409']]."</th></tr>";
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