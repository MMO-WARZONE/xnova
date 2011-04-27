<?php

 /*
===========================================================
 Created by Sk3y ICQ: 270270011
===========================================================
 File: support.php
-----------------------------------------------------------
 Version: 1.0 (08.07.2008)
===========================================================
*/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', false);

$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
	includeLang('supp');
		$parse     = $lang;
		
		
if($_GET['ticket'] == 0){
/// Deteilsanzeige des eigenen tickets
		$query = doquery("SELECT * FROM {{table}} WHERE status >= '1' ORDER BY time", "supp");
		while($ticket = mysql_fetch_array($query))
		{
		if($ticket['status']==1)
		{
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket['status']==0)
		{
		$status = "<font color=red>Cerrar</font>";
		}
		if($ticket['status']==2)
		{
		$status = "<font color=yellow>Respuesta del Admin</font>";
		}
		if($ticket['status']==3)
		{
		$status = "<font color=green>Respuesta del Jugador</font>";
		}

		$query6 = doquery("SELECT * FROM {{table}} WHERE id = '".$ticket['player_id']."'", "users");		
		while($name6 = mysql_fetch_array($query6))
		{
		$playername = $name6['username'];	
									}		
		$parse['tickets'] .= "<tr>"
						    ."<td class='b'>".$ticket['ID']."</td>"
						    ."<td class='b'>".$playername."</td>"
							."<td class='b'><a href='support.php?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>"
							."<td class='b'>". $status ."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>"
							."</tr>";

		}
		display(parsetemplate(gettemplate('admin/supp'), $parse), '',false, '',true);
		




}elseif($_GET['sendenticket'] =="1"){
/// Eintragen eines Neuen Tickets


$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('admin/supp_t_send_error'), $parse),false, '',true);
}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '". $tickettext ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");
		display(parsetemplate(gettemplate('admin/supp_t_send'), $parse), '',false, '',true);
}
}elseif($_GET['sendenantwort'] =="1"){
/// Eintragen der neuen Antwort
	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('admin/supp_t_send_error'), $parse), '',false, '',true);
}else{

		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
		while($ticket = mysql_fetch_array($query))
		{
		$newtext = $ticket['text'].'<br><br><hr><br> <font color="red">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`text` = '". $newtext ."',";
		$QryUpdatemsg .= "`status` = '2'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		doquery( $QryUpdatemsg, "supp");
					
	}
						display(parsetemplate(gettemplate('admin/supp_answ_send'), $parse), '',false, '',true);
}
}elseif($_GET['schliessen'] =="1"){
		$schließen = $_GET['ticket'];
	
		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`status` = '0'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schließen ."' ";
		doquery( $QryUpdatemsg, "supp");
							display(parsetemplate(gettemplate('admin/supp_t_close'), $parse), '',false, '',true);
	
}else{
/// Listenanzeige des einen tickets
	$query2 = doquery("SELECT * FROM {{table}} WHERE `ID` = '".$_GET['ticket']."'", "supp");
	while($ticket2 = mysql_fetch_array($query2))
	{
		if($ticket2['status']==1)
		{
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket2['status']==0)
		{
		$status = "<font color=red>Cerrar</font>";
		}
		if($ticket2['status']==2)
		{
		$status = "<font color=yellow>Respuesta del Admin</font>";
		}
		if($ticket2['status']==3)
		{
		$status = "<font color=green>Respuesta del Jugador</font>";
		}
		$query6 = doquery("SELECT * FROM {{table}} WHERE id = '".$ticket2['player_id']."'", "users");		
		while($name7 = mysql_fetch_array($query6))
		{
		$playername2 = $name7['username'];	
									}		
		$parse['tickets'] .= "<tr>"
						  ."<td class='b'>".$ticket2['ID']."</td>"
						    ."<td class='b'>".$playername2."</td>"
							."<td class='b'>".$ticket2['subject']."</td>"
							."<td class='b'>".$status."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket2['time'])."</td>"
							."</tr>";

		$parse['text_view'] = $ticket2['text'];
		$parse['id'] = $ticket2['ID'];
	

	display(parsetemplate(gettemplate('admin/supp_detail'), $parse), '',false, '',true);
}

}
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>