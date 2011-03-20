
<font color=lime>||| CONSULTA SQL |||</font>
El usuario shoghicp ha ejecutado la siguiente sentencia SQL:
INSERT INTO `config` (`config_name` ,`config_value`) VALUES (\\\'background\\\',  \\\'1\\\');
Operación realizada el: 14-11-2010 14:53:40
 16:18:56
greifer` varchar(64) NOT NULL default \\\'\\\',  `id_owner2` bigint(20) NOT NULL default \\\'0\\\',  `defender` varchar(64) NOT NULL default \\\'\\\',  `gesamtunits` bigint(20) NOT NULL default \\\'0\\\',  `gesamttruemmer` bigint(20) NOT NULL default \\\'0\\\',  `rid` varchar(72) NOT NULL default \\\'\\\',  `raport` text NOT NULL,  `fleetresult` varchar(64) NOT NULL default \\\'\\\',  `a_zestrzelona` tinyint(3) unsigned NOT NULL default \\\'0\\\',  `time` int(10) unsigned NOT NULL default \\\'0\\\',  KEY `id_owner1` (`id_owner1`,`rid`),  KEY `id_owner2` (`id_owner2`,`rid`),  KEY `time` (`time`),  FULLTEXT KEY `raport` (`raport`),  PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;
Operación realizada el: 22-10-2010 14:24:58
