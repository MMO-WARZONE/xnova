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
	$auteur = $_SESSION['suser'];
	$reactie  = $_POST['reactie'];
	$onderwerp = $_POST['onderwerp'];
	$forum = $_POST['forum'];
	$topic = 'mededeling';
		$res=mysql_query("select max(id) from beta_users") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		$aantal=$row['max(id)'];
		for( $i = 1; $i <= $aantal; $i++){
		$array[$i]=2;
		//echo serialize($array[$i]);
		//$save=serialize($array[$i]);
		}
	mysql_query("INSERT INTO beta_board_reactie ( onderwerp, auteur, forum, time, reactie, topic) VALUES ('".$onderwerp."','".$auteur."','".$forum."',NOW(),'".$reactie."','".$topic."')") or die(mysql_error());
	mysql_query("update beta_board_subject set unread='".serialize($array)."' where onderwerp='".$onderwerp."' and forum='".$forum."'") or die(mysql_error());
	}
	//header("Location: topicmede.php?onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']);
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=1");
}
?>