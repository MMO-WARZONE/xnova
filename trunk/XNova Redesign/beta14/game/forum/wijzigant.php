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
	$naam = $_POST['auteur'];
	$reactie  = $_POST['reactie'];
	$onderwerp = $_POST['onderwerp'];
	$forum = $_POST['forum'];
	$topic = $_POST['topic'];
	$id = $_POST['id'];
	mysql_query("update beta_board_reactie set reactie='".$reactie."' where onderwerp='".$onderwerp."' and forum='".$forum."' and id='".$id."' and topic='".$topic."' and auteur='".$naam."'") or die(mysql_error());
	if($topic=='onderwerp'){
		$t=2;
	}else{
		$t=1;
	}
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=".$t);
	}
	
}
?>