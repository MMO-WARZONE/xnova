<?php
define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
include_once($xgp_root . 'includes/pages/class.ShowAlliancePage.' . $phpEx);

$lang['Chat']  = 'Chat del Universo';
$lang['chat_loading']  = 'Cargando...';
$lang['chat_disc']     = 'Chat del Universo';
$lang['chat_message']  = 'Mensaje';
$lang['chat_short']    = 'Acceso directo';
$lang['chat_text']     = 'Texto';
$lang['chat_send']     = 'Enviar';

$page_limit = 100; // Chat rows Limit
if($_GET['page']>''){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$start_row = $page * $page_limit;

if ($_GET) {
    if($_GET['chat_type']=='ally' && $_GET['ally_id'] != ''){
        if ($_GET['show']=='history') {
            if($_GET['ally_id'] != $user['ally_id']){
            message($lang['Error_1'], $lang['Error']);
            }
            showPageButtons($page,'ally');
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
        }else{
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
        }
    }else{
        if ($_GET['show']=='history') {
            showPageButtons($page,'all');
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = 0 ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
        }else{
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = 0 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
        }
    }
}else{
    if($_POST['chat_type']=='ally' && $_POST['ally_id'] != ''){
        $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_POST['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
    }else{
        $query = doquery("SELECT * FROM {{table}} WHERE ally_id = 0 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
    }
}

$buff = "";
while($v=mysql_fetch_array($query)){
    $msg = "";
    $nick=$v['user'];
    if( strpos($v['message'], "ALLUSERS:") === false and strpos($v['message'], $user['username'].":") === false and $nick != $user['username']){
		continue;
	}
	if($nick != "BOT"){
		$CurUser = doquery("SELECT `id`, `email` FROM {{table}} WHERE `username` = '".$v['user']."' LIMIT 1;", 'users', true);
		$CurUser['avatar'] = sprintf( 'http://www.gravatar.com/avatar/%s?d=%s&s=%d&r=%s', md5( $CurUser['email'] ), 'identicon', 128, 'pg' );
	}else{
		$CurUser = array("id" => 0, "avatar" => "favicon.ico");
	}
    $msgtimestamp=$v['timestamp'];
        
    $msgtimestamp=date("G:i", $msgtimestamp);
	if((strpos( $v['message'], "ALLUSERS:") === false and strpos($v['message'], $user['username'].":") !== false) or (strpos( $v['message'], "ALLUSERS:") === false and $nick == $user['username'])){
		$style = "color:grey !important;";
	}else{
		$style = "";
	}
	$v['message'] = str_replace("ALLUSERS:", "", str_replace($user['username'].":", "", $v['message'] ));
	$msg=ShowAlliancePage::bbcode($v['message'], false);
	$msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[c=(white|blue|yellow|lime|green|pink|red|orange)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);
	$msg=preg_replace("#:agr:#isU","<img src=\"images/smileys/aggressive.gif\" align=\"absmiddle\" title=\":agr:\" alt=\":agr:\">",$msg);
	$msg=preg_replace("#:angel:#isU","<img src=\"images/smileys/angel.gif\" align=\"absmiddle\" title=\":angel:\" alt=\":angel:\">",$msg);
	$msg=preg_replace("#:bad:#isU","<img src=\"images/smileys/bad.gif\" align=\"absmiddle\" title=\":bad:\" alt=\":bad:\">",$msg);
	$msg=preg_replace("#:blink:#isU","<img src=\"images/smileys/blink.gif\" align=\"absmiddle\" title=\":blink:\" alt=\":blink:\">",$msg);
	$msg=preg_replace("#:blush:#isU","<img src=\"images/smileys/blush.gif\" align=\"absmiddle\" title=\":blush:\" alt=\":blush:\">",$msg);
	$msg=preg_replace("#:bomb:#isU","<img src=\"images/smileys/bomb.gif\" align=\"absmiddle\" title=\":bomb:\" alt=\":bomb:\">",$msg);
	$msg=preg_replace("#:clap:#isU","<img src=\"images/smileys/clapping.gif\" align=\"absmiddle\" title=\":clap:\" alt=\":clap:\">",$msg);
	$msg=preg_replace("#:cool:#isU","<img src=\"images/smileys/cool.gif\" align=\"absmiddle\" title=\":cool:\" alt=\":cool:\">",$msg);
	$msg=preg_replace("#:c:#isU","<img src=\"images/smileys/cray.gif\" align=\"absmiddle\" title=\":c:\" alt=\":c:\">",$msg);
	$msg=preg_replace("#:crz:#isU","<img src=\"images/smileys/crazy.gif\" align=\"absmiddle\" title=\":crz:\" alt=\":crz:\">",$msg);
	$msg=preg_replace("#:diablo:#isU","<img src=\"images/smileys/diablo.gif\" align=\"absmiddle\" title=\":diablo:\" alt=\":diablo:\">",$msg);
	$msg=preg_replace("#:cool2:#isU","<img src=\"images/smileys/dirol.gif\" align=\"absmiddle\" title=\":cool2:\" alt=\":cool2:\">",$msg);
	$msg=preg_replace("#:fool:#isU","<img src=\"images/smileys/fool.gif\" align=\"absmiddle\" title=\":fool:\" alt=\":fool:\">",$msg);
	$msg=preg_replace("#:rose:#isU","<img src=\"images/smileys/give_rose.gif\" align=\"absmiddle\" title=\":rose:\" alt=\":rose:\">",$msg);
	$msg=preg_replace("#:good:#isU","<img src=\"images/smileys/good.gif\" align=\"absmiddle\" title=\":good:\" alt=\":good:\">",$msg);
	$msg=preg_replace("#:huh:#isU","<img src=\"images/smileys/huh.gif\" align=\"absmiddle\" title=\":huh:\" alt=\":|\">",$msg);
	$msg=preg_replace("#:D:#isU","<img src=\"images/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
	$msg=preg_replace("#:/#isU","<img src=\"images/smileys/mellow.gif\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
 	$msg=preg_replace("#:yu#isU","<img src=\"images/smileys/yu.gif\" align=\"absmiddle\" title=\":yu\" alt=\":yu\">",$msg);
	$msg=preg_replace("#:unknw:#isU","<img src=\"images/smileys/unknw.gif\" align=\"absmiddle\" title=\":unknw:\" alt=\":unknw:\">",$msg);
 	$msg=preg_replace("#:sad#isU","<img src=\"images/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
	$msg=preg_replace("#:smile#isU","<img src=\"images/smileys/smile.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg); 
	$msg=preg_replace("#:shok:#isU","<img src=\"images/smileys/shok.gif\" align=\"absmiddle\" title=\":shok:\" alt=\":shok:\">",$msg);
	$msg=preg_replace("#:rofl#isU","<img src=\"images/smileys/rofl.gif\" align=\"absmiddle\" title=\":rofl\" alt=\":rofl\">",$msg);
	$msg=preg_replace("#:eye#isU","<img src=\"images/smileys/blackeye.gif\" align=\"absmiddle\" title=\":eye\" alt=\":eye\">",$msg);
 	$msg=preg_replace("#:p#isU","<img src=\"images/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
 	$msg=preg_replace("#:wink:#isU","<img src=\"images/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg); 
	$msg=preg_replace("#:yahoo:#isU","<img src=\"images/smileys/yahoo.gif\" align=\"absmiddle\" title=\":yahoo:\" alt=\":yahoo:\">",$msg);
	$msg=preg_replace("#:tratata:#isU","<img src=\"images/smileys/mill.gif\" align=\"absmiddle\" title=\":tratata:\" alt=\":tratata:\">",$msg);
	$msg=preg_replace("#:fr#isU","<img src=\"images/smileys/friends.gif\" align=\"absmiddle\" title=\":fr\" alt=\":fr\">",$msg);
	$msg=preg_replace("#:dr#isU","<img src=\"images/smileys/drinks.gif\" align=\"absmiddle\" title=\":dr\" alt=\":dr\">",$msg);
	$msg=preg_replace("#:tease:#isU","<img src=\"images/smileys/tease.gif\" align=\"absmiddle\" title=\":tease:\" alt=\":tease:\">",$msg); 
    $msg="<div align=\"left\" style='color:white;width:570px;overflow:auto;'><span style='font:menu;'>[".$msgtimestamp."]</span> <img src='".$CurUser['avatar']."' width=14 height=14 /> <span style=$style ><a href='messages.php?mode=write&id=".$CurUser['id']."&subject=Mensaje Chat' style=$style >".$nick.":</a> ".$msg."</span><br></div>";
    $buff = $msg . $buff;
}
print $buff;

function showPageButtons($curPage,$type){
    global $page_limit,$lang;
    echo "<div style='width:100%;border:1px solid red;padding:4px;' align=center>";
    echo "<b><font size=3>".$lang['AllyChat']." / ".$lang['chat_history']."</font></b> ";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b><font size=2>".$lang['chat_page'].":</font></b> ";
    echo "<select name='page' onchange='document.location.assign(\"chat_msg.php?chat_type=".$_GET['chat_type']."&ally_id=".$_GET['ally_id']."&show=".$_GET['show']."&page=\"+this.value)'>";
    if($type=='ally'){
        $rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."'", "chat",true);
        $cnt = $rows['CNT'] / $page_limit;
        for($i = 0; $i < $cnt; ++$i) {
            if($curPage==$i){
                echo "<option value=".$i." selected>".$i."</option> ";
            }else{
                echo "<option value=".$i.">".$i."</option> ";
            }
        }
    }else{
        $rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id < 1", "chat",true);
        $cnt = $rows['CNT'] / $page_limit;
        for($i = 0; $i < $cnt; ++$i) {
            if($curPage==$i){
                echo "<option value=".$i." selected>".$i."</option> ";
            }else{
                echo "<option value=".$i.">".$i."</option> ";
            }
        }
    }
    echo "</select> ";
    echo "</div>";
}

?>
