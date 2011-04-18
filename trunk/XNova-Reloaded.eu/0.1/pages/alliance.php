<?php

/**
 * alliance.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

$mode = $_GET['mode'];
if (empty($mode))   { unset($mode); }
$a     = intval($_GET['a']);
if (empty($a))      { unset($a); }
$sort1 = intval($_GET['sort1']);
if (empty($sort1))  { unset($sort1); }
$sort2 = intval($_GET['sort2']);
if (empty($sort2))  { unset($sort2); }
$d = $_GET['d'];
if ((!is_numeric($d)) || (empty($d) && $d != 0))
	unset($d);

$edit = $_GET['edit'];

if (empty($edit))
	unset($edit);

$rank = intval($_GET['rank']);
if (empty($rank))
	unset($rank);

$kick = intval($_GET['kick']);
if (empty($kick))
	unset($kick);

$id = intval($_GET['id']);
if (empty($id))
	unset($id);


$mode     = $_GET['mode'];
$yes      = $_GET['yes'];
$edit     = $_GET['edit'];
$allyid   = intval($_GET['allyid']);
$show     = intval($_GET['show']);
$sort     = intval($_GET['sort']);
$sendmail = intval($_GET['sendmail']);
$t        = $_GET['t'];
$a        = intval($_GET['a']);
$tag      = $_GET['tag'];

includeLang('alliance');


if ($_GET['mode'] == 'ainfo') { // Infos zur Ally /Allyseite
	$a = intval($_GET['a']);
	$tag = $_GET['tag'];

	if (isset($_GET['tag'])) { // Query wenn der Ally Tag angegeben wurde
		
		$Query = $DB->prepare("SELECT * FROM ".PREFIX."alliance WHERE ally_tag = :ally_tag");
		$Query->bindParam('ally_tag', $tag);
		$Query->execute();
		$allyrow = $Query->fetch();
	
	} elseif (is_numeric($a) && $a != 0) { // Query wenn die Ally ID gegeben wurde
	
		$Query = $DB->prepare("SELECT * FROM ".PREFIX."alliance WHERE id = :id");
		$Query->bindParam('id', $a);
		$Query->execute();
		$allyrow = $Query->fetch();
		
	} else {
		message($lang['ally_does_not_exist'], $lang['Alliance_information']);
	}
	
	if (!$allyrow) { // Wenn $allyrow leer ist gibts auch keine Allys
		message($lang['ally_does_not_exist'], $lang['Alliance_information']);
	}
	extract($allyrow);

	if ($ally_image != "") { // Wenn es ein Allylogo gibt...
		$ally_image = "<tr><th colspan=2><img src=\"{$ally_image}\" alt=\"{$ally_tag}\"></th></tr>"; // ... dann zeigs an
	}

	if ($ally_description != "") { // Wenns ne Beschreibung zur Ally gibt...
		$ally_description = "<tr><th colspan=2 height=100>{$ally_description}</th></tr>"; // ... zeig sie an
	} else
		$ally_description = "<tr><th colspan=2 height=100>".$lang['no_ally_discription']."</th></tr>"; // ansonsten zeige die Default Beschreibung

	if ($ally_web != "") {
		$ally_web = "<tr><th>{$lang['Initial_page']}</th><th><a href=\"{$ally_web}\" target=\"_blank\">{$ally_web}</a></th></tr>";
	}

	$lang['ally_member_scount'] = $ally_members;
	$lang['ally_name'] = stripslashes($ally_name);
	$lang['ally_tag'] = stripslashes($ally_tag);
	// BB Codes
	$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
	$replacements[] = '<font color="\1">\2</font>';
	$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
	$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
	$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
	$replacements[] = '<font color="\1">';
	$patterns[] = "#\[/f\]#Ssi";
	$replacements[] = '</font>';
	$ally_description = preg_replace($patterns, $replacements, $ally_description);

	$lang['ally_description'] = nl2br($ally_description);
	$lang['ally_image'] = $ally_image;
	$lang['ally_web'] = $ally_web;

	if ($user['ally_id'] == 0) { // wenn der User noch nicht in ner Ally ist ...
		$lang['bewerbung'] = "<tr>
	  <th>Bewerben</th>
	  <th><a href=\"?action=internalAlliance&amp;mode=apply&amp;allyid=" . $id . "\">".$lang['klick_to_apply']."</a></th></tr>";// ... kann er sich bewerben
	} else
		$lang['bewerbung'] = "";

	$page .= parsetemplate(gettemplate('alliance_ainfo'), $lang);
	display($page, str_replace('%s', $ally_name, $lang['Info_of_Alliance']));
}
// Ende des ainfo bereiches

if ($user['ally_id'] == 0) { // wenn der User noch nicht in ner Ally ist ...
	if ($mode == 'make' && $user['ally_request'] == 0) { // ... kann er eine erstellen (solange nicht noch eine Bewerbung steht)
		if ($yes == 1 && $_POST) { // wenn man auf "Erstellen" klickt
			
			if (!$_POST['atag']) {
				message($lang['have_not_tag'], $lang['make_alliance']);
			}
			if (!$_POST['aname']) {
				message($lang['have_not_name'], $lang['make_alliance']);
			}
			
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."alliance WHERE ally_tag = :ally_tag");
			$Query->bindParam('ally_tag', $_POST['atag']);
			$Query->execute();
			$tagquery = $Query->fetch();

			if ($tagquery) {
				message(str_replace('%s', $_POST['atag'], $lang['always_exist']), $lang['make_alliance']);
			}
			// Allianz in die Alliance Tabelle schreiben
			$Query = $DB->prepare("INSERT INTO `".PREFIX."alliance` SET 
			`ally_name`= :ally_name ,
			`ally_tag`= :ally_tag,
			`ally_owner`= :ally_owner,
			`ally_owner_range`='Leader',
			`ally_members`='1',
			`ally_register_time`= :time
			");
			$Query->bindParam('ally_name', $_POST['aname']);
			$Query->bindParam('ally_tag', $_POST['atag']);
			$Query->bindParam('ally_owner', $user['id']);
			$Query->bindParam('time' , time());
			$Query->execute();
			
			
			
			$Query = $DB->prepare("SELECT * FROM `".PREFIX."alliance` WHERE ally_tag = :ally_tag");
			$Query->bindParam('ally_tag', $_POST['atag']);
			$Query->execute();
			$allyquery = $Query->fetch();
			
			// Und anschließend den Leader in seine Ally schieben
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET
			`ally_id` = :ally_id,
			`ally_name` = :ally_name,
			`ally_register_time` = :time
			WHERE `id`= :id");
			$Query->bindParam('ally_id', $allyquery['id']);
			$Query->bindParam('ally_name', $allyquery['ally_name']);
			$Query->bindParam('time' , time());
			$Query->bindParam('id' , $user['id']);
			$Query->execute();

			

			$page = MessageForm(str_replace('%s', stripslashes($_POST['atag']), $lang['ally_maked']),

				str_replace('%s', stripslashes($_POST['atag']), $lang['alliance_has_been_maked']) . "<br><br>", "", $lang['Ok']);
		} else {
			$page .= parsetemplate(gettemplate('alliance_make'), $lang);
		}

		display($page, $lang['make_alliance']);
	}

	if ($mode == 'search' && $user['ally_request'] == 0) { // Allianz suchen
		
		$parse = $lang;
		$lang['searchtext'] = $_POST['searchtext'];
		$page = parsetemplate(gettemplate('alliance_searchform'), $lang);

		if ($_POST) { // Hier wird gesucht (ähnlich der Spieler / Ally Suche
			
				$searchtext = "%{$_POST['searchtext']}%";
				
				$Query = $DB->prepare("SELECT * FROM ".PREFIX."alliance WHERE ally_name LIKE :searchtext OR ally_tag LIKE :searchtext ");
				$Query->bindParam('searchtext', $searchtext);
				$Query->execute();
				$search = $Query;

				if (3 != 0) {
					$template = gettemplate('alliance_searchresult_row');

					while ($s = $search->fetch()) {
					 $entry = array();
					 $entry['ally_tag'] = "[<a href=\"?action=internalAlliance&amp;mode=apply&amp;allyid={$s['id']}\">{$s['ally_tag']}</a>]";
					 $entry['ally_name'] = $s['ally_name'];
					 $entry['ally_members'] = $s['ally_members'];

					$parse['result'] .= parsetemplate($template, $entry);
					}

				$page .= parsetemplate(gettemplate('alliance_searchresult_table'), $parse);
			}
		}

		display($page, $lang['search_alliance']);
	}

	if ($mode == 'apply' && $user['ally_request'] == 0) { // Wenn man sich bewerben will und nicht bereits eine Bewerbung am Laufen hat
	
		if (!is_numeric($_GET['allyid']) || !$_GET['allyid'] || $user['ally_request'] != 0 || $user['ally_id'] != 0) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}
		
		$Query = $DB->prepare("SELECT ally_tag,ally_request FROM ".PREFIX."alliance WHERE id = :id");
		$Query->bindParam('id', intval($_GET['allyid']));
		$Query->execute();
		$allyrow = $Query->fetch();
		
		if (!$allyrow) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}

		extract($allyrow);

		if ($_POST['further'] == $lang['Send']) { // Wird die Bewerbung abgeschickt, trage es bei dem User ein, dass er sich beworben hat
		
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
			ally_request = :allyid,
			ally_request_text = :text,
			ally_register_time = :time
			WHERE id = :userid");
			$Query->bindParam('allyid',$allyid);
			$Query->bindParam('text',$_POST['text']);
			$Query->bindParam('time',time());
			$Query->bindParam('userid',$user['id']);
			$Query->execute();
		
			message($lang['apply_registered'], $lang['your_apply']);
			
		} else {
			$text_apply = ($ally_request) ? $ally_request : $lang['There_is_no_a_text_apply']; // 
		}

		$parse = $lang;
		$parse['allyid'] = intval($_GET['allyid']);
		$parse['chars_count'] = strlen($text_apply);
		$parse['text_apply'] = $text_apply;
		$parse['Write_to_alliance'] = str_replace('%s', $ally_tag, $lang['Write_to_alliance']);

		$page = parsetemplate(gettemplate('alliance_applyform'), $parse);

		display($page, $lang['Write_to_alliance']);
	}

	if ($user['ally_request'] != 0) { // Wenn man sich bereits irgendwo beworben hat
		
		
		$Query = $DB->prepare("SELECT ally_tag FROM ".PREFIX."alliance WHERE id = :ally_request ORDER BY id");
		$Query->bindParam('ally_request',$user['ally_request']);
		$Query->execute();
		$allyquery = $Query->fetch();

		extract($allyquery);
		
		if ($_POST['bcancel']) { // Wenn man die Bewerbung abbricht
		
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET ally_request = 0 WHERE id = :userid");
			$Query->bindParam('userid',$user['id']);
			$Query->execute();
			
			//Lösche sie aus der Datenbank

			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Canceled_a_request_text']);
			$lang['button_text'] = $lang['Ok'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		} else {
			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Waiting_a_request_text']);
			$lang['button_text'] = $lang['Delete_apply'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		}
		display($page, "Deine Anfrage");
	} else { 
	
		$page .= parsetemplate(gettemplate('alliance_defaultmenu'), $lang);
		display($page, $lang['alliance']);
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------------
// Innerhalb einer Ally
elseif ($user['ally_id'] != 0 && $user['ally_request'] == 0) {
	// Abfrage der Allyrow
	/*
array(1 =>
	'name' => 'Co. Leader',
	'mails' => '1',
	'delete' => '0',
	'kick' => '1',
	'bewerbungen' => '1',
	'administrieren' => '1',
	'memberlist' => '1',
	'bewerbungenbearbeiten' => '1',
	'onlinestatus' => '1',
	'rechtehand' => '1'
	);

*/
// Allianz Ränge

	$Query = $DB->prepare("SELECT * FROM ".PREFIX."alliance WHERE id = :user_ally_id");
	$Query->bindParam('user_ally_id',$user['ally_id']);
	$Query->execute();
	$ally = $Query->fetch();
	
	$ally_ranks = unserialize($ally['ally_ranks']); //erstmal entpacken

	$allianz_raenge = unserialize($ally['ally_ranks']); 

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist_status = true;
	} else
		$user_can_watch_memberlist_status = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['memberlist'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist = true;
	} else
		$user_can_watch_memberlist = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['mails'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_send_mails = true;
	} else
		$user_can_send_mails = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['kick'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_kick = true;
	} else
		$user_can_kick = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['rechtehand'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_edit_rights = true;
	else
		$user_can_edit_rights = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['delete'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_exit_alliance = true;
	else
		$user_can_exit_alliance = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungen'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_einsehen = true;
	else
		$user_bewerbungen_einsehen = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_bearbeiten = true;
	else
		$user_bewerbungen_bearbeiten = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_admin = true;
	else
		$user_admin = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_onlinestatus = true;
	else
		$user_onlinestatus = false;

	if (!$ally) { // wenn die Ally nicht mehr existiert
	
	$Query = $DB->prepare("UPDATE ".PREFIX."users SET ally_id = 0 WHERE id = :userid");
	$Query->bindParam('userid',$user['id']);
	$Query->execute();
	
		message($lang['ally_notexist'], $lang['your_alliance'], '?action=internalAlliance');
	}

	if ($mode == 'exit') { // Ally verlassen bzw auflösen (sofern man der Leader ist)
		if ($ally['ally_owner'] == $user['id']) {
			message($lang['Owner_cant_go_out'], $lang['Alliance']); // wobei der Leader nicht auf diese Weise raus kann
		}
		// für den normalen User
		if ($_GET['yes'] == 1) {
			
			// ihm keine Ally mehr zuweisen
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET ally_id = 0, ally_name = '' WHERE id = :userid");
			$Query->bindParam('userid',$user['id']);
			$Query->execute();
			
			// Member der Ally um eins reduzieren (Statistik)
			$Query = $DB->prepare("UPDATE ".PREFIX."statpoints SET id_ally = 0 WHERE id_owner = :userid");
			$Query->bindParam('userid',$user['id']);
			$Query->execute();
			
			// und hier in der Allianz selber
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET `ally_members` = `ally_members` -1 WHERE id = :allyid");
			$Query->bindParam('allyid',$ally['id']);
			$Query->execute();
			
			$lang['Go_out_welldone'] = str_replace("%s", stripslashes($ally_name), $lang['Go_out_welldone']);
			$page = MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['Ok']);
		} else {
			// Abfragen, ob man wirklich austreten will
			$lang['Want_go_out'] = str_replace("%s", stripslashes($ally_name), $lang['Want_go_out']);
			$page = MessageForm($lang['Want_go_out'], "<br>", "?mode=exit&yes=1", "Ja");
			$page .= "<center><table width=\"700\"><tr><td class =\"c\" height=\"21\"><a href=\"?action=internalAlliance\">".$lang['Back']."</a></td></tr></table></center>";
		}
		display($page);
	}

	if ($mode == 'memberslist') { // Mitgliederliste
		
		$allianz_raenge = unserialize($ally['ally_ranks']);
		
		if ($ally['ally_owner'] != $user['id'] && !$user_can_watch_memberlist) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
		// Art der Sortierung
		if ($sort2) {
			$sort1 = intval($_GET['sort1']);
			$sort2 = intval($_GET['sort2']);

			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 3) {
				$sort = " ORDER BY `points`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			
			// Und entsprechend aus der DB auslesen
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE ally_id = :allyid {$sort}");
			$Query->bindParam('allyid',$user['ally_id']);
			$Query->execute();
			$listuser = $Query;
			
		} else {
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE ally_id = :allyid");
			$Query->bindParam('allyid',$user['ally_id']);
			$Query->execute();
			$listuser = $Query;
		}
		// Zähler für die Mitglieder
		$i = 0;
		
		$template = gettemplate('alliance_memberslist_row');
		$page_list = '';
		while ($u = $listuser->fetch()) {
			
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."statpoints WHERE
			stat_type = '1' AND
			stat_code = '1' AND
			id_owner = :userid
			");
			$Query->bindParam('userid',$u['id']);
			$Query->execute();
			$UserPoints = $Query->fetch();
			
			$i++;
			$u['i'] = $i;

			if ($u["onlinetime"] + 60 * 10 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "lime>{$lang['On']}<";
			} elseif ($u["onlinetime"] + 60 * 20 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "yellow>{$lang['15_min']}<";
			} elseif ($user_can_watch_memberlist_status) {
				$u["onlinetime"] = "red>{$lang['Off']}<";
			} else $u["onlinetime"] = "orange>-<";
			// Rangnamen
			if ($ally['ally_owner'] == $u['id']) {
				$u["ally_range"] = ($ally['ally_owner_range'] == '')?"Leader":$ally['ally_owner_range'];
			} elseif (isset($allianz_raenge[$u['ally_rank_id']]['name'])) {
				$u["ally_range"] = $allianz_raenge[$u['ally_rank_id']]['name'];
			} else {
				$u["ally_range"] = $lang['Novate'];
			}

			$u["dpath"] = $dpath;
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";

			if ($u['ally_register_time'] > 0)
				$u['ally_register_time'] = date("d-m-Y h:i:s", $u['ally_register_time']);
			else
				$u['ally_register_time'] = "-";

			$page_list .= parsetemplate($template, $u);
		}
		// Sortierung
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
		
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET `ally_members` = :i WHERE id = :allyid");
			$Query->bindParam('i', $i);
			$Query->bindParam('allyid',$ally['id']);
			$Query->execute();
		}

		$parse = $lang;
		$parse['i'] = $i;
		$parse['s'] = $s;
		$parse['list'] = $page_list;

		$page .= parsetemplate(gettemplate('alliance_memberslist_table'), $parse);

		display($page, $lang['Members_list']);
	}

	if ($mode == 'circular') { // Rundmails
		
		$allianz_raenge = unserialize($ally['ally_ranks']);
		// Berechtigungen überprüfen
		if ($ally['ally_owner'] != $user['id'] && !$user_can_send_mails) {
			message($lang['Denied_access'], $lang['Send_circular_mail']);
		}

		if ($sendmail == 1) {
			$_POST['r'] = intval($_POST['r']);
			$_POST['text'] = strip_tags($_POST['text']);

			if ($_POST['r'] == 0) {
			
				$Query = $DB->prepare("SELECT id, username FROM ".PREFIX."users WHERE ally_id = :allyid");
				$Query->bindParam('allyid',$user['ally_id']);
				$Query->execute();
				$sq = $Query;
			} else {
			
				$Query = $DB->prepare("SELECT id, username FROM ".PREFIX."users WHERE ally_id = :allyid AND ally_rank_id = :r");
				$Query->bindParam('allyid',$user['ally_id']);
				$Query->bindParam('r', $_POST['r']);
				$Query->execute();
				$sq = $Query;
			}
			// looooooop
			$list = '';
			while ($u = $sq->fetch()) {
			
				$Query = $DB->prepare("INSERT INTO ".PREFIX."messages SET
				`message_owner`= :owner ,
				`message_sender`= :sender ,
				`message_time`= :time ,
				`message_type`='2',
				`message_from`= :from ,
				`message_subject`= :subject ,
				`message_text`= :text
				");
				
				$Query->bindParam('owner', $u['id']);
				$Query->bindParam('sender', $user['id']);
				$Query->bindParam('time', time());
				$Query->bindParam('from', $user['username']);
				$Query->bindParam('subject', $_POST['subject'] );
				$Query->bindParam('text', $_POST['text']);
				$Query->execute();
				
				$list .= "<br>{$u['username']} ";
			}
			
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET `new_message`=new_message+1 WHERE
			ally_id= = :allyid AND
			ally_rank_id = :r
			");
			$Query->bindParam('allyid',$user['ally_id']);
			$Query->bindParam('r', $_POST['r']);
			$Query->execute();
			
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET `mnl_alliance`=mnl_alliance+1 WHERE
			ally_id= = :allyid AND
			ally_rank_id = :r
			");
			$Query->bindParam('allyid',$user['ally_id']);
			$Query->bindParam('r', $_POST['r']);
			$Query->execute();
			
			// Info das die Nachricht verschickt wurde
			
			$page = MessageForm($lang['Circular_sended'], $lang['members_got_a_message'] . $list, "?action=internalAlliance", $lang['Ok'], true);
			display($page, $lang['Send_circular_mail']);
		}

		$lang['r_list'] = "<option value=\"0\">{$lang['All_players']}</option>";
		if ($allianz_raenge) {
			foreach($allianz_raenge as $id => $array) {
				$lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
			}
		}

		$page .= parsetemplate(gettemplate('alliance_circular'), $lang);

		display($page, $lang['Send_circular_mail']);
	}

	if ($mode == 'admin' && $edit == 'rights') { // Administrativer Bereich
		$allianz_raenge = unserialize($ally['ally_ranks']);

		if ($ally['ally_owner'] != $user['id'] && !$user_can_edit_rights) { // Nur wenn man der Leader ist, oder die entsprechenden Rechte hat, darf man rein
			message($lang['Denied_access'], $lang['Members_list']);
		} elseif (!empty($_POST['newrangname'])) {
			$name = strip_tags($_POST['newrangname']);

			$allianz_raenge[] = array('name' => $name,
				'mails' => 0,
				'delete' => 0,
				'kick' => 0,
				'bewerbungen' => 0,
				'administrieren' => 0,
				'bewerbungenbearbeiten' => 0,
				'memberlist' => 0,
				'onlinestatus' => 0,
				'rechtehand' => 0
				);

			$ranks = serialize($allianz_raenge);
			
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_ranks = :rank WHERE id = :allyid");
			$Query->bindParam('rank', $ranks);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();


			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		} elseif ($_POST['id'] != '' && is_array($_POST['id'])) {
			$ally_ranks_new = array();

			foreach ($_POST['id'] as $id) {
				$name = $allianz_raenge[$id]['name'];

				$ally_ranks_new[$id]['name'] = $name;

				if (isset($_POST['u' . $id . 'r0'])) {
					$ally_ranks_new[$id]['delete'] = 1;
				} else {
					$ally_ranks_new[$id]['delete'] = 0;
				}

				if (isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $user['id']) {
					$ally_ranks_new[$id]['kick'] = 1;
				} else {
					$ally_ranks_new[$id]['kick'] = 0;
				}

				if (isset($_POST['u' . $id . 'r2'])) {
					$ally_ranks_new[$id]['bewerbungen'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungen'] = 0;
				}

				if (isset($_POST['u' . $id . 'r3'])) {
					$ally_ranks_new[$id]['memberlist'] = 1;
				} else {
					$ally_ranks_new[$id]['memberlist'] = 0;
				}

				if (isset($_POST['u' . $id . 'r4'])) {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 0;
				}

				if (isset($_POST['u' . $id . 'r5'])) {
					$ally_ranks_new[$id]['administrieren'] = 1;
				} else {
					$ally_ranks_new[$id]['administrieren'] = 0;
				}

				if (isset($_POST['u' . $id . 'r6'])) {
					$ally_ranks_new[$id]['onlinestatus'] = 1;
				} else {
					$ally_ranks_new[$id]['onlinestatus'] = 0;
				}

				if (isset($_POST['u' . $id . 'r7'])) {
					$ally_ranks_new[$id]['mails'] = 1;
				} else {
					$ally_ranks_new[$id]['mails'] = 0;
				}

				if (isset($_POST['u' . $id . 'r8'])) {
					$ally_ranks_new[$id]['rechtehand'] = 1;
				} else {
					$ally_ranks_new[$id]['rechtehand'] = 0;
				}
			}

			$ranks = serialize($ally_ranks_new); // Ränge packen und in die DB schreiben
			
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_ranks = :rank WHERE id = :allyid");
			$Query->bindParam('rank', $ranks);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();

			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		}
		// Ränge löschen
		elseif (isset($d) && isset($ally_ranks[$d])) {
			unset($ally_ranks[$d]);
			$ally['ally_rank'] = serialize($ally_ranks);
			
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_ranks = :rank WHERE id = :allyid");
			$Query->bindParam('rank', $ally['ally_rank']);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();
		}

		if (count($ally_ranks) == 0 || $ally_ranks == '') { // wenns keine Ränge gibt
			$list = "<tr><th>{$lang['There_is_not_range']}</th></tr>"; // dann sag das dem Leader
		} else { // ansonsten 
			// lade das Template
			$list = parsetemplate(gettemplate('alliance_admin_laws_head'), $lang);
			$template = gettemplate('alliance_admin_laws_row');
			
			$i = 0;

			foreach($ally_ranks as $a => $b) {
				if ($ally['ally_owner'] == $user['id']) {
					// $i++;u2r5
					$lang['id'] = $a;
					$lang['delete'] = "<a href=\"?action=internalAlliance&amp;mode=admin&amp;edit=rights&amp;d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_apply']}\" border=0></a>";
					$lang['r0'] = $b['name'];
					$lang['a'] = $a;
					$lang['r1'] = "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1)?' checked="checked"':'') . ">"; //{$b[1]}
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				} else {
					$lang['id'] = $a;
					$lang['r0'] = $b['name'];
					$lang['delete'] = "<a href=\"?action=internalAlliance&amp;mode=admin&amp;edit=rights&amp;d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_apply']}\" border=0></a>";
					$lang['a'] = $a;
					$lang['r1'] = "<b>-</b>";
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				}
			}

			if (count($ally_ranks) != 0) {
				$list .= parsetemplate(gettemplate('alliance_admin_laws_feet'), $lang);
			}
		}

		$lang['list'] = $list;
		$lang['dpath'] = $dpath;
		$page .= parsetemplate(gettemplate('alliance_admin_laws'), $lang);

		display($page, $lang['Law_settings']);
	}

	if ($mode == 'admin' && $edit == 'ally') { // Allianz bearbeiten
		if ($t != 1 && $t != 2 && $t != 3) {
			$t = 1;
		}
		// post!
		if ($_POST) {
			if (!get_magic_quotes_gpc()) {
				$_POST['owner_range'] = stripslashes($_POST['owner_range']);
				$_POST['web'] = stripslashes($_POST['web']);
				$_POST['image'] = stripslashes($_POST['image']);
				$_POST['text'] = stripslashes($_POST['text']);
			}
		}

		if ($_POST['options']) {
			$ally['ally_owner_range'] = htmlspecialchars(strip_tags($_POST['owner_range']));

			$ally['ally_web'] = htmlspecialchars(strip_tags($_POST['web']));

			$ally['ally_image'] = htmlspecialchars(strip_tags($_POST['image']));

			$ally['ally_request_notallow'] = intval($_POST['request_notallow']);

			if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1) {
				message($lang['pick_option'], $lang['error']);
				exit;
			}
			
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET 
			`ally_owner_range`= :ally_owner_range,
			`ally_image`= :ally_image,
			`ally_web`= :ally_web,
			`ally_request_notallow`= :ally_request_notallow
			WHERE id = :allyid
			");
			$Query->bindParam('ally_owner_range', $ally['ally_owner_range']);
			$Query->bindParam('ally_image', $ally['ally_image']);
			$Query->bindParam('ally_web', $ally['ally_web']);
			$Query->bindParam('ally_request_notallow', $ally['ally_request_notallow']);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();
			
		} elseif ($_POST['t']) {
			if ($t == 3) {
				$ally['ally_request'] = strip_tags($_POST['text']);

				$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_request = :request WHERE id = :allyid");
				$Query->bindParam('request', $ally['ally_request']);
				$Query->bindParam('allyid', $ally['id']);
				$Query->execute();
				
				
			} elseif ($t == 2) {
				$ally['ally_text'] = strip_tags($_POST['text']);
				
				$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_text = :text WHERE id = :allyid");
				$Query->bindParam('text', $ally['ally_text']);
				$Query->bindParam('allyid', $ally['id']);
				$Query->execute();
				
			} else {
				$ally['ally_description'] = strip_tags($_POST['text']);
				
				$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_description = :description WHERE id = :allyid");
				$Query->bindParam('description', $ally['ally_description']);
				$Query->bindParam('allyid', $ally['id']);
				$Query->execute();
			}
		}
		$lang['dpath'] = $dpath;
		
		if ($t == 3) {
			$lang['request_type'] = $lang['Show_of_request_text'];
		} elseif ($t == 2) {
			$lang['request_type'] = $lang['Internal_text_of_alliance'];
		} else {
			$lang['request_type'] = $lang['Public_text_of_alliance'];
		}

		if ($t == 2) {
			$lang['text'] = stripslashes($ally['ally_text']);
			$lang['Texts'] = "Interner Text";
			$lang['Show_of_request_text'] = "Internet Allianz Text";
		} else {
			$lang['text'] = stripslashes($ally['ally_description']);
		}

		if ($t == 3) {
		}
		$lang['t'] = $t;

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_image'] = $ally['ally_image'];
		$lang['ally_request_notallow_0'] = (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
		$lang['ally_request_notallow_1'] = (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
		$lang['ally_owner_range'] = $ally['ally_owner_range'];
		$lang['Transfer_alliance'] = MessageForm($lang['transfer_ally'], "", "?action=internalAlliance&amp;mode=admin&amp;edit=give", $lang['Continue']);
		$lang['Disolve_alliance'] = MessageForm($lang['disolve_ally'], "", "?action=internalAlliance&amp;mode=admin&amp;edit=exit", $lang['Continue']);

		$page .= parsetemplate(gettemplate('alliance_admin'), $lang);
		display($page, $lang['Alliance_admin']);
	}

	if ($mode == 'admin' && $edit == 'members') { // Mitgliederliste 
		
		// Rechte zum Kicken abfragen
		if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		
		if (isset($kick)) {
			if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
				message($lang['Denied_access'], $lang['Members_list']);
			}

			
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE id = :kick LIMIT 1");
			$Query->bindParam('kick', $kick);
			$Query->execute();
			$u = $Query->fetch();
			
			// Kicken
			if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner']) {
			
				$Query = $DB->prepare("UPDATE ".PREFIX."users SET  ally_id = 0  WHERE `id`= :id");
				$Query->bindParam('id', $u['id']);
				$Query->execute();
				
				$Query = $DB->prepare("UPDATE ".PREFIX."statpoints SET  id_ally = 0  WHERE `id_owner`= :id_owner");
				$Query->bindParam('id_owner', $u['id']);
				$Query->execute();
				
				$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET  ally_members = ally_members - 1  WHERE `id`= :id");
				$Query->bindParam('id', $ally['id']);
				$Query->execute();
			}
		} elseif (isset($_POST['newrang'])) {
		
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE `id`= :id LIMIT 1");
			$Query->bindParam('id', $u);
			$Query->execute();
			$q = $Query->fetch();
			
			if ((isset($ally_ranks[$_POST['newrang']-1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner']) {
			
				$Query = $DB->prepare("UPDATE ".PREFIX."users SET ally_rank_id = :newrang WHERE `id`= :id LIMIT 1");
				$Query->bindParam('newrang', $_POST['newrang']);
				$Query->bindParam('id', $id);
				$Query->execute();
			
			}
		}
		
		$template = gettemplate('alliance_admin_members_row');
		$f_template = gettemplate('alliance_admin_members_function');
		// Sortierung
		if ($sort2) {
		
			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 3) {
				$sort = " ORDER BY `points_planets`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE ally_id = :allyid {$sort}");
			$Query->bindParam('allyid', $user['ally_id']);
			$Query->execute();
			$listuser = $Query;
		} else {
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE ally_id = :allyid");
			$Query->bindParam('allyid', $user['ally_id']);
			$Query->execute();
			$listuser = $Query;
		}
		// Mitglieder zähl Variable
		$i = 0;
		// Template laden
		$page_list = '';
		
		$Query = $DB->prepare("SELECT * FROM ".PREFIX."users WHERE ally_id = :allyid");
		$Query->bindParam('allyid', $user['ally_id']);
		$Query->execute();
		$countuser = $Query;
		$lang['memberzahl'] = sql_num_rows($countuser);

		while ($u = $listuser->fetch()) {
			
			$Query = $DB->prepare("SELECT * FROM ".PREFIX."statpoints WHERE 
			`stat_type` = '1' AND
			`stat_code` = '1' AND
			`id_owner` = :id
			");
			$Query->bindParam('id', $u['id']);
			$Query->execute();
			$UserPoints = $Query->fetch();
			
			$i++;
			$u['i'] = $i;
			// Inaktivität
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";
			
			$u["onlinetime"] = pretty_time(time() - $u["onlinetime"]);
			// Rangnamen
			if ($ally['ally_owner'] == $u['id']) {
				$ally_range = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
			} elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])) {
				$ally_range = $lang['Novate'];
			} else {
				$ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];
			}

			if ($ally['ally_owner'] == $u['id'] || $rank == $u['id']) {
				$u["functions"] = '';
			} elseif ($ally_ranks[$user['ally_rank_id']-1][5] == 1 || $ally['ally_owner'] == $user['id']) {
				$f['dpath'] = $dpath;
				$f['Expel_user'] = $lang['Expel_user'];
				$f['Set_range'] = $lang['Set_range'];
				$f['You_are_sure_want_kick_to'] = str_replace("%s", $u['username'], $lang['You_are_sure_want_kick_to']);
				$f['id'] = $u['id'];
				$u["functions"] = parsetemplate($f_template, $f);
			} else {
				$u["functions"] = '';
			}
			$u["dpath"] = $dpath;
			
			if ($rank != $u['id']) {
				$u['ally_range'] = $ally_range;
			} else {
				$u['ally_range'] = '';
			}
			$u['ally_register_time'] = date("d-m-Y h:i:s", $u['ally_register_time']);
			$page_list .= parsetemplate($template, $u);
			if ($rank == $u['id']) {
				$r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
				$r['options'] .= "<option value=\"0\">{$lang['Novate']}</option>";

				foreach($ally_ranks as $a => $b) {
					$r['options'] .= "<option value=\"" . ($a + 1) . "\"";
					if ($u['ally_rank_id']-1 == $a) {
						$r['options'] .= ' selected=selected';
					}
					$r['options'] .= ">{$b['name']}</option>";
				}
				$r['id'] = $u['id'];
				$r['Save'] = $lang['Save'];
				$page_list .= parsetemplate(gettemplate('alliance_admin_members_row_edit'), $r);
			}
		}
		// Sortierung
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
		
			$Query = $DB->prepare("Update ".PREFIX."alliance SET ally_members = :i WHERE id = :allyid");
			$Query->bindParam('i', $i);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();
		}

		$lang['memberslist'] = $page_list;
		$lang['s'] = $s;
		$page .= parsetemplate(gettemplate('alliance_admin_members_table'), $lang);

		display($page, $lang['Members_administrate']);
	}


	if ($mode == 'admin' && $edit == 'requests') { // Bewerbungen (Leader)
		if ($ally['ally_owner'] != $user['id'] && !$user_bewerbungen_bearbeiten) {
			message($lang['Denied_access'], $lang['Check_the_requests']);
		}

		if ($_POST['action'] == "Akzeptieren") { // neues Mitgleid aufnehmen
			$_POST['text'] = strip_tags($_POST['text']);
			
			$Query = $DB->prepare("SELECT * FROM".PREFIX."users WHERE id = :show");
			$Query->bindParam('show', $show);
			$Query->execute();
			$u = $Query->fetch();

			// Anzahl der Member um 1 erhöhen
			
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_members=ally_members+1 WHERE id = :allyid");
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();
			
			// Den user der Ally hinzufügen
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
			ally_name= :ally_name,
			ally_request_text='',
			ally_request='0',
			ally_id= :allyid,
			new_message=new_message+1,
			mnl_alliance=mnl_alliance+1 
			WHERE id = :show");
			$Query->bindParam('ally_name', $ally['ally_name']);
			$Query->bindParam('allyid', $ally['id']);
			$Query->bindParam('show', $show);
			$Query->execute();
			
			
			$subject = "[" . stripslashes($ally['ally_name']) . "] ".$lang['accepted1'];
			$text = $lang['accepted2'] . stripslashes($ally['ally_name']) . $lang['accepted3'] . $_POST['text'];
			
			// und ihm ne nachricht senden das er aufgenommen wurde
			$Query = $DB->prepare("INSERT INTO ".PREFIX."messages SET
			message_owner = :owner,
			message_sender = :sender,
			message_time = :time,
			message_type = 2,
			message_from = :from,
			message_subject = :subject,
			message_text =:text
			");
			$Query->bindParam('owner', $show);
			$Query->bindParam('sender', $user['id']);
			$Query->bindParam('time', time());
			$Query->bindParam('from', $ally['ally_tag']);
			$Query->bindParam('subject', $subject);
			$Query->bindParam('text', $text);
			$Query->execute();
			
			header('Location:?action=internalAlliance&amp;mode=admin&amp;edit=requests');
			die();

		} elseif ($_POST['action'] == "Ablehnen" && $_POST['action'] != '') { // wenn man ihn ablehnt
			$_POST['text'] = strip_tags($_POST['text']);
			
			// den request auf 0 setzen
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
			ally_request_text='',
			ally_request='0',
			ally_id='0',
			new_message=new_message+1,
			mnl_alliance=mnl_alliance+1
			WHERE id = :show");
			$Query->bindParam('show', $show);
			$Query->execute();

			// User ne Nachricht schicken das er abgelehnt wurde
			
			$subject = "[" . stripslashes($ally['ally_name']) . "] ".$lang['rejected1'];
			$text = $lang['rejected2'] . stripslashes($ally['ally_name']) . $lang['rejected3'] . $_POST['text'];
			
			$Query = $DB->prepare("INSERT INTO ".PREFIX."messages SET
			message_owner = :owner,
			message_sender = :sender,
			message_time = :time,
			message_type = 2,
			message_from = :from,
			message_subject = :subject,
			message_text =:text
			");
			$Query->bindParam('owner', $show);
			$Query->bindParam('sender', $user['id']);
			$Query->bindParam('time', time());
			$Query->bindParam('from', $ally['ally_tag']);
			$Query->bindParam('subject', $subject);
			$Query->bindParam('text', $text);
			$Query->execute();
			
			header('Location:?action=internalAlliance&amp;mode=admin&amp;edit=requests');
			die();
		}

		$row = gettemplate('alliance_admin_request_row');
		$i = 0;
		$parse = $lang;
		
		$Query = $DB->prepare("SELECT id, username, ally_request_text ,ally_register_time FROM ".PREFIX."users WHERE ally_request = :allyid");
		$Query->bindParam('allyid', $ally['id']);
		$Query->execute();
		$query = $Query;
		
		while ($r = $query->fetch()) {
			
			if (isset($show) && $r['id'] == $show) {
				$s['username'] = $r['username'];
				$s['ally_request_text'] = nl2br($r['ally_request_text']);
				$s['id'] = $r['id'];
			}
			// Datum der Allianz gründung
			$r['time'] = date("d-m-Y h:i:s", $r['ally_register_time']);
			$parse['list'] .= parsetemplate($row, $r);
			$i++;
		}
		if ($parse['list'] == '') {
			$parse['list'] = "<tr><th colspan=2>".$lang['no_apply_for_you']."</th></tr>";
		}
		// 
		if (isset($show) && $show != 0 && $parse['list'] != '') {
			
			$s['Request_from'] = str_replace('%s', $s['username'], $lang['Request_from']);
			
			$parse['request'] = parsetemplate(gettemplate('alliance_admin_request_form'), $s);
			$parse['request'] = parsetemplate($parse['request'], $lang);
		} else {
			$parse['request'] = '';
		}

		$parse['ally_tag'] = $ally['ally_tag'];
		$parse['Back'] = $lang['Back'];

		$parse['There_is_hanging_request'] = str_replace('%n', $i, $lang['There_is_hanging_request']);
		
		$page = parsetemplate(gettemplate('alliance_admin_request_table'), $parse);
		display($page, $lang['Check_the_requests']);
	}

	if ($mode == 'admin' && $edit == 'name') {
		 // Allianz Namen ändern

		$ally_ranks = unserialize($ally['ally_ranks']);
		// Berechtigungen prüfen
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newname']) {
			// Neuer Name
			$ally['ally_name'] = strip_tags($_POST['newname']);
			
			//Ally Tabelle...
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_name = :allyname WHERE id = :allyid");
			$Query->bindParam('allyname', $ally['ally_name']);
			$Query->bindParam('allyid', $user['ally_id']);
			$Query->execute();
			
			// ... und User Tabelle updaten
			$Query = $DB->prepare("UPDATE ".PREFIX."users SET ally_name = :allyname WHERE ally_id = :allyid");
			$Query->bindParam('allyname', $ally['ally_name']);
			$Query->bindParam('allyid', $ally['id']);
			$Query->execute();
		}

		$parse['question']           = $lang['Change_the_ally_name'];
		$parse['New_name']           = $lang['New_name'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newname';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page, $lang['Alliance_admin']);

	}

	if ($mode == 'admin' && $edit == 'tag') {
		// Allianz Tag ändern
		$ally_ranks = unserialize($ally['ally_ranks']);

		// Rechte überprüfen
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newtag']) {
			// Neuer Tag
			$ally['ally_tag'] = strip_tags($_POST['newtag']);
			
			// Tabelle Updaten
			$Query = $DB->prepare("UPDATE ".PREFIX."alliance SET ally_tag = :allytag WHERE id = :allyid");
			$Query->bindParam('allytag', $ally['ally_tag']);
			$Query->bindParam('allyid', $user['ally_id']);
			$Query->execute();
		}

		$parse['question']           = $lang['Change_the_ally_tag'];
		$parse['New_name']           = $lang['New_tag'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newtag';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page, $lang['Alliance_admin']);
	}

	if ($mode == 'admin' && $edit == 'exit') { // Allianz auflösen
		// 
		$ally_ranks = unserialize($ally['ally_ranks']);
		// Rechte überprüfen
		if ($ally['ally_owner'] != $user['id'] && !$user_can_exit_alliance) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
	
		$Query = $DB->prepare("DELETE FROM ".PREFIX."alliance WHERE id = :allyid");
		$Query->bindParam('allyid', $ally['id']);
		$Query->execute();
		
		$Query = $DB->prepare("UPDATE ".PREFIX."users SET 
		ally_name = '', 
		ally_request_text = '', 
		ally_request = '0', 
		ally_id = '0', 
		ally_rank_id = '0'
		WHERE
		id = :id
		");
		$Query->bindParam('id', $user['id']);
		$Query->execute();
		
		$Query = $DB->prepare("UPDATE ".PREFIX."statpoints SET id_ally = '0' WHERE id_owner = :id");
		$Query->bindParam('id', $user['id']);
		$Query->execute();
		
		header('Location: ?action=internalAlliance');
		exit;
	}
	{

		if ($ally['ally_owner'] != $user['id']) {
			$ally_ranks = unserialize($ally['ally_ranks']);
		}
		// Ally Logo
		if ($ally['ally_ranks'] != '') {
			$ally['ally_ranks'] = "<tr><td colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>";
		}
		
		if ($ally['ally_owner'] == $user['id']) {
			$range = ($ally['ally_owner_range'] != '')?$lang['Founder']:$ally['ally_owner_range'];
		} elseif ($user['ally_rank_id'] != 0 && isset($ally_ranks[$user['ally_rank_id']-1]['name'])) {
			$range = $ally_ranks[$user['ally_rank_id']-1]['name'];
		} else {
			$range = $lang['member'];
		}
		// Link zur Memberliste
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['memberlist'] != 0) {
			$lang['members_list'] = " (<a href=\"?action=internalAlliance&amp;mode=memberslist\">{$lang['Members_list']}</a>)";
		} else {
			$lang['members_list'] = '';
		}
		// Link zur Allianzverwaltung
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['administrieren'] != 0) {
			$lang['alliance_admin'] = " (<a href=\"?action=internalAlliance&amp;mode=admin&amp;edit=ally\">{$lang['Alliance_admin']}</a>)";
		} else {
			$lang['alliance_admin'] = '';
		}
		// Link für Rundmails
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['mails'] != 0) {
			$lang['send_circular_mail'] = "<tr><th>{$lang['Circular_message']}</th><th><a href=\"?action=internalAlliance&amp;mode=circular\">{$lang['Send_circular_mail']}</a></th></tr>";
		} else {
			$lang['send_circular_mail'] = '';
		}
		
		$lang['requests'] = '';
		// Requests auslesen
		$Query = $DB->prepare("SELECT id FROM ".PREFIX."users WHERE ally_request = :id");
		$Query->bindParam('id', $ally['id']);
		$Query->execute();
		$request = $Query;
		
		$request_count = sql_num_rows($request);
		if ($request_count != 0) {
			if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['bewerbungen'] != 0)
				$lang['requests'] = "<tr><th>{$lang['Requests']}</th><th><a href=\"?action=internalAlliance&amp;mode=admin&amp;edit=requests\">{$request_count} {$lang['XRequests']}</a></th></tr>";
		}
		if ($ally['ally_owner'] != $user['id']) {
			$lang['ally_owner'] .= MessageForm($lang['Exit_of_this_alliance'], "", "?action=internalAlliance&amp;mode=exit", $lang['Continue']);
		} else {
			$lang['ally_owner'] .= '';
		}
		// Ally Logo
		$lang['ally_image'] = ($ally['ally_image'] != '')?
		"<tr><th colspan=2><img src=\"{$ally['ally_image']}\" alt=\"{".stripslashes($ally['ally_name'])."}\"></th></tr>":'';
		
		$lang['range'] = $range;
		// BB Codes
		$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
		$replacements[] = '<font color="\1">\2</font>';
		$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
		$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
		$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
		$replacements[] = '<font color="\1">';
		$patterns[] = "#\[/f\]#Ssi";
		$replacements[] = '</font>';
		$ally['ally_description'] = preg_replace($patterns, $replacements, $ally['ally_description']);
		$lang['ally_description'] = nl2br(stripslashes($ally['ally_description']));

		$ally['ally_text'] = preg_replace($patterns, $replacements, $ally['ally_text']);
		$lang['ally_text'] = nl2br(stripslashes($ally['ally_text']));

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_tag'] = stripslashes($ally['ally_tag']);
		$lang['ally_members'] = $ally['ally_members'];
		$lang['ally_name'] = stripslashes($ally['ally_name']);

	display(parsetemplate(gettemplate('alliance_frontpage'), $lang), $lang['your_alliance']);
	}
}
?>