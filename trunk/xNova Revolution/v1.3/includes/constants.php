<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if ( !defined('INSIDE') ) die(header("location:../"));

	# Ruta por defecto de templates y el skin
	define('DEFAULT_SKINPATH' 		 , 'styles/skins/wofplanet/');
	define('TEMPLATE_DIR'     		 , 'styles/templates/');

	# Email del administrador y direccion url del juego
	define('ADMINEMAIL'               , "brayan.narvaez@ocrend.com");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	# Datos de universo: GALAXIA, PLANETAS, SISTEMAS SOLARES.
	define('MAX_GALAXY_IN_WORLD'      ,   9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     ,  15);

    # Numero de columnas por mensaje de espionaje
	define('SPY_REPORT_ROW'           , 4);

	# Campos por base lunar en la luna
	define('FIELDS_BY_MOONBASIS_LEVEL', 3);

	# Campos por terraformer en el planeta
	define('FIELDS_BY_TERRAFORMER'	  , 5);

	# Maximos planetas por usuario, contando el principal
	define('MAX_PLAYER_PLANETS'       , 10);

	# Cola de edificios
	define('MAX_BUILDING_QUEUE_SIZE'  , 5);

	# Cola de produccion en el hangar
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000);

	# Recursos en contenedores para que no se produzca mas
	# 1.0 es al 100% - 1.1 para 110% etc...
	define('MAX_OVERFLOW'             , 1);

	# Recursos iniciales en el planeta
	define('BASE_STORAGE_SIZE'        ,  100000);
	define('BUILD_METAL'              ,    1500);
	define('BUILD_CRISTAL'            ,    1500);
	define('BUILD_DEUTERIUM'          , 	500);
    define('BUILD_DARKMATTER'         , 	250);

	# Valores por defecto de los oficiales
	define('COMMANDANT'				  ,      3);
	define('AMIRAL'				  	  ,   0.05);
	define('ESPION'				  	  ,      5);
	define('CONSTRUCTEUR'             ,    0.1);
	define('SCIENTIFIQUE'			  ,    0.1);
	define('GENERAL'			      ,   0.10);
	define('DEFENSEUR'			  	  ,   0.25);
	define('TECHNOCRATE'			  ,   0.05);
	define('STOCKEUR'				  ,    0.5);
	define('GEOLOGUE'				  ,   0.05);
	define('INGENIEUR'				  ,   0.05);

	# Cantidad de materia oscura requerida en el mercader
	define('TR_DARK_MATTER'			  ,   2500);

?>
