<?php // alliance.php ::  Adminitrador de Alianzas.

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

{//init
	define('IN_RBO', true);
	include('common.php');
	include('cookies.php');
	$userrow = checkcookies();
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}

function MessageForm($title,$mes,$dest='',$button_name='Aceptar'){

	return "<center><table width=519><form action=\"$dest\" method=POST>
	<tr><td class=c colspan=2>$title</td></tr><tr><th colspan=2>$mes
	<input type=submit value=\"$button_name\"></th></tr></table></form></center>";

}


if($userrow['ally_id'] == 0 && $userrow['ally_request'] == 0 && !$a){
	/*
	  Vista normal de cuando no se tiene ni solicitud ni alianza
	*/
	$page = '<table width=519><tr><td class=c colspan=2>Alianza</td></tr>';
	$page .= '<tr><th><a href="?a=1">Crear alianza propia</a></th>';
	$page .= '<th><a href="?a=2">Buscar alianzas</a></th></tr></table><br>';

	display($page,"Alianza");

}
elseif($userrow['ally_id'] == 0 && $userrow['ally_request'] == 0 && $a == 1){
	/*
	  Aca se crean las alianzas...
	*/
	if($weiter == 1 && $_POST){
		/*
		  Por el momento solo estoy improvisando, luego se perfeccionara el sistema :)
		  Creo que aqui se realiza una query para comprovar el nombre, y luego le pregunta si es el tag correcto...
		*/ //atag //aname
		if(!$_POST['atag']){ message("Falta la etiqueta de la alianza","Crear alianza");}
		if(!$_POST['aname']){ message("Falta el nombre de la alianza","Crear alianza");}
		
		$tagquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='".$_POST['atag']."'",'alliance',true);
		
		if($tagquery){ message($_POST['atag']." ya existe","Crear alianza");}
		
		//$page = $newtag.' <form action="allianzen.php" method="post"><input value="Continuar" type="submit"></form>';
		
		doquery("INSERT INTO {{table}} SET `ally_name`='".$_POST['aname']."', `ally_tag`='".$_POST['atag']."' , `ally_owner`=".$userrow['id'].", `ally_owner`='Fundador', `ally_register_time`=".time().";","alliance");
		$allyquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='".$_POST['atag']."'",'alliance',true);
		doquery("UPDATE {{table}} SET `ally_id`=".$allyquery['id']." WHERE `id`=".$userrow['id'],"users");
		
		$page = MessageForm($_POST['atag']." creada","La alianza ".$_POST['aname']." ha sido creada.<br>","","Aceptar");
	}else{
		$page = '<form action="?a=1&weiter=1" method=POST>';
		$page .= '<table width=519><tr><td class=c colspan=2>Crear alianza</td></tr>';
		$page .= '<tr><th>Etiqueta de la alianza (3-8 caracteres)</th>';
		$page .= '<th><input type=text name="atag" size=8 maxlength=8 value=""></th></tr>';
		$page .= '<tr><th>Nombre de la alianza (max. 35 caracteres)</th>';
		$page .= '<th><input type=text name="aname" size=20 maxlength=30 value=""></th></tr>';
		$page .= '<tr><th colspan=2><input type=submit value="Crear"></th>';
		$page .= '</tr></table></form>';
	}
	display($page,"Crear alianza");
}
elseif($userrow['ally_id'] == 0 && $userrow['ally_request'] == 0 && $a == 2){
	/*
	  Buscador de alianzas
	*/
	if($_POST){//esta parte es igual que el buscador de search.php...

		//suchtext
	}else{
		$page = '<table width=519><tr><td class=c colspan=2>Buscar alianzas</td></tr>';
		$page .= '<tr><th>Busca</th><th><form action="?a=2" method=POST>';
		$page .= '<input type=text name=suchtext value=""><input type=submit value="Buscar">';
		$page .= '</th></tr></form></table>';
	}
	display($page,"Buscar alianzas");

}
elseif($userrow['ally_id'] == 0 && $userrow['ally_request'] != 0){


	//preguntamos por el ally_tag
	$allyquery = doquery("SELECT ally_tag FROM {{table}} WHERE id=".$userrow['ally_request']." ORDER BY `id`","alliance",true);
	
	extract($allyquery);
	if($_POST['bcancel']){
		
		doquery("UPDATE {{table}} SET `ally_request`=0 WHERE `id`=".$userrow['id'],"users");
		$page = '<form action="" method="POST"><table width="519"><tr><td class="c" colspan="2">Tu solicitud</td></tr><tr><th colspan="2">Tu solicitud a la alianza ['.$ally_tag.'] ha sido borrada. Ahora puedes escribir una nueva solicitud o crear tu propia alianza.</th></tr><tr><th colspan="2"><input value="OK" type="submit"></th></tr></table></form>';
		
	}else{
		$page = '<form action="" method=POST><table width=519><tr><td class=c colspan=2>Tu solicitud</td></tr><tr><th colspan=2>Ya has enviado una solicitud a la alianza ['.$ally_tag.']. Por favor, espera hasta que recibas una respuesta o borra tu solicitud anterior.</th></tr><tr><th colspan=2><input type=submit name="bcancel" value="Borrar solicitud"></th></tr></table></form>';
	}
	
	display($page,"Tu solicitud");
}
elseif($userrow['ally_id'] != 0 && $userrow['ally_request'] == 0){


if($a == 4){//Lista de miembros.
	/*
	  Lista de miembros.
	  Por lo que parece solo se hace una query fijandose los usuarios con el mismo ally_id.
	  seguido del query del planeta principal de cada uno para sacarle la posicion, pero
	  voy a ver si tambien agrego las cordenadas en el id user...
	*/
	if($sort2){
		if($sort1 == 1){$sort = " ORDER BY `username`";}
		elseif($sort1 == 2){$sort = " ORDER BY `username`";}
		elseif($sort1 == 3){$sort = " ORDER BY `points`";}
		elseif($sort1 == 4){$sort = " ORDER BY `ally_register_time`";}
		elseif($sort1 == 5){$sort = " ORDER BY `onlinetime`";}
		
		else{$sort = " ORDER BY `id`";}
		if($sort2 == 1){ $sort .= " DESC;";}
		elseif($sort2 == 2){ $sort .= " ASC;";}
		$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id=".$userrow['ally_id']."$sort",'users');
	}else{
		$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id=".$userrow['ally_id'],'users');
	}
	//contamos la cantidad de usuarios.
	$i=0;
	
	while($u = mysql_fetch_array($listuser)){
		$i++;
		$page .= '
	<tr><th>'.$i.'</th><th>'.$u['username'].'</th>
	<th><a href="writemessages.php?messageziel='.$u['id'].'">
	<img src="'.$dpath.'img/m.gif" border=0 alt="Escribir un mensaje">
	</a></th><th>Fundador</th><th>'.$u['points'].'</th><th>
	<a href="galaxy.php?&g='.$u['galaxy'].'&s='.$u['system'].'">'.$u['galaxy'].':'.$u['system'].':'.$u['planet'].'</a></th><th>'.date("Y-m-d h:m:s",$u['ally_register_time']).'</th>
	<th><font color=lime>On</font></th></tr>';
	}
	$page .= "</table>";
	
	if($sort2==1){$s=2;}elseif($sort2==2){$s=1;}
	$page = '<table width=519><tr><td class=c colspan=8>Lista de miembros (Cantidad: '.$i.')</td></tr>
	<tr><th>Nr.</th><th>
	<a href="?a=4&sort1=1&sort2='.$s.'">Nombre</a></th>
	<th> </th><th><a href="?a=4&sort1=2&sort2='.$s.'">Posición</a></th>
	<th><a href="?a=4&sort1=3&sort2='.$s.'">Puntos</a></th>
	<th><a href="?a=4&sort1=0&sort2='.$s.'">Coordenadas</a></th><th>
	<a href="?a=4&sort1=4&sort2='.$s.'">Miembro desde el</a></th>
	<th><a href="?a=4&sort1=5&sort2='.$s.'">Online</a></th></tr>'.$page;
	
	display($page_top.$page,"Lista de miembros");

}
elseif($a==3){//Dejar alianza

	if($ally_owner == $userrow['id']){error("No puedes salir de tu propia alianza. Para eso, tendras que disolverla.","Alianzas");}
	//query para la allyrow
	$allyquery = doquery("SELECT * FROM {{table}} WHERE id=".$userrow['ally_id']." ORDER BY `id`","alliance",true);
	
	if(!$allyquery){error("Ha ocurrido un error fatal, advierte a un administrador sobre este problema.<br><br>ERROR: Alianza no existe.","Alianzas");}
	
	extract($allyquery);
	
	
	if($weiter==1){//se sale de la alianza
		doquery("UPDATE {{table}} SET `ally_id`=0 WHERE `id`=".$userrow['id'],"users");
		$page = MessageForm("Acabas de salir de la alianza $ally_name","<br>",$PHP_SELF,"Aceptar");
	}else{
		$page = MessageForm("Realmente deseas salir de la alianza $ally_name?","<br>","?a=3&weiter=1","Sí");
	
	}
	
	
	display($page);
}

elseif($a == 5){//Administrar la alianza
	
	$allyrow = doquery("SELECT * FROM {{table}} WHERE id=".$userrow['ally_id'],"alliance",true);

	if(!$allyrow){error("Ha ocurrido un error fatal, advierte a un administrador sobre este problema.<br><br>ERROR: Alianza no existe.","Alianzas");}

	if($t != 1 &&$t != 2 &&$t != 3){$t= 1;}
	$page = '<table width=519><tr><td class=c colspan=2>Administrar la alianza</td></tr>';
	$page .= '<tr><th colspan=2><a href="?a=6">Ajustar leyes</a></th></tr>';
	$page .= '<tr><th colspan=2><a href="?a=7">Administrar a  los miembros</a></th></tr>';
	$page .= '<tr><th colspan=2><a href="?a=9" title="Cambiar la etiqueta de la alianza (solo se puede una vez por semana)">';
	$page .= '<img src="'.$dpath.'pic/appwiz.gif" border=0 alt="Cambiar la etiqueta de la alianza">';
	$page .= '</a>&nbsp;<a href="?a=10" title="Cambiar el nombre de la alianza (solo se puede una vez por semana)">';
	$page .= '<img src="'.$dpath.'pic/appwiz.gif" border=0 alt="Cambiar el nombre de la alianza">';
	$page .= '</a></table>';
	$page .= '<br>';
	$page .= '<form action="?&a=11" method=POST>';
	$page .= '<table width=519><tr><td class=c colspan=3>Textos</td></tr>';
	$page .= '<tr>';
	$page .= '<th><a href="?a=5&t=1">Texto externo</a></th>';
	$page .= '<th><a href="?&a=5&t=2">Texto interno</a></th>';
	$page .= '<th><a href="?&a=5&t=3">Texto de solicitud</a></th>';
	$page .= '</tr><tr><td class=c colspan=3>';
	
	/*
	  Depende del $t, muestra el formulario para cada tipo de texto.
	*/
	if($t == 3){
		$page .= 'Muestra de texto de solicitud';
	}elseif($t == 2){
		$page .= 'Texto interno de la alianza';
	}else{
		$page .= 'Texto público de la alianza';
	}
	
	/*
	  Aqui se peticiona el texto de las alianzas
	*/
	if($t == 3){
		$text = $allyrow['ally_request'];
	}elseif($t == 2){
		$text = $allyrow['ally_text'];
	}else{
		$text = $allyrow['ally_description'];
	}
	
	$page .= ' (<span id="cntChars">0</span> / 5000 Caracteres)</td></tr><tr><th colspan=3>';
	$page .= '<textarea name="text" cols=70 rows=15 onkeyup="javascript:cntchar(5000)">'.$text.'</textarea>';
	
	if($t == 3){
		$page .= '</th></tr><tr><th colspan=3>Muestra de solicitud <select name=bewforce>';
		$page .= '<option value=0>no mostrar automáticamente</option>';
		$page .= '<option value=1>mostrar automáticamente</option></select></th></tr>';
		$page .= '<tr><th colspan=3>';
	}
	$page .= '<input type=hidden name=t value='.$t.'>';
	
	
	$page .= '</th></tr>';
	$page .= '<tr><th colspan=3>';
	$page .= '<input type=hidden name=t value=1><input type=reset value="Reponer"> ';
	$page .= '<input type=submit value="Guardar"></th></tr></table>';
	$page .= '</form><br>';
	$page .= '<form action="?a=11" method=POST>';
	$page .= '<table width=519><tr><td class=c colspan=2>Opciones</td></tr>';
	$page .= '<tr><th>Página principal</th>';
	$page .= '<th><input type=text name="hp" value="'.$allyrow['ally_web'].'" size="70"></th></tr>';
	$page .= '<tr><th>Logo de la alianza</th>';
	$page .= '<th><input type=text name="logo" value="'.$allyrow['ally_image'].'" size="70"></th></tr>';
	$page .= '<tr><th>Solicitudes</th>';
	
	$page .= '<th><select name=bew>';
	$page .= '<option value=0'.(($allyrow['ally_request_notallow'] == 0) ? ' SELECTED' : '').'>';
	$page .= 'Permitidas (la alianza está abierta)</option>';
	$page .= '<option value=1'.(($allyrow['ally_request_notallow'] == 1) ? ' SELECTED' : '').'>';
	$page .= 'No están permitidas (la alianza está cerrada)</option></select>';
	$page .= '</th></tr><tr><th>Nombre del fundador</th>';
	$page .= '<th><input type=text name=fname value="'.$allyrow['ally_owner_range'].'" size=30></th>';
	$page .= '<tr><th colspan=2><input type=submit value="Guardar"></th>';
	$page .= '</tr></table></form>';

	$page .= MessageForm("Disolver esta alianza","","?a=12","continuar");
	$page .= '<br>';
	$page .= MessageForm("Transferir / tomar esta alianza","","?a=18","continuar");

	display($page,'Administrar alianza');

}
elseif($a == 6){
	$page = '<a href="allianzen.php?session=15bf9bf20e09&a=5">Regresar a la visión general</a><table width=519><tr><td class=c colspan=11>Configurar las leyes</td></tr><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><tr><th></th><th>Nombre de rango</th><th><img src=img/r1.png></th><th><img src=img/r2.png></th><th><img src=img/r3.png></th><th><img src=img/r4.png></th><th><img src=img/r5.png></th><th><img src=img/r6.png></th><th><img src=img/r7.png></th><th><img src=img/r8.png></th><th><img src=img/r9.png></th></tr><tr><th><a href="allianzen.php?session=15bf9bf20e09&a=15&d=3"><img src="http://www.geocities.com/perberosro/ogame/skin/pic/abort.gif" alt="Borrar rango" border=0></a></th><th>&nbsp;asd &nbsp;</th><th><input type=checkbox name="u3r0"></th><th><input type=checkbox name="u3r1"></th><th><input type=checkbox name="u3r2"></th><th><input type=checkbox name="u3r3"></th><th><input type=checkbox name="u3r4"></th><th><input type=checkbox name="u3r5"></th><th><input type=checkbox name="u3r6"></th><th><input type=checkbox name="u3r7"></th><th><input type=checkbox name="u3r8"></th></tr><tr><th><a href="allianzen.php?session=15bf9bf20e09&a=15&d=2"><img src="http://www.geocities.com/perberosro/ogame/skin/pic/abort.gif" alt="Borrar rango" border=0></a></th><th>&nbsp;asd &nbsp;</th><th><input type=checkbox name="u2r0"></th><th><input type=checkbox name="u2r1"></th><th><input type=checkbox name="u2r2"></th><th><input type=checkbox name="u2r3"></th><th><input type=checkbox name="u2r4"></th><th><input type=checkbox name="u2r5"></th><th><input type=checkbox name="u2r6"></th><th><input type=checkbox name="u2r7"></th><th><input type=checkbox name="u2r8"></th></tr><tr><th colspan=11><input type=submit value="Guardar"></th></tr></form></table><br><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Crear rango</td></tr><tr><th>Nombre de rango</th><th><input type=text name="newrangname" size=20 maxlength=30></th></tr><tr><th colspan=2><input type=submit value="Crear"></th></tr></form></table><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Leyenda de leyes</td></tr><tr><th><img src=img/r1.png></th><th>Disolver la alianza</th></tr><tr><th><img src=img/r2.png></th><th>Expulsar usuario</th></tr><tr><th><img src=img/r3.png></th><th>Ver las solicitudes</th></tr><tr><th><img src=img/r4.png></th><th>Ver la lista de miembros</th></tr><tr><th><img src=img/r5.png></th><th>Revisar las solicitudes</th></tr><tr><th><img src=img/r6.png></th><th>Administrar la alianza</th></tr><tr><th><img src=img/r7.png></th><th>Ver el estado en línea en la lista de miembros</th></tr><tr><th><img src=img/r8.png></th><th>Crear un correo circular</th></tr><tr><th><img src=img/r9.png></th><th>\'Mano derecha\' ( es necesario para transferir la posición de fundador)</th></tr></form></table>';
	//$page = '<a href="allianzen.php?session=15bf9bf20e09&a=5">Regresar a la visión general</a><table width=519><tr><td class=c colspan=11>Configurar las leyes</td></tr><tr><th colspan=11>No existe ningun rango</td></tr></table><br><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Crear rango</td></tr><tr><th>Nombre de rango</th><th><input type=text name="newrangname" size=20 maxlength=30></th></tr><tr><th colspan=2><input type=submit value="Crear"></th></tr></form></table><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Leyenda de leyes</td></tr><tr><th><img src=img/r1.png></th><th>Disolver la alianza</th></tr><tr><th><img src=img/r2.png></th><th>Expulsar usuario</th></tr><tr><th><img src=img/r3.png></th><th>Ver las solicitudes</th></tr><tr><th><img src=img/r4.png></th><th>Ver la lista de miembros</th></tr><tr><th><img src=img/r5.png></th><th>Revisar las solicitudes</th></tr><tr><th><img src=img/r6.png></th><th>Administrar la alianza</th></tr><tr><th><img src=img/r7.png></th><th>Ver el estado en línea en la lista de miembros</th></tr><tr><th><img src=img/r8.png></th><th>Crear un correo circular</th></tr><tr><th><img src=img/r9.png></th><th>\'Mano derecha\' ( es necesario para transferir la posición de fundador)</th></tr></form></table>';
	display($page,'Ajustar leyes');
	
}
elseif($a == 7){
	/*
	  Administrar a los miembros
	*/
	$page = 'a href="allianzen.php?session=15bf9bf20e09&a=5">Regresar a la visión general</a><table width=519><tr><td class=c colspan=9>Lista de miembros (cantidad: 1)</td></tr><tr><th>Nr.</th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=1&sort2=1">Nombre</a></th><th> </th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=2&sort2=1">Posición</a></th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=3&sort2=1">Puntos</a></th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=0&sort2=1">Coordenadas</a></th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=4&sort2=1">Miembro desde el</a></th><th><a href="allianzen.php?session=15bf9bf20e09&a=7&sort1=5&sort2=1">Inactivo</a></th><th>Función</th></tr><tr><th>1</th><th>Perberos</th><th><a href="writemessages.php?session=15bf9bf20e09&messageziel=132750"><img src="http://www.geocities.com/perberosro/ogame/skin/img/m.gif" border=0 alt="Escribir mensaje"></a></th><th>Fundador</th><th>10576</th><th><a href="galaxy.php?session=15bf9bf20e09&p1=2&p2=288">2:288:10</a></th><th>2006-07-13 17:08:48</th><th>0d</th><th></th></tr></table>';
	display($page,'Administrar a los miembros');

	// a=9 es para cambiar la etiqueta de la etiqueta.
	// a=10 es para cambiarle el nombre de la alianza
}
elseif($a == 15){
	/*
	  permite crear y borrar los diferentes rangos de miembros
	  con $d se borra un rango
	*/
	$page = '<a href="allianzen.php?session=15bf9bf20e09&a=5">Regresar a la visión general</a><table width=519><tr><td class=c colspan=11>Configurar las leyes</td></tr><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><tr><th></th><th>Nombre de rango</th><th><img src=img/r1.png></th><th><img src=img/r2.png></th><th><img src=img/r3.png></th><th><img src=img/r4.png></th><th><img src=img/r5.png></th><th><img src=img/r6.png></th><th><img src=img/r7.png></th><th><img src=img/r8.png></th><th><img src=img/r9.png></th></tr><tr><th><a href="allianzen.php?session=15bf9bf20e09&a=15&d=3"><img src="http://www.geocities.com/perberosro/ogame/skin/pic/abort.gif" alt="Borrar rango" border=0></a></th><th>&nbsp;asd &nbsp;</th><th><input type=checkbox name="u3r0"></th><th><input type=checkbox name="u3r1"></th><th><input type=checkbox name="u3r2"></th><th><input type=checkbox name="u3r3"></th><th><input type=checkbox name="u3r4"></th><th><input type=checkbox name="u3r5"></th><th><input type=checkbox name="u3r6"></th><th><input type=checkbox name="u3r7"></th><th><input type=checkbox name="u3r8"></th></tr><tr><th><a href="allianzen.php?session=15bf9bf20e09&a=15&d=2"><img src="http://www.geocities.com/perberosro/ogame/skin/pic/abort.gif" alt="Borrar rango" border=0></a></th><th>&nbsp;asd &nbsp;</th><th><input type=checkbox name="u2r0"></th><th><input type=checkbox name="u2r1"></th><th><input type=checkbox name="u2r2"></th><th><input type=checkbox name="u2r3"></th><th><input type=checkbox name="u2r4"></th><th><input type=checkbox name="u2r5"></th><th><input type=checkbox name="u2r6"></th><th><input type=checkbox name="u2r7"></th><th><input type=checkbox name="u2r8"></th></tr><tr><th colspan=11><input type=submit value="Guardar"></th></tr></form></table><br><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Crear rango</td></tr><tr><th>Nombre de rango</th><th><input type=text name="newrangname" size=20 maxlength=30></th></tr><tr><th colspan=2><input type=submit value="Crear"></th></tr></form></table><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Leyenda de leyes</td></tr><tr><th><img src=img/r1.png></th><th>Disolver la alianza</th></tr><tr><th><img src=img/r2.png></th><th>Expulsar usuario</th></tr><tr><th><img src=img/r3.png></th><th>Ver las solicitudes</th></tr><tr><th><img src=img/r4.png></th><th>Ver la lista de miembros</th></tr><tr><th><img src=img/r5.png></th><th>Revisar las solicitudes</th></tr><tr><th><img src=img/r6.png></th><th>Administrar la alianza</th></tr><tr><th><img src=img/r7.png></th><th>Ver el estado en línea en la lista de miembros</th></tr><tr><th><img src=img/r8.png></th><th>Crear un correo circular</th></tr><tr><th><img src=img/r9.png></th><th>\'Mano derecha\' ( es necesario para transferir la posición de fundador)</th></tr></form></table>';
	//$page = '<a href="allianzen.php?session=15bf9bf20e09&a=5">Regresar a la visión general</a><table width=519><tr><td class=c colspan=11>Configurar las leyes</td></tr><tr><th colspan=11>No existe ningun rango</td></tr></table><br><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Crear rango</td></tr><tr><th>Nombre de rango</th><th><input type=text name="newrangname" size=20 maxlength=30></th></tr><tr><th colspan=2><input type=submit value="Crear"></th></tr></form></table><form action="allianzen.php?session=15bf9bf20e09&a=15" method=POST><table width=519><tr><td class=c colspan=2>Leyenda de leyes</td></tr><tr><th><img src=img/r1.png></th><th>Disolver la alianza</th></tr><tr><th><img src=img/r2.png></th><th>Expulsar usuario</th></tr><tr><th><img src=img/r3.png></th><th>Ver las solicitudes</th></tr><tr><th><img src=img/r4.png></th><th>Ver la lista de miembros</th></tr><tr><th><img src=img/r5.png></th><th>Revisar las solicitudes</th></tr><tr><th><img src=img/r6.png></th><th>Administrar la alianza</th></tr><tr><th><img src=img/r7.png></th><th>Ver el estado en línea en la lista de miembros</th></tr><tr><th><img src=img/r8.png></th><th>Crear un correo circular</th></tr><tr><th><img src=img/r9.png></th><th>\'Mano derecha\' ( es necesario para transferir la posición de fundador)</th></tr></form></table>';
	display($page,'Ajustar leyes');

}
elseif($a == 17){//Correo circular
	/*
	  Mandar un correo circular.
	  creo que aqui tendria que ver yo como crear el sistema de mensajes...
	*/
	if($sendmail==1){
		/*
		  aca se envia el correo circular.
		  y se hace una comprobacion de quienes lo recibieron, ademas de mostrar su nombre.
		  "Los siguientes jugadores han recibido tu correo circular"
		  y un botoncito de aceptar que lleva al principio.
		*/
		
	}
	
	$page = '<table width=519><form action="?a=17&sendmail=1" method=POST><tr>';
	$page .= '<td class=c colspan=2>Enviar correo circular</td></tr><tr><th>Destinatario</th>';
	$page .= '<th><select name=r><option value=0>Todos los jugadores</option></select></th></tr>';
	$page .= '<tr><th>Correo de texto (<span id="cntChars">0</span> / 500 caracteres)</th>';
	$page .= '<th><textarea name=text cols=60 rows=10 onkeyup="javascript:cntchar(500)"></textarea></th></tr>';
	$page .= '<tr><th colspan=2><input type=submit value="Enviar"></th></tr></table>';
	display($page,'Enviar correo circular');

}
else{
	/*
	  Cuando se puede apreciar la alianza propia...
	  Realizamos el query para pedir todos los datos.
	  Pero hay que ver el tema de los permisos.
	*/
	//query para la allyrow
	$allyquery = doquery("SELECT * FROM {{table}} WHERE id=".$userrow['ally_id']." ORDER BY `id`","alliance",true);
	
	if(!$allyquery){error("Ha ocurrido un error fatal, advierte a un administrador sobre este problema.<br><br>ERROR: Alianza no existe.","Alianzas");}
	
	$count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".$userrow['ally_id'].";","users",true);

	extract($allyquery);
	
	$page = '<table width=519><tr><td class=c colspan=2>Tu alianza</td></tr>';
	$page .= (($ally_image != '')?"<tr><td colspan=2><img src=\"$ally_image\"></td></tr>":"");
	$page .= '<tr><th>Etiqueta</th><th>'.$ally_tag.'</th></tr><tr><th>Nombre</th>';
	$page .= '<th>'.$ally_name.'</th></tr><tr><th>Miembro</th>';
	$page .= '<th>'.$count[0].' (<a href="?a=4">Lista de miembros</a>)</th></tr>';
	$page .= '<tr><th>Rango</th>';
	
	//temporalmente...
	if($ally_owner == $userrow['id']){
		$rango = $allyrow['ally_owner_range'];
	}else{$rango = 'miembro';}
	
	
	$page .= '<th>'.$rango.' (<a href="?a=5">Administrar la alianza</a>)</th></tr>';
	$page .= '<tr><th>Correo circular</th>';
	$page .= '<th><a href="?a=17">Enviar correo circular</a></th></tr>';
	$page .= '<tr><th colspan=2 height=100>'.$ally_description.'</th></tr>';
	$page .= '<tr><th>Página principal</th>';
	$page .= '<th><a href="'.$ally_web.'">'.$ally_web.'</a></th></tr>';
	$page .= '<tr><td class=c colspan=2>Sección interna</th></tr>';
	$page .= '<tr><th colspan=2 height=100>'.$ally_text.'</th></tr></table>';
	
	if($ally_owner != $userrow['id']){
		$page .= MessageForm("Salir de esta alianza","","?a=3","Continuar");
	}
	
	display($page,"Tu alianza");
	
}

}
















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