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

function ShowLeftMenu ($Level)
{
	global $game_config, $dpath, $user, $lang;;

	$parse					= $lang;
	$parse['dpath']			= $dpath;
	$parse['version']   	= VERSION;
	$parse['servername']	= $game_config['game_name'];
	$parse['lm_tx_serv']	= $game_config['resource_multiplier'];
	$parse['lm_tx_game']    = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']   = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']   = MAX_FLEET_OR_DEFS_PER_ROW;
	$parse['forum_url']     = $game_config['forum_url'];
	$parse['servername']   	= $game_config['game_name'];
	$rank                   = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']     = $rank['total_rank'];

	if ($Level > 0)
		$parse['admin_link']	="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><a href=\"javascript:top.location.href='adm/index.php'\"> <font color=\"#99cc00\">Acceder al CPanel </font></a></div>";
	else
		$parse['admin_link']  	= "";
		

    if($user["new_message"]!=0){
        $color="color=\"red\"";
    }else{
        $color="color=\"white\"";
    }
    $parse["new_message"]    = ' (<font size="1px" '.$color.' > '. $user["new_message"].' </font>)';



	return parsetemplate(gettemplate('left_menu'), $parse);
}
?>
