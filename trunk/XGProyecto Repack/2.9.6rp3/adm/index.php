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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 1) die(message ($lang['404_page']));

	$page = '<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>'. $game_config['game_name'] .' - Admin CP</title> 
<link rel="shortcut icon" href="./../favicon.ico"> 
</head> 
<body>
<iframe src="menu.php" name="rightFrame" id="rightFrame" frameborder="0" border="0" style="position:fixed;top:0px;left:0px;width:20%;height:100%;"></iframe>
<iframe src="topnav.php" name="topFrame" id="topFrame" frameborder="0" border="0" style="position:fixed;top:0px;right:0px;width:80%;height:15%;"></iframe>
<iframe src="OverviewPage.php" name="Hauptframe" id="mainFrame" frameborder="0" border="0" style="position:fixed;bottom:1px;right:0px;width:80%;height:85%;"></iframe>
</html> ';
	echo $page;
?>