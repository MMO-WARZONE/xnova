<?PHP
/**
 * @author Chlorel
 * @copyright (c)  XNova Group
 * Modificado y comentado por SainT.
 */

 
define('INSIDE'  , true); //Definimos inside como verdadero
define('INSTALL' , false); //Definimos install como falso. 


$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)

//si no esta logeado....
if ($IsUserChecked == false) {
	includeLang('login'); //incluimos el archivo de idioma login ( atraves de una funcion )
	message($lang['Login_Ok'], $lang['log_numbreg']); //Mensaje de error y cerramos.
}

includeLang('leftmenu'); //incluimos el archivo de idioma leftmenu ( atraves de una funcion )

//Cargamos las plantillas
$tpl_menu = gettemplate('left_menu');
$tpl_info = gettemplate('serv_infos');

//La información del servidor en la variable $parse (array)
$parse                 = $lang;
$parse['lm_tx_serv']   = $game_config['resource_multiplier'];
$parse['lm_tx_game']   = $game_config['game_speed'] / 2500;
$parse['lm_tx_fleet']  = $game_config['fleet_speed'] / 2500;
$parse['lm_tx_queue']  = MAX_FLEET_OR_DEFS_PER_ROW;
$parse['server_info']  = parsetemplate($tpl_info, $parse);
$parse['XNovaRelease'] = VERSION;
$parse['dpath']        = $dpath;
$parse['forum_url']    = $game_config['forum_url'];
$parse['mf']           = 'Hauptframe';
$parse['servername']   = $game_config['game_name']; 

// Link para Admins y Moderadores
if ($user['authlevel'] > 0) {
	$parse['ADMIN_LINK']  = '<tr><td colspan="2"><div><a href="admin/leftmenu.php"><font color="lime">'.$lang['user_level'][$user['authlevel']].'</font></a></div></td></tr>';
} else {
	$parse['ADMIN_LINK']  = '';
}

//Sacamos El Menu.
$ConsultaMenu = doquery("SELECT * FROM {{table}} order by orden asc", 'menu'); //Sacamos el menu ordenado.
	while ($row = mysql_fetch_assoc($ConsultaMenu)) { //Hacemos un while (lee 1 por 1)	
	
		if($row['lang'] == "0") { //Si el lang es 0 esque se lee desde el leftmenu.mo si no no.
			$nombremenu = $row['nombre'];
			$nombremenu = $lang[$nombremenu];
		} else { //Si no lo es ponemos el nombre tal cual
		$nombremenu = $row['nombre'];
		}
		
		if($row['link'] == NULL) { //Si el link es nulo (es seccion) 
			$parse['todoelmenu'] .= "<tr>";
			$parse['todoelmenu'] .= "<td colspan=\"2\" background=\"".$dpath."img/bg1.gif\"><center>".$nombremenu."</center></td>";
			$parse['todoelmenu'] .= "</tr>";
		} else { //si no lo es
			$parse['todoelmenu'] .= "<tr>";
			$parse['todoelmenu'] .= "<td colspan=\"2\"><div><a href=\"".$row['link']."\" accesskey=\"b\" target=\"Hauptframe\">".$nombremenu."</a></div></td>";		
			$parse['todoelmenu'] .= "</tr>";
		   }

		
	}
//Finalizamos el Parsing
$menu = parsetemplate($tpl_menu, $parse);

display($menu, 'Menu', '', false);

// -----------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo
// rc - el menu se regenera por base de datos
?>
