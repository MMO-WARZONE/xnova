<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

includeLang('startseite');



$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;
$query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true);
$parse['last_user'] = $query['username'];
$query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
$parse['online_users'] = $query[0];
$parse['users_amount'] = $game_config['users_amount'];
$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
$OnlineAdmins = doquery("SELECT * FROM {{table}} WHERE onlinetime>='".(time()-15*60)."' AND authlevel>=1",'users');
if($OnlineAdmins){
	$parse['OnlineAdmins'] = "";
	while ($oas = mysql_fetch_array($OnlineAdmins)) {
		$parse['OnlineAdmins'] .= " ". $oas['username'] ."</a>, ";
	}
}else{
	$parse['OnlineAdmins'] = "--";
}
$RowsTPL = gettemplate('contact_body_rows2');


$QrySelectUser  = "SELECT `username`, `email`, `authlevel`, `id`  ";
$QrySelectUser .= "FROM {{table}} ";
$QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
$GameOps = doquery ( $QrySelectUser, 'users');

while( $Ops = mysql_fetch_assoc($GameOps) ) {
	$bloc['ctc_data_name']    = $Ops['username'];
	$bloc['ctc_data_auth']    = $lang['user_level'][$Ops['authlevel']];
	$bloc['ctc_data_mail']    = "<a href=mailto:".$Ops['email']."?subject=Anfrage_AG-XNova_Uni1_>".$Ops['email']."</a>";
	if(empty($user['authlevel'])) {
		$bloc['ctc_data_pn']	= "login";
	} else {
		$bloc['ctc_data_pn']	= "<a href=messages.php?mode=write&id=".$Ops['id'].">".$lang['ctc_pn']."</a>";
	}
	$parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
}

$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;",'banned');
$i=0;
while($u = mysql_fetch_array($query)){
	$parse['banned'] .=
	"<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[4])."</center></b></td>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[5])."</center></b></td>".
	"<td class=b><center><b>".$u[2]."</center></b></td>".
	"<td class=b><center><b>".$u[6]."</center></b></td></tr>";
	$i++;

}

if ($i=="0")
	$parse['banned'] .= "<tr><th class=b colspan=6>".$lang['PRANGER_NO_PLAYER_BANNED']."</th></tr>";
else
	$parse['banned'] .= "<tr><th class=b colspan=6>".str_replace('##player##', $i, $lang['PRANGER_NUM_PLAYERS_BANNED'])."</th></tr>";

display(parsetemplate(gettemplate('startseite/pranger'), $parse), $lang['PRANGER_TITLE'], false);

?>