<?php


function ShowSupportPage($user){

	global $lang;

	$parse     = $lang;

	if(($_GET['ticket']) == 0){

			$query = doquery("SELECT * FROM {{table}} WHERE `player_id` = '".$user['id']."'", "supp");
			while($ticket = mysql_fetch_array($query)){
			
				switch($ticket['status']){
					case 0:
					$status = "<font color=red>Geschlossen</font>";
					$parse['answer_new'] = 'Ticket Geschlossen';
					break;
					case 1:
					$parse['eintrag'] ='<textarea cols="50" rows="10" name="senden_antwort_text"></textarea><center><input type="submit" value="Absenden"></center>';
					$status = "<font color=green>Offen</font>";
					break;
					case 2:
					$status = "<font color=orange>Admin-Antwort</font>";
					$parse['eintrag'] ='<textarea cols="50" rows="10" name="senden_antwort_text"></textarea><center><input type="submit" value="Absenden"></center>';
					break;
					case 3:
					$status = "<font color=green>Spieler-Antwort</font>";
					$parse['eintrag'] ='<textarea cols="50" rows="10" name="senden_antwort_text"></textarea><center><input type="submit" value="Absenden"></center>';
					break;
				}
				$parse['ticketdiv'] .= "if (i != ".$ticket['ID']."){javascript:animatedcollapse.hide('".$ticket['ID']."');}\n";
				$parse['ticketsrc'] .= "animatedcollapse.addDiv('".$ticket['ID']."', 'fade=1,height=auto')\n";
				$parse['tickets'] .= "<tr>"
				."<td class='b'>".$ticket['ID']."</td>"
				."<td class='b'><a href=\"javascript:infodiv(".$ticket['ID'].");javascript:animatedcollapse.toggle('".$ticket['ID']."');\">".$ticket['subject']."</a></td>"
				."<td class='b'>".$status."</td>"
				."<td class='b'>".date("j. M Y H:i:s",$ticket['time'])."</td>"
				."</tr>";
				$parse['ticketsinfo'] .= "<div id=\"".$ticket['ID']."\" style=\"display:none\";>\n"
				."<table width=\"519\">"
				."<tr>"
				."<td class=\"c\"><center>".$lang['text']."</center></td>"
				."</tr>"
				."<tr>"
				."<td class=\"b\"><center>".$ticket['text']."</center></td>"
				."</tr>"
				."<tr><td class=\"c\" width=\"50%\"><center>".$parse['answer_new']."</center></td></tr>"
				."<tr>"
				."<form action=\"game.php?page=support&ticket=".$ticket['ID']."&sendenantwort=1\" method=\"POST\">"
				."<td class=\"b\" colspan=\"2\">"
				."<input type=\"hidden\" name=\"senden_antwort_id\" value=\"".$ticket['ID']."\">"
				.$parse['eintrag']
				."</form>"
				."</td>"
				."</tr>"
				."</table>\n"
				."</div>\n";
			}
			display(parsetemplate(gettemplate('supp/supp'), $parse), 'Support',true);




	}
	elseif($_GET['sendenticket'] == "1"){



	$subject = $_POST['senden_ticket_subject'];
	$tickettext = $_POST['senden_ticket_text'];
	$time = time();

	if(empty($tickettext) OR empty($subject)){

			display(parsetemplate(gettemplate('supp/supp_t_send_error'), $parse),false, 'Support',true);
	}else{
			$Qryinsertticket  = "INSERT {{table}} SET ";
			$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
			$Qryinsertticket .= "`subject` = '". $subject ."',";
			$Qryinsertticket .= "`text` = '" .mysql_escape_string( $tickettext) ."',";
			$Qryinsertticket .= "`time` = '". $time ."',";
			$Qryinsertticket .= "`status` = '1'";
			doquery( $Qryinsertticket, "supp");
						
			display(parsetemplate(gettemplate('supp/supp_t_send'), $parse),'Support',true);
	}
	}elseif($_GET['sendenantwort'] == "1"){

		$antworttext = $_POST['senden_antwort_text'];
		$antwortticketid = $_POST['senden_antwort_id'];

		if(empty($antworttext) OR empty($antwortticketid)){
			display(parsetemplate(gettemplate('supp/supp_t_send_error'), $parse),'Support',true);
		}else{

			$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
			while($ticket = mysql_fetch_array($query)){
			$newtext = $ticket['text'].'<br><br><hr>'.$user['username'].' schreib am '.date("j. M Y H:i:s", time()).'<br><br>'.$antworttext.'';
			$QryUpdatemsg  = "UPDATE {{table}} SET ";
			$QryUpdatemsg .= "`text` = '".mysql_escape_string(  $newtext) ."',";
			$QryUpdatemsg .= "`status` = '3'";
			$QryUpdatemsg .= "WHERE ";
			$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
			doquery( $QryUpdatemsg, "supp");
							
			}
			display(parsetemplate(gettemplate('supp/supp_answ_send'), $parse),'Support',true);
		}
	}
}
?>