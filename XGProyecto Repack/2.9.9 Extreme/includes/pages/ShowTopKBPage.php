<?php

##############################################################################
# *                                                                             #
# * XG PROYECT                                                                 #
# *                                                                           #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net           #
# *                                                                             #
# *                                                                             #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *                                                                             #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of             #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             #
# *  GNU General Public License for more details.                             #
# *                                                                             #
##############################################################################

if (!defined('INSIDE'))die(header("location:../../"));

    $parse = $lang;
     $top = doquery ("SELECT * FROM {{table}} ORDER BY `gesamttruemmer` DESC LIMIT 0,100;", 'topkb');
     $a = 0;
     
        while($data = mysql_fetch_assoc($top)){
            $a++;
            $timedeut = date("D d M H:i:s", $data['time']);
            $destrunits         = pretty_number($data['gesamtunits']); 

        if ($data['fleetresult'] == a) $bloc['top_fighters']       = "<a href=\"TopKBReport.php?raport=". $data['rid'] ."\" target=\"_new\"><font color=\"green\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"red\">". $data['defender'] ."</font></a>";
        elseif ($data['fleetresult'] == r) $bloc['top_fighters']       = "<a href=\"TopKBReport.php?raport=". $data['rid'] ."\" target=\"_new\"><font color=\"red\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"green\">". $data['defender'] ."</font></a>";
        else $bloc['top_fighters']       = "<a href=\"TopKBReport.php?raport=". $data['rid'] ."\" target=\"_new\">" .$data['angreifer'] ."<b> VS </b>". $data['defender'] ."</a>";

         $bloc['top_rank']           = $a;
         $bloc['destrunits']         = $destrunits; 
         $bloc['top_time']           = $timedeut;


        $parse['top_list'] .= parsetemplate(gettemplate('topkb/topkb_rows'), $bloc);
        }

    display(parsetemplate(gettemplate('topkb/topkb'), $parse));
    
?> 
