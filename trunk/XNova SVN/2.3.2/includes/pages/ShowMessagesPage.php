<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowMessagesPage($CurrentUser)
{
	global $svn_root,$lang, $phpEx, $db, $dpath,$messfields,$displays,$users;


	if($_POST){
		switch ($_POST["action"]) {
			case "delete":
				if ($_POST["id"]) {
					$MessId = intval($_POST["id"]);
					$db->query("DELETE FROM {{table}}
						WHERE `message_id` = '" . $MessId . "'
						AND message_owner = '" . $CurrentUser["id"]."'", 'messages');
				}
				exit;
			break;
			case "deleteall":
				$MessCat = intval($_POST["messcat"]);
				
				if($MessCat != "100") $sql = "`message_type` = " . $MessCat . " AND ";
				$db->query("DELETE FROM {{table}}
					WHERE $sql message_owner = " . $CurrentUser["id"], 'messages');
				exit;
			break;
			case "show":
				$MessId = intval($_POST["id"]);
				$db->query("UPDATE {{table}} SET `message_read`='1'
					WHERE `message_id` = '".$_POST["id"]."'
					AND message_owner = '" . $CurrentUser["id"]."' ","messages");
				exit;
			break;
		}
	}
	
	$displays->assignContent('messages_new');
	
	$OwnerID       = intval($_POST['id']);

        $MessCategory  = $_GET['messcat'];
	$MessPageMode  = $_GET['mode'];

	$UsrMess       = $db->query("SELECT * FROM {{table}} WHERE `message_owner` = '" . $CurrentUser['id'] . "' ORDER BY `message_time` DESC;", 'messages');
	$UnRead        = $CurrentUser;

	$MessageType   = array (0, 1, 2, 3, 4, 5, 15, 99);
	
	foreach($MessageType as $MessType){
		$TotalMess[$MessType] = 0;
	}

	while ($CurMess = mysql_fetch_array($UsrMess)) {
		$MessType              = $CurMess['message_type'];
		if($CurMess['message_read']==1){
			$unreadMess[$MessType] += 1;
			//$unreadMess[100]       += 1;
		}
		$TotalMess[$MessType] += 1;
		//$TotalMess[100]       += 1;
	}
	foreach ($MessageType as $k => $id) {
		$displays->newBlock("message_type");
		
		$replace[type] = $id;
		
		$replace[unread] = $TotalMess[$id]-$unreadMess[$id];
		
		$replace[total] = $TotalMess[$id];
		$replace[name] = $lang['mg_type'][$id];
		
		foreach($replace as $k => $v){
			$displays->assign($k, $v);
		}
	}
	unset($replace);
	switch ($MessPageMode) {
		case 'write':
			if($_GET["actions"]=="0"){
                            if($_REQUEST['subject']){
                                    $subject = $_REQUEST['subject'];
                            }
                            $Owner   = $OwnerID;
                            $Sender  = $CurrentUser['id'];
                            $From    = $CurrentUser['username'] ." [".$CurrentUser['galaxy'].":".$CurrentUser['system'].":".$CurrentUser['planet']."]";
                            $Subject = $_POST['subject'];
                            $Message = $_POST['text'];
                            $users->SendSimpleMessage ( $Owner, $Sender, '', 1, $From, $Subject, $Message);
                            //$displays->message("Mensaje enviado");
                            //exit();
                        }
		break;
		case 'show':
			$displays->newBlock("show_message");
			$UsrMess       = $db->query("SELECT * FROM {{table}} WHERE `message_owner` = " . $CurrentUser['id'] . " AND `message_type` = " . intval($MessCategory) . " ORDER BY `message_time` DESC;", 'messages');
			while ($CurMess = @mysql_fetch_array($UsrMess)) {
				unset($replace);
				$displays->newBlock("message");
				
				$replace[id] = $CurMess['message_id'];
				if($CurMess['message_read']==0){
					$img="noread";
					$control="false";
				}else{
					$img="read";
					$control="true";
				}
				
				$replace[noread] = '<img id="idmensaje" onclick="control_mensaje(\''.$replace[id].'\','.$control.')" src="./styles/images/'.$img.'.png" width="16" height="14" border="0" />';
				$replace[mdate] = date("m-d H:i:s ", $CurMess['message_time']);
				$replace[from] = stripslashes($CurMess['message_from']);
				$replace[subject] = stripslashes($CurMess['message_subject']);
				$replace[message] = stripslashes( $CurMess['message_text']);
				
				foreach($replace as $k => $v){
					$displays->assign($k, $v);
				}
				if ($CurMess['message_type'] == 1 OR $CurMess['message_type'] == 2) {
					$displays->newBlock("answer");
					$replace[id] = $CurMess['message_sender'];
					$replace[subject] = $lang['mg_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']);
					foreach($replace as $k => $v){
						$displays->assign($k, $v);
					}
				}
			}
		break;
	}

	$displays->display("Mensajes");
	
}
?>