<?php
require('connect.php');
require('session.php');
session_start(); 
if(isset($_POST['post'])) {
	if( $_POST['forum'] == NULL || $_POST['info'] == NULL || $_POST['keuze'] == NULL ) {
		echo 'You must give something';
	}
	else
	{
	$naam = $_SESSION['suser'];
	$forum  = $_POST['forum'];
	$info = $_POST['info'];
	$type = $_POST['keuze'];
	mysql_query("INSERT INTO beta_board_forum (forum, info, auteur, type) VALUES ('".$forum."','".$info."','".$naam."','".$type."')") or die(mysql_error());
	header("Location: index.php");
	}
}
?>