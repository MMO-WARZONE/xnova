<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require_once(ROOT_PATH.'extension.inc');
require_once(ROOT_PATH.'common.'.PHP_EXT);
	
$page = request_var('page','');
switch($page)
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'changelog':
		include_once(ROOT_PATH . 'includes/pages/ShowChangelogPage.' . PHP_EXT);
		ShowChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case 'galaxy':
		if(CheckModule(11))
			message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
			
		include_once(ROOT_PATH . 'includes/pages/class.ShowGalaxyPage.' . PHP_EXT);
		$ShowGalaxyPage = new ShowGalaxyPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>