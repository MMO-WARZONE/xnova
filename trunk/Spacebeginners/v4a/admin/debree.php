<?php

/**
* debree.php
* @Licence GNU (GPL)
* @version 1.0 
* @copyright 2010 
* @Team Space Beginner
*/


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt, $lang;

 if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {
      
	  includeLang('admin');

      $mode      = $_POST['mode'];
      $parse     = $lang;

      if ($mode == 'addit') {
	  
     	$idplanet         = $_POST['id_planet'];
   		$metall           = $_POST['metal'];
		$crystal          = $_POST['crystal'];
		$appolonium       = $_POST['appolonium'];
		
		CreateOneDebrisField ($idplanet, $metall, $crystal,$appolonium, false);
		
        AdminMessage ($lang['build_debree'],$lang['info_debree'], "debree.php", 5);
	   }
	  
	 
	   $Page .= parsetemplate(gettemplate('admin/create_debree'),  $parse );
	   display ( $Page,$lang['create_debree'], false, '', true, false);
		
	}else{
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

	return $Page;

?>