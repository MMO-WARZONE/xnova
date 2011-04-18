<?php

if ($user['authlevel'] == 0) {
    switch ($user['volk']) {

        case "A":
        include ("stat_volk_01.php");
        break;

        case "B":
        include ("stat_volk_02.php");
        break;

        case "C":
        include ("stat_volk_03.php");
        break;

        case "0":
        include ("stat_info.php");
        break;

        default :
        include('stat_info.php');
        break;

    }
} else {
    include ("stat_team.php");
}


?>