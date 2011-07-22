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

if(!defined('INSIDE')) die('Hacking attempt!');

	function GetBuildingTime ($USER, $PLANET, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $CONF, $requeriments, $ExtraDM, $OfficerInfo;

		$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
		if	   (in_array($Element, $reslist['build']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['norio'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ((TIMESTAMP - $USER[$resource[702]] <= 0) ? ($ExtraDM[702]['add']) : 0));
		elseif (in_array($Element, $reslist['defense']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['norio'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ((TIMESTAMP - $USER[$resource[706]] <= 0) ? ($ExtraDM[706]['add']) : 0) - ((TIMESTAMP - $USER[$resource[701]] <= 0) ? ($ExtraDM[701]['add']) : 0));
		elseif (in_array($Element, $reslist['fleet']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['norio'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ((TIMESTAMP - $USER[$resource[706]] <= 0) ? ($ExtraDM[706]['add']) : 0) - ((TIMESTAMP - $USER[$resource[705]] <= 0) ? ($ExtraDM[705]['add']) : 0));	
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			$cost_norio   = floor($pricelist[$Element]['norio']   * pow($pricelist[$Element]['factor'], $level));
			if(is_array($PLANET[$resource[31].'_inter']))
			{
				$Level = 0;
				foreach($PLANET[$resource[31].'_inter'] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			else
				$Level	= $PLANET[$resource[31]];
			
			if(NEW_RESEARCH)
				$time		  = ((($cost_metal + $cost_crystal + $cost_norio) / (1000 * (1 + $Level)) * (1 - $USER[$resource[606]] * $OfficerInfo[606]['info'])) / ($CONF['game_speed'] / 2500)) * 3600;
			else {
				$time         = (($cost_metal + $cost_crystal + $cost_norio) / $CONF['game_speed']) / (($Level + 1) * 2);
				$time         = $time * (1 - ((TIMESTAMP - $USER[$resource[705]] <= 0) ? (1 - $ExtraDM[705]['add']) : 1)) * 3600;
			}
			$time         = floor($time * ((TIMESTAMP - $USER[$resource[705]] <= 0) ? (1 - $ExtraDM[705]['add']) : 1) * pow((1 - UNIVERISTY_RESEARCH_REDUCTION), $PLANET[$resource[6]]));
		}
		
		return max((($Destroy)?floor($time / 2):floor($time)), $CONF['min_build_time']);
	}

?>