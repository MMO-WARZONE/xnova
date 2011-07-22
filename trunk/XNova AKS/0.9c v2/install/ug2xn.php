<?php

// UGAMELA 2 XNOVA - DATABASE MODIFICATOR
// Version: 0.5
// Created by e-Zobar
// XNova (c) Copyright 2008

$querys = array(
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_end_stay` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_target_owner` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_group` varchar(15) character set utf8 collate utf8_general_ci NOT NULL default '0';",

"ALTER TABLE `{{prefix}}messages` MODIFY `message_from` varchar(48) character set utf8 default NULL;",
"ALTER TABLE `{{prefix}}messages` MODIFY `message_subject` varchar(48) character set utf8 default NULL;",

"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_points`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_planets`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_points_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `rank`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `rank_old`;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_buildlist` INT (11) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `expedition_tech` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_expedition` INT( 11 ) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_geologue` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_amiral` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_ingenieur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_technocrate` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_points` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_minier` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_raid` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpraid` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpminier` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `banaday` int(11) default NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `user_agent` text character set utf8 NOT NULL;",
"ALTER TABLE `{{prefix}}users` MODIFY `lang` varchar(8) character set utf8 NOT NULL default 'de';",

"CREATE TABLE `{{prefix}}annonce` (
`id` int(11) NOT NULL auto_increment,
`user` text collate utf8_general_ci NOT NULL,
`galaxie` int(11) NOT NULL,
`systeme` int(11) NOT NULL,
`metala` bigint(11) NOT NULL,
`cristala` bigint(11) NOT NULL,
`deuta` bigint(11) NOT NULL,
`metals` bigint(11) NOT NULL,
`cristals` bigint(11) NOT NULL,
`deuts` bigint(11) NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_german1_ci AUTO_INCREMENT=5;",

"ALTER TABLE `{{prefix}}planets` DROP COLUMN `b_building_queue`;",
"ALTER TABLE `{{prefix}}planets` DROP COLUMN `unbau`;",
"ALTER TABLE `{{prefix}}planets` ADD COLUMN `last_jump_time` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}planets` MODIFY `b_building_id` text character set utf8 NOT NULL;",

"CREATE TABLE `{{prefix}}statpoints` (
`id_owner` int(11) NOT NULL,
`id_ally` int(11) NOT NULL,
`stat_type` int(2) NOT NULL,
`stat_code` int(11) NOT NULL,
`tech_rank` int(11) NOT NULL,
`tech_old_rank` int(11) NOT NULL,
`tech_points` bigint(20) NOT NULL,
`tech_count` int(11) NOT NULL,
`build_rank` int(11) NOT NULL,
`build_old_rank` int(11) NOT NULL,
`build_points` bigint(20) NOT NULL,
`build_count` int(11) NOT NULL,
`defs_rank` int(11) NOT NULL,
`defs_old_rank` int(11) NOT NULL,
`defs_points` bigint(20) NOT NULL,
`defs_count` int(11) NOT NULL,
`fleet_rank` int(11) NOT NULL,
`fleet_old_rank` int(11) NOT NULL,
`fleet_points` bigint(20) NOT NULL,
`fleet_count` int(11) NOT NULL,
`total_rank` int(11) NOT NULL,
`total_old_rank` int(11) NOT NULL,
`total_points` bigint(20) NOT NULL,
`total_count` int(11) NOT NULL,
`stat_date` int(11) NOT NULL,
KEY `TECH` (`tech_points`),
KEY `BUILDS` (`build_points`),
KEY `DEFS` (`defs_points`),
KEY `FLEET` (`fleet_points`),
KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM;",

"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_builds`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_tech`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_builds_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_tech_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_members_points`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet2`;",

"CREATE TABLE `{{prefix}}chat` (
`messageid` int(5) unsigned NOT NULL auto_increment,
`user` varchar(255) NOT NULL default '',
`message` text NOT NULL,
`timestamp` int(11) NOT NULL default '0',
PRIMARY KEY  (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"DROP TABLE `{{prefix}}admin_acl`;",

"DROP TABLE `{{prefix}}admin_modules`;",

"INSERT INTO `{{prefix}}config` (`config_name`, `config_value`) VALUES
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('game_disable', '0'),
('close_reason', ''),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '9'),
('LastSettedPlanetPos', '1'),
('urlaubs_modus_erz', '1'),
('forum_url', 'http://www.xnova-reloaded.de/'),
('OverviewNewsFrame', '1'),
('OverviewNewsText', 'Herzlich Willkommen bei XNova!'),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', '');",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='COOKIE_NAME';",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='game_name';"
);

if (isset($_GET['step']))
    $step    = intval($_GET['step']);
else
    $step    = 1;
    $phpself = $_SERVER['PHP_SELF'];

if ($step == 1) {
?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style>
</head>
<body>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela to XNova </span></td></tr>
<tr><td align="center">Vous &ecirc;tes sur le point de modifier votre base de donn&eacute;e UGamela afin qu'elle soit compatible avec XNova.<br>
Ces deux serveurs totalements diff&eacute;rents et leurs base de donn&eacute;es ne peuvent pas &ecirc;tres associ&eacute;es<br>
sans modifications. En passant &agrave; la prochaine &eacute;tape, vous devez remplire ces conditions:<br>
- Posseder une sauvegarde de votre base de donn&eacute;e actuelle (en cas de probl&egrave;me).<br>
- Avoir la version la plus &agrave; jour d'XNova (<a href="http://www.xnova-reloaded.de">http://www.xnova-reloaded.de</a>).<br>
- Avoir pris connaissance des risques du transfert.</td></tr>
<tr><td height="50px" align="center"><a href="<?php echo $phpself; ?>?step=<?php echo ($step + 1); ?>">Passer &agrave; la configuration</a></td></tr>
</table>
</body>
</html>

<?php
}
elseif ($step == 2) {
?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style></head>
<body>
<?php if ($_GET['error'] == 1) { ?>
<script> alert('Impossible de se connecter &#224; la base de donn&#233;e!'); </script>
<?php } elseif ($_GET['error'] == 2) { ?>
<script> alert('Mettez un Chmod 777 au fichier config.php!'); </script>
<?php } ?>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela to XNova </span></td></tr>
<tr><td height="110" align="center">Veuillez Remplir ce formulaire en renseignant les champs tels qu'ils sont dans votre fichier config.php<br>
Si vous modifiez quelque chose, le transfert &eacute;choura!<br><br>
<form action="<?php echo $phpself; ?>?step=<?php echo ($step + 1); ?>" method="post">
<table width="367" border="0" cellspacing="0" cellpadding="0">
<tr><td width="231">Adresse du serveur SQL:</td>
    <td width="150"><input type="text" name="host" value="localhost" size="25"></td></tr>
<tr><td>Nom de la base de donn&eacute;e: </td>
    <td><input type="text" name="db" value="" size="25"></td></tr>
<tr><td>Pr&eacute;fix des tables: </td>
    <td><input type="text" name="prefix" value="game_" size="25"></td></tr>
<tr><td>Identifiant:</td>
    <td><input type="text" name="user" value="" size="25"></td></tr>
<tr><td>Mot-de-passe: </td>
    <td><input type="password" name="passwort" value="" size="25"></td></tr>
</table>
<br>
<input type="submit" name="send" value="Valider">
</form></td></tr>
</table>
</body>
</html>

<?php
}
elseif ($step == 3) {

$host       = $_POST['host'];
$user       = $_POST['user'];
$pass       = $_POST['passwort'];
$prefix     = $_POST['prefix'];
$db         = $_POST['db'];

$connection = @mysql_connect($host, $user, $pass);

if (!$connection) {
    header("Location: ?step=2&error=1");
    exit();
}

$dbselect   = @mysql_select_db($db);

if (!$dbselect) {
    header("Location: ?step=2&error=2");
    exit();
}

$zufall = mt_rand(1000, 1234567890);
$dz = fopen("../config.php", "w");

if (!$dz) {
    header("Location: ?step=2&error=2");
    exit();
}

fwrite($dz, "<"."?"."p"."h"."p  //config.php :: XNova server

if(!defined(\"INSIDE\")){ die(\"attemp hacking\");}
	\$dbsettings = Array(
		\"server\"        => \"".$host."\", /"."/ MySQL server name. (Default: localhost)
		\"user\"          => \"".$user."\", /"."/ MySQL username.
		\"pass\"          => \"".$pass."\", /"."/ MySQL password.
		\"name\"          => \"".$db."\", /"."/ MySQL database name.
		\"prefix\"        => \"".$prefix."\", /"."/ Prefix for table names.
		\"secretword\"    => \"XNova".$zufall."\"); /"."/ Secret word used when hashing information for cookies.


?".">");
fclose($dz);

function doquery($query, $p) {
    $query = str_replace("{{prefix}}", $p, $query);
    $return = mysql_query($query) or die("MySQL Fehler: <b>".mysql_error()."</b>");

    return $return;
}

foreach ($querys as $query) {
    doquery($query, $prefix);
}

?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style>
</head>
<body>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela to XNova </span></td></tr>
<tr><td align="center">F&eacute;licitation, votre de donn&eacute;e UGamela a &eacute;t&eacute; modifi&eacute;e afin qu'elle soit compatible avec XNova.<br>
Votre fichier config.php a &eacute;t&eacute; modifi&eacute; avec les informations de votre base de donn&eacute;e.<br>
Votre serveur est pr&egrave;s &agrave; &ecirc;tre utillis&eacute;. </td>
</tr><tr><td height="50px" align="center"><a href="../login.php">Page d'accueil du serveur</a></td></tr>
</table>
</body>
</html>

<?php
}
else {
   header("Location: ".$phpself);
   exit();
}
?>