<?php
//version 1

function ShowOnlineUsersAdmin($user){
	global $lang,$dpath,$db,$displays;
    if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

//$parse	= $lang;

if ($_GET['cmd'] == 'sort')
	$TypeSort = $_GET['type'];
else
	$TypeSort = "id";

$queryuser 	= "u.id, u.username, u.user_agent, u.current_page, u.user_lastip, u.ally_name, u.onlinetime, u.email, u.galaxy, u.system, u.planet, u.activate_status";
$querystat 	= "s.total_points";
$Last15Mins = $db->query("SELECT ". $queryuser .", ". $querystat ."
		      FROM  {{table}}users as u LEFT JOIN {{table}}statpoints as s
		      ON u.id=s.id_owner AND s.stat_type=1 WHERE u.onlinetime >= '". (time() - 15 * 60) ."' 
		      ORDER BY `". mysql_escape_string($TypeSort) ."` ASC;", '');


$Count      = 0;
$Color      = "lime";
$displays->assignContent("adm/onlineuser_table");
while ($TheUser = mysql_fetch_array($Last15Mins) )
{
        $displays->newblock("list_online");
	if ($PrevIP != "")
		if ($PrevIP == $TheUser['user_lastip'])
			$Color = "red";
	else
		$Color = "lime";

	//$Bloc['dpath']              = $dpath;
	$Bloc['adm_ov_data_id']     = $TheUser['id'];
	$Bloc['adm_ov_data_name']   = $TheUser['username'];
	$Bloc['adm_ov_data_agen']   = $TheUser['user_agent'];
	$Bloc['current_page']       = str_replace("%20", " ", $TheUser['current_page']);
	$Bloc['usr_s_id']    	    = $TheUser['id'];
	$Bloc['adm_ov_data_clip']   = $Color;
	$Bloc['adm_ov_data_adip']   = $TheUser['user_lastip'];
	$Bloc['adm_ov_data_ally']   = $TheUser['ally_name'];
	$Bloc['adm_ov_data_point']  = pretty_number ( $TheUser['total_points'] );
	$Bloc['adm_ov_data_activ']  = pretty_time ( time() - $TheUser['onlinetime'] );
	$Bloc['adm_ov_data_pict']   = "m.gif";
	$PrevIP                     = $TheUser['user_lastip'];
	$Bloc['usr_email']    	    = $TheUser['email'];
	if ($TheUser['urlaubs_modus'] == 1)
	{
		$Bloc['state_vacancy']  = "<img src=\"./styles/images/true.png\" >";
	}else{
		$Bloc['state_vacancy']  = "<img src=\"./styles/images/false.png\">";
	}
	if ($TheUser['bana'] == 1)
	{
		$Bloc['is_banned']  	= "<img src=\"./styles/images/banned.png\" >";
	}
	else
	{
		$Bloc['is_banned']  	= $lang['ou_not_banned'];
	}
	$Bloc['usr_planet_gal']    	= $TheUser['galaxy'];
	$Bloc['usr_planet_sys']    	= $TheUser['system'];
	$Bloc['usr_planet_pos']    	= $TheUser['planet'];
	$Bloc['actived']    		= $TheUser['activate_status'] ? "Si" : "No";
	foreach ($Bloc as $key => $value) {
            $displays->assign($key,$value);
        }



        //$parse['adm_ov_data_table']    .= parsetemplate( gettemplate('adm/onlineuser_row'), $Bloc );
	$Count++;
}
          if ($Count == 1){
              $lang['players'] = $lang['ou_player_connected'];
              }
          else {
              $lang['players'] = $lang['ou_player_connecteds'];
              }

$lang['adm_ov_data_count']  		 = $Count;

$displays->display ();
}
?>