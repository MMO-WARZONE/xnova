<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donorships.php                        **
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

	if (($_POST['small_ship_cargo'] < 0) || ($_POST['big_ship_cargo'] < 0) || ($_POST['freighter'] < 0) || ($_POST['light_hunter'] < 0) || ($_POST['heavy_hunter'] < 0) || ($_POST['elite_fighter'] < 0) || ($_POST['crusher'] < 0) || ($_POST['battle_ship'] < 0) || ($_POST['colonizer'] < 0)
	 || ($_POST['recycler'] < 0) || ($_POST['spy_sonde'] < 0) || ($_POST['bomber_ship'] < 0) || ($_POST['solar_satelit'] < 0) || ($_POST['destructor'] < 0) || ($_POST['dearth_star'] < 0) || ($_POST['battleship'] < 0) || ($_POST['world_eater'] < 0)) {
		AdminMessage ( "Invalid Value", "Filthy Cheater" );
	} else {

		$id			= $TargetPlanet;
		$player			= $TargetUser;
		$small_ship_cargo	= $_POST['small_ship_cargo'];
		$big_ship_cargo		= $_POST['big_ship_cargo'];
		$freighter		= $_POST['freighter'];
		$light_hunter		= $_POST['light_hunter'];
		$heavy_hunter		= $_POST['heavy_hunter'];
		$elite_fighter		= $_POST['elite_fighter'];
		$crusher		= $_POST['crusher'];
		$battle_ship		= $_POST['battle_ship'];
		$colonizer		= $_POST['colonizer'];
		$recycler		= $_POST['recycler'];
		$spy_sonde		= $_POST['spy_sonde'];
		$bomber_ship		= $_POST['bomber_ship'];
		$solar_satelit		= $_POST['solar_satelit'];
		$destructor		= $_POST['destructor'];
		$dearth_star		= $_POST['dearth_star'];
		$battleship		= $_POST['battleship'];
		$world_eater		= $_POST['world_eater'];
	   	$TotalCost = (($small_ship_cargo	* $donorcost['202'])
				+($big_ship_cargo	* $donorcost['203'])
				+($freighter		* $donorcost['204'])
				+($light_hunter		* $donorcost['205'])
				+($heavy_hunter		* $donorcost['206'])
				+($elite_fighter	* $donorcost['207'])
				+($crusher		* $donorcost['208'])
				+($battle_ship		* $donorcost['209'])
				+($colonizer		* $donorcost['210'])
				+($recycler		* $donorcost['211'])
				+($spy_sonde		* $donorcost['212'])
				+($bomber_ship		* $donorcost['213'])
				+($solar_satelit	* $donorcost['214'])
				+($destructor		* $donorcost['215'])
				+($dearth_star		* $donorcost['216'])
				+($battleship		* $donorcost['217'])
				+($world_eater		* $donorcost['218']));

		if ($TotalCost <= $AvailPoints) {
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` + '". $small_ship_cargo ."', ";
			$QryUpdatePlanet .= "`battleship` = `battleship` + '". $battleship ."', ";
			$QryUpdatePlanet .= "`dearth_star` = `dearth_star` + '". $dearth_star ."', ";
			$QryUpdatePlanet .= "`destructor` = `destructor` + '". $destructor ."', ";
			$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` + '". $solar_satelit ."', ";
			$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` + '". $bomber_ship ."', ";
			$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` + '". $spy_sonde ."', ";
			$QryUpdatePlanet .= "`recycler` = `recycler` + '". $recycler ."', ";
			$QryUpdatePlanet .= "`colonizer` = `colonizer` + '". $colonizer ."', ";
			$QryUpdatePlanet .= "`battle_ship` = `battle_ship` + '". $battle_ship ."', ";
			$QryUpdatePlanet .= "`crusher` = `crusher` + '". $crusher ."', ";
			$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` + '". $heavy_hunter ."', ";
			$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` + '". $big_ship_cargo ."', ";
			$QryUpdatePlanet .= "`light_hunter` = `light_hunter` + '". $light_hunter ."', ";
			$QryUpdatePlanet .= "`elite_fighter` = `elite_fighter` + '". $elite_fighter ."', ";
			$QryUpdatePlanet .= "`freighter` = `freighter` + '". $freighter ."', ";
			$QryUpdatePlanet .= "`world_eater` = `world_eater` + '". $world_eater ."' ";
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
	$Page .= "<form action=donorships.php method=post><input type=\"hidden\" name=\"mode\" value=\"addit\">";
	$Page .= "<table width=404><tbody><tr>";
	$Page .= "<td class=c colspan=4>Purchase Ships</td></tr>";
	$Page .= "<tr><th>Cost</th><th>Ship Name</th><th>Quantity</th><th>Current</th></tr>";
	$Page .= "<tr><th>".$donorcost['202']."</th><th>".$donorname['202']."</th><th><input name=".$donorid['202']." type=text value=0></th><th>".$planetrow[$donorid['202']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['203']."</th><th>".$donorname['203']."</th><th><input name=".$donorid['203']." type=text value=0></th><th>".$planetrow[$donorid['203']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['204']."</th><th>".$donorname['204']."</th><th><input name=".$donorid['204']." type=text value=0></th><th>".$planetrow[$donorid['204']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['205']."</th><th>".$donorname['205']."</th><th><input name=".$donorid['205']." type=text value=0></th><th>".$planetrow[$donorid['205']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['206']."</th><th>".$donorname['206']."</th><th><input name=".$donorid['206']." type=text value=0></th><th>".$planetrow[$donorid['206']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['207']."</th><th>".$donorname['207']."</th><th><input name=".$donorid['207']." type=text value=0></th><th>".$planetrow[$donorid['207']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['208']."</th><th>".$donorname['208']."</th><th><input name=".$donorid['208']." type=text value=0></th><th>".$planetrow[$donorid['208']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['209']."</th><th>".$donorname['209']."</th><th><input name=".$donorid['209']." type=text value=0></th><th>".$planetrow[$donorid['209']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['210']."</th><th>".$donorname['210']."</th><th><input name=".$donorid['210']." type=text value=0></th><th>".$planetrow[$donorid['210']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['211']."</th><th>".$donorname['211']."</th><th><input name=".$donorid['211']." type=text value=0></th><th>".$planetrow[$donorid['211']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['212']."</th><th>".$donorname['212']."</th><th><input name=".$donorid['212']." type=text value=0></th><th>".$planetrow[$donorid['212']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['213']."</th><th>".$donorname['213']."</th><th><input name=".$donorid['213']." type=text value=0></th><th>".$planetrow[$donorid['213']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['214']."</th><th>".$donorname['214']."</th><th><input name=".$donorid['214']." type=text value=0></th><th>".$planetrow[$donorid['214']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['215']."</th><th>".$donorname['215']."</th><th><input name=".$donorid['215']." type=text value=0></th><th>".$planetrow[$donorid['215']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['216']."</th><th>".$donorname['216']."</th><th><input name=".$donorid['216']." type=text value=0></th><th>".$planetrow[$donorid['216']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['217']."</th><th>".$donorname['217']."</th><th><input name=".$donorid['217']." type=text value=0></th><th>".$planetrow[$donorid['217']]."</th></tr>";
	$Page .= "<tr><th>".$donorcost['218']."</th><th>".$donorname['218']."</th><th><input name=".$donorid['218']." type=text value=0></th><th>".$planetrow[$donorid['218']]."</th></tr>";
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