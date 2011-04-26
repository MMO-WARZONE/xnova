<?php // forum.php ::  Foro interno del juego.Version 1.0

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

/*
  Este foro esta basado en el PHPBBs y otros que se le parecen.
  Su estructura es similar.
*/

	
{//init
	define('IN_RBO', true);
	include('common.php');
	include('cookies.php');
	$userrow = checkcookies();
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
}

function showthread($forum, $start=0) {

	global $controlrow;
	//old query
    //$query = doquery("SELECT * FROM {{table}} WHERE id='$id' OR parent='$id' ORDER BY id LIMIT $start,15", "forum");
		//$TreathCount = count(mysql_fetch_array($query));
	//new query
	$query = doquery("SELECT * FROM {{table}} WHERE topic_id=$forum ORDER BY `post_time`", "forum_posts");

	$page = "<table width=\"100%\"><tr><td colspan=2 align=right><a href=\"?new=reply&t=$forum\"><img src=\"img/reply.gif\"></a></td></tr>";
	$i=0;$u = 0;
	while ($t = mysql_fetch_array($query)) {
		
		if($i==0){$page .= "<tr><td class=c>Autor</td><td class=c>Mensaje</td></tr>"; $f=$t['forum_id'];}
		
		$p = doquery("SELECT * FROM {{table}} WHERE post_id='".$t['post_id']."' LIMIT 1", "forum_posts_text",true);
		
		/*
		  peque preparacion del texto...
		  solo hay que hacer unos cuantos remplaze, etc...
		*/
		//$p['post_text'] = str_replace(":".$p['bbcode_uid'],'',$p['post_text']);
		//$p['post_text'] = str_replace(":".$p['bbcode_uid'],'',$p['post_text']);
		/*
		$p['post_text'] = str_replace('[color=red]',"<font color=\"red\">",$p['post_text']);
		$p['post_text'] = str_replace('[color=blue]',"<font color=\"#AFCCFF\">",$p['post_text']);
		$p['post_text'] = str_replace('[color=green]',"<font color=\"green\">",$p['post_text']);
		$p['post_text'] = str_replace('[/color]',"</font>",$p['post_text']);
		$p['post_text'] = str_replace('[img]',"<img src=\"",$p['post_text']);
		$p['post_text'] = str_replace('[/img]',"\">",$p['post_text']);
		$p['post_text'] = str_replace('[i]',"<i>",$p['post_text']);
		$p['post_text'] = str_replace('[/i]',"</i>",$p['post_text']);
		$p['post_text'] = str_replace('[b]',"<b>",$p['post_text']);
		$p['post_text'] = str_replace('[/b]',"</b>",$p['post_text']);
		$p['post_text'] = str_replace('[u]',"<u>",$p['post_text']);
		$p['post_text'] = str_replace('[/u]',"</u>",$p['post_text']);
		$p['post_text'] = str_replace('[list]',"<lu><li>",$p['post_text']);
		$p['post_text'] = str_replace('[/list:u]',"</li></lu>",$p['post_text']);
		$p['post_text'] = str_replace('[url=',"<a href=",$p['post_text']);
		$p['post_text'] = str_replace('[/url]',"</a>",$p['post_text']);
		$p['post_text'] = str_replace('[quote="',"<table style=\"background-color:#4E4F05;\"><tr><td><b>",$p['post_text']);
		$p['post_text'] = str_replace('"]',"</b> dijo:<br><br>",$p['post_text']);
		$p['post_text'] = str_replace('[quote]',"<table style=\"background-color:#607295;\"><tr><td class=l>Cita: <br>",$p['post_text']);
		$p['post_text'] = str_replace('[/quote]',"</td></table>",$p['post_text']);
		$p['post_text'] = str_replace(']',">",$p['post_text']);
		$p['post_text'] = str_replace('[',"<",$p['post_text']);
		*/
		
		//Smiles!
		if($t['enable_smilies'] == 1){	$p['post_text'] = iconnize($p['post_text']);}
		if($u != $t['poster_id'] || $controlrow['flood_avatar']){
		$page .= "<tr><td class=l width=100 valign=top align=left>";
		//}elseif($i==1){$page .= "<tr><td class=l width=100 valign=top align=left>";
		}else{$page .= "<tr><td>";}
		
		if($u != $t['poster_id'] || $controlrow['flood_avatar']){
			//query
			$userquery = doquery("SELECT * FROM {{table}} WHERE id=".$t['poster_id']." LIMIT 1", "users",true);
			$avatar = "<img src=\"".$userquery['avatar']."\" width=100 class=\"avatar\">";
			//nombre de usuario
			$username = "<a href=\"search.php?searchtext=".$userquery['username']."\">".$userquery['username']."</a>";
			//para mostrar el iconito del sexo
			if($userquery['sex'] == 'M'){$username .= " <img src=\"img/male.gif\">";}
			elseif($userquery['sex'] == 'F'){$username .= " <img src=\"img/female.gif\">";}
			
			$page .= "$username<br>";
			$page .= ($userquery['avatar'] != '') ? $avatar : "";
			$page .= "<br>".date("M d Y",$userquery['register_time']);
			
		}
		
		
		
		if($i==1){$page .= "</td><td class=b valign=top align=left>";}else{$page .= "</td><td class=f valign=top align=left>";}
		
		$page .= nl2br($p['post_text'])."</td></tr>";
		
		
		if($i==1){$i=2;}else{$i=1;}
		
		//Esto es para evitar flood, se quita el avatar cuando se responde a si mismo
		$u = $t['poster_id'];
	}
	
	if($i==0){message("El tema no existe","Ver tema", 'forum.php');}
	
	//Agregamos un contador al topic_views del table_forum_topics
	doquery("UPDATE {{table}} SET `topic_views` = `topic_views`+ 1 WHERE `topic_id`=$forum;", "forum_topics");
	
	$page .= "<tr><td class=c colspan=4><a id=last href=?f=$f>Volver</a></td></tr></table>";
    display($page, "Forum",true,true,false);
    
}

function reply($topic) {

    global $userrow;

	if(!$userrow){message("Para poder responder un tema, necesitas identificarte.","Responder tema");}
	
    $topic_id = doquery("SELECT * FROM {{table}} WHERE topic_id=$topic", "forum_topics",true);
	
	if(!$topic_id){message("El tema no existe","Nuevo tema","forum.php");}
	
    if(isset($_POST["post"])) {
		extract($_POST);
		/*
		  Hacemos la comprobacion
		*/
		$postnumber = doquery("SELECT MAX(post_id) AS post_id FROM {{table}};","forum_posts_text",true);
		$post_id = $postnumber["post_id"] + 1;
		$forum_id = $topic_id['forum_id'];
		//$topicnumber = doquery("SELECT MAX(topic_id) AS topic_id FROM {{table}};","forum_topics",true);
		$topic_id = $topic;
		//Convertimos el texto para que sea seguro durante la query...
		$content = CleanStr($content);
		//este seria el texto
		doquery("INSERT INTO {{table}} SET `post_id`=$post_id, `bbcode_uid`='', `post_subject`='$title', `post_text`=\"$content\";","forum_posts_text");
		//este seria el index
		doquery("INSERT INTO {{table}} SET `post_id`=$post_id, `topic_id`=$topic_id, `forum_id`=$forum_id, `poster_id`=".$userrow['id'].", `post_time`=".time().", `poster_ip`='be5577eb', `post_username`='', `enable_bbcode`=1, `enable_html`=0, `enable_smilies`=1, `enable_sig`=1, `post_edit_count`=0;","forum_posts");
		//actualiza el topic es el topico
		doquery("UPDATE {{table}} SET `topic_time`=".time().", topic_replies=topic_replies+1, `topic_last_post_id`=$post_id WHERE `topic_id`=$topic_id;","forum_topics");
		
		message("El nuevo tema se agrego correctamente. En unos instantes seras redirigido.","Nuevo tema","forum.php?t=$topic_id#last");
    }
    $topic_title = $topic_id["topic_title"];
	
	//formulario
	form($page,$topic_title,"forum.php?new=reply&t=$topic");
	display($page, "Forum");
}

function newthread($forum_id) {

    global $userrow;
	
	if(!$userrow){message("Para poder crear un tema, necesitas identificarte.","Crear tema");}
	
    $forum_cat = doquery("SELECT * FROM {{table}} WHERE forum_id=$forum_id", "forum_cat",true);
	if(!$forum_cat){message("El foro no existe","Nuevo tema","forum.php");}
	/*
	  Formulario para crear un nuevo tema
	*/
    if(isset($_POST["post"])) {
		extract($_POST);
		/*
		  Hacemos la comprobacion
		*/
		$postnumber = doquery("SELECT MAX(post_id) AS post_id FROM {{table}};","forum_posts_text",true);
		$post_id = $postnumber["post_id"] + 1;
		$topicnumber = doquery("SELECT MAX(topic_id) AS topic_id FROM {{table}};","forum_topics",true);
		$topic_id = $topicnumber["topic_id"] + 1;
		
		//este seria el index
		doquery("INSERT INTO {{table}} SET `post_id`=$post_id, `topic_id`=$topic_id, `forum_id`=$forum_id, `poster_id`=".$userrow['id'].", `post_time`=".time().", `poster_ip`='be5577eb', `post_username`='', `enable_bbcode`=1, `enable_html`=0, `enable_smilies`=1, `enable_sig`=1, `post_edit_count`=0;","forum_posts");
		//este seria el texto
		doquery("INSERT INTO {{table}} SET `post_id`=$post_id, `bbcode_uid`='', `post_subject`='$title', `post_text`='$content';","forum_posts_text");
		//este es el topico
		doquery("INSERT INTO {{table}} SET `topic_id`=$topic_id, `forum_id`=$forum_id, `topic_title`='$title', `topic_poster`=".$userrow['id'].", `topic_time`=".time().", topic_first_post_id=$topic_id","forum_topics");
		
		doquery("UPDATE {{table}} SET forum_topics=forum_topics+1, `forum_last_post_id`=$post_id WHERE `forum_id`=$forum_id;","forum_cat");
		message("El nuevo tema se agrego correctamente. En unos instantes seras redirigido.","Nuevo tema","forum.php?f=$forum_id");
    }

	
	$page = $forum_cat["forum_name"];
	
	form($page,"Nuevo tema - ".$forum_cat['forum_name'],"forum.php?new=thread&f=$forum_id");
	display($page, "Forum");
    
}

function showtopic($forum){
	
	$query_cat = doquery("SELECT forum_name FROM {{table}} WHERE forum_id=$forum", "forum_cat",true);
	$query = doquery("SELECT * FROM {{table}} WHERE forum_id=$forum ORDER BY  `topic_type` DESC, `topic_time` DESC ", "forum_topics");
	//<a href=".PHP_SELF.">Foro</a> -> ".$query_cat['forum_name']."</th>
	$page = "<table width=\"100%\"><tr><td style=\"font-size:14px;\" colspan=5>".$query_cat['forum_name']."</td><td align=right><a href=\"?new=thread&f=$forum\"><img src=\"img/post.gif\"></a></tr>";
	
	$i = 0;
	
	while($t = mysql_fetch_array($query)){
		
		if($i == 0){$page .= "<tr><td class=\"c\" colspan=2 align=center>Temas</td><td class=c align=center>Respuestas</td><td class=c align=center>Autor</td><td class=c align=center>Lecturas</td><td class=c align=center>Ultimo Mensaje</td></tr>";}
		
		//para mostrar el ultimo post
		$query_user = doquery("SELECT username FROM {{table}} WHERE id=".$t['topic_poster'],"users",true);
			
		$lastpost = date("M d, h:m a",$t['topic_time'])."<br>";
		$lastpost .= "<a href=\"search.php?searchtext=".$query_user['username']."\">";
		$lastpost .= $query_user["username"]."</a> <a href=?t=".$t['topic_id']."#last";
		$lastpost .= " title=\"Ver 伃timo mensaje\"><img src=\"img/icon_latest_reply.gif\" alt=\">\"></a>";
		  
		$page .= "<tr><th width=20><a href=\"?t=".$t['topic_id']."\">";
		
		
		//Depende del icono
		if($t['topic_type'] == 0){
		$page .= "<img src=\"img/topicnew.gif\" title=\"Post\">";
		}elseif($t['topic_vote'] == 1){//votacion
		$page .= "<img src=\"img/vote.gif\" title=\"Votaci&oacute;n\">";
		}elseif($t['topic_type'] == 2){//anuncios!
		$page .= "<img width=25 src=\"img/anc.gif\" title=\"Anuncio\">";
		}elseif($t['topic_type'] == 1){//anuncios!
		$page .= "<img src=\"img/topichot.gif\" title=\"PostIt\">";
		}else{$page .= "<img src=\"img/topicnew.gif\" title=\"Post\">";}
		
		$page .= "</a></th><th><a href=\"?t=".$t['topic_id']."\">".$t["topic_title"]."</a></th>";
		$page .= "<th align=center>".$t['topic_replies']."</th>";
		$page .= "<th align=center><a href=\"search.php?searchtext=".$query_user['username']."\">";
		$page .= $query_user["username"]."</a></th>";
		$page .= "<th align=center>".$t['topic_views']."</th>";
		$page .= "<th align=center>$lastpost</th>";
		
		$i++;
		//$page .= "</table></td></tr>";
	}
	
	$page .= "<tr><td class=c colspan=6><a href=forum.php>Volver</a></td></tr></table></td></tr></table>";

	
    display($page, "Forum",true,true,false);
	/*
	while($t = mysql_fetch_array($query)){
		

		if($userrow["authlevel"] == 1 && $c["auth_read"] != 0 ){
		$page .= "<tr><td class=c style=\"background-color:#3F0808;\"><img src=\"img/folder.gif\"></td><td style=\"background-color:#3F0808;\"><a href=?topic=".$t['forum_id'].">".$t["topic_title"]."</a><br>";
		$page .= "".$c["forum_desc"]."</td><td style=\"background-color:#3F0808;\"t>Post: ".$t["forum_posts"]."<br>Temas: ".$t["forum_topics"]."</td></tr>";
		
		}*//*
	}
	
	$page .= "<tr><td colspan=4>[<a href=index.php>Volver</a>]</td></tr></table></td></tr></table>";

    display($page, "Forum",true,true,false);
*/

}

function showcategories(){
	
	global $userrow,$lang;

	//el title del foro y head.
	$page = "<table width=\"100%\"><tr><td class=c colspan=5>Foro interno ".$lang['TITLE_GAME']."</td></tr>";
	
	$query_cat = doquery("SELECT * FROM {{table}}", "forum_categories");
	$i = 0;
	while($c_name = mysql_fetch_array($query_cat)){
		
		if($i == 0){ $page .= "<tr><td colspan=2 class=\"c\">Foro</th><td class=\"c\">Temas</td><td class=\"c\">Mensajes</td><td class=\"c\">Ultimo Mensaje</td></tr>";}
		$page .= "<tr><th colspan=5>".$c_name["cat_title"]."</th></tr>";
		
		$query = doquery("SELECT * FROM {{table}} WHERE cat_id=".$c_name["cat_id"], "forum_cat");
		
		while($c = mysql_fetch_array($query)){
			
			
			//para mostrar el ultimo post
			if($c['forum_last_post_id'] != 0){
			  //pedimos el post
			  $query_topic = doquery("SELECT `topic_poster`,`topic_title`,`topic_time`,`topic_first_post_id` FROM {{table}} WHERE forum_id=".$c['forum_id']." ORDER BY `topic_time` DESC LIMIT 1", "forum_topics",true);
			  $query_user = doquery("SELECT username FROM {{table}} WHERE id=".$query_topic['topic_poster'],"users",true);
			  
			  
			  /*
			    Texto que va en la parte donde se dice Ultimo mensaje
			  */
			  $lastpost = "<a href=\"?t=".$query_topic['topic_first_post_id']."\" title=\"".$query_topic['topic_title']."\">";
			  $lastpost .= substr($query_topic['topic_title'],0,10)." ...</a><br>";
			  $lastpost .= date("M d, h:m a",$query_topic['topic_time']);
			  $lastpost .= "<br><a href=\"search.php?searchtext=".$query_user['username']."\">";
			  $lastpost .= $query_user["username"]."</a>";
			  $lastpost .= " <a href=?t=".$query_topic['topic_first_post_id']."#last title=\"Ver 伃timo mensaje\">";
			  $lastpost .= "<img src=\"img/icon_latest_reply.gif\" alt=\">\"></a>";
			  
			  
			}else{$lastpost = "No hay mensajes";}
			
			if($c["auth_read"] == 0 ||($userrow["authlevel"] == 1 && $c["auth_read"] != 0)){
				$page .= "<tr><td width=20 class=l><a href=?f=".$c['forum_id']."><img src=\"";
				
				//para mostrar que tan nuevo hay post en un tema
				if(isset($c["topic_status"]) && $c["topic_status"] == 0 && $c["forum_topics"] != 0 && $query_topic['topic_time'] >= time() - 60*60*6){
					$page .= "img/new_2.gif";
				}elseif(isset($c["topic_status"]) && $c["topic_status"] == 0){
					$page .= "img/old_2.gif";
				}else{
					$page .= "img/lock.gif";
				}
				
				$page .= "\"></a></td><td class=l><a href=?f=".$c['forum_id'].">".$c["forum_name"]."</a><br>";
				$page .= "".$c["forum_desc"]."</td>";
				$page .= "<td class=l width=50 align=center>".$c["forum_topics"]."</td>";
				$page .= "<td class=l width=50 align=center>".$c["forum_posts"]."</td>";
				$page .= "<td class=l width=110 align=center>$lastpost</td></tr>";
			}
		}
		$i++;
		$page .= "";
	}
	
	$page .= "</td></tr></table>";

    display($page, "Forum");

}

function form(&$page, $title,$dest=''){

	$page .= <<<END
<form  action="$dest" name="post" method=post>
<table width="100%">
  <tr>
    <td colspan=2>$title</td>
  </tr>
  <tr>
    <td colspan=2 class="c">Publicar una respuesta</td>
  </tr>
  <tr>
    <td>
      <div align="right"><b>Asunto:</b></div>
    </td>
    <td >
      <div align="left">
        <input type=text name=title size=50 maxlength=50 />
      </div>
    </td>
  </tr>
  <tr>
    <td class="l"><table border="0" cellpadding="2" cellspacing="0" width="100" align="center">
<tbody><tr align="center">
<td colspan="4"><span class="explaintitle">Emoticons</span></td>
</tr>
<tr align="center">
<td><a href="javascript:emoticon(':D')"><img src="img/smiles/icon_biggrin.gif" alt="Very Happy" title="Very Happy" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':)')"><img src="img/smiles/icon_smile.gif" alt="Smile" title="Smile" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':(')"><img src="img/smiles/icon_sad.gif" alt="Sad" title="Sad" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':o')"><img src="img/smiles/icon_surprised.gif" alt="Surprised" title="Surprised" border="0" height="15" width="15"></a></td>
</tr>
<tr align="center">
<td><a href="javascript:emoticon(':shock:')"><img src="img/smiles/icon_eek.gif" alt="Shocked" title="Shocked" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':?')"><img src="img/smiles/icon_confused.gif" alt="Confused" title="Confused" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon('8)')"><img src="img/smiles/icon_cool.gif" alt="Cool" title="Cool" border="0" height="15" width="15"></a></td>

<td><a href="javascript:emoticon(':lol:')"><img src="img/smiles/icon_lol.gif" alt="Laughing" title="Laughing" border="0" height="15" width="15"></a></td>
</tr>
<tr align="center">
<td><a href="javascript:emoticon(':x')"><img src="img/smiles/icon_mad.gif" alt="Mad" title="Mad" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':P')"><img src="img/smiles/icon_razz.gif" alt="Razz" title="Razz" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':oops:')"><img src="img/smiles/icon_redface.gif" alt="Embarassed" title="Embarassed" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':cry:')"><img src="img/smiles/icon_cry.gif" alt="Crying or Very sad" title="Crying or Very sad" border="0" height="15" width="15"></a></td>
</tr>
<tr align="center">
<td><a href="javascript:emoticon(':evil:')"><img src="img/smiles/icon_evil.gif" alt="Evil or Very Mad" title="Evil or Very Mad" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':twisted:')"><img src="img/smiles/icon_twisted.gif" alt="Twisted Evil" title="Twisted Evil" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':roll:')"><img src="img/smiles/icon_rolleyes.gif" alt="Rolling Eyes" title="Rolling Eyes" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':wink:')"><img src="img/smiles/icon_wink.gif" alt="Wink" title="Wink" border="0" height="15" width="15"></a></td>
</tr>
<tr align="center">
<td><a href="javascript:emoticon(':!:')"><img src="img/smiles/icon_exclaim.gif" alt="Exclamation" title="Exclamation" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':?:')"><img src="img/smiles/icon_question.gif" alt="Question" title="Question" border="0" height="15" width="15"></a></td>

<td><a href="javascript:emoticon(':idea:')"><img src="img/smiles/icon_idea.gif" alt="Idea" title="Idea" border="0" height="15" width="15"></a></td>
<td><a href="javascript:emoticon(':arrow:')"><img src="img/smiles/icon_arrow.gif" alt="Arrow" title="Arrow" border="0" height="15" width="15"></a></td>
</tr>
<tr align="center">
<td colspan="4" class="nav"><a href="forum.php?mode=smilies" onclick="window.open('forum.php?mode=smilies', '_phpbbsmilies', 'HEIGHT=250,resizable=yes,scrollbars=yes,WIDTH=300');return false;" target="_phpbbsmilies">Ver mas Emoticons</a></td>
</tr>
</tbody></table></td>
    <td>
      <table border="0" cellpadding="2" cellspacing="0" width="450">
<tbody><tr align="center">

</tr>
<tr>
<td colspan="9">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td colspan="9">
</td>
</tr>
<tr>
<td colspan="9">
<textarea name="content" rows="15" cols="35" style="width: 450px;" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">
</textarea>
</td>
</tr>
</tbody></table>
    </td>
  </tr>
  <tr>
    <td class=c colspan=1><a href="javascript:history.back(1);">Volver</a></td>
	<td class=c colspan=2><input accesskey="s" tabindex="6" name="post" class="mainoption" value="Enviar" type="submit"></td>
  </tr>
</table>

</form>
<script>
function emoticon(text) {
	var txtarea = document.post.content;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}
</script>
END;



}

function CleanStr($str){
  //global $admin;
  $str = trim($str);//先頭と末尾の空白除去
  if (get_magic_quotes_gpc()) {//￥を削除
    $str = stripslashes($str);
  }
  //if($admin!=ADMIN_PASS){//管理者はタグ可能
    $str = htmlspecialchars($str);//タグっ禁止
    $str = str_replace("&amp;", "&", $str);//特殊文字
  //}
  str_replace("\"", "\&quot;", $str);
  str_replace("\n", "\\n", $str);
  return str_replace(",", "&#44;", $str);//カンマを変換
}

function iconnize($str){
	//Este archivo contiene la lista de emoticos y demas graficos
	@include("img/smiles/list.php");
		
    foreach($array as $a => $b) {
        $str = str_replace($a," <img src=\"$b\" alt=\"$a\">", $str);
    }
    return $str;
}

function smilies(){

	$page = '<a name="top" id="top"></a><script language="javascript" type="text/javascript">
<!--
function emoticon(text) {
	text = \' \' + text + \' \';
	if (opener.document.forms[\'post\'].content.createTextRange && opener.document.forms[\'post\'].content.caretPos) {
		var caretPos = opener.document.forms[\'post\'].content.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == \' \' ? text + \' \' : text;
		opener.document.forms[\'post\'].content.focus();
	} else {
	opener.document.forms[\'post\'].content.value  += text;
	opener.document.forms[\'post\'].content.focus();
	}
}
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="10"><tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="c">Emoticons</td>
</tr><tr><th class="c"><table width="100" border="0" cellspacing="0" cellpadding="5">';


	/*
	  Los iconos se leen desde el list.php
	  Ahi se encuentra el catalogo de emoticons
	*/
	include("img/smiles/list.php");

	$i = 0;
    foreach($array as $a => $b) {
		if($i==0){$page .= "<tr align=\"center\">\n";}
		$i++;
		$page .= "<td><a href=\"javascript:emoticon('$a')\"><img src=\"$b\" alt=\"$c\" width=\"15\" height=\"15\" border=\"0\" title=\"$c\" /></a></td>\n";
		if($i==8){$i=0;$page .= "</tr>\n";}
		
    }
	if($i!=0){$page .= "</tr>\n";}

	//Cierra los dos tables
	$page .= "</table>\n</td>\n</tr>\n<tr>\n<td class=\"c\" align=\"center\">";
	$page .= "<a href=\"javascript:window.close();\">Cerrar Ventana</a>\n";
	$page .= "</td>\n</tr>\n</table>\n</td>\n</tr>\n</table>";

	display($page,'Emoticons',false);
die();

}
/*
  Foro!!!
*/
if (isset($f) && isset($new) && is_numeric($f) && $new == "thread"){ newthread($f);}
elseif(isset($t) && isset($new) && is_numeric($t) && $new == "reply"){ reply($t);}
elseif(isset($f) && is_numeric($f)){ showtopic($f);}
elseif(isset($t) && is_numeric($t)){ showthread($t);}
elseif(isset($mode) && $mode == 'smilies'){smilies();}
else { showcategories(); }



//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
