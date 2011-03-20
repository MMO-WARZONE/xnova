<?php
/**
 * @name Soporte(sistema de incidencias) Plugin
 * @author adri93 (plugin)
 * @author jtsamper (Codigo base)
 * @author adaptado para 2.9.1 por samurai.rukasu (adaptación y mejora)
 * @category Plugin
 * @version 0.3
 * @copyright (c) 2010 Adri93 for the plugin conversion, jt.samper and samurai.rukasu for the system.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if($game_config['supp_plugin']== ''){
doquery("INSERT INTO {{table}} (`config_name`, `config_value`) VALUES ('supp_plugin', 1)","config");
$QryTablePluginsupp    = "CREATE TABLE `{{table}}` ( ";
$QryTablePluginsupp   .= "`status` tinyint(1) NOT NULL default '0',";
$QryTablePluginsupp   .= "`ID` int(11) NOT NULL auto_increment,";
$QryTablePluginsupp   .= "`player_id` int(11) NOT NULL,";
$QryTablePluginsupp   .= "`time` int(11) NOT NULL,";
$QryTablePluginsupp   .= "`subject` varchar(255) NOT NULL,";
$QryTablePluginsupp   .= "`text` longtext NOT NULL,";
$QryTablePluginsupp   .= " PRIMARY KEY  (`ID`)";
$QryTablePluginsupp   .= ") ENGINE = MYISAM CHARACTER SET latin1 COLLATE latin1_bin;";
doquery ($QryTablePluginsupp, 'supp');
}

$sop_name="Sistema de incidencias";
 $sop_desc="Para comunicarte con tus usuarios desde el panel de control";
 $config_line .= AdmPlugin($sop_name, $sop_desc);
 if(PluginAct($sop_name) == 1){
    //lang variables
$lang['supp_header']      = "Sistema de Incidencias";
$lang['ticket_id']     = "#Ticket-ID";
$lang['subject']     = "Asunto";
$lang['status']     = "Estado";
$lang['ticket_posted']     = "Creado el:";
$lang['ticket_new']     = "Nuevo Ticket";
$lang['input_text']     = "Descripcion de la incidencia o problema:";
$lang['answer_new']     = "Texto Solucion:";
$lang['text']         = "Texto:";
$lang['message_a']     = "Estado del mensaje:";
$lang['sendit_a']     = "Mensaje ha sido enviado";
$lang['message_t']     = "Estado de los tickets:";
$lang['sendit_t']     = "El ticket ha sido registrado.";
$lang['close_t']     = "El ticket ha sido cerrado.";
$lang['sendit_error']     = "Error:";
$lang['sendit_error_msg'] = "No ha rellenado todos los datos!";
$lang['supp_admin_system']     = "Administracion del Sistema de Incidencias";
$lang['close_ticket']     = "Cerrar Ticket";
$lang['player']     = "Jugador";
$lang['input_text']    = "Enviar";
//menu hack
$lang['lm_options']	.='</a></font></div></td></tr><tr><td><div align="center"><font color="#FFFFFF"><a href="game.php?page=support">Soporte';

    $page=$_GET['page'];
    
if(is_phpself('game') && $page=='support'){ 

//funciones básicas
    include($game_root . 'includes/functions/SortUserPlanets.' . $phpEx);
    
    $dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    include($game_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
    SetSelectedPlanet ($user);

    $planetrow = doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$user['current_planet']."';", "planets", true);

    include($game_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
    CheckPlanetUsedFields($planetrow);
    //fin funciones basicas
function ShowSupportPage($user){

global $lang;

$parse     = $lang;

if(($_GET['ticket']) == 0){

		$query = doquery("SELECT * FROM {{table}} WHERE `player_id` = '".$user['id']."'", "supp");
		while($ticket = mysql_fetch_array($query)){

		if($ticket['status']==1){
		$status = "<font color=green>Abrir</font>";
		}
		if($ticket['status']==0){
		$status = "<font color=red>Cerrar</font>";
		}
		if($ticket['status']==2){
		$status = "<font color=yellow>Respuesta del Admin</font>";
		}
		if($ticket['status']==3){
		$status = "<font color=green>Respuesta del Jugador</font>";
		}

		$parse['tickets'] .= "<tr>"
		."<td class='b'>".$ticket['ID']."</td>"
		."<td class='b'><a href='game.php?page=support&ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>"
		."<td class='b'>".$status."</td>"
		."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>"
		."</tr>";
		}
		display(parsetemplate(gettemplate('plugins/supp/supp'), $parse));

}elseif($_GET['sendenticket'] == "1"){

$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){

		display(parsetemplate(gettemplate('plugins/supp/supp_t_send_error'), $parse));
}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '" .mysql_escape_string( $tickettext) ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");

		display(parsetemplate(gettemplate('plugins/supp/supp_t_send'), $parse));
}
}elseif($_GET['sendenantwort'] == "1"){

$antworttext = $_POST['senden_antwort_text'];
$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){

		display(parsetemplate(gettemplate('plugins/supp/supp_t_send_error'), $parse));
}else{

		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
		while($ticket = mysql_fetch_array($query)){
		$newtext = $ticket['text'].'<br><br><hr><br> <font color="yellow">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`text` = '".mysql_escape_string(  $newtext) ."',";
		$QryUpdatemsg .= "`status` = '3'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		doquery( $QryUpdatemsg, "supp");

	}
	display(parsetemplate(gettemplate('plugins/supp/supp_answ_send'), $parse));
}
}else{
/// Listenanzeige der eigenen tickets
	$query2 = doquery("SELECT * FROM {{table}} WHERE `ID` = '".$_GET['ticket']."'", "supp");
	while($ticket2 = mysql_fetch_array($query2)){
		
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
		$parse['ids'] = $ticket2['ID'];

		display(parsetemplate(gettemplate('plugins/supp/supp_detail'), $parse));
}

}
}
ShowSupportPage($user);
}
//adm menu hack
$lang['mu_connected'].='</a></th></tr><tr><th onMouseOver=\'this.className="ForIEHover"\' onMouseOut=\'this.className="ForIE"\' class="ForIE"><a href="SettingsPage.php?page=support" target="Hauptframe">Soporte';
    
if(is_phpself('adm/SettingsPage') && $page=='support'){ 
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

		display(parsetemplate(gettemplate('plugins/adm/supp'), $parse), false, '', true, false);

}elseif($_GET['sendenticket'] =="1"){
/// Eintragen eines Neuen Tickets

$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){

	display(parsetemplate(gettemplate('plugins/adm/supp_t_send_error'),$parse), false, '', true, false);
}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '". mysql_escape_string($tickettext) ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");
		display(parsetemplate(gettemplate('plugins/adm/supp_t_send'), $parse), false, '', true, false);
}
}elseif($_GET['sendenantwort'] =="1"){
/// Eintragen der neuen Antwort
	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('plugins/adm/supp_t_send_error'), $parse), false, '', true, false);
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
	display(parsetemplate(gettemplate('plugins/adm/supp_answ_send'), $parse), false, '', true, false);
}
}elseif($_GET['schliessen'] =="1"){
		$schließen = $_GET['ticket'];
	
		$QryUpdatemsg  = "UPDATE {{table}} SET ";
		$QryUpdatemsg .= "`status` = '0'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schließen ."' ";
		doquery( $QryUpdatemsg, "supp");
		display(parsetemplate(gettemplate('plugins/adm/supp_t_close'), $parse) , false, '', true, false);

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

	display(parsetemplate(gettemplate('plugins/adm/supp_detail'), $parse), false, '', true, false);
}

}
	} else {
		admMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
    }
}
?>
