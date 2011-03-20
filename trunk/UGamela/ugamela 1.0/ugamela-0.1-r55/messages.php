<?php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

includeLang('messages');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

/*
	TABLA DE REFERENCIA:
	
	ID	Tipo
	0	Mensaje comun 
	1	Mensaje entre jugadores
	2	Mensaje de la alianza
	3	Mensaje ------ alerta espionaje
	4	Mensaje ------- orden de la flota espionaje
	5	Mensaje ------ Llegada a un planeta
	6	Mensaje -----  aun no estan decididos los diferentes tipos de mensajes,
		salvo los primeros 3, el orden puede variar...
	
*/

if($mode == 'write'){ //Formulario para mandar mensajes personales (PM)


	if(!is_numeric($id)){error("Error fatal, por favor contacte este error al programador.<br>Programador: Y depaso tomamos un cafecito ;)","Error intencionado...");}

	/*
	  Obtenemos informacion del id user al que se esta enviando el mensaje.
	  En caso de no existir, el mensaje de !is_numeric($id)  crea un error visual...
	  TOUH! HAY QUE REVISAR ESO EN LOS OTROS PHP... FUCK!
	*/
	$user_query = doquery("SELECT * FROM {{table}} WHERE id='$id'",'users',true);

	if(!$user_query){ message($lang['User_notexist'],$lang['Send_message']);}

	//No lo encuentro muy necesario...
	//$planet_query = doquery("SELECT * FROM {{table}} WHERE id=".$user_query["id_planet"],"planets",true);
	//if(!$planet_query){ error("Ha surgido un problema con el usuario al que estas mandando el mensaje.<br>Por favor, contacta a algun administrador para solucionar el problema.<br>Atte. el programador.<br><br>Asunto: Planeta principal no existe.","Enviar mensaje");}

	$pos_query = doquery("SELECT * FROM {{table}} WHERE id_planet=".$user_query["id_planet"],"galaxy",true);
	if(!$pos_query){ error("Ha surgido un problema con el usuario al que estas mandando el mensaje.<br>Por favor, contacta a algun administrador para solucionar el problema.<br>Atte. el programador.<br><br>Asunto: Planeta principal no tiene coordenadas.",$lang['Send_message']);}

	if($_POST){
		
		/*
		  Crear una nueva tabla donde se almacenaran los mensajes.  "message_sender = 1"
		  message_id,  message_owner, message_sender, message_type, message_time, message_subject,y message_text
		*/
		$error=0;
		if(!$_POST["subject"]){ $error++; $page .= "<center><br><font color=#FF0000>{$lang['No_Subject']}<br></font></center>";}
		if(!$_POST["text"]){ $error++; $page .= "<center><br><font color=#FF0000>{$lang['No_Text']}<br></font></center>";}
		if($error==0){
			
			$page .= "<center><font color=#00FF00>El mensaje ha sido enviado<br></font></center>";
			
			$_POST['text'] = str_replace("'",'&#39;',$_POST['text']);
			$_POST['text'] = str_replace('\\','&#92;',$_POST['text']);
			//query para agregar un mensaje
			doquery("INSERT INTO {{table}} SET 
				`message_owner`='{$id}',
				`message_sender`='{$user['id']}',
				`message_time`='".time()."',
				`message_type`='1',
				`message_from`='{$user['username']} [{$user['galaxy']}:{$user['system']}:{$user['planet']}]',
				`message_subject`='{$_POST['subject']}',
				`message_text`='{$_POST['text']}'"
				,'messages');
			$text = '';
			//query para agregar un contador al dueño de ese mensaje
			doquery("UPDATE {{table}} SET `new_message`=`new_message`+1 WHERE `id`={$id};",'users');
			
		}
		
	}

	$to = "{$user_query['username']} [{$pos_query['galaxy']}:{$pos_query['system']}:{$pos_query['planet']}]";

	$lang['subject'] = (!isset($subject)) ? $lang['No_Subject']: $subject;
	$lang['to'] = $to;
	$lang['id'] = $id;
	$lang['text'] = $text;
	
	
	$page .= parsetemplate(gettemplate('messages_pm_form'), $lang);
	
	display($page,$lang['Send_message']);
	die();

}

//Marcamos los mensajes como leidos
doquery("UPDATE {{table}} SET new_message=0 WHERE id={$user['id']}",'users');
/*
  Aqui se borran los mensajes. por medio de deletemessage y deletemarked
*/
if (isset($_POST['deletemessages']))

if ($_POST['deletemessages'] == 'deleteall') {
	//Se borran todos los mensajes del jugador
	doquery("DELETE FROM {{table}} WHERE message_owner={$user['id']}",'messages');
}elseif ($_POST['deletemessages'] == 'deletemarked') {
	
	foreach($_POST as $a => $b){
		/*
		  Los checkbox marcados tienen la palabra delmes seguido del id.
		  Y cada array contiene el valor "on" para compro
		*/
		if(preg_match("/delmes/i",$a) && $b == 'on'){
			
			$id = str_replace("delmes","",$a);
			$note_query = doquery("SELECT * FROM {{table}} WHERE message_id=$id AND message_owner={$user['id']}",'messages');
			//comprobamos,
			if($note_query){
				$deleted++;
				doquery("DELETE FROM {{table}} WHERE message_id=$id","messages");// y borramos
			}
		}
	}
}

$page = <<<HTML
<table>
<tr>
 <td>
   </td>
 <td>
  <table width="519">
<form action="" method="post"><table>
<tr>
 <td>
   </td>
 <td>
  <input name="messages" value="1" type="hidden">
   <table width="519">
    <tr>
     <th colspan="4">
      <select onchange="document.getElementById('deletemessages').options[this.selectedIndex].selected='true'" id="deletemessages2" name="deletemessages2">
       <option value="deletemarked">{$lang['Delete_marked_messages']}</option>
	   <option value="deleteall">{$lang['Delete_all_messages']}</option> 
      </select>
      <input value="{$lang['Ok']}" type="submit">
     </th>
    </tr><tr>
    <th style="color: rgb(242, 204, 74);" colspan="4"><input onchange="document.getElementById('fullreports').checked=this.checked" id="fullreports2" name="fullreports2" type="checkbox">{$lang['show_only_partial_espionage_reports']}</th>
    </tr><tr>
HTML;
/*
  Aca comiensa a mostrar los mensajes
*/

//Encabezado
$page .= <<<HTML
    <td colspan="4" class="c">{$lang['Messages']}</td>
    </tr>
        <tr>
       <th>{$lang['Action']}</th>
     <th>{$lang['Date']}</th>
     <th>{$lang['From']}</th>
     <th>{$lang['Subject']}</th>
    </tr>
HTML;
//Mega loop

$messagequery = doquery("SELECT * FROM {{table}} WHERE message_owner={$user['id']} ORDER BY message_time DESC",'messages');

/*
  Loop donde se muestran los mensajes, y depende del tipo de cada mensaje
  este se muestra de cada color.
*/

while ($m = mysql_fetch_array($messagequery)){

	$page .= '<tr><th';
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= '><input name="delmes'.$m['message_id'].'" type="checkbox"></th><th';
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= '>'.date("m-d H:m:s",$m['message_time']).'</th><th';
	 
	/*
	  Color del Mensaje, de quien lo envio
	*/
	//if($m['message_type'] == 0){$page .= ' style="color: rgb(255, 62, 62);"';}
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	elseif($m['message_type'] == 2){$page .= ' style="color: rgb(101, 216, 118);"';}
	elseif($m['message_type'] == 3){$page .= ' style="color: rgb(255, 62, 62);"';}
	elseif($m['message_type'] == 4){$page .= ' style="color: rgb(101, 216, 118);"';}
	$page .= '>';
	
	if($m['message_type'] == 0){$page .= $m['message_from'];}
	elseif($m['message_type'] == 1){$page .= $m['message_from'];}
	elseif($m['message_type'] == 2){$page .= "{$lang['alliance']} [{$m['message_from']}]";}
	elseif($m['message_type'] == 3){$page .= $m['message_from'];}
	elseif($m['message_type'] == 4){$page .= $lang['Fleet_order'];}
	$page .= '</th><th'; //Emisor
	 
	/*
	  Color del Mensaje, sujeto del mensaje (titulo)
	*/
	//if($m['message_type'] == 0){$page .= ' style="color: rgb(242, 204, 74);"';}
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	//elseif($m['message_type'] == 2){$page .= '';}
	elseif($m['message_type'] == 3){$page .= ' style="color: rgb(242, 204, 74);"';}
	elseif($m['message_type'] == 4){$page .= ' style="color: rgb(86, 52, 248);"';}
	$page .= '>';

	if($m['message_type'] == 0){$page .= $m['message_subject'];}
	elseif($m['message_type'] == 1){$page .= $m['message_subject'];}
	elseif($m['message_type'] == 2){
		switch ($m['message_subject']){
			case 'requestok':
			$page .= str_replace('%s',$m['message_from'],$lang['Request_from']);
			;break;
			case 'requestfail':
			$page .= '<font color="red">'.str_replace('%s',$m['message_from'],$lang['Request_fail']).'</font>';
			;break;
			default:
			$page .= "<a href=\"alliance.php?mode=circular\" style=\"color: rgb(72, 227, 204);\">{$lang['Circular']}</a>";break;
		}
	}
	elseif($m['message_type'] == 3){
		$page .= $lang['Circular'];
	}
	elseif($m['message_type'] == 4){$page .= $lang['Fleet_return'];}
	
	
	//Mensaje circular de tu alianza [%s]
	//elseif($m['message_type'] == 4){$page .= str_replace('%s',$m['message_subject'],$lang['Message_from_your_alliance']);}
	
	
	if($m['message_type'] == 1){$page .= ' <a href="messages.php?mode=write&amp;id='.$m['message_sender'].'&amp;subject=Re:'.htmlspecialchars($m['message_subject']).'"><img src="'.$dpath.'img/m.gif" alt="Responder" border="0"></a>';}
	
	$page .= '</th></tr><tr><td';//Asunto
	
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= ' class="b"> </td><td';
	if($m['message_type'] == 1){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= ' colspan="3" class="b">';
	
	if($m['message_type'] == 0){$page .= nl2br($m['message_text']);}
	elseif($m['message_type'] == 1){$page .= nl2br($m['message_text']);}
	elseif($m['message_type'] == 2){
		switch ($m['message_subject']){
			case 'requestok':
			$page .= $m['message_subject'];break;
			case 'requestfail':
			$page .= $m['message_subject'];break;
			default:
			$page .= str_replace('%s',"<a href=\"messages.php?mode=write&amp;id={$m['message_sender']}\">{$m['message_subject']}</a>",$lang['Player_say']) . nl2br( $m['message_text']);
		}
	}
	
	$page .= '</td></tr>';

}
//Mensaje de cuando no hay ningun mensaje :/
//if($i==0){ $page .= "<tr><th colspan=\"4\">No hay mensajes</th></tr>";}
//Fin Mega loop

$page .= <<<HTML
        <tr>
    <th style="color: rgb(242, 204, 74);" colspan="4"><input onchange="document.getElementById('fullreports2').checked=this.checked" id="fullreports" name="fullreports" type="checkbox">{$lang['show_only_partial_espionage_reports']}</th>
    </tr><tr>
     <th colspan="4">
      <select onchange="document.getElementById('deletemessages2').options[this.selectedIndex].selected='true'" id="deletemessages" name="deletemessages">
       <option value="deletemarked">{$lang['Delete_marked_messages']}</option>
	   <option value="deleteall">{$lang['Delete_all_messages']}</option> 
      </select>
      <input value="Ok" type="submit">
     </th>
    </tr><tr>
     <td colspan="4">
      <center>     
      </center>
     </td>
    </tr>
  </table>
 </td>
 </tr>
</table>
</form>
</table>
</td>
</tr>
</table>
</center>
HTML;
  
  display($page,$lang['Messages']);

/*
a:11:{s:2:"zp";s:26:"???????? [1:394:11]";s:4:"hist";s:14:"07-28 02:43:35";s:5:"rost1";d:42954;s:5:"rost2";d:53749;s:5:"rost3";d:24716;s:5: "rost4";d:573;s:13:"GesamtSchiffe";i:0;s:8:"Gebaeude";a:8:{s:6:"???";i: 5;s:6:"???";i:7;s:10:"?????";i:6;s:12:"??????";i:10;s:6:"???";i:1;s:10:" ?????";i:2;s:6:"???";i:3;s:10:"?????";i:4;}s:6:"Flotte";i:0;s:12: "Verteidigung";i:0;s:2:"ec";d:0;}
*/


// Created by Perberos. All rights reversed (C) 2006
?>
