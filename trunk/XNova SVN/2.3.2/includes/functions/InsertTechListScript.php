<?php
//version 1
if(!defined('INSIDE')){ die(header("location:../../"));}

	function InsertTechListScript ($CallProgram, $NamePlanet)
	{
		global $lang;

		$TechListScript  = "<script type=\"text/javascript\">\n";
		$TechListScript .= "<!--\n";
		$TechListScript .= "function tec_t() {\n";
		$TechListScript .= "	tec_v           = new Date();\n";
		$TechListScript .= "	var tec_blc     = document.getElementById('tec_blc');\n";
		$TechListScript .= "	var tec_timeout = 1;\n";
		$TechListScript .= "	tec_n           = new Date();\n";
		$TechListScript .= "	tec_ss          = tec_pp;\n";
		$TechListScript .= "	tec_aa          = Math.round( (tec_n.getTime() - tec_v.getTime() ) / 1000. );\n";
		$TechListScript .= "	tec_s           = tec_ss - tec_aa;\n";
		$TechListScript .= "	tec_m           = 0;\n";
		$TechListScript .= "	tec_h           = 0;\n\n";
		$TechListScript .= "	if ( (tec_ss + 3) < tec_aa ) {\n";
		$TechListScript .= "		tec_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + tec_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "		if ((tec_ss + 6) >= tec_aa) {\n";
		$TechListScript .= "			window.setTimeout('document.location.href=\"game.php?page=". $CallProgram ."&planet=' + tec_pl + '\";', 3500);\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "	} else {\n";
		$TechListScript .= "		if ( tec_s < 0 ) {\n";
		$TechListScript .= "			if (1) {\n";
		$TechListScript .= "				tec_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + tec_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "				window.setTimeout('document.location.href=\"game.php?page=". $CallProgram ."&planet=' + tec_pl + '\";', 2000);\n";
		$TechListScript .= "			} else {\n";
		$TechListScript .= "				timeout = 0;\n";
		$TechListScript .= "				tec_blc.innerHTML = \"".$lang['bd_finished']."<br>\" + \"<a href=game.php?page=". $CallProgram ."&planet=\" + tec_pl + \">".$lang['bd_continue']."</a>\";\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "		} else {\n";
		$TechListScript .= "			if ( tec_s > 59) {\n";
		$TechListScript .= "				tec_m = Math.floor( tec_s / 60);\n";
		$TechListScript .= "				tec_s = tec_s - tec_m * 60;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( tec_m > 59) {\n";
		$TechListScript .= "				tec_h = Math.floor( tec_m / 60);\n";
		$TechListScript .= "				tec_m = tec_m - tec_h * 60;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( tec_s < 10 ) {\n";
		$TechListScript .= "				tec_s = \"0\" + tec_s;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if ( tec_m < 10 ) {\n";
		$TechListScript .= "				tec_m = \"0\" + tec_m;\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "			if (1) {\n";
		$TechListScript .= "				tec_blc.innerHTML = tec_h + \":\" + tec_m + \":\" + tec_s + \"<br><a href=game.php?page=". $CallProgram ."&mode=research&cmd=\" + tec_pm + \"&tech=\" + tec_pl + \">".$lang['bd_cancel'].$NamePlanet."</a>\";\n";
		$TechListScript .= "			} else {\n";
		$TechListScript .= "				tec_blc.innerHTML = tec_h + \":\" + tec_m + \":\" + tec_s + \"<br><a href=game.php?page=". $CallProgram ."&mode=research&cmd=\" + tec_pm + \"&tech=\" + tec_pl + \">".$lang['bd_cancel'].$NamePlanet."</a>\";\n";
		$TechListScript .= "			}\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "		tec_pp = tec_pp - 1;\n";
		$TechListScript .= "		if (tec_timeout == 1) {\n";
		$TechListScript .= "			window.setTimeout(\"tec_t();\", 999);\n";
		$TechListScript .= "		}\n";
		$TechListScript .= "	}\n";
		$TechListScript .= "}\n";
		$TechListScript .= "//-->\n";
		$TechListScript .= "</script>\n";

		return $TechListScript;
	}

?>