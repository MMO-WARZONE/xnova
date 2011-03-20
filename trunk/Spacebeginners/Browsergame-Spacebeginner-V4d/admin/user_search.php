<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

if ( $user['authlevel'] >= 3 and in_array ($user['id'],$Adminerlaubt) ) {
includeLang('admin/user/user_search');

$PanelMainTPL = gettemplate('admin/user/user_search01');

$parse                  = $lang;
$parse['adm_sub_form1'] = "";
$parse['adm_sub_form2'] = "";
$parse['adm_sub_form3'] = "";
$parse['adm_sub_form4'] = "";

if (isset($_GET['result'])) {
switch ($_GET['result']){
case 'usr_search':
$Pattern = $_GET['player'];
$SelUser = doquery("SELECT * FROM {{table}} WHERE `username` LIKE '%". $Pattern ."%' LIMIT 1;", 'users', true);
$UsrMain = doquery("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

$bloc                   = $lang;
$bloc['answer1']        = $SelUser['id'];
$bloc['answer2']        = $SelUser['username'];
$bloc['answer3']        = $SelUser['user_lastip'];
$bloc['answer4']        = $SelUser['email'];
$bloc['answer5']        = $lang['adm_usr_level'][ $SelUser['authlevel'] ];
$bloc['answer6']        = $lang['adm_usr_genre'][ $SelUser['sex'] ];
$bloc['answer7']        = "[".$SelUser['id_planet']."] ".$UsrMain['name'];
$bloc['answer8']        = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
$SubPanelTPL            = gettemplate('admin/user/user_search02');
$parse['adm_sub_form2'] = parsetemplate( $SubPanelTPL, $bloc );
break;

case 'usr_data':
$Pattern = $_GET['player'];
$SelUser = doquery("SELECT * FROM {{table}} WHERE `username` LIKE '%". $Pattern ."%' LIMIT 1;", 'users', true);
$UsrMain = doquery("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

$bloc                    = $lang;
$bloc['answer1']         = $SelUser['id'];
$bloc['answer2']         = $SelUser['username'];
$bloc['answer3']         = $SelUser['user_lastip'];
$bloc['answer4']         = $SelUser['email'];
$bloc['answer5']         = $lang['adm_usr_level'][ $SelUser['authlevel'] ];
$bloc['answer6']         = $lang['adm_usr_genre'][ $SelUser['sex'] ];
$bloc['answer7']         = "[".$SelUser['id_planet']."] ".$UsrMain['name'];
$bloc['answer8']         = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
$SubPanelTPL             = gettemplate('admin/user/user_search02');
$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );

$parse['adm_sub_form2']  = "<table width=\"95%\">";
$parse['adm_sub_form2'] .= "<tr><td class=\"c\" width=\"50%\" align=\"left\" colspan=\"4\">".$lang['user_af']."</td><th width=\"50%\" colspan=\"4\">&nbsp;</th></tr>";
$parse['adm_sub_form2'] .= "<tr><th align=\"center\" colspan=\"1\" width=\"12%\">".$lang['user_af01']."</th><th align=\"center\" colspan=\"1\" width=\"13%\">".$lang['user_af02']."</th><th align=\"center\" colspan=\"1\" width=\"12%\">".$lang['user_af03']."</th><th align=\"center\" colspan=\"1\" width=\"13%\">".$lang['user_af04']."</th></tr>";

$UsrColo = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelUser['id'] ." ORDER BY `galaxy` ASC, `planet` ASC, `system` ASC, `planet_type` ASC';", 'planets');
while ( $Colo = mysql_fetch_assoc($UsrColo) ) {
if ($Colo['id'] != $SelUser['id_planet']) {

$parse['adm_sub_form2'] .= "<tr><th align=\"center\" width=\"12%\">".$Colo['id']."</th>";
$parse['adm_sub_form2'] .= "<th align=\"center\" width=\"13%\">". (($Colo['planet_type'] == 1) ? $lang['user_af05'] : $lang['user_af06'] ) ."</th>";
$parse['adm_sub_form2'] .= "<th align=\"center\" width=\"12%\">[".$Colo['galaxy'].":".$Colo['system'].":".$Colo['planet']."]</th>";
$parse['adm_sub_form2'] .= "<th align=\"center\" width=\"13%\">".$Colo['name']."</th></tr>";
} }

$parse['adm_sub_form2'] .= "</table>";

$parse['adm_sub_form3']  = "<table width=\"95%\">";
$parse['adm_sub_form3'] .= "<tr><td class=\"c\" width=\"50%\" align=\"left\" colspan=\"2\">".$lang['user_ag']."</td><th width=\"50%\" colspan=\"2\">&nbsp;</th></tr> </tr>";
$parse['adm_sub_form3'] .= "<tr><th align=\"left\" colspan=\"1\" width=\"25%\"><u>".$lang['user_ag01']."</u></th><th align=\"center\" colspan=\"1\" width=\"25%\"><u>".$lang['user_ag02']."</u></th></tr>";

for ($Item = 100; $Item <= 199; $Item++) {
if ($resource[$Item] != "") {
$parse['adm_sub_form3'] .= "<tr><th align=\"left\" width=\"25%\">".$lang['tech'][$Item]."</th>";
$parse['adm_sub_form3'] .= "<th align=\"center\" width=\"25%\">".$SelUser[$resource[$Item]]."</th></tr>";
} }
$parse['adm_sub_form3'] .= "</tbody></table>";
break;

case 'usr_level':
$Player     = $_GET['player'];
$NewLvl     = $_GET['authlvl'];

$QryUpdate  = doquery("UPDATE {{table}} SET `authlevel` = '".$NewLvl."' WHERE `username` = '".$Player."';", 'users');
$Message    = $lang['adm_mess_lvl1']. " ". $Player ." ".$lang['adm_mess_lvl2'];
$Message   .= "<font color=\"red\">".$lang['adm_usr_level'][ $NewLvl ]."</font>!";

AdminMessage ( $Message, $lang['adm_mod_level'] );
break;

} }


if (isset($_GET['action'])) {
$bloc    = $lang;

switch ($_GET['action']){
case 'usr_data':
$SubPanelTPL            = gettemplate('admin/user/user_search03');
break;

case 'usr_level':
for ($Lvl = 0; $Lvl < 4; $Lvl++) {
$bloc['adm_level_lst'] .= "<option value=\"". $Lvl ."\">". $lang['adm_usr_level'][ $Lvl ] ."</option>";
}
$SubPanelTPL            = gettemplate('admin/user/user_search04');
break;

default:
break;
}
$parse['adm_sub_form2'] = parsetemplate( $SubPanelTPL, $bloc );
}

$page = parsetemplate( $PanelMainTPL, $parse );
display( $page, $lang['panel_mainttl'], false, '', true );
} else {
message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

?>