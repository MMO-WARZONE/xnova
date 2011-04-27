<?php
/**
 * @author e-Zobar
 *
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (filesize('config.php') == 0) // if (!file_exists('config.php'))
{
	header('location: install/');
	exit();
}

header('location: login.php');

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Creation avec redirection vers l'installeur si pas de config.php
?>
