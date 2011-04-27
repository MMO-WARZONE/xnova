<?php
/**
 * @author Perberos perberos@gmail.com
 * @author e-Zobar
 * @author angelus_ira
 * 
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = false;
// these lines of code are necessary?
$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode('/', $XNova_Script);

// On vire le script
array_pop($Uri_Array);
$XNova_URI     = implode('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

// start of fix to avoid that one without being be logged to the frames.php
if (!$IsUserChecked)
{
	header('Location: login.php'); 
	die();
}
// end of fix

$parse = $lang;
$parse['ENCODING']  = $langInfos['ENCODING'];
$parse['game_name'] = $game_config['game_name'];

// getting template, parsing and go out
$template = gettemplate('frames');
$html = parsetemplate($template, $parse);
echo $html;

?>
