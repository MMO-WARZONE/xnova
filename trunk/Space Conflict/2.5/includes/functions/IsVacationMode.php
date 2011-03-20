<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** IsVacationMode.php                    **
******************************************/

    function IsVacationMode($CurrentUser){
       global $game_config;

       if($CurrentUser['urlaubs_modus'] == 1){
       $query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');
       while($id = mysql_fetch_array($query)){
          doquery("UPDATE {{table}} SET
                   metal_perhour = '".$game_config['metal_basic_income']."',
                   crystal_perhour = '".$game_config['crystal_basic_income']."',
                   deuterium_perhour = '".$game_config['deuterium_basic_income']."',
                   tachyon_perhour = '".$game_config['tachyon_basic_income']."',
                   metal_mine_porcent = '0',
                   crystal_mine_porcent = '0',
                   deuterium_sintetizer_porcent = '0',
                   tach_accel_porcent = '0',
                   solar_plant_porcent = '0',
                   fusion_plant_porcent = '0',
                   solar_satelit_porcent = '0'
                 WHERE id = '{$id['id']}' AND `planet_type` = '1' ", 'planets');
          }
          return true;
       }
       return false;
    }

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/    

?>