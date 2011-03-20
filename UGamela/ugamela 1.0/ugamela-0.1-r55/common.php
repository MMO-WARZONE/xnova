<?php  //common.php :: Contain common functions

/*
	Ugamela v0.1 build.43
	
	ugamela@perberos.com.ar
*/

if ( !defined('INSIDE') )
{
	die("Hacking attempt");
}
	
	
//error_reporting  (E_ERROR | E_WARNING | E_PARSE);
//set_magic_quotes_runtime(0);



header("X-Powered-By: Ugamela");
define('VERSION','0.1');
error_reporting  (E_ERROR | E_WARNING | E_PARSE); // Para evitar que se reporten las variables no iniciadas
set_magic_quotes_runtime(0); // Deshabilita magic_quotes_runtime

extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);


//
// Definimos algunas arrays de configuracion.
//
$game_config = array();
$user = array();
$theme = array();
$images = array();
$lang = array();

//
// Constantes
//
//http://80.237.203.201/download/use/reloaded/
//http://people.freenet.de/kakashi/Maya/
define('DEFAULT_SKINPATH',"http://people.freenet.de/kakashi/Maya/");
define('TEMPLATE_DIR',"templates/");
define('TEMPLATE_NAME',"OpenGame");

//
//lenguaje...
//
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	$HTTP_ACCEPT_LANGUAGE = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
}else{
	$HTTP_ACCEPT_LANGUAGE = "es";
}//default language}
if(is_dir($ugamela_root_path."language/".$HTTP_ACCEPT_LANGUAGE.'/')){
	define('DEFAULT_LANG',$HTTP_ACCEPT_LANGUAGE);
}else{
	define('DEFAULT_LANG','es');
}



//include($ugamela_root_path . 'config.'.$phpEx);

// no muy necesario ...
//if( !defined("UGAMELA_INSTALLED") )
//{
//	header('Location: ' . $ugamela_root_path . 'install/install.' . $phpEx);
//	exit;
//}

//--[ DEPURAR ]-------------------------------------------------------------
//Objeto debug
include($ugamela_root_path . 'includes/debug.class.'.$phpEx);
$debug = new debug;
//--[ /DEPURAR ]------------------------------------------------------------

include($ugamela_root_path . 'includes/constants.'.$phpEx);
include($ugamela_root_path . 'includes/functions.'.$phpEx);
include($ugamela_root_path . 'includes/vars.'.$phpEx);
include($ugamela_root_path . 'includes/db.'.$phpEx);
include($ugamela_root_path . 'includes/planet_maker.'.$phpEx);
include($ugamela_root_path . 'includes/strings.'.$phpEx);

/*
  Aqui realizamos la obtencion de datos de datos del juego.

*/
$query = doquery("SELECT * FROM {{table}}",'config');

while ( $row = mysql_fetch_assoc($query) )
{
	$game_config[$row['config_name']] = $row['config_value'];
}

include($ugamela_root_path."language/".DEFAULT_LANG."/lang_info.cfg");

//
// Muestra un mensaje de Servidor cerrado.
//
if( $game_config['game_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	//message('El juego ha sido cerrado, Intenta volver en otro momento.', 'Juego cerrado');
}


// Created by Perberos. All rights reversed (C) 2006
?>
