<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** scrapyard.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
include($xnova_root_path . 'includes/scrapvars.' . $phpEx);
	$TargetPlanet = $user['current_planet'];
	$TargetUser   = $user['id'];
	$PlanetName   = $planetrow['name'];
	$PlayerName   = $user['username'];
	$ReturnFactor = rand(80, 120)/100;
	$mode         = $_POST['mode'];	

if ($mode == 'sellit') {
	$id					= $TargetPlanet;
	$player				= $TargetUser;
	$small_cargo		= $_POST['small_ship_cargo'];
	$large_cargo		= $_POST['big_ship_cargo'];
	$light_fighter		= $_POST['light_hunter'];
	$heavy_fighter		= $_POST['heavy_hunter'];
	$freighter			= $_POST['freighter'];
	$cruiser			= $_POST['crusher'];
	$battleship			= $_POST['battle_ship'];
	$colony				= $_POST['colonizer'];
	$recycler			= $_POST['recycler'];
	$spy				= $_POST['spy_sonde'];
	$bomber				= $_POST['bomber_ship'];
	$solar				= $_POST['solar_satelit'];
	$destroyer			= $_POST['destructor'];
	$deathstar			= $_POST['dearth_star'];
	$battlecruiser		= $_POST['battleship'];
	$freighter			= $_POST['freighter'];
	$elite_fighter		= $_POST['elite_fighter'];
	$worldeater			= $_POST['world_eater'];
	$misil_launcher		= $_POST['misil_launcher'];
	$small_laser		= $_POST['small_laser'];
	$big_laser			= $_POST['big_laser'];
	$gauss_canyon		= $_POST['gauss_canyon'];
	$ionic_canyon		= $_POST['ionic_canyon'];
	$buster_canyon		= $_POST['buster_canyon'];
	$small_protection_shield	= $_POST['small_protection_shield'];
	$big_protection_shield		= $_POST['big_protection_shield'];

	$TotalMetal = (($small_cargo		* $pricelist['202']['metal'])
			+($large_cargo				* $pricelist['203']['metal'])
			+($light_fighter			* $pricelist['204']['metal'])
			+($heavy_fighter			* $pricelist['205']['metal'])
			+($cruiser					* $pricelist['206']['metal'])
			+($battleship				* $pricelist['207']['metal'])
			+($colony					* $pricelist['208']['metal'])
			+($recycler					* $pricelist['209']['metal'])
			+($spy						* $pricelist['210']['metal'])
			+($bomber					* $pricelist['211']['metal'])
			+($solar					* $pricelist['212']['metal'])
			+($destroyer				* $pricelist['213']['metal'])
			+($deathstar				* $pricelist['214']['metal'])
			+($battlecruiser			* $pricelist['215']['metal'])
			+($freighter				* $pricelist['216']['metal'])
			+($elite_fighter			* $pricelist['217']['metal'])
			+($worldeater				* $pricelist['218']['metal'])
			+($misil_launcher			* $pricelist['401']['metal'])
			+($small_laser				* $pricelist['402']['metal'])
			+($big_laser				* $pricelist['403']['metal'])
			+($gauss_canyon				* $pricelist['404']['metal'])
			+($ionic_canyon				* $pricelist['405']['metal'])
			+($buster_canyon			* $pricelist['406']['metal'])
			+($small_protection_shield	* $pricelist['407']['metal'])
			+($big_protection_shield	* $pricelist['408']['metal'])
			+($orb_def_plat				* $pricelist['409']['metal'])
			  );

	$TotalCrystal = (($small_cargo		* $pricelist['202']['crystal'])
			+($large_cargo				* $pricelist['203']['crystal'])
			+($light_fighter			* $pricelist['204']['crystal'])
			+($heavy_fighter			* $pricelist['205']['crystal'])
			+($cruiser					* $pricelist['206']['crystal'])
			+($battleship				* $pricelist['207']['crystal'])
			+($colony					* $pricelist['208']['crystal'])
			+($recycler					* $pricelist['209']['crystal'])
			+($spy						* $pricelist['210']['crystal'])
			+($bomber					* $pricelist['211']['crystal'])
			+($solar					* $pricelist['212']['crystal'])
			+($destroyer				* $pricelist['213']['crystal'])
			+($deathstar				* $pricelist['214']['crystal'])
			+($battlecruiser			* $pricelist['215']['crystal'])
			+($freighter				* $pricelist['216']['crystal'])
			+($elite_fighter			* $pricelist['217']['crystal'])
			+($worldeater				* $pricelist['218']['crystal'])
			+($misil_launcher			* $pricelist['401']['crystal'])
			+($small_laser				* $pricelist['402']['crystal'])
			+($big_laser				* $pricelist['403']['crystal'])
			+($gauss_canyon				* $pricelist['404']['crystal'])
			+($ionic_canyon				* $pricelist['405']['crystal'])
			+($buster_canyon			* $pricelist['406']['crystal'])
			+($small_protection_shield	* $pricelist['407']['crystal'])
			+($big_protection_shield  	* $pricelist['408']['crystal'])
			+($orb_def_plat				* $pricelist['409']['crystal'])
			  );

	$TotalDeuterium = (($small_cargo	* $pricelist['202']['deuterium'])
			+($large_cargo				* $pricelist['203']['deuterium'])
			+($light_fighter			* $pricelist['204']['deuterium'])
			+($heavy_fighter			* $pricelist['205']['deuterium'])
			+($cruiser					* $pricelist['206']['deuterium'])
			+($battleship				* $pricelist['207']['deuterium'])
			+($colony					* $pricelist['208']['deuterium'])
			+($recycler					* $pricelist['209']['deuterium'])
			+($spy						* $pricelist['210']['deuterium'])
			+($bomber					* $pricelist['211']['deuterium'])
			+($solar					* $pricelist['212']['deuterium'])
			+($destroyer				* $pricelist['213']['deuterium'])
			+($deathstar				* $pricelist['214']['deuterium'])
			+($battlecruiser			* $pricelist['215']['deuterium'])
			+($freighter				* $pricelist['216']['deuterium'])
			+($elite_fighter			* $pricelist['217']['deuterium'])
			+($worldeater				* $pricelist['218']['deuterium'])
			+($misil_launcher			* $pricelist['401']['deuterium'])
			+($small_laser				* $pricelist['402']['deuterium'])
			+($big_laser				* $pricelist['403']['deuterium'])
			+($gauss_canyon				* $pricelist['404']['deuterium'])
			+($ionic_canyon				* $pricelist['405']['deuterium'])
			+($buster_canyon			* $pricelist['406']['deuterium'])
			+($small_protection_shield	* $pricelist['407']['deuterium'])
			+($big_protection_shield   	* $pricelist['408']['deuterium'])
			+($orb_def_plat				* $pricelist['409']['deuterium'])
			  );

	$TotalTachyon = (($small_cargo		* $pricelist['202']['tachyon'])
			+($large_cargo				* $pricelist['203']['tachyon'])
			+($light_fighter			* $pricelist['204']['tachyon'])
			+($heavy_fighter			* $pricelist['205']['tachyon'])
			+($cruiser					* $pricelist['206']['tachyon'])
			+($battleship				* $pricelist['207']['tachyon'])
			+($colony					* $pricelist['208']['tachyon'])
			+($recycler					* $pricelist['209']['tachyon'])
			+($spy						* $pricelist['210']['tachyon'])
			+($bomber					* $pricelist['211']['tachyon'])
			+($solar					* $pricelist['212']['tachyon'])
			+($destroyer				* $pricelist['213']['tachyon'])
			+($deathstar				* $pricelist['214']['tachyon'])
			+($battlecruiser			* $pricelist['215']['tachyon'])
			+($freighter				* $pricelist['216']['tachyon'])
			+($elite_fighter			* $pricelist['217']['tachyon'])
			+($worldeater				* $pricelist['218']['tachyon'])
			+($misil_launcher			* $pricelist['401']['tachyon'])
			+($small_laser				* $pricelist['402']['tachyon'])
			+($big_laser				* $pricelist['403']['tachyon'])
			+($gauss_canyon				* $pricelist['404']['tachyon'])
			+($ionic_canyon				* $pricelist['405']['tachyon'])
			+($buster_canyon			* $pricelist['406']['tachyon'])
			+($small_protection_shield	* $pricelist['407']['tachyon'])
			+($big_protection_shield   	* $pricelist['408']['tachyon'])
			+($orb_def_plat				* $pricelist['409']['tachyon'])
			  );

	if ($small_cargo		< 0 ||
		    $large_cargo	< 0 ||
		    $light_fighter	< 0 ||
		    $heavy_fighter	< 0 ||
		    $cruiser		< 0 ||
		    $battleship		< 0 ||
		    $colony			< 0 ||
		    $recycler		< 0 ||
		    $spy			< 0 ||
		    $bomber			< 0 ||
		    $solar			< 0 ||
		    $destroyer		< 0 ||
		    $deathstar		< 0 ||
		    $battlecruiser	< 0 ||
		    $freighter		< 0 ||
		    $elite_fighter	< 0 ||
		    $worldeater		< 0 ||
		    $misil_launcher	< 0 ||
		    $small_laser	< 0 ||
		    $big_laser		< 0 ||
		    $gauss_canyon	< 0 ||
		    $ionic_canyon	< 0 ||
		    $buster_canyon	< 0 ||
		    $small_protection_shield < 0 ||
		    $big_protection_shield   < 0 ||
		    $orb_def_plat	< 0) {

		AdminMessage ( "Cheater", "Cheater" ); 
	} else if ($small_cargo	<= $planetrow[$resource['202']] &&
		    $large_cargo	<= $planetrow[$resource['203']] &&
		    $light_fighter	<= $planetrow[$resource['204']] &&
		    $heavy_fighter	<= $planetrow[$resource['205']] &&
		    $cruiser		<= $planetrow[$resource['206']] &&
		    $battleship		<= $planetrow[$resource['207']] &&
		    $colony			<= $planetrow[$resource['208']] &&
		    $recycler		<= $planetrow[$resource['209']] &&
		    $spy			<= $planetrow[$resource['210']] &&
		    $bomber			<= $planetrow[$resource['211']] &&
		    $solar			<= $planetrow[$resource['212']] &&
		    $destroyer		<= $planetrow[$resource['213']] &&
		    $deathstar		<= $planetrow[$resource['214']] &&
		    $battlecruiser	<= $planetrow[$resource['215']] &&
		    $freighter		<= $planetrow[$resource['216']] &&
		    $elite_fighter	<= $planetrow[$resource['217']] &&
		    $worldeater		<= $planetrow[$resource['218']] &&
		    $misil_launcher	<= $planetrow[$resource['401']] &&
		    $small_laser	<= $planetrow[$resource['402']] &&
		    $big_laser		<= $planetrow[$resource['403']] &&
		    $gauss_canyon	<= $planetrow[$resource['404']] &&
		    $ionic_canyon	<= $planetrow[$resource['405']] &&
		    $buster_canyon	<= $planetrow[$resource['406']] &&
		    $small_protection_shield <= $planetrow[$resource['407']] &&
		    $big_protection_shield   <= $planetrow[$resource['408']] &&
		    $orb_def_plat	<= $planetrow[$resource['409']]) {

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` - '".$small_cargo."', ";
			$QryUpdatePlanet .= "`battleship` = `battleship` - '". $battlecruiser."', ";
			$QryUpdatePlanet .= "`dearth_star` = `dearth_star` - '". $deathstar ."', ";
			$QryUpdatePlanet .= "`destructor` = `destructor` - '". $destroyer."', ";
			$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` - '". $solar."', ";
			$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` - '". $bomber."', ";
			$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` - '". $spy."', ";
			$QryUpdatePlanet .= "`recycler` = `recycler` - '". $recycler."', ";
			$QryUpdatePlanet .= "`colonizer` = `colonizer` - '". $colony."', ";
			$QryUpdatePlanet .= "`battle_ship` = `battle_ship` - '". $battleship."', ";
			$QryUpdatePlanet .= "`crusher` = `crusher` - '". $cruiser."', ";
			$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` - '". $heavy_fighter."', ";
			$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` - '". $large_cargo."', ";
			$QryUpdatePlanet .= "`light_hunter` = `light_hunter` - '". $light_fighter."', ";
			$QryUpdatePlanet .= "`elite_fighter` = `elite_fighter` - '". $elite_fighter."', ";
			$QryUpdatePlanet .= "`freighter` = `freighter` - '". $freighter."', ";
			$QryUpdatePlanet .= "`world_eater` = `world_eater` - '". $worldeater."' ,";
			$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` - '". $misil_launcher ."', ";
			$QryUpdatePlanet .= "`small_laser` = `small_laser` - '". $small_laser ."', ";
			$QryUpdatePlanet .= "`big_laser` = `big_laser` - '". $big_laser ."', ";
			$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` - '". $gauss_canyon ."', ";
			$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` - '". $ionic_canyon ."', ";
			$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` - '". $buster_canyon ."', ";
			$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` - '". $small_protection_shield ."', ";
			$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` - '". $big_protection_shield ."', ";
			$QryUpdatePlanet .= "`orb_def_plat` = `orb_def_plat` - '". $orb_def_plat ."', ";
			$QryUpdatePlanet .= "`metal` = `metal` + '".($TotalMetal * $ReturnFactor)."', ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + '".($TotalCrystal * $ReturnFactor)."', ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + '".($TotalDeuterium * $ReturnFactor)."', ";
			$QryUpdatePlanet .= "`tachyon` = `tachyon` + '".($TotalTachyon * $ReturnFactor)."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( "Ship Scrap Sucessful", "Ship Scrap Sucessful" );

		} else {
			AdminMessage ( "Not Enough Available Ships", "Not Enough Available Ships" );
		}	
				
	}

	$Page .= "<br><br><h2>Fleet Scrapyard</h2>";
	$Page .= "<table width=60%><tbody><tr>";
	$Page .= "<td class=c colspan=2>Fleet Scrapyard</td></tr>";
	$Page .= "<tr><th><font color=skyblue> ".$PlayerName."</font></th>";
	$Page .= "<th><font color=skyblue> ".$PlanetName."</font></th></tr>";
	$Page .= "</tbody></table>";
	$Page .= "<form action=scrapyard.php method=post><input type=\"hidden\" name=\"mode\" value=\"sellit\">";
	$Page .= "<table width=60%><tbody><tr>";
	$Page .= "<td class=c colspan=4>Fleet Scrapyard</td></tr>";
	$Page .= "<tr><th>Ship Name:</th><th>Available:</th><th>Scrap:</th><th>Value:</th></tr>";
	$Page .= "<tr><th>".$scrapname['202']."</th><th>".$planetrow[$resource['202']]."</th><th><input name=".$scrapid['202']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['202']['metal']." <br>Crystal: ".$pricelist['202']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['202']['deuterium']." <br>Tachyon: ".$pricelist['202']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['203']."</th><th>".$planetrow[$resource['203']]."</th><th><input name=".$scrapid['203']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['203']['metal']." <br>Crystal: ".$pricelist['203']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['203']['deuterium']." <br>Tachyon: ".$pricelist['203']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['204']."</th><th>".$planetrow[$resource['204']]."</th><th><input name=".$scrapid['204']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['204']['metal']." <br>Crystal: ".$pricelist['204']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['204']['deuterium']." <br>Tachyon: ".$pricelist['204']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['205']."</th><th>".$planetrow[$resource['205']]."</th><th><input name=".$scrapid['205']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['205']['metal']." <br>Crystal: ".$pricelist['205']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['205']['deuterium']." <br>Tachyon: ".$pricelist['205']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['206']."</th><th>".$planetrow[$resource['206']]."</th><th><input name=".$scrapid['206']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['206']['metal']." <br>Crystal: ".$pricelist['206']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['206']['deuterium']." <br>Tachyon: ".$pricelist['206']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['207']."</th><th>".$planetrow[$resource['207']]."</th><th><input name=".$scrapid['207']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['207']['metal']." <br>Crystal: ".$pricelist['207']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['207']['deuterium']." <br>Tachyon: ".$pricelist['207']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['208']."</th><th>".$planetrow[$resource['208']]."</th><th><input name=".$scrapid['208']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['208']['metal']." <br>Crystal: ".$pricelist['208']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['208']['deuterium']." <br>Tachyon: ".$pricelist['208']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['209']."</th><th>".$planetrow[$resource['209']]."</th><th><input name=".$scrapid['209']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['209']['metal']." <br>Crystal: ".$pricelist['209']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['209']['deuterium']." <br>Tachyon: ".$pricelist['209']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['210']."</th><th>".$planetrow[$resource['210']]."</th><th><input name=".$scrapid['210']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['210']['metal']." <br>Crystal: ".$pricelist['210']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['210']['deuterium']." <br>Tachyon: ".$pricelist['210']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['211']."</th><th>".$planetrow[$resource['211']]."</th><th><input name=".$scrapid['211']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['211']['metal']." <br>Crystal: ".$pricelist['211']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['211']['deuterium']." <br>Tachyon: ".$pricelist['211']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['212']."</th><th>".$planetrow[$resource['212']]."</th><th><input name=".$scrapid['212']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['212']['metal']." <br>Crystal: ".$pricelist['212']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['212']['deuterium']." <br>Tachyon: ".$pricelist['212']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['213']."</th><th>".$planetrow[$resource['213']]."</th><th><input name=".$scrapid['213']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['213']['metal']." <br>Crystal: ".$pricelist['213']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['213']['deuterium']." <br>Tachyon: ".$pricelist['213']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['214']."</th><th>".$planetrow[$resource['214']]."</th><th><input name=".$scrapid['214']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['214']['metal']." <br>Crystal: ".$pricelist['214']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['214']['deuterium']." <br>Tachyon: ".$pricelist['214']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['215']."</th><th>".$planetrow[$resource['215']]."</th><th><input name=".$scrapid['215']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['215']['metal']." <br>Crystal: ".$pricelist['215']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['215']['deuterium']." <br>Tachyon: ".$pricelist['215']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['216']."</th><th>".$planetrow[$resource['216']]."</th><th><input name=".$scrapid['216']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['216']['metal']." <br>Crystal: ".$pricelist['216']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['216']['deuterium']." <br>Tachyon: ".$pricelist['216']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['217']."</th><th>".$planetrow[$resource['217']]."</th><th><input name=".$scrapid['217']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['217']['metal']." <br>Crystal: ".$pricelist['217']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['217']['deuterium']." <br>Tachyon: ".$pricelist['217']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['218']."</th><th>".$planetrow[$resource['218']]."</th><th><input name=".$scrapid['218']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['218']['metal']." <br>Crystal: ".$pricelist['218']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['218']['deuterium']." <br>Tachyon: ".$pricelist['218']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['401']."</th><th>".$planetrow[$resource['401']]."</th><th><input name=".$scrapid['401']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['202']['metal']." <br>Crystal: ".$pricelist['202']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['202']['deuterium']." <br>Tachyon: ".$pricelist['202']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['402']."</th><th>".$planetrow[$resource['402']]."</th><th><input name=".$scrapid['402']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['402']['metal']." <br>Crystal: ".$pricelist['402']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['402']['deuterium']." <br>Tachyon: ".$pricelist['402']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['403']."</th><th>".$planetrow[$resource['403']]."</th><th><input name=".$scrapid['403']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['403']['metal']." <br>Crystal: ".$pricelist['403']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['403']['deuterium']." <br>Tachyon: ".$pricelist['403']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['404']."</th><th>".$planetrow[$resource['404']]."</th><th><input name=".$scrapid['404']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['404']['metal']." <br>Crystal: ".$pricelist['404']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['404']['deuterium']." <br>Tachyon: ".$pricelist['404']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['405']."</th><th>".$planetrow[$resource['405']]."</th><th><input name=".$scrapid['405']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['405']['metal']." <br>Crystal: ".$pricelist['405']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['405']['deuterium']." <br>Tachyon: ".$pricelist['405']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['406']."</th><th>".$planetrow[$resource['406']]."</th><th><input name=".$scrapid['406']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['406']['metal']." <br>Crystal: ".$pricelist['406']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['406']['deuterium']." <br>Tachyon: ".$pricelist['406']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['407']."</th><th>".$planetrow[$resource['407']]."</th><th><input name=".$scrapid['407']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['407']['metal']." <br>Crystal: ".$pricelist['407']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['407']['deuterium']." <br>Tachyon: ".$pricelist['407']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['408']."</th><th>".$planetrow[$resource['408']]."</th><th><input name=".$scrapid['408']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['408']['metal']." <br>Crystal: ".$pricelist['408']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['408']['deuterium']." <br>Tachyon: ".$pricelist['408']['tachyon']."</th></tr>";

	$Page .= "<tr><th>".$scrapname['409']."</th><th>".$planetrow[$resource['409']]."</th><th><input name=".$scrapid['409']." type=text value=0></th>";
	$Page .= "<th>Metal: ".$pricelist['409']['metal']." <br>Crystal: ".$pricelist['409']['crystal']." ";
	$Page .= "<br>Deuterium: ".$pricelist['409']['deuterium']." <br>Tachyon: ".$pricelist['409']['tachyon']."</th></tr>";

	$Page .= "<tr><th colspan=4><input type=Submit value=Scrap></th></tr>";
	$Page .= "</tbody></tr></table></form>";
// Show Adsense Ad
if ($adsense_config['scrapyard_on'] == 1) {
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