<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

	function CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, $Chance )
	{
		global $lang, $user;

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

		if ($MoonGalaxy['id_luna'] == 0)
		{
			if ($MoonPlanet['id'] != 0)
			{
				$SizeMin                = zround(pow ((3 * $Chance)+10,0.5) * 1000 );
				$SizeMax                = zround(pow ((3 * $Chance)+20,0.5) * 1000 );

				$PlanetName             = $MoonPlanet['name'];

				$maxtemp                = $MoonPlanet['temp_max'] - rand(10, 45);
				$mintemp                = $MoonPlanet['temp_min'] - rand(10, 45);
				$size                   = rand ($SizeMin, $SizeMax);

				$QryInsertMoonInLunas   = "INSERT INTO {{table}} SET ";
				$QryInsertMoonInLunas  .= "`name` = '". ( ($MoonName == '') ? $lang['fcm_moon'] : $MoonName ) ."', ";
				$QryInsertMoonInLunas  .= "`galaxy` = '".   $Galaxy  ."', ";
				$QryInsertMoonInLunas  .= "`system` = '".   $System  ."', ";
				$QryInsertMoonInLunas  .= "`lunapos` = '".  $Planet  ."', ";
				$QryInsertMoonInLunas  .= "`id_owner` = '". $Owner   ."', ";
				$QryInsertMoonInLunas  .= "`temp_max` = '". $maxtemp ."', ";
				$QryInsertMoonInLunas  .= "`temp_min` = '". $mintemp ."', ";
				$QryInsertMoonInLunas  .= "`diameter` = '". $size    ."', ";
				$QryInsertMoonInLunas  .= "`id_luna` = '".  $MoonID  ."';";
				doquery( $QryInsertMoonInLunas , 'lunas' );

				$QryGetMoonIdFromLunas  = "SELECT * FROM {{table}} ";
				$QryGetMoonIdFromLunas .= "WHERE ";
				$QryGetMoonIdFromLunas .= "`galaxy` = '".  $Galaxy ."' AND ";
				$QryGetMoonIdFromLunas .= "`system` = '".  $System ."' AND ";
				$QryGetMoonIdFromLunas .= "`lunapos` = '". $Planet ."';";
				$lunarow = doquery( $QryGetMoonIdFromLunas , 'lunas', true);

				$QryUpdateMoonInGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateMoonInGalaxy .= "`id_luna` = '". $lunarow['id'] ."', ";
				$QryUpdateMoonInGalaxy .= "`luna` = '0' ";
				$QryUpdateMoonInGalaxy .= "WHERE ";
				$QryUpdateMoonInGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
				$QryUpdateMoonInGalaxy .= "`system` = '". $System ."' AND ";
				$QryUpdateMoonInGalaxy .= "`planet` = '". $Planet ."';";
				doquery( $QryUpdateMoonInGalaxy , 'galaxy');

				$QryInsertMoonInPlanet  = "INSERT INTO {{table}} SET ";
				$QryInsertMoonInPlanet .= "`name` = '". ( ($MoonName == '') ? $lang['fcm_moon'] : $MoonName ) ."', ";
				$QryInsertMoonInPlanet .= "`id_owner` = '". $Owner ."', ";
				$QryInsertMoonInPlanet .= "`galaxy` = '". $Galaxy ."', ";
				$QryInsertMoonInPlanet .= "`system` = '". $System ."', ";
				$QryInsertMoonInPlanet .= "`planet` = '". $Planet ."', ";
				$QryInsertMoonInPlanet .= "`last_update` = '". time() ."', ";
				$QryInsertMoonInPlanet .= "`planet_type` = '3', ";
				$QryInsertMoonInPlanet .= "`image` = 'mond', ";
				$QryInsertMoonInPlanet .= "`diameter` = '". $size ."', ";
				$QryInsertMoonInPlanet .= "`field_max` = '1', ";
				$QryInsertMoonInPlanet .= "`temp_min` = '". $mintemp ."', ";
				$QryInsertMoonInPlanet .= "`temp_max` = '". $maxtemp ."', ";
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
			}
		}

		return $PlanetName;
	}

?>