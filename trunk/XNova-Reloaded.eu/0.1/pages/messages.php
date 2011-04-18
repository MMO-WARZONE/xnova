<?php

/**
 * messages.php
 *
 * @version 2.0
 * @copyright 2008 by Chlorel for XNova (-1.2)
 * @copyright 2008 by Mwieners for Xnova-Germany (2.0)
 * neues Design by Steggi for Xnova-reloaded.de
 */

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

		$UsrMess = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_owner` = '".$user['id']."' ORDER BY `message_time` DESC");

		$UNQuery  = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '".$user['id']."'");
		$UnRead   = $UNQuery->fetch();

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

		while ($CurMess = $UsrMess->fetch()) {
				$MessType			  = $CurMess['message_type'];
				$TotalMess[$MessType] += 1;
				$TotalMess[100]	   += 1;
		}

		switch ($MessPageMode):
				case 'write':
				define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
					// -------------------------------------------------------------------------------------------------------
					// NACHRICHT SCHREIBEN
					if ( !is_numeric( $OwnerID ) ) {
						message ($lang['mess_no_ownerid'], $lang['mess_error']);
					}
		
					$OWnerRecord  = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '".$OwnerID."'");
					$OwnerRecord  = $OWnerRecord->fetch();
		
					if (!$OwnerRecord) {
						message ($lang['mess_no_owner']  , $lang['mess_error']);
					}
		
					$OWnerHome  = $DB->query("SELECT * FROM ".PREFIX."galaxy WHERE `id_planet` = '". $OwnerRecord["id_planet"] ."'");
					$OwnerHome  = $OWnerHome->fetch();
					
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
							print '<script>self.close();</script>';
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
		
					$write				 .= parsetemplate(gettemplate('messages_pm_form'), $parse);
					display($write, $lang['mess_pagetitle'], false);
						break;

				case 'delete':
						// -------------------------------------------------------------------------------------------------------
						// Suppression des messages selectionnés
						define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
						$DeleteWhat = $_POST['deletemessages'];
						if	   ($DeleteWhat == 'deleteall') {
								$DB->query("DELETE FROM ".PREFIX."messages WHERE `message_owner` = '". $user['id'] ."'");

								
								
								
						} elseif ($DeleteWhat == 'deletemarked') {
								foreach($_POST as $Message => $Answer) {
										if (preg_match("/delmes/i", $Message) && $Answer == 'on') {
												$MessId   = str_replace("delmes", "", $Message);
												$MessHere = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."'");

									
												if ($MessHere) {
														$DB->query("DELETE FROM ".PREFIX."messages WHERE `message_id` = '". $MessId ."'");

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
												$MessHere = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."'");
												
												if ($MessHere) {
														doquery("DELETE FROM {{table}} WHERE `message_id` = '".$MessId."';", 'messages');
														$DB->query("DELETE FROM ".PREFIX."messages WHERE `message_id` = '". $MessId ."'");

												}
										}
								}
						}
						$MessCategory = $_POST['category'];

				case 'show':
						// -------------------------------------------------------------------------------------------------------
						// NACHRICHTEN ANZEIGEN
						define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
						$page1  = "<script language=\"JavaScript\">\n";
						$page1 .= "function f(target_url, win_name) {\n";
						$page1 .= "var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');\n";
						$page1 .= "new_win.focus();\n";
						$page1 .= "}\n";
						$page1 .= "</script>\n";
						$page1 .= "<center>";
						$page1 .= "<table>";
						$page1 .= "<tr>";
						$page1 .= "<td></td>";
						$page1 .= "<td>\n";
						$page1 .= "<table width=\"800\">";
						$page1 .= "<form action=\"?action=internalMessages\" method=\"post\"><table>";
						$page1 .= "<tr>";
						$page1 .= "<td></td>";
						$page1 .= "<td>\n<input name=\"messages\" value=\"1\" type=\"hidden\">";
						$page1 .= "<table width=\"800\">";
						$page1 .= "<tr>";
						$page1 .= "<th colspan=\"5\">";
						$page1 .= "<select onchange=\"document.getElementById('deletemessages').options[this.selectedIndex].selected='true'\" id=\"deletemessages2\" name=\"deletemessages2\">";
						$page1 .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
						$page1 .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
						$page1 .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
						$page1 .= "</select>";
						$page1 .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
						$page1 .= "</th>";
						$page1 .= "</tr><tr>";
						$page1 .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"5\">";
						$page1 .= "<input name=\"category\" value=\"".$MessCategory."\" type=\"hidden\">";
						$page1 .= "<input onchange=\"document.getElementById('fullreports').checked=this.checked\" id=\"fullreports2\" name=\"fullreports2\" type=\"checkbox\">".$lang['mess_partialreport']."</th>";
						$page1 .= "</tr><tr>";
						$page1 .= "<th>".$lang['mess_action']."</th>";
						$page1 .= "<th>".$lang['mess_class']."</th>";
						$page1 .= "<th>".$lang['mess_subject']."</th>";
						$page1 .= "<th>".$lang['mess_date']."</th>";
						$page1 .= "<th>".$lang['mess_from']."</th>";
						$page1 .= "</tr>";

						if ($MessCategory == 100) {
								$UsrMess = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_owner` = '".$user['id']."' ORDER BY `message_time` DESC");

								$SubUpdateQry  = "";
								for ($MessType = 0; $MessType < 101; $MessType++) {
										if ( in_array($MessType, $MessageType) ) {
												$SubUpdateQry .= "`".$messfields[$MessType]."` = '0', ";
										}
								}
								$DB->query("UPDATE ".PREFIX."users SET $SubUpdateQry `id` = '".$user['id']."' WHERE `id` = '".$user['id']."'");

								while ($CurMess = $UsrMess->fetch()) {
																	if($CurMess['message_class'] == 1){$class = "Unwichtig";
									}elseif($CurMess['message_class'] == 2){$class = "Normal";
									}elseif($CurMess['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}	
										$page1 .= "\n<tr>";
										$page1 .= "<input name=\"showmes". $CurMess['message_id'] . "\" type=\"hidden\" value=\"1\">";
$page1 .= "<th><input name=\"delmes". $CurMess['message_id'] ."\" type=\"checkbox\"></th>";
									$page1 .= "<th>". $class ."</th>";
									$page1 .= "<th><a href=\"#\" onClick=\"Ajax('?action=internalMessages&amp;mode=read&ms=". $CurMess['message_id'] ."');\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page1 .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page1 .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
										if ($CurMess['message_type'] == 1) {
												$page1 .= "<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=". $CurMess['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']) ."', '');\">";
												$page1 .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th></tr>";
										} else {
												$page1 .= "</th>";
										 $page1 .= "</tr><tr>";
										$page1 .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; class=\"b\"> </td>";
										$page1 .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; colspan=\"4\" class=\"b\">". stripslashes( nl2br( $CurMess['message_text'] ) ) ."</td>";
										$page1 .= "</tr>";
										}

								}
						} else {
								
								$UsrMess = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC");
								if($_GET['mode'] == 'show'){
								$DB->query("UPDATE ".PREFIX."users SET `".$messfields[$MessCategory]."` = '0', `".$messfields[100]."` = `".$messfields[100]."` - '".$WaitingMess[$MessCategory]."' WHERE `id` = '".$user['id']."'");
								}
								
								while ($CurMess = $UsrMess->fetch()) {
																	if($CurMess['message_class'] == 1){$class = "Unwichtig";
									}elseif($CurMess['message_class'] == 2){$class = "Normal";
									}elseif($CurMess['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}	
										if ($CurMess['message_type'] == $MessCategory) {
												$page1 .= "\n<tr>";
												$page1 .= "<input name=\"showmes". $CurMess['message_id'] . "\" type=\"hidden\" value=\"1\">";
$page1 .= "<th><input name=\"delmes". $CurMess['message_id'] ."\" type=\"checkbox\"></th>";
									$page1 .= "<th>". $class ."</th>";
									$page1 .= "<th><a href=\"#\" onClick=\"Ajax('?action=internalMessages&amp;mode=read&ms=". $CurMess['message_id'] ."');\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$page1 .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$page1 .= "<th>". stripslashes( $CurMess['message_from'] ) ."";
												if ($CurMess['message_type'] == 1) {
														$page1 .= "<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=". $CurMess['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']) ."', '');\">";
														$page1 .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th></tr>";
												} else {
														$page1 .= "</th>";
																										$page1 .= "</tr><tr>";
												$page1 .= "<td class=\"b\"> </td>";
												$page1 .= "<td colspan=\"4\" class=\"b\">". nl2br( stripslashes( $CurMess['message_text'] ) ) ."</td>";
												$page1 .= "</tr>";
												}

										}
								}
						}


						$page1 .= "<tr>";
						$page1 .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"5\">";
						$page1 .= "<input onchange=\"document.getElementById('fullreports2').checked=this.checked\" id=\"fullreports\" name=\"fullreports\" type=\"checkbox\">".$lang['mess_partialreport']."</th>";
						$page1 .= "</tr><tr>";
						$page1 .= "<th colspan=\"5\">";
						$page1 .= "<select onchange=\"document.getElementById('deletemessages2').options[this.selectedIndex].selected='true'\" id=\"deletemessages\" name=\"deletemessages\">";
						$page1 .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
						$page1 .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
						$page1 .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
						$page1 .= "</select>";
						$page1 .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
						$page1 .= "</th>";
						$page1 .= "</tr><tr>";
						$page1 .= "<td colspan=\"5\"></td>";
						$page1 .= "</tr>";
						$page1 .= "</table>\n";
						$page1 .= "</td>";
						$page1 .= "</tr>";
						$page1 .= "</table>\n";
						$page1 .= "</form>";
						$page1 .= "</td>";
						$page1 .= "</table>\n";
						$page1 .= "</center>";
						display($page1, $lang['mess_pagetitle'], false);
						break;

				case 'read':
				define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
				if($_GET['del'] == 'ja'){
				if($query['message_owner'] == $user['id']){
							$MessHere  = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_id` = '". intval($_GET['ms']) ."' AND `message_owner` = '". $user['id'] ."'");
					
								if ($MessHere) {
														$DB->query("DELETE FROM ".PREFIX."messages WHERE `message_id` = '". intval($_GET['ms']) ."'");
														message("Erfolgreich gel&ouml;scht", "Erfolgreich");
												}
				}
									}else{
						$Query = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_id` = '". intval($_GET['ms']) ."'");
						$query = $Query->fetch();
									if($query['message_class'] == 1){$class = "Unwichtig";
									}elseif($query['message_class'] == 2){$class = "Normal";
									}elseif($query['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}
						if($query['message_sender'] == $user['id'] or $query['message_owner'] == $user['id']){
						$read  = "<table width=\"800\">";
						$read .= "<tr>";
						$read .= "		<td class=\"c\" colspan=\"3\">". $query['message_subject'] ."</td>";
						$read .= "</tr><tr>";
						$read .= "		<th>". $lang['mess_class'] ."</th>";
						if($query['message_owner'] == $user['id']){
						$read .= "		<th>". $lang['mess_from'] ."</th>";
						}else{$read .= "		<th>". $lang['mess_to'] ."</th>";}
						$read .= "		<th>". $lang['mess_date'] ."</th>";
						$read .= "</tr><tr>";
						$read .= "		<th>". $class ."</th>";
						if($query['message_owner'] == $user['id']){
						$read .= "		<th>". $query['message_from'] ." ";
					if ($query['message_type'] == 1) {
						$read .= "
						<a href=\"#\" onClick=\"f('?action=internalMessages&amp;mode=write&amp;id=". $query['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $query['message_subject']) ."', '');\">";
						$read .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";
					} else {
						$read .= "</th>";
					}
					}else{	
					$Query2 = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '{$query['message_owner']}'");

					$query2 = $Query2->fetch();
					$read .= "<th>". $query2['username'] ."";
					$read .= "<a href=\"?action=internalMessages&amp;mode=write&amp;id=". $query['message_owner'] ."&amp;subject=". htmlspecialchars( $query['message_subject']) ."\">";
					$read .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";}
					
						$read .= "		<th>". date("m-d H:i:s", $query['message_time']) ."</th>";
						$read .= "</tr><tr>";
						$read .= "		<th colspan=\"2\">". $lang['mess_typ'] ."</th>";
						$read .= "		<th>". $lang['mess_action'] ."</th>";
						$read .= "</tr><tr>";
						$read .= "		<th colspan=\"2\">". $lang['typ'][$query['message_type']] ."</th>";
						if($query['message_owner'] == $user['id']){
						$read .= "		<th><a href=\"?action=internalMessages&amp;mode=read&ms={$_GET['ms']}&del=ja\">". $lang['mess_delete'] ."</a></th>";
						}else{
						$read .= "		<th>---</th>";
						}
						$read .= "</tr><tr>";
						$read .= "		<td class=\"c\" colspan=\"3\">". $lang['nachricht_lesen'] ."</td>";
						$read .= "</tr><tr>";
						$read .= "		<th colspan=\"3\" height=\"200\">". $query['message_text'] ."</th>";
						$read .= "</tr><tr>";
						if($query['message_owner'] == $user['id']){
						$read .= "<th colspan=\"3\"><form action=\"?action=internalMessages\" method=\"post\">
								<input name=\"meldentyp\" type=\"hidden\" value=\"melden\" />
								<input name=\"meldenid\" type=\"hidden\" value=\"{$query['message_id']}\" />
								<input name=\"\" type=\"submit\" value=\"Melden\" /></form></th>";
						$read .= "</tr><tr>";
						}
						$read .= "		<td colspan=\"3\" class=\"c\"><a href=\"?action=internalMessages&amp;\">". $lang['mess_back'] ."</a></td>";
						$read .= "</tr></table>";
						}
						}
						display($read, $lang['mess_pagetitle'], false);
				break;
				case 'melden':
				define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
						if($_POST['gemeldet'] == 'gemeldet'){
						$Melden = $DB->query("UPDATE ".PREFIX."messages SET `message_melden_grund` = '{$_POST['message_melde_grund']}',`message_melden` = '1',`message_melden_time` = '{$_POST['message_melde_time']}' WHERE `message_id` = '{$_POST['meldenid']}'");
						 message('Nachricht gemeldet!','Erfolgreich!');
						}else{
						$Query = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_id` = '{$_POST['meldenid']}'");
						$query = $Query->fetch();
									if($query['message_class'] == 1){$class = "Unwichtig";
									}elseif($query['message_class'] == 2){$class = "Normal";
									}elseif($query['message_class'] == 3){$class = "<blink><font color=\"red\">Wichtig</blink></font>";
									}else{$class = "Normal";}
						if($query['message_owner'] == $user['id']){
						$page  = "<table width=\"800\"><form action=\"?action=internalMessages\" method=\"post\">";
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
						$page .= "<a href=\"?action=internalMessages&amp;mode=write&amp;id=". $query['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $query['message_subject']) ."\">";
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
						$page .= "		<td colspan=\"3\" class=\"c\"><a href=\"?action=internalMessages\">". $lang['mess_back'] ."</a></td>";
						$page .= "</tr></table></form>";
						}
						}
				break;
				case 'ausgang':
				define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!
						$ausgang  = "<center>";
						$ausgang .= "<table width=\"800\">";
						$ausgang .= "<tr>";
						$ausgang .= "<td class=\"c\" colspan=\"3\">".$lang['postausgang']."</td>";
						$ausgang .= "</tr>";
						$ausgang .= "<tr>";
						$ausgang .= "<th>".$lang['mess_to']."</th>";
						$ausgang .= "<th>".$lang['mess_subject']."</th>";
						$ausgang .= "<th>".$lang['mess_date']."</th>";
						$ausgang .= "</tr>";
								$UsrMess = $DB->query("SELECT * FROM ".PREFIX."messages WHERE `message_sender` = '{$user['id']}' ORDER BY `message_time` DESC");
								
								while ($CurMess = $UsrMess->fetch()) {
								$QUERY2 = $DB->query("SELECT * FROM ".PREFIX."users WHERE `id` = '{$CurMess['message_owner']}'");
								$query2	= $QUERY2->fetch();
									$ausgang .= "\n<tr>";
									$ausgang .= "<th>". $query2['username'] ."</th>";
									$ausgang .= "<th><a href=\"?action=internalMessages&amp;mode=read&ms=". $CurMess['message_id'] ."\">". stripslashes( $CurMess['message_subject'] ) ."</a> ";
									$ausgang .= "<th>". date("m-d H:i:s", $CurMess['message_time']) ."</th>";
									$ausgang .= "</tr>";
								}
						$ausgang .= "</table>\n";
						$ausgang .= "</center>";
						display($ausgang, $lang['mess_pagetitle'], false);
						break;
				default:
						//Script zum schreiben von Nachrichten
						
						//Script zum Nachladen der einzelnen Nachrichten Kategorien
						$page .= "<script type=\"text/JavaScript\">";
						$page .= "function Ajax(datei) {";
						$page .= "var xhReq = new XMLHttpRequest();";
						$page .= "xhReq.open(\"GET\", datei, false);";
						$page .= "xhReq.send(null);";
						$page .= "var serverResponse = xhReq.responseText;";
						$page .= "document.getElementById(\"content\").innerHTML = serverResponse;";
						$page .= "}";
						$page .= "</script>";
						$page .= "<center>";
						$page .= "<br>";
						$page .= "<table width=\"800\">";
						$page .= "<tr>";
						$page .= "		<td class=\"c\" colspan=\"10\">". $lang['title'] ."</td>";
						$page .= "</tr>";
						$page .= "<tr>";
						
						for ($MessType = 0; $MessType <= 100; $MessType++) 
							{
								if ( in_array($MessType, $MessageType) ) 
									{
										$page .= "<th><a href=\"#\" onClick=\"Ajax('?action=internalMessages&amp;mode=show&amp;messcat=". $MessType ."');\">";
										$page .= "<font color=\"". $TitleColor[$MessType] ."\">". $lang['type'][$MessType] ."</font></a></th>";
									}
							}
						$page .= " <th>
						<a href=\"#\" onClick=\"Ajax('?action=internalMessages&amp;mode=ausgang');\">". $lang['postausgang'] ."</a></th>";
						$page .= "</tr>";
						$page .= "<tr>";
						for ($MessType = 0; $MessType <= 100; $MessType++) 
							{
								if ( in_array($MessType, $MessageType) ) 
									{
										$page .= "		<th><font color=\"". $TitleColor[$MessType] ."\">". $WaitingMess[$MessType] ."/". $TotalMess[$MessType] ."</font></th>";
									}
							}				
						$page .= "<th>&nbsp;</th>";
						$page .= "</tr>";
						$page .= "</table>";
						$page .= "<div id=\"content\"></div>";
						$page .= "</center>";
						break;
			    endswitch;

		display($page, $lang['mess_pagetitle']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Mise a plat, linearisation, suppression des doublons / triplons / 'n'gnions dans le code (Chlorel)
// 1.2 - Regroupage des 2 fichiers vers 1 seul plus simple a mettre en oeuvre et a gerer !
// 2.0 - Postausgang, Meldefunktion, lesen, Wichtigkeitseinstellung und mehr eingebaut! Datei ein bisschen geordnet! (Mwieners)

?>