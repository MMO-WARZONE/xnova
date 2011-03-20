<?php
require('connect.php');
require('session.php');
session_start(); 
if(isset($_POST['post'])) {
	if( $_POST['keuze1'] == NULL or $_POST['keuze2'] == NULL) {
		echo 'You must give at least 2 possibilities';
	}
	else
	{
	$naam = $_SESSION['suser'];
	$reactie  = $_GET['reactie'];
	$onderwerp = $_GET['onderwerp'];
	$forum = $_GET['forum'];
	$topic = $_GET['topic'];
	$type = $_POST['pol'];
	$K1 = $_POST['keuze1'];
	if( $_POST['keuze1'] == NULL ){
		$P1 = '';
	}
	else{
		$P1 = 0;
	}
	$K2 = $_POST['keuze2'];
	if( $_POST['keuze2'] == NULL ){
		$P2 = '';
	}
	else{
		$P2 = 0;
	}
	$K3 = $_POST['keuze3'];
	if( $_POST['keuze3'] == NULL ){
		$P3 = '';
	}
	else{
		$P3 = 0;
	}
	$K4 = $_POST['keuze4'];
	if( $_POST['keuze4'] == NULL ){
		$P4 = '';
	}
	else{
		$P4 = 0;
	}
	$K5 = $_POST['keuze5'];
	if( $_POST['keuze5'] == NULL ){
		$P5 = '';
	}
	else{
		$P5 = 0;
	}
		$res=mysql_query("select max(id) from beta_users") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		$aantal=$row['max(id)'];
		for( $i = 1; $i <= $aantal; $i++){
		$array[$i]=2;
		//echo serialize($array[$i]);
		//$save=serialize($array[$i]);
		}
	mysql_query("INSERT INTO beta_board_reactie ( onderwerp, auteur, forum, time, reactie, topic) VALUES ('".$onderwerp."','".$naam."','".$forum."',NOW(),'".$reactie."','".$topic."')") or die(mysql_error());
	mysql_query("INSERT INTO beta_board_subject (onderwerp, auteur, forum, type, topic, unread) VALUES ('".$onderwerp."','".$naam."','".$forum."','".$type."','".$topic."','".serialize($array)."')") or die(mysql_error());
	mysql_query("INSERT INTO beta_board_pol (onderwerp, auteur, forum, time, topic, keuze1, keuze2, keuze3, keuze4, keuze5) VALUES ('".$onderwerp."','".$naam."','".$forum."',NOW(),'".$topic."','".$K1."','".$K2."','".$K3."','".$K4."','".$K5."')") or die(mysql_error());
	mysql_query("INSERT INTO beta_board_polstem (onderwerp, auteur, forum, topic, keuze1, keuze2, keuze3, keuze4, keuze5) VALUES ('".$onderwerp."','".$naam."','".$forum."','".$topic."','".$P1."','".$P2."','".$P3."','".$P4."','".$P5."')") or die(mysql_error());
	if($topic == 'mededeling'){
	//header("Location: topicmede.php?onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']);
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=1");
	}
	else
	{
	//header("Location: topic.php?onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']);
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=2");
	}
	}
}
?>