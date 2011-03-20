<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

   	if ($user['authlevel'] >= 3) {
		includeLang('admin/arraki');

      	$mode      = $_POST['mode'];

      	$PageTpl   = gettemplate("admin/arr_del");
      	$parse     = $lang;

      	if ($mode == 'addit') {
         		$id          = $_POST['id'];
         		$arraki      = $_POST['arraki'];

         		$QryUpdateUsers  = "UPDATE game_users SET ";
         		$QryUpdateUsers .= "`arraki` = `arraki` - '". $arraki ."' ";
         		$QryUpdateUsers .= " WHERE `id` = '".$id."' ";

         		doquery( $QryUpdateUsers, "users");

         		$QryUpdatePlanets  = "UPDATE game_planets, game_users SET ";
         		$QryUpdatePlanets .= "game_planets.arraki = game_users.arraki ";
         		$QryUpdatePlanets .= " WHERE game_planets.id_owner = game_users.id ";

         		doquery( $QryUpdatePlanets, "planets");

			

         		AdminMessage ( $lang['del_arr_done'], $lang['del_arr_title'] );
          	}
          		$Page = parsetemplate($PageTpl, $parse);

          	display ($Page, $lang['del_arr_title'], false, '', true);
   	} else {
      	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
   	}

?>

