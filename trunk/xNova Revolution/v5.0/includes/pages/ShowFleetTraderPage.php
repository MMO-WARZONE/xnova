<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @link: http://www.xnovarevolution.con.ar

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

function ShowFleetTraderPage()
{
	global $USER, $PLANET, $LNG, $CONF, $pricelist, $resource;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$CONF['trade_allowed_ships']	= explode(',', $CONF['trade_allowed_ships']);
	$ID								= request_var('id', 0);
	if(!empty($ID) && in_array($ID, $CONF['trade_allowed_ships'])) {
		$Count						= max(min(request_var('count', '0'), $PLANET[$resource[$ID]]), 0);
		$PLANET['metal']			= bcadd($PLANET['metal'], bcmul($Count, bcmul($pricelist[$ID]['metal'], (float) (1 - $CONF['trade_charge']))));
		$PLANET['crystal']			= bcadd($PLANET['crystal'], bcmul($Count, bcmul($pricelist[$ID]['crystal'], (float) (1 - $CONF['trade_charge']))));
		$PLANET['deuterium']		= bcadd($PLANET['deuterium'], bcmul($Count, bcmul($pricelist[$ID]['deuterium'], (float) (1 - $CONF['trade_charge']))));
		$PLANET['norio']			= bcadd($PLANET['norio'], bcmul($Count, bcmul($pricelist[$ID]['norio'], (float) (1 - $CONF['trade_charge']))));
		$USER['darkmatter']			= bcadd($USER['darkmatter'], bcmul($Count, bcmul($pricelist[$ID]['darkmatter'], (float) (1 - $CONF['trade_charge']))));
		$PlanetRess->Builded[$ID]	= bcadd(bcmul('-1', $Count), $PlanetRess->Builded[$ID]);
	}
	
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$template->loadscript('fleettrader.js');
	$template->execscript('updateVars();');
	$Cost	= array();
	foreach($CONF['trade_allowed_ships'] as $ID)
	{
		$Cost[$ID]	= array($PLANET[$resource[$ID]], $pricelist[$ID]['metal'], $pricelist[$ID]['crystal'], $pricelist[$ID]['deuterium'], $pricelist[$ID]['darkmatter'], $pricelist[$ID]['norio']);
	}
	$template->assign_vars(array(	
		'tech'						=> $LNG['tech'],
		'ft_head'					=> $LNG['ft_head'],
		'ft_count'					=> $LNG['ft_count'],
		'ft_max'					=> $LNG['ft_max'],
		'ft_total'					=> $LNG['ft_total'],
		'ft_charge'					=> $LNG['ft_charge'],
		'ft_absenden'				=> $LNG['ft_absenden'],
		'trade_allowed_ships'		=> $CONF['trade_allowed_ships'],
		'CostInfos'					=> json_encode($Cost),
		'Charge'					=> $CONF['trade_charge'],
	));
	
	$template->show("fleettrader_overview.tpl");
}
?>