<?php

include("common.php");

$id = (isset($_REQUEST['id']))? $_REQUEST['id'] : '';
//instalacion simple. "no completa"

switch ($id){
	case "resouce":{
		$query =  "CREATE TABLE `resource` (`id` INT NOT NULL ,`type` VARCHAR( 8 ) NOT NULL ,`name` VARCHAR( 32 ) NOT NULL ,`title` VARCHAR( 32 ) NOT NULL);";
		doquery($query,"");}
	break;
	
	case "galaxy":{
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
		doquery($query,"galaxy");}
	break;
	
	case "planets":{
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
  `image` char(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',
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
  `energy_free` int(11) NOT NULL default '0',
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
  
  `metalmine_porcent` int(11) NOT NULL DEFAULT 0,
  `crystalmine_porcent` int(11) NOT NULL DEFAULT 0,
  `deuterium_porcent` int(11) NOT NULL DEFAULT 0,
  `solarplant_porcent` int(11) NOT NULL DEFAULT 0,
  `fusion_porcent` int(11) NOT NULL DEFAULT 0,
  `satelite_porcent` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"planets");}
	break;
	
	case "notes":{
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) default NULL,
  `time` int(11) default NULL,
  `priority` tinyint(1) default NULL,
  `title` varchar(32) default NULL,
  `text` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"notes");}
	break;
	
	case "changelog":{
	
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(32) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"changelog");}
	break;
	
	case "forum":{
	
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
		doquery("INSERT INTO {{table}} VALUES (6,2,'OffTopic','Temas que son relacionados con el juego o no.<br>\r\nAlgun comentario o un consejo a los jugadores. Todo eso acá.',0,50,0,0,0,NULL,0,0,0,1,1,1,1,3,3,1,1,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (7,3,'General [BETA]','Esta sección del foro permanecera cerrada, hasta que se concreten los sistemas correspondientes relacionados a este tema. Gracias',0,10,0,0,0,NULL,0,0,0,3,1,1,3,3,3,1,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (8,4,'Laboratorio de investigaciones','Sector donde se prueban experimentos y se desarrollan teorias. Además de servir como vitacora de procedimientos.<br>\r\nEn este foro se discutirán asuntos del juego, su estructura, sistema. algoritmias, invenciones, etc.<br>Fundamentalmente para el desarrollo del juego.',0,10,0,0,0,NULL,0,0,0,3,3,3,3,3,3,3,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (9,4,'Solo Mods & Admins','Solo visible para los Administradores y Moderadores.<br>\r\nEn este foro se discutirán asuntos del juego y usuarios.',0,20,0,0,0,NULL,0,3,3,3,3,3,3,3,3,3,3,0);","forum_cat");
		doquery("INSERT INTO {{table}} VALUES (10,4,'Papelera de Reciclaje','Todos los temas y demás post que se consideran obsoletos. Son depositados acá, para no borrarlos.',0,10,0,0,0,NULL,0,0,0,3,3,3,3,3,3,3,3,0);","forum_cat");
		
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
		doquery($query,"forum_topics");}
	break;
	
	case "alliance":{
		
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `ally_name` varchar(32) default '',
  `ally_tag` varchar(8) default '',
  `ally_owner` int(11) NOT NULL default '0',
  `ally_description` text,
  `ally_web` varchar(255) default '',
  `ally_text` text,
  `ally_image` varchar(255) default '',
  `ally_request` text NULL,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT 0,
  `ally_owner_range` varchar(32) default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";
		doquery($query,"alliance");}
	break;
	
	case "users":{
		$query =  "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_first` varchar(64) NOT NULL default '',
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
  `points` bigint(20) NOT NULL default '0',
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
  `ally_request` int(11) NOT NULL DEFAULT 0,
  `ally_register_time` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_planet` (`id_planet`)
) TYPE=MyISAM;";
		doquery($query,"users");}
	break;
	
	case "message":{
	
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
		doquery($query,"messages");}
	break;
	
	case "fleets":{
	
		$query = "CREATE TABLE {{table}} (
  `fleet_id` int(11) NOT NULL auto_increment,
  `fleet_owner` int(11) NOT NULL DEFAULT '0',
  `fleet_mission` int(11) NOT NULL default '0',
  `fleet_amount` int(11) NOT NULL default '0',
  `fleet_array` text,
  `fleet_star_time` int(11) NOT NULL default '0',
  `fleet_start_galaxy` int(11) NOT NULL default '0',
  `fleet_start_system` int(11) NOT NULL default '0',
  `fleet_start_planet` int(11) NOT NULL default '0',
  `fleet_start_type` int(11) NOT NULL default '0',
  `fleet_star_end` int(11) NOT NULL default '0',
  `fleet_end_galaxy` int(11) NOT NULL default '0',
  `fleet_end_system` int(11) NOT NULL default '0',
  `fleet_end_planet` int(11) NOT NULL default '0',
  `fleet_end_type` int(11) NOT NULL default '0',
  `fleet_resource_metal` int(11) NOT NULL DEFAULT 0,
  `fleet_resource_crystal` int(11) NOT NULL DEFAULT 0,
  `fleet_resource_deuterium` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`fleet_id`)
) TYPE=MyISAM;";
		doquery($query,"fleets");}
	break;
	
  case "buddy":{
	
		$query = "CREATE TABLE {{table}} (
  `id` int(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
";
		doquery($query,"buddy");}
	break;
  
	default:{
	echo_head("Install");
	echo '<center>
	<h2>Instalaci&oacute;n</h2><br /><br />
	Resource [ <a href="install.php?id=resouce">Instalar</a> ]<br /><br />
	Galaxy [ <a href="install.php?id=galaxy">Instalar</a>] <br /><br />
	Planets [ <a href="install.php?id=planets">Instalar</a> ]<br /><br />
	Notes [ <a href="install.php?id=notes">Instalar</a> ]<br /><br />
	Users [ <a href="install.php?id=users">Instalar</a> ]<br /><br />
	Forum [ <a href="install.php?id=forum">Instalar</a> ]<br /><br />
	Alliance [ <a href="install.php?id=alliance">Instalar</a> ]<br /><br />
	Message [ <a href="install.php?id=message">Instalar</a> ]<br /><br />
	Fleets [ <a href="install.php?id=fleets">Instalar</a> ]<br /><br />
	Buddy [ <a href="install.php?id=buddy">Instalar</a> ]<br /><br />
	Changelog [ <a href="install.php?id=changelog">Instalar</a> ]<br /><br />
	</center>';}


}

?><center><a href="./">./</a> <a href="install.php">install.php</a></center>
