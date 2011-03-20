<?php 
require('connect.php');
$forum = $_GET['forum'];
mysql_query("delete from beta_board_subject where forum='".$forum."'") or die(mysql_error());
mysql_query("delete from beta_board_reactie where forum='".$forum."'") or die(mysql_error());
mysql_query("delete from beta_board_polstem where forum='".$forum."'") or die(mysql_error());
mysql_query("delete from beta_board_pol where forum='".$forum."'") or die(mysql_error());
mysql_query("delete from beta_board_forum where forum='".$forum."'") or die(mysql_error());
header("Location: home.php");
?>

