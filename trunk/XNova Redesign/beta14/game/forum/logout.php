<?php
require("connect.php");
session_start(); // start een sessie of zet een sessie voort
$user = $_SESSION['suser'];
setcookie('XNovaforum',$naam,time()-3600);
mysql_query("UPDATE beta_users set forum_online='offline' where username='".$user."'") or die(mysql_error());
$_SESSION = array(); // maak het sessie array leeg
session_destroy();   // verwijder de sessie

// als er een cookie geset is, reset deze
if(isset($_COOKIE['login_cookie'])) {
  setcookie("login_cookie", "", time(), "/");
}
header("Location: index.php");
?>