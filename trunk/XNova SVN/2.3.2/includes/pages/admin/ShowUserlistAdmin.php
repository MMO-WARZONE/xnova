<?php
//version 1
function DeleteSelectedUser($UserID)
	{
            global $db;
		$TheUser = $db->query ( "SELECT * FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users', true );

		if ( $TheUser['ally_id'] != 0 )
		{
			$TheAlly = $db->query ( "SELECT * FROM {{table}} WHERE `id` = '" . $TheUser['ally_id'] . "';", 'alliance', true );
			$TheAlly['ally_members'] -= 1;

			if ($TheAlly['ally_members'] > 0)
			{
				$db->query ( "UPDATE {{table}} SET `ally_members` = '" . $TheAlly['ally_members'] . "' WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
			}
			else
			{
				$db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $TheAlly['id'] . "';", 'alliance' );
				$db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '" . $TheAlly['id'] . "';", 'statpoints' );
			}
		}

		$db->query ( "DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '" . $UserID . "';", 'statpoints' );

		$ThePlanets = $db->query ( "SELECT * FROM {{table}} WHERE `id_owner` = '" . $UserID . "';", 'planets' );

		while ( $OnePlanet = mysql_fetch_assoc ( $ThePlanets ) )
		{

			$db->query ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $OnePlanet['galaxy'] . "'
				 AND `system` = '" . $OnePlanet['system'] . "'
				 AND `planet` = '" . $OnePlanet['planet'] . "';", 'galaxy' );
			$db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $OnePlanet['id'] . "';", 'planets' );
		}

		$db->query ( "DELETE FROM {{table}} WHERE `message_sender` = '" . $UserID . "';", 'messages' );
		$db->query ( "DELETE FROM {{table}} WHERE `message_owner` = '" . $UserID . "';", 'messages' );
		$db->query ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'notes' );
		$db->query ( "DELETE FROM {{table}} WHERE `fleet_owner` = '" . $UserID . "';", 'fleets' );
		$db->query ( "DELETE FROM {{table}} WHERE `id_owner1` = '" . $UserID . "';", 'rw' );
		$db->query ( "DELETE FROM {{table}} WHERE `id_owner2` = '" . $UserID . "';", 'rw' );
		$db->query ( "DELETE FROM {{table}} WHERE `sender` = '" . $UserID . "';", 'buddy' );
		$db->query ( "DELETE FROM {{table}} WHERE `owner` = '" . $UserID . "';", 'buddy' );
		$db->query ( "DELETE FROM {{table}} WHERE `player_id` = '" . $UserID . "';", 'supp' );
		$db->query ( "DELETE FROM {{table}} WHERE `id` = '" . $UserID . "';", 'users' );
                $users_amount = $db->config_config["users_amount"]-1;
		$db->query ( "UPDATE `{{table}}` SET `config_value` = '".abs($users_amount)."' WHERE CONVERT( `config_name` USING utf8 ) = 'users_amount' LIMIT 1 ;", "config" );
	}

function ShowUserlistAdmin($user){
	global $lang,$svn_root,$db, $displays;
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

	

//	$parse	= $lang;

	if ($_GET['cmd'] == 'dele')
		DeleteSelectedUser ($_GET['user']);
	if ($_GET['cmd'] == 'sort')
		$TypeSort = $_GET['type'];
	else
		$TypeSort = "id";

	$query   = $db->query("SELECT `id`,`username`,`email`,`ip_at_reg`,`user_lastip`,`register_time`,`onlinetime`,`bana`,`banaday`, `activate_status` FROM {{table}} ORDER BY `". $TypeSort ."` ASC", 'users');

	$lang['adm_ul_table'] = "";
	$i                     = 0;
	$Color                 = "green ";
	
        $displays->assignContent("adm/userlist_body");

	while ($u = mysql_fetch_assoc($query))
	{
                $displays->newblock("lista_jugadores");
		$i++;

		if ($PrevIP != "")
		{
			if ($PrevIP == $u['user_lastip'])
				$Color = "red";
			else
				$Color = "green";
		}

		$Bloc['adm_ul_data_id']     		= $u['id'];
		$Bloc['adm_ul_data_name']   		= $u['username'];
		$Bloc['adm_ul_data_mail']   		= $u['email'];
		$Bloc['ip_adress_at_register']   	= $u['ip_at_reg'];
		$Bloc['adm_ul_data_adip']   		= "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>";
		$Bloc['adm_ul_data_regd']   		= gmdate ( "d/m/Y G:i:s", $u['register_time'] );
		$Bloc['adm_ul_data_lconn']  		= gmdate ( "d/m/Y G:i:s", $u['onlinetime'] );
		$Bloc['adm_ul_data_banna']  		= ($u['bana'] == 1) ? "<a href=# title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">".$lang['ul_yes']."</a>" : $lang['ul_no'];
		$Bloc['adm_ul_data_actio']  		= ($u['id'] != $user['id'] && $user['authlevel'] >= 3) ? "<a href=\"?page=userlist&cmd=dele&user=".$u['id']."\" border=\"0\" onclick=\"return confirm('".$lang['ul_sure_you_want_dlte']."  $u[username]?');\"><img border=\"0\" src=\"".$svn_root."styles/images/r1.png\"></a>" : "-";
		$PrevIP                     		= $u['user_lastip'];
		//$Bloc['actived']    			= $u['activate_status']==1 ? "Si" : "No";
                $Bloc['actived']                        = gmdate ( "d/m/Y G:i:s", $u['activate_status'] );

	foreach ($Bloc as $key => $value) {
            $displays->assign($key,$value);
        }


	}
	$lang['adm_ul_count'] 					= $i;

	$displays->display();

}
?>