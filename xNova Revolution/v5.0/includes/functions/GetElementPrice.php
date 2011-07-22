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

/*function GetElementPrice ($USER, $PLANET, $Element, $USERfactor = true) { 
     global $pricelist, $resource, $LNG; 
		if ($USERfactor)
			$level = (isset($PLANET[$resource[$Element]])) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'norio'      => $LNG['Norio'],
			'energy_max' => $LNG['Energy'],
		    'darkmatter' => $LNG['Darkmatter'],
		);
		$text = "";
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= $ResTitle . ": ";
				$cost  = $USERfactor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
				$text .= (isset($PLANET[$ResType]) && $cost > $PLANET[$ResType]) || (isset($USER[$ResType]) && $cost > $USER[$ResType]) ? "<b style=\"color:red;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> " : "<b style=\"color:lime;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> ";
			}
		}
    return $text; 
} */

function GetElementPrice ($USER, $PLANET, $Element, $USERfactor = true, $level = false)
	{
		global $pricelist, $resource, $LNG, $dpath;

		//if ($USERfactor) // OLD CODE
		if ($USERfactor && ($level === false)) // FIX BY JSTAR
			$level = ($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$is_buyeable = true;

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'norio'      => $LNG['Norio'],
			'energy_max' => $LNG['Energy'],
		    'darkmatter' => $LNG['Darkmatter'],
		);

 $text = "<div><fieldset style='border-width:thin; border: 1px solid #000000;background:url(styles/theme/gow/img/build.png); border-radius:10px;-moz-border-radius:10px;'><legend><font color='#FFFFFF'>".$LNG['fgp_require'] . "</font></legend>";
     $text .= "<table align='center' width='90%' border='0' cellspacing='3'>";
     
     // Colocamos los Iconos de los Requisitos
     $text .= "<tr>"; 
     foreach ($array as $ResType => $ResTitle) { 
         if ($pricelist[$Element][$ResType] != 0) {

                        $text .= "<td align=center><img src=styles/theme/gow/adds/" .$ResType .".jpg alt=" .$ResTitle ."></td>";					
         } 
     }
     $text .= "</tr>";
     
     // Colocamos los textos de los requisitos
     $text .= "<tr>"; 
     foreach ($array as $ResType => $ResTitle) { 
         if ($pricelist[$Element][$ResType] != 0) { 
             $text .= "<td align='center'>"; 
             if ($USERfactor) { 
                 $cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)); 
             } else { 
                 $cost = floor($pricelist[$Element][$ResType]); 
             } 
				if ($cost > $PLANET[$ResType])
				{
					$text .= "<b style=\"color:red;\"> <t title=\"-" . pretty_number ($cost - $PLANET[$ResType]) . "\">";
					$text .= "<span class=\"noresources\">" . pretty_number($cost) . "</span></t></b> ";
					$is_buyeable = false;
				}				else
					$text .= "<b style=\"color:lime;\">" . pretty_number($cost) . "</b> ";
			}
          
     }
     $text .= "</tr></table></fieldset></div>"; 
     return $text; 
 }  
 
?>