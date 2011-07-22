<?php

/**
* crear_planetas.php
*
* @version 2.0
* @copyright 2008 By Garbanzt for Xnova Project, modificado por Neko para xtreme-gamez 2009
**/


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

   if ($user['authlevel'] >= 3) {
      
	  includeLang('admin');

      $mode      = $_POST['mode'];
      $parse     = $lang;

      if ($mode == 'addit') {
	  
     	$id       	   = $_POST['id'];
        $galaxy        = $_POST['galaxy'];
        $system        = $_POST['system'];
        $planet        = $_POST['planet'];
		
      if ($galaxy > 0 && $system > 0 && $planet > 0 && $id > 0 && $galaxy < 10 && $system < 500 && $planet < 16) {
           
      CreateOnePlanetRecord ($galaxy, $system, $planet, $id, '', '', false) ;
          
      message ('Planet erfolgreich erstellt! | <a href="mats.php">Planet Editieren</a>','Information', "crear_planetas.php", 5);
	  }else{
	  message ('Nicht moeglich auf Position 0, nicht moeglich ueber Position 9:499, nicht moeglich auf Position 16.', 'Fehler', "crear_planetas.php", 5);
	  }
	 }
	 
	$Page .= parsetemplate(gettemplate('admin/crear_planetas'),  $parse );
	display ( $Page, "Erstellen sie einen neuen Planeten", false, '', true, false);
		
	}else
	{
		message ( 'Sie verfuegen nicht ueber die Rechte das durchzufueren', 'Fehler');
	}
	return $Page;

?>