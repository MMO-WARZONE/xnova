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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function InsertHangarListScript ($CallProgram)
	{
		global $lang;

		$TechListScript  = "<script type=\"text/javascript\">\n";
		$TechListScript .= "<!--\n";
		$TechListScript .= "function han_t() {\n";
		$TechListScript .= "	han_v           = new Date();\n";
		$TechListScript .= "	var han_blc     = document.getElementById('han_blc');\n";
		$TechListScript .= "	var han_timeout = 1;\n";
		$TechListScript .= "	han_n           = new Date();\n";
		$TechListScript .= "	han_ss          = han_pp;\n";
		$TechListScript .= "	han_aa          = Math.round( (han_n.getTime() - han_v.getTime() ) / 1000. );\n";
		$TechListScript .= "	han_s           = han_ss - han_aa;\n";
		$TechListScript .= "	han_m           = 0;\n";
		$TechListScript .= "	han_h           = 0;\n\n";
		$TechListScript .= "	if ( (han_ss + 3) < han_aa ) {\n";
		$TechListScript .= "		han_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + han_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "		if ((han_ss + 6) >= han_aa) {\n";
		$TechListScript .= "			window.setTimeout('document.location.href=\"game.php?page=". $CallProgram ."&planet=' + han_pl + '\";', 3500);\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "	} else {\n";
		$TechListScript .= "		if ( han_s < 0 ) {\n";
		$TechListScript .= "			if (1) {\n";
		$TechListScript .= "				han_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + han_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "				window.setTimeout('document.location.href=\"game.php?page=". $CallProgram ."&planet=' + han_pl + '\";', 2000);\n";
		$TechListScript .= "			} else {\n";
		$TechListScript .= "				timeout = 0;\n";
		$TechListScript .= "				han_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + han_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "		} else {\n";
		$TechListScript .= "			if ( han_s > 59) {\n";
		$TechListScript .= "				han_m = Math.floor( han_s / 60);\n";
		$TechListScript .= "				han_s = han_s - han_m * 60;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( han_m > 59) {\n";
		$TechListScript .= "				han_h = Math.floor( han_m / 60);\n";
		$TechListScript .= "				han_m = han_m - han_h * 60;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( han_s < 10 ) {\n";
		$TechListScript .= "				han_s = \"0\" + han_s;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( han_m < 10 ) {\n";
		$TechListScript .= "				han_m = \"0\" + han_m;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if (1) {\n";
		$TechListScript .= "				han_blc.innerHTML = han_h + \":\" + han_m + \":\" + han_s + \"<br>\";\n";
		$TechListScript .= "			} else {\n";
		$TechListScript .= "				han_blc.innerHTML = han_h + \":\" + han_m + \":\" + han_s + \"<br>\";\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "		han_pp = han_pp - 1;\n";
		$TechListScript .= "		if (han_timeout == 1) {\n";
		$TechListScript .= "			window.setTimeout(\"han_t();\", 999);\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "	}\n";
		$TechListScript .= "}\n";
		$TechListScript .= "//-->\n";
		$TechListScript .= "</script>\n";

		return $TechListScript;
	}

?>