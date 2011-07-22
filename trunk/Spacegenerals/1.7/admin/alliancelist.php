<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);
includeLang('admin');

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
		. "<td class=b><center><b><a href=alliancelist.php?desc=" . $u['id'] . ">".$lang['alliancelist_lookat']."</a>/<a href=alliancelist.php?edit=" . $u['id'] . ">".$lang['alliancelist_edit']."</a></center></b></td>"
		. "<td class=b><center><b><a href=alliancelist.php?mitglieder=". $u['id'] .">" . $u['ally_members'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href=alliancelist.php?mail=" . $u['id'] . "><img src=../images/r5.png></a></center></b></td>"
		. "<td class=b><center><b><a href=alliancelist.php?del=" . $u['id'] . ">X</a></center></b></td>"
		. "</tr>";
		$i++;
	}

	if ($i == "1")
		$parse['allianz'] .= "<tr><th class=b colspan=9>".$lang['alliancelist_total1']."</th></tr>";
	else
		$parse['allianz'] .= "<tr><th class=b colspan=9>".str_replace('##allys##', ''.$i, $lang['alliancelist_total'])."</th></tr>";

	if(isset($_GET['desc'])) {

		$ally_id = intval($_GET['desc']);
		$info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
		$ally_text = mysql_fetch_assoc($info);

		$parse['desc'] .= "<tr>"
			. "<th colspan=9>".$lang['alliancelist_description']."</th></tr>"
			. "<tr>"
			. "<td class=b colspan=9><center><b>" . $ally_text['ally_description'] . "</center></b></td>"
			. "</tr>";
	}

	if(isset($_GET['edit'])) {

		$ally_id = intval($_GET['edit']);
		$info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
		$ally_text = mysql_fetch_assoc($info);

		$parse['desc'] .= "<tr>"
			. "<th colspan=9>".$lang['alliancelist_description']."</th></tr>"
			. "<tr>"
			. "<form action=alliancelist.php?edit=" . $ally_id  . " method=POST>"
			. "<td class=b colspan=9><center><b><textarea name=desc cols=50 rows=10 >" . $ally_text['ally_description'] . "</textarea></center></b></td>"
			. "</tr>"
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_save']."' /></center></b></td>"
			. "</form></tr>";

		if(isset($_POST['desc'])) {
			$query = doquery("UPDATE {{table}} SET `ally_description` = '". $_POST['desc'] ."' WHERE `id` = '" . $_GET['edit'] . "'",'alliance');
			AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_edited'], $lang['alliancelist_edited_title']);
		}
	}


## Ally name und tag##

	if(isset($_GET['allyname'])) {
		$ally_id = $_GET['allyname'];
		$query = doquery("SELECT `ally_image`, `ally_web`, `ally_name`, `ally_tag` FROM {{table}} WHERE `id` = '". $_GET['allyname'] ."'", "alliance");
		$u = mysql_fetch_assoc($query);

		$parse['name'] .= "<tr>"
			. "<td colspan=9 class=c>".$lang['alliancelist_nametag']."</td></tr>"
			. "<form action=alliancelist.php?allyname=" . $ally_id  . " method=POST>"
			. "<tr>"
			. "<th colspan=4><center><b>".$lang['alliancelist_name']."</center></b></th><th colspan=5><center><b><input type=text size=38 name=name value=".$u['ally_name']."></center></b></th>"
			. "</tr>"
			. "<tr>"
			. "<th colspan=4><center><b>".$lang['alliancelist_tag']."</center></b></th>   <th colspan=5><center><b><input type=text size=38 name=tag value=".$u['ally_tag']."></center></b></th>"
			. "</tr>"
			. "<tr>"
			. "<th colspan=3><center><b>".$lang['alliancelist_logo']."</center></b></th>   <th colspan=3><center><b><input type=text size=38 name=image value=".$u['ally_image']."></center></b></th>  <th colspan=3><center><b><a href=". $u['ally_image'] .">KLICK</a></center></b></th>"
			. "</tr>"
			. "<tr>"
			. "<th colspan=3><center><b>".$lang['alliancelist_web']."</center></b></th>   <th colspan=3><center><b><input type=text size=38 name=web value=".$u['ally_web']."></center></b></th>  <th colspan=3><center><b><a href=". $u['ally_web'] .">KLICK</a></center></b></th>"
			. "</tr>"
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_save']."' /></center></b></td>"
			. "</form></tr>";

		if(isset($_POST['name'])) {
			$query = doquery("UPDATE {{table}} SET `ally_name` = '". $_POST['name'] ."', `ally_tag` = '". $_POST['tag'] ."', `ally_image` = '". $_POST['image'] ."', `ally_web` = '". $_POST['web'] ."' WHERE `id` = '" . $_GET['allyname'] . "'",'alliance');
			AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_edit_done'], $lang['alliancelist_edit_done_title']);
		}

	}

	if(isset($_GET['del'])) {
		$ally_id = $_GET['del'];

		$parse['name'] .= "<tr>"
			. "<th colspan=9>".$lang['alliancelist_delete']."</th></tr>"
			. "<form action=alliancelist.php?del=" . $ally_id  . " method=POST>"
			. "<tr>"
			. "<th colspan=9><center><b>".$lang['alliancelist_delete_confirm']."</b></center></th>"
			. "</tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_delete']."' name=del></b></center></td>"
			. "</form></tr>";

		if(isset($_POST['del'])) {
			$query = doquery("DELETE FROM {{table}} WHERE id = '" . $_GET['del'] . "'",'alliance');
			AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_deleted'], $lang['alliancelist_deleted_title']);
		}
	}


	if(isset($_GET['mitglieder'])) {
		$ally_id = $_GET['mitglieder'];

		$users = doquery("SELECT `id`, `username`, `email` FROM {{table}} WHERE ally_id='". $ally_id ."'", "users");

		$parse['member'] .= "<tr>"
			. "<td class=c colspan=2><center><b>".$lang['alliancelist_member_id']."</b></center></td>"
			. "<td class=c colspan=3><center><b>".$lang['alliancelist_member_username']."</b></center></td>"
			. "<td class=c colspan=2><center><b>".$lang['alliancelist_member_email']."</b></center></td>"
			. "<td class=c colspan=2><center><b>".$lang['alliancelist_member_dismiss']."</b></center></td>"
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
			. "<th colspan=9>".$lang['alliancelist_delete']."</th></tr>"
			. "<form action=alliancelist.php?ent=" . $user_id  . " method=POST>"
			. "<tr>"
			. "<th colspan=9><center><b>".$lang['alliancelist_dismiss_confirm']."</b></center></th>"
			. "</tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_dismiss']."' name=ent></center></b></td>"
			. "</form></tr>";

		if(isset($_POST['ent'])) {
			$user_id = $_GET['ent'];
			doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='".$user_id."'", "users");
			AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_dismissed_title'], $lang['alliancelist_dismissed_title']);
		}

	}


	if(isset($_GET['mail'])) {
		$ally_id = $_GET['mail'];

		$parse['mail'] .= "<tr>"
			. "<th colspan=9>".$lang['alliancelist_massmail']."</th></tr>"
			. "<tr>"
			. "<form action=alliancelist.php?mail=" . $ally_id  . " method=POST>"
			. "<td class=b colspan=4>".$lang['alliancelist_subject']."</td><td class=b colspan=5><center><b><input type=text name=subject size=28></b></center></td>"
			. "</tr><tr>"
			. "<td class=b colspan=9><center><b><textarea name=text cols=50 rows=10 ></textarea></b></center></td>"
			. "</tr>"
			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_send']."' /></b></center></td>"
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
					`message_from`='".$lang['alliancelist_from_admin']."',
					`message_subject`='". $_POST['subject'] ."',
					`message_text`='". $_POST['text'] ."'
					", "messages");
			}
			AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_massmail_send'], $lang['alliancelist_massmail_send_title']);
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
			. "<td colspan=9 class=c>".$lang['alliancelist_leader_change']."</td></tr>"
			. "<form action=alliancelist.php?leader=" . $ally_id  . " method=POST>"
			. "<tr>"
			. "<th colspan=4><center><b>".$lang['alliancelist_leader_current']."</b></center></th>   <th colspan=5><center><b>$leader</center></b></th>"
			. "</tr>"
			. "<tr>"
			. "<th colspan=4><center><b>".$lang['alliancelist_newleader_id']."</b></center></th>   <th colspan=5><center><b><input type=text size=8 name=leader></center></b></th>"
			. "</tr>"

			. "<tr>"
			. "<td class=b colspan=9><center><b><input type=submit value='".$lang['alliancelist_button_save']."' /></b></center></td>"
			. "</form></tr>";

		if(isset($_POST['leader'])) {
			$sq = doquery("SELECT ally_id FROM {{table}} WHERE id='". $_POST['leader'] ."'", "users");
			$a = mysql_fetch_array($sq);

			if($a['ally_id'] == $_GET['leader']) {
				$query = doquery("UPDATE {{table}} SET `ally_owner` = '". $_POST['leader'] ."' WHERE `id` = '" . $_GET['leader'] . "'",'alliance');
				AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_newleader_success'], $lang['alliancelist_success']);
			} else {
				AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">'.$lang['alliancelist_newleader_failed'], $lang['alliancelist_error']);
			}
		}
	}


	display(parsetemplate(gettemplate('admin/alliance_body'), $parse), $lang['alliancelist_title'], false, '', true);

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>