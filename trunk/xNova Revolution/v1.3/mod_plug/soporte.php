<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

@plugin:
mod_plug system by green
adapted mod_plgu by brayan narvaez (principe negro)

Proyect based in xg proyect for xtreme gamez.
*/

class soporte_mod extends modPl implements mod_pl{
    public function install(){
        parent::install_basic('soporte');
        doquery("CREATE TABLE  {{table}} (
`ID` int(11) NOT NULL auto_increment,
`player_id` int(11) NOT NULL,
`time` int(11) NOT NULL,
`subject` varchar(255) NOT NULL,
`text` longtext NOT NULL,
`status` int(1) NOT NULL,
 PRIMARY KEY  (`ID`)
) ENGINE = MYISAM CHARACTER SET latin1 COLLATE latin1_bin; ", "supp");

    }
    public function exec(){
    parent::call_default();
       global $lang;

$parse = $lang;

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
        display(parsetemplate(gettemplate('supp/supp'), $parse), 'Support',false);

}elseif($_GET['sendenticket'] == "1"){

$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){

        display(parsetemplate(gettemplate('supp/supp_t_send_error'), $parse),false, 'Support',false);
}else{
        $Qryinsertticket  = "INSERT {{table}} SET ";
        $Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
        $Qryinsertticket .= "`subject` = '". $subject ."',";
        $Qryinsertticket .= "`text` = '" .mysql_escape_string( $tickettext) ."',";
        $Qryinsertticket .= "`time` = '". $time ."',";
        $Qryinsertticket .= "`status` = '1'";
        doquery( $Qryinsertticket, "supp");

        display(parsetemplate(gettemplate('supp/supp_t_send'), $parse),'Support',false);
}
}elseif($_GET['sendenantwort'] == "1"){

$antworttext = $_POST['senden_antwort_text'];
$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){

        display(parsetemplate(gettemplate('supp/supp_t_send_error'), $parse),'Support',false);
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
    display(parsetemplate(gettemplate('supp/supp_answ_send'), $parse),'Support',false);
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

        display(parsetemplate(gettemplate('supp/supp_detail'), $parse),'Support',false);
}

   }
  }
      public function end(){

    }
    public function pre_exec(){
        global $lang, $game_config;
        parent::lang_txt('reciclador');

    }
}

?>
