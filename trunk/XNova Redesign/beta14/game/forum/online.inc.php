<?php
if($_SESSION['suser'] == false) { 
//$suser=$_SESSION['suser']; //id van de gebruiker ()
//$online_verval = time()-300; // in secondes

/*if (end(explode("/",$PHP_SELF)) == "online.inc.php") {
  header("Location: ./index.php");
  exit();
}*/

$ip = getenv("REMOTE_ADDR");
//$page_naam = $_SERVER['REQUEST_URI'];
if($ip == "") { $ip = getenv("HTTP_X_FORWARDED_FOR"); }
//if(!isset($page_naam)) { $page_naam = ""; }

$time = time();
//leden die niet actief zijn verwijderen
//mysql_query("DELETE from beta_board_foruminfo WHERE datum < '$online_verval'") or die(mysql_error());


//if($_SESSION['suser'] == true) { //checken of ze ingelogt zijn
  //$sql = mysql_query("SELECT * from beta_board_foruminfo WHERE username='$suser'") or die(mysql_error());
  //$sql2 = "username='$suser', ip='$ip'";
  //$sql3 = "username='$suser'";
  $sql = mysql_query("SELECT * from beta_board_foruminfo WHERE ip='".$ip."' AND username=''") or die(mysql_error());
  $sql2 = "ip='".$ip."'";
  $sql3 = "ip='".$ip."'";

if(mysql_num_rows($sql) == 0) {
  $referer = $_SERVER['HTTP_REFERER'];
  mysql_query("INSERT INTO beta_board_foruminfo SET ".$sql2.", datum=NOW(), datum_start=NOW(), referer='".$referer."'") or die(mysql_error()); //gegevens van de bezoeker opslaan
} elseif(mysql_num_rows($sql) != 0) {
  mysql_query("UPDATE beta_board_foruminfo SET datum=NOW() WHERE ".$sql3."") or die(mysql_error()); //gegevens van de bezoeker updaten
}
}
?> 