<?php
//version 1.1

function ShowMoonOptAdmin($user){
	global $lang,$db, $displays;
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));



	if ($_POST && $_POST['add_moon'])
	{
		$PlanetID  = $_POST['add_moon'];
		$MoonName  = $_POST['name'];

		$QrySelectPlanet  = "SELECT * FROM {{table}} ";
		$QrySelectPlanet .= "WHERE ";
		$QrySelectPlanet .= "`id` = '". $PlanetID ."';";
		$PlanetSelected   = $db->query ( $QrySelectPlanet, 'planets', true);

		$Galaxy    = $PlanetSelected['galaxy'];
		$System    = $PlanetSelected['system'];
		$Planet    = $PlanetSelected['planet'];
		$Owner     = $PlanetSelected['id_owner'];
	

		CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner,  $MoonName, 20 );

		$displays->message ($lang['mo_moon_added'],"admin.php?page=moonopt",2);
	}
	elseif($_POST && $_POST['del_moon'])
	{
		$MoonID        	  = $_POST['del_moon'];

		$QrySelectMoon  = "SELECT * FROM {{table}} ";
		$QrySelectMoon .= "WHERE ";
		$QrySelectMoon .= "`id` = '". $MoonID ."';";
		$MoonSelected = $db->query ( $QrySelectMoon, 'planets', true);

		$Galaxy    = $MoonSelected['galaxy'];
		$System    = $MoonSelected['system'];
		$Planet    = $MoonSelected['planet'];
		$Owner     = $MoonSelected['id_owner'];
		
		
		$DeleteMoonQry1  = "DELETE FROM {{table}} WHERE `id` = '".$MoonID."';";
		$db->query($DeleteMoonQry1, 'planets');
		
		$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
		$QryUpdateGalaxy .= "`id_luna` = '0' ";
		$QryUpdateGalaxy .= "WHERE ";
		$QryUpdateGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
		$QryUpdateGalaxy .= "`system` = '". $System ."' AND ";
		$QryUpdateGalaxy .= "`planet` = '". $Planet ."' ";
		$QryUpdateGalaxy .= "LIMIT 1;";
		$db->query( $QryUpdateGalaxy , 'galaxy');

		$displays->message ($lang['mo_moon_deleted'],"admin.php?page=moonopt",2);
	}
	else{
                $displays->assignContent('adm/moonoptions');
                $displays->display();
	}
}
?>