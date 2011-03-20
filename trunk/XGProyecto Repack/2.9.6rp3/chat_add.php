<?php
define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

    // On récupère les informations du message et de l'envoyeur
    if (isset($_POST["msg"]) && isset($user['username'])) {
       $msg  = addslashes ($_POST["msg"]);
       $nick = addslashes ($user['username']);
       $chat_type = addslashes ($_POST["chat_type"]);
       $ally_id = addslashes ($_POST["ally_id"]);
       $nick = addslashes ($user['username']);
	   if(strpos($msg, "BOT:") !== false and $user['authlevel'] > 0){
			$nick = "BOT";
			$msg = str_replace("BOT:", "ALLUSERS:", $msg);			
	   }
    }
    else {
       $msg="";
       $nick="";
    }
    if ($msg!="" && $nick!="") {
        if($chat_type=="ally" && $ally_id>""){
            $query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','".$ally_id."','".$msg."', '".time()."')", "chat");
        }else{
            $query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','0', '".$msg."', '".time()."')", "chat");
        }
    }
?>