<?php
/**
 * An ugly plugins system for Xnova, a gift from DSC 1.1
 * @author Perberos
 *
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('INSIDE')) {
	die('Hacking attemp');
}

// return the name of php file without extension
function phpself()
{
	global $ugamela_root_path;
	
	$file = pathinfo($_SERVER['PHP_SELF']);
	//fix for PHP PHP 4 > 5.2.0
	if (version_compare(PHP_VERSION, '5.2.0', '<'))
		$file['filename'] = substr($file['basename'], 0,
			strlen($file['basename']) - strlen($file['extension']) - 1);
	
	if (basename($ugamela_root_path) != '.')
		return basename($file['dirname']) . '/' . $file['filename'];
	else
		return $file['filename'];
}

// return if a name of php file is same of $name
function is_phpself($name)
{
	return (phpself() == $name);
}

// making a little better the code using 1 var instead 2
$plugins_path = $ugamela_root_path . 'plugins/';
// this variable is only for compatibility reasons, using version_compare()
$plugins_version = '0.1.1';

// open all files inside plugins folder
$dir = opendir($plugins_path);

while (($file = readdir($dir)) !== false) {
	// we check if the file is a include file
	$extension = '.' . substr($file, -3);
	// and include once the file
	if ($extension == ".$phpEx") {
		include $plugins_path . $file;
	// way the way, whe check if the plugin is inside of a folder
	} elseif (file_exists($plugins_path . $file . '/' . $file . '.' . $phpEx)) {
		include $plugins_path . $file . '/' . $file . '.' . $phpEx;
	}
}

?>
