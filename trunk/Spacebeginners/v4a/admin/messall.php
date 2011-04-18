<?php

/**
 * messall.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

	if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {

       if ($_POST && $_GET['mode'] == "change")    { 
          if ($user['authlevel'] == 3) // niveau administrateur 
          {             
           $kolor = 'red';             
           $ranga = 'Administrateur';         
          }
          
         elseif ($user['authlevel'] == 2) // niveau Operateur
         {             
          $kolor = 'skyblue';             
          $ranga = 'Op&eacute;rateur';         
         }   
        
         elseif ($user['authlevel'] == 1) // niveau Moderateur
         {             
          $kolor = 'yellow';             
          $ranga = 'Mod&eacute;rateur';   
          }       
           // Tout est OK donc on peut ecrir un message a tout les joueurs 
          if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != '')) {             
             $sq      = doquery("SELECT * FROM {{table}}", "users");
             $Time    = time();             
             $From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";             
             $Subject = "<font color=\"". $kolor ."\">". $_POST['temat'] ."</font>";             
             $Message = "<font color=\"". $kolor ."\"><b>". $_POST['tresc'] ."</b></font>";         
             $summery=0;   
             
           while ($u = mysql_fetch_array($sq)) {               
              SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message);
                $_POST['tresc'] = str_replace(":name:",$u['username'],$_POST['tresc']);
             }   
           // Ici le message est bien Partis.
           message("<font color=\"lime\">Votre message a &eacute;t&eacute; envoy&eacute;!</font>", "Envoy&eacute;", "../overview." . $phpEx, 3);         
          }
         else
         {
          // Ici on a une erreur : pas de sujet sp&eacute;cifi&eacute;
          message("Vous n\'avez pas sp&eacute;cifi&eacute; de sujet!", "Erreur", "../overview." . $phpEx, 3);
         }       
        }
        else
       {         
        $parse = $game_config;
        $parse['dpath'] = $dpath;         
        $parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';         
        $page .= parsetemplate(gettemplate('admin/messall_body'), $parse);         
        display($page, '', false,'', true);       
       }   
    } // fin de la requette de verification level

    else // on vire car pas le bon level
      {       
       message($lang['sys_noalloaw'], $lang['sys_noaccess']);   
      }
?>
