<?php
##############################################################################
# *                    #
# * XG PROYECT                 #
# *                     #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar  #
# *                    #
# *                    #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.          #
# *                    #
# *  This program is distributed in the hope that it will be useful,   #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of    #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    #
# *  GNU General Public License for more details.        #
# *                    #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowTopKB()
{
	global $lang;
	//anzeige der Top 100 Liste
	includeLang('INGAME');
	$parse = $lang; 
	$RowsTPL = gettemplate('topkb/topkb_rows');
	$top = doquery ("SELECT * FROM {{table}} ORDER BY gesamtunits DESC LIMIT 100;", 'topkb');
	$a = 0;
	while($data = mysql_fetch_array($top)) {
		$a++;
		$timedeut = date("D d M H:i:s", $data['time']);
 
		$user1 = doquery("SELECT * FROM {{table}} WHERE username='".$data[2]."';", 'users',true);
		if ($data['fleetresult'] == "a" AND $user1['hof'] == 1) { 
		$bloc['top_fighters'] 		= "<a href=\"javascript:f('topkbuser.php?mode=". $data['rid'] ."', '');\"><font color=\"green\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"red\">". $data['defender'] ."</font></a>";
		} else if ($data['fleetresult'] == "r" AND  $user1['hof'] == 1) { 
		$bloc['top_fighters']       = "<a href=\"javascript:f('topkbuser.php?page=showtopkb&mode=". $data['rid'] ."', '');\"><font color=\"red\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"green\">". $data['defender'] ."</font></a>";
		} else if ($data['fleetresult'] == "w" AND $user1['hof'] == 1) {
		$bloc['top_fighters']       = "<a href=\"javascript:f('topkbuser.php?mode=". $data['rid'] ."', '');\">" .$data['angreifer'] ."<b> VS </b>". $data['defender'] ."</a>";
		}
    $bloc['top_rank']           = $a;
    $bloc['top_time']           = $timedeut;
    $bloc['top_units']          = pretty_number($data['gesamtunits']);
    $bloc['underrow']           = $lang['grata'] ."test";
    //  date("r", $data['time']);
    $parse['top_list'] .= parsetemplate($RowsTPL, $bloc);
    }
 display(parsetemplate(gettemplate('topkb/topkb'), $parse), false); 
 }
 ?>