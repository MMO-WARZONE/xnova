<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

if ($IsUserChecked == false) {
   includeLang('error/login');
   message($lang['login']['01'], $lang['login']['02']);
}

if(isset($_GET['page'])){
    switch($_GET['page']){

        case 'Space-Beginners' :
        include('./includes/grund_function/game_menu.php');
        break;

        case 'changelog' :
        include('./includes/grund_function/changelog.php');
        break;

        case 'stat' :
        include('./includes/grund_function/menu_05/stat_haupt.php');
        break;

        case 'ruhm' :
        include('./includes/grund_function/menu_05/topkb.php');
        break;

        case 'ruhm-info' :
        include('./includes/grund_function/menu_05/topkbuser.php');
        break;


        default :
        include('./login.php');
        break;
    }
}else{
    include('./login.php');
}

?>