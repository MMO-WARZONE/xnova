<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** lancerstatauto.php                    **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

   if ($user['authlevel'] >= 3) {
      includeLang('admin');
   
   $tempsstat   = 60;
   $StatFleetDate   = time()+$tempsstat;
   $StatFleetDatend   = $StatFleetDate+$tempsstat;

   $QryInsertFleet  = "INSERT INTO {{table}} SET ";
   $QryInsertFleet .= "`fleet_owner` = '0', ";
   $QryInsertFleet .= "`fleet_mission` = '4', ";
   $QryInsertFleet .= "`fleet_amount` = '1', ";
   $QryInsertFleet .= "`fleet_array` = '203,1;', ";
   $QryInsertFleet .= "`fleet_start_time` = '". $StatFleetDate ."',";
   $QryInsertFleet .= "`fleet_start_galaxy` = '1', ";
   $QryInsertFleet .= "`fleet_start_system` = '1', ";
   $QryInsertFleet .= "`fleet_start_planet` = '1', ";
   $QryInsertFleet .= "`fleet_start_type` = '1', ";
   $QryInsertFleet .= "`fleet_end_time` = '". $StatFleetDatend ."', ";
   $QryInsertFleet .= "`fleet_end_stay` = '0', ";
   $QryInsertFleet .= "`fleet_end_galaxy` = '1', ";
   $QryInsertFleet .= "`fleet_end_system` = '1', ";
   $QryInsertFleet .= "`fleet_end_planet` = '1', ";
   $QryInsertFleet .= "`fleet_end_type` = '1', ";
   $QryInsertFleet .= "`fleet_resource_metal` = '0', ";
   $QryInsertFleet .= "`fleet_resource_crystal` = '0', ";
   $QryInsertFleet .= "`fleet_resource_deuterium` = '1', ";
   $QryInsertFleet .= "`fleet_target_owner` = '0', ";
   $QryInsertFleet .= "`start_time` = '". time() ."';";
   doquery( $QryInsertFleet, 'fleets');

   AdminMessage ( $lang['stat_auto4'], $lang['stat_auto6'] );       
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