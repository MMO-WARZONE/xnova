<?php 
require('connect.php');
require('session.php');
session_start();

	$onderwerp = $_GET['onderwerp'];
	$forum = $_GET['forum'];
	$topic = $_GET['topic'];
	$type = $_GET['type'];
	if($type == 'notpol'){
	mysql_query("DELETE from beta_board_reactie WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."'") or die(mysql_error());
	mysql_query("DELETE from beta_board_subject WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."' and type='".$type."'") or die(mysql_error());
	}else{
	mysql_query("DELETE from beta_board_reactie WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."'") or die(mysql_error());
	mysql_query("DELETE from beta_board_subject WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."' and type='".$type."'") or die(mysql_error());	
	mysql_query("DELETE from beta_board_pol WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."'") or die(mysql_error());
	mysql_query("DELETE from beta_board_polstem WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and topic='".$topic."'") or die(mysql_error());
	}
	//header("Location: forums.php?forum=".$forum."&p=0");
	header("Location: index.php?page=forums&forum=".$forum."&p=0");
?>