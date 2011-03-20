<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_adm', true);

$xgp_root  = './../';
include( $xgp_root . 'extension.inc.php');
include( $xgp_root . 'common.' . $phpEx);
include('AdminFunctions/Autorization.' . $phpEx);

	if ($user['authlevel'] >= 1) {
	includeLang('INGAME');
		$parse     = $lang;

if($_GET['ticket'] == 0){
/// Deteilsanzeige des eigenen tickets
		$query = doquery("SELECT s.* ,u.id, u.username as username FROM {{table}}supp as s, {{table}}users as u WHERE status >= '1' AND  u.id=s.player_id ORDER BY s.time", "");
		while($ticket = mysql_fetch_array($query)){
		if($ticket['status']==1){
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket['status']==0){
		$status = "<font color=red>Cerrar</font>";
		}
		if($ticket['status']==2){
		$status = "<font color=yellow>Respuesta del adm</font>";
		}
		if($ticket['status']==3){
		$status = "<font color=green>Respuesta del Jugador</font>";
		}
		
		$playername = $ticket['username'];	
				
		$parse['tickets'] .= "<tr>"
						    ."<td class='b'>".$ticket['ID']."</td>"
						    ."<td class='b'>".$playername."</td>"
							."<td class='b'><a href='support.php?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>"
							."<td class='b'>". $status ."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>"
							."</tr>";
		}

		display(parsetemplate(gettemplate('adm/supp'), $parse), false, '', true, false);

}elseif($_GET['sendenticket'] =="1"){
/// Eintragen eines Neuen Tickets

$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){

	display(parsetemplate(gettemplate('adm/supp_t_send_error'),$parse), false, '', true, false);
}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '". mysql_escape_string($tickettext) ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");
		display(parsetemplate(gettemplate('adm/supp_t_send'), $parse), false, '', true, false);
}
}elseif($_GET['sendenantwort'] =="1"){
/// Eintragen der neuen Antwort
	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('adm/supp_t_send_error'), $parse), false, '', true, false);
}else{

		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
		while($ticket = mysql_fetch_array($query))
		{
		$newtext = $ticket['text'].'<br><br><hr><br> <font color="red">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`text` = '".mysql_escape_string( $newtext )."',";
		$QryUpdatemsg .= "`status` = '2'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		doquery( $QryUpdatemsg, "supp");
					
	}
	display(parsetemplate(gettemplate('adm/supp_answ_send'), $parse), false, '', true, false);
}
}elseif($_GET['schliessen'] =="1"){
		$schließen = $_GET['ticket'];
	
		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`status` = '0'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schließen ."' ";
		doquery( $QryUpdatemsg, "supp");
		display(parsetemplate(gettemplate('adm/supp_t_close'), $parse) , false, '', true, false);

}else{
/// Listenanzeige des einen tickets
	$query2 = doquery("SELECT s.*, u.username as username , u.id FROM {{table}}supp as s, {{table}}users as u  WHERE s.ID = '".$_GET['ticket']."' AND u.id=s.player_id ", "");
	while($ticket2 = mysql_fetch_array($query2)){
		if($ticket2['status']==1){
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket2['status']==0){
		$status = "<font color=red>Cerrar</font>";
		}
		if($ticket2['status']==2){
		$status = "<font color=yellow>Respuesta del adm</font>";
		}
		if($ticket2['status']==3){
		$status = "<font color=green>Respuesta del Jugador</font>";
		}
		
		$playername2 = $ticket2['username'];
				
		$parse['tickets'] .= "<tr><td class='b'>".$ticket2['ID']."</td>"
						    ."<td class='b'>".$playername2."</td>"
							."<td class='b'>".$ticket2['subject']."</td>"
							."<td class='b'>".$status."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket2['time'])."</td>"
							."</tr>";

		$parse['text_view'] = $ticket2['text'];
		$parse['id'] = $ticket2['ID'];

	display(parsetemplate(gettemplate('adm/supp_detail'), $parse), false, '', true, false);
}

}
	} else {
		admMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>