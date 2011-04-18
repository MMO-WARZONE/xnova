<?php

/**
  * topkbuser.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

includeLang('tech');
includeLang('menu_05/topkb');

if (!isset($mode)) {

   if (isset($_GET['mode'])) {
       $mode          = $_GET['mode'];
   } else {
       $mode = 0;
   }
}

$anzeige = doquery("SELECT * FROM {{table}} WHERE `rid` = '". $mode ."';", 'topkb');

$BodyTPL = gettemplate('topkb/topkb_03');
$RowsTPL = gettemplate('topkb/topkb_04');
$parse   = $lang;
$dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$parse['dpath'] = $dpath;

while($tabelle = mysql_fetch_assoc($anzeige)) {
    $report = stripslashes($tabelle['raport']);
    foreach ($lang['tech_rc'] as $id => $s_name) {
        $str_replace1  = array("[ship[".$id."]]");
        $str_replace2  = array($s_name);
        $report = str_replace($str_replace1, $str_replace2, $report);
    }
    $user1 = doquery("SELECT * FROM {{table}} WHERE `id` = '". $tabelle['id_owner1'] ."';", 'users');

    while($user1data = mysql_fetch_assoc($user1)) {
        switch ($user1data['avatar']) {

            case "A":
            $bloc['useratter'] = "<img src='./styl/image/volk/volk_01.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            case "B":
            $bloc['useratter'] = "<img src='./styl/image/volk/volk_02.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            case "C":
            $bloc['useratter'] = "<img src='./styl/image/volk/volk_03.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            default:
            $bloc['useratter'] = "<img src='". $user1data['avatar'] ."' style='height:100px; width:100px;' alt=''>";
            break;
        }
    }

    $user2       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $tabelle['id_owner2'] ."';", 'users');
    while($user2data = mysql_fetch_assoc($user2)) {
        switch ($user2data['avatar']) {

            case "A":
            $bloc['userdeffer'] = "<img src='./styl/image/volk/volk_01.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            case "B":
            $bloc['userdeffer'] = "<img src='./styl/image/volk/volk_02.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            case "C":
            $bloc['userdeffer'] = "<img src='./styl/image/volk/volk_03.jpg' style='height:100px; width:100px;' alt=''>";
            break;

            default:
            $bloc['userdeffer'] = "<img src='". $user2data['avatar'] ."' style='height:100px; width:100px;' alt=''>";
            break;
        }
    }
    $bloc['top_vs']             = "VS";
    $bloc['top_fighters']       = $tabelle['angreifer'] ."<b> VS </b>". $tabelle['defender'];
    $bloc['top_id_owner1']      = "<b>". $tabelle['id_owner1'] ."</b>";
    $bloc['top_angreifer']      = "". $tabelle['angreifer'] ."";
    $bloc['top_id_owner2']      = $tabelle['id_owner2'];
    $bloc['top_defender']       = "". $tabelle['defender'] ."";
    $bloc['top_gesamtunits']    = pretty_number( $tabelle['gesamtunits'] );
    $bloc['top_gesamttruemmer'] = $tabelle['gesamttruemmer'];
    $bloc['top_rid']            = $tabelle['rid'];
    $bloc['top_raport']         = $report;
    $bloc['top_time']           = date("r", $tabelle['time']);
    $dpath                      = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    $bloc['dpath']              = $dpath;
    $parse['top_list']         .= parsetemplate($RowsTPL, $bloc);
}

display(parsetemplate(gettemplate('topkb/topkb_03'), $parse), $lang['Ruhm_02'], false);

?>