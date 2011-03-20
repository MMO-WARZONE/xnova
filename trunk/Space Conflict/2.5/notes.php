<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** notes.php                             **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

$a = $_GET['a'];
$n = intval($_GET['n']);
$lang['Please_Wait'] = "Patientez...";

includeLang('notes');

$lang['PHP_SELF'] = 'notes.'.$phpEx;

if($_POST["s"] == 1 || $_POST["s"] == 2){

	$time = time();
	$priority = $_POST["u"];
	$title = ($_POST["title"]) ? mysql_escape_string(strip_tags($_POST["title"])) : $lang['NoTitle'];
	$text = ($_POST["text"]) ? mysql_escape_string(strip_tags($_POST["text"])) : $lang['NoText'];

	if($_POST["s"] ==1){
		doquery("INSERT INTO {{table}} SET owner={$user['id']}, time=$time, priority=$priority, title='$title', text='$text'","notes");
		message($lang['NoteAdded'], $lang['Please_Wait'],'notes.'.$phpEx,"3");
	}elseif($_POST["s"] == 2){
		$id = intval($_POST["n"]);
		$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner=".$user["id"],"notes");

		if(!$note_query){ error($lang['notpossiblethisway'],$lang['Notes']); }

		doquery("UPDATE {{table}} SET time=$time, priority=$priority, title='$title', text='$text' WHERE id=$id","notes");
		message($lang['NoteUpdated'], $lang['Please_Wait'], 'notes.'.$phpEx, "3");
	}
}
elseif($_POST){

	foreach($_POST as $a => $b){
		if(preg_match("/delmes/i",$a) && $b == "y"){

			$id = str_replace("delmes","",$a);
			$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner={$user['id']}","notes");

			if($note_query){
				$deleted++;
				doquery("DELETE FROM {{table}} WHERE `id`=$id;","notes");
			}
		}
	}
	if($deleted){
		$mes = ($deleted == 1) ? $lang['NoteDeleted'] : $lang['NoteDeleteds'];
		message($mes,$lang['Please_Wait'],'notes.'.$phpEx,"3");
	}else{header("Location: notes.$phpEx");}

}else{
	if($_GET["a"] == 1){

		$parse = $lang;
		$parse['c_Options'] = "<option value=2 selected=selected>{$lang['Important']}</option>
			  <option value=1>{$lang['Normal']}</option>
			  <option value=0>{$lang['Unimportant']}</option>";

		$parse['cntChars'] = '0';
		$parse['TITLE'] = $lang['Createnote'];
		$parse['text'] = '';
		$parse['title'] = '';
		$parse['inputs'] = '<input type=hidden name=s value=1>';

		$page .= parsetemplate(gettemplate('notes_form'), $parse);

		display($page,$lang['Notes'],false);

	}
	elseif($_GET["a"] == 2){

		$note = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} AND id=$n",'notes',true);

		if(!$note){ message($lang['notpossiblethisway'],$lang['Error']); }

		$cntChars = strlen($note['text']);

		$SELECTED[$note['priority']] = ' selected="selected"';

		$parse = array_merge($note,$lang);
		$parse['c_Options'] = "<option value=2{$SELECTED[2]}>{$lang['Important']}</option>
			  <option value=1{$SELECTED[1]}>{$lang['Normal']}</option>
			  <option value=0{$SELECTED[0]}>{$lang['Unimportant']}</option>";
		$parse['cntChars'] = $cntChars;
		$parse['TITLE'] = $lang['Editnote'];
		$parse['inputs'] = '<input type=hidden name=s value=2><input type=hidden name=n value='.$note['id'].'>';

		$page .= parsetemplate(gettemplate('notes_form'), $parse);

		display($page,$lang['Notes'],false);

	}
	else{

		$notes_query = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} ORDER BY time DESC",'notes');
		$count = 0;
		$parse=$lang;
		while($note = mysql_fetch_array($notes_query)){
			$count++;
			if($note["priority"] == 0){ $parse['NOTE_COLOR'] = "lime";}
			elseif($note["priority"] == 1){ $parse['NOTE_COLOR'] = "yellow";}
			elseif($note["priority"] == 2){ $parse['NOTE_COLOR'] = "red";}

			$parse['NOTE_ID'] = $note['id'];
			$parse['NOTE_TIME'] = date("Y-m-d h:i:s",$note["time"]);
			$parse['NOTE_TITLE'] = $note['title'];
			$parse['NOTE_TEXT'] = strlen($note['text']);

			$list .= parsetemplate(gettemplate('notes_body_entry'), $parse);

		}

		if($count == 0){
			$list .= "<tr><th colspan=4>{$lang['ThereIsNoNote']}</th>\n";
		}

		$parse = $lang;
		$parse['BODY_LIST'] = $list;
		$page .= parsetemplate(gettemplate('notes_body'), $parse);

		display($page,$lang['Notes'],false);
	}
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>