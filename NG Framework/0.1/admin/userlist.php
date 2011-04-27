<?php
/**
 * @author Chlorel
 *
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users and non-admin
if ($IsUserChecked == false || $user['authlevel'] < 2) {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

includeLang('admin');

// delete a user
if ($_GET['cmd'] == 'dele') {
	DeleteSelectedUser($_GET['user']);
}
// to order the contents
if ($_GET['cmd'] == 'sort') {
	// to prevent errors
	switch ($_GET['type']) {
		case 'email':         $short = 'email';         break;
		case 'username':      $short = 'username';      break;
		case 'user_lastip':   $short = 'user_lastip';   break;
		case 'register_time': $short = 'register_time'; break;
		case 'onlinetime':    $short = 'onlinetime';    break;
		case 'bana':          $short = 'bana';          break;
		default:              $short = 'id';            break;
	}
} else {
	$short = 'id';
}

$page_tpl = gettemplate('admin/userlist_body');
$rows_tpl = gettemplate('admin/userlist_rows');

$query   = doquery("SELECT * FROM {{table}} ORDER BY `". $short ."` ASC", 'users');

$parse                 = $lang;
$parse['adm_ul_table'] = '';
// for the user count
$i = 0;
// first color for ip hintligh
$color  = 'lime';

// a second parse array
$bloc          = $lang;
$bloc['dpath'] = $dpath;

while ($u = mysql_fetch_assoc($query)) {
	// to highligh same ip
	if ($previp != '') {
		if ($previp == $u['user_lastip']) {
			$color = 'red';
		} else {
			$color = 'lime';
		}
	}
	
	$bloc['adm_ul_data_id']    = $u['id'];
	$bloc['adm_ul_data_name']  = $u['username'];
	$bloc['adm_ul_useragent']  = $u['user_agent'];
	
	
	$bloc['adm_ul_data_mail']  = $u['email'];
	$bloc['adm_ul_data_adip']  = '<font color="'.$color.'">'. $u['user_lastip'] .'</font>';
	
	$bloc['adm_ul_data_regd']  = gmdate('d/m/Y G:i:s', $u['register_time']);
	// online time
	$bloc['adm_ul_data_lconn']  = ($u['onlinetime']) ? gmdate('d/m/Y G:i:s', $u['onlinetime']) : '<font color="red">unknown</a>';
	
	$bloc['adm_ul_data_banna'] = ($u['bana'] == 1) ? '<a href # title="'. gmdate('d/m/Y G:i:s', $u['banaday']) .'">'. $lang['adm_ul_yes'] .'</a>' : $lang['adm_ul_no'];
	$bloc['adm_ul_data_detai'] = ''; // Lien vers une page de details genre Empire
	$bloc['adm_ul_data_actio'] = '<a href="userlist.php?cmd=dele&user='.$u['id'].'"><img src="../images/r1.png"></a>'; // Lien vers actions 'effacer'
	
	// this var is used to remember the ip, and highligh with a red color
	$previp = $u['user_lastip'];
	
	// sommon the row template
	$parse['adm_ul_table'] .= parsetemplate($rows_tpl, $bloc);
	
	$i++;
}

$parse['adm_ul_count'] = $i;

$page = parsetemplate($page_tpl, $parse);
display($page, $lang['adm_ul_title'], false, '', true);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>
