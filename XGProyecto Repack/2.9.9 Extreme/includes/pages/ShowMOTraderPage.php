<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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

/*
 Mod by Think for xgproyect.net
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowMOTraderPage($CurrentUser, &$CurrentPlanet)
{
	global $phpEx, $lang;

	$parse = $lang;

	###### CONFIGURACIÓN / CONFIG #######
	//Activar reductor de números [0 para desactivar y 1 para activar] - Más información de esta función en el post original
	$parse['reductor_on'] = 0;
	
	//Cantidad de M0 que se dará cada 1 de metal: [Por defecto 0.1]
	$Ratio['metal'] = 0.1;
	
	//Cantidad de M0 que se dará cada 1 de cristal: [Por defecto 0.2]
	$Ratio['crystal'] = 0.2;
	
	//Cantidad de M0 que se dará cada 1 de deuterio: [Por defecto 0.4]
	$Ratio['deuterium'] = 0.4;
	
	//Recursos en tu juego. Si tienes más, puedes añadirlos aquí (Y en el template, claro)
	$resources = array("metal","crystal","deuterium");
	
	###### CÓDIGO A PARTIR DE AQUÍ. NO RECOMENDABLE MODIFICAR SIN SABER QUÉ SE ESTÁ HACIENDO... ####
	
	$TotalMO = 0;
	
	foreach($resources as $CurRes)
	{
		$parse['rate_'.$CurRes] = $Ratio[$CurRes];
		$parse[$CurRes."_max"] = floor($CurrentPlanet[$CurRes]);
		
		if($_POST AND $_POST[$CurRes] > 0)
		{
			if($_POST[$CurRes] > $CurrentPlanet[$CurRes])
				$$CurRes = round($CurrentPlanet[$CurRes]);
			else
				$$CurRes = intval(round($_POST[$CurRes]));
			
			$TotalMO += round($$CurRes * $Ratio[$CurRes]);
			$CurrentPlanet[$CurRes] -= $$CurRes;
		}
	}
	
	if($_POST)
	{
		if($TotalMO > 0)
		{
			doquery("UPDATE {{table}} SET `darkmatter` = `darkmatter` + ".$TotalMO." WHERE `id` = '".$CurrentUser['id']."'","users");
			$parse['events'] = $lang['mo_success_exchange'];
		}
		else
			message($lang['mo_noenoughres'],"game.php?page=motrader",5);
	}
	

	return display(parsetemplate(gettemplate('trader/MOtrader_body'),$parse));
}
?>