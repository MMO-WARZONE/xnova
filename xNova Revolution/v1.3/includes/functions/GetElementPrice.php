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

	function GetElementPrice ($user, $planet, $Element, $userfactor = true)
	{
		global $pricelist, $resource, $lang;

		if ($userfactor)
			$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
          
     $is_buyeable = true; 
     $array = array( 
         'metal'      => $lang["Metal"], 
         'crystal'    => $lang["Crystal"], 
         'deuterium'  => $lang["Deuterium"],
         'darkmatter' => $lang["Darkmatter"],
         'energy_max' => $lang["Energy"] 
         ); 
  
    $text = "<div><fieldset style='border-width:thin; border-color:black; border-style:solid;'><legend>".$lang['fgp_require'] . "</legend>";
     $text .= "<table align='center' width='90%' border='0' cellspacing='3'>";
     
     // Colocamos los Iconos de los Requisitos
     $text .= "<tr>"; 
     foreach ($array as $ResType => $ResTitle) { 
         if ($pricelist[$Element][$ResType] != 0) {
                        $text .= "<td align='center'><img src='styles/images/requisitos/".$ResType.".png' width='40' alt='".$ResTitle."' title='".$ResTitle."'></td> ";
         } 
     }
     $text .= "</tr>";
     
     // Colocamos los textos de los requisitos
     $text .= "<tr>"; 
     foreach ($array as $ResType => $ResTitle) { 
         if ($pricelist[$Element][$ResType] != 0) { 
             $text .= "<td align='center'>"; 
             if ($userfactor) { 
                 $cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)); 
             } else { 
                 $cost = floor($pricelist[$Element][$ResType]); 
             } 
				if ($cost > $planet[$ResType])
				{
					$text .= "<b style=\"color:red;\"> <t title=\"-" . shortly_number ($cost - $planet[$ResType]) . "\">";
					$text .= "<span class=\"noresources\">" . shortly_number($cost) . "</span></t></b> ";
					$is_buyeable = false;
				}				else
					$text .= "<b style=\"color:lime;\">" . shortly_number($cost) . "</b> ";
			}
          
     }
     $text .= "</tr></table></fieldset></div>"; 
     return $text; 
 }  
?>
