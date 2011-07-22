<?php

/*
_   \ /\ / /\ ´¯|¯` |_¯ |¯¯) |_¯ |_¯| /\  |¯¯ |_¯    _
¯   \/ \/ /--\  |   |__ |¯¯\ __| |   /--\ |__ |__    ¯

 @copyright:
Copyright (C) 2008 - 2010 By 5aMu and Think.-

- Proyect based in XRV, which is based in XGProyect -
*/

// Este archivo se encarga de la página "Ajustes generales".-

class ShowOptionsPage
{

   

    //Comprobación de construcciones en proceso para el modo vacaciones
   private function CheckIfIsBuilding($CurrentUser)
   {
      $query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');

      while($id = mysql_fetch_array($query))
      {
         if($id['b_building'] != 0)
         {
            if($id['b_building'] != "")
               return true;
         }
         elseif($id['b_tech'] != 0)
         {
            if($id['b_tech'] != "")
               return true;
         }
         elseif($id['b_hangar'] != 0)
         {
            if($id['b_hangar'] != "")
               return true;
         }
      }
      $fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '{$CurrentUser['id']}'", 'fleets',true);
      if($fleets != 0)
         return true;

      return false;
   }
           


   //Comprobación tiempo de modo vacaciones y si está activado [necesario en todos los archivos]
   public function ShowOptionsPage($CurrentUser)
   {
      global $game_config, $dpath, $lang;

      $mode = $_GET['mode'];

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
         //Skin
         if (isset($_POST["design"]) && $_POST["design"] == 'on')
         {
            $design = "1";
         }
         else
         {
            $design = "0";
         }

         //Comprobación de IP
         if (isset($_POST["noipcheck"]) && $_POST["noipcheck"] == 'on')
         {
            $noipcheck = "1";
         }
         else
         {
            $noipcheck = "0";
         }

   // < ------------------------------------------------------------ AVATAR ------------------------------------------------------------ >
            
            if ($_POST && $mode == "change") { // Array ( [db_character]
            $iduser = $user["id"];
            $avatar = $_POST["avatar"];
            $dpath = $_POST["dpath"];
            
            }



         //Modo vacaciones
         if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on')
         {
            if($this->CheckIfIsBuilding($CurrentUser))
            {
               message($lang['op_cant_activate_vacation_mode'], "game.php?page=options",10);
            }

            $urlaubs_modus = "1";
            $time = time() + 172800;
            doquery("UPDATE {{table}} SET
            `urlaubs_modus` = '$urlaubs_modus',
            `urlaubs_until` = '$time'
            WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

            $query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');

            while($id = mysql_fetch_array($query))
            {
               doquery("UPDATE {{table}} SET
               metal_perhour = '".$game_config['metal_basic_income']."',
               crystal_perhour = '".$game_config['crystal_basic_income']."',
               deuterium_perhour = '".$game_config['deuterium_basic_income']."',
               energy_used = '0',
               energy_max = '0',
               metal_mine_porcent = '0',
               crystal_mine_porcent = '0',
               deuterium_sintetizer_porcent = '0',
               solar_plant_porcent = '0',
               fusion_plant_porcent = '0',
               solar_satelit_porcent = '0'
               WHERE id = '{$id['id']}' AND `planet_type` = 1 ", 'planets');
            }
         }
         else
            $urlaubs_modus = "0";

            //Borra cuenta
         if (isset($_POST["db_deaktjava"]) && $_POST["db_deaktjava"] == 'on')
         {
            $db_deaktjava = time();
         }
         else
         {
            $db_deaktjava = "0";
         }

            //Órden de los planetas
         $SetSort  = mysql_escape_string($_POST['settings_sort']);
         $SetOrder = mysql_escape_string($_POST['settings_order']);

         //Guardar opciones en la BD
         doquery("UPDATE {{table}} SET
         `dpath` = '".mysql_escape_string($_POST['dpath'])."',
         `design` = '$design',
         `avatar` = '$avatar',
         `noipcheck` = '$noipcheck',
         `planet_sort` = '$SetSort',
         `planet_sort_order` = '$SetOrder',
         `urlaubs_modus` = '$urlaubs_modus',
         `lang` = '$_POST[idioma_usuario]',
         `db_deaktjava` = '$db_deaktjava'
         WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

          //Mensaje al guardar en opciones
          message($lang['op_options_changed'], "game.php?page=general", 2);
      }
      else
      {

         $parse         = $lang;
         $parse['dpath'] = $dpath;
         $parse['opt_avata_data'] = $CurrentUser['avatar'];

         //Mensaje que saldrá al tener el modo vacaciones activado
         if($CurrentUser['urlaubs_modus'])
         {
            $parse['opt_modev_data']   = ($CurrentUser['urlaubs_modus'] == 1)?" checked='checked'/":'';
            $parse['opt_modev_exit']   = ($CurrentUser['urlaubs_modus'] == 0)?" checked='1'/":'';
            $parse['vacation_until']   = date("d.m.Y G:i:s",$CurrentUser['urlaubs_until']);

            display(parsetemplate(gettemplate('options/options_body_vmode'), $parse));
            //Fin
         }
         else
         {
            $parse['opt_lst_ord_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort'] == 0) ? " selected": "") .">Fecha de colonización</option>";
            $parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort'] == 1) ? " selected": "") .">Coordenadas</option>";
            $parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($CurrentUser['planet_sort'] == 2) ? " selected": "") .">Orden alfabético</option>";
            $parse['opt_lst_cla_data']   = "<option value =\"0\"". (($CurrentUser['planet_sort_order'] == 0) ? " selected": "") .">Creciente</option>";
            $parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($CurrentUser['planet_sort_order'] == 1) ? " selected": "") .">Decreciente</option>";
            $parse['opt_sskin_data']   = ($CurrentUser['design'] == 1) ? " checked='checked'":'';
            $parse['opt_noipc_data']   = ($CurrentUser['noipcheck'] == 1) ? " checked='checked'":'';
            $parse['db_deaktjava']     = ($CurrentUser['db_deaktjava']  > 0) ? " checked='checked'/":'';
            $parse['lst_idomas']   = "<option value =\"spanish\"". (($CurrentUser['lang'] == 'spanish') ? " selected": "") .">Español</option>";
            $parse['lst_idomas']  .= "<option value =\"english\"". (($CurrentUser['lang'] == 'english') ? " selected": "") .">Ingles</option>";  



// Selección de Skins - Inicio -
$SkinPath = "styles/skins";
$directorio=opendir($xgp_root.$SkinPath);
$SkinGuardado=str_replace($SkinPath.'/', '', $CurrentUser['dpath']);
$parse['lst_skins']   = "<option value=\"{$CurrentUser['dpath']}\">$SkinGuardado</option>";
while ($archivo = readdir($directorio)){
    if($archivo=='.' or $archivo=='..' or $archivo=='index.htm'){
        echo "";
    } else {
        $SkinPathCompleto=$SkinPath."/".$archivo."/";
        $parse['lst_skins']  .= "<option value=\"$SkinPathCompleto\">$archivo</option>";
    }
}
closedir($directorio);
// Selección de Skins - Fin - 


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
            display(parsetemplate(gettemplate('options/options_ajustes'), $parse));
              }
              //Fin switch
         }
      }
   }
}
?>
