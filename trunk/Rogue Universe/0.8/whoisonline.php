<?php

define('INSIDE' , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
if($user['username'] == '') header('Location: login.php');

    includeLang('whoisonline');
    $parse = $lang;

$maxtime = 600; // Nombre de secondes durant les quelles le joueur est considéré "actif"
$row_tpl = gettemplate('whoisonline_row');
$query = doquery("SELECT `username`, `authlevel`, `onlinetime`, `ally_id` FROM {{table}} WHERE `onlinetime` > '".(time() - $maxtime)."';", 'users');
$Count = 0;

while ($row = mysql_fetch_array($query)) {
  // Tag de l'alliance et nom de joueur

  if ($row['ally_id'] != 0) {
    $rally = doquery("SELECT `ally_tag` FROM {{table}} WHERE `id` = '". $row['ally_id'] ."';", 'alliance');
    $rallyA = mysql_fetch_array($rally);
    $rtag = '['.$rallyA[0].']';
  } else {
    $rtag = '';
  }

  // Rang du joueur
  if ($row['authlevel'] == 1) {
      $rparse['rank_status']   = '<font color="gold"> '. $lang['moderator'] .'</font>';
  } elseif ($row['authlevel'] == 2) {
      $rparse['rank_status']   = '<font color="orange">'. $lang['gameadmin'] .'</font>';
  } elseif ($row['authlevel'] == 3) {
      $rparse['rank_status']   = '<font color="lime"> '. $lang['admin'] .' </font>';
  } else {
      $rparse['rank_status']   = ' '. $lang['player'] .' ';
  }

  $rparse['user_name']  = $row['username'];
  $rparse['ally_tag']   = $rtag;
  $rparse['last_click'] = date('d/m/Y H:i:s', $row['onlinetime']);

  // Calcul du temps écoulé
  $time_diff = time() - $row['onlinetime'];

  // Pour les minutes
  if ($time_diff > 60) {
    $time_minutes = floor($time_diff / 60).'m ';
    $time_diff = $time_diff%60;
  }
  $rparse['time_diff']  = $time_minutes.$time_diff.'s';
  $parse['online_list'] .= parsetemplate($row_tpl, $rparse);
  $Count++;
}
  $parse['online_count']  = $Count;

  display(parsetemplate(gettemplate('whoisonline'), $parse), 'Online', false);

?>