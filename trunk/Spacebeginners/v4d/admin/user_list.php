<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_list');
if ($_GET['cmd'] == 'dele') {
DeleteSelectedUser ( intval($_GET['user']) );
}
if ($_GET['cmd'] == 'sort') {
$TypeSort = mysql_real_escape_string($_GET['type']);
} else {
$TypeSort = "id";
}

$PageTPL = gettemplate('admin/user/user_list01');
$RowsTPL = gettemplate('admin/user/user_list02');
$NowsTPL = gettemplate('admin/user/user_list03');
$query   = doquery("SELECT * FROM {{table}} ORDER BY `". $TypeSort ."` ASC", 'users');

$parse                 = $lang;
$parse['adm_ul_table'] = "";
$i                     = 0;
$Color                 = "lime";
while ($u = mysql_fetch_assoc ($query) ) {
if ($PrevIP != "") {
if ($PrevIP == $u['user_lastip']) {
$Color = "red";
} else {
$Color = "lime";
}
}
$monde = doquery("SELECT id FROM {{table}} WHERE id_owner= '".$u['id']."'",'lunas');
$Bloc['adm_ul_data_id']     = $u['id'];
$Bloc['adm_ul_data_name']   = $u['username'];
$Bloc['adm_ul_data_hp']     = $u['galaxy'].':'.$u['system'].':'.$u['planet'];
$Bloc['adm_ul_data_moons']  = mysql_num_rows($monde);
$Bloc['adm_ul_data_mail']   = $u['email'];
$Bloc['adm_ul_data_adip']   = "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>";
$Bloc['adm_ul_data_regd']   = date ( "d/m/Y G:i:s", $u['register_time'] );
$Bloc['adm_ul_data_lconn']  = date ( "d/m/Y G:i:s", $u['onlinetime'] );
$Bloc['adm_ul_data_banna']  = ( $u['bana'] == 1 ) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">". $lang['adm_ul_yes'] ."</a>" : $lang['adm_ul_no'];
$Bloc['adm_ul_data_umod']   = $u['urlaubs_modus'] ? 'Ja' : 'Nein';
$Bloc['adm_ul_data_actio']  = "<a href=\"user_list.php?cmd=dele&user=".$u['id']."\"><img src=\"../images/r1.png\"></a>"; // Lien vers actions 'effacer'
$PrevIP                     = $u['user_lastip'];
$parse['adm_ul_table']     .= parsetemplate( $RowsTPL, $Bloc );
$i++;
}
$parse['adm_ul_count'] = $i;

if(isset($_GET['action']) && isset($_GET['id'])) {
$id = intval($_GET['id']);
$query                   = doquery("SELECT * FROM {{table}} WHERE id='".$id."' LIMIT 1", "users");
$users                   = mysql_fetch_array($query);
$users['umodchecked']    = $users['urlaubs_modus'] ? 'checked=checked' : '';
$users['banchecked']     = ( $users['bana'] == 1 ) ? 'checked=checked' : '';
$parse['show_edit_form'] = parsetemplate($NowsTPL, $users);
}
if(isset($_POST['submit'])) {

$edit_id    = intval($_POST['currid']);
$username   = mysql_real_escape_string($_POST['username']);
$email      = mysql_real_escape_string($_POST['email']);
$bantime    =  intval($_POST['ban_days'] * 86400);
$bantime    += intval($_POST['ban_hours'] * 3600);
$bantime    += intval($_POST['ban_mins'] * 60);
$bantime    += intval($_POST['ban_secs']);
$bantime    = time() + $bantime;

if($_POST['gesperrt'] == 1) {
$bana = '`bana` = 1,`urlaubs_modus` = 1,`banaday` = '. $bantime;

$bann = doquery("INSERT INTO {{table}} SET
`who`           = '".$username."',
`theme`         = '".mysql_real_escape_string($_POST['reason'])."',
`who2`          = '".$username."',
`time`          = '".time()."',
`longer`        = '".$bantime."',
`author`        = '".$user['username']."',
`email`         = '".$user['email']."'",'banned');
}else{
$bana = '`bana` = 0,`banaday` = 0';
}
if($_POST['umod'] == 1) {
$umod = '`urlaubs_modus` = 1';
}else{
$umod = '`urlaubs_modus` = 0';
}

$query = doquery("UPDATE {{table}} SET
`username`              = '".$username."',
`email`                 = '".$email."',
`spy_tech`              = '".intval($_POST['spy_tech'])."',
`prod_op`               = '".intval($_POST['prod_op'])."',
`computer_tech`         = '".intval($_POST['computer_tech'])."',
`military_tech`         = '".intval($_POST['military_tech'])."',
`defence_tech`          = '".intval($_POST['defence_tech'])."',
`shield_tech`           = '".intval($_POST['shield_tech'])."',
`energy_tech`           = '".intval($_POST['energy_tech'])."',
`hyperspace_tech`       = '".intval($_POST['hyperspace_tech'])."',
`combustion_tech`       = '".intval($_POST['combustion_tech'])."',
`impulse_motor_tech`    = '".intval($_POST['impulse_motor_tech'])."',
`hyperspace_motor_tech` = '".intval($_POST['hyperspace_motor_tech'])."',
`laser_tech`            = '".intval($_POST['laser_tech'])."',
`ionic_tech`            = '".intval($_POST['ionic_tech'])."',
`buster_tech`           = '".intval($_POST['buster_tech'])."',
`intergalactic_tech`    = '".intval($_POST['intergalactic_tech'])."',
`expedition_tech`       = '".intval($_POST['expedition_tech'])."',
`graviton_tech`         = '".intval($_POST['graviton_tech'])."',
`rpg_points`            = '".intval($_POST['rpg_points'])."',
`intergalactic_tech`    = '".intval($_POST['intergalactic_tech'])."',
`expedition_tech`       = '".intval($_POST['expedition_tech'])."',
`graviton_tech`         = '".intval($_POST['graviton_tech'])."',
`rpg_geologue`          = '".intval($_POST['rpg_geologue'])."',
`rpg_amiral`            = '".intval($_POST['rpg_amiral'])."',
`rpg_ingenieur`         = '".intval($_POST['rpg_ingenieur'])."',
`rpg_technocrate`       = '".intval($_POST['rpg_technocrate'])."',
`rpg_espion`            = '".intval($_POST['rpg_espion'])."',
`rpg_constructeur`      = '".intval($_POST['rpg_constructeur'])."',
`rpg_scientifique`      = '".intval($_POST['rpg_scientifique'])."',
`rpg_commandant`        = '".intval($_POST['rpg_commandant'])."',
`rpg_points`            = '".intval($_POST['rpg_points'])."',
`rpg_stockeur`          = '".intval($_POST['rpg_stockeur'])."',
`rpg_defenseur`         = '".intval($_POST['rpg_defenseur'])."',
`rpg_destructeur`       = '".intval($_POST['rpg_destructeur'])."',
`rpg_general`           = '".intval($_POST['rpg_general'])."',
`rpg_bunker`            = '".intval($_POST['rpg_bunker'])."',
`rpg_raideur`            = '".intval($_POST['rpg_raideur'])."',
`rpg_empereur`          = '".intval($_POST['rpg_empereur'])."',
".$bana.",
".$umod."

WHERE `id` = '".$edit_id."' LIMIT 1",'users');


		// AdminLOG - Helmchen
           $fp = @fopen('logs/adminlog_'.date('d.m.Y').'.php','a');
           fwrite($fp, " <?php\n");
           fwrite($fp, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
           fwrite($fp, "\$Logtext = ' \n");
           fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values of user with ID: ".$edit_id."';\n");
           fwrite($fp, " ?>\n");
           fclose($fp);
          // AdminLOG ENDE
AdminMessage ('<meta http-equiv="refresh" content="1; url=user_list.php">Die Einstellungen wurden erfolgreich ge&auml;ndert', 'User-Einstellungs-Bereich');
}

$page = parsetemplate( $PageTPL, $parse );
display( $page, $lang['adm_ul_title'], false, '', true);
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>