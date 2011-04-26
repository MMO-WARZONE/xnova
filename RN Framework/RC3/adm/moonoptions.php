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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] != 3) die(message ($lang['not_enough_permissions']));

	$parse	= $lang;

	if ($_POST && $_POST['add_moon'])
	{
		$PlanetID  = $_POST['add_moon'];
		$MoonName  = $_POST['name'];

		$QrySelectPlanet  = "SELECT * FROM {{table}} ";
		$QrySelectPlanet .= "WHERE ";
		$QrySelectPlanet .= "`id` = '". $PlanetID ."';";
		$PlanetSelected   = doquery ( $QrySelectPlanet, 'planets', true);

		$Galaxy    = $PlanetSelected['galaxy'];
		$System    = $PlanetSelected['system'];
		$Planet    = $PlanetSelected['planet'];
		$Owner     = $PlanetSelected['id_owner'];
		$MoonID    = time();

		CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, 20 );

		message ($lang['mo_moon_added'],"moonoptions.php",2);
	}
	elseif($_POST && $_POST['del_moon'])
	{
		$MoonID        	  = $_POST['del_moon'];

		$QrySelectMoon  = "SELECT * FROM {{table}} ";
		$QrySelectMoon .= "WHERE ";
		$QrySelectMoon .= "`id` = '". $MoonID ."';";
		$MoonSelected = doquery ( $QrySelectMoon, 'lunas', true);

		$Galaxy    = $MoonSelected['galaxy'];
		$System    = $MoonSelected['system'];
		$Planet    = $MoonSelected['lunapos'];
		$Owner     = $MoonSelected['id_owner'];


		$DeleteMoonQry1  = "DELETE FROM {{table}} WHERE `id` = '".$MoonID."';";
		doquery($DeleteMoonQry1, 'lunas');

		$DeleteMoonQry2  = "DELETE FROM {{table}} WHERE `galaxy` ='".$Galaxy."' AND `system` ='".$System."' AND `planet` ='".$Planet."' AND `planet_type` = 3;";
		doquery($DeleteMoonQry2, 'planets');

		$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
		$QryUpdateGalaxy .= "`id_luna` = '0' ";
		$QryUpdateGalaxy .= "WHERE ";
		$QryUpdateGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
		$QryUpdateGalaxy .= "`system` = '". $System ."' AND ";
		$QryUpdateGalaxy .= "`planet` = '". $Planet ."' ";
		$QryUpdateGalaxy .= "LIMIT 1;";
		doquery( $QryUpdateGalaxy , 'galaxy');

		message ($lang['mo_moon_deleted'],"moonoptions.php",2);
	}
	else
		display (parsetemplate(gettemplate("adm/moonoptions"), $parse), false, '', true, false);

?>