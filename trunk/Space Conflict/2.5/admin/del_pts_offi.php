<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** del_pts_officer.php                   **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

       if ($user['authlevel'] >= 3) {
          includeLang('admin');
        
          $mode      = $_POST['mode'];
        
          $PageTpl   = gettemplate("admin/del_pts_offi");
          $parse     = $lang;
        
          if ($mode == 'addit') {
             $id          = $_POST['id'];
             $rpg_points       = $_POST['rpg_points'];
             $QryUpdateUsers  = "UPDATE {{table}} SET ";
             $QryUpdateUsers .= "`rpg_points` = `rpg_points` - '". $rpg_points ."' ";
             $QryUpdateUsers .= " WHERE `id` = '".$id."' ";
             doquery( $QryUpdateUsers, "users");

             AdminMessage ( $lang['adm_deloffi2'], $lang['adm_deloffi1'] );
          }
          $Page = parsetemplate($PageTpl, $parse);

          display ($Page, $lang['del_sup_poi'], false, '', true);
       } else {
          AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
       }

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>