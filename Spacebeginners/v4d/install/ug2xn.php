<?php

// UGAMELA 2 XNOVA - DATABASE MODIFICATOR
// Version: 0.5
// Created by e-Zobar
// XNova (c) Copyright 2008

$querys = array(
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_end_stay` int(11) NOT NULL default '0';"
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
- Avoir la version la plus &agrave; jour d'XNova (<a href="http://spacebeginner.de/forum/index.php">http://spacebeginner.de/forum/index.php</a>).<br>
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
    <td><input type="text" name="prefix" value="" size="25"></td></tr>
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
		\"secretword\"    => \"SPACEBEGINNER".$zufall."\"); /"."/ Secret word used when hashing information for cookies.


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