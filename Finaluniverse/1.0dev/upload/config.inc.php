<?php
// game.wot.core vars
// core
if (!defined('CORE_DIR')) define('CORE_DIR', dirname(__FILE__).'/');
if (!defined('RELATIVE_CORE_DIR')) define('RELATIVE_CORE_DIR', '');
if (!defined('CORE_N')) define('CORE_N', '1_1');
$packageDirs[] = CORE_DIR;

// com.woltlab.wbb vars
// wbb
if (!defined('WBB_DIR')) define('WBB_DIR', '');
if (!defined('RELATIVE_WBB_DIR')) define('RELATIVE_WBB_DIR', RELATIVE_CORE_DIR.'forum/');
if (!defined('WBB_N')) define('WBB_N', '1_1');
$packageDirs[] = WBB_DIR;

// general info
if (!defined('RELATIVE_WCF_DIR'))	define('RELATIVE_WCF_DIR', RELATIVE_CORE_DIR.'wcf/');
if (!defined('PACKAGE_ID')) define('PACKAGE_ID', 79);
if (!defined('PACKAGE_NAME')) define('PACKAGE_NAME', 'WOT Game Core');
if (!defined('PACKAGE_VERSION')) define('PACKAGE_VERSION', '1.2.1');
?>