<?php

/*
_   \ /\ / /\ ´¯|¯` |_¯ |¯¯) |_¯ |_¯| /\  |¯¯ |_¯    _
¯   \/ \/ /--\  |   |__ |¯¯\ __| |   /--\ |__ |__    ¯

 @copyright:
Copyright (C) 2008 - 2010 By 5aMu and Think.-

- Proyect based in XRV, which is based in XGProyect -
*/

// Este archivo se encarga de la página "Datos de usuario".-

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
         //Nombre de usuario
         if (isset($_POST["db_character"]) && $_POST["db_character"] != '')
         {
            $username = mysql_escape_string ( $_POST['db_character'] );
         }
         else
         {
            $username = mysql_escape_string ( $CurrentUser['username'] );
         }

         // Cambio del nombre de usuario
         if ($CurrentUser['username'] != $_POST["db_character"])
         {
            $query = doquery("SELECT id FROM {{table}} WHERE username='".mysql_escape_string ($_POST["db_character"])."'", 'users', true);

            if (!$query)
            {
               doquery("UPDATE {{table}} SET username='".mysql_escape_string ($username)."' WHERE id='".intval($CurrentUser['id'])."' LIMIT 1", "users");
               setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0);
               message($lang['op_username_changed'], "index.php", 1);
            }
         }

         //Dirección de email
         if (isset($_POST["db_email"]) && $_POST["db_email"] != '')
         {
            $db_email = mysql_escape_string ( $_POST['db_email'] );
         }
         else
         {
            $db_email = $CurrentUser['email'];
         }

         //Guardar opciones en la BD
         doquery("UPDATE {{table}} SET
         `email` = '$db_email'

         WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

         //Cambio de clave
         if (isset($_POST["db_password"]) && md5($_POST["db_password"]) == $CurrentUser["password"])
         {
            if ($_POST["newpass1"] == $_POST["newpass2"])
            {
               if ($_POST["newpass1"] != "")
               {
                  $newpass = md5($_POST["newpass1"]);
                  doquery("UPDATE {{table}} SET `password` = '{$newpass}' WHERE `id` = '{$CurrentUser['id']}' LIMIT 1", "users");
                  setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0);
                  message($lang['op_password_changed'],"index.php",1);
               }
            }
         }

         //Mensaje al guardar las opciones
         message($lang['op_options_changed'], "game.php?page=options", 2);
      }
      else
      {
            $parse         = $lang;
            $parse['dpath'] = $dpath;
            $parse['opt_usern_data']   = $CurrentUser['username'];
            $parse['opt_mail1_data']   = $CurrentUser['email'];
            $parse['opt_mail2_data']   = $CurrentUser['email_2'];
            $parse['opt_dpath_data']   = $CurrentUser['dpath'];
            $parse['opt_delac_data']   = ($CurrentUser['db_deaktjava'] == 1) ? " checked='checked'/":'';
            $parse['db_deaktjava']     = ($CurrentUser['db_deaktjava']  > 0) ? " checked='checked'/":'';

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
            display(parsetemplate(gettemplate('options/options_general'), $parse));
            }
            //Fin switch
         }
     }
}
?>
