<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

   if ($user['authlevel'] >= 2) {
      includeLang('admin');
      $mode      = $_POST['mode'];
      $PageTpl   = gettemplate("admin/add_pts");
      $parse     = $lang;
      if ($mode == 'addit') {
         $id          = $_POST['id'];
         $rpg_points       = intval($_POST['rpg_points']);
         $QryUpdateUsers  = "UPDATE {{table}} SET ";
         $QryUpdateUsers .= "`rpg_points` = `rpg_points` + '". $rpg_points ."' ";
         $QryUpdateUsers .= " WHERE `id` = '".$id."' ";
         doquery( $QryUpdateUsers, "users");
            AdminMessage ( $lang['adm_am_done'], $lang['adm_am_ttle'] );
      }
      $Page = parsetemplate($PageTpl, $parse);
      display ($Page, $lang['adm_am_ttle'], false, '', true);
   } else {
      AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
   }
?>