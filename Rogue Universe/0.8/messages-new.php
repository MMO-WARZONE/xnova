<?php

/**
 * messages.php
 *
 * @version 1.1
 * @copyright 2008 by Pada for XNova.project.es
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('messages');

	if($_POST){
		switch ($_POST[action]) {
			case "delete":
				if (is_numeric($_POST[id])) {
					$MessId = intval($_POST[id]);
					doquery("DELETE FROM {{table}} WHERE `message_id` = " . $MessId . " AND message_owner = " . $user[id], 'messages');
				}
				exit;
			break;
		}
	}
	
	if($_GET){
		switch ($_GET[action]) {
			case "deleteall":
				$MessCat = intval($_GET[messcat]);
				
				if($MessCat != "100") $sql = "`message_type` = " . $MessCat . " AND ";
				doquery("DELETE FROM {{table}} WHERE $sql message_owner = " . $user[id], 'messages');
				header("Location: " . $_SERVER['PHP_SELF'] . "?messcat=" . $MessCat);
				exit;
			break;
		}
	}

	// ADD SMILIES ARRAY
	makeSmiliesArray();
	
	$tp = new TemplatePower($ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . "/messages.tpl" );
	$tp->prepare();
	
	$OwnerID       = $_GET['id'];
	$MessCategory  = (isset($_GET['messcat'])) ? $_GET['messcat'] : '100';
	$MessPageMode  = (isset($_GET['mode'])) ? $_GET['mode'] : 'show';

	$UsrMess       = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `message_owner` = " . $user['id'] . " ORDER BY `message_time` DESC;", 'messages');
	$UnRead        = $user;

	$MessageType   = array ( 100, 0, 1, 2, 3, 4, 5, 15, 99);
	$TitleColor    = array ( 0 => '#FFFF00', 1 => '#FFFF00', 2 => '#FFFF00', 3 => '#FFFF00', 4 => '#FFFF00', 5 => '#FFFF00', 15 => '#FFFF00', 99 => '#FFFF00', 100 => '#FFFF00'  );
	$BackGndColor  = array ( 0 => '#663366', 1 => '#663366', 2 => '#663366', 3 => '#663366', 4 => '#663366', 5 => '#663366', 15 => '#663366', 99 => '#663366', 100 => '#663366'  );

	for ($MessType = 0; $MessType < 101; $MessType++) {
		if ( in_array($MessType, $MessageType) ) {
			$WaitingMess[$MessType] = $UnRead[$messfields[$MessType]];
			$TotalMess[$MessType] = 0;
		}
	}

	while ($CurMess = mysql_fetch_array($UsrMess)) {
		$MessType              = $CurMess['message_type'];
		$TotalMess[$MessType] += 1;
		$TotalMess[100]       += 1;
	}
	
	foreach ($MessageType as $k => $id) {
		$tp->newBlock("message_type");
		
		$replace[type] = $id;
		$replace[unread] = $WaitingMess[$id];
		$replace[total] = $TotalMess[$id];
		$replace[name] = $lang['type'][$id];
		
		foreach($replace as $k => $v){
			$tp->assign($k, $v);
		}
	}

	switch ($MessPageMode) {
		case 'write':
			
			if($_REQUEST['subject']){
				$subject = $_REQUEST['subject'];
			}
			
			if ( !is_numeric( $OwnerID ) ) {
				message ($lang['mess_no_ownerid'], $lang['mess_error']);
			}

			$OwnerRecord = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `id` = " . mysql_escape_string($OwnerID), 'users', true);

			if (!$OwnerRecord) {
				message ($lang['mess_no_owner'], $lang['mess_error']);
			}

			$OwnerHome   = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `id_planet` = " . mysql_escape_string($OwnerRecord["id_planet"]), 'galaxy', true);
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
					$From    = $user['username'] ." [".$user['galaxy'].":".$user['system'].":".$user['planet']."]";
					$Subject = $_POST['subject'];
					$Message = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );
					SendSimpleMessage ( $Owner, $Sender, '', 1, $From, $Subject, $Message);
					$subject = "";
					$text    = "";
				}
			}
			
			$parse['smilies_list'] = getSmilies();
			$parse['Send_message'] = $lang['mess_pagetitle'];
			$parse['Recipient']    = $lang['mess_recipient'];
			$parse['Subject']      = $lang['mess_subject'];
			$parse['Message']      = $lang['mess_message'];
			$parse['characters']   = $lang['mess_characters'];
			$parse['Envoyer']      = $lang['mess_envoyer'];

			$parse['id']           = $OwnerID;
			$parse['to']           = $OwnerRecord['username'] ." [".$OwnerHome['galaxy'].":".$OwnerHome['system'].":".$OwnerHome['planet']."]";
			$parse['subject']      = (!isset($subject)) ? $lang['mess_no_subject'] : $subject ;
			$parse['text']         = $text;

			$page                 .= parsetemplate(gettemplate('messages_pm_form'), $parse);
			break;
		
		default:
		case 'show':

			if ($MessCategory == 100) {
				$UsrMess       = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `message_owner` = " . $user['id'] . " ORDER BY `message_time` DESC;", 'messages');
				$SubUpdateQry  = "";
				foreach ($MessageType as $k => $MessType) {
					$SubUpdateQry .= "`".$messfields[$MessType]."` = 0, ";
				}
				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= $SubUpdateQry;
				$QryUpdateUser .= "`id` = " . $user['id'];
				$QryUpdateUser .= " WHERE ";
				$QryUpdateUser .= "`id` = " . $user['id'];
				doquery ( $QryUpdateUser, 'users' );				
			} else {
				$UsrMess       = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `message_owner` = " . $user['id'] . " AND `message_type` = " . intval($MessCategory) . " ORDER BY `message_time` DESC;", 'messages');
				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`".$messfields[$MessCategory]."` = 0, ";
				$QryUpdateUser .= "`".$messfields[100]."` = `".$messfields[100]."` - ".$WaitingMess[$MessCategory];
				$QryUpdateUser .= " WHERE ";
				$QryUpdateUser .= "`id` = " . $user['id'];
				doquery ( $QryUpdateUser, 'users' );
			}
			
			while ($CurMess = @mysql_fetch_array($UsrMess)) {
				unset($replace);
				$tp->newBlock("message");
				
				$replace[id] = $CurMess['message_id'];
				$replace[mdate] = date("m-d H:i:s O", $CurMess['message_time']);
				$replace[from] = stripslashes($CurMess['message_from']);
				$replace[subject] = stripslashes($CurMess['message_subject']);
				$replace[message] = makeMessageSmilies(nl2br( stripslashes( $CurMess['message_text'] ) ));

				foreach($replace as $k => $v){
					$tp->assign($k, $v);
				}
				
				if ($CurMess['message_type'] == 1 OR $CurMess['message_type'] == 2) {
					unset($replace);
					
					$tp->newBlock("answer");
					$replace[id] = $CurMess['message_sender'];
					$replace[subject] = $lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']);
					foreach($replace as $k => $v){
						$tp->assign($k, $v);
					}
				}
			}

			break;
	}
	
	$tp->gotoBlock("_ROOT");
	$tp->assignGlobal("PHPSELF", $_SERVER['PHP_SELF']);
	
	foreach($lang as $name => $trans){
		$tp->assignGlobal("lang_" . $name, $trans);
	}
	
	$page .= $tp->getOutputContent();
	
	display($page, $lang['mess_pagetitle']);


// TODO
/*
- When answering an PM, theres no need to sent the "user_id", just the username (security i think)
- Adding an Ajax Queue for message deleting
- Make some message an "Alliance Circular PM" (button). Only if user has rights and other stuff.
*/

// FIXES
/*
- Fixed the "popup" combat & spionage messages link (javascript function)

*/
?>