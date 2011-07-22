<?php
define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include_once($xgp_root . 'extension.inc.php');
include_once($xgp_root . 'common.' . $phpEx);

if(class_exists('SQLiteDatabase') or class_exists('SQLite3')){
		define('HAS_SQLITE'			  	  , true);
	}else{
		define('HAS_SQLITE'			  	  , false);
	}
	
include_once($xgp_root . 'includes/classes/class.MiniDB.'.$phpEx);
	
if(HAS_SQLITE == false){message("El servidor no soporta SQLite");}
$lang['Chat']  = 'Chat del Universo';
$lang['chat_loading']  = 'Cargando...';
$lang['chat_disc']     = 'Chat del Universo';
$lang['chat_message']  = 'Mensaje';
$lang['chat_short']    = 'Acceso directo';
$lang['chat_text']     = 'Texto';
$lang['chat_send']     = 'Enviar';
    $BodyTPL = gettemplate('chat/chat_body');
    $nick = $user['username'];
    $parse = $lang;
    if ($_GET) {
        if($_GET["chat_type"]=="ally"){
            $parse['chat_type'] = $_GET["chat_type"];
            $parse['ally_id']   = $user['ally_id'];
        }
    }
    $page = parsetemplate($BodyTPL, $parse);
	if($_GET['ajax'] == 1){
		$ChatDB = new MiniDB("chatOnline");
		if($ChatDB->Variables[$user['id']] <= (time() - (60 * 10)) and HAS_SQLITE == true){
				   $msg  = addslashes ("ALLUSERS:<span style=color:lime > ".$user['username'] . "</span> se ha conectado al chat");
				   $nick = addslashes ("BOT");
				   $chat_type = addslashes ($_GET["chat_type"]);
				   $ally_id = addslashes ($_GET["ally_id"]);
					if($chat_type=="ally" && $ally_id>""){
						$query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','".$ally_id."','".$msg."', '".time()."')", "chat");
					}else{
						$query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','0', '".$msg."', '".time()."')", "chat");
					}
				
		}
		$ChatDB->Variables[$user['id']] = time();
		$ChatDB->Variables[$user['id']."_name"] = $user['username'];
		$ChatDB->Variables[$user['id']."_avatar"] = $user['avatar'];
		$ChatDB->Close();
		$table = "";
		$table .= '<tr><th width="20"><img src="favicon.ico" width="20" height="20"/></th><th>BOT</th></tr>';
		if(HAS_SQLITE == false){
			$table .= '<tr><th colspan="2">No soportado</th></tr>';
		}
		foreach($ChatDB->Variables as $ID => $Time){
			if(is_numeric($ID) and $Time >= (time() - (60 * 10))/* and $ID != $user['id']*/){
				$table .= '<tr><th width="20"><img src="'.$ChatDB->Variables[$ID."_avatar"] .'" width="20" height="20"/></th><th>'.$ChatDB->Variables[$ID."_name"] .'</th></tr>';
			}
		}
		die($table);
	}
	
    display($page, false, false, false, false);

?>
