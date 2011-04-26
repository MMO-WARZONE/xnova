<?  //boddy.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


{//init
	include("common.php");
	include("cookies.php");

	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
}

/*
  Delete!
*/

if($s == 1 && isset($bid))
{//delete...

	$buddy = doquery("SELECT * FROM {{table}} WHERE id=$bid","buddy",true);
	if($buddy["owner"] == $userrow["id"]){
		if($buddy["active"]==0 && $a == 1){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
		}elseif($buddy["active"]==1){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
		}elseif($buddy["active"]==0){
			doquery("UPDATE {{table}} SET `active`=1 WHERE `id`=$bid","buddy");
		}
	}elseif($buddy["sender"] == $userrow["id"]){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
	}

}
elseif($_POST["s"]==3 && $_POST["a"]==1 && $_POST["e"]==1 && isset($_POST["u"]))
{
/*
  Hacemos la comprobacion de que si existe ya una solicitud, etc...
*/
	$uid = $userrow["id"];
	$u = $_POST["u"];
	
	$buddy = doquery("SELECT * FROM {{table}} WHERE sender=$uid AND owner=$u  OR sender=$u AND owner=$uid","buddy",true);
	
	if(!$buddy){
		
		$text = $_POST["text"];
		doquery("INSERT INTO {{table}} SET `sender`=$uid, `owner`=$u, `active`=0, `text`='$text'","buddy");
		message("Solicitud enviada.","Solicitud de compañero", "buddy.php");
		
	}else{ message("Ya existe una solicitud para ese usuario.","Solicitud de compañero");}
/*
  <input type=hidden name=a value=1>
  <input type=hidden name=s value=3>
  <input type=hidden name=e value=1>
  <input type=hidden name=u value=".$u["id"].">

*/

}
/*
	Buddy list -_-U
	Bueno, consiste en una tabla llamada buddy. como la de notes.
	buddy.php se puede llamar comunmente sin variables, y mostrar la lista por default.
	la variable "a"="1" consiste en cambiar el tipo de lista.
	la "a"=2 permite mostrar el formulario para crear una entrada buddy incluyendo el "u"
	como id del usuario.
*/

echo_head("Lista de compañeros");
echo_topnav();
echo "<center>\n";

/*
  Formulario para enviar mensajes de solicitud de compañeros
*/
if($a == 2 && isset($u))
{//formulario de solicitud

	$u = doquery("SELECT * FROM {{table}} WHERE id=$u","users",true);

	if(isset($u) && $u["id"] != $userrow["id"]){
		echo "<script src=\"scripts/cntchar.js\" type=\"text/javascript\"></script>";
		echo "<script src=\"scripts/win.js\" type=\"text/javascript\"></script><center>";
		echo "<form action=buddy.php method=post>";
		echo "<input type=hidden name=a value=1>";
		echo "<input type=hidden name=s value=3>";
		echo "<input type=hidden name=e value=1>";
		echo "<input type=hidden name=u value=".$u["id"].">";
		echo "<table width=519><tr>";
		echo "<td class=c colspan=2>Solicitud de compañeros</td></tr>";
		echo "<tr><th>Jugador</th><th>".$u["username"]."</th></tr>";
		echo "<tr><th>Texto de solicitud (<span id=\"cntChars\">0</span> / 5000 Caráctereres)</th>";
		echo "<th><textarea name=text cols=60 rows=10 onKeyUp=\"javascript:cntchar(5000)\">";
		echo "</textarea></th></tr>";
		echo "<tr><td class=c><a href=\"javascript:back();\">Volver</a></td>";
		echo "<td class=c><input type=submit value='Enviar'></td></tr></table>";
		echo "</form></center></body></html>";
		die();
	}elseif($u["id"] == $userrow["id"]){
		message("No puedes pedir una solicitud a ti mismo...","Solicitud de compañero");
	}

}

echo "<table width=519>\n<tr>\n  <td class=c colspan=6>\n";

//con a indicamos las solicitudes y con e las distiguimos
if($a ==1) echo ($e == 1) ? "Mis Solicitudes":"Otras Solicitudes"; else echo "Lista de compañeros";

echo "  </td>\n</tr>\n";

//Solo se muestra en la lista de compañeros.
if(!isset($a)){
	echo "<tr><th colspan=6><a href=?a=1>Solicitudes</a></th></tr>";
	echo "<tr><th colspan=6><a href=?a=1&e=1>Mis solicitudes</a></th></tr>";
	echo "<tr><td class=c></td>";
	echo "<td class=c>Nombre</td>";
	echo "<td class=c>Alianza</td>";
	echo "<td class=c>Coordenadas</td><td class=c>Posición</td>";
	echo "<td class=c></td></tr>\n";
}

	/*
		Loop para mostrar la lista de buddy
	*/
	
//	if($a ==1) query = ($e == 1)
//		? "active=0 AND owner=".$userrow["id"]
	//	:	"active=0 AND sender=".$userrow["id"]." OR owner=".$userrow["id"]; 
	
	//else query = 
	
	if($a == 1) { $query = ($e == 1) ?	"WHERE active=0 AND sender=".$userrow["id"] : "WHERE active=0 AND owner=".$userrow["id"];
	}else{$query = "WHERE active=1 AND sender=".$userrow["id"]." OR active=1 AND owner=".$userrow["id"];}
	if($userrow['authlevel'] && !$a && !$e){$buddyrow = doquery("SELECT (id) as owner,id as sender FROM {{table}}","users");
	}else{
		$buddyrow = doquery("SELECT * FROM {{table}} ".$query,"buddy");
	}

	while($b = mysql_fetch_array($buddyrow)){
		//para solicitudes
		if(!isset($i) && isset($a)){	echo "	<tr>\n  <td class=c></td>\n  <td class=c>Usuario</td>\n  <td class=c>Alianza</td>\n  <td class=c>Coordenadas</td>\n  <td class=c>Texto</td>\n  <td class=c></td>\n</tr>";}
		
		$i++;
		$uid = ($b["owner"] == $userrow["id"]) ? $b["sender"] : $b["owner"];
		//query del user
		$u = doquery("SELECT id,username,galaxy,system,planet,onlinetime,ally_id FROM {{table}} WHERE id=".$uid,"users",true);
		
		//$g = doquery("SELECT galaxy, system, planet FROM {{table}} WHERE id_planet=".$u["id_planet"],"galaxy",true);
		//$a = doquery("SELECT * FROM {{table}} WHERE id=".$uid,"aliance",true);
		
		echo "<tr>\n";
		echo "<th width=20>".$i."</th>\n";
		echo "<th><a href=writemessages.php?messageziel=".$u["id"].">".$u["username"]."</a></th>\n";
		echo "<th>";
		
		if($u["ally_id"] !=0){//Alianza
			$allyrow = doquery("SELECT id,ally_tag FROM {{table}} WHERE id=".$u["ally_id"],"alliance",true);
			if($allyrow){
				echo "<a href=ainfo.php?a=".$allyrow["id"].">".$allyrow["ally_tag"]."</a>";
			}
		}
		
		echo "</th>\n";
		echo "<th><a href=\"galaxy.php?g=".$u["galaxy"]."&s=".$u["system"]."\">";
		echo $u["galaxy"].":".$u["system"].":".$u["planet"]."</a></th>\n<th>";//Coordenadas del planeta principal
		/*
		  Conectado - texto:
		  Dependiendo del tiempo actual y el registrado en la base de datos, este indica si
		  se encuentra conectado o muestra un texto diciendo hace 15 min, o hace 30 min, On/Off
		*/
		if(isset($a)){
			echo $b["text"];
		}else{
			echo "<font color=";
			
			if($u["onlinetime"] +60*10 >= time()){ echo "lime>On"; }
			elseif($u["onlinetime"] +60*20 >= time()){echo "yellow>15 min"; }
			else{echo "red> Off";}
			
			echo "</font>";
		}
		
		echo "</th><th>";
		
		if(isset($a) && isset($e)){
			echo "<a href=?s=1&bid=".$b["id"].">Borrar Solicitud</a>";
		}elseif(isset($a)){
			echo "<a href=?s=1&bid=".$b["id"].">Aceptar</a><br/>";
			echo "<a href=?a=1&s=1&bid=".$b["id"].">Rechazar</a></a>";
		}else{ echo "<a href=?s=1&bid=".$b["id"].">Borrar</a>";}
		echo "</th>\n</tr>\n";
	}
	if(!isset($i)){ echo "<th colspan=6>No hay ninguna solicitud</th>\n";}


if(isset($a)){ echo "<tr>\n<td class=c colspan=6><a href=buddy.php>Volver</a></td>\n</tr>\n";
}

//foot
echo "</table>\n</center>\n</body>\n</html>";


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