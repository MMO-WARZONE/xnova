<?php

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowMessagesPage($CurrentUser)
{
    global $xgp_root, $phpEx, $game_config, $dpath, $lang, $messfields, $_POST, $_GET;

    includeLang('INGAME');
    
    if($_POST){
        switch ($_POST["action"]) {
            case "delete":
                if ($_POST["id"]) {
                    $MessId = intval($_POST["id"]);
                    doquery("DELETE FROM {{table}} WHERE `message_id` = '" . $MessId . "' AND message_owner = '" . $CurrentUser["id"]."'", 'messages','');
                }
                exit;
            break;
            case "deleteall":
                $MessCat = intval($_POST["messcat"]);
                
                if($MessCat != "100") $sql = "`message_type` = " . $MessCat . " AND ";
                doquery("DELETE FROM {{table}} WHERE $sql message_owner = " . $CurrentUser["id"], 'messages');
                exit;
            break;
        }
        
    }
    
    // ADD SMILIES ARRAY
    //makeSmiliesArray();

    include_once($xgp_root . 'includes/classes/class.TemplatePower.inc.' . $phpEx);  
	$tp = new TemplatePower($xgp_root . TEMPLATE_DIR  . "messages_new.tpl" );
    $tp->prepare();
    
    $OwnerID       = $_GET['id'];
    $MessCategory  = (isset($_GET['messcat'])) ? $_GET['messcat'] : '100';
    $MessPageMode  = (isset($_GET['mode'])) ? $_GET['mode'] : 'show';
	
	$UsrMess       = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$CurrentUser['id']."' ORDER BY `message_time` DESC;", 'messages');
    $UnRead        = $CurrentUser;

    $MessageType   = array ( 100, 0, 1, 2, 3, 4, 5, 15, 99);
    $TitleColor    = array ( 0 => '#FFFF00', 1 => '#FFFF00', 2 => '#FFFF00', 3 => '#FFFF00', 4 => '#FFFF00', 5 => '#FFFF00', 15 => '#FFFF00', 99 => '#FFFF00', 100 => '#FFFF00'  );
    $BackGndColor  = array ( 0 => '#663366', 1 => '#663366', 2 => '#663366', 3 => '#663366', 4 => '#663366', 5 => '#663366', 15 => '#663366', 99 => '#663366', 100 => '#663366'  );

    
    
    foreach($MessageType as $MessType){
            $TotalMess[$MessType] = 0;
        
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
        $replace[name] = $lang['mg_type'][$id];
        
        foreach($replace as $k => $v){
            $tp->assign($k, $v);
        }
    }

    switch ($MessPageMode) {
        case 'write':
            
            if($_REQUEST['subject']){
                $subject = $_REQUEST['subject'];
            }
            
			if (!is_numeric($OwnerID))
				header("location:game.php?page=messages");

			$OwnerRecord = doquery("SELECT * FROM {{table}} WHERE `id` = '".$OwnerID."';", 'users', true);

			if (!$OwnerRecord)
				header("location:game.php?page=messages");

			$OwnerHome   = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $OwnerRecord["id_planet"] ."';", 'galaxy', true);
			if (!$OwnerHome)
				header("location:game.php?page=messages");

			if ($_POST)
			{
				$error = 0;
				$errorlist = "";
				
				if (!$_POST["subject"] & !$_POST["text"])
				{
						$errorlist .= $lang['mg_no_text_subject'];
						$error++;
				}
				
				elseif (!$_POST["subject"])
				{
						$errorlist .= $lang['mg_no_subject'];
						$error++;
				}
				
				elseif (!$_POST["text"])
				{
						$errorlist .= $lang['mg_no_text'];
						$error++;
				}
				if ($error != 0)
				{
					message ($errorlist);
				}
				else{

	
					$_POST['text'] = str_replace("'", '&#39;', $_POST['text']);
 //                  $_POST['text'] = str_replace('rn', '<br />', $_POST['text']);
				

                    $Owner   = $OwnerID;
                    $Sender  = $CurrentUser['id'];
                    $From    = $CurrentUser['username'] ." [".$CurrentUser['galaxy'].":".$CurrentUser['system'].":".$CurrentUser['planet']."]";
                    $Subject = $_POST['subject'];
                    $Message	= preg_replace ( "/([^\s]{80}?)/" , "\\1<br />" , trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) ) );
                    SendSimpleMessage ( $Owner, $Sender, '', 1, $From, $Subject, $Message);
                    $subject = "";
                    $text    = "";
					
					message ($lang['mg_msg_sended'], "game.php?page=messages", "2");
                }
				
            }
			
            $parse['id']           = $OwnerID;
            $parse['to']           = $OwnerRecord['username'] ." [".$OwnerHome['galaxy'].":".$OwnerHome['system'].":".$OwnerHome['planet']."]";
			$parse['subject']      = (!isset($subject)) ? $lang['mg_sin_subject'] : $subject ;
			$parse['text']         = $text;

            $tp->newBlock("new_message");

                $tp->assign("new_message", parsetemplate(gettemplate('messages_pm_form'), $parse));  
            break;
        
        default:
        case 'show':
        if($CurrentUser["new_message"]!=0){
            doquery("UPDATE {{table}} SET `new_message` ='0' WHERE `id` = '".$CurrentUser['id']."' ","users",'');
        }
    
            if ($MessCategory == 100) {
                $UsrMess       = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `message_owner` = " . $CurrentUser['id'] . " ORDER BY `message_time` DESC;", 'messages','');
                            
            } else {
                $UsrMess       = doquery("SELECT SQL_CACHE * FROM {{table}} WHERE `message_owner` = " . $CurrentUser['id'] . " AND `message_type` = " . intval($MessCategory) . " ORDER BY `message_time` DESC;", 'messages','');
                
            }
            
            while ($CurMess = @mysql_fetch_array($UsrMess)) {
                unset($replace);
                $tp->newBlock("message");
                
                $replace[id] = $CurMess['message_id'];
                $replace[mdate] = date("m-d H:i:s O", $CurMess['message_time']);
                $replace[from] = stripslashes($CurMess['message_from']);
                $replace[subject] = stripslashes($CurMess['message_subject']);
                //$replace[message] = makeMessageSmilies(nl2br( stripslashes( $CurMess['message_text'] ) ));
                $replace[message] = nl2br( stripslashes( $CurMess['message_text'] ) );

                foreach($replace as $k => $v){
                    $tp->assign($k, $v);
                }
                
                if ($CurMess['message_type'] == 1 OR $CurMess['message_type'] == 2) {
                    unset($replace);
                    
                    $tp->newBlock("answer");
                    $replace[id] = $CurMess['message_sender'];
                    $replace[subject] = $lang['mg_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']);
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
    
    display($page);
}
?> 