<?php
//version 1
function ShowPlanetlistAdmin($user){
global $lang,$db,$displays; 

if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

	$query  = $db->query("SELECT p.*, u.username FROM {{table}}planets as p
			 INNER JOIN {{table}}users as u ON p.planet_type='1' AND u.id=p.id_owner
			 WHERE p.destruyed='' ", "");
	$i 		= 0;

        $displays->assignContent("adm/planetlist_body");
	while ($u = mysql_fetch_array($query))
	{
                $displays->newblock("lista_planetas");
		$i++;
		if($i<10){
			if($u['destruyed']!=0 && $u['destruyed']< time()+7*60*60*24){
			$db->query('DELETE FROM {{table}}planets as p, {{table}}galaxy as g
				WHERE  (p.galaxy="'.$u['galaxy'].'" AND	p.system="'.$u['system'].'" AND p.planet="'.$u['planet'].'")
				AND  (g.galaxy="'.$u['galaxy'].'" AND g.system="'.$u['system'].'" AND g.planet="'.$u['planet'].'")  ','' );
			}
		}

                foreach($u as $key => $value){
                    $displays->assign($key,$value);
                }
	}

	if ($i == 1){
		$lang['info_planetas'] .= "<tr><th class=b colspan=5>".$lang['pl_only_one_planet']."</th></tr>";
	}
	else{
		$lang['info_planetas'] .= "<tr><th class=b colspan=5>". $lang['pl_there_are'] . $i . $lang['pl_planets'] ."</th></tr>";
	}

	$displays->display();
 }
?>