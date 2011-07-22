<?php

 /**
 * aksinvitation.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

  define('INSIDE', true);
  define('INSTALL', false);
  
  $rocketnova_root_path = './';
  include($rocketnova_root_path . 'extension.inc');
  include($rocketnova_root_path . 'common.' . $phpEx);
  
  $aks = doquery("SELECT * FROM {{table}} WHERE `name` = '" . $_GET['aksname'] . "'", 'aks', true);
  $fleets = preg_split('#\,#', $aks['fleets']);
  $n = count($fleets);
  for ($j = 0; $j < $n - 1; $j++) {
      $f[$j] = doquery("SELECT * FROM {{table}} WHERE fleet_id=" . $fleets[$j], 'fleets', true);
  }
  
  if (!isset($_POST['newpart'])) {
      $display = '<form id="addpart" name="addpart" method="post" action="aksinvitation.php?aksname=' . $aks['name'] . '">
  <input type="text" name="newpart" id="textfield" />
  <input type="submit" name="button" id="button" value="Inviter" />
</form>';
  } elseif ($_POST['newpart'] == '') {
      $display = '<a><font color=white>Rien n\'a &eacute;t&eacute; &eacute;crit ! </font></a><a href ="./aksinvitation.php"> Retour</a>';
  } else {
      
      $newpart = doquery("SELECT * FROM {{table}} WHERE `username` = '" . $_POST['newpart'] . "'", 'users', true);
      doquery("UPDATE {{table}} SET `invited` = '" . $aks['invited'] . "," . $newpart['id'] . "' WHERE `id` ='" . $aks['id'] . "' ", 'aks');
      $Subject = 'Einladung zum Verbandsangriff';
      $Message = 'Hallo,
Der Spieler ' . $user['username'] . ' hat sie zu folgendem Verbandsangriff eingeladen : ' . $aks['name'] . '. 
Starten sie vor: ' . gmdate("d/m/y", $f[0]['fleet_start_time']) . ' &agrave; ' . gmdate("H:i:s", $f[0]['fleet_start_time']) . '.';
      SendSimpleMessage($newpart['id'], $user['id'], time(), 1, $user['username'], $Subject, $Message);
      $display = ($newpart != array()) ? '<a><font color=white>Invitation bien envoy&eacute;e! </font></a><a href ="./aksinvitation.php"> Retour</a>' : '<a><font color=white>Aucun joueur ne s\'appelle : ' . $_POST['newpart'] . '.  </font></a><a href ="./aksinvitation.php"> Retour</a>';
  }
  echo $display;
?>