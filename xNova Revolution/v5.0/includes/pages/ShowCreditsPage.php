<?php

/**
 _  \_/ |\ | /пп\ \  / /\    |пп) |_п \  / /пп\ |  |   |┤п|п` | /пп\ |\ |5
 п  /п\ | \| \__/  \/ /--\   |пп\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @link: http://www.xnovarevolution.con.ar
 *
 * Please do not remove the credits
*/

function ShowCreditsPage()
{
	global $USER, $PLANET, $LNG, $LANG;

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$template->show("creditos_overview.tpl");
}
?>