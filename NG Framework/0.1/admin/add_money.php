<?php
/**
 * @author Chlorel
 * @author portion to e-Zobar
 * @author SainT
 * 
 * 
 * @package XNova
 * @version 1.1
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-admin users
if (!$IsUserChecked || $user['authlevel'] < 2)
	AdminMessage($lang['sys_noalloaw'], $lang['sys_noaccess']);

includeLang('admin');

if (isset($_POST['mode']))
{
	$id      = $_POST['id'];
	$metal   = intval($_POST['metal']);
	$cristal = intval($_POST['cristal']);
	$deut    = intval($_POST['deut']);

	// [MOD] Recursos para todos
	// http://project.xnova.es/viewtopic.php?f=11&t=8
	if ($id == '*')
	{
		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
		$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
		$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
		doquery($QryUpdatePlanet, "planets");
		
		AdminMessage($lang['adm_am_done'], $lang['adm_am_ttle']);
	}
	else
	{
		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
		$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
		$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". intval($id) ."' ";
		doquery($QryUpdatePlanet, "planets");
		
		AdminMessage($lang['adm_am_done'], $lang['adm_am_ttle']);
	}

	AdminMessage($lang['adm_am_done'], $lang['adm_am_ttle']);
}

$template = gettemplate('admin/add_money');
$page     = parsetemplate($template, $lang);

display($page, $lang['adm_am_ttle'], false, '', true);

?>
