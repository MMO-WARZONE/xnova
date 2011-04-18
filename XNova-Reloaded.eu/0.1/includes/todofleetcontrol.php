<?php
/**
 *
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// Fonctions deja 'au propre'
if (!defined('INSIDE')) {
	die('Hacking attemp');
}

// Functions already 'with the propre'
define('INSIDE' , true);
define('INSTALL', false);

// open all files inside functions folder
$dir = opendir(XNOVA_ROOT_PATH . 'includes/functions');

while (($file = readdir($dir)) !== false) {
	// we check if the file is a include file
	$extension = '.' . substr($file, -3);
	// and include once the file
	if ($extension == ".php")
		require_once XNOVA_ROOT_PATH . 'includes/functions/' . $file;
}


?>