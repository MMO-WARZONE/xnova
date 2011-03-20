<?php
//version 1.1

function ShowSupportAdmin($user){
	global $lang,$db,$displays;
	if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));
	
	if($_GET['ticket'] == 0){
		$query = $db->query("SELECT s.* ,u.id, u.username as username
				 FROM {{table}}supp as s INNER JOIN {{table}}users as u
				 ON status >= '0' AND  u.id=s.player_id ORDER BY s.time", "");



                $displays->assignContent("adm/supp");
		while($ticket = mysql_fetch_array($query)){ 

                 if($ticket['status']==1){
			$ticket['status'] = "<font color=green>".$lang['sp_open']."</font>";
		}elseif($ticket['status']==0){
			$ticket['status'] = "<font color=red>".$lang['sp_close']."</font>";
		}elseif($ticket['status']==2){
			$ticket['status'] = "<font color=yellow>".$lang['sp_asw_adm']."</font>";
		}elseif($ticket['status']==3){
			$ticket['status'] = "<font color=green>".$lang['sp_asw_pla']."</font>";
	 	}
                $ticket['time'] = date("j-m-Y H:i:s",$ticket['time']);

	 	$displays->newblock("lista_tickets");
		$i++;

	
                    foreach($ticket as $key => $value){
                    $displays->assign($key,$value);
                }

		}
	        $displays->display();
	
}elseif($_GET['sendenantwort'] =="1"){

	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];

	if(empty($antworttext) OR empty($antwortticketid)){

                $displays-> message ($lang['sp_send_error'],"admin.php?page=support",2);
	}else{
	
		$query = $db->query("SELECT * FROM {{table}} WHERE `id` = '".$antwortticketid."'", "supp");
		while($ticket = mysql_fetch_array($query)){
			$newtext = $ticket['text'].'<br><br><hr><br> <font color="red">'.$antworttext.'</font>';
		
			$QryUpdatemsg  = "UPDATE {{table}} SET ";
			$QryUpdatemsg .= "`text` = '".mysql_escape_string( $newtext )."',";
			$QryUpdatemsg .= "`status` = '2'";
			$QryUpdatemsg .= "WHERE ";
			$QryUpdatemsg .= "`ID` = '". $antwortticketid ."' ";
			$db->query( $QryUpdatemsg, "supp");				
		}

               $displays-> message ($lang['sp_send_done'],"admin.php?page=support",2);
        }
}elseif($_GET['schliessen'] =="1"){
		
	$QryUpdatemsg  = "UPDATE {{table}} SET ";
	$QryUpdatemsg .= "`status` = '0'";
	$QryUpdatemsg .= "WHERE ";
	$QryUpdatemsg .= "`id` = '". $_GET['ticket'] ."' ";
	$db->query( $QryUpdatemsg, "supp");
	
         $displays->message ($lang['sp_ticket_close'],"admin.php?page=support",2);

}else{
	$query2 = $db->query("SELECT s.*, u.username as username , u.id
			  FROM {{table}}supp as s INNER JOIN {{table}}users as u ON u.id=s.player_id
			  WHERE s.ID = '".$_GET['ticket']."' ", "");

                $displays->assignContent("adm/supp_detail");
	        while($ticket2 = mysql_fetch_array($query2)){
                    

                 if($ticket2['status']==1){
			$ticket2['status'] = "<font color=green>".$lang['sp_open']."</font>";
		}elseif($ticket2['status']==0){
			$ticket2['status'] = "<font color=red>".$lang['sp_close']."</font>";
		}elseif($ticket2['status']==2){
			$ticket2['status'] = "<font color=yellow>".$lang['sp_asw_adm']."</font>";
		}elseif($ticket2['status']==3){
			$ticket2['status'] = "<font color=green>".$lang['sp_asw_pla']."</font>";
	 	}

               $ticket2['time']      = date("j-m-Y H:i:s",$ticket2['time']);
		

		
		$i++;

                foreach($ticket2 as $key => $value){
                    $displays->assign($key,$value);
                }


		}
	        $displays->display();
	}

}
	

?>