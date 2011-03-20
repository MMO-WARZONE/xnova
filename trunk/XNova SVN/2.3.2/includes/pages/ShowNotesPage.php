<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowNotesPage($CurrentUser)
{
	global $lang,$db, $lang,$displays;
        $display=FALSE;
	$a 		= $_GET['a'];
	$n 		= intval($_GET['n']);

	if($_POST["s"] == 1 || $_POST["s"] == 2)
	{
		$time 		= time();
		$priority 	= mysql_escape_string(strip_tags($_POST["u"]));
		$title 		= ($_POST["title"]) ? mysql_escape_string(strip_tags($_POST["title"])) : "Sin título";
		$text 		= ($_POST["text"]) ? mysql_escape_string(strip_tags($_POST["text"])) : "Sin texto";

		if($_POST["s"] ==1)
		{
			$db->query("INSERT INTO {{table}} SET owner='".$CurrentUser['id']."', time='".$time."', priority='".$priority."', title='".$title."', text='".$text."'","notes");
			header("location:game.php?page=notes");
		}
		elseif($_POST["s"] == 2)
		{
			$id = intval($_POST["n"]);
			$note_query = $db->query("SELECT * FROM {{table}} WHERE id='".$id."' AND owner='".$CurrentUser["id"]."'","notes");

			if(!$note_query)
				header("location:game.php?page=notes");

			$db->query("UPDATE {{table}} SET
						time='".$time."', priority='".$priority."', 
						title='".$title."', text='".$text."' 
						WHERE id='".$id."'","notes");
						
			header("location:game.php?page=notes");
		}
	}
	elseif($_POST)
	{
		foreach($_POST as $a => $b)
		{
			if(preg_match("/delmes/i",$a) && $b == "y")
			{
				$id = str_replace("delmes","",$a);
				$note_query = $db->query("SELECT * FROM {{table}} WHERE id=$id AND owner={$CurrentUser['id']}","notes");

				if($note_query)
				{
					$deleted++;
					$db->query("DELETE FROM {{table}} WHERE `id`=$id;","notes");
				}
			}
		}

		if($deleted)
			header("location:game.php?page=notes");
		else
			header("Location:game.php?page=notes");
	}
	else
	{
            $displays->assignContent("notes/notes",false,false);
		if($_GET["a"] == 1)
		{
                    $displays->newblock("form");
			$parse['c_Options'] = "<option value=2 selected=selected>".$lang['nt_important']."</option>
	  								<option value=1>".$lang['nt_normal']."</option>
									<option value=0>".$lang['nt_unimportant']."</option>";
			$parse['TITLE'] 	= $lang['nt_create_note'];
			$parse[inputs]  	= "<input type=hidden name=s value=1>";
                        foreach($parse as $key => $value){
                            $displays->assign($key,$value);
                        }
		}
		elseif($_GET["a"] == 2)
		{
                    $displays->newblock("form");
			$note = $db->query("SELECT * FROM {{table}} WHERE owner='".$CurrentUser['id']."' AND id='".$n."'",'notes',true);
			if(!$note)
				header("location:game.php?page=notes");

			$SELECTED[$note['priority']] = 'selected="selected"';

			$parse['c_Options'] = "<option value=2 {$SELECTED[2]}>".$lang['nt_important']."</option>
			<option value=1{$SELECTED[1]}>".$lang['nt_normal']."</option>
			<option value=0{$SELECTED[0]}>".$lang['nt_unimportant']."</option>";

			$parse['TITLE'] 	= $lang['nt_edit_note'];
			$parse['inputs'] 	= '<input type=hidden name=s value=2><input type=hidden name=n value='.$note['id'].'>';
			$parse[asunto]		= $note[title];
			$parse[texto]		= $note[text];
                        foreach($parse as $key => $value){
                            $displays->assign($key,$value);
                        }

		}
		else
		{
                    $displays->newblock("notes");
			$notes_query = $db->query("SELECT * FROM {{table}} WHERE owner={$CurrentUser['id']} ORDER BY time DESC",'notes');

			$count = 0;

			while($note = mysql_fetch_array($notes_query))
			{
                                $displays->newblock("listnotes");
				$count++;

				if($note["priority"] == 0){ $parse['NOTE_COLOR'] = "lime";}
				elseif($note["priority"] == 1){ $parse['NOTE_COLOR'] = "yellow";}
				elseif($note["priority"] == 2){ $parse['NOTE_COLOR'] = "red";}

				$parse['NOTE_ID'] 		= $note['id'];
				$parse['NOTE_TIME'] 	= date("Y-m-d h:i:s",$note["time"]);
				$parse['NOTE_TITLE'] 	= $note['title'];
				$parse['NOTE_TEXT'] 	= strlen($note['text']);
                                foreach($parse as $key => $value){
                                     $displays->assign($key,$value);
                                }
                        }

			if($count == 0)
			{
                                $displays->newblock("error");
				//$list = "<tr><th colspan=4>".$lang['nt_you_dont_have_notes']."</th>\n";
			}

			
		}
                $displays->display();
	}
}
?>