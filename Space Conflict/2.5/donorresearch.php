<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donorresearch.php                     **
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

	$levelcost106 = floor($donorcost['106']   * pow(1.5, $user[$donorid['106']]));
	$levelcost108 = floor($donorcost['108']   * pow(1.5, $user[$donorid['108']]));
	$levelcost109 = floor($donorcost['109']   * pow(1.5, $user[$donorid['109']]));
	$levelcost110 = floor($donorcost['110']   * pow(1.5, $user[$donorid['110']]));
	$levelcost111 = floor($donorcost['111']   * pow(1.5, $user[$donorid['111']]));
	$levelcost113 = floor($donorcost['113']   * pow(1.5, $user[$donorid['113']]));
	$levelcost114 = floor($donorcost['114']   * pow(1.5, $user[$donorid['114']]));
	$levelcost115 = floor($donorcost['115']   * pow(1.5, $user[$donorid['115']]));
	$levelcost117 = floor($donorcost['117']   * pow(1.5, $user[$donorid['117']]));
	$levelcost118 = floor($donorcost['118']   * pow(1.5, $user[$donorid['118']]));
	$levelcost120 = floor($donorcost['120']   * pow(1.5, $user[$donorid['120']]));
	$levelcost121 = floor($donorcost['121']   * pow(1.5, $user[$donorid['121']]));
	$levelcost122 = floor($donorcost['122']   * pow(1.5, $user[$donorid['122']]));
	$levelcost123 = floor($donorcost['123']   * pow(1.5, $user[$donorid['123']]));
	$levelcost124 = floor($donorcost['124']   * pow(1.5, $user[$donorid['124']]));
	$levelcost194 = floor($donorcost['194']   * pow(1.5, $user[$donorid['194']]));
	$levelcost195 = floor($donorcost['195']   * pow(1.5, $user[$donorid['195']]));
	$levelcost196 = floor($donorcost['196']   * pow(1.5, $user[$donorid['196']]));
	$levelcost197 = floor($donorcost['197']   * pow(1.5, $user[$donorid['197']]));
	$levelcost198 = floor($donorcost['198']   * pow(1.5, $user[$donorid['198']]));
	$levelcost199 = floor($donorcost['199']   * pow(1.5, $user[$donorid['199']]));
	$levelcost200 = floor($donorcost['200']   * pow(1.5, $user[$donorid['200']]));

if ($mode == 'addit') {
	$id			= $TargetPlanet;
	$player			= $TargetUser;
	$spy_tech		= $_POST['spy_tech'];
	$computer_tech		= $_POST['computer_tech'];
	$military_tech		= $_POST['military_tech'];
	$defence_tech		= $_POST['defence_tech'];
	$shield_tech		= $_POST['shield_tech'];
	$energy_tech		= $_POST['energy_tech'];
	$hyperspace_tech	= $_POST['hyperspace_tech"'];
	$combustion_tech	= $_POST['combustion_tech'];
	$impulse_motor_tech	= $_POST['impulse_motor_tech'];
	$hyperspace_motor_tech	= $_POST['hyperspace_motor_tech'];
	$laser_tech		= $_POST['laser_tech'];
	$ionic_tech		= $_POST['ionic_tech'];
	$buster_tech		= $_POST['buster_tech'];
	$intergalactic_tech	= $_POST['intergalactic_tech'];
	$expedition_tech	= $_POST['expedition_tech'];
	$tach_extract_tech	= $_POST['tach_extract_tech'];
	$tach_compress_tech	= $_POST['tach_compress_tech'];
	$genetic_tech		= $_POST['genetic_tech'];
	$quantum_tech		= $_POST['quantum_tech'];
	$quantum_drive_tech	= $_POST['quantum_drive_tech'];
	$graviton_tech		= $_POST['graviton_tech'];
	$tach_tech		= $_POST['tach_tech'];
	
   	$TotalCost = (($spy_tech		* $levelcost106)
			+($computer_tech	* $levelcost108)
			+($military_tech	* $levelcost109)
			+($defence_tech		* $levelcost110)
			+($shield_tech		* $levelcost111)
			+($energy_tech		* $levelcost113)
			+($hyperspace_tech	* $levelcost114)
			+($combustion_tech	* $levelcost115)
			+($impulse_motor_tech	* $levelcost117)
			+($hyperspace_motor_tech * $levelcost118)
			+($laser_tech		* $levelcost120)
			+($ionic_tech		* $levelcost121)
			+($buster_tech		* $levelcost122)
			+($intergalactic_tech	* $levelcost123)
			+($expedition_tech	* $levelcost124)
			+($tach_extract_tech	* $levelcost194)
			+($tach_compress_tech	* $levelcost195)
			+($genetic_tech		* $levelcost196)
			+($quantum_tech		* $levelcost197)
			+($quantum_drive_tech	* $levelcost198)
			+($graviton_tech	* $levelcost199)
			+($tach_tech		* $levelcost200)
			);


	if ($TotalCost <= $AvailPoints) {

		$QryUpdateUser		= "UPDATE {{table}} SET ";
		$QryUpdateUser		.= "`spy_tech` = `spy_tech` + '". $spy_tech ."', ";
		$QryUpdateUser		.= "`computer_tech` = `computer_tech` + '". $computer_tech ."', ";
		$QryUpdateUser		.= "`military_tech` = `military_tech` + '". $military_tech ."', ";
		$QryUpdateUser		.= "`defence_tech` = `defence_tech` + '". $defence_tech ."', ";
		$QryUpdateUser		.= "`shield_tech` = `shield_tech` + '". $shield_tech ."', ";
		$QryUpdateUser		.= "`energy_tech` = `energy_tech` + '". $energy_tech ."', ";
		$QryUpdateUser		.= "`hyperspace_tech` = `hyperspace_tech` + '". $hyperspace_tech ."', ";
		$QryUpdateUser		.= "`combustion_tech` = `combustion_tech` + '". $combustion_tech ."', ";
		$QryUpdateUser		.= "`impulse_motor_tech` = `impulse_motor_tech` + '". $impulse_motor_tech ."', ";
		$QryUpdateUser		.= "`hyperspace_motor_tech` = `hyperspace_motor_tech` + '". $hyperspace_motor_tech ."', ";
		$QryUpdateUser		.= "`laser_tech` = `laser_tech` + '". $laser_tech ."', ";
		$QryUpdateUser		.= "`ionic_tech` = `ionic_tech` + '". $ionic_tech ."', ";
		$QryUpdateUser		.= "`buster_tech` = `buster_tech` + '". $buster_tech ."', ";
		$QryUpdateUser		.= "`intergalactic_tech` = `intergalactic_tech` + '". $intergalactic_tech ."', ";
		$QryUpdateUser		.= "`expedition_tech` = `expedition_tech` + '". $expedition_tech ."', ";
		$QryUpdateUser		.= "`quantum_tech` = `quantum_tech` + '". $quantum_tech ."', ";
		$QryUpdateUser		.= "`quantum_drive_tech` = `quantum_drive_tech` + '". $quantum_drive_tech ."', ";
		$QryUpdateUser		.= "`genetic_tech` = `genetic_tech` + '". $genetic_tech ."', ";
		$QryUpdateUser		.= "`tach_extract_tech` = `tach_extract_tech` + '". $tach_extract_tech ."', ";
		$QryUpdateUser		.= "`tach_compress_tech` = `tach_compress_tech` + '". $tach_compress_tech ."', ";
		$QryUpdateUser		.= "`tach_tech` = `tach_tech` + '". $tach_tech ."', ";
		$QryUpdateUser		.= "`graviton_tech` = `graviton_tech` + '". $graviton_tech ."' ,";
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
	$Page .= "<form action=donorresearch.php method=post><input type=\"hidden\" name=\"mode\" value=\"addit\">";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=4>Purchase Buildings</td></tr>";
	$Page .= "<tr><th>Cost</th><th>Research Name</th><th>Purchase</th><th>Level</th></tr>";
	$Page .= "<tr><th>".$levelcost106."</th><th>".$donorname['106']."</th><th><input name=".$donorid['106']." type=checkbox value=1></th><th>".$user[$donorid['106']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost108."</th><th>".$donorname['108']."</th><th><input name=".$donorid['108']." type=checkbox value=1></th><th>".$user[$donorid['108']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost109."</th><th>".$donorname['109']."</th><th><input name=".$donorid['109']." type=checkbox value=1></th><th>".$user[$donorid['109']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost110."</th><th>".$donorname['110']."</th><th><input name=".$donorid['110']." type=checkbox value=1></th><th>".$user[$donorid['110']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost111."</th><th>".$donorname['111']."</th><th><input name=".$donorid['111']." type=checkbox value=1></th><th>".$user[$donorid['111']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost113."</th><th>".$donorname['113']."</th><th><input name=".$donorid['113']." type=checkbox value=1></th><th>".$user[$donorid['113']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost114."</th><th>".$donorname['114']."</th><th><input name=".$donorid['114']." type=checkbox value=1></th><th>".$user[$donorid['114']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost115."</th><th>".$donorname['115']."</th><th><input name=".$donorid['115']." type=checkbox value=1></th><th>".$user[$donorid['115']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost117."</th><th>".$donorname['117']."</th><th><input name=".$donorid['117']." type=checkbox value=1></th><th>".$user[$donorid['117']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost118."</th><th>".$donorname['118']."</th><th><input name=".$donorid['118']." type=checkbox value=1></th><th>".$user[$donorid['118']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost120."</th><th>".$donorname['120']."</th><th><input name=".$donorid['120']." type=checkbox value=1></th><th>".$user[$donorid['120']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost121."</th><th>".$donorname['121']."</th><th><input name=".$donorid['121']." type=checkbox value=1></th><th>".$user[$donorid['121']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost122."</th><th>".$donorname['122']."</th><th><input name=".$donorid['122']." type=checkbox value=1></th><th>".$user[$donorid['122']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost123."</th><th>".$donorname['123']."</th><th><input name=".$donorid['123']." type=checkbox value=1></th><th>".$user[$donorid['123']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost124."</th><th>".$donorname['124']."</th><th><input name=".$donorid['124']." type=checkbox value=1></th><th>".$user[$donorid['124']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost194."</th><th>".$donorname['194']."</th><th><input name=".$donorid['194']." type=checkbox value=1></th><th>".$user[$donorid['194']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost195."</th><th>".$donorname['195']."</th><th><input name=".$donorid['195']." type=checkbox value=1></th><th>".$user[$donorid['195']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost196."</th><th>".$donorname['196']."</th><th><input name=".$donorid['196']." type=checkbox value=1></th><th>".$user[$donorid['196']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost197."</th><th>".$donorname['197']."</th><th><input name=".$donorid['197']." type=checkbox value=1></th><th>".$user[$donorid['197']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost198."</th><th>".$donorname['198']."</th><th><input name=".$donorid['198']." type=checkbox value=1></th><th>".$user[$donorid['198']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost199."</th><th>".$donorname['199']."</th><th><input name=".$donorid['199']." type=checkbox value=1></th><th>".$user[$donorid['199']]."</th></tr>";
	$Page .= "<tr><th>".$levelcost200."</th><th>".$donorname['200']."</th><th><input name=".$donorid['200']." type=checkbox value=1></th><th>".$user[$donorid['200']]."</th></tr>";
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