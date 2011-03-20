<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 1) die(message ($lang['404_page']));

 function actualizacion()
{
	global $game_config;
	$version = @file_get_contents('http://www.xnovarevolution.com.ar/version.php');
	if ($game_config['VERSION'] < $version)
	{
            return true;
		} else {
			return false;
		}
	}

$parse	=	$lang;

if(file_exists($xgp_root . 'install/') && defined('IN_ADMIN'))
{
	$Message	.= "<font color=\"red\">".$lang['ow_install_file_detected']."</font><br/><br/>";
	$error++;
}

if ($user['authlevel'] >= 3)
{
	if(@fopen("./../config.php", "a"))
	{
		$Message	.= "<font color=\"red\">".$lang['ow_config_file_writable']."</font><br/><br/>";
		$error++;
	}

	$Errors = doquery("SELECT COUNT(*) AS `errors` FROM {{table}} WHERE 1;", 'errors', true);

	if($Errors['errors'] != 0)
	{
		$Message	.= "<font color=\"red\">".$lang['ow_database_errors']."</font><br/><br/>";
		$error++;
	}
}

if($error != false)
{
	$parse['error_message']		=	$Message;
	$parse['color']				=	"red";
} else {
	$parse['error_message']		= 	"Actualmente estas usando la version " .$game_config['VERSION'] ." para ver el progreso de la nueva versi&oacute;n haz click <a href=\"http://xnovarevolution.com.ar/foros/viewtopic.php?f=2&t=39&start=0\" target=\"_blank\">aqu&iacute;</a>, Tal vez existe una nueva versi&oacute;n. Informate de ello <a href=\"http://xnovarevolution.com.ar/news.php\" target=\"_blnak\">aqu&iacute;</a>";
	$parse['color']				=	"lime";
}


display( parsetemplate(gettemplate('adm/OverviewBody'), $parse), false, '', true, false);
?>
