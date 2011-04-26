<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

{//info
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$userrow[current_planet]}","planets",true);
}

/*
  Este script es original xD
  La funcion de este script es administrar una variable del $userrow
  Permite agregar y quitar arrays...
*/
//Lets start!
if(isset($mode)){
	if($_POST){
		//Pegamos el texto :P
		if($_POST["n"] == ""){$_POST["n"] = "Sin nombre";}
		
		$r = "{$_POST[n]},{$_POST[g]},{$_POST[s]},{$_POST[p]},{$_POST[t]}\r\n";
		$userrow['fleet_shortcut'] .= $r;
		doquery("UPDATE {{table}} SET fleet_shortcut='{$userrow[fleet_shortcut]}' WHERE id={$userrow[id]}","users");
		message("El acceso se agrego correctamente. En unos instantes seras redirigido.","Agregar","fleetshortcut");
	}
	$page = "<form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
	<tr height=20>
	<td colspan=2 class=c>Agregar Acceso rápido</td>
	</tr><tr height=\"20\"><th>
	<input type=text name=n value=\"$g\" size=32 maxlength=32 title=\"Nombre\">
	<input type=text name=g value=\"$s\" size=3 maxlength=1 title=\"Galaxia\">
	<input type=text name=s value=\"$p\" size=3 maxlength=3 title=\"Sistema\">
	<input type=text name=p value=\"$t\" size=3 maxlength=3 title=\"Posicion del planeta\">
	 <select name=t>";
	$page .= '<option value="1"'.(($c[4]==1)?" SELECTED":"").">Planeta</option>";
	$page .= '<option value="2"'.(($c[4]==2)?" SELECTED":"").">Escombros</option>";
	$page .= '<option value="3"'.(($c[4]==3)?" SELECTED":"").">Luna</option>";
	$page .= "</select>
	</th></tr><tr>
	<th><input type=reset value=Limpiar> <input type=submit value=Guardar>";
	//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
	$page .= "</th></tr>";
	$page .= '<tr><td colspan=2 class=c><a href=fleetshortcut>Volver</a></td></tr></tr></table></form>';
}
elseif(isset($a)){
	if($_POST){
		//Armamos el array...
		$scarray = explode("\r\n",$userrow['fleet_shortcut']);
		if($_POST["delete"]){
			unset($scarray[$a]);
			$userrow['fleet_shortcut'] =  implode("\r\n",$scarray);
			doquery("UPDATE {{table}} SET fleet_shortcut='{$userrow[fleet_shortcut]}' WHERE id={$userrow[id]}","users");
			message("El acceso se borro correctamente. En unos instantes seras redirigido.","Editar","fleetshortcut");
		}
		else{
			$r = explode(",",$scarray[$a]);
			$r[0] = $_POST['n'];
			$r[1] = $_POST['g'];
			$r[2] = $_POST['s'];
			$r[3] = $_POST['p'];
			$r[4] = $_POST['t'];
			$scarray[$a] = implode(",",$r);
			$userrow['fleet_shortcut'] =  implode("\r\n",$scarray);
			doquery("UPDATE {{table}} SET fleet_shortcut='{$userrow[fleet_shortcut]}' WHERE id={$userrow[id]}","users");
			message("El acceso se modifico correctamente. En unos instantes seras redirigido.","Editar","fleetshortcut");
		}
	}
	if($userrow['fleet_shortcut']){

		$scarray = explode("\r\n",$userrow['fleet_shortcut']);
		$c = explode(',',$scarray[$a]);
		
		$page = "<form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
	<tr height=20>
	<td colspan=2 class=c>Modificar Acceso rápido de {$c[0]} [{$c[1]}:{$c[2]}:{$c[3]}]</td>
	</tr>";
		//if($i==0){$page .= "";}
		$page .= "<tr height=\"20\"><th>
		<input type=hidden name=a value=$a>
		<input type=text name=n value=\"{$c[0]}\" size=32 maxlength=32>
		<input type=text name=g value=\"{$c[1]}\" size=3 maxlength=1>
		<input type=text name=s value=\"{$c[2]}\" size=3 maxlength=3>
		<input type=text name=p value=\"{$c[3]}\" size=3 maxlength=3>
		 <select name=t>";
		$page .= '<option value="1"'.(($c[4]==1)?" SELECTED":"").">Planeta</option>";
		$page .= '<option value="2"'.(($c[4]==2)?" SELECTED":"").">Escombros</option>";
		$page .= '<option value="3"'.(($c[4]==3)?" SELECTED":"").">Luna</option>";
		$page .= "</select>
		</th></tr><tr>
		<th><input type=reset value=Reponer> <input type=submit value=Guardar> <input type=submit name=delete value=Borrar>";
		//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
		$page .= "</th></tr>";
		
	}else{$page .= message("No hay ning&uacute;n acceso directo","Acceso directo","fleetshortcut");}

	$page .= '<tr><td colspan=2 class=c><a href=fleetshortcut>Volver</a></td></tr></tr></table></form>';


}
else{

	$page = '<table border="0" cellpadding="0" cellspacing="1" width="519">
	<tr height="20">
	<td colspan="2" class="c">Accesos rápidos (<a href="?mode=add">Agregar</a>)</td>
	</tr>';
	  
	if($userrow['fleet_shortcut']){
		/*
		  Dentro de fleet_shortcut, se pueden almacenar las diferentes direcciones
		  de acceso directo, el formato es el siguiente.
		  Nombre, Galaxia,Sistema,Planeta,Tipo
		*/
		$scarray = explode("\r\n",$userrow['fleet_shortcut']);
		$i=$e=0;
		foreach($scarray as $a => $b){
			if($b!=""){
			$c = explode(',',$b);
			if($i==0){$page .= "<tr height=\"20\">";}
			$page .= "<th><a href=\"?a=".$e++."\">";
			$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";
			//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
			if($c[4]==2){$page .= " (E)";}elseif($c[4]==3){$page .= " (L)";}
			$page .= "</a></th>";
			if($i==1){$page .= "</tr>";}
			if($i==1){$i=0;}else{$i=1;}
			}
			
		}
		if($i==1){$page .= "<th></th></tr>";}
	
	}else{$page .= "<th colspan=\"2\">No hay ning&uacute;n acceso directo</th>";}

	$page .= '<tr><td colspan=2 class=c><a href=fleet>Volver</a></td></tr></tr></table>';
}
display($page,"Administrador de Accesos directos de coordenadas");
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
