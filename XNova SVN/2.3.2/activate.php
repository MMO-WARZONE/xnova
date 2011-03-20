<?php
//version 1
define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);
$InLogin = true;

$svn_root = './';
include($svn_root . 'extension.inc.php'); 
include($svn_root . 'common.' . $phpEx);


      $stamp            = encrypt($_GET['stamp'],true);
      $hash             = encrypt($_GET['hash'] ,true);
      if(!$_GET['hash']){
            $displays->message ("No existe la variable hash", $dest = "", $time = "3", $topnav = false, $menu = false);
      }elseif(!$_GET['stamp']){
            $displays->message ("No existe la variable stamp", $dest = "", $time = "3", $topnav = false, $menu = false);
      }

      $tblatudp = $db->query("UPDATE {{table}} SET `activate_status` = '".time()."'
                           WHERE `username` = '" . $hash . "' AND `id` = '" . $stamp . "' LIMIT 1;",'users');
      
      if ($tblatudp) {
           $displays->message("Cuenta Activada" );
      }else{
           $displays->message("Cuenta no encontrada");
      }
?>