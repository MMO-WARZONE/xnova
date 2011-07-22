<?php

define('INSIDE', true);
define('INSTALL', false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('admin');

$aks = doquery("SELECT * FROM {{table}} WHERE `name` = '" . $_GET['aksname'] . "'", 'aks', true);
$fleets = preg_split('#\,#', $aks['fleets']);
$n = count($fleets);

for ($j = 0; $j < $n - 1; $j++) {
	$f[$j] = doquery("SELECT * FROM {{table}} WHERE fleet_id=" . $fleets[$j], 'fleets', true);
}

if (!isset($_POST['newpart'])) {
	$display = '<form id="addpart" name="addpart" method="post" action="aksinvitation.php?aksname=' . $aks['name'] . '">
	<input type="text" name="newpart" id="textfield" />
	<input type="submit" name="button" id="button" value="'.$lang['aksinvitation_button_invite'].'" />
	</form>';
} elseif ($_POST['newpart'] == '') {
	$display = '<a><font color=white>'.$lang['aksinvitation_error_full'].'</font></a><a href ="./aksinvitation.php">'.$lang['aksinvitation_back'].'</a>';
} else {

	$newpart = doquery("SELECT * FROM {{table}} WHERE `username` = '" . $_POST['newpart'] . "'", 'users', true);
	doquery("UPDATE {{table}} SET `invited` = '" . $aks['invited'] . "," . $newpart['id'] . "' WHERE `id` ='" . $aks['id'] . "' ", 'aks');
	$Subject = $lang['aksinvitation_message_subject'];
	$search = array( '##player##', '##aks##', '##start##' );
	$replace = array( $user['username'], $aks['name'], gmdate("d/m/y H:i:s", $f[0]['fleet_start_time']) );
	$Message = str_replace($search, $replace, $lang['aksinvitation_message_text']);
	SendSimpleMessage($newpart['id'], $user['id'], time(), 1, $user['username'], $Subject, $Message);
	$display = ($newpart != array()) ? '<a><font color=white>'.$lang['aksinvitation_message_send'].'</font></a><a href ="./aksinvitation.php">'.$lang['aksinvitation_back'].'</a>' : '<a><font color=white>'.$lang['aksinvitation_error_player'] . $_POST['newpart'] . '.  </font></a><a href ="./aksinvitation.php">'.$lang['aksinvitation_back'].'</a>';
}
echo $display;
?>