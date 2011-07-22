<?php


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

if ($user['authlevel'] >= 1) {

$lang['adm_am_ttle'] = "Gemeldete Nachrichten";
 $parse = $lang;
 includeLang('messages');
if($_GET['mode'] == 'read'){
				if($_GET['del'] == 'ja'){
						$Melden = doquery("UPDATE {{table}} SET `message_melden` = '2' WHERE `message_id` = '{$_GET['ms']}'", 'messages'); message('Nachricht als bearbeitet makiert!<br><a href="meldenadmin.php">Zur&uuml;ck</a>','Erfolgreich!');
									}else{
						$query	   = doquery("SELECT * FROM {{table}}messages WHERE `message_id` = '{$_GET['ms']}';", '', true);
									if($query['message_class'] == 1){$class = "Unwichtig";
									}elseif($query['message_class'] == 2){$class = "Normal";
									}elseif($query['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}
						$page  = "<table width=\"569\">";
						$page .= "<tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $query['message_subject'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $lang['mess_class'] ."</th>";
						$page .= "		<th>". $lang['mess_from'] ."</th>";
						$page .= "		<th>". $lang['mess_date'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $class ."</th>";
						$page .= "		<th>". $query['message_from'] ."(ID=". $query['message_sender'] .")";
						$page .= "</th>";
						$page .= "		<th>". date("m-d H:i:s", $query['message_time']) ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['mess_typ'] ."</th>";
						$page .= "		<th>". $lang['mess_entmelden'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['typ'][$query['message_type']] ."</th>";
						$page .= "		<th><a href=\"messages.php?mode=read&ms={$_GET['ms']}&del=ja\">X</a></th>";
						$page .= "</tr><tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $lang['nachricht_lesen'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\" height=\"200\">". $query['message_text'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $lang['melden_grund'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\">". $query['message_melden_grund'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th class=\"c\" colspan=\"1\">". $lang['melden_time'] ."</th>";
							$page .= "		<th class=\"c\" colspan=\"2\">". $lang['mess_owner'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"1\">". date("m-d H:i:s", $query['message_time']) ."</th>";
						$query2	   = doquery("SELECT * FROM {{table}}users WHERE `id` = '{$query['message_owner']}';", '', true);
						$page .= "		<th colspan=\"2\">". $query2['username'] ."(ID=". $query['message_owner'] .")</tr>";
						$page .= "<tr>";
						$page .= "<th colspan=\"3\"><form action=\"meldenadmin.php\" method=\"GET\">
						<input name=\"mode\" type=\"hidden\" value=\"read\" />
						<input name=\"ms\" type=\"hidden\" value=\"{$_GET['ms']}\" />
								<input name=\"del\" type=\"hidden\" value=\"ja\" />
								<input name=\"\" type=\"submit\" value=\"Bearbeitet\" /></form></th>";
						$page .= "</tr><tr>";
						$page .= "		<td colspan=\"3\" class=\"c\"><a href=\"meldenadmin.php\">". $lang['mess_back'] ."</a></td>";
						$page .= "</tr></table>";
						}
		}elseif($_GET['mode'] == 'alt'){
						$page  = "<center>";
						$page .= "<table width=\"519\">";
						$page .= "<tr>";
						$page .= "<th>".$lang['mess_entmelden']."</th>";
						$page .= "<th>".$lang['mess_owner']."</th>";
						$page .= "<th>".$lang['mess_subject']."</th>";
						$page .= "<th>Melde ".$lang['mess_date']."</th>";
						$page .= "<th>".$lang['mess_from']."</th>";
						$page .= "</tr>";

								$UsrMess	   = doquery("SELECT * FROM {{table}}messages WHERE `message_melden` = '2' ORDER BY `message_time` DESC;", '', false);
								while ($CurMess = mysql_fetch_array($UsrMess)) {
								$query2	   = doquery("SELECT * FROM {{table}}users WHERE `id` = '{$query['message_owner']}';", '', true);
									$page .= "\n<tr>";
									$page .= "<th><a href=\"meldenadmin.php?mode=read&ms=". $CurMess['message_id'] ."&del=ja\">X</a></th>";
									$page .= "<th>". $query2['username'] ."(ID=". $CurMess['message_owner'] .")</th>";
									$page .= "<th><a href=\"meldenadmin.php?mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page .= "<th>". date("m-d H:i:s", $CurMess['message_melden_time']) ."</th>";
									$page .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
									$page .= "</th>";
									$page .= "</tr>";
								}
						$page .= "<tr>";
						$page .= "<td colspan=\"5\" class=\"c\"><a href=\"meldenadmin.php\">Unbearbeitete Nachrichten</a></td>";
						$page .= "</tr>";
						$page .= "</table>\n";
						$page .= "</center>";
				}else{
						$page  = "<center>";
						$page .= "<table width=\"519\">";
						$page .= "<tr>";
						$page .= "<th>".$lang['mess_entmelden']."</th>";
						$page .= "<th>".$lang['mess_owner']."</th>";
						$page .= "<th>".$lang['mess_subject']."</th>";
						$page .= "<th>".$lang['mess_date']."</th>";
						$page .= "<th>".$lang['mess_from']."</th>";
						$page .= "</tr>";

								$UsrMess	   = doquery("SELECT * FROM {{table}}messages WHERE `message_melden` = '1' ORDER BY `message_time` DESC;", '', false);

								while ($CurMess = mysql_fetch_array($UsrMess)) {
								$query2	   = doquery("SELECT * FROM {{table}}users WHERE `id` = '{$CurMess['message_owner']}';", '', true);
									$page .= "\n<tr>";
									$page .= "<th><a href=\"meldenadmin.php?mode=read&ms=". $CurMess['message_id'] ."&del=ja\">X</a></th>";
									$page .= "<th>". $query2['username'] ."(ID=". $CurMess['message_owner'] .")</th>";
									$page .= "<th><a href=\"meldenadmin.php?mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
									$page .= "</th>";
									$page .= "</tr>";
								}
						$page .= "<tr>";
						$page .= "<td colspan=\"5\" class=\"c\"><a href=\"meldenadmin.php?mode=alt\">Bearbeitete Nachrichten</a></td>";
						$page .= "</tr>";
						$page .= "</table>\n";
						$page .= "</center>";
				}
$page .= parsetemplate($PageTpl, $parse);
display ($page, $lang['adm_am_ttle'], false, '', true);

	}else{
        AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>