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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
include('AdminFunctions/Autorization.' . $phpEx);

if ($Observation != 1) die();

	$parse	= $lang;
	$query 	= doquery("SELECT * FROM {{table}} WHERE `planet_type` = '3'", "planets");
	$i 		= 0;

	while ($u = mysql_fetch_array($query))
	{
		$parse['moon'] .= "<tr>"
		. "<th>" . $u[0] . "</th>"
		. "<th>" . $u[1] . "</th>"
		. "<th>" . $u[2] . "</th>"
		. "<th>" . $u[4] . "</th>"
		. "<th>" . $u[5] . "</th>"
		. "<th>" . $u[6] . "</th>"
		. "</tr>";
		$i++;
	}

	if ($i == "1")
		$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['mt_only_one_moon']."</th></tr>";
	else
		$parse['moon'] .= "<tr><th class=b colspan=6>". $lang['mt_there_are'] . $i . $lang['mt_moons'] ."</th></tr>";

	display(parsetemplate(gettemplate('adm/MoonListBody'), $parse), false, '', true, false);
?>
