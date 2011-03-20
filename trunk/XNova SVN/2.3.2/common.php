<?php
//version 1
//ini_set ('error_reporting', E_ALL);
header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");
header("Accept-Encoding: gzip, deflate");

if(file_exists($svn_root . 'config.php') && INSTALL != true )
{
    if(filesize($svn_root . 'config.php') == 0  ){

	exit ( header ( "location:" . $svn_root .  "install/" ) );
    }

}
if(!file_exists($svn_root . 'config.php') && INSTALL != true){
    exit ( header ( "location:" . $svn_root .  "install/" ) );
}

$phpEx			= "php";

include_once($svn_root . 'includes/constants.'.$phpEx);
include_once($svn_root . 'includes/functions.'.$phpEx);
include_once($svn_root."includes/functions/classes/class.TemplatePower.inc.".$phpEx);	

include($svn_root.'includes/functions/classes/Console.'.$phpEx);

include($svn_root.'includes/functions/classes/PhpQuickProfiler.'.$phpEx);

include($svn_root.'includes/functions/classes/MySqlDatabase.'.$phpEx);

include($svn_root . 'includes/functions/classes/class.plugins.' . $phpEx);

$db = new MySqlDatabase();
include($svn_root. "includes/displays.".$phpEx);

$displays=new displays();
include($svn_root . 'includes/functions/classes/class.user.'.$phpEx);

$users=new users();
if(INSTALL != true)
{
        $plugin = new plugins();
	include($svn_root . 'includes/vars.'.$phpEx);
	include($svn_root . 'includes/functions/CreateOneMoonRecord.'.$phpEx);
	include($svn_root . 'includes/functions/CreateOnePlanetRecord.'.$phpEx);

        define('DEFAULT_LANG'	, ($db->game_config['lang']	   == '') ? "es" : 	$db->game_config['lang']	);
	
	includeLang('GAME');
	
	if ($InLogin != true)
	{	
                $users->CheckUser();
                if($db->game_config['game_disable'] == 1 && $users->user['authlevel'] == 0)
		{
			$displays->message(stripslashes($db->game_config['close_reason']));
		}
	}

	if(time() >= ($db->game_config['stat_last_update'] + (60 * $db->game_config['stat_update_time'])))
	{
		update_config('stat_last_update', time());
		include($svn_root . 'includes/pages/admin/statfunctions.' . $phpEx);
		$stats= new statfunction();
                $result=$stats->MakeStats();

		update_config('stat_last_update', $result['stats_time']);
                unset($result,$stats);
	}

	if (isset($users->user) && !empty ($users->user))
	{

                include($svn_root . "includes/functions/classes/class.FlyingFleetHandler.".$phpEx);                      
                $fleethand=new FlyingFleetHandlers();


                //$_fleets = $db->query("SELECT * FROM {{table}} WHERE (`fleet_start_time` <= '".time()."') OR (`fleet_end_time` <= '".time()."');", 'fleets' ); //  OR fleet_end_time <= ".time()
                $_fleets = $db->query("SELECT * FROM {{table}}", 'fleets' ); //  OR fleet_end_time <= ".time()

                while ($row =  mysql_fetch_array($_fleets))
		{
			if($row['fleet_owner'] == $users->user['id'] or $row['fleet_target_owner'] == $users->user['id'])
			{
				$array                = array();
				$array['galaxy']      = $row['fleet_start_galaxy'];
				$array['system']      = $row['fleet_start_system'];
				$array['planet']      = $row['fleet_start_planet'];

				if($row['fleet_start_time'] <= time()){
					$array['planet_type'] = $row['fleet_start_type'];
				}else{
					$array['planet_type'] = $row['fleet_end_type'];
                                }

				$fleethand->FlyingFleetHandler($array);
				unset($array);
			}
			unset($row);
		}
		unset($_fleets);

		if ( defined('IN_ADMIN') )
		{
			includeLang('ADMIN');

			$dpath     = "./". DEFAULT_SKINPATH  ;
		}
		else
		{
			$dpath     = (!$users->user["dpath"]) ? DEFAULT_SKINPATH : $users->user["dpath"];
		}

		include($svn_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
		SetSelectedPlanet ($users->user);

                $planetrow = $db->query("SELECT * FROM `{{table}}` WHERE `id` = '".$users->user['current_planet']."';", "planets", true );
                include($svn_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
		CheckPlanetUsedFields($planetrow);
	}
}
else
{
	$dpath     = "../" . DEFAULT_SKINPATH;
}

?>