<?php

/*
_   \ /\ / /\ ´¯|¯` |_¯ |¯¯) |_¯ |_¯| /\  |¯¯ |_¯    _
¯   \/ \/ /--\  |   |__ |¯¯\ __| |   /--\ |__ |__    ¯

 @copyright:
Copyright (C) 2008 - 2010 By 5aMu and Think.-

- Proyect based in XRV, which is based in XGProyect -
*/

// Este archivo se encarga de la página "Opciones de galaxia".-

class ShowOptionsPage
{
   public function ShowOptionsPage($CurrentUser)
   {
      global $game_config, $dpath, $lang;
      
      $mode = $_GET['mode'];

      //Comprobación tiempo de modo vacaciones y si está activado [necesaria en todos los archivos]
      if ($_POST && $mode == "exit")
      {
         if (isset($_POST["exit_modus"]) && $_POST["exit_modus"] == 'on' and $CurrentUser['urlaubs_until'] <= time())
         {
            $urlaubs_modus = "0";

            doquery("UPDATE {{table}} SET
            `urlaubs_modus` = '0',
            `urlaubs_until` = '0'
            WHERE `id` = '".$CurrentUser['id']."' LIMIT 1", "users");
         
          doquery("UPDATE {{table}} SET
         `last_update`='".time()."'
         WHERE `id_owner` = '".$CurrentUser['id']."'","planets");

            die(header("location:game.php?page=options"));
         }
         else
         {
            $urlaubs_modus = "1";
            die(header("location:game.php?page=options"));
         }
      }

       //Guardar opciones
      if ($_POST && $mode == "change")
      {
         //Cantidad de sondas
         if (isset($_POST["spio_anz"]) && is_numeric($_POST["spio_anz"]))
         {
            $spio_anz = intval($_POST["spio_anz"]);
         }
         else
         {
            $spio_anz = "1";
         }

         //Mensajes de flotas
         if (isset($_POST["settings_fleetactions"]) && is_numeric($_POST["settings_fleetactions"]))
         {
            $settings_fleetactions = mysql_escape_string($_POST["settings_fleetactions"]);
         }
         else
         {
            $settings_fleetactions = "1";
         }

         //Sondas de espionaje
         if (isset($_POST["settings_esp"]) && $_POST["settings_esp"] == 'on')
         {
            $settings_esp = "1";
         }
         else
         {
            $settings_esp = "0";
         }

         //Escribir mensaje
         if (isset($_POST["settings_wri"]) && $_POST["settings_wri"] == 'on')
         {
            $settings_wri = "1";
         }
         else
         {
            $settings_wri = "0";
         }

         //Añadir lista de amigos
         if (isset($_POST["settings_bud"]) && $_POST["settings_bud"] == 'on')
         {
            $settings_bud = "1";
         }
         else
         {
            $settings_bud = "0";
         }

         //Ataque con misiles
         if (isset($_POST["settings_mis"]) && $_POST["settings_mis"] == 'on')
         {
            $settings_mis = "1";
         }
         else
         {
            $settings_mis = "0";
         }

         //Ver reporte
         if (isset($_POST["settings_rep"]) && $_POST["settings_rep"] == 'on')
         {
            $settings_rep = "1";
         }
         else
         {
            $settings_rep = "0";
         }

         //Guardar opciones en la BD
         doquery("UPDATE {{table}} SET
         `spio_anz` = '$spio_anz',
         `settings_fleetactions` = '$settings_fleetactions',
         `settings_esp` = '$settings_esp',
         `settings_wri` = '$settings_wri',
         `settings_bud` = '$settings_bud',
         `settings_mis` = '$settings_mis',
         `settings_rep` = '$settings_rep'
         WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

         //Mensaje al guardar en opciones
         message($lang['op_options_changed'], "game.php?page=galaxia", 2);
      }
      else
      {

            $parse         = $lang;
            $parse['dpath'] = $dpath;
            $parse['opt_probe_data']   = $CurrentUser['spio_anz'];
            $parse['opt_toolt_data']   = $CurrentUser['settings_tooltiptime'];
            $parse['opt_fleet_data']   = $CurrentUser['settings_fleetactions'];
            $parse['user_settings_rep'] = ($CurrentUser['settings_rep'] == 1) ? " checked='checked'/":'';
            $parse['user_settings_esp'] = ($CurrentUser['settings_esp'] == 1) ? " checked='checked'/":'';
            $parse['user_settings_wri'] = ($CurrentUser['settings_wri'] == 1) ? " checked='checked'/":'';
            $parse['user_settings_mis'] = ($CurrentUser['settings_mis'] == 1) ? " checked='checked'/":'';
            $parse['user_settings_bud'] = ($CurrentUser['settings_bud'] == 1) ? " checked='checked'/":'';

            //Switch
            $mode = $_GET['mode'];
            switch ($mode)
              {
//--------------------------------------------------------------------------------------\\
   case "finish":
      display(parsetemplate(gettemplate('options/good'), $parse));
   break;
//--------------------------------------------------------------------------------------\\
   default:
            display(parsetemplate(gettemplate('options/options_galaxia'), $parse));
            }
            //Fin switch
         }
      }
   }
?>
