<?php

//version 1

function SortUserPlanets ($CurrentUser)
{
        global $db;
	$Order = ( $CurrentUser['planet_sort_order'] == 1 ) ? "DESC" : "ASC" ;
	$Sort  = $CurrentUser['planet_sort'];

	//$QryPlanets  = "SELECT `id`, `name`, `galaxy`, `system`, `planet`, `planet_type` FROM {{table}} WHERE `id_owner` = '". $CurrentUser['id'] ."' AND `destruyed` = 0 ORDER BY ";
        $QryPlanets  = "SELECT `id`, `name`, `galaxy`, `system`, `planet`, `planet_type` FROM {{table}} WHERE `id_owner` = '". $CurrentUser['id'] ."' ORDER BY ";

	if($Sort == 0){
		$QryPlanets .= "`id` ". $Order;
        }elseif($Sort == 1){
		$QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
        }elseif ($Sort == 2){
		$QryPlanets .= "`name` ". $Order;
        }
	$Planets = $db->query($QryPlanets, 'planets' );

	return $Planets;
}
?>