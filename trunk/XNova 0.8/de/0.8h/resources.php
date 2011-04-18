<?php

/**
 * resourcen.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

if($user['urlaubs_modus'] == 1) {
	includeLang('resources');
      message($lang['urlaubs_modus']);
}else{
	includeLang('resources');

			BuildRessourcePage ( $user, $planetrow );
}

?>