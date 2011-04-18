<?php

/**
 * erreurs.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

includeLang('admin');
$parse = $lang;

      if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {

                // Supprimer les erreurs
                extract($_GET);
                if (isset($delete)) {
                        doquery("DELETE FROM {{table}} WHERE `error_id`=$delete", 'errors');
                } elseif ($deleteall == 'yes') {
                        doquery("TRUNCATE TABLE {{table}}", 'errors');
                }

                $parse['errors_list'] = "
                        <tr>
                                <td class=\"c\" colspan=\"1\">
                                        Count
                                </td>
                                <td class=\"c\" colspan=\"4\">
                                        Error
                                </td>
                        </tr>";

                $parse['group_errors'] = '<a href="errors.php?group=0">Ungroup Errors</a>';

                if($group == 1){
                        $query = doquery("SELECT error_page, error_text, COUNT(error_id) FROM {{table}} GROUP BY error_text ;", 'errors');
                        while ($u = mysql_fetch_array($query)) {
                                $parse['errors_list'] .= "
                                <tr>
                                        <th width=\"25\">". $u['COUNT(error_id)'] ."</td>
                                        <th colspan=\"4\">". $u['error_page'] ."</td>
                                </tr>
                                <tr><th colspan=\"4\">". nl2br($u['error_text']) ."</td></tr>";
                        }
                }else{
                        // Afficher les erreurs
                        $sort = $_GET['sort'];
                        if(strlen($sort) == 0){ $sort = "error_id"; }
                        if($_GET['ord'] == 2){
                                $ord = "DESC";
                                $parse['oth_ord'] = 1;
                        }else{
                                $ord = "ASC";
                                $parse['oth_ord'] = 2;
                        }

                        $query = doquery("SELECT * FROM {{table}} ORDER BY `".$sort."` ".$ord." ;", 'errors');

                        $parse['group_errors'] = '<a href="errors.php?group=1">Group Errors</a>';

                        $parse['errors_list'] = "
                                <tr>
                                        <td class=\"c\" width=\"60\">
                                                <a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_id\">".$lang['adm_er_idmsg']."</a>
                                        </td>
                                        <td class=\"c\" width=\"190\">
                                                <a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_type\">".$lang['adm_er_type']."</a>
                                        </td>
                                        <td class=\"c\" width=\"250\">
                                                <a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_time\">".$lang['adm_er_time']."</a>
                                        </td>
                                        <td class=\"c\" width=\"20\">
                                                ".$lang['adm_er_delete']."
                                        </td>
                                </tr>";

                        $i = 0;
                        while ($u = mysql_fetch_array($query)) {
                                $i++;
                                $parse['errors_list'] .= "
                                <tr><td width=\"25\" class=n>". $u['error_id'] ."</td>
                                <td width=\"170\" class=n>". $u['error_type'] ."</td>
                                <td width=\"230\" class=n>". date('d/m/Y h:i:s', $u['error_time']) ."</td>
                                <td width=\"95\" class=n><a href=\"?delete=". $u['error_id'] ."\"><img src=\"../images/r1.png\"></a></td></tr>
                                <tr><td colspan=\"4\" class=b>". $u['error_page'] ."</td></tr>
                                <tr><td colspan=\"4\" class=b>". nl2br($u['error_text']) ."</td></tr>";
                        }
                        $parse['errors_list'] .= "<tr>
                                <th class=b colspan=5>". $i ." ". $lang['adm_er_nbs'] ."</th>
                        </tr>";
                }

                display(parsetemplate(gettemplate('admin/errors_body'), $parse), "Bledy", false, '', true);
        } else {
                message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
        }

?>