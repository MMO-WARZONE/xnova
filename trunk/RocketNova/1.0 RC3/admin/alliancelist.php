<?php

/**
########################################################
Allianzlist.php by RedFighter

Funktion: 
Auflistung aller vorhandenen Allianzen welche gleichzeitig via Adminpanel editierbar sind!

Fehler und Verbesserungsvorschläge bitte im entsprechende Thread posten!
Support auch nur über diesen Thread!

(c) Copyright by RedFighter 
########################################################
**/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 2) {


$query = doquery("SELECT `id`, `ally_name`, `ally_tag`,  `ally_owner`, `ally_register_time`, `ally_description`, `ally_text`, `ally_members` FROM {{table}}", "alliance");

            $i = 0;
			while ($u = mysql_fetch_assoc($query)) {
			
			$users = doquery("SELECT `username` FROM {{table}} WHERE id='". $u['ally_owner'] ."'", "users");
            $a = mysql_fetch_array($users);
            $leader = $a['username'];

            $ally_register_time = gmdate ( "d/m/Y G:i:s", $u['ally_register_time']);
			
			$parse['alliance'] .= "<tr>"
			. "<td class=b><center><b>" . $u['id'] . "</center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?allyname=" . $u['id'] . ">" . $u['ally_name'] . "</a></center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?allyname=" . $u['id'] . ">" . $u['ally_tag'] . "</a></center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?leader=" . $u['id'] . "><b>" . $leader . "</center></b></a></td>"
			. "<td class=b><center><b>" . $ally_register_time . "</center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?desc=" . $u['id'] . ">Anschauen</a>/<a href=alliancelist.php?edit=" . $u['id'] . ">Bearbeiten</a></center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?mitglieder=". $u['id'] .">" . $u['ally_members'] . "</a></center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?mail=" . $u['id'] . "><img src=../images/r5.png></a></center></b></td>"
			. "<td class=b><center><b><a href=alliancelist.php?del=" . $u['id'] . ">X</a></center></b></td>"
			. "</tr>";
			$i++; 
			}
		if ($i == "1")
			$parse['allianz'] .= "<tr><th class=b colspan=9>Es gibt eine Allianz</th></tr>";
		else
			$parse['allianz'] .= "<tr><th class=b colspan=9>Es gibt {$i} Allianzen</th></tr>";

        if(isset($_GET['desc'])) {
		
		$ally_id = intval($_GET['desc']);
		$info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
        $ally_text = mysql_fetch_assoc($info);
		
		$parse['desc'] .= "<tr>"
		    . "<th colspan=9>Allianzbeschreibung</th></tr>"
		    . "<tr>"
			. "<td class=b colspan=9><center><b>" . $ally_text['ally_description'] . "</center></b></td>"
			. "</tr>";
		}
		
		if(isset($_GET['edit'])) {	
				
		$ally_id = intval($_GET['edit']);
		$info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
        $ally_text = mysql_fetch_assoc($info);
			
				$parse['desc'] .= "<tr>"
		    . "<th colspan=9>Allianzbeschreibung</th></tr>"
		    . "<tr>"
		    . "<form action=alliancelist.php?edit=" . $ally_id  . " method=POST>"
			. "<td class=b colspan=9><center><b><textarea name=desc cols=50 rows=10 >" . $ally_text['ally_description'] . "</textarea></center></b></td>"
			. "</tr>"		    
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value=Speichern></center></b></td>"
		    . "</form></tr>";
		
		if(isset($_POST['desc'])) {
		$query = doquery("UPDATE {{table}} SET `ally_description` = '". $_POST['desc'] ."' WHERE `id` = '" . $_GET['edit'] . "'",'alliance'); 
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Die Allianzbeschreibung wurde editiert', 'Allianbeschreibung editiert');
} 
}
		

		## Ally name und tag##
		
		if(isset($_GET['allyname'])) {
		$ally_id = $_GET['allyname'];
		$query = doquery("SELECT `ally_image`, `ally_web`, `ally_name`, `ally_tag` FROM {{table}} WHERE `id` = '". $_GET['allyname'] ."'", "alliance");
        $u = mysql_fetch_assoc($query);
		
			$parse['name'] .= "<tr>"
		    . "<td colspan=9 class=c>Allianzname/Tag</td></tr>"
		    . "<form action=alliancelist.php?allyname=" . $ally_id  . " method=POST>"
		    . "<tr>"
			. "<th colspan=4><center><b>Allianzname</center></b></th>   <th colspan=5><center><b><input type=text size=38 name=name value=".$u['ally_name']."></center></b></th>"
			. "</tr>"	
		    . "<tr>"
			. "<th colspan=4><center><b>Allianztag</center></b></th>   <th colspan=5><center><b><input type=text size=38 name=tag value=".$u['ally_tag']."></center></b></th>"
			. "</tr>"	
		    . "<tr>"
			. "<th colspan=3><center><b>Allianzlogo</center></b></th>   <th colspan=3><center><b><input type=text size=38 name=image value=".$u['ally_image']."></center></b></th>  <th colspan=3><center><b><a href=". $u['ally_image'] .">KLICK</a></center></b></th>"
			. "</tr>"
		    . "<tr>"
			. "<th colspan=3><center><b>Allianz Website</center></b></th>   <th colspan=3><center><b><input type=text size=38 name=web value=".$u['ally_web']."></center></b></th>  <th colspan=3><center><b><a href=". $u['ally_web'] .">KLICK</a></center></b></th>"
			. "</tr>"			
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value=Speichern></center></b></td>"
		    . "</form></tr>";
		
		if(isset($_POST['name'])) {
		$query = doquery("UPDATE {{table}} SET `ally_name` = '". $_POST['name'] ."', `ally_tag` = '". $_POST['tag'] ."', `ally_image` = '". $_POST['image'] ."', `ally_web` = '". $_POST['web'] ."' WHERE `id` = '" . $_GET['allyname'] . "'",'alliance'); 
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Die Allianz wurde editiert', 'Allianz editiert');
		}
			
		}
		
		if(isset($_GET['del'])) {
		$ally_id = $_GET['del'];
					
			$parse['name'] .= "<tr>"
		    . "<th colspan=9>Allianz l&ouml;schen</th></tr>"
		    . "<form action=alliancelist.php?del=" . $ally_id  . " method=POST>"
		    . "<tr>"
			. "<th colspan=9><center><b>Bist du dir sicher das du diese Allianz l&ouml;schen willst?<br>Sie ist nachdem du dies best&auml;tigt hast unwiderruflich gel&ouml;scht! </center></b></th>"
			. "</tr>"	
			. "<td class=b colspan=9><center><b><input type=submit value=L&ouml;schen name=del></center></b></td>"
		    . "</form></tr>";
		
		if(isset($_POST['del'])) {
		$query = doquery("DELETE FROM {{table}} WHERE id = '" . $_GET['del'] . "'",'alliance'); 
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Die Allianz wurde gel&ouml;scht', 'Allianz gel&ouml;scht');
        }
		}
	 
/**
########################################################
Allianzlist.php by RedFighter

Version 2!

Funktion: 
Man kann absofort eine Liste der Mitglieder der Allianz sehen!
########################################################
**/
     if(isset($_GET['mitglieder'])) {
	 $ally_id = $_GET['mitglieder'];
	 
     $users = doquery("SELECT `id`, `username`, `email` FROM {{table}} WHERE ally_id='". $ally_id ."'", "users");

	 $parse['member'] .= "<tr>"
			. "<td class=c colspan=2><center><b>ID</center></b></td>"
			. "<td class=c colspan=3><center><b>Username</center></b></td>"
			. "<td class=c colspan=2><center><b>Email</center></b></td>"
			. "<td class=c colspan=2><center><b>Entlassen</center></b></td>"
			. "</tr>";
	 
	        $i = 0;
			while ($u = mysql_fetch_assoc($users)) {		
			$query = doquery("SELECT `ally_owner` FROM {{table}}", "alliance");
			$a = mysql_fetch_assoc($query);
			
			$parse['member_row'] .= "<tr>"
			. "<td class=b colspan=2><center><b>" . $u['id'] . "</center></b></td>"
			. "<td class=b  colspan=3><center><b><a href=../messages.php?mode=write&id=" . $u['id'] . ">". $u['username'] ."</a></center></b></td>"
			. "<td class=b  colspan=2><center><b>". $u['email'] ."</center></b></td>"
			. "<td class=b  colspan=2><center><b><a href=alliancelist.php?ent=". $u['id'] ."> X </a></center></b></td>"
			. "</tr>";
			$i++; 
			}
	 }
	 
	 if(isset($_GET['ent'])) {
	 $user_id = $_GET['ent'];
	 
	 			$parse['name'] .= "<tr>"
		    . "<th colspan=9>Allianz l&ouml;schen</th></tr>"
		    . "<form action=alliancelist.php?ent=" . $user_id  . " method=POST>"
		    . "<tr>"
			. "<th colspan=9><center><b>Nach dem best&auml;tigen des Buttons wird der Spieler aus dieser Allianz entlassen. <br>Willst du das wirklich tun?</center></b></th>"
			. "</tr>"	
			. "<td class=b colspan=9><center><b><input type=submit value=Entlassen name=ent></center></b></td>"
		    . "</form></tr>";
		
		if(isset($_POST['ent'])) {
		$user_id = $_GET['ent'];
        doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='".$user_id."'", "users");
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Mitglied wurde entlassen', 'Mitglied entlassen');
        }
	 
	 }
	 
	 /**
########################################################
Allianzlist.php by RedFighter

Version 3!

Funktion: 
Rundmails können vom Admin geschrieben werden
Leader kann vom Admin geändert werden
########################################################
**/
        if(isset($_GET['mail'])) {
				$ally_id = $_GET['mail'];
		
						$parse['mail'] .= "<tr>"
		    . "<th colspan=9>Rundmail an die Allianzmitglieder</th></tr>"
		    . "<tr>"
		    . "<form action=alliancelist.php?mail=" . $ally_id  . " method=POST>"
			. "<td class=b colspan=4>Betreff:</td><td class=b colspan=5><center><b><input type=text name=subject size=28</center></b></td>"
			. "</tr><tr>"		
			. "<td class=b colspan=9><center><b><textarea name=text cols=50 rows=10 ></textarea></center></b></td>"
			. "</tr>"		    
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value=Versenden></center></b></td>"
		    . "</form></tr>";
		
        if(isset($_POST['text'])) {
		$ally_id = $_GET['mail'];
        $sq = doquery("SELECT id FROM {{table}} WHERE ally_id='". $ally_id ."'", "users");
                        while ($u = mysql_fetch_array($sq)) {
                                doquery("INSERT INTO {{table}} SET
                                `message_owner`='{$u['id']}',
                                `message_sender`='Administrator' ,
                                `message_time`='" . time() . "',
                                `message_type`='2',
                                `message_from`='Allianznachricht (Admin)',
                                `message_subject`='". $_POST['subject'] ."',
                                `message_text`='". $_POST['text'] ."'
                                ", "messages");
                        }						AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Rundmail wurde verschickt!', 'Versendet');
						}		
						}
						
		if(isset($_GET['leader'])) {
		$ally_id = $_GET['leader'];
		
		$query = doquery("SELECT `ally_owner` FROM {{table}}", "alliance");
		$u = mysql_fetch_array($query);
		$users = doquery("SELECT `username` FROM {{table}} WHERE id='". $u['ally_owner'] ."'", "users");
        $a = mysql_fetch_array($users);
        $leader = $a['username'];
		
		$parse['leader'] .= "<tr>"
		    . "<td colspan=9 class=c>Leader &auml;ndern</td></tr>"
		    . "<form action=alliancelist.php?leader=" . $ally_id  . " method=POST>"
		    . "<tr>"
			. "<th colspan=4><center><b>Aktueller Leader:</center></b></th>   <th colspan=5><center><b>$leader</center></b></th>"
			. "</tr>"	
		    . "<tr>"
			. "<th colspan=4><center><b><u>ID</u> des neuen Leaders</center></b></th>   <th colspan=5><center><b><input type=text size=8 name=leader></center></b></th>"
			. "</tr>"	
				
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value=Speichern></center></b></td>"
		    . "</form></tr>";
		
		if(isset($_POST['leader'])) {
		$sq = doquery("SELECT ally_id FROM {{table}} WHERE id='". $_POST['leader'] ."'", "users");
		$a = mysql_fetch_array($sq);

		if($a['ally_id'] == $_GET['leader']) {
        $query = doquery("UPDATE {{table}} SET `ally_owner` = '". $_POST['leader'] ."' WHERE `id` = '" . $_GET['leader'] . "'",'alliance'); 
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Der Allianzleader wurde erfolgreich ge&auml;ndert!', 'Erfolgreich');
		} else {
		AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Der User befindet sich nicht in dieser Allianz!', 'Fehler');
        }
	 }
	 }
	 
	 
	 		display(parsetemplate(gettemplate('admin/alliance_body'), $parse), 'Allianceubersicht', false, '', true);

		} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>