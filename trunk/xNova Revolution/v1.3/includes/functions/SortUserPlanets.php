<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

function SortUserPlanets ($CurrentUser)
{
	$Order = ( $CurrentUser['planet_sort_order'] == 1 ) ? "DESC" : "ASC" ;
	$Sort  = $CurrentUser['planet_sort'];

	$QryPlanets  = "SELECT `id`, `name`, `galaxy`, `system`, `planet`, `planet_type` FROM {{table}} WHERE `id_owner` = '". $CurrentUser['id'] ."' AND `destruyed` = 0 ORDER BY ";

	if($Sort == 0)
		$QryPlanets .= "`id` ". $Order;
	elseif($Sort == 1)
		$QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
	elseif ($Sort == 2)
		$QryPlanets .= "`name` ". $Order;

	$Planets = doquery($QryPlanets, 'planets');

	return $Planets;
}
?>
