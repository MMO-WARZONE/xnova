<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = '../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('admin');

$parse = $lang;

if ($IsUserChecked == false || $user['authlevel'] < 2) {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

if(!$_POST['Optimieren']) {
	$tables = doquery("SHOW TABLES","todas");
	while ($row = mysql_fetch_assoc($tables))  {
		foreach ($row as $opcion => $table) {
			$parse['table'] .= "<tr>";
			$parse['table'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#000000\"><strong>".$table."</strong></td>";
			$parse['table'] .= "</tr>";
		}
	}
} else {
	$tables = doquery("SHOW TABLES",'todas');
	while ($row = mysql_fetch_assoc($tables))  {
		foreach ($row as $opcion => $table) {
			doquery("OPTIMIZE TABLE {$table}", "$table");
			if (mysql_errno()){
				$parse['table'] .= "<tr>";
				$parse['table'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#000000\"><strong>".$table."</strong></td>";
				$parse['table'] .= "<td class=\"b\" colspan=\"2\" style=\"color:red\"><strong>".$lang['optimieren_not_done']."</strong></td>";
				$parse['table'] .= "</tr>";
			}else{
				$parse['table'] .= "<tr>";
				$parse['table'] .= "<td class=\"c\" style=\"color:#000000\"><strong>".$table."</strong></td>";
				$parse['table'] .= "<td class=\"b\" style=\"color:green\"><strong>".$lang['optimieren_done']."</strong></td>";
				$parse['table'] .= "</tr>";
			}
		}
	}
}

$tpl_menu = gettemplate('admin/optimieren');
$menu = parsetemplate($tpl_menu, $parse);
display($menu, $lang['optimieren_title'], '', false);

?>
   