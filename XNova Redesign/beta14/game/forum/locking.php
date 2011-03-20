<?php
require('connect.php');
require('session.php');
session_start(); 
	$naam = $_GET['auteur'];
	$onderwerp = $_GET['onderwerp'];
	$forum = $_GET['forum'];
	$topic = $_GET['topic'];
	if($_GET['status'] == 'open'){
	$status = 'gesloten';
	}else{
	$status = 'open';
	}
	$type = $_GET['type'];
	mysql_query("update beta_board_subject set status='".$status."' where onderwerp='".$onderwerp."' and forum='".$forum."' and type='".$type."' and topic='".$topic."' and auteur='".$naam."'") or die(mysql_error());
	header("Location: index.php?page=forums&forum=".$_GET['forum']."&p=0");
?>