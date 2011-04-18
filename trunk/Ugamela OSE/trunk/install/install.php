<?php
/*
 * Ugamela OSE
 * install.php - Un tutorial de instalacion.
 * Se preguntaran datos como base de datos sql. Luego se crearan las tablas.
 * Last Revition: 2009.05.03 02:13 (GMT - 03:00)
 *
 * Copyright (C) Perberos (German Augusto Perugorria)
 * Copyright (C) Matsusoft Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 ******************************************************************************/
//Este es el skin...
define('BASE_DIR', '../');
define('SKINPATH', '../templates/opengame/');

function page1()
{
	//una simple pagina de bienvenida
	$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:lime">Bienvenida</b><br>
	</td>
	<td class=b>Bienvenido a el instalador de Ugamela<br><br>
	blablabla. Si tenes alguna sugerencia o problema.<br>
	mail: ugamela@perberos.com.ar<br>
	Tambien puedes subscribirte a la lista de correo<br><br>
	ProjectPage: <a href="https://sourceforge.net/projects/ugamela/">https://sourceforge.net/projects/ugamela/</a><br>
	WebForum: <a href="http://ugamela.perberos.com.ar/">http://ugamela.perberos.com.ar/</a><br>
	Subscribe Maillist: <a href="https://lists.sourceforge.net/lists/listinfo/ugamela-devel">ugamela-devel@lists.sourceforge.net</a><br>
	<br><br>
	<b>International</b><br>
	Bugs or problems, ideas. <a href="http://89.137.169.216/ugamela/">English Forum</a><br>
	<!-- Bugs et Problèmes, Idée et Réactions <a href="http://forum.cflo56.fr.nf/">http://forum.cflo56.fr.nf/</a>--><br>
	<br>
	</td>
  </tr>
  <tr><th colspan=2><a href="?step=2">Siguiente paso</a></th></tr>
</table>';

	display($page, 'Install');
}

function page2()
{
	// Preguntamos los datos sql
	if ($_POST)
	{
		$link = mysql_connect($_POST['dbhost'], $_POST['dbuname'], $_POST['dbpass']) or die(mysql_error());

		// Ahora que esta conectado. si no existe la table, la creamos
		if (isset($_POST['dbmake']))
		{
			mysql_query("CREATE DATABASE `".$_POST['dbname']."`;") or die("Error on make ".$_POST['dbname'].".<br>Error: ".mysql_error());
		}
		//ahora creamos el archivo con el config data.
		make_configfile();

		$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:grey">Welcome</b><br>
	  <b style="color:grey">Datos SQL</b><br>
	  <b style="color:lime">Guardar configuracion</b><br>
	</td>
	<td class=b>Guardar configuracion:<br><br>
		Los datos se guardaron correctamente en el archivo config.php<br>
		los datos para la conexion SQL estan ahi.
		ahora puedes seguir al <a href="?step=3">siguiente paso</a>
	</td>
  </tr>
  <tr><th colspan=2><a href="?step=2">Paso anterior</a> | <a href="?step=3">Siguiente paso</a></th></tr>
</table>';

		display($page, 'Install');
		exit(0);
	}

	$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:grey">Welcome</b><br>
	  <b style="color:lime">Datos SQL</b><br>
	</td>
	<td class=b>Datos SQL:
	<form action="" method="post">
<table>
	<tr>
		<td>DataBase Name</td>
		<td><input name="dbname" type="text" value="" />
		<label><input name="dbmake" type="checkbox"> Make</label></td>
	</tr>
	<tr>
		<td>DataBase Prefix</td>
		<td><input name="db_prefix" type="text" value="ugml_" /></td>
	</tr>
	<tr>
		<td>DataBase Host</td>
		<td><input name="dbhost" type="text" value="localhost" /></td>
	</tr>
	<tr>
		<td>DataBase UserName</td>
		<td><input name="dbuname" type="text" value="" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input name="dbpass" type="password" value="" /></td>
	</tr>
	<tr>
		<td><input type="submit" value="Next" /></td>
		<td></td>
	</tr>
</table>
	</form>
	</td>
  </tr>
  <tr><th colspan=2><a href="?step=1">Paso anterior</a> | <a href="?step=3">Siguiente paso</a></th></tr>
</table>';

	display($page, 'install');
}

function page3()
{
	// creamos las tablas y demas chiches
	if ($_POST)
	{
		install_database();

		$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:grey">Welcome</b><br>
	  <b style="color:grey">Datos SQL</b><br>
	  <b style="color:grey">Guardar configuracion</b><br>
	  <b style="color:grey">Tablas y datos</b><br>
	  <b style="color:lime">Instalar base de datos</b><br>
	</td>
	<td class=b>Base de datos instalada completamente:<br><br>
		Base de datos creada correctamente.<br>
		ahora puedes seguir al <a href="?step=4">siguiente paso</a>
	</td>
  </tr>
  <tr><th colspan=2><a href="?step=3">Paso anterior</a> | <a href="?step=4">Siguiente paso</a></th></tr>
</table>';

		display($page, 'Install');
		exit(0);
	}

	$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:grey">Welcome</b><br>
	  <b style="color:grey">Datos SQL</b><br>
	  <b style="color:grey">Guardar configuracion</b><br>
	  <b style="color:lime">Tablas y datos</b><br>
	</td>
	<td class=b>Tablas y datos:<br><br>
	Ahora se procedera a crear las tablas...<br><br>
	<form action="" method="post">

		<input type="submit" name="install" value="Make" />

	</form>
	</td>
  </tr>
  <tr><th colspan=2><a href="?step=2">Paso anterior</a> | <a href="?step=4">Siguiente paso</a></th></tr>
</table>';

	display($page, 'Install');
}

function page4()
{
	$BASE_DIR = BASE_DIR;
	$page = '<table width=450>
  <tr>
	<td colspan=2 class=b>Instalacion</td>
  </tr>
  <tr>
	<td class=c>Steps:<br>
	  <b style="color:grey">Welcome</b><br>
	  <b style="color:grey">Datos SQL</b><br>
	  <b style="color:grey">Guardar configuracion</b><br>
	  <b style="color:grey">Tablas y datos</b><br>
	  <b style="color:grey">Instalar base de datos</b><br>
	  <b style="color:lime">Finalizado</b><br>
	</td>
	<td class=b>Finalizado:<br><br>
	Ugamela ya se encuentra instalado.<br><br>
	<!-- <b style="color:red"><blink>Es importante:</blink></b><br>
	Ahora solo resta crear la cuenta admin.<br>
	Recuerde que debe registrarse con el nombre "<b>admin</b>"--><br>
	<a href="'.BASE_DIR.'reg.php">Registrar cuenta</a>

	</td>
  </tr>
  <tr><th colspan=2><a href="?step=3">Paso anterior</a> | <a href="'.BASE_DIR.'reg.php">Finalizar</a></th></tr>
</table>';

	display($page, 'Install');
}

function display($dat,$title)
{
	// un simple echo
	echo '<html>
<head>
<title>'.$title.'</title>
<link rel="stylesheet" type="text/css" href="'.SKINPATH.'formate.css" />
</head>
<body>
	<center>'.$dat.'</center>
</body>
</html>';
}

function doquery($query, $table, $fetch = false)
{
	//query
	global $link;

	define('INSIDE', true);

	if (!$link)
	{
		require BASE_DIR.'config.php';

		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or error(mysql_error(),'SQL Error');
		mysql_select_db(DB_NAME) or error(mysql_error(), 'SQL Error');
	}

	$sqlquery = mysql_query(str_replace('{{table}}', DB_PREFIX . $table, $query)) or error(mysql_error(), 'SQL Error');

	if ($fetch)
	{
		//hace el fetch y regresa $sqlrow
		$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}
	else
	{ //devuelve el $sqlquery ("sin fetch")
		return $sqlquery;
	}
}

function make_configfile()
{
	// Make a new configure file. It replace the original with the new settings
	$configfile = BASE_DIR.'config.php';
	// file_exist ask write will be for next revition ;P
	if (file_exists($configfile))
	{
		//try to check if is writeable but it can be completed with error solution description... if somebody want complete!w
		is_writable($configfile) or die('<h1>Forbidden</h1>You do not have permission to write in on this server.');
	}
	// lets make the file
	$file = '<?php
// config.php - Archivo de configuracion
// Este archivo es autogenerado | This files is autogenerated
if (!defined(\'INSIDE\'))
{
	die(\'attemp hacking\');
}

define(\'DB_SERVER\', \''.$_POST['dbhost'].'\'); // MySQL server name. (Default: localhost)
define(\'DB_USERNAME\', \''.$_POST['dbuname'].'\'); // MySQL username.
define(\'DB_PASSWORD\', \''.$_POST['dbpass'].'\'); // GundamMySQL password.
define(\'DB_NAME\', \''.$_POST['dbname'].'\'); // MySQL database name.
define(\'DB_PREFIX\', \''.$_POST['db_prefix'].'\'); // Prefix for table names.
define(\'DB_SECRET_WORD\', \''.time().'\'); // Secret word used when hashing information for cookies.

// Created by Perberos. All rights reversed (C) 2006 //<- Yes! I still using reversed!
?>';
	// Abrimos el archivo o creamos uno nuevo | openfile or make a new
	$nfile = @fopen($configfile, 'w') or die('<h1>Forbidden</h1>You do not have permission to write in on this server.');
	// Metemos el texto | put the text
	fputs($nfile, $file);
	// Lo cerramos |close them
	fclose($nfile);
}

function install_database()
{
	//se crean las tablas
	global $lang;

	define('INSIDE', true);
	// para la lista de recursos
	require BASE_DIR.'includes/vars.php';


	//-[config]------
	{
		$query = "CREATE TABLE {{table}} (
	`config_name` VARCHAR( 64 ) NOT NULL ,
	`config_value` TEXT NOT NULL
	);";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('users_amount', '0');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('game_name', 'Ugamela');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('resource_multiplier', '1');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('debug', '0');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('initial_fields', '163');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('metal_basic_income', '20');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('crystal_basic_income', '10');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('deuterium_basic_income', '0');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('energy_basic_income', '0');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('COOKIE_NAME', 'ugamela');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('allow_invetigate_while_lab_is_update', '0');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('copyright', 'Powered by Ugamela. &copy; 2006. All rights reversed');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('id_g', '1');";

		doquery($query,"config");
		//nuevo sistema progresivo de cuentas
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('id_s', '2');";

		doquery($query,"config");
		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('id_p', '1');";
		doquery($query,"config");

		$query = "	INSERT INTO {{table}} ( `config_name` , `config_value` )
	VALUES ('max_position', '15');";
		doquery($query,"config");


	}


	//-[galaxy]------
	{
		$query = "CREATE TABLE {{table}} (
  `galaxy` int(2) NOT NULL default '0',
  `system` int(3) NOT NULL default '0',
  `planet` int(2) NOT NULL default '0',
  `id_planet` int(11) NOT NULL default '0',
  `metal` int(11) NOT NULL default '0',
  `crystal` int(11) NOT NULL default '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`)
) TYPE=MyISAM;";
		doquery($query,"galaxy");
	}

	//-[planets]------
	{
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `id_owner` int(11) default NULL,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `last_update` int(11) default NULL,
  `planet_type` int(11) NOT NULL DEFAULT 1,
  `destruyed` int(11) NOT NULL default '0',
  `b_building` int(11) NOT NULL DEFAULT 0,
  `b_building_id` int(11) NOT NULL DEFAULT 0,
  `b_tech` int(11) NOT NULL DEFAULT 0,
  `b_tech_id` int(11) NOT NULL DEFAULT 0,
  `b_hangar` int(11) NOT NULL DEFAULT 0,
  `b_hangar_id` text NOT NULL DEFAULT '',
  `b_hangar_plus` int(11) NOT NULL DEFAULT 0,
  `image` char(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',

  `points` bigint(20) default '0',
  `ranks` bigint(20) default '0',

  `field_current` int(11) NOT NULL default '0',
  `field_max` int(11) NOT NULL default '163',
  `temp_min` int(3) NOT NULL default '-17',
  `temp_max` int(3) NOT NULL default '23',
  `metal` double(16,6) NOT NULL default '0.000000',
  `metal_perhour` int(11) NOT NULL default '0',
  `metal_max` bigint(20) default '100000',
  `crystal` double(16,6) NOT NULL default '0.000000',
  `crystal_perhour` int(11) NOT NULL default '0',
  `crystal_max` bigint(20) default '100000',
  `deuterium` double(16,6) NOT NULL default '0.000000',
  `deuterium_perhour` int(11) NOT NULL default '0',
  `deuterium_max` bigint(20) default '100000',
  `energy_used` int(11) NOT NULL default '0',
  `energy_max` int(11) NOT NULL default '0',
  `".$resource["1"]."` int(11) NOT NULL default '0',
  `".$resource["2"]."` int(11) NOT NULL default '0',
  `".$resource["3"]."` int(11) NOT NULL default '0',
  `".$resource["4"]."` int(11) NOT NULL default '0',
  `".$resource["12"]."` int(11) NOT NULL default '0',
  `".$resource["14"]."` int(11) NOT NULL default '0',
  `".$resource["15"]."` int(11) NOT NULL default '0',
  `".$resource["21"]."` int(11) NOT NULL default '0',
  `".$resource["22"]."` int(11) NOT NULL default '0',
  `".$resource["23"]."` int(11) NOT NULL default '0',
  `".$resource["24"]."` int(11) NOT NULL default '0',
  `".$resource["31"]."` int(11) NOT NULL default '0',
  `".$resource["33"]."` int(11) NOT NULL default '0',
  `".$resource["34"]."` int(11) NOT NULL default '0',
  `".$resource["44"]."` int(11) NOT NULL default '0',

  `".$resource["202"]."` int(11) NOT NULL default '0',
  `".$resource["203"]."` int(11) NOT NULL default '0',
  `".$resource["204"]."` int(11) NOT NULL default '0',
  `".$resource["205"]."` int(11) NOT NULL default '0',
  `".$resource["206"]."` int(11) NOT NULL default '0',
  `".$resource["207"]."` int(11) NOT NULL default '0',
  `".$resource["208"]."` int(11) NOT NULL default '0',
  `".$resource["209"]."` int(11) NOT NULL default '0',
  `".$resource["210"]."` int(11) NOT NULL default '0',
  `".$resource["211"]."` int(11) NOT NULL default '0',
  `".$resource["212"]."` int(11) NOT NULL default '0',
  `".$resource["213"]."` int(11) NOT NULL default '0',
  `".$resource["214"]."` int(11) NOT NULL default '0',
  `".$resource["215"]."` int(11) NOT NULL default '0',

  `".$resource["401"]."` int(11) NOT NULL default '0',
  `".$resource["402"]."` int(11) NOT NULL default '0',
  `".$resource["403"]."` int(11) NOT NULL default '0',
  `".$resource["404"]."` int(11) NOT NULL default '0',
  `".$resource["405"]."` int(11) NOT NULL default '0',
  `".$resource["406"]."` int(11) NOT NULL default '0',
  `".$resource["407"]."` int(11) NOT NULL default '0',
  `".$resource["408"]."` int(11) NOT NULL default '0',
  `".$resource["502"]."` int(11) NOT NULL default '0',
  `".$resource["503"]."` int(11) NOT NULL default '0',

  `".$resource["1"]."_porcent` int(11) NOT NULL DEFAULT 10,
  `".$resource["2"]."_porcent` int(11) NOT NULL DEFAULT 10,
  `".$resource["3"]."_porcent` int(11) NOT NULL DEFAULT 10,
  `".$resource["4"]."_porcent` int(11) NOT NULL DEFAULT 10,
  `".$resource["12"]."_porcent` int(11) NOT NULL DEFAULT 10,
  `".$resource["212"]."_porcent` int(11) NOT NULL DEFAULT 10,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"planets");
	}

	//-[notes]------
	{
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) default NULL,
  `time` int(11) default NULL,
  `priority` tinyint(1) default NULL,
  `title` varchar(32) default NULL,
  `text` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"notes");
	}

	//-[forum]------
	{
		$query = "CREATE TABLE {{table}} (
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `cat_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_name` varchar(150) default NULL,
  `forum_desc` text,
  `forum_status` tinyint(4) NOT NULL default '0',
  `forum_order` mediumint(8) unsigned NOT NULL default '1',
  `forum_posts` mediumint(8) unsigned NOT NULL default '0',
  `forum_topics` mediumint(8) unsigned NOT NULL default '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `prune_next` int(11) default NULL,
  `prune_enable` tinyint(1) NOT NULL default '0',
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_read` tinyint(2) NOT NULL default '0',
  `auth_post` tinyint(2) NOT NULL default '0',
  `auth_reply` tinyint(2) NOT NULL default '0',
  `auth_edit` tinyint(2) NOT NULL default '0',
  `auth_delete` tinyint(2) NOT NULL default '0',
  `auth_sticky` tinyint(2) NOT NULL default '0',
  `auth_announce` tinyint(2) NOT NULL default '0',
  `auth_vote` tinyint(2) NOT NULL default '0',
  `auth_pollcreate` tinyint(2) NOT NULL default '0',
  `auth_attachments` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`)
) TYPE=MyISAM;
";

		doquery($query,"forum_cat");

		doquery("INSERT INTO {{table}} VALUES (1,1,'Anuncios, Politica y Reglas de Ugamela','Noticias de los admininstradores\, programadores y desarrolladores.',0,10,0,0,0,NULL,0,0,0,3,3,3,3,3,3,3,3,3);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (2,2,'Soporte & Ayuda','Este es el lugar indicado para la gente que no entiende una goma del juego.',0,10,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (3,2,'Errores & Bugs','Esos errores tanto visuales, de programación, o incluso las fé de errata.',0,20,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (4,2,'Sugerencias','Estamos abiertos a toda ayuda que nos de el publico con tal de mejorar.',0,30,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (5,2,'Quejas','Si algo te molesta, dilo.<br>No te quedes con la palabra en la boca.',0,40,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (6,2,'OffTopic','Temas que son relacionados con el juego o no.<br>\r\nAlgun comentario o un consejo a los jugadores. Todo eso acE',0,50,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (7,3,'General [BETA]','Esta sección del foro permanecera cerrada, hasta que se concreten los sistemas correspondientes relacionados a este tema. Gracias',0,10,0,0,0,NULL,0,0,0,3,1,1,3,3,3,1,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (8,4,'Laboratorio de investigaciones','Sector donde se prueban experimentos y se desarrollan teorias. Además de servir como vitacora de procedimientos.<br>\r\nEn este foro se discutirá asuntos del juego, su estructura, sistema. algoritmias, invenciones, etc.<br>Fundamentalmente para el desarrollo del juego.',0,10,0,0,0,NULL,0,0,0,3,3,3,3,3,3,3,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (9,4,'Solo Mods & Admins','Solo visible para los Administradores y Moderadores.<br>\r\nEn este foro se discutirá asuntos del juego y usuarios.',0,20,0,0,0,NULL,0,3,3,3,3,3,3,3,3,3,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (10,4,'Papelera de Reciclaje','Todos los temas y demás post que se consideran obsoletos. Son depositados acE para no borrarlos.',0,10,0,0,0,NULL,0,0,0,3,3,3,3,3,3,3,3,0);","forum_cat");

		$query = "CREATE TABLE {{table}} (
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_order` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
) TYPE=MyISAM;";
		doquery($query,"forum_categories");

		doquery("INSERT INTO {{table}} (`cat_id`,`cat_title`,`cat_order`) VALUES (1,'Anuncios y avisos',10);","forum_categories");
		doquery("INSERT INTO {{table}} (`cat_id`,`cat_title`,`cat_order`) VALUES (2,'General',20);","forum_categories");
		doquery("INSERT INTO {{table}} (`cat_id`,`cat_title`,`cat_order`) VALUES (3,'Alianzas',30);","forum_categories");
		doquery("INSERT INTO {{table}} (`cat_id`,`cat_title`,`cat_order`) VALUES (4,'Otros',40);","forum_categories");

		$query = "CREATE TABLE {{table}} (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) NOT NULL default '',
  `post_subject` varchar(60) default NULL,
  `post_text` text,
  PRIMARY KEY  (`post_id`)
) TYPE=MyISAM;";
		doquery($query,"forum_posts_text");

		$query = "CREATE TABLE {{table}} (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `poster_id` mediumint(8) NOT NULL default '0',
  `post_time` int(11) NOT NULL default '0',
  `poster_ip` varchar(8) NOT NULL default '',
  `post_username` varchar(25) default NULL,
  `enable_bbcode` tinyint(1) NOT NULL default '1',
  `enable_html` tinyint(1) NOT NULL default '0',
  `enable_smilies` tinyint(1) NOT NULL default '1',
  `enable_sig` tinyint(1) NOT NULL default '1',
  `post_edit_time` int(11) default NULL,
  `post_edit_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`)
) TYPE=MyISAM;";
		doquery($query,"forum_posts");

		$query = "CREATE TABLE {{table}} (
  `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(8) unsigned NOT NULL default '0',
  `topic_title` char(60) NOT NULL default '',
  `topic_poster` mediumint(8) NOT NULL default '0',
  `topic_time` int(11) NOT NULL default '0',
  `topic_views` mediumint(8) unsigned NOT NULL default '0',
  `topic_replies` mediumint(8) unsigned NOT NULL default '0',
  `topic_status` tinyint(3) NOT NULL default '0',
  `topic_vote` tinyint(1) NOT NULL default '0',
  `topic_type` tinyint(3) NOT NULL default '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`)
) TYPE=MyISAM;";
		doquery($query,"forum_topics");
	}

	//-[alliance]------
	{
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `ally_name` varchar(32) default '',
  `ally_tag` varchar(8) default '',
  `ally_owner` int(11) NOT NULL default '0',
  `ally_register_time` int(11) NOT NULL default '0',

  `ally_description` text,
  `ally_web` varchar(255) default '',
  `ally_text` text,
  `ally_image` varchar(255) default '',
  `ally_request` text NULL,
  `ally_request_waiting` text NULL,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT 0,
  `ally_owner_range` varchar(32) default '',
  `ally_ranks` text NULL,

  `ally_members` int(11) NOT NULL default '0',
  `ally_points` bigint(20) NOT NULL default '0',
  `ally_points_builds` int(11) NOT NULL default '0',
  `ally_points_fleet` int(11) NOT NULL default '0',
  `ally_points_tech` int(11) NOT NULL default '0',
  `ally_points_builds_old` int(11) NOT NULL default '0',
  `ally_points_fleet_old` int(11) NOT NULL default '0',
  `ally_points_tech_old` int(11) NOT NULL default '0',
  `ally_members_points` int(11) NOT NULL default '0',


  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"alliance");
	}

	//-[users]------
	{
		$query =  "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_2` varchar(64) NOT NULL default '',
  `lang` char(8) NOT NULL DEFAULT 'es',
  `authlevel` tinyint(4) NOT NULL DEFAULT 0,
  `sex` char(1) NULL,
  `avatar` char(255) NOT NULL DEFAULT '',
  `sign` text,
  `id_planet` int(11) NOT NULL default '0',
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `current_planet` int(11) NOT NULL default '0',
  `user_lastip` varchar(16) NOT NULL default '',
  `register_time` int(11) NOT NULL DEFAULT 0,
  `onlinetime` int(11) NOT NULL default '0',
  `dpath` varchar(255) NOT NULL default '',
  `design` tinyint(4) NOT NULL default '1',
  `noipcheck` tinyint(4) NOT NULL default '1',
  `spio_anz` tinyint(4) NOT NULL default '1',
  `settings_tooltiptime` tinyint(4) NOT NULL default '5',
  `settings_fleetactions` tinyint(4) NOT NULL default '0',
  `settings_allylogo` tinyint(4) NOT NULL default '0',
  `settings_esp` tinyint(4) NOT NULL default '1',
  `settings_wri` tinyint(4) NOT NULL default '1',
  `settings_bud` tinyint(4) NOT NULL default '1',
  `settings_mis` tinyint(4) NOT NULL default '1',
  `settings_rep` tinyint(4) NOT NULL default '0',
  `urlaubs_modus` tinyint(4) NOT NULL default '0',
  `db_deaktjava` tinyint(4) NOT NULL default '0',

  `points_builds` bigint(20) NOT NULL default '0',
  `points_tech` bigint(20) NOT NULL default '0',
  `points_fleet` bigint(20) NOT NULL default '0',
  `points_builds2` bigint(20) NOT NULL default '0',
  `points_tech2` bigint(20) NOT NULL default '0',
  `points_fleet2` bigint(20) NOT NULL default '0',
  `points_builds_old` bigint(20) NOT NULL default '0',
  `points_tech_old` bigint(20) NOT NULL default '0',
  `points_fleet_old` bigint(20) NOT NULL default '0',

  `points_points` bigint(20) NOT NULL default '0',

  `rank` int(11) NOT NULL default '0',
  `new_message` int(11) NOT NULL DEFAULT 0,
  `fleet_shortcut` text NULL,
  `b_tech_planet` int(11) NOT NULL DEFAULT 0,
  `".$resource["106"]."` int(11) NOT NULL default '0',
  `".$resource["108"]."` int(11) NOT NULL default '0',
  `".$resource["109"]."` int(11) NOT NULL default '0',
  `".$resource["110"]."` int(11) NOT NULL default '0',
  `".$resource["111"]."` int(11) NOT NULL default '0',
  `".$resource["113"]."` int(11) NOT NULL default '0',
  `".$resource["114"]."` int(11) NOT NULL default '0',
  `".$resource["115"]."` int(11) NOT NULL default '0',
  `".$resource["117"]."` int(11) NOT NULL default '0',
  `".$resource["118"]."` int(11) NOT NULL default '0',
  `".$resource["120"]."` int(11) NOT NULL default '0',
  `".$resource["121"]."` int(11) NOT NULL default '0',
  `".$resource["122"]."` int(11) NOT NULL default '0',
  `".$resource["123"]."` int(11) NOT NULL default '0',
  `".$resource["199"]."` int(11) NOT NULL default '0',

  `ally_id` int(11) NOT NULL DEFAULT 0,
  `ally_name` varchar(32) DEFAULT '',
  `ally_request` int(11) NOT NULL DEFAULT 0,
  `ally_rank_id` int(11) NOT NULL DEFAULT 0,
  `ally_request_text` text NULL,
  `ally_register_time` int(11) NOT NULL default '0',

  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_planet` (`id_planet`)
) TYPE=MyISAM;";
		doquery($query,"users");
	}

	//-[message]------
	{
		$query = "CREATE TABLE {{table}} (
  `message_id` int(11) NOT NULL auto_increment,
  `message_owner` int(11) NOT NULL default '0',
  `message_sender` int(11) NOT NULL default '0',
  `message_time` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `message_from` varchar(32) default NULL,
  `message_subject` varchar(32) default NULL,
  `message_text` text,
  PRIMARY KEY  (`message_id`)
) TYPE=MyISAM;";
		doquery($query,"messages");
	}

	//-[errors]------
	{
		$query = "CREATE TABLE {{table}} (
  `error_id` int(11) NOT NULL auto_increment,
  `error_sender` varchar(32) NOT NULL default '0',
  `error_time` int(11) NOT NULL default '0',
  `error_type` varchar(32) NOT NULL default 'unknown',
  `error_text` text,
  PRIMARY KEY  (`error_id`)
) TYPE=MyISAM;";
		doquery($query,"errors");
	}
	//-[fleets]------
	{
		$query = "CREATE TABLE {{table}} (
  `fleet_id` int(11) NOT NULL auto_increment,
  `fleet_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_mission` int(11) NOT NULL default '0',
  `fleet_amount` int(11) NOT NULL default '0',
  `fleet_array` text,
  `fleet_start_time` int(11) NOT NULL default '0',
  `fleet_start_galaxy` int(11) NOT NULL default '0',
  `fleet_start_system` int(11) NOT NULL default '0',
  `fleet_start_planet` int(11) NOT NULL default '0',
  `fleet_start_type` int(11) NOT NULL default '0',
  `fleet_end_time` int(11) NOT NULL default '0',
  `fleet_end_galaxy` int(11) NOT NULL default '0',
  `fleet_end_system` int(11) NOT NULL default '0',
  `fleet_end_planet` int(11) NOT NULL default '0',
  `fleet_end_type` int(11) NOT NULL default '0',
  `fleet_resource_metal` int(11) NOT NULL DEFAULT 0,
  `fleet_resource_crystal` int(11) NOT NULL DEFAULT 0,
  `fleet_resource_deuterium` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`fleet_id`)
) TYPE=MyISAM;";
		doquery($query,"fleets");
	}

	//-[buddy]------
	{
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
";
		doquery($query,"buddy");
	}


	//-[buddy]------
	{
		$query = "CREATE TABLE {{table}} (
  `themes_id` mediumint(8) NOT NULL auto_increment,
  `template_name` varchar(30),
  `style_name` varchar(30),
  `head_stylesheet` varchar(100),
  PRIMARY KEY  (`themes_id`)
) TYPE=MyISAM;
";
		doquery($query,"themes");
	}

	//-[End]------

}
//inicio

function error($mes, $title = 'Error')
{
	global $link;

	echo '<html>
<head>
<title>'.$lang['ErrorPage'].'</title>
<link rel="stylesheet" type="text/css" href="'.SKINPATH.'formate.css" />
<meta http-equiv="content-type" content="text/html; charset='.$lang['ENCODING'].'" />
</head>
<body>
 <center>
 <br><br>

 <table width="519">
 <tr>
   <td class="c"><font color="red">'.$title.'</font></td>
  </tr>
  <tr>
   <th class="errormessage">'.$mes.'</th>

  </tr>
 </table>
 </center>
</body>
</html>';

	if ($link)
	{
		mysql_close();
	}

	die();
}

// Inicio
switch ($_GET['step'])
{
	case 2:
	{
		page2();
		break;
	}
	case 3:
	{
		page3();
		break;
	}
	case 4:
	{
		page4();
		break;
	}
	default:
	{
		page1();// pagina de bienvenida
	}
}

?>
