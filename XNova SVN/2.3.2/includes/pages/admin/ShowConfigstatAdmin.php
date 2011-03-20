<?php
//version 1.2

function ShowConfigstatAdmin($user){
	global $lang,$db, $displays;

if ($user['authlevel'] < 3) die($displays->message ($lang['not_enough_permissions']));

	if ($_POST['save'] == $lang['cs_save_changes'])
	{
		if (isset($_POST['stat']) && $_POST['stat'] != $db->game_config['stat'])
		{
			update_config('stat' , $_POST['stat']);
 			$db->game_config['stat'] = $_POST['stat'];
		}
		if (isset($_POST['stat_level']) &&  is_numeric($_POST['stat_level']) && $_POST['stat_level'] != $db->game_config['stat_level'])
		{
			update_config('stat_level',  $_POST['stat_level']);
			$db->game_config['stat_level'] = $_POST['stat_level'];
		}
		if (isset($_POST['stat_flying']) && $_POST['stat_flying'] != $db->game_config['stat_flying'])
		{
			update_config('stat_flying',  $_POST['stat_flying']);
			$db->game_config['stat_flying']	= $_POST['stat_flying'];
		}
		if (isset($_POST['stat_settings']) &&  is_numeric($_POST['stat_settings']) && $_POST['stat_settings'] != $db->game_config['stat_settings'])
		{
			update_config('stat_settings',  $_POST['stat_settings']);
			$db->game_config['stat_settings'] = $_POST['stat_settings'];
		}
		if (isset($_POST['stat_amount']) &&  is_numeric($_POST['stat_amount']) && $_POST['stat_amount'] != $db->game_config['stat_amount'] && $_POST['stat_amount'] >= 10)
		{
			update_config('stat_amount',  $_POST['stat_amount']);
			$db->game_config['stat_amount']	= $_POST['stat_amount'];
		}
		if (isset($_POST['stat_update_time']) &&  is_numeric($_POST['stat_update_time']) && $_POST['stat_update_time'] != $db->game_config['stat_update_time'])
		{
			update_config('stat_update_time',  $_POST['stat_update_time']);
			$db->game_config['stat_update_time'] = $_POST['stat_update_time'];
		}
		$displays->message("Configuaracion de estadisticas Guardadas","admin.php?page=configstat");
		
	}
	else
	{
		
		$selected			=	"selected=\"selected\"";
		$stat				=	(($db->game_config['stat'] == 1)? 'sel_sta1':'sel_sta0');
		$lang[$stat]			=	$selected;
		$stat_fly			=	(($db->game_config['stat_flying'] == 1)? 'sel_sf1':'sel_sf0');
		$lang[$stat_fly]		=	$selected;
		$lang['stat_level']		=	$db->game_config['stat_level'];
		$lang['stat_settings']		=	$db->game_config['stat_settings'];
		$lang['stat_amount']		=	$db->game_config['stat_amount'];
		$lang['stat_update_time']	=	$db->game_config['stat_update_time'];
		
                $displays->assignContent('adm/configstats_body');

                $displays->display();

	
	}
}
?>