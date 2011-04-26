<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = '../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 2) die(message ($lang['not_enough_permissions']));

	$parse = $lang;

	if(!$_POST['Optimizar'])
	{
		$Tablas = doquery("SHOW TABLES","todas");
		while ($row = mysql_fetch_assoc($Tablas))
		{
			foreach ($row as $opcion => $tabla)
			{
				$parse['tabla'] .= "<tr>";
				$parse['tabla'] .= "<th colspan=\"2\">".$tabla."</th>";
				$parse['tabla'] .= "</tr>";
			}
		}
	}
	else
	{
		$Tablas = doquery("SHOW TABLES",'todas');
		while ($row = mysql_fetch_assoc($Tablas))
		{
			foreach ($row as $opcion => $tabla)
			{
				doquery("OPTIMIZE TABLE {$tabla}", "$tabla");
				if (mysql_errno())
				{
					$parse['tabla'] .= "<tr>";
					$parse['tabla'] .= "<th>".$tabla."</th>";
					$parse['tabla'] .= "<th colspan=\"2\" style=\"color:red\">".$lang['od_not_opt']."</th>";
					$parse['tabla'] .= "</tr>";
				}
				else
					{
					$parse['tabla'] .= "<tr>";
					$parse['tabla'] .= "<th>".$tabla."</th>";
					$parse['tabla'] .= "<th style=\"color:green\">".$lang['od_opt']."</th>";
					$parse['tabla'] .= "</tr>";
				}
			}
		}
	}

	display(parsetemplate(gettemplate('adm/optimicedb'), $parse), false, '', true, false);

?>