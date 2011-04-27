<?php
	//######################################################//
	//# Name:      config-idioma.php 					   #//
	//# Authors:   SainT  								   #//
	//# Copyright: OgameRC.com 							   #//
	//# Website:   http://www.xnova.saint-rc.es            #//
	//######################################################//
	
	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 
	define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

	$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
		//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
	
	unset($lang); //vaciamos el array
	
	if(isset($_GET['archivo'])) { //si existe la var en la url
	includeLang($_GET['archivo']); //incluimos el archivo de idioma
	
	
	$Buscar = '<';
	foreach( $lang as $opcion => $valor ) { //pasamos valor por valor
	$valor = htmlentities($valor, ENT_QUOTES);  
	$parse['idioma'] .= "<tr>"; 
	$parse['idioma'] .= "<td class=\"c\" style=\"color:#FFFFFF\"><strong>".$valor."</strong></td>";
	$parse['idioma'] .= "<td class=\"b\" align=\"center\" ><input style=\"width:100%;\" name=\"".$opcion."\" type=\"text\" value=\"".$valor."\"/></td>";
	$parse['idioma'] .= "</tr>";
	
	} //Fin foreach
	} //Fin if
	if($_POST) { //Si actualizaron
	$c = 0; //Contador = 0;
	$texto = "<?php\n\r"; //iniciamos el php
	unset($lang); //borramos la variable
		foreach($_POST as $opcion => $valor ) { //pasamos valor por valor
		if($c != 0) {
		$texto .= "$";
		$texto .= "lang[".$opcion."] = \"".$valor."\";\n";
		} //fin contador if
		$c++;
		} //Fin foreach
		$texto .= "\n\r?>"; //finalizamos el php
		$archivo = "../language/es/".$_GET['archivo'].".mo";

		$fp = fopen($archivo, "w+");
		$escribir = fputs($fp, $texto);
		fclose($fp);
			header("Location: ./config-idioma.php?archivo=".$_GET['archivo'].""); //reidirigimos a config-idioma.php
	} //Fin _post
	//Finalizamos el Parsing
	
	$tpl_menu = gettemplate('admin/config_idioma_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Administracion de idiomas', '', false);
	?>