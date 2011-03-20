<?php
//version 1

function ShowResetAdmin ( $CurrentUser )
{
	global $phpEx,$lang,$db,$displays;

	if ($CurrentUser['authlevel'] < 3) die($displays->message ($lang['not_enough_permissions']));

		$db->query( "RENAME TABLE {{table}} TO {{table}}_s", 'planets');
		$db->query( "RENAME TABLE {{table}} TO {{table}}_s", 'users' );

		$db->query( "CREATE  TABLE IF NOT EXISTS {{table}} ( LIKE {{table}}_s );", 'planets');
		$db->query( "CREATE  TABLE IF NOT EXISTS {{table}} ( LIKE {{table}}_s );", 'users');

		$db->query( "TRUNCATE TABLE {{table}}", 'sac');
		$db->query( "TRUNCATE TABLE {{table}}", 'alliance');
		$db->query( "TRUNCATE TABLE {{table}}", 'banned');
		$db->query( "TRUNCATE TABLE {{table}}", 'buddy');
		$db->query( "TRUNCATE TABLE {{table}}", 'galaxy');
		$db->query( "TRUNCATE TABLE {{table}}", 'errors');
		$db->query( "TRUNCATE TABLE {{table}}", 'fleets');
		$db->query( "TRUNCATE TABLE {{table}}", 'messages');
		$db->query( "TRUNCATE TABLE {{table}}", 'notes');
		$db->query( "TRUNCATE TABLE {{table}}", 'rw');
		$db->query( "TRUNCATE TABLE {{table}}", 'statpoints');

		$AllUsers  = $db->query ("SELECT `username`,`password`,`email`,
				      `email_2`,`authlevel`,`galaxy`,`system`,`planet`,
				      `dpath`, `onlinetime`, `register_time`, `id_planet`
				      FROM {{table}};", 'users_s');
		$LimitTime = time() - (15 * (24 * (60 * 60)));
		$TransUser = 0;
		while ( $TheUser = mysql_fetch_assoc($AllUsers) )
		{
			if ( $TheUser['onlinetime'] > $LimitTime )
			{
				$UserPlanet     = $db->query ("SELECT `name`
							   FROM {{table}}
							   WHERE `id` = '". $TheUser['id_planet']."';"
							   , 'planets_s', true);
				if ($UserPlanet['name'] != "")
				{
					$QryInsertUser  = "INSERT INTO {{table}} SET ";
					$QryInsertUser .= "`username` = '".      $TheUser['username']      ."', ";
					$QryInsertUser .= "`email` = '".         $TheUser['email']         ."', ";
					$QryInsertUser .= "`email_2` = '".       $TheUser['email_2']       ."', ";
					$QryInsertUser .= "`id_planet` = '0', ";
					$QryInsertUser .= "`authlevel` = '".     $TheUser['authlevel']     ."', ";
					$QryInsertUser .= "`dpath` = '".         $TheUser['dpath']         ."', ";
					$QryInsertUser .= "`galaxy` = '".        $TheUser['galaxy']        ."', ";
					$QryInsertUser .= "`system` = '".        $TheUser['system']        ."', ";
					$QryInsertUser .= "`planet` = '".        $TheUser['planet']        ."', ";
					$QryInsertUser .= "`register_time` = '". $TheUser['register_time'] ."', ";
					$QryInsertUser .= "`password` = '".      $TheUser['password']      ."';";
					$db->query( $QryInsertUser, 'users');

					$NewUser        = $db->query("SELECT `id`
								  FROM {{table}}
								  WHERE `username` = '". $TheUser['username'] ."'
								  LIMIT 1;", 'users', true);

					CreateOnePlanetRecord ($TheUser['galaxy'], $TheUser['system'], $TheUser['planet'], $NewUser['id'], $UserPlanet['name'],	'', '', '', true);

					$PlanetID       = $db->query("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`id_planet` = '".      $PlanetID['id'] ."', ";
					$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".             $NewUser['id']  ."';";
					$db->query( $QryUpdateUser, 'users' );
					$TransUser++;
				}
			}
		}
		$db->query("UPDATE {{table}} SET `config_value` = '". $TransUser ."' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
		$db->query("DROP TABLE {{table}}", 'planets_s');
		$db->query("DROP TABLE {{table}}", 'users_s');

		header( "location:admin.php?page=overview");
}

?>