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

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='support'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación

includeLang('supp');

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

		$parse     = $lang;
				
if(($_GET['ticket']) == 0){
/// Deteilsanzeige des eigenen tickets
		$query = doquery("SELECT * FROM {{table}} WHERE `player_id` = '".$user['id']."'", "supp");
		while($ticket = mysql_fetch_array($query))
		{
		/// Status-anzeige
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
		/// Status-anzeige ende
		$parse['tickets'] .= "<tr>"
						    ."<td class='b'>".$ticket['ID']."</td>"
							."<td class='b'><a href='support.php?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>"
							."<td class='b'>".$status."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>"
							."</tr>";
		}
		display(parsetemplate(gettemplate('supp'), $parse), 'Support',true);




}elseif($_GET['sendenticket'] == "1"){
/// Eintragen eines Neuen Tickets


$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('supp_t_send_error'), $parse),false, 'Support',true);
}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '". $tickettext ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");
					
		display(parsetemplate(gettemplate('supp_t_send'), $parse),'Support',true);
}
}elseif($_GET['sendenantwort'] == "1"){
/// Eintragen der neuen Antwort
$antworttext = $_POST['senden_antwort_text'];
$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('supp_t_send_error'), $parse),'Support',true);
}else{

		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
		while($ticket = mysql_fetch_array($query))
		{
		$newtext = $ticket['text'].'<br><br><hr><br> <font color="yellow">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`text` = '". $newtext ."',";
		$QryUpdatemsg .= "`status` = '3'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		doquery( $QryUpdatemsg, "supp");
					
	}
						display(parsetemplate(gettemplate('supp_answ_send'), $parse),'Support',true);
}
}else{
/// Listenanzeige der eigenen tickets
	$query2 = doquery("SELECT * FROM {{table}} WHERE `ID` = '".$_GET['ticket']."'", "supp");
	while($ticket2 = mysql_fetch_array($query2))
	{
		
		if($ticket2['status']>=1){
					$parse['eintrag'] ='
			<textarea cols="50" rows="10" name="senden_antwort_text" style="font-family:Arial;font-size:0.8em;"></textarea>
			<center><input type="submit" value="Enviar"></center>';
		}
		if($ticket2['status']==1)
		{
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket2['status']==0)
		{
		$status = "<font color=red>Cerrado</font>";
		$parse['answer_new'] = 'Ticket Cerrado';
		}
		if($ticket2['status']==2)
		{
		$status = "<font color=yellow>Respuesta del Admin</font>";
		}
		if($ticket2['status']==3)
		{
		$status = "<font color=green>Respuesta del Jugador</font>";
		}
		$parse['tickets'] .= "<tr>"
						  ."<td class='b'>".$ticket2['ID']."</td>"
							."<td class='b'>".$ticket2['subject']."</td>"
							."<td class='b'>".$status."</td>"
							."<td class='b'>".date("j-m-Y H:i:s",$ticket2['time'])."</td>"
							."</tr>";

		$parse['text_view'] = $ticket2['text'];
		$parse['id'] = $ticket2['ID'];
	

	display(parsetemplate(gettemplate('supp_detail'), $parse),'Support',true);
}

}

?>
