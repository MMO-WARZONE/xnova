<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

include("common.php");
include("cookies.php");

$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
/*
	TABLA DE REFERENCIA:
	
	ID	Tipo
	0	Mensaje comun entre jugadores
	
*/
//Marcamos los mensajes como leidos
doquery("UPDATE {{table}} SET new_message=0 WHERE id={$userrow['id']}",'users');

/*
  Aqui se borran los mensajes. por medio de deletemessage y deletemarked
*/
if (isset($_POST['deletemessages']))

if ($_POST['deletemessages'] == 'deleteall') {
	//Se borran todos los mensajes del jugador
	doquery("DELETE FROM {{table}} WHERE message_owner={$userrow['id']}",'messages');
}elseif ($_POST['deletemessages'] == 'deletemarked') {

	
	foreach($_POST as $a => $b){
		/*
		  Los checkbox marcados tienen la palabra delmes seguido del id.
		  Y cada array contiene el valor "on" para compro
		*/
		if(preg_match("/delmes/i",$a) && $b == 'on'){
			
			$id = str_replace("delmes","",$a);
			$note_query = doquery("SELECT * FROM {{table}} WHERE message_id=$id AND message_owner={$userrow['id']}",'messages');
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

$messagequery = doquery("SELECT * FROM {{table}} WHERE message_owner={$userrow['id']} ORDER BY message_time DESC",'messages');

/*
  Loop donde se muestran los mensajes, y depende del tipo de cada mensaje
  este se muestra de cada color.
*/

while ($m = mysql_fetch_array($messagequery)){

	$page .= '<tr><th';
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= '><input name="delmes'.$m['message_id'].'" type="checkbox"></th><th';
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= '>'.date("m-d H:m:s",$m['message_time']).'</th><th';
	 
	/*
	  Color del Mensaje, de quien lo envio
	*/
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	elseif($m['message_type'] == 1){$page .= ' style="color: rgb(255, 62, 62);"';}
	elseif($m['message_type'] == 1){$page .= ' style="color: rgb(101, 216, 118);"';}
	$page .= '>';
	
	$page .= $m['message_from'].'</th><th'; //Emisor
	 
	/*
	  Color del Mensaje, sujeto del mensaje (titulo)
	*/
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	elseif($m['message_type'] == 1){$page .= ' style="color: rgb(242, 204, 74);"';}
	elseif($m['message_type'] == 1){$page .= ' style="color: rgb(101, 216, 118);"';}
	$page .= '>';

	$page .= $m['message_subject'];
	if($m['message_type'] == 0){$page .= ' <a href="writemessages.php?messageziel='.$m['message_sender'].'&amp;re=1&amp;betreff=Re:'.htmlspecialchars($m['message_subject']).'"><img src="'.$dpath.'img/m.gif" alt="Responder" border="0"></a>';}
	
	$page .= '</th></tr><tr><td';//Asunto
	
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= ' class="b"> </td><td';
	if($m['message_type'] == 0){$page .= '  style="background-color: rgb(51, 51, 0); background-image: none;";"';}
	$page .= ' colspan="3" class="b">'.nl2br($m['message_text']).'</td></tr>';

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


//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
