<?php
/**
 * @author Chlorel
 *
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('INSIDE')) {
	die('Hacking attemp');
}

// Functions already 'with the propre'
define('INSIDE' , true);
define('INSTALL', false);

// open all files inside functions folder
$dir = opendir($ugamela_root_path . 'includes/functions');

while (($file = readdir($dir)) !== false) {
	// we check if the file is a include file
	$extension = '.' . substr($file, -3);
	// and include once the file
	if ($extension == ".$phpEx")
		require_once $ugamela_root_path . 'includes/functions/' . $file;
}

?>
