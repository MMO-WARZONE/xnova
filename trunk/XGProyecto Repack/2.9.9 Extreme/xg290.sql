-- MySQL dump 10.11
--
-- Host: mysql1065.servage.net    Database: xg290
-- ------------------------------------------------------
-- Server version	5.0.85
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `xgp_aks`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_aks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(50) character set latin1 collate latin1_general_ci default NULL,
  `teilnehmer` text character set latin1 collate latin1_general_ci,
  `flotten` text character set latin1 collate latin1_general_ci,
  `ankunft` int(32) default NULL,
  `galaxy` int(2) default NULL,
  `system` int(4) default NULL,
  `planet` int(2) default NULL,
  `planet_type` tinyint(1) default NULL,
  `eingeladen` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_aks`
--


--
-- Table structure for table `xgp_alliance`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_alliance` (
  `id` bigint(11) NOT NULL auto_increment,
  `ally_name` varchar(32) default '',
  `ally_tag` varchar(8) default '',
  `ally_owner` int(11) NOT NULL default '0',
  `ally_register_time` int(11) NOT NULL default '0',
  `ally_description` text,
  `ally_web` varchar(255) default '',
  `ally_text` text,
  `ally_image` varchar(255) default '',
  `ally_request` text,
  `ally_request_waiting` text,
  `ally_request_notallow` tinyint(4) NOT NULL default '0',
  `ally_owner_range` varchar(32) default '',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_alliance`
--

INSERT INTO `xgp_alliance` VALUES (4,'´stadd','´staff',1,1305367843,NULL,'',NULL,'',NULL,NULL,0,'Leader',NULL,1);
INSERT INTO `xgp_alliance` VALUES (5,'asd','asd',25,1308474136,NULL,'',NULL,'',NULL,NULL,0,'Leader',NULL,1);

--
-- Table structure for table `xgp_annonce`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_annonce` (
  `id` int(11) NOT NULL auto_increment,
  `user` text character set latin1 collate latin1_general_ci NOT NULL,
  `type` int(11) NOT NULL,
  `galaxie` int(11) NOT NULL,
  `systeme` int(11) NOT NULL,
  `planete` int(11) NOT NULL,
  `vaisseau` bigint(11) NOT NULL,
  `nombrevaisseau` bigint(20) NOT NULL,
  `metala` bigint(20) NOT NULL,
  `cristala` bigint(20) NOT NULL,
  `deuta` bigint(20) NOT NULL,
  `metals` bigint(20) NOT NULL,
  `cristals` bigint(20) NOT NULL,
  `deuts` bigint(20) NOT NULL,
  `datefin` int(11) NOT NULL,
  `reserve` bigint(20) NOT NULL,
  `defense` bigint(11) NOT NULL,
  `nombredefense` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_annonce`
--


--
-- Table structure for table `xgp_banned`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_banned` (
  `id` bigint(11) NOT NULL auto_increment,
  `who` varchar(64) NOT NULL default '',
  `theme` text NOT NULL,
  `who2` varchar(64) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  `longer` int(11) NOT NULL default '0',
  `author` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  KEY `ID` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_banned`
--


--
-- Table structure for table `xgp_bots`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_bots` (
  `id` bigint(11) NOT NULL auto_increment,
  `player` bigint(11) NOT NULL,
  `last_time` int(11) NOT NULL,
  `every_time` int(11) NOT NULL,
  `last_planet` bigint(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_bots`
--

INSERT INTO `xgp_bots` VALUES (1,25,1308828935,100,34,0);

--
-- Table structure for table `xgp_buddy`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_buddy` (
  `id` bigint(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  `text` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_buddy`
--

INSERT INTO `xgp_buddy` VALUES (1,33,1,1,'teste');

--
-- Table structure for table `xgp_chat`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_chat` (
  `messageid` int(5) unsigned NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `timestamp` int(11) NOT NULL default '0',
  `ally_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`messageid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_chat`
--

INSERT INTO `xgp_chat` VALUES (1,'BOT','ALLUSERS:<span style=color:lime > think</span> se ha conectado al chat',1307524613,0);
INSERT INTO `xgp_chat` VALUES (2,'think','ALLUSERS: [c=white] :bad:[/c]',1307524680,0);
INSERT INTO `xgp_chat` VALUES (3,'think','ALLUSERS: [c=white]gh[/c]',1307524785,0);
INSERT INTO `xgp_chat` VALUES (4,'BOT','ALLUSERS:<span style=color:lime > think</span> se ha conectado al chat',1307529535,0);
INSERT INTO `xgp_chat` VALUES (5,'BOT','ALLUSERS:<span style=color:lime > nkrsystem</span> se ha conectado al chat',1307541341,0);
INSERT INTO `xgp_chat` VALUES (6,'nkrsystem','ALLUSERS: [c=white]jjh[/c]',1307542100,0);
INSERT INTO `xgp_chat` VALUES (7,'nkrsystem','ALLUSERS: [c=white]rwt[/c]',1307542111,0);
INSERT INTO `xgp_chat` VALUES (8,'nkrsystem','ALLUSERS: [c=white]wr[/c]',1307542112,0);
INSERT INTO `xgp_chat` VALUES (9,'nkrsystem','ALLUSERS: [c=white]t[/c]',1307542112,0);
INSERT INTO `xgp_chat` VALUES (10,'nkrsystem','ALLUSERS: [c=white]wret[/c]',1307542113,0);
INSERT INTO `xgp_chat` VALUES (11,'nkrsystem','ALLUSERS: [c=white]rtert[/c]',1307542154,0);
INSERT INTO `xgp_chat` VALUES (12,'BOT','ALLUSERS:<span style=color:lime > nkrsystem</span> se ha conectado al chat',1307586561,0);
INSERT INTO `xgp_chat` VALUES (13,'BOT','ALLUSERS:<span style=color:lime > nkrsystem</span> se ha conectado al chat',1308050253,0);
INSERT INTO `xgp_chat` VALUES (14,'BOT','ALLUSERS:<span style=color:lime > nkrsystem</span> se ha conectado al chat',1308104384,0);

--
-- Table structure for table `xgp_config`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_config` (
  `config_name` varchar(64) NOT NULL default '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_config`
--

INSERT INTO `xgp_config` VALUES ('VERSION','2.9.9 Rp1');
INSERT INTO `xgp_config` VALUES ('users_amount','9');
INSERT INTO `xgp_config` VALUES ('moderation','1,0,0,1,1;1,1,0,1,1;1;');
INSERT INTO `xgp_config` VALUES ('game_speed','2500');
INSERT INTO `xgp_config` VALUES ('fleet_speed','2500');
INSERT INTO `xgp_config` VALUES ('resource_multiplier','1');
INSERT INTO `xgp_config` VALUES ('Fleet_Cdr','30');
INSERT INTO `xgp_config` VALUES ('Defs_Cdr','30');
INSERT INTO `xgp_config` VALUES ('initial_fields','163');
INSERT INTO `xgp_config` VALUES ('COOKIE_NAME','XGProyect');
INSERT INTO `xgp_config` VALUES ('game_name','XG Proyect');
INSERT INTO `xgp_config` VALUES ('game_disable','1');
INSERT INTO `xgp_config` VALUES ('close_reason','This server is closed for now (this is a test site only for xgproject&lt;br /&gt;\\r\\n&lt;br /&gt;\\r\\nEn este momento el servidor se encuentra cerrado!');
INSERT INTO `xgp_config` VALUES ('metal_basic_income','20');
INSERT INTO `xgp_config` VALUES ('crystal_basic_income','10');
INSERT INTO `xgp_config` VALUES ('deuterium_basic_income','5');
INSERT INTO `xgp_config` VALUES ('energy_basic_income','0');
INSERT INTO `xgp_config` VALUES ('BuildLabWhileRun','0');
INSERT INTO `xgp_config` VALUES ('LastSettedGalaxyPos','1');
INSERT INTO `xgp_config` VALUES ('LastSettedSystemPos','13');
INSERT INTO `xgp_config` VALUES ('LastSettedPlanetPos','3');
INSERT INTO `xgp_config` VALUES ('noobprotection','1');
INSERT INTO `xgp_config` VALUES ('noobprotectiontime','5000');
INSERT INTO `xgp_config` VALUES ('noobprotectionmulti','5');
INSERT INTO `xgp_config` VALUES ('forum_url','http://www.xgproyect.net/');
INSERT INTO `xgp_config` VALUES ('adm_attack','0');
INSERT INTO `xgp_config` VALUES ('debug','0');
INSERT INTO `xgp_config` VALUES ('lang','english');
INSERT INTO `xgp_config` VALUES ('stat','0');
INSERT INTO `xgp_config` VALUES ('stat_level','2');
INSERT INTO `xgp_config` VALUES ('stat_last_update','1308828418');
INSERT INTO `xgp_config` VALUES ('stat_settings','1000');
INSERT INTO `xgp_config` VALUES ('stat_amount','10');
INSERT INTO `xgp_config` VALUES ('stat_update_time','15');
INSERT INTO `xgp_config` VALUES ('stat_flying','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('OverviewNewsFrame','1');
INSERT INTO `xgp_config` VALUES ('OverviewNewsText','welcome to xg project');
INSERT INTO `xgp_config` VALUES ('Loteria','1214689842');
INSERT INTO `xgp_config` VALUES ('configloteria','5000|4000|2000|100|10000|8000|4000|200|50|20|0|600|');

--
-- Table structure for table `xgp_errors`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_errors` (
  `error_id` bigint(11) NOT NULL auto_increment,
  `error_sender` varchar(32) NOT NULL default '0',
  `error_time` int(11) NOT NULL default '0',
  `error_type` varchar(32) NOT NULL default 'unknown',
  `error_text` text,
  PRIMARY KEY  (`error_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_errors`
--


--
-- Table structure for table `xgp_fleets`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_fleets` (
  `fleet_id` bigint(11) NOT NULL auto_increment,
  `fleet_owner` int(11) NOT NULL default '0',
  `fleet_mission` int(11) NOT NULL default '0',
  `fleet_amount` bigint(11) NOT NULL default '0',
  `fleet_array` text,
  `fleet_start_time` int(11) NOT NULL default '0',
  `fleet_start_galaxy` int(11) NOT NULL default '0',
  `fleet_start_system` int(11) NOT NULL default '0',
  `fleet_start_planet` int(11) NOT NULL default '0',
  `fleet_start_type` int(11) NOT NULL default '0',
  `fleet_end_time` int(11) NOT NULL default '0',
  `fleet_end_stay` int(11) NOT NULL default '0',
  `fleet_end_galaxy` int(11) NOT NULL default '0',
  `fleet_end_system` int(11) NOT NULL default '0',
  `fleet_end_planet` int(11) NOT NULL default '0',
  `fleet_end_type` int(11) NOT NULL default '0',
  `fleet_target_obj` int(2) NOT NULL default '0',
  `fleet_resource_metal` bigint(11) NOT NULL default '0',
  `fleet_resource_crystal` bigint(11) NOT NULL default '0',
  `fleet_resource_deuterium` bigint(11) NOT NULL default '0',
  `fleet_resource_darkmatter` bigint(11) NOT NULL default '0',
  `fleet_target_owner` int(11) NOT NULL default '0',
  `fleet_group` varchar(15) NOT NULL default '0',
  `fleet_mess` int(11) NOT NULL default '0',
  `start_time` int(11) default NULL,
  PRIMARY KEY  (`fleet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_fleets`
--


--
-- Table structure for table `xgp_galaxy`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_galaxy` (
  `galaxy` int(2) NOT NULL default '0',
  `system` int(3) NOT NULL default '0',
  `planet` int(2) NOT NULL default '0',
  `id_planet` int(11) NOT NULL default '0',
  `metal` bigint(11) NOT NULL default '0',
  `crystal` bigint(11) NOT NULL default '0',
  `id_luna` int(11) NOT NULL default '0',
  `luna` int(2) NOT NULL default '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_galaxy`
--

INSERT INTO `xgp_galaxy` VALUES (1,1,1,1,0,300,17,0);
INSERT INTO `xgp_galaxy` VALUES (1,1,9,2,0,0,27,0);
INSERT INTO `xgp_galaxy` VALUES (1,70,8,18,0,0,22,0);
INSERT INTO `xgp_galaxy` VALUES (2,200,8,19,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (3,300,8,20,0,0,23,0);
INSERT INTO `xgp_galaxy` VALUES (4,270,8,21,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,7,9,26,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,9,10,33,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,9,6,34,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,11,12,37,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,12,8,42,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,12,10,41,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,12,4,40,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,13,11,43,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,13,4,44,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,7,14,45,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (1,33,11,46,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (2,33,7,47,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (5,323,5,48,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (3,333,2,49,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (7,143,13,50,0,0,0,0);
INSERT INTO `xgp_galaxy` VALUES (6,111,12,51,0,0,0,0);

--
-- Table structure for table `xgp_loteria`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_loteria` (
  `id` int(11) NOT NULL,
  `id_planeta` int(11) NOT NULL,
  `nombre_u` char(255) NOT NULL,
  `boletos` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_loteria`
--

INSERT INTO `xgp_loteria` VALUES (1,1,'nkrsystem',1);

--
-- Table structure for table `xgp_messages`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_messages` (
  `message_id` bigint(11) NOT NULL auto_increment,
  `message_owner` int(11) NOT NULL default '0',
  `message_sender` int(11) NOT NULL default '0',
  `message_time` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `message_from` varchar(48) default NULL,
  `message_subject` text,
  `message_text` text,
  `message_read` tinyint(3) default '1',
  `deleted` int(1) NOT NULL default '0',
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=194 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_messages`
--

INSERT INTO `xgp_messages` VALUES (176,32,0,1308302242,1,'Admin','¡Bienvenido!','¡Bienvenido a XG Proyect!<p>Al comenzar, construye una mina de Metal.<br />Para hacerlo, haz click en el enlace \"Edificios\" en la izquierda, y dale a \"construir\" a la derecha de la mina de metal.<br />Ahora tienes algo de tiempo para conocer más cosas del juego.<p>Podrás encontrar ayuda:<br />En el <a href=\"http://www.xtreme-gamez.com.ar/foros\" target=\"_blank\">Foro</a><br />Ahora, tu mina debería estar acabada.<br />Como no producen nada sin energía, deberías construir una Planta de energía solar, vuelve a Edificios, y elige construir la Planta de energía solar.<p>Para ver todas las naves, estructuras defensivas, edificios e investigaciones que puedes investigar, puedes echarle un vistazo al árbol de tecnología en \"Tecnología\" en el menú izquierdo.<p>Ahora ya puedes empezar la conquista del universo... ¡Buena suerte!',1,0);
INSERT INTO `xgp_messages` VALUES (177,33,0,1308360447,1,'Admin','¡Bienvenido!','¡Bienvenido a XG Proyect!<p>Al comenzar, construye una mina de Metal.<br />Para hacerlo, haz click en el enlace \"Edificios\" en la izquierda, y dale a \"construir\" a la derecha de la mina de metal.<br />Ahora tienes algo de tiempo para conocer más cosas del juego.<p>Podrás encontrar ayuda:<br />En el <a href=\"http://www.xtreme-gamez.com.ar/foros\" target=\"_blank\">Foro</a><br />Ahora, tu mina debería estar acabada.<br />Como no producen nada sin energía, deberías construir una Planta de energía solar, vuelve a Edificios, y elige construir la Planta de energía solar.<p>Para ver todas las naves, estructuras defensivas, edificios e investigaciones que puedes investigar, puedes echarle un vistazo al árbol de tecnología en \"Tecnología\" en el menú izquierdo.<p>Ahora ya puedes empezar la conquista del universo... ¡Buena suerte!',1,0);
INSERT INTO `xgp_messages` VALUES (180,1,0,1308487780,5,'Control Tower','Transport Fleet','One of your fleet reaches Planeta Principal <a href=\"game.php?page=galaxy&mode=3&galaxy=1&system=1\"  >[1:1:9]</a> and deliver their goods: 54986 de Metal, 0 de Crystal y 0 of Deuterium.',1,0);
INSERT INTO `xgp_messages` VALUES (178,34,0,1308360586,1,'Admin','¡Bienvenido!','¡Bienvenido a XG Proyect!<p>Al comenzar, construye una mina de Metal.<br />Para hacerlo, haz click en el enlace \"Edificios\" en la izquierda, y dale a \"construir\" a la derecha de la mina de metal.<br />Ahora tienes algo de tiempo para conocer más cosas del juego.<p>Podrás encontrar ayuda:<br />En el <a href=\"http://www.xtreme-gamez.com.ar/foros\" target=\"_blank\">Foro</a><br />Ahora, tu mina debería estar acabada.<br />Como no producen nada sin energía, deberías construir una Planta de energía solar, vuelve a Edificios, y elige construir la Planta de energía solar.<p>Para ver todas las naves, estructuras defensivas, edificios e investigaciones que puedes investigar, puedes echarle un vistazo al árbol de tecnología en \"Tecnología\" en el menú izquierdo.<p>Ahora ya puedes empezar la conquista del universo... ¡Buena suerte!',1,0);
INSERT INTO `xgp_messages` VALUES (179,35,0,1308360629,1,'Admin','¡Bienvenido!','¡Bienvenido a XG Proyect!<p>Al comenzar, construye una mina de Metal.<br />Para hacerlo, haz click en el enlace \"Edificios\" en la izquierda, y dale a \"construir\" a la derecha de la mina de metal.<br />Ahora tienes algo de tiempo para conocer más cosas del juego.<p>Podrás encontrar ayuda:<br />En el <a href=\"http://www.xtreme-gamez.com.ar/foros\" target=\"_blank\">Foro</a><br />Ahora, tu mina debería estar acabada.<br />Como no producen nada sin energía, deberías construir una Planta de energía solar, vuelve a Edificios, y elige construir la Planta de energía solar.<p>Para ver todas las naves, estructuras defensivas, edificios e investigaciones que puedes investigar, puedes echarle un vistazo al árbol de tecnología en \"Tecnología\" en el menú izquierdo.<p>Ahora ya puedes empezar la conquista del universo... ¡Buena suerte!',1,0);
INSERT INTO `xgp_messages` VALUES (182,1,0,1308489139,5,'Control Tower','Return of the fleet','A fleet back to planet Alpha Centauri<a href=\"game.php?page=galaxy&mode=3&galaxy=1&system=1\"  >[1:1:1]</a>. The fleet does not give resources.',1,0);
INSERT INTO `xgp_messages` VALUES (184,1,0,1308570359,5,'Control Tower','Transport Fleet','Found a fleet dePlaneta Principal<a href=\"game.php?page=galaxy&mode=3&galaxy=1&system=1\"  >[1:1:9]</a>Alpha Centauri coming in his libro<a href=\"game.php?page=galaxy&mode=3&galaxy=1&system=1\"  >[1:1:1]</a>0Metal units, units de19994Crystal0Deuterium units.',1,0);
INSERT INTO `xgp_messages` VALUES (192,1,33,1308673669,1,'human','','',1,0);
INSERT INTO `xgp_messages` VALUES (193,33,1,1308674014,1,'nkrsystem','','',1,0);
INSERT INTO `xgp_messages` VALUES (191,2,0,1308656794,4,'Space Control','Return of the fleet','One of your fleet reaches  <a href=\"game.php?page=galaxy&mode=3&galaxy=1&system=1\"  >[1:1:9]</a> and deliver their goods: 600 de Metal, 307.200 de Crystal y 0 of Deuterium.',1,0);
INSERT INTO `xgp_messages` VALUES (190,2,0,1308656393,4,'Space Control','Recycling Report','Your fleet arrived at the coordinates indicated and gatherers 600 units Metal and 307.200 units of Crystal.',1,0);
INSERT INTO `xgp_messages` VALUES (189,1,0,1308655550,3,'Control Tower','<a href=\"#\" style=\"color:green;\" OnClick=\'f(\"CombatReport.php?raport=75dea7e88be23249f62d5caaab63d1e5\", \"\");\' >Battle Report [1:1:1]</a>','',1,0);

--
-- Table structure for table `xgp_notes`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_notes` (
  `id` bigint(11) NOT NULL auto_increment,
  `owner` int(11) default NULL,
  `time` int(11) default NULL,
  `priority` tinyint(1) default NULL,
  `title` varchar(32) default NULL,
  `text` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_notes`
--

INSERT INTO `xgp_notes` VALUES (7,1,1308050358,2,'dfs','r\r\nsdf\r\nsdf\r\ns\r\nd');
INSERT INTO `xgp_notes` VALUES (8,2,1307582731,2,'Sin título','ew\r\ntwe\r\nr\r\nw\r\n\r\nwr\r\nwt\r\ntwrtwr\r\nrt');

--
-- Table structure for table `xgp_planets`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_planets` (
  `id` bigint(11) NOT NULL auto_increment,
  `name` varchar(255) default 'Planeta Principal',
  `id_owner` int(11) default NULL,
  `id_level` int(11) default NULL,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `last_update` int(11) default NULL,
  `planet_type` int(11) NOT NULL default '1',
  `destruyed` int(11) NOT NULL default '0',
  `b_building` int(11) NOT NULL default '0',
  `b_building_id` text NOT NULL,
  `b_tech` int(11) NOT NULL default '0',
  `b_tech_id` int(11) NOT NULL default '0',
  `b_hangar` int(11) NOT NULL default '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL default '0',
  `image` varchar(32) NOT NULL default 'normaltempplanet01',
  `diameter` int(11) NOT NULL default '12800',
  `points` bigint(20) default '0',
  `ranks` bigint(20) default '0',
  `field_current` int(11) NOT NULL default '0',
  `field_max` int(11) NOT NULL default '163',
  `temp_min` int(3) NOT NULL default '-17',
  `temp_max` int(3) NOT NULL default '23',
  `metal` double(132,8) NOT NULL default '0.00000000',
  `metal_perhour` int(11) NOT NULL default '0',
  `metal_max` bigint(20) default '100000',
  `crystal` double(132,8) NOT NULL default '0.00000000',
  `crystal_perhour` int(11) NOT NULL default '0',
  `crystal_max` bigint(20) default '100000',
  `deuterium` double(132,8) NOT NULL default '0.00000000',
  `deuterium_perhour` int(11) NOT NULL default '0',
  `deuterium_max` bigint(20) default '100000',
  `energy_used` int(11) NOT NULL default '0',
  `energy_max` bigint(20) NOT NULL default '0',
  `metal_mine` int(11) NOT NULL default '0',
  `crystal_mine` int(11) NOT NULL default '0',
  `deuterium_sintetizer` int(11) NOT NULL default '0',
  `solar_plant` int(11) NOT NULL default '0',
  `fusion_plant` int(11) NOT NULL default '0',
  `robot_factory` int(11) NOT NULL default '0',
  `nano_factory` int(11) NOT NULL default '0',
  `hangar` int(11) NOT NULL default '0',
  `metal_store` int(11) NOT NULL default '0',
  `crystal_store` int(11) NOT NULL default '0',
  `deuterium_store` int(11) NOT NULL default '0',
  `laboratory` int(11) NOT NULL default '0',
  `terraformer` int(11) NOT NULL default '0',
  `ally_deposit` int(11) NOT NULL default '0',
  `silo` int(11) NOT NULL default '0',
  `small_ship_cargo` bigint(11) NOT NULL default '0',
  `big_ship_cargo` bigint(11) NOT NULL default '0',
  `light_hunter` bigint(11) NOT NULL default '0',
  `heavy_hunter` bigint(11) NOT NULL default '0',
  `crusher` bigint(11) NOT NULL default '0',
  `battle_ship` bigint(11) NOT NULL default '0',
  `colonizer` bigint(11) NOT NULL default '0',
  `recycler` bigint(11) NOT NULL default '0',
  `spy_sonde` bigint(11) NOT NULL default '0',
  `bomber_ship` bigint(11) NOT NULL default '0',
  `solar_satelit` bigint(11) NOT NULL default '0',
  `destructor` bigint(11) NOT NULL default '0',
  `dearth_star` bigint(11) NOT NULL default '0',
  `battleship` bigint(11) NOT NULL default '0',
  `supernova` bigint(11) NOT NULL default '0',
  `misil_launcher` bigint(11) NOT NULL default '0',
  `small_laser` bigint(11) NOT NULL default '0',
  `big_laser` bigint(11) NOT NULL default '0',
  `gauss_canyon` bigint(11) NOT NULL default '0',
  `ionic_canyon` bigint(11) NOT NULL default '0',
  `buster_canyon` bigint(11) NOT NULL default '0',
  `small_protection_shield` tinyint(1) NOT NULL default '0',
  `planet_protector` tinyint(1) NOT NULL default '0',
  `big_protection_shield` tinyint(1) NOT NULL default '0',
  `interceptor_misil` int(11) NOT NULL default '0',
  `interplanetary_misil` int(11) NOT NULL default '0',
  `metal_mine_porcent` int(11) NOT NULL default '10',
  `crystal_mine_porcent` int(11) NOT NULL default '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL default '10',
  `solar_plant_porcent` int(11) NOT NULL default '10',
  `fusion_plant_porcent` int(11) NOT NULL default '10',
  `solar_satelit_porcent` int(11) NOT NULL default '10',
  `mondbasis` bigint(11) NOT NULL default '0',
  `phalanx` bigint(11) NOT NULL default '0',
  `sprungtor` bigint(11) NOT NULL default '0',
  `last_jump_time` int(11) NOT NULL default '0',
  `bankm` double(132,0) NOT NULL default '0',
  `bankc` double(132,0) NOT NULL default '0',
  `bankd` double(132,0) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_planets`
--

INSERT INTO `xgp_planets` VALUES (1,'Alpha Centauri',1,0,1,1,1,1308828939,1,0,0,'0',0,0,0,'',0,'normaltempplanet02',12750,0,0,186,500,47,87,1113900.21622000,5403,1000000,55143430.09910000,1391,1000000,1728320.68647000,582,1000000,-2742,2808,19,13,12,16,5,0,0,15,25,25,25,15,10,0,6,334,30,5029,3130,0,0,0,101,206198,0,0,0,100,392,100,0,0,0,10,0,0,0,0,0,0,98,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (2,'Planeta Principal',2,3,1,1,9,1308824769,1,0,0,'0',0,0,0,'',0,'normaltempplanet04',12750,0,0,50,163,45,85,4114028.03333000,1258,100000,34680212.01670000,0,100000,43531495.21940000,0,100000,-1555,424,21,0,0,9,0,10,0,10,0,0,0,0,0,0,0,4,1,12221,1,21230,1000,0,2342,999,0,0,235,0,0,0,1,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (17,'Moon',1,0,1,1,1,1308778190,3,0,0,'0',0,0,0,'',0,'mond',6651,0,0,53,100,22,60,350254.00000000,0,100000,40532.00000000,0,100000,23541.00000000,0,100000,0,0,10,0,0,0,0,20,0,0,0,0,0,0,0,0,0,10,0,0,10,0,0,10,0,120,0,0,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,7,15,1,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (18,'Colony',1,0,1,70,8,1308750399,1,0,0,'0',0,0,0,'',0,'normaltempplanet01',39675,0,0,0,300,-20,20,47661.46666670,20,100000,24080.73333330,10,100000,11790.36666670,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (19,'Colony',1,0,2,200,8,1308128742,1,0,0,'',0,0,0,'',0,'normaltempplanet05',43500,0,0,0,300,-28,12,40754.16666660,20,100000,20627.08333330,10,100000,10063.54166670,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (20,'Colony',1,0,3,300,8,1308128763,1,0,0,'',0,0,0,'',0,'normaltempplanet04',43725,0,0,0,300,-46,-6,40754.40000000,20,100000,20627.20000000,10,100000,10063.60000000,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (21,'Colony',1,0,4,270,8,1308128939,1,0,0,'',0,0,0,'',0,'normaltempplanet04',40125,0,0,0,300,36,76,40756.35555560,20,100000,20628.17777770,10,100000,10064.08888890,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (22,'Moon',1,0,1,70,8,1308778184,3,0,0,'0',0,0,0,'',0,'mond',6711,0,0,1,100,-63,8,0.00000000,0,100000,0.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,1,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (23,'Moon',1,0,3,300,8,1308128936,3,0,0,'0',0,0,0,'',0,'mond',9730,0,0,0,100,-76,-34,0.00000000,0,100000,0.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (26,'Planeta Principal',19,3,1,7,9,1303230379,1,0,0,'0',0,0,0,'',0,'normaltempplanet05',12750,0,0,0,163,32,72,561.98888888,20,100000,530.99444446,10,100000,15.49722224,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (27,'Moon',2,3,1,1,9,1308818336,3,0,0,'',0,0,0,'',0,'mond',8867,0,0,0,100,30,65,0.00000000,0,100000,22498.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (33,'Planeta Principal',24,3,1,9,10,1304721443,1,0,0,'',0,0,0,'',0,'wasserplanet01',12750,0,0,0,163,-18,22,501.25555556,20,100000,500.62777778,10,100000,0.31388890,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (34,'Planeta Principal',25,3,1,9,6,1308828935,1,0,0,'0',0,0,0,'',0,'dschjungelplanet01',12750,0,0,63,163,43,83,430.66166720,903,100000,359.10333264,723,100000,31260.82750020,145,100000,-1101,1063,11,12,7,14,0,6,0,6,1,0,0,6,0,0,0,20,0,27,5,0,0,0,0,168,0,0,0,0,0,0,50,79,7,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (37,'Planeta Principal',28,0,1,11,12,1308134454,1,0,0,'',0,0,0,'',0,'wasserplanet05',12750,0,0,0,163,-59,-19,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (42,'Planeta Principal',33,0,1,12,8,1308823808,1,0,0,'0',0,0,0,'',0,'normaltempplanet02',12750,0,0,2,163,48,88,4501.51111110,0,100000,2545.75555558,0,100000,1107.72500001,1,100000,-4,22,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,1,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (41,'Planeta Principal',32,0,1,12,10,1308302243,1,0,0,'',0,0,0,'',0,'wasserplanet05',12750,0,0,0,163,-27,13,500.01111111,20,100000,500.00555556,10,100000,0.00277778,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (40,'Planeta Principal',31,0,1,12,4,1308626713,1,0,0,'',0,0,0,'',0,'dschjungelplanet09',12750,0,0,0,163,6,46,5950.18888884,20,100000,3225.09444449,10,100000,1362.54722222,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (43,'Planeta Principal',34,0,1,13,11,1308360587,1,0,0,'',0,0,0,'',0,'wasserplanet05',12750,0,0,0,163,-50,-10,500.01111111,20,100000,500.00555556,10,100000,0.00277778,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (44,'Planeta Principal',35,0,1,13,4,1308360656,1,0,0,'',0,0,0,'',0,'dschjungelplanet02',12750,0,0,0,163,-13,27,500.30000000,20,100000,500.15000000,10,100000,0.07500000,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (45,'delta',2,3,1,7,14,1308569043,1,0,0,'',0,0,0,'',0,'eisplanet07',62700,0,0,0,300,-73,-33,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (46,'Colony',2,3,1,33,11,1308570334,1,0,0,'',0,0,0,'',0,'wasserplanet04',31200,0,0,0,333,-64,-24,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (47,'Colony',2,3,2,33,7,1308570357,1,0,0,'',0,0,0,'',0,'normaltempplanet02',53850,0,0,0,270,-40,0,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (48,'Colony',2,3,5,323,5,1308570411,1,0,0,'',0,0,0,'',0,'dschjungelplanet03',43050,0,0,0,230,66,106,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (49,'Colony',1,0,3,333,2,1308625077,1,0,0,'',0,0,0,'',0,'trockenplanet08',31275,0,0,0,322,43,83,500.00000000,0,100000,500.00000000,0,100000,0.00000000,0,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (50,'Colony',1,0,7,143,13,1308712771,1,0,0,'',0,0,0,'',0,'eisplanet01',44400,0,0,0,233,-26,14,1474.18888889,20,100000,987.09444447,10,100000,243.54722221,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);
INSERT INTO `xgp_planets` VALUES (51,'Colony',1,0,6,111,12,1308778052,1,0,0,'',0,0,0,'',0,'wasserplanet02',34425,0,0,0,223,-16,24,2199.38888889,20,100000,1349.69444444,10,100000,424.84722222,5,100000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,0,0,0,0,0,0,0);

--
-- Table structure for table `xgp_plugins`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_plugins` (
  `status` tinyint(11) NOT NULL default '0',
  `plugin` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_plugins`
--

INSERT INTO `xgp_plugins` VALUES (0,'Simulador');
INSERT INTO `xgp_plugins` VALUES (0,'Records');

--
-- Table structure for table `xgp_radar`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_radar` (
  `id` int(11) NOT NULL auto_increment,
  `id_owner` text character set latin1 collate latin1_general_ci NOT NULL,
  `alert` int(11) NOT NULL,
  `galaxia` int(11) NOT NULL,
  `sistema` int(11) NOT NULL,
  `planeta` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_radar`
--


--
-- Table structure for table `xgp_rw`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_rw` (
  `owners` varchar(255) NOT NULL,
  `rid` varchar(72) NOT NULL,
  `raport` text NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_rw`
--

INSERT INTO `xgp_rw` VALUES ('2,1','75dea7e88be23249f62d5caaab63d1e5','Fleets clash in  Tue Jun 21 11:26:15.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>200</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th><th>[ship[404]]</th></tr><tr><th>Amount</th><th>334</th><th>30</th><th>5,029</th><th>3,130</th><th>101</th><th>206,198</th><th>100</th><th>392</th><th>100</th><th>10</th></tr><tr><th>Weapons</th><th>3,340</th><th>401</th><th>741,778</th><th>1,338,075</th><th>0</th><th>0</th><th>51,500,000</th><th>802,620</th><th>141,250,000</th><th>28,325</th></tr><tr><th>Shield</th><th>8,350</th><th>1,875</th><th>125,725</th><th>195,625</th><th>2,525</th><th>0</th><th>12,500,000</th><th>392,000</th><th>100,000,000</th><th>5,000</th></tr><tr><th>Armor</th><th>334,000</th><th>90,000</th><th>5,029,000</th><th>7,825,000</th><th>404,000</th><th>51,549,500</th><th>225,000,000</th><th>6,860,000</th><th>450,000,000</th><th>87,500</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 195,664,539 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th><th>[ship[404]]</th></tr><tr><th>Amount</th><th>334</th><th>30</th><th>5,029</th><th>3,130</th><th>101</th><th>206,198</th><th>100</th><th>392</th><th>100</th><th>10</th></tr><tr><th>Weapons</th><th>4,259</th><th>446</th><th>691,488</th><th>1,138,538</th><th>0</th><th>0</th><th>49,000,000</th><th>720,300</th><th>121,250,000</th><th>28,875</th></tr><tr><th>Shield</th><th>8,350</th><th>1,875</th><th>125,725</th><th>195,625</th><th>2,525</th><th>0</th><th>12,500,000</th><th>392,000</th><th>100,000,000</th><th>5,000</th></tr><tr><th>Armor</th><th>334,000</th><th>90,000</th><th>5,029,000</th><th>7,825,000</th><th>404,000</th><th>51,549,500</th><th>225,000,000</th><th>6,860,000</th><th>450,000,000</th><th>87,500</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 172,833,905 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 1000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 300 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />',1,1308655575);

--
-- Table structure for table `xgp_statpoints`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_statpoints` (
  `id_owner` int(11) NOT NULL default '0',
  `id_ally` int(11) NOT NULL default '0',
  `stat_type` int(2) NOT NULL default '0',
  `stat_code` int(11) NOT NULL default '0',
  `tech_rank` int(11) NOT NULL default '0',
  `tech_old_rank` int(11) NOT NULL default '0',
  `tech_points` bigint(20) NOT NULL default '0',
  `tech_count` int(11) NOT NULL default '0',
  `build_rank` int(11) NOT NULL default '0',
  `build_old_rank` int(11) NOT NULL default '0',
  `build_points` bigint(20) NOT NULL default '0',
  `build_count` int(11) NOT NULL default '0',
  `defs_rank` int(11) NOT NULL default '0',
  `defs_old_rank` int(11) NOT NULL default '0',
  `defs_points` bigint(20) NOT NULL default '0',
  `defs_count` int(11) NOT NULL default '0',
  `fleet_rank` int(11) NOT NULL default '0',
  `fleet_old_rank` int(11) NOT NULL default '0',
  `fleet_points` bigint(20) NOT NULL default '0',
  `fleet_count` int(11) NOT NULL default '0',
  `total_rank` int(11) NOT NULL default '0',
  `total_old_rank` int(11) NOT NULL default '0',
  `total_points` bigint(20) NOT NULL default '0',
  `total_count` int(11) NOT NULL default '0',
  `stat_date` int(11) NOT NULL default '0',
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_statpoints`
--

INSERT INTO `xgp_statpoints` VALUES (34,0,1,1,11,11,0,1,11,11,0,0,11,11,0,0,11,11,0,0,11,11,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (33,0,1,1,9,9,0,1,9,9,0,2,7,7,0,0,9,9,0,0,9,9,0,3,1308828418);
INSERT INTO `xgp_statpoints` VALUES (32,0,1,1,6,6,0,1,6,6,0,0,4,4,0,0,6,6,0,0,6,6,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (1,0,2,1,1,1,9223372036854775807,310,2,1,302197720,191,2,1,2450,98,2,1,3470607,216130,1,1,9223372036854775807,216729,1305365426);
INSERT INTO `xgp_statpoints` VALUES (31,0,1,1,4,4,0,1,4,4,0,0,5,5,0,0,4,4,0,0,4,4,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (2,0,2,1,2,0,9223372036854775807,310,3,0,302197720,191,3,0,2450,98,3,0,3470607,216130,2,0,9223372036854775807,216729,1305367200);
INSERT INTO `xgp_statpoints` VALUES (5,0,2,1,4,4,286,47,4,4,259,63,4,4,314,136,4,4,406,220,4,4,1265,466,1308828418);
INSERT INTO `xgp_statpoints` VALUES (28,0,1,1,5,5,0,1,5,5,0,0,6,6,0,0,5,5,0,0,5,5,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (25,5,1,1,3,3,286,47,3,3,259,63,2,2,314,136,3,3,406,220,3,3,1265,466,1308828418);
INSERT INTO `xgp_statpoints` VALUES (24,0,1,1,7,7,0,1,7,7,0,0,8,8,0,0,7,7,0,0,7,7,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (19,0,1,1,8,8,0,1,8,8,0,0,9,9,0,0,8,8,0,0,8,8,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (2,0,1,1,2,2,66188,131,2,2,2209,50,3,3,2,1,2,2,797122,38033,2,2,865521,38215,1308828418);
INSERT INTO `xgp_statpoints` VALUES (35,0,1,1,10,10,0,1,10,10,0,0,10,10,0,0,10,10,0,0,10,10,0,1,1308828418);
INSERT INTO `xgp_statpoints` VALUES (1,4,1,1,1,1,9223372036854775807,312,1,1,305590278,240,1,1,2820,108,1,1,3496358,215574,1,1,9223372036854775807,216234,1308828418);
INSERT INTO `xgp_statpoints` VALUES (4,0,2,1,3,3,9223372036854775807,312,1,1,305590278,240,1,1,2820,108,1,1,3496358,215574,3,3,9223372036854775807,216234,1308828418);

--
-- Table structure for table `xgp_supp`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_supp` (
  `ID` int(11) NOT NULL auto_increment,
  `player_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subject` varchar(255) collate latin1_bin NOT NULL,
  `text` longtext collate latin1_bin NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_supp`
--

INSERT INTO `xgp_supp` VALUES (1,1,1306543008,'teste','teste de &lt;br /&gt;\\r\\nenvio<br><br><hr><br> <font color=\"red\">wetrt&lt;br /&gt;\\r\\ner&lt;br /&gt;\\r\\nt&lt;br /&gt;\\r\\ntre&lt;br /&gt;\\r\\n nao faças nada lol</font>',2);
INSERT INTO `xgp_supp` VALUES (2,1,1306545993,'te','etre&lt;br /&gt;\\r\\nert&lt;br /&gt;\\r\\netr&lt;br /&gt;\\r\\nt&lt;br /&gt;<br><br><hr><br> <font color=\"red\">retyet</font>',2);
INSERT INTO `xgp_supp` VALUES (3,1,1306546365,'43645','3456&amp;lt;br /&amp;gt;\\r\\n45645&amp;lt;br /&amp;gt;\\r\\n6&amp;lt;br /&amp;gt;\\r\\n46&amp;lt;br /&amp;gt;\\r\\n&amp;lt;br /&amp;gt;\\r\\n7&amp;lt;br /&amp;gt;\\r\\n45<br><br><hr><br> <font color=\"red\">rety&lt;br /&gt;</font>',2);
INSERT INTO `xgp_supp` VALUES (4,1,1306547248,'464','56465<br><br><hr><br> <font color=\"red\">utu</font>',2);
INSERT INTO `xgp_supp` VALUES (5,1,1307435573,'Pois bem mais um','teste de envio e o caraças dos br nao saiem&lt;br /&gt;\\r\\nd&lt;br /&gt;\\r\\ndd&lt;br /&gt;\\r\\nd&lt;br /&gt;\\r\\nd&lt;br /&gt;<br><br><hr><br> <font color=\"red\">boa tambem nao sei  :)&lt;br /&gt;\\r\\n&lt;br /&gt;\\r\\ndsa&lt;br /&gt;\\r\\nsa&lt;br /&gt;\\r\\nda&lt;br /&gt;\\r\\nd&lt;br /&gt;\\r\\na</font>',2);

--
-- Table structure for table `xgp_topkb`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_topkb` (
  `id` bigint(11) unsigned NOT NULL auto_increment,
  `id_owner1` bigint(20) NOT NULL default '0',
  `angreifer` varchar(64) NOT NULL default '',
  `id_owner2` bigint(20) NOT NULL default '0',
  `defender` varchar(64) NOT NULL default '',
  `gesamtunits` bigint(20) NOT NULL default '0',
  `gesamttruemmer` bigint(20) NOT NULL default '0',
  `rid` varchar(72) NOT NULL default '',
  `raport` text NOT NULL,
  `fleetresult` varchar(64) NOT NULL default '',
  `a_zestrzelona` tinyint(3) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id_owner1` (`id_owner1`,`rid`),
  KEY `id_owner2` (`id_owner2`,`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_topkb`
--

INSERT INTO `xgp_topkb` VALUES (1,1,'nkrsystem',2,'think',0,0,'ccd7ca3ffb599c71207bbf98e5118a41','Fleets clash in  Thu May 26 02:03:27.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1,000</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>250,000</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 0 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The attacker has won the battle<br />obtaining 0 Metal, 0 Crystal  0 Deuterium<br /><br />The attacker has lost a total of 0 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 0 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','a',1,1306375407);
INSERT INTO `xgp_topkb` VALUES (2,1,'nkrsystem',2,'think',0,0,'2b13fdc6f493279d755561aff30b51d7','Fleets clash in  Thu May 26 02:08:57.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1,000</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>250,000</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,231</th><th>1,000</th><th>2,342</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>40</th><th>11</th><th>1,234,321</th><th>342</th><th>17,154,648</th><th>2,120,000</th><th>0</th><th>968,200</th><th>157</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,100</th><th>400,000</th><th>46,840</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,647,400</th><th>12,000,000</th><th>7,494,400</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 21,477,719 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,231</th><th>1,000</th><th>2,342</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>38</th><th>10</th><th>1,148,774</th><th>330</th><th>19,702,368</th><th>2,320,000</th><th>0</th><th>930,600</th><th>184</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,100</th><th>400,000</th><th>46,840</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,647,400</th><th>12,000,000</th><th>7,494,400</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 24,102,303 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 1000000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 300000 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 3 %<br /><br /><br />','r',1,1306375737);
INSERT INTO `xgp_topkb` VALUES (3,1,'nkrsystem',12,'human',0,0,'99c5a7ac411ab69abcd5704a35aaa23e','Fleets clash in  Thu May 26 13:49:40.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>11</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>2,750</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender human ([1:5:4])<br />Weapons 0% - Shield 0% - Armor 0%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 0 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The attacker has won the battle<br />obtaining 0 Metal, 0 Crystal  0 Deuterium<br /><br />The attacker has lost a total of 0 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 0 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','a',1,1306417780);
INSERT INTO `xgp_topkb` VALUES (4,2,'think',1,'nkrsystem',32000,9600,'c3b3ab50921a48feeda822d957fbea54','Fleets clash in  Tue Jun 7 03:19:29.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[206]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>696</th></tr><tr><th>Shield</th><th>100</th></tr><tr><th>Armor</th><th>5,400</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th></tr><tr><th>Amount</th><th>331</th><th>30</th><th>5,030</th><th>3,130</th><th>100</th><th>206,211</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Weapons</th><th>4,138</th><th>364</th><th>521,863</th><th>939,000</th><th>0</th><th>0</th><th>42,000,000</th><th>192,500</th><th>143,750,000</th></tr><tr><th>Shield</th><th>8,275</th><th>1,875</th><th>125,750</th><th>195,625</th><th>2,500</th><th>0</th><th>12,500,000</th><th>100,000</th><th>100,000,000</th></tr><tr><th>Armor</th><th>331,000</th><th>90,000</th><th>5,030,000</th><th>7,825,000</th><th>400,000</th><th>51,552,750</th><th>225,000,000</th><th>1,750,000</th><th>450,000,000</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 696 on the defender. The defender\'s shields absorb 29 points of damage.<br />The defending fleet fires a total force of 187,407,864 on the attacker. The attacker\'s shields absorb 100 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th></tr><tr><th>Amount</th><th>331</th><th>30</th><th>5,029</th><th>3,130</th><th>100</th><th>206,210</th><th>100</th><th>100</th><th>100</th></tr><tr><th>Weapons</th><th>4,427</th><th>330</th><th>597,194</th><th>1,291,125</th><th>0</th><th>0</th><th>57,500,000</th><th>173,250</th><th>123,750,000</th></tr><tr><th>Shield</th><th>8,275</th><th>1,875</th><th>125,725</th><th>195,625</th><th>2,500</th><th>0</th><th>12,500,000</th><th>100,000</th><th>100,000,000</th></tr><tr><th>Armor</th><th>331,000</th><th>90,000</th><th>5,029,000</th><th>7,825,000</th><th>400,000</th><th>51,552,500</th><th>225,000,000</th><th>1,750,000</th><th>450,000,000</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 183,316,326 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 27000 units<br />The defender has lost a total of 5000 units<br />A debris field 6900 Metal and 2700 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','r',0,1307416769);
INSERT INTO `xgp_topkb` VALUES (5,1,'nkrsystem',2,'think',0,0,'6a317deb9eec5d14a7e51f7988a84b82','Fleets clash in  Thu Jun 9 02:25:22.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>250</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 0 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The attacker has won the battle<br />obtaining 0 Metal, 0 Crystal  0 Deuterium<br /><br />The attacker has lost a total of 0 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 0 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','a',1,1307586322);
INSERT INTO `xgp_topkb` VALUES (6,1,'nkrsystem',2,'think',1000,300,'d6c93f20caa0b8f321c08a3daf708199','Fleets clash in  Thu Jun 9 07:22:23.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>250</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>39</th><th>10</th><th>1,222,100</th><th>282</th><th>18,003,040</th><th>2,340,000</th><th>0</th><th>0</th><th>921,200</th><th>142</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 22,486,814 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>44</th><th>11</th><th>1,124,332</th><th>300</th><th>18,003,040</th><th>2,140,000</th><th>0</th><th>0</th><th>1,005,800</th><th>152</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 22,273,678 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 1000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 300 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','r',1,1307604143);
INSERT INTO `xgp_topkb` VALUES (7,1,'nkrsystem',2,'think',10000,3000,'1f42bca9f11593046957a4e5548f92b9','Fleets clash in  Thu Jun 9 07:24:47.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>10</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>2,500</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>39</th><th>12</th><th>1,344,310</th><th>261</th><th>14,776,080</th><th>1,980,000</th><th>0</th><th>0</th><th>977,600</th><th>138</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 19,078,439 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>47</th><th>10</th><th>1,442,078</th><th>345</th><th>14,436,400</th><th>1,940,000</th><th>0</th><th>0</th><th>1,062,200</th><th>178</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 18,881,258 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 10000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 3000 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','r',1,1307604287);
INSERT INTO `xgp_topkb` VALUES (8,1,'nkrsystem',2,'think',1000,300,'1f62730a17404541e0644fcec83c35ff','Fleets clash in  Wed Jun 15 11:31:19.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>250</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>37</th><th>11</th><th>1,295,426</th><th>300</th><th>17,493,520</th><th>2,300,000</th><th>0</th><th>0</th><th>752,000</th><th>149</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 21,841,443 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[206]]</th><th>[ship[207]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[213]]</th><th>[ship[401]]</th></tr><tr><th>Amount</th><th>4</th><th>1</th><th>12,221</th><th>1</th><th>21,230</th><th>1,000</th><th>2,342</th><th>1,000</th><th>235</th><th>1</th></tr><tr><th>Weapons</th><th>43</th><th>10</th><th>1,356,531</th><th>294</th><th>16,134,800</th><th>2,180,000</th><th>0</th><th>0</th><th>1,015,200</th><th>190</th></tr><tr><th>Shield</th><th>80</th><th>50</th><th>244,420</th><th>50</th><th>2,123,000</th><th>400,000</th><th>46,840</th><th>0</th><th>235,000</th><th>40</th></tr><tr><th>Armor</th><th>3,200</th><th>2,400</th><th>9,776,800</th><th>2,000</th><th>114,642,000</th><th>12,000,000</th><th>7,494,400</th><th>200,000</th><th>5,170,000</th><th>400</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 20,687,068 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 1000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 300 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','r',1,1308137479);
INSERT INTO `xgp_topkb` VALUES (9,1,'nkrsystem',2,'think',0,0,'f885152d4bdbcff291704f8b64d6181a','Fleets clash in  Wed Jun 15 14:19:55.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>12</th></tr><tr><th>Shield</th><th>25</th></tr><tr><th>Armor</th><th>1,000</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br />The attacking fleet fires a total force of 12 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 0 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The attacker has won the battle<br />obtaining 0 Metal, 2499 Crystal  0 Deuterium<br /><br />The attacker has lost a total of 0 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 0 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','a',0,1308147595);
INSERT INTO `xgp_topkb` VALUES (10,2,'think',1,'nkrsystem',1000,300,'75dea7e88be23249f62d5caaab63d1e5','Fleets clash in  Tue Jun 21 11:26:15.<br /><br />Round 1 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[210]]</th></tr><tr><th>Amount</th><th>1</th></tr><tr><th>Weapons</th><th>0</th></tr><tr><th>Shield</th><th>0</th></tr><tr><th>Armor</th><th>200</th></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th><th>[ship[404]]</th></tr><tr><th>Amount</th><th>334</th><th>30</th><th>5,029</th><th>3,130</th><th>101</th><th>206,198</th><th>100</th><th>392</th><th>100</th><th>10</th></tr><tr><th>Weapons</th><th>3,340</th><th>401</th><th>741,778</th><th>1,338,075</th><th>0</th><th>0</th><th>51,500,000</th><th>802,620</th><th>141,250,000</th><th>28,325</th></tr><tr><th>Shield</th><th>8,350</th><th>1,875</th><th>125,725</th><th>195,625</th><th>2,525</th><th>0</th><th>12,500,000</th><th>392,000</th><th>100,000,000</th><th>5,000</th></tr><tr><th>Armor</th><th>334,000</th><th>90,000</th><th>5,029,000</th><th>7,825,000</th><th>404,000</th><th>51,549,500</th><th>225,000,000</th><th>6,860,000</th><th>450,000,000</th><th>87,500</th></tr></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 195,664,539 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br />Round 2 :<br /><br /><table><tr><th>Aggressor think ([1:1:9])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><br /><br />Destroyed<br /></tr></table></th></tr></table><br /><br /><table><tr><th>Defender nkrsystem ([1:1:1])<br />Weapons 100% - Shield 100% - Armor 100%<table border=1 align=\"center\"><tr><th>Type</th><th>[ship[202]]</th><th>[ship[203]]</th><th>[ship[204]]</th><th>[ship[205]]</th><th>[ship[209]]</th><th>[ship[210]]</th><th>[ship[214]]</th><th>[ship[215]]</th><th>[ship[216]]</th><th>[ship[404]]</th></tr><tr><th>Amount</th><th>334</th><th>30</th><th>5,029</th><th>3,130</th><th>101</th><th>206,198</th><th>100</th><th>392</th><th>100</th><th>10</th></tr><tr><th>Weapons</th><th>4,259</th><th>446</th><th>691,488</th><th>1,138,538</th><th>0</th><th>0</th><th>49,000,000</th><th>720,300</th><th>121,250,000</th><th>28,875</th></tr><tr><th>Shield</th><th>8,350</th><th>1,875</th><th>125,725</th><th>195,625</th><th>2,525</th><th>0</th><th>12,500,000</th><th>392,000</th><th>100,000,000</th><th>5,000</th></tr><tr><th>Armor</th><th>334,000</th><th>90,000</th><th>5,029,000</th><th>7,825,000</th><th>404,000</th><th>51,549,500</th><th>225,000,000</th><th>6,860,000</th><th>450,000,000</th><th>87,500</th></tr></table></th></tr></table></table></th></tr></table></table></th></tr></table></table></th></tr></table><br /><br />The attacking fleet fires a total force of 0 on the defender. The defender\'s shields absorb 0 points of damage.<br />The defending fleet fires a total force of 172,833,905 on the attacker. The attacker\'s shields absorb 0 points of damage.<br /><br /><br /><br />The defender has won the battle<br /><br />The attacker has lost a total of 1000 units<br />The defender has lost a total of 0 units<br />A debris field 0 Metal and 300 Crystal floating in the orbit of the planet.<br /><br />The probability that a moon emerge from the rubble is: 0 %<br /><br /><br />','r',1,1308655575);

--
-- Table structure for table `xgp_users`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `xgp_users` (
  `id` bigint(11) unsigned NOT NULL auto_increment,
  `username` varchar(64) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `email_2` varchar(64) NOT NULL default '',
  `authlevel` tinyint(4) NOT NULL default '0',
  `id_planet` int(11) NOT NULL default '0',
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `planet` int(11) NOT NULL default '0',
  `current_planet` int(11) NOT NULL default '0',
  `user_lastip` varchar(16) NOT NULL default '',
  `ip_at_reg` varchar(16) NOT NULL default '',
  `user_agent` text NOT NULL,
  `current_page` text NOT NULL,
  `ranking` smallint(11) NOT NULL default '0',
  `register_time` int(11) NOT NULL default '0',
  `avatar` char(250) NOT NULL default 'styles/images/noavatar.png',
  `onlinetime` int(11) NOT NULL default '0',
  `dpath` varchar(255) NOT NULL default '',
  `design` tinyint(4) NOT NULL default '1',
  `noipcheck` tinyint(4) NOT NULL default '1',
  `planet_sort` tinyint(1) NOT NULL default '0',
  `planet_sort_order` tinyint(1) NOT NULL default '0',
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
  `urlaubs_until` int(11) NOT NULL default '0',
  `db_deaktjava` bigint(19) NOT NULL default '0',
  `new_message` int(11) NOT NULL default '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) NOT NULL default '0',
  `spy_tech` int(11) NOT NULL default '0',
  `computer_tech` int(11) NOT NULL default '0',
  `military_tech` int(11) NOT NULL default '0',
  `defence_tech` int(11) NOT NULL default '0',
  `shield_tech` int(11) NOT NULL default '0',
  `energy_tech` int(11) NOT NULL default '0',
  `hyperspace_tech` int(11) NOT NULL default '0',
  `combustion_tech` int(11) NOT NULL default '0',
  `impulse_motor_tech` int(11) NOT NULL default '0',
  `hyperspace_motor_tech` int(11) NOT NULL default '0',
  `laser_tech` int(11) NOT NULL default '0',
  `ionic_tech` int(11) NOT NULL default '0',
  `buster_tech` int(11) NOT NULL default '0',
  `intergalactic_tech` int(11) NOT NULL default '0',
  `expedition_tech` int(11) NOT NULL default '0',
  `graviton_tech` int(11) NOT NULL default '0',
  `ally_id` int(11) NOT NULL default '0',
  `ally_name` varchar(32) default '',
  `ally_request` int(11) NOT NULL default '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL default '0',
  `ally_rank_id` int(11) NOT NULL default '0',
  `current_luna` int(11) NOT NULL default '0',
  `rpg_geologue` int(11) NOT NULL default '0',
  `rpg_amiral` int(11) NOT NULL default '0',
  `rpg_ingenieur` int(11) NOT NULL default '0',
  `rpg_technocrate` int(11) NOT NULL default '0',
  `rpg_espion` int(11) NOT NULL default '0',
  `rpg_constructeur` int(11) NOT NULL default '0',
  `rpg_scientifique` int(11) NOT NULL default '0',
  `rpg_commandant` int(11) NOT NULL default '0',
  `rpg_stockeur` int(11) NOT NULL default '0',
  `darkmatter` int(11) NOT NULL default '0',
  `rpg_defenseur` int(11) NOT NULL default '0',
  `rpg_destructeur` int(11) NOT NULL default '0',
  `rpg_general` int(11) NOT NULL default '0',
  `rpg_bunker` int(11) NOT NULL default '0',
  `rpg_raideur` int(11) NOT NULL default '0',
  `rpg_empereur` int(11) NOT NULL default '0',
  `bana` int(11) default NULL,
  `banaday` int(11) NOT NULL default '0',
  `humano` int(11) NOT NULL default '0',
  `vampiro` int(11) NOT NULL default '0',
  `lobo` int(11) NOT NULL default '0',
  `asgard` int(11) NOT NULL default '0',
  `staatsform` int(11) NOT NULL default '0',
  `lang` varchar(20) default 'english',
  `check` int(11) NOT NULL default '0',
  `loteria_sus` tinyint(4) NOT NULL default '0',
  `dmlevel` int(11) NOT NULL,
  `tut_1` int(11) NOT NULL default '0',
  `tut_2` int(11) NOT NULL default '0',
  `tut_3` int(11) NOT NULL default '0',
  `tut_4` int(11) NOT NULL default '0',
  `tut_5` int(11) NOT NULL default '0',
  `tut_5_forum` int(11) NOT NULL default '0',
  `tut_6` int(11) NOT NULL default '0',
  `tut_6_mer` int(11) NOT NULL default '0',
  `tut_7` int(11) NOT NULL default '0',
  `tut_7_esp` int(11) NOT NULL default '0',
  `tut_8` int(11) NOT NULL default '0',
  `tut_8_exp` int(11) NOT NULL default '0',
  `tut_9` int(11) NOT NULL default '0',
  `tut_10` int(11) NOT NULL default '0',
  `tut_10_rec` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `xgp_users`
--

INSERT INTO `xgp_users` VALUES (1,'nkrsystem','38121acc3443ed35c6a7d723de349807','rstuga3@gmail.com','rstuga@gmail.com',3,1,1,1,1,1,'93.102.144.25','93.102.133.121','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.100 Safari/534.30','/299a/game.php?page=general',2,1302254271,'avatar.png',1308828939,'styles/skins/evolution/',0,1,1,1,25,5,25,0,1,1,1,1,1,0,0,0,8,NULL,0,11,21,10,10,10,13,10,60,60,60,12,10,10,3,10,1,4,'´stadd',0,NULL,1305367843,0,0,11,10,10,10,10,10,10,10,10,3517463,10,10,10,10,1,1,NULL,0,0,0,0,1,2,'english',1,1,0,1,0,1,1,0,0,0,0,0,0,0,0,1,0,0);
INSERT INTO `xgp_users` VALUES (2,'think','54c84b40e9ff5a31472904a0cd2f0a17','1@iol.pt','1@iol.pt',3,2,1,1,9,2,'93.102.144.25','93.102.133.121','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)','/299a/game.php?page=options',0,1302254827,'avatar.png',1308824769,'styles/skins/evolution/',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,2,NULL,0,10,10,10,10,10,10,10,10,10,10,10,10,10,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,1,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (19,'3r1k','17ac60d52fafd6d6bc026dc66c165a6b','dffr@gmail.com','dffr@gmail.com',3,26,1,7,9,26,'85.85.203.68','78.130.38.52','Mozilla/5.0 (Windows; U; Windows NT 6.1; es-ES; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16','/299/game.php?page=overview',0,1303224800,'http://www.rstuga.com/avatar.png',1303230379,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,0,1,0,'spanish',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (24,'nikkos','32dc043fb372faf2e0a489392ea71cf8','reewt@iol.pt','reewt@iol.pt',3,33,1,9,10,33,'93.102.135.114','93.102.135.114','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)','/299/game.php?page=logout',0,1304721330,'styles/images/noavatar.png',1304721446,'styles/skins/_BluXoRe_/',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,0,1,0,'spanish',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (25,'defiant','bee783ee2974595487357e195ef38ca2','24hfh@iol.pt','24hfh@iol.pt',3,34,1,9,6,34,'BOT','93.102.135.58','UGamelaPlay NewBot v0.5','/299a/game.php?page=logout',0,1304995667,'styles/images/noavatar.png',1308828935,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,0,NULL,0,5,5,4,4,4,5,0,5,2,0,7,5,0,0,0,0,5,'asd',0,NULL,1308474136,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,0,1,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (28,'falcon','e10adc3949ba59abbe56e057f20f883e','dddd@iol.pt','dddd@iol.pt',0,37,1,11,12,37,'93.102.151.63','93.102.151.63','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET4.0C; Tablet PC 2.0)','/299a/game.php?page=overview',0,1308134454,'styles/images/noavatar.png',1308134454,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,1,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (31,'teste3','c03aa55846e82aeeadf1879065baf7ed','rtfgeedfsg@iol.pt','rtfgeedfsg@iol.pt',0,40,1,12,4,40,'93.102.131.81','93.102.151.63','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)','/299a/game.php?page=overview',0,1308136196,'styles/images/noavatar.png',1308626713,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,13,1,1,0,0,0,0,0,0,485000,0,0,0,0,0,0,NULL,0,0,0,0,1,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (33,'human','c03aa55846e82aeeadf1879065baf7ed','fff@iol.pt','fff@iol.pt',0,42,1,12,8,42,'93.102.144.25','93.102.134.167','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.100 Safari/534.30','/299a/game.php?page=logout',0,1308360447,'styles/images/noavatar.png',1308823827,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,2,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,1,0,0,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (32,'nkrsystem2','c03aa55846e82aeeadf1879065baf7ed','rrrr@iol.pt','rrrr@iol.pt',0,41,1,12,10,41,'93.102.140.242','93.102.140.242','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET4.0C; Tablet PC 2.0)','/299a/game.php?page=logout',0,1308302242,'styles/images/noavatar.png',1308302280,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,1,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (34,'vampiro','c03aa55846e82aeeadf1879065baf7ed','fwef2@iol.pt','fwef2@iol.pt',0,43,1,13,11,43,'93.102.134.167','93.102.134.167','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)','/299a/game.php?page=logout',0,1308360586,'styles/images/noavatar.png',1308360603,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,1,0,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
INSERT INTO `xgp_users` VALUES (35,'lobo','c03aa55846e82aeeadf1879065baf7ed','uju@iol.pt','uju@iol.pt',0,44,1,13,4,44,'93.102.134.167','93.102.134.167','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)','/299a/game.php?page=logout',0,1308360629,'styles/images/noavatar.png',1308360669,'',1,1,0,0,1,5,0,0,1,1,1,1,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,1,0,0,'english',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-23 12:33:32
