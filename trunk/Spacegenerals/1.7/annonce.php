<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('annonce');

// Schutz vor unregestrierten
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

$users   = doquery("SELECT * FROM {{table}} WHERE id='".$user['id']."';", 'users');
$annonce = doquery("SELECT * FROM {{table}} ", 'annonce');
$action  = $_GET['action'];

if ($action == 5) {
	$metalvendre = intval($_POST['metalvendre']);
	$cristalvendre = intval($_POST['cristalvendre']);
	$deutvendre = intval($_POST['deutvendre']);

	$metalsouhait = intval($_POST['metalsouhait']);
	$cristalsouhait = intval($_POST['cristalsouhait']);
	$deutsouhait = intval($_POST['deutsouhait']);

	while ($v_annonce = mysql_fetch_array($users)) {
		$user = mysql_real_escape_string($v_annonce['username']);
		$iduser = intval($v_annonce['id']);
		$galaxie = intval($v_annonce['galaxy']);
		$systeme = intval($v_annonce['system']);
	}

	doquery("INSERT INTO {{table}} SET
		user='{$user}',
		iduser='{$iduser}',
		galaxie='{$galaxie}',
		systeme='{$systeme}',
		metala='{$metalvendre}',
		cristala='{$cristalvendre}',
		deuta='{$deutvendre}',
		metals='{$metalsouhait}',
		cristals='{$cristalsouhait}',
		deuts='{$deutsouhait}'" , "annonce");

	$page2 .="<center>
	<br>
	<p>".$lang['ANNONCE_SAVED']."</p>
	<br><p><a href=\"annonce.php\">".$lang['ANNONCE_BACK']."</a></p>";

	display($page2);
} elseif (!$action) {
	$annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");

	$page2 = "<center>
	<br>
	<table width=\"600\">".$lang['ANNONCE_HEADER'];
	while ($b = mysql_fetch_array($annonce)) {
		$page2 .= '<tr><th> ';
		$page2 .= $b["user"] ;
		$page2 .= '</th><th>';
		$page2 .= $b["galaxie"];
		$page2 .= '</th><th>';
		$page2 .= $b["systeme"];
		$page2 .= '</th><th>';
		$page2 .= $b["metala"];
		$page2 .= '</th><th>';
		$page2 .= $b["cristala"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuta"];
		$page2 .= '</th><th>';
		$page2 .= $b["metals"];
		$page2 .= '</th><th>';
		$page2 .= $b["cristals"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuts"];
		$page2 .= '</th><th>';
		if($b['user'] == $user['username']){
			$page2 .= "<a href=\"annonce.php?action=del&id=".$b['id']."\">".$lang['ANNONCE_DELETE']."</a>";
		}else{
			$page2 .= "<a href=\"messages.php?mode=write&id=".$b['iduser']."\">".$lang['ANNONCE_CONTACT']."</a>";
		}
		$page2 .= "</th></tr>";
	}

	$page2 .= "
	<tr><th colspan=\"10\" align=\"center\"><a href=\"annonce2.php?action=2\">".$lang['ANNONCE_CREATE_ANNONCE']."</a></th></tr>
	</td>
	</table>";

	display($page2);
} elseif($action == 'del') {
	$page2 = "<center><br><table width=\"600\"><td class=\"c\" colspan=\"10\"><font color=\"#FFFFFF\">".$lang['ANNONCE_DELETE_ANNONCE']."?</font></td></tr><tr><th colspan=\"3\">".$lang['ANNONCE_DELETE_CONFIRM']."?</th></tr><tr><th colspan=\"10\" align=\"center\"><a href=\"annonce.php?action=delja&id=". $_GET['id'] ."\">".$lang['ANNONCE_YES']."</a> -- <a href=\"annonce.php\">".$lang['ANNONCE_NO']."</a></th></tr></td></table>";
	display($page2);
} elseif($action == 'delja') {
	doquery("DELETE FROM `{{table}}` WHERE `id` = ". intval($_GET['id']) ." AND `user` = '". $user['username'] ."' LIMIT 1", 'annonce');
	message($lang['ANNONCE_DELETED'], $lang['ANNONCE_OK']);
}

?>