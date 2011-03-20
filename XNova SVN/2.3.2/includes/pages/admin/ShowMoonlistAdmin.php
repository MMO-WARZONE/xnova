<?php
//version 1
function ShowMoonlistAdmin($user){
global $lang,$db,$displays;

if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

	$query  = $db->query("SELECT p.*, u.username FROM {{table}}planets as p
			 INNER JOIN {{table}}users as u ON p.planet_type='3' AND u.id=p.id_owner
			 WHERE p.destruyed='' ", "");
	$i 		= 0;

        $displays->assignContent("adm/moonlist_body");
	while ($u = mysql_fetch_array($query))
	{
		$displays->newblock("lista_lunas");
		$i++;

                foreach($u as $key => $value){
                $displays->assign($key,$value);

	}

	if ($i == "1"){
		$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['mt_only_one_moon']."</th></tr>";}
	else {
		$parse['moon'] .= "<tr><th class=b colspan=6>". $lang['mt_there_are'] . $i . $lang['mt_moons'] ."</th></tr>";}
}
	$displays->display();
}	
?>