<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);


//anzeige der Top 100 Liste
includeLang('topkb');
$BodyTPL = gettemplate('topkb');
$RowsTPL = gettemplate('topkb_rows');
$parse   = $lang;


$top = doquery ("SELECT * FROM {{table}} ORDER BY (`gesamtunits` * `gesamttruemmer`) DESC LIMIT 100;", 'topkb');
$a = 0;
while($data = mysql_fetch_assoc($top))
{
	$a++;
	$timedeut = date("D d M H:i:s", $data['time']);

	if ($data['fleetresult'] == a) $bloc['top_fighters']       = "<a href=\"topkbuser.php?mode=". $data['rid'] ."\" target=\"_new\"><font color=\"green\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"red\">". $data['defender'] ."</font></a>";
	else if ($data['fleetresult'] == w) $bloc['top_fighters']       = "<a href=\"topkbuser.php?mode=". $data['rid'] ."\" target=\"_new\"><font color=\"red\">" .$data['angreifer'] ."</font><b> VS </b><font color=\"green\">". $data['defender'] ."</font></a>";
	else $bloc['top_fighters']       = "<a href=\"topkbuser.php?mode=". $data['rid'] ."\" target=\"_new\">" .$data['angreifer'] ."<b> VS </b>". $data['defender'] ."</a>";


	$bloc['top_rank']           = $a;
	$bloc['top_time']           = $timedeut;
	$bloc['underrow']           = $lang['grata'];
	//  date("r", $data['time']);
	$parse['top_list'] .= parsetemplate($RowsTPL, $bloc);
}

display(parsetemplate(gettemplate('topkb'), $parse), $lang['topkb'], false);
//Ende der data der Top 100 Liste

 
 ?>