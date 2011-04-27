<?php

/**
 * CreateOneMoonRecord.php
 *
 * @version 1.1
 * @copyright 2008
 */
// ----------------------------------------------------------------------------------------------------------------
//
// Creation d'une lune (coté enregistrement dans la BDD)
//
function CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonName, $Chance ) {
	global $lang;

	$PlanetName            = "";

	$QryGetMoonPlanetData  = "SELECT * FROM {{table}} ";
	$QryGetMoonPlanetData .= "WHERE ";
	$QryGetMoonPlanetData .= "`galaxy` = '". $Galaxy ."' AND ";
	$QryGetMoonPlanetData .= "`system` = '". $System ."' AND ";
	$QryGetMoonPlanetData .= "`planet` = '". $Planet ."';";
	$MoonPlanet = doquery ( $QryGetMoonPlanetData, 'planets', true);

	$QryGetMoonGalaxyData  = "SELECT * FROM {{table}} ";
	$QryGetMoonGalaxyData .= "WHERE ";
	$QryGetMoonGalaxyData .= "`galaxy` = '". $Galaxy ."' AND ";
	$QryGetMoonGalaxyData .= "`system` = '". $System ."' AND ";
	$QryGetMoonGalaxyData .= "`planet` = '". $Planet ."';";
	$MoonGalaxy = doquery ( $QryGetMoonGalaxyData, 'galaxy', true);

	if ($MoonGalaxy['id_luna'] == 0) {
		if ($MoonPlanet['id'] != 0 && $MoonPlanet['planet_type'] != 3) {
			$SizeMin                = 2000 + ( $Chance * 100 );
			$SizeMax                = 6000 + ( $Chance * 200 );

			$PlanetName             = $MoonPlanet['name'];

			$maxtemp                = $MoonPlanet['temp_max'] - rand(10, 45);
			$mintemp                = $MoonPlanet['temp_min'] - rand(10, 45);
			$size                   = rand ($SizeMin, $SizeMax);

			$QryInsertMoonInPlanet  = "INSERT INTO {{table}} SET ";
			$QryInsertMoonInPlanet .= "`name` = '" .$lang['sys_moon'] ."', ";
			$QryInsertMoonInPlanet .= "`id_owner` = '". $Owner ."', ";
			$QryInsertMoonInPlanet .= "`galaxy` = '". $Galaxy ."', ";
			$QryInsertMoonInPlanet .= "`system` = '". $System ."', ";
			$QryInsertMoonInPlanet .= "`planet` = '". $Planet ."', ";
			$QryInsertMoonInPlanet .= "`last_update` = '". time() ."', ";
			$QryInsertMoonInPlanet .= "`planet_type` = '3', ";
			$QryInsertMoonInPlanet .= "`image` = 'mond', ";
			$QryInsertMoonInPlanet .= "`diameter` = '". $size ."', ";
			$QryInsertMoonInPlanet .= "`field_max` = '1', ";
			$QryInsertMoonInPlanet .= "`temp_min` = '". $maxtemp ."', ";
			$QryInsertMoonInPlanet .= "`temp_max` = '". $mintemp ."', ";
			$QryInsertMoonInPlanet .= "`metal` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`crystal` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`deuterium` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_max` = '".BASE_STORAGE_SIZE."';";
			doquery( $QryInsertMoonInPlanet , 'planets');

			$QryGetMoonIdFromPlanet  = "SELECT * FROM {{table}} ";
			$QryGetMoonIdFromPlanet .= "WHERE ";
			$QryGetMoonIdFromPlanet .= "`galaxy` = '".  $Galaxy ."' AND ";
			$QryGetMoonIdFromPlanet .= "`system` = '".  $System ."' AND ";
			$QryGetMoonIdFromPlanet .= "`planet` = '".  $Planet ."' AND ";			
			$QryGetMoonIdFromPlanet .= "`planet_type` = '3';";
			$lunarow = doquery( $QryGetMoonIdFromPlanet , 'planets', true);

			$QryUpdateMoonInGalaxy  = "UPDATE {{table}} SET ";
			$QryUpdateMoonInGalaxy .= "`id_luna` = '". $lunarow['id'] ."', ";
			$QryUpdateMoonInGalaxy .= "`luna` = '0' ";
			$QryUpdateMoonInGalaxy .= "WHERE ";
			$QryUpdateMoonInGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QryUpdateMoonInGalaxy .= "`system` = '". $System ."' AND ";
			$QryUpdateMoonInGalaxy .= "`planet` = '". $Planet ."';";
			doquery( $QryUpdateMoonInGalaxy , 'galaxy');


		}
	}

	return $PlanetName;
}

?>