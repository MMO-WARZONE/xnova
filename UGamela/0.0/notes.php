<?php	//notes.php
{//init
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	//esto no es necesario, porque no hay imagenes.
	//$dpath = (!$userrow["dpatch"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}
if($_POST["s"] == 1 || $_POST["s"] == 2){//Edicion y agregar notas

	$time = time();
	$priority = $_POST["u"];
	$title = ($_POST["title"]) ? $_POST["title"] : $lang['NoTitle'];
	$text = ($_POST["text"]) ? $_POST["text"] : $lang['NoText'];

	if($_POST["s"] ==1){
		doquery("INSERT INTO {{table}} SET owner={$userrow[id]}, time=$time, priority=$priority, title='$title', text='$text'","notes");
		message($lang['NoteAdded'], $lang['Please_Wait'],"notes","3");
	}elseif($_POST["s"] == 2){
		/*
		  pequeña query para averiguar si la nota que se edita es del propio jugador
		*/
		$id = $_POST["n"];
		$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner=".$userrow["id"],"notes");
		
		if(!$note_query){ error($lang['notpossiblethisway'],$lang['Notes']); }
		
		doquery("UPDATE {{table}} SET time=$time, priority=$priority, title='$title', text='$text' WHERE id=$id","notes");
		message($lang['NoteUpdated'], $lang['Please_Wait'], "notes", "3");
	}

}
elseif($_POST){//Borrar

	foreach($_POST as $a => $b){
		/*
		  Los checkbox marcados tienen la palabra delmes seguido del id.
		  Y cada array contiene el valor "y" para compro
		*/
		if(preg_match("/delmes/i",$a) && $b == "y"){
			
			$id = str_replace("delmes","",$a);
			$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner={$userrow[id]}","notes");
			//comprobamos,
			if($note_query){
				$deleted++;
				doquery("DELETE FROM {{table}} WHERE `id`=$id;","notes");// y borramos
			}
		}
	}
	if($deleted){
		$mes = ($deleted == 1) ? $lang['NoteDeleted'] : $lang['NoteDeleteds'];
		message($mes,$lang['Please_Wait'],"notes","3");
	}else{header("Location: notes");}

}
else{//sin post...
	echo_head($lang['Notes']);
	echo '<script src="scripts/cntchar.js" type="text/javascript"></script>
<script src="scripts/win.js" type="text/javascript"></script>
<center>';
if($a == 1){//crear una nueva nota.
	/*
	  Formulario para crear una nueva nota.
	*/
	echo '<form action=notes method=post>
	<input type=hidden name=s value=1>
	<table width=519>
	  <tr>
		<td class=c colspan=2>'.$lang['Createnote'].'</td>
	  </tr>
	  <tr>
	    <th>'.$lang['Priority'].'</th>
		<th>
		  <select name=u>
			<option value=2>'.$lang['Important'].'</option>
			<option value=1>'.$lang['Normal'].'</option>
			<option value=0>'.$lang['Unimportant'].'</option>
		  </select>
		</th>
	  </tr>
	  <tr>
		<th>'.$lang['Subject'].'</th>
		<th><input type=text name=title size=30 maxlength=30 value=""></th>
	  </tr>
	  <tr>
		<th>'.$lang['Notice'].' (<span id=cntChars>0</span> / 5000 '.$lang['characters'].')</th>
		<th>
		  <textarea name=text cols=60 rows=10 onkeyup="javascript:cntchar(5000)"></textarea>
		</th>
	  </tr>
	  <tr>
		<td class=c><a href=notes>'.$lang['Back'].'</a></td>
		<td class=c><input type=submit value="'.$lang['Save'].'"></td>
	  </tr>
	</table>
</form>';

}
elseif($a == 2){//editar
	/*
	  Formulario donde se puestra la nota y se puede editar.
	*/
	$note = doquery("SELECT * FROM {{table}} WHERE owner={$userrow[id]} AND id=$n",'notes',true);
	
	if(!$note){ message($lang['notpossiblethisway'],$lang['Error']); }
	
	$cntChars = strlen($note['text']);
	
	$SELECTED[$note['priority']] = ' selected="selected"';

	echo <<<HTML
<form action=notes method=post>
  <input type=hidden name=s value=2>
  <input type=hidden name=n value={$note[id]}>
  <table width=519>
	<tr>
	  <td class=c colspan=2>{$lang[Editnote]}</td>
	</tr>
	<tr>
	  <th>{$lang[Priority]}</th>
	  <th>
		<select name=u>
		  <option value=2{$SELECTED[2]}>{$lang[Important]}</option>
		  <option value=1{$SELECTED[1]}>{$lang[Normal]}</option>
		  <option value=0{$SELECTED[0]}>{$lang[Unimportant]}</option>
		</select>
	  </th>
	</tr>
	<tr>
	  <th>{$lang[Subject]}</th>
	  <th>
		<input type=text name=title size=30 maxlength=30 value={$note[title]}>
	  </th>
	</tr>
	<tr>
	  <th>{$lang[Note]} (<span id="cntChars">$cntChars</span> / 5000 {$lang[characters]})</th>
	  <th>
	    <textarea name=text cols=60 rows=10 onkeyup="javascript:cntchar(5000)">{$note[text]}</textarea>
	  </th>
	</tr>
	<tr>
	  <td class=c><a href=notes>{$lang[Back]}</a></td>
	  <td class=c>
		<input type=reset value="{$lang[Reset]}">
		<input type=submit value="{$lang[Apply]}">
	  </td>
	</tr>
  </table>
</form>
HTML;

}
else{//default

	echo "
<form action=notes.php method=post>
  <table width=519>
	<tr>
	  <td class=c colspan=4>{$lang[Notes]}</td>
	</tr>
	<tr>
	  <th colspan=4><a href=notes?a=1>{$lang[MakeNewNote]}</a></th>
	</tr>
	<tr>
	  <td class=c></td>
	  <td class=c>{$lang[Date]}</td>
	  <td class=c>{$lang[Subject]}</td>
	  <td class=c>{$lang[Size]}</td>
	</tr>";

	$notes_query = doquery("SELECT * FROM {{table}} WHERE owner={$userrow[id]} ORDER BY time DESC",'notes');
	//Loop para crear la lista de notas que el jugador tiene
	$count = 0;
	while($note = mysql_fetch_array($notes_query)){
		$count++;
		//Colorea el titulo dependiendo de la prioridad
		if($note["priority"] == 0){ $color = "lime";}//Importante
		elseif($note["priority"] == 1){ $color = "yellow";}//Normal
		elseif($note["priority"] == 2){ $color = "red";}//Sin importancia
		
		echo "
	<tr>
	  <th width=20><input name=delmes{$note[id]} value=y type=checkbox></th>
	  <th width=150>".date("Y-m-d h:m:s",$note["time"])."</th>
	  <th><a href=\"notes?a=2&amp;n={$note[id]}\"><font color=$color>{$note[title]}</font></a></th>
	  <th align=right width=40>".strlen($note['text'])."</th>
	</tr>";
	}
  if($count == 0){
  echo "
	<tr>
	  <th colspan=4>{$lang[ThereIsNoNote]}</th>
	</tr>\n";
  }
	echo "
	<tr>
	  <td colspan=4><input value={$lang[Delete]} type=submit></td>
	</tr>
  </table>
</form>
</center>
</body>
</html>";
}
}
if(isset($link)) mysql_close();
// Created by Perberos. All rights reversed (C) 2006
?>