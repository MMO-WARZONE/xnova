<?php
//version 1
function ShowActivePlanetAdmin($user){

global $lang, $db, $displays;

if ($user['authlevel'] < 1) die($displays->message($lang['not_enough_permissions']));


$query 	= $db->query("SELECT `id`,`name`,`galaxy`,`system`,`planet`,`points`,`last_update` FROM {{table}} WHERE `last_update` >= '". (time()-15 * 60) ."' and `destruyed`='0' ORDER BY `id` ASC", 'planets');
$i          = 0;

        $displays->assignContent("adm/activeplanets_body", $topnav = true, $menu = true, $admin = true);
        while ($u = mysql_fetch_array($query))
{
                $displays->newblock("planetas_activos");
		$i++;

	$u['position'] = "[". $u['galaxy'] .":". $u['system'] .":". $u['planet'] ."]";
	$u['points']   = pretty_number($u['points'] / 1000);
	$u['activity'] = pretty_time(time() - $u['last_update']);


        foreach($u as $key => $value){
        $displays->assign($key,$value);
        }

}

$lang['online_list'] .= "<tr>";
$lang['online_list'] .= "<th class=\"b\" colspan=\"4\">" . $lang['ap_there_are'] . $i . $lang['ap_with_activity'] . "</th>";
$lang['online_list'] .= "</tr>";

	$displays->display();

}
?>