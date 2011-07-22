<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @link: http://www.xnovarevolution.con.ar

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

define('INSIDE'  , true);

define('ROOT_PATH', './');
include(ROOT_PATH . 'common.php');
require(ROOT_PATH . 'includes/classes/class.template.php');

$LANG->includeLang(array('FLEET', 'TECH'));
	
$RID	= request_var('raport', '');

if(file_exists(ROOT_PATH.'raports/raport_'.$RID.'.php'))
	require_once(ROOT_PATH.'raports/raport_'.$RID.'.php');

$template	= new template();

$template->isPopup(true);

$template->assign_vars(array('raport' => $raport));
$template->show('raport.tpl');

?>