<?php
require('connect.php');
require('session.php');
session_start(); 
if(isset($_POST['post'])) {
	if( $_POST['reactie'] == NULL ) {
		echo 'Je moet iets ingeven';
	}
	else
	{
	$naam = $_SESSION['suser'];
	$reactie  = $_POST['reactie'];
	$onderwerp = $_POST['onderwerp'];
	$forum = $_POST['forum'];
	$topic = 'mededeling';
	if( $_POST['keuze'] == 'notpol'){
		$res=mysql_query("select max(id) from beta_users") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		$aantal=$row['max(id)'];
		for( $i = 1; $i <= $aantal; $i++){
		$array[$i]=2;
		//echo serialize($array[$i]);
		//$save=serialize($array[$i]);
		}
	$type = $_POST['keuze'];
	mysql_query("INSERT INTO beta_board_reactie ( onderwerp, auteur, forum, time, reactie, topic) VALUES ('".$onderwerp."','".$naam."','".$forum."',NOW(),'".$reactie."','".$topic."')") or die(mysql_error());
	mysql_query("INSERT INTO beta_board_subject (onderwerp, auteur, forum, type, topic, unread) VALUES ('".$onderwerp."','".$naam."','".$forum."','".$type."','".$topic."','".serialize($array)."')") or die(mysql_error());
	//header("Location: topicmede.php?onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']);
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=1");
	}
	else 
	{ 
	//header("Location: pol.php?onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&reactie=".$_POST['reactie']."&topic=".$topic);
	header("Location: index.php?page=pol&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&reactie=".$_POST['reactie']."&topic=".$topic);
	}
	}
}
?>