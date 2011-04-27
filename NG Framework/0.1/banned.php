<?php
/**
 * @author e-Zobar
 *
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Sancionados'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación
	

includeLang('banned');

$parse           = $lang;
$parse['dpath']  = $dpath;
$parse['mf']     = $mf;

$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;", 'banned');
$i = 0;

$template = gettemplate('banned_row');

while ($row = mysql_fetch_array($query))
{
	$row['time']   = gmdate('d/m/Y G:i:s', $row['time']);
	$row['longer'] = gmdate('d/m/Y G:i:s', $row['longer']);
	
	$parse['banned'] .= parsetemplate($template, $row);
	$i++;
}

if ($i == 0)
{
	$parse['banned'] .= "<tr><th class=b colspan=6>{$lang['ban_no']}</th></tr>";
}
else
{
	$parse['banned'] .= "<tr><th class=b colspan=6>{$lang['ban_thereare']} {$i} {$lang['ban_players']}</th></tr>";
}

$body = gettemplate('banned_body');

display(parsetemplate($body, $parse), $lang['ban_title'], true);

?>
