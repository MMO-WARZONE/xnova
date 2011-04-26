<?php


// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;



include("common.php");
include("cookies.php");

if(!is_numeric($messageziel)){error("Error fatal, por favor contacte este error al programador.<br>Programador: Y depaso tomamos un cafecito ;)","Error intencionado...");}

{// init
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta

}


/*
  Obtenemos informacion del id user al que se esta enviando el mensaje.
  En caso de no existir, el mensaje de !is_numeric($messageziel) crea un error visual...
  TOUH! HAY QUE REVISAR ESO EN LOS OTROS PHP... FUCK!
*/
$user_query = doquery("SELECT * FROM {{table}} WHERE id=$messageziel",'users',true);
if(!$user_query){ message("El jugador no existe.",'Enviar mensaje');}

//No lo encuentro muy necesario...
//$planet_query = doquery("SELECT * FROM {{table}} WHERE id=".$user_query["id_planet"],"planets",true);
//if(!$planet_query){ error("Ha surgido un problema con el usuario al que estas mandando el mensaje.<br>Por favor, contacta a algun administrador para solucionar el problema.<br>Atte. el programador.<br><br>Asunto: Planeta principal no existe.","Enviar mensaje");}

$pos_query = doquery("SELECT * FROM {{table}} WHERE id_planet=".$user_query["id_planet"],"galaxy",true);
if(!$pos_query){ error("Ha surgido un problema con el usuario al que estas mandando el mensaje.<br>Por favor, contacta a algun administrador para solucionar el problema.<br>Atte. el programador.<br><br>Asunto: Planeta principal no tiene coordenadas.","Enviar mensaje");}

echo_head("Mensajes");
echo_topnav();


if($_POST && $gesendet == 1){
	/*
	  Crear una nueva tabla donde se almacenaran los mensajes.
	  aun falta averiguar que tipo de datos hirian...
	  pero por ahora, solo va:
	  id, owner, sender, time, title,y body
	*/
	$error=0;
	if(!$_POST["betreff"]){ $error++; echo '<center><br><font color=#FF0000>Sin asunto<br></font></center>';}
	if(!$_POST["text"]){ $error++; echo '<center><br><font color=#FF0000>Dónde esta el mensaje?<br></font></center>';}
	if($error==0){
		
		echo "<center><font color=#00FF00>El mensaje ha sido enviado<br></font></center>";
		
		$query = "INSERT INTO {{table}} SET ";
		$query .= "`message_owner`=".$messageziel;
		$query .= ", `message_sender`=".$userrow['id'];
		$query .= ", `message_time`=".time();
		$query .= ", `message_type`=0, `message_from`='".$userrow['username'];
		$query .= " [".$userrow['galaxy'].":".$userrow['system'].":";
		$query .= $userrow['planet']."]', `message_subject`='";
		$query .= $_POST["betreff"]."', `message_text`='".$_POST["text"]."';";
		//query para agregar un mensaje
		doquery($query,'messages');
		//query para agregar un contador al dueño de ese mensaje
		doquery("UPDATE {{table}} SET `new_message`=`new_message`+1 WHERE `id`=$messageziel;",'users');
	}
}

$to = $user_query["username"].' ['.$pos_query["galaxy"].':'.$pos_query["system"].':'.$pos_query["planet"].']';

$betreff = (isset($re) && $re != 1) ? "Sin asunto": $betreff;

	echo '<script src="scripts/cntchar.js" type="text/javascript"></script>
<script src="scripts/win.js" type="text/javascript"></script>
<center>';

echo '<br />
<center>
<form action="writemessages.php?gesendet=1&messageziel='.$messageziel.'" method="post">
 <table width="519">
   <tr>
   <td class="c" colspan="2">Escribir mensaje</td>
  </tr>
  <tr>
   <th>Destinatario</th>
   <th><input type="text" name="to" size="40" value="'.$to.'" /></th>
  </tr>
  <tr>
   <th>Asunto</th>
   <th>
    <input type="text" name="betreff" size="40" maxlength="40" value="'.$betreff.'" />
   </th>
  </tr>
  <tr>
   <th>
    Mensaje(<span id="cntChars">0</span> / 500 Caracteres)
   </th>
   <th>
    <textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(500)"></textarea>
   </th>
  </tr>
  <tr>
   <th colspan="2"><input type="submit" value="Enviar" /></th>
  </tr>
   </table>
</form>
</center>
</body>
</html>';

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
