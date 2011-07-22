<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('admin/banned');

if ($user['authlevel'] >= 3) {
	if ($_GET['x'] == 'add') {
		if ($_POST['add']){

			$ip = $_POST['ip'];
			if (!$ip){
				message($lang['add_no_ip'], $lang['error']);
			}
			addban($ip,$_POST[reason],$_POST[legnth]);
		
		}else{
		$page1 .= parsetemplate(gettemplate('admin/bannedipform'), $lang);
		display($page1, $lang['ip_ban_sys'], false, '', true );
		}
	}
	if ($_GET['x'] == 'delete') {
		if ($_GET['id']){
			delban($_GET['id']);
		}else{
		// show error
		message($lang['rem_no_ip'], $lang['error']);
		}
	}
	$listbanned = doquery("SELECT * FROM {{table}}", 'bannedip');
	$i = 0;
	$banned_list = '';
	while ($r = mysql_fetch_array($listbanned)){
		$i++;
		$r['i'] = $i;
		$r['razon'] = $r['reason'];
		$r['borrar'] = "<a href=\"./banadmin.php?x=delete&id={$r[id]}\">Bann aufheben</a>";
		$banned_list .= parsetemplate(gettemplate('admin/bannedip_row'), $r);
	}
	$lang['lista'] = $banned_list;
	$page .= parsetemplate(gettemplate('admin/bannedip'), $lang);
	display($page, $lang['ip_ban_sys'], false, '', true );
}else{
message($lang['no_admin'], $lang['error']);
}

?>