<?php  //boddy.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);

if($s == 1 && isset($bid))
{//delete...

	$buddy = doquery("SELECT * FROM {{table}} WHERE id=$bid","buddy",true);
	if($buddy["owner"] == $user["id"]){
		if($buddy["active"]==0 && $a == 1){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
		}elseif($buddy["active"]==1){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
		}elseif($buddy["active"]==0){
			doquery("UPDATE {{table}} SET `active`=1 WHERE `id`=$bid","buddy");
		}
	}elseif($buddy["sender"] == $user["id"]){
			doquery("DELETE FROM {{table}} WHERE `id`=$bid","buddy");
	}

}
elseif($_POST["s"]==3 && $_POST["a"]==1 && $_POST["e"]==1 && isset($_POST["u"]))
{
/*
  Hacemos la comprobacion de que si existe ya una solicitud, etc...
*/
	$uid = $user["id"];
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

$page = "<center><br>";

/*
  Formulario para enviar mensajes de solicitud de compañeros
*/
if($a == 2 && isset($u))
{//formulario de solicitud

	$u = doquery("SELECT * FROM {{table}} WHERE id='$u'","users",true);

	if(isset($u) && $u["id"] != $user["id"]){
		$page .= "<script src=\"scripts/cntchar.js\" type=\"text/javascript\"></script>
		<script src=\"scripts/win.js\" type=\"text/javascript\"></script><center>
		<form action=buddy.php method=post>
		<input type=hidden name=a value=1>
		<input type=hidden name=s value=3>
		<input type=hidden name=e value=1>
		<input type=hidden name=u value=".$u["id"].">
		<table width=519><tr>
		<td class=c colspan=2>Solicitud de compañeros</td></tr>
		<tr><th>Jugador</th><th>".$u["username"]."</th></tr>
		<tr><th>Texto de solicitud (<span id=\"cntChars\">0</span> / 5000 Caráctereres)</th>
		<th><textarea name=text cols=60 rows=10 onKeyUp=\"javascript:cntchar(5000)\">
		</textarea></th></tr>
		<tr><td class=c><a href=\"javascript:back();\">Volver</a></td>
		<td class=c><input type=submit value='Enviar'></td></tr></table>
		</form></center></body></html>";
		display($page,'buddy');
	}elseif($u["id"] == $user["id"]){
		message("No puedes pedir una solicitud a ti mismo...","Solicitud de compañero");
	}

}

$page .= "<table width=519>\n<tr>\n  <td class=c colspan=6>\n";

//con a indicamos las solicitudes y con e las distiguimos
if($a ==1) $page .= ($e == 1) ? "Mis Solicitudes":"Otras Solicitudes"; else $page .= "Lista de compañeros";


$page .= "</td>\n</tr>\n";

//Solo se muestra en la lista de compañeros.
if(!isset($a)){
	$page .= "<tr><th colspan=6><a href=?a=1>Solicitudes</a></th></tr>";
	$page .= "<tr><th colspan=6><a href=?a=1&e=1>Mis solicitudes</a></th></tr>";
	$page .= "<tr><td class=c></td>";
	$page .= "<td class=c>Nombre</td>";
	$page .= "<td class=c>Alianza</td>";
	$page .= "<td class=c>Coordenadas</td><td class=c>Posición</td>";
	$page .= "<td class=c></td></tr>\n";
}
	/*
		Loop para mostrar la lista de buddy
	*/

	if($a == 1) {
		$query = ($e == 1) ? "WHERE active=0 AND sender=".$user["id"] : "WHERE active=0 AND owner=".$user["id"];
	}else{
		$query = "WHERE active=1 AND sender=".$user["id"]." OR active=1 AND owner=".$user["id"];
	}
	if($user['authlevel'] && !$a && !$e){
		$buddyrow = doquery("SELECT (id) as owner,id as sender FROM {{table}}","users");
	}else{
		$buddyrow = doquery("SELECT * FROM {{table}} ".$query,"buddy");
	}
	while($b = mysql_fetch_array($buddyrow)){
		//para solicitudes
		if(!isset($i) && isset($a)){	$page .= "	<tr>\n  <td class=c></td>\n  <td class=c>Usuario</td>\n  <td class=c>Alianza</td>\n  <td class=c>Coordenadas</td>\n  <td class=c>Texto</td>\n  <td class=c></td>\n</tr>";}
		
		$i++;
		$uid = ($b["owner"] == $user["id"]) ? $b["sender"] : $b["owner"];
		//query del user
		$u = doquery("SELECT id,username,galaxy,system,planet,onlinetime,ally_id FROM {{table}} WHERE id=".$uid,"users",true);
		
		//$g = doquery("SELECT galaxy, system, planet FROM {{table}} WHERE id_planet=".$u["id_planet"],"galaxy",true);
		//$a = doquery("SELECT * FROM {{table}} WHERE id=".$uid,"aliance",true);
		
		$page .= "<tr>
		<th width=20>".$i."</th>
		<th><a href=messages.php?mode=write&id=".$u["id"].">".$u["username"]."</a></th>
		<th>";
		
		if($u["ally_id"] !=0){//Alianza
			$allyrow = doquery("SELECT id,ally_tag FROM {{table}} WHERE id=".$u["ally_id"],"alliance",true);
			if($allyrow){
				$page .= "<a href=alliance.php?mode=ainfo&a=".$allyrow["id"].">".$allyrow["ally_tag"]."</a>";
			}
		}
		
		$page .= "</th><th><a href=\"galaxy.php?g=".$u["galaxy"]."&s=".$u["system"]."\">";
		$page .= $u["galaxy"].":".$u["system"].":".$u["planet"]."</a></th>\n<th>";//Coordenadas del planeta principal
		/*
		  Conectado - texto:
		  Dependiendo del tiempo actual y el registrado en la base de datos, este indica si
		  se encuentra conectado o muestra un texto diciendo hace 15 min, o hace 30 min, On/Off
		*/
		if(isset($a)){
			$page .= $b["text"];
		}else{
			$page .= "<font color=";
			
			if($u["onlinetime"] +60*10 >= time()){ $page .= "lime>On"; }
			elseif($u["onlinetime"] +60*20 >= time()){$page .= "yellow>15 min"; }
			else{$page .= "red> Off";}
			
			$page .= "</font>";
		}
		
		$page .= "</th><th>";
		
		if(isset($a) && isset($e)){
			$page .= "<a href=?s=1&bid=".$b["id"].">Borrar Solicitud</a>";
		}elseif(isset($a)){
			$page .= "<a href=?s=1&bid=".$b["id"].">Aceptar</a><br/>";
			$page .= "<a href=?a=1&s=1&bid=".$b["id"].">Rechazar</a></a>";
		}else{ $page .= "<a href=?s=1&bid=".$b["id"].">Borrar</a>";}
		$page .= "</th>\n</tr>\n";
	}
if(!isset($i)){ $page .= "<th colspan=6>No hay ninguna solicitud</th>\n";}

if($a ==1) $page .= "<tr><td class=c><a href=buddy.php>Volver</a></td></tr>";

$page .= "</table>\n</center>";

display ($page,$lang['buddy']);

// Created by Perberos. All rights reversed (C) 2006
?>
