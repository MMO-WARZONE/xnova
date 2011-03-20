<?php
//version 1

function ShowSupportPage($user){

	global $lang,$displays,$svn_root,$db;

	$displays->assignContent('supp/supp2');
	$subject = $_POST['senden_ticket_subject'];
	$tickettext = strip_tags($_POST['senden_ticket_text'],"<br>");
	$tickext = $_POST['ticket_text'];	
	$time = time();
	if($_POST["send"]){
		if(empty($tickettext) || empty($subject)){
				echo "prueba";
				//display(parsetemplate(gettemplate('supp/supp_t_send_error'), $parse),false, 'Support');
		}else{
			if(!$_GET['sendticket']){
				$Qryinsertticket  = "INSERT {{table}} SET ";
				$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
				$Qryinsertticket .= "`subject` = '".mysql_escape_string( $subject ) ."',";
				$Qryinsertticket .= "`text` = '" .mysql_escape_string( $tickettext) ."',";
				$Qryinsertticket .= "`time` = '". $time ."',";
				$Qryinsertticket .= "`status` = '1'";
				$db->query( $Qryinsertticket, "supp");
			}else{
				$ticket = $db->query("SELECT `text` FROM {{table}} WHERE `id` = '".$_GET['sendticket']."'", "supp",true);
                               
                                $newtext =$ticket['text'].'<br><br><hr><br>'. $tickettext;
                                $QryUpdatemsg  = "UPDATE {{table}} SET ";
				$QryUpdatemsg .= "`text` = '".mysql_escape_string($newtext) ."',";
				$QryUpdatemsg .= "`status` = '3'";
				$QryUpdatemsg .= "WHERE ";
				$QryUpdatemsg .= "`id` = '". $_GET['sendticket'] ."' AND `status` != '0' ;";
				$db->query( $QryUpdatemsg, "supp");
				
			}
		}
	}
        if(!$_GET["ticket"] && !$_GET["sendticket"]){
            $displays->newBlock('newsupp');
        }
	$query = $db->query("SELECT * FROM {{table}} WHERE `player_id` = '".$user['id']."'", "supp");
	
	if(mysql_num_rows($query)){
		$displays->newBlock('supp');
		while($ticket = mysql_fetch_array($query)){
                
                            $displays->newBlock('listsupp');
                            if($ticket['status']==0){
                                    $status = "<font color=red>Cerrar</font>";
                            }elseif($ticket['status']==1){
                                    $status = "<font color=green>Abrir</font>";
                            }elseif($ticket['status']==2){
                                    $status = "<font color=yellow>Respuesta del Admin</font>";
                            }elseif($ticket['status']==3){
                                    $status = "<font color=green>Respuesta del Jugador</font>";
                            }
                            $ticket['status']=$status;
                            $ticket['time']=date("j-m-Y H:i:s",$ticket['time']);
                            foreach($ticket as $name => $trans){
                                    $displays->assign($name, $trans);
                            }
                            if(($_GET['ticket'] == $ticket['ID'])||($_GET['sendticket'] == $ticket['ID'])){
                                $displays->gotoBlock("_ROOT");
				$displays->newBlock('newsupp');
				$parse['id']=$ticket['ID'];
				$parse['subject']=$ticket['subject'];
				$parse['text']=$ticket['text'];
                                $parse['read']="readonly";
				foreach($parse as $name => $trans){
					$displays->assign($name, $trans);
				}
				unset($parse);
                            }
			unset($ticket);
		}
	}

	$displays->display('Soporte');
	
	
}
?>