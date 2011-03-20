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
include($xgp_root . 'adm/statfunctions.' . $phpEx);

if ($user['authlevel'] < 2) die(message ($lang['not_enough_permissions']));

	$result			= MakeStats();
	$memory_p		= str_replace(array("%p", "%m"), $result['memory_peak'], $lang['sb_top_memory']);
	$memory_e		= str_replace(array("%e", "%m"), $result['end_memory'], $lang['sb_final_memory']);
	$memory_i		= str_replace(array("%i", "%m"), $result['initial_memory'], $lang['sb_start_memory']);
	$stats_end_time	= str_replace("%t", $result['totaltime'], $lang['sb_stats_update']);
	$stats_block	= str_replace("%n", $result['amount_per_block'], $lang['sb_users_per_block']);

	update_config( 'stat_last_update', $result['stats_time']);

	$using_flying 	= (($game_config['stat_flying']==1) ? $lang['sb_using_fleet_array'] : $lang['sb_using_fleet_query']);

	message($lang['sb_stats_updated'].$stats_end_time.$memory_i.$memory_e.$memory_p.$stats_block.$using_flying);


?>
