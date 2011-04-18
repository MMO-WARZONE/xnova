<?php

/**
  * topkb.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

includeLang('menu_05/topkb');

$RowsTPL = gettemplate('topkb/topkb_02');
$parse = $lang;
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$parse['dpath'] = $dpath;

$top = doquery ("SELECT * FROM {{table}} ORDER BY (`gesamtunits` + `gesamttruemmer`) DESC;", 'topkb');
$a   = 0;

while($data = mysql_fetch_assoc($top)) {
    $a++;

    If ($a == 101){
        break;
    }

    $timedeut = date("D d M H:i:s", $data['time']);

    if ($data['fleetresult'] == a) $bloc['top_fighters'] = "<a href='game.php?page=ruhm-info&amp;mode=". $data['rid'] ."' target='_blank'><font color='#00DF00'>" .$data['angreifer'] ."</font><b> VS </b><font color='#FF0000'>". $data['defender'] ."</font></a>";
        else
    if ($data['fleetresult'] == r) $bloc['top_fighters'] = "<a href='game.php?page=ruhm-info&amp;mode=". $data['rid'] ."' target='_blank'><font color='#FF0000'>" .$data['angreifer'] ."</font><b> VS </b><font color='#00DF00'>". $data['defender'] ."</font></a>";
        else
    $bloc['top_fighters']                                = "<a href='game.php?page=ruhm-info&amp;mode=". $data['rid'] ."' target='_blank'>" .$data['angreifer'] ."<b> VS </b>". $data['defender'] ."</a>";

    $bloc['top_rank'] = $a;
    $bloc['top_time'] = $timedeut;
    $bloc['underrow'] = $lang['grata'] ."test";

    $parse['top_list'] .= parsetemplate($RowsTPL, $bloc);
}

display(parsetemplate(gettemplate('topkb/topkb_01'), $parse), $lang['Ruhm_01']);

?>