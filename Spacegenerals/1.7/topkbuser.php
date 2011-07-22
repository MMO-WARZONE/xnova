<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

$mode = (isset($_GET['mode']) AND ctype_xdigit($_GET['mode']))
    ? $_GET['mode']
    : 0;




//start der einzel anzeige
$anzeige      = doquery("SELECT * FROM {{table}} WHERE `rid` = '$mode';", 'topkb');

includeLang('topkb');
$BodyTPL = gettemplate('topkbanzeige');
$RowsTPL = gettemplate('topkbanzeige_rows');
$parse  = $lang;



while($tabelle = mysql_fetch_assoc($anzeige))
{

	$user1      = doquery("SELECT avatar FROM {{table}} WHERE `id` = '". $tabelle['id_owner1'] ."';", 'users');
	while($user1data = mysql_fetch_assoc($user1))
	{
		$bloc['useratter']              = "<th><img src=\"". $user1data['avatar'] ."\" height=100 width=100></th>";
	}

	$user2      = doquery("SELECT avatar FROM {{table}} WHERE `id` = '". $tabelle['id_owner2'] ."';", 'users');
	while($user2data = mysql_fetch_assoc($user2))
	{
		$bloc['userdeffer']              = "<th><img src=\"". $user2data['avatar'] ."\" height=100 width=100></th>";;
	}

	$bloc['top_vs']            = "<th><b>  VS  </b></th>";
	$bloc['top_titel']          = "<td><h2>". $tabelle['angreifer'] ."<b> VS </b>". $tabelle['defender'] ."</h2></td>";
	$bloc['top_fighters']      = $tabelle['angreifer'] ."<b> VS </b>". $tabelle['defender'];
	$bloc['top_id_owner1']      = "<b>". $tabelle['id_owner1'] ."</b>";
	$bloc['top_angreifer']      = "<th>". $tabelle['angreifer'] ."</th>";
	$bloc['top_id_owner2']      = $tabelle['id_owner2'];
	$bloc['top_defender']      = "<th>". $tabelle['defender'] ."</th>";
	$bloc['top_gesamtunits']    = pretty_number( $tabelle['gesamtunits'] );
	$bloc['top_gesamttruemmer'] = $tabelle['gesamttruemmer'];
	$bloc['top_rid']            = $tabelle['rid'];
	$bloc['top_raport']        = $tabelle['raport'];
	$bloc['top_time']          = date("r", $tabelle['time']);

	$parse['top_list'] .= parsetemplate($RowsTPL, $bloc);
}


display(parsetemplate($BodyTPL, $parse), $lang['top'], false);

?>