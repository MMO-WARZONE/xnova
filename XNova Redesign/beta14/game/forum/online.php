<?php
$suser=$_SESSION['suser']; //id van de gebruiker ()
$online_verval = time()-300; // in secondes

if (end(explode("/",$PHP_SELF)) == "online.inc.php") {
  header("Location: ./index.php");
  exit();
}

$ip = getenv("REMOTE_ADDR");
//$page_naam = $_SERVER['REQUEST_URI'];
if($ip == "") { $ip = getenv("HTTP_X_FORWARDED_FOR"); }
//if(!isset($page_naam)) { $page_naam = ""; }

$time = time();
//leden die niet actief zijn verwijderen
mysql_query("DELETE FROM online WHERE datum < '$online_verval'");


if($_SESSION['suser'] == true) { //checken of ze ingelogt zijn
  $sql = mysql_query("SELECT * FROM online WHERE username='$suser'");
  $sql2 = "username='$suser', ip='$ip'";
  $sql3 = "username='$suser'";
} else {
  $sql = mysql_query("SELECT * FROM online WHERE ip='$ip' AND userid='0'");
  $sql2 = "ip='$ip'";
  $sql3 = "ip='$ip'";
}

if(mysql_num_rows($sql) == 0) {
  $referer = $HTTP_REFERER;
  mysql_query("INSERT INTO foruminfo SET $sql2, datum='$time', datum_start='$time', referer='$referer'"); //gegevens van de bezoeker opslaan
} elseif(mysql_num_rows($sql) != 0) {
  mysql_query("UPDATE foruminfo SET datum='$time' WHERE $sql3"); //gegevens van de bezoeker updaten
}

?> 