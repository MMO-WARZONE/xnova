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

function ShowChatPage($CurrentUser)
{
	global $game_config, $dpath, $lang;
	ini_set('display_error',0);
	ini_set('error_reporting',0);
  
    includeLang('INGAME');
    $nick = $CurrentUser['username'];
	    $parse = $lang;
    if (isset($_GET["chat_type"])) {
            $parse['chat_type'] = $_GET["chat_type"];
            $parse['ally_id']   = $CurrentUser['ally_id'];
		    display(parsetemplate(gettemplate('chat_body'), $parse),false,'',false,false);

    }
	else
	{
	display("<div id=\"content\">\n".parsetemplate(gettemplate('chat_body'), $parse)."\n</div>");
	}
}
// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>