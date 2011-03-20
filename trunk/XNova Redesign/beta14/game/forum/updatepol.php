<?php
require('connect.php');
require('session.php');
session_start(); 

	$onderwerp = $_GET['onderwerp'];
	$auteur = $_GET['auteur'];
	$forum = $_GET['forum'];
	$topic = $_GET['topic'];
	$keuze = $_GET['keuze'];
	$id = $_GET['id_pol'];
	$userpol = $_SESSION['suser'];
	mysql_query("update beta_board_polstem set ".$keuze." = ".$keuze." +1 where onderwerp='".$onderwerp."' and auteur='".$auteur."' and forum='".$forum."' and topic='".$topic."'") or die(mysql_error());
	$month = 2592000 + time(); //2592000 
	setcookie($id, $userpol, $month);
	if($topic == 'mededeling'){
	header("Location: topicmede.php?onderwerp=".$_GET['onderwerp']."&forum=".$_GET['forum']);
	}
	else
	{
	header("Location: topic.php?onderwerp=".$_GET['onderwerp']."&forum=".$_GET['forum']);
	}

?>