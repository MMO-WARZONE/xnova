<?php

/**
 * messages.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

		includeLang('messages');


		$OwnerID	   = $_GET['id'];
		$MessCategory  = $_GET['messcat'];
		$MessPageMode  = $_GET["mode"];
		$DeleteWhat	= $_POST['deletemessages'];
		$Melden		   = $_POST['meldentyp'];
		if (isset ($DeleteWhat)) {
				$MessPageMode = "delete";
		}
		if (isset ($Melden)) {
				$MessPageMode = "melden";
		}

		$UsrMess	   = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' ORDER BY `message_time` DESC;", 'messages');
		$UnRead		= doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['id'] ."';", 'users', true);

		$MessageType   = array ( 0, 1, 2, 3, 4, 5, 15, 99, 100 );
		$TitleColor	= array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#030070', 99 => '#007070', 100 => '#ABABAB'  );
		$BackGndColor  = array ( 0 => '#663366', 1 => '#336666', 2 => '#000099', 3 => '#666666', 4 => '#999999', 5 => '#999999', 15 => '#999999', 99 => '#999999', 100 => '#999999'  );

	$messfields = array (
	0 => "mnl_spy",
	1 => "mnl_joueur",
	2 => "mnl_alliance",
	3 => "mnl_attaque",
	4 => "mnl_exploit",
	5 => "mnl_transport",
	15 => "mnl_expedition",
	97 => "mnl_general",
	99 => "mnl_buildlist",
	100 => "new_message"
	);
		for ($MessType = 0; $MessType < 101; $MessType++) {
				if ( in_array($MessType, $MessageType) ) {
						$WaitingMess[$MessType] = $UnRead[$messfields[$MessType]];
						$TotalMess[$MessType]   = 0;
				}
		}

		while ($CurMess = mysql_fetch_array($UsrMess)) {
				$MessType			  = $CurMess['message_type'];
				$TotalMess[$MessType] += 1;
				$TotalMess[100]	   += 1;
		}

		switch ($MessPageMode):
				case 'write':
					// -------------------------------------------------------------------------------------------------------
					// NACHRICHT SCHREIBEN
					if ( !is_numeric( $OwnerID ) ) {
						message ($lang['mess_no_ownerid'], $lang['mess_error']);
					}
		
					$OwnerRecord = doquery("SELECT * FROM {{table}} WHERE `id` = '".$OwnerID."';", 'users', true);
		
					if (!$OwnerRecord) {
						message ($lang['mess_no_owner']  , $lang['mess_error']);
					}
		
					$OwnerHome   = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $OwnerRecord["id_planet"] ."';", 'galaxy', true);
					if (!$OwnerHome) {
						message ($lang['mess_no_ownerpl'], $lang['mess_error']);
					}
		
					if ($_POST) {
						$error = 0;
						if (!$_POST["subject"]) {
							$error++;
							$page .= "<center><br><font color=#FF0000>".$lang['mess_no_subject']."<br></font></center>";
						}
						if (!$_POST["text"]) {
							$error++;
							$page .= "<center><br><font color=#FF0000>".$lang['mess_no_text']."<br></font></center>";
						}
						if ($error == 0) {
							$page .= "<center><font color=#00FF00>".$lang['mess_sended']."<br></font></center>";
		
							$_POST['text'] = str_replace("'", '&#39;', $_POST['text']);
		//					$_POST['text'] = str_replace('\r\n', '<br />', $_POST['text']);
		
							$Owner   = $OwnerID;
							$Sender  = $user['id'];
							$From	= $user['username'] ." [".$user['galaxy'].":".$user['system'].":".$user['planet']."]";
							$Subject = $_POST['subject'];
							$Class = $_POST['class'];
							$Message = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );
							SendSimpleMessage2 ( $Owner, $Sender, '', 1, $From, $Subject, $Message, $Class);
							$subject = "";
							$text	= "";
						}
					}
					$parse['Send_message'] = $lang['mess_pagetitle'];
					$parse['Recipient']	= $lang['mess_recipient'];
					$parse['Subject']	  = $lang['mess_subject'];
					$parse['Class']	  = $lang['mess_class'];
					$parse['Message']	  = $lang['mess_message'];
					$parse['characters']   = $lang['mess_characters'];
					$parse['Envoyer']	  = $lang['mess_envoyer'];
					$parse['wichtig']	  = $lang['wichtig'];
					$parse['normal']	  = $lang['normal'];
					$parse['unwichtig']	  = $lang['unwichtig'];
		
					$parse['id']		   = $OwnerID;
					$parse['to']		   = $OwnerRecord['username'] ." [".$OwnerHome['galaxy'].":".$OwnerHome['system'].":".$OwnerHome['planet']."]";
					$parse['subject']	  = (!isset($subject)) ? $lang['mess_no_subject'] : $subject ;
					$parse['text']		 = $text;
		
					$page				 .= parsetemplate(gettemplate('messages_pm_form'), $parse);
						break;

				case 'delete':
						// -------------------------------------------------------------------------------------------------------
						// Suppression des messages selectionnÃ©s
						$DeleteWhat = $_POST['deletemessages'];
						if	   ($DeleteWhat == 'deleteall') {
								doquery("DELETE FROM {{table}} WHERE `message_owner` = '". $user['id'] ."';", 'messages');
						} elseif ($DeleteWhat == 'deletemarked') {
								foreach($_POST as $Message => $Answer) {
										if (preg_match("/delmes/i", $Message) && $Answer == 'on') {
												$MessId   = str_replace("delmes", "", $Message);
												$MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."';", 'messages');
												if ($MessHere) {
														doquery("DELETE FROM {{table}} WHERE `message_id` = '".$MessId."';", 'messages');
												}
										}
								}
						} elseif ($DeleteWhat == 'deleteunmarked') {
								foreach($_POST as $Message => $Answer) {
										$CurMess	= preg_match("/showmes/i", $Message);
										$MessId	 = str_replace("showmes", "", $Message);
										$Selected   = "delmes".$MessId;
										$IsSelected = $_POST[ $Selected ];
										if (preg_match("/showmes/i", $Message) && !isset($IsSelected)) {
												$MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."';", 'messages');
												if ($MessHere) {
														doquery("DELETE FROM {{table}} WHERE `message_id` = '".$MessId."';", 'messages');
												}
										}
								}
						}
						$MessCategory = $_POST['category'];

				case 'show':
						// -------------------------------------------------------------------------------------------------------
						// NACHRICHTEN ANZEIGEN
						$page  = "<script language=\"JavaScript\">\n";
						$page .= "function f(target_url, win_name) {\n";
						$page .= "var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');\n";
						$page .= "new_win.focus();\n";
						$page .= "}\n";
						$page .= "</script>\n";
						$page .= "<center>";
						$page .= "<table>";
						$page .= "<tr>";
						$page .= "<td></td>";
						$page .= "<td>\n";
						$page .= "<table width=\"519\">";
						$page .= "<form action=\"messages.php\" method=\"post\"><table>";
						$page .= "<tr>";
						$page .= "<td></td>";
						$page .= "<td>\n<input name=\"messages\" value=\"1\" type=\"hidden\">";
						$page .= "<table width=\"519\">";
						$page .= "<tr>";
						$page .= "<th colspan=\"5\">";
						$page .= "<select onchange=\"document.getElementById('deletemessages').options[this.selectedIndex].selected='true'\" id=\"deletemessages2\" name=\"deletemessages2\">";
						$page .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
						$page .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
						$page .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
						$page .= "</select>";
						$page .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
						$page .= "</th>";
						$page .= "</tr><tr>";
						$page .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"5\">";
						$page .= "<input name=\"category\" value=\"".$MessCategory."\" type=\"hidden\">";
						$page .= "<input onchange=\"document.getElementById('fullreports').checked=this.checked\" id=\"fullreports2\" name=\"fullreports2\" type=\"checkbox\">".$lang['mess_partialreport']."</th>";
						$page .= "</tr><tr>";
						$page .= "<th>".$lang['mess_action']."</th>";
						$page .= "<th>".$lang['mess_class']."</th>";
						$page .= "<th>".$lang['mess_subject']."</th>";
						$page .= "<th>".$lang['mess_date']."</th>";
						$page .= "<th>".$lang['mess_from']."</th>";
						$page .= "</tr>";

						if ($MessCategory == 100) {
								$UsrMess	   = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' ORDER BY `message_time` DESC;", 'messages');
								$SubUpdateQry  = "";
								for ($MessType = 0; $MessType < 101; $MessType++) {
										if ( in_array($MessType, $MessageType) ) {
												$SubUpdateQry .= "`".$messfields[$MessType]."` = '0', ";
										}
								}
								$QryUpdateUser  = "UPDATE {{table}} SET ";
								$QryUpdateUser .= $SubUpdateQry;
								$QryUpdateUser .= "`id` = '".$user['id']."' "; // Vraiment pas envie de me casser le fion a virer la derniere virgule du sub query
								$QryUpdateUser .= "WHERE ";
								$QryUpdateUser .= "`id` = '".$user['id']."';";
								doquery ( $QryUpdateUser, 'users' );

								while ($CurMess = mysql_fetch_array($UsrMess)) {
																	if($CurMess['message_class'] == 1){$class = "Unwichtig";
									}elseif($CurMess['message_class'] == 2){$class = "Normal";
									}elseif($CurMess['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}	
										$page .= "\n<tr>";
										$page .= "<input name=\"showmes". $CurMess['message_id'] . "\" type=\"hidden\" value=\"1\">";
$page .= "<th><input name=\"delmes". $CurMess['message_id'] ."\" type=\"checkbox\"></th>";
									$page .= "<th>". $class ."</th>";
									$page .= "<th><a href=\"messages.php?mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
										if ($CurMess['message_type'] == 1) {
												$page .= "<a href=\"messages.php?mode=write&amp;id=". $CurMess['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']) ."\">";
												$page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th></tr>";
										} else {
												$page .= "</th>";
										 $page .= "</tr><tr>";
										$page .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; class=\"b\"> </td>";
										$page .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; colspan=\"4\" class=\"b\">". stripslashes( nl2br( $CurMess['message_text'] ) ) ."</td>";
										$page .= "</tr>";
										}

								}
						} else {
								$UsrMess	   = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC;", 'messages');
								if($_GET['mode'] == 'show'){
								$QryUpdateUser  = "UPDATE {{table}} SET ";
								$QryUpdateUser .= "`".$messfields[$MessCategory]."` = '0', ";
								$QryUpdateUser .= "`".$messfields[100]."` = `".$messfields[100]."` - '".$WaitingMess[$MessCategory]."' ";
								$QryUpdateUser .= "WHERE ";
								$QryUpdateUser .= "`id` = '".$user['id']."';";
								doquery ( $QryUpdateUser, 'users' );}
								while ($CurMess = mysql_fetch_array($UsrMess)) {
																	if($CurMess['message_class'] == 1){$class = "Unwichtig";
									}elseif($CurMess['message_class'] == 2){$class = "Normal";
									}elseif($CurMess['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}	
										if ($CurMess['message_type'] == $MessCategory) {
												$page .= "\n<tr>";
												$page .= "<input name=\"showmes". $CurMess['message_id'] . "\" type=\"hidden\" value=\"1\">";
$page .= "<th><input name=\"delmes". $CurMess['message_id'] ."\" type=\"checkbox\"></th>";
									$page .= "<th>". $class ."</th>";
									$page .= "<th><a href=\"messages.php?mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
												if ($CurMess['message_type'] == 1) {
														$page .= "<a href=\"messages.php?mode=write&amp;id=". $CurMess['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']) ."\">";
														$page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th></tr>";
												} else {
														$page .= "</th>";
																										$page .= "</tr><tr>";
												$page .= "<td class=\"b\"> </td>";
												$page .= "<td colspan=\"4\" class=\"b\">". nl2br( stripslashes( $CurMess['message_text'] ) ) ."</td>";
												$page .= "</tr>";
												}

										}
								}
						}


						$page .= "<tr>";
						$page .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"5\">";
						$page .= "<input onchange=\"document.getElementById('fullreports2').checked=this.checked\" id=\"fullreports\" name=\"fullreports\" type=\"checkbox\">".$lang['mess_partialreport']."</th>";
						$page .= "</tr><tr>";
						$page .= "<th colspan=\"5\">";
						$page .= "<select onchange=\"document.getElementById('deletemessages2').options[this.selectedIndex].selected='true'\" id=\"deletemessages\" name=\"deletemessages\">";
						$page .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
						$page .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
						$page .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
						$page .= "</select>";
						$page .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
						$page .= "</th>";
						$page .= "</tr><tr>";
						$page .= "<td colspan=\"5\"></td>";
						$page .= "</tr>";
						$page .= "</table>\n";
						$page .= "</td>";
						$page .= "</tr>";
						$page .= "</table>\n";
						$page .= "</form>";
						$page .= "</td>";
						$page .= "</table>\n";
						$page .= "</center>";
						break;

				case 'read':
				if($_GET['del'] == 'ja'){
				if($query['message_owner'] == $user['id']){
						  $MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $_GET['ms'] ."' AND `message_owner` = '". $user['id'] ."';", 'messages');
								if ($MessHere) {
														doquery("DELETE FROM {{table}} WHERE `message_id` = '". $_GET['ms'] ."';", 'messages');
														message("Erfolgreich gel&ouml;scht", "Erfolgreich");
												}
				}
									}else{
						$query	   = doquery("SELECT * FROM {{table}}messages WHERE `message_id` = '{$_GET['ms']}';", '', true);
									if($query['message_class'] == 1){$class = "Unwichtig";
									}elseif($query['message_class'] == 2){$class = "Normal";
									}elseif($query['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}
						if($query['message_sender'] == $user['id'] or $query['message_owner'] == $user['id']){
						$page  = "<table width=\"569\">";
						$page .= "<tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $query['message_subject'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $lang['mess_class'] ."</th>";
						if($query['message_owner'] == $user['id']){
						$page .= "		<th>". $lang['mess_from'] ."</th>";
						}else{$page .= "		<th>". $lang['mess_to'] ."</th>";}
						$page .= "		<th>". $lang['mess_date'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $class ."</th>";
						if($query['message_owner'] == $user['id']){
						$page .= "		<th>". $query['message_from'] ." ";
					if ($query['message_type'] == 1) {
						$page .= "<a href=\"messages.php?mode=write&amp;id=". $query['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $query['message_subject']) ."\">";
						$page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";
					} else {
						$page .= "</th>";
					}
					}else{	$query2	   = doquery("SELECT * FROM {{table}}users WHERE `id` = '{$query['message_owner']}';", '', true);
					$page .= "<th>". $query2['username'] ."";
					$page .= "<a href=\"messages.php?mode=write&amp;id=". $query['message_owner'] ."&amp;subject=". htmlspecialchars( $query['message_subject']) ."\">";
					$page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";}
					
						$page .= "		<th>". date("m-d H:i:s", $query['message_time']) ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['mess_typ'] ."</th>";
						$page .= "		<th>". $lang['mess_action'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['typ'][$query['message_type']] ."</th>";
						if($query['message_owner'] == $user['id']){
						$page .= "		<th><a href=\"messages.php?mode=read&ms={$_GET['ms']}&del=ja\">". $lang['mess_delete'] ."</a></th>";
						}else{
						$page .= "		<th>---</th>";
						}
						$page .= "</tr><tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $lang['nachricht_lesen'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\" height=\"200\">". $query['message_text'] ."</th>";
						$page .= "</tr><tr>";
						if($query['message_owner'] == $user['id']){
						$page .= "<th colspan=\"3\"><form action=\"messages.php\" method=\"post\">
								<input name=\"meldentyp\" type=\"hidden\" value=\"melden\" />
								<input name=\"meldenid\" type=\"hidden\" value=\"{$query['message_id']}\" />
								<input name=\"\" type=\"submit\" value=\"Melden\" /></form></th>";
						$page .= "</tr><tr>";
						}
						$page .= "		<td colspan=\"3\" class=\"c\"><a href=\"messages.php\">". $lang['mess_back'] ."</a></td>";
						$page .= "</tr></table>";
						}
						}
				break;
				case 'melden':
						if($_POST['gemeldet'] == 'gemeldet'){
						$Melden = doquery("UPDATE {{table}} SET `message_melden_grund` = '{$_POST['message_melde_grund']}',`message_melden` = '1',`message_melden_time` = '{$_POST['message_melde_time']}' WHERE `message_id` = '{$_POST['meldenid']}'", 'messages'); message('Nachricht gemeldet!','Erfolgreich!');
						}else{
						$query	   = doquery("SELECT * FROM {{table}}messages WHERE `message_id` = '{$_POST['meldenid']}';", '', true);
									if($query['message_class'] == 1){$class = "Unwichtig";
									}elseif($query['message_class'] == 2){$class = "Normal";
									}elseif($query['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}
						if($query['message_owner'] == $user['id']){
						$page  = "<table width=\"569\"><form action=\"messages.php\" method=\"post\">";
						$page .= "<tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $query['message_subject'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $lang['mess_class'] ."</th>";
						$page .= "		<th>". $lang['mess_from'] ."</th>";
						$page .= "		<th>". $lang['mess_date'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th>". $class ."</th>";
						$page .= "		<th>". $query['message_from'] ." ";
					if ($query['message_type'] == 1) {
						$page .= "<a href=\"messages.php?mode=write&amp;id=". $query['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $query['message_subject']) ."\">";
						$page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";
					} else {
						$page .= "</th>";
					}
						$page .= "		<th>". date("m-d H:i:s", $query['message_time']) ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['mess_typ'] ."</th>";
						$page .= "		<th>". $lang['mess_action'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"2\">". $lang['typ'][$query['message_type']] ."</th>";
						$page .= "		<th>NICHT L&Ouml;SCHEN</th>";
						$page .= "</tr><tr>";
						$page .= "		<td class=\"c\" colspan=\"3\">". $lang['nachricht_lesen'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\" height=\"200\">". $query['message_text'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\">". $lang['melden_grund'] ."</th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\"><textarea name=\"message_melde_grund\" widht=\"100%\" rows=\"7\">". $lang['no_delete'] ."</textarea></th>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\"><input name=\"\" type=\"submit\" value=\"Melden\" /></th>";
						$page .= "</tr><tr>";
						$page .= "<input type=\"hidden\" name=\"message_melde_time\" value=\"". (time() + 60 * 60 * 24) ."\"> ";
						$page .= "<input type=\"hidden\" name=\"gemeldet\" value=\"gemeldet\"> ";
						$page .= "<input name=\"meldentyp\" type=\"hidden\" value=\"melden\" />";
						$page .= "<input name=\"meldenid\" type=\"hidden\" value=\"{$query['message_id']}\" />";
						$page .= "		<td colspan=\"3\" class=\"c\"><a href=\"messages.php\">". $lang['mess_back'] ."</a></td>";
						$page .= "</tr></table></form>";
						}
						}
				break;
				case 'ausgang':
						$page  = "<center>";
						$page .= "<table width=\"519\">";
						$page .= "<tr>";
						$page .= "<td class=\"c\" colspan=\"3\">".$lang['postausgang']."</td>";
						$page .= "</tr>";
						$page .= "<tr>";
						$page .= "<th>".$lang['mess_to']."</th>";
						$page .= "<th>".$lang['mess_subject']."</th>";
						$page .= "<th>".$lang['mess_date']."</th>";
						$page .= "</tr>";

								$UsrMess	   = doquery("SELECT * FROM {{table}}messages WHERE `message_sender` = '{$user['id']}' ORDER BY `message_time` DESC;", '', false);

								while ($CurMess = mysql_fetch_array($UsrMess)) {
								$query2	   = doquery("SELECT * FROM {{table}}users WHERE `id` = '{$CurMess['message_owner']}';", '', true);
									$page .= "\n<tr>";
									$page .= "<th>". $query2['username'] ."</th>";
									$page .= "<th><a href=\"messages.php?mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page .= "</tr>";
								}
						$page .= "</table>\n";
						$page .= "</center>";
						break;
				default:
						$page  = "<script language=\"JavaScript\">\n";
						$page .= "function f(target_url, win_name) {\n";
						$page .= "var new_win = window.open(target_url, win_name, 'resizable=yes, scrollbars=yes, menubar=no, toolbar=no, width=550, height=280, top=0, left=0');\n";
						$page .= "new_win.focus();\n";
						$page .= "}\n";
						$page .= "</script>\n";
						$page .= "<center>";
						$page .= "<br>";
						$page .= "<table width=\"569\">";
						$page .= "<tr>";
						$page .= "		<td class=\"c\" colspan=\"5\">". $lang['title'] ."</td>";
						$page .= "</tr><tr>";
						$page .= "		<th colspan=\"3\">". $lang['head_type'] ."</th>";
						$page .= "		<th>". $lang['head_count'] ."</th>";
						$page .= "		<th>". $lang['head_total'] ."</th>";
						$page .= "</tr>";
						$page .= "<tr>";
						$page .= "		<th colspan=\"3\"><a href=\"messages.php?mode=show&amp;messcat=100\"><font color=\"". $TitleColor[100] ."\">". $lang['type'][100] ."</a></th>";
						$page .= "		<th><font color=\"". $TitleColor[100] ."\">". $WaitingMess[100] ."</font></th>";
						$page .= "		<th><font color=\"". $TitleColor[100] ."\">". $TotalMess[100] ."</font></th>";
						$page .= "</tr>";
						for ($MessType = 0; $MessType < 100; $MessType++) {
								if ( in_array($MessType, $MessageType) ) {
										$page .= "<tr>";
										$page .= "		<th colspan=\"3\"><a href=\"messages.php?mode=show&amp;messcat=". $MessType ." \"><font color=\"". $TitleColor[$MessType] ."\">". $lang['type'][$MessType] ."</a></th>";
										$page .= "		<th><font color=\"". $TitleColor[$MessType] ."\">". $WaitingMess[$MessType] ."</font></th>";
										$page .= "		<th><font color=\"". $TitleColor[$MessType] ."\">". $TotalMess[$MessType] ."</font></th>";
										$page .= "</tr>";
								}
								}
										$page .= "<tr>";
										$page .= "		<th colspan=\"5\"><a href=\"messages.php?mode=ausgang \">". $lang['postausgang'] ."</th>";
										$page .= "</tr>";
						$page .= "</table>";
						$page .= "</center>";
						break;
			    endswitch;

		display($page, $lang['mess_pagetitle']);



?>