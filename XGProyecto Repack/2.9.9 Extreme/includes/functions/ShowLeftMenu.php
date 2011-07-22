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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowLeftMenu ()
{ 
	global $xgp_root, $phpEx, $dpath, $game_config, $lang, $planetrow, $user, $lang;
   

	$parse					= $lang;
	$parse['dpath']			= $dpath;
    $parse['avatar']        = $user['avatar'];
	$parse['version']   	= VERSION;
	$parse['servername']	= $game_config['game_name'];
	$parse['forum_url']     = $game_config['forum_url'];
	$parse['user_rank']     = $user['total_rank'];
    $parse['opt_avata_data'] = $CurrentUser['avatar'];
    $parse['user_username']  = $user ['username'];
        
       // Mod cuenta mensajes by shoek
        $MenSoporte = doquery("SELECT COUNT(*) as total FROM `{{table}}` WHERE `player_id` = '".intval($CurrentUser['id'])."' AND `status` = '2';", 'supp', true);
        if ($MenSoporte['total'] > 0)
         $parse['NumSoporte']        = "(<a href=\"game.php?page=support\">".$MenSoporte['total']."</a>)";
        // Fin mod cuenta mensajes  


           
            if ($_POST && $mode == "change") { // Array ( [db_character]
            $iduser = $user["id"];
            $avatar = $_POST["avatar"];       
            }  

    if (isset($planetrow['sprungtor']) && $planetrow['sprungtor'] > 0)
      $parse['portal_link']="<tr><td><div align=\"center\"><a href='game.php?page=infos&gid=43' ><font color=\"green\">".($lang['tech'][43])."</font></a></div></td></tr>";  


	return parsetemplate(gettemplate('left_menu'), $parse);
}
?>