<?php
/**
 * @author SainT
 *
 * @package XNova
 * @copyright (c)  XNova Group
 **/

define('INSIDE'  , true); //Definimos inside como verdadero
define('INSTALL' , false); //Definimos install como falso. 
define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)

includeLang('admin'); //Incluimos el archivo del lenguaje
includeLang('leftmenu'); //incluimos el archivo de idioma leftmenu ( atraves de una funcion )

$parse = $lang; 
//Si no tiene permiso no entra
if ($IsUserChecked == false || $user['authlevel'] < 2) {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}


$opcion = $_GET['opcion']; //Recojemos la variable de la url y la ponemos como $opcion.

switch ($opcion) { //Ahora hacemos un switch (Casos) 
	case "Crear": //Si es Crear
	
	//Array con los menus y sus links
$Nmenus = array (
0 => "Overview",
1 => "Buildings",
2 => "Research",
3 => "Shipyard",
4 => "Defense",
5 => "Officiers",
6 => "Marchand",
7 => "Alliance",
8 => "Fleet",
9 => "Messages",
10 => "Galaxy",
11 => "Imperium",
12 => "Resources",
13 => "Technology",
14 => "Records",
15 => "Statistics",
16 => "Search",
17 => "blocked",
18 => "Annonces",
19 => "Buddylist",
20 => "Notes",
21 => "Chat",
22 => "Contact",
23 => "support_system",
24 => "Options",
);

$Lmenus = array (
0 => "overview.php",
1 => "buildings.php",
2 => "buildings.php?mode=research",
3 => "buildings.php?mode=fleet",
4 => "buildings.php?mode=defense",
5 => "officier.php",
6 => "marchand.php",
7 => "alliance.php",
8 => "fleet.php",
9 => "messages.php",
10 => "galaxy.php?mode=0",
11 => "imperium.php",
12 => "resources.php",
13 => "techtree.php",
14 => "records.php",
15 => "stat.php?start=",
16 => "search.php",
17 => "banned.php",
18 => "annonce.php",
19 => "buddy.php",
20 => "notes.php",
21 => "chat.php",
22 => "contact.php",
23 => "support.php",
24 => "options.php",
);
	
	$parse['todoelmenu'] .= "<tr>";
	$parse['todoelmenu'] .= "<td align=\"center\" class=\"c\" style=\"color:#FFFFFF\">";
	$parse['todoelmenu'] .= "<form action=\"menu.php?opcion=Crear\" method=\"post\" enctype=\"application/x-www-form-urlencoded\">";
	$parse['todoelmenu'] .= "Nombre: <input style=\"width:160;\" type=\"text\" name=\"nombre\" id=\"nombre\" /><br />";
	$parse['todoelmenu'] .= "Link: <input style=\"width:160;\" type=\"text\" name=\"link\" id=\"link\" /><br />";
    $parse['todoelmenu'] .= "<input type=\"submit\" name=\"button\" id=\"button\" value=\"Crear\" />";
	$parse['todoelmenu'] .= "</form>";
	$parse['todoelmenu'] .= "</td>";
	$parse['todoelmenu'] .= "</tr>";
	
	if(isset($_POST['nombre'])) {
	$datosultimos = doquery("SELECT * FROM {{table}} order by orden desc limit 1", 'menu', true); //Sacamos el menu ordenado.
	$orden = $datosultimos['orden']+1;
	doquery("INSERT INTO {{table}} SET nombre='{$_POST['nombre']}', link='{$_POST['link']}', orden='{$orden}', lang='1'","menu");
	}
	break;
	case "Eliminar":  //A la hora de eliminar
	$id = $_GET['id']; //$id la definimos como el menu a borrar
	if($id) { //Si existe orden
 	doquery("DELETE FROM {{table}} WHERE orden='{$id}'", 'menu'); //lo Borramos del menu.
	$query = doquery("SELECT orden FROM {{table}} order by orden desc", 'menu', true); //Sacamos el menu borrado (si existe eske ya no necesitamos actualizar mas).
	$cantidad = $query[0]; //ponemos aqui el numero de "orden" que tiene el ultimo
	$cantidad = $cantidad - $id; //AQui le restamos el que borramos
	if($cantidad > 0) { doquery("UPDATE {{table}} SET orden = orden - 1 order by orden desc limit {$cantidad}", "menu"); } //actualizamos todos los anteriores siempre que tengamos que actualizar.
	header("Location: menu.php"); //reidirigimos a menu
	}
	break;
	case "subir":
	$id = $_GET['orden']; //Sacamos el numero de orden que tiene.
	if($id > 1) { //Si id no es uno ( para que no quede en 0 )
	$subir = $id -1;
	doquery("UPDATE {{table}} SET orden = 999 where orden={$id}", "menu");
	doquery("UPDATE {{table}} SET orden = {$id} where orden={$subir}", "menu");
	doquery("UPDATE {{table}} SET orden ={$subir} where orden='999'", "menu");
	}
	header("Location: menu.php"); //reidirigimos a menu
	break;
	case "bajar":
	$query = doquery("SELECT orden FROM {{table}} order by orden desc", 'menu', true); //Sacamos el ultimo menu.
	$cantidad = $query[0]; //ponemos aqui el numero de "orden" que tiene el ultimo
	$id = $_GET['orden']; //Sacamos el numero de orden que tiene.
	if($cantidad > $id) { //Si id no es uno ( para que no quede en 0 )
	$bajar = $id +1;
	doquery("UPDATE {{table}} SET orden = 999 where orden={$id}", "menu");
	doquery("UPDATE {{table}} SET orden = {$id} where orden={$bajar}", "menu");
	doquery("UPDATE {{table}} SET orden ={$bajar} where orden='999'", "menu");
	}
	header("Location: menu.php"); //reidirigimos a menu
	break;
	default: //Si la el contenido de la variable no coincide con nada ponemos este.
	
		//Sacamos El Menu.
		$ConsultaMenu = doquery("SELECT * FROM {{table}} order by orden asc", 'menu'); //Sacamos el menu ordenado.
		while ($row = mysql_fetch_assoc($ConsultaMenu)) { //Hacemos un while (lee 1 por 1)	
			$propio = "si";  //Definimos $propio como verdadero (si el menu lo creo el)
			
			if($row['lang'] == "0") { //Si el lang es 0 esque se lee desde el leftmenu.mo si no no.
				$nombremenu = $row['nombre'];
				$nombremenu = $lang[$nombremenu];
				$propio = "no";
			} else { //Si no lo es ponemos el nombre tal cual
			$nombremenu = $row['nombre'];
			}
		
			if($row['link'] == NULL) { //Si el link es nulo (es seccion) 
				$parse['todoelmenu'] .= "<tr>";
				$parse['todoelmenu'] .= "<td class=\"c\" width=\"15px\" style=\"color:#FFFFFF\"><a alt=\"Eliminar\" title=\"Eliminar\" href=\"menu.php?opcion=Eliminar&id=".$row['orden']."\"><img src=\"../images/r1.png\"></a> </td>";
				$parse['todoelmenu'] .= "<td align=\"left\" class=\"c\" style=\"color:#FFFFFF\"><center>".$nombremenu."</center></td>";
				$parse['todoelmenu'] .= "<td align=\"center\" class=\"c\" width=\"20px\" style=\"color:#FFFFFF\"><a alt=\"Subir\" title=\"Subir\" href=\"menu.php?opcion=subir&orden=".$row['orden']."\"><img src=\"../images/fa.png\"></a> <a alt=\"Bajar\" title=\"Bajar\" href=\"menu.php?opcion=bajar&orden=".$row['orden']."\"><img src=\"../images/fb.png\"></a> </td>";
				$parse['todoelmenu'] .= "</tr>";
			} else { //si no lo es
				$parse['todoelmenu'] .= "<tr>";
				$parse['todoelmenu'] .= "<td class=\"c\" width=\"15px\" style=\"color:#FFFFFF\"> <a alt=\"Eliminar\" title=\"Eliminar\" href=\"menu.php?opcion=Eliminar&id=".$row['orden']."\"><img src=\"../images/r1.png\"></a> </td>";
				$parse['todoelmenu'] .= "<td align=\"left\" class=\"b\" style=\"color:#FFFFFF\"><div>".$nombremenu."</div></td>";
				$parse['todoelmenu'] .= "<td align=\"center\" class=\"c\" width=\"20px\" style=\"color:#FFFFFF\"><a alt=\"Subir\" title=\"Subir\" href=\"menu.php?opcion=subir&orden=".$row['orden']."\"><img src=\"../images/fa.png\"></a> <a alt=\"Bajar\" title=\"Bajar\" href=\"menu.php?opcion=bajar&orden=".$row['orden']."\"><img src=\"../images/fb.png\"></a> </td>";
				$parse['todoelmenu'] .= "</tr>";
			}
		}
		
	
	break;
	}
	//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/menu'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administración del Menu', '', false);
?>
