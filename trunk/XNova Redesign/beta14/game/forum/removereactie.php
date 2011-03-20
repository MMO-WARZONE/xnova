<?php 
require('connect.php');
require('session.php');
session_start();

	$onderwerp = $_GET['onderwerp'];
	$forum = $_GET['forum'];
	$reactie = $_GET['reactie'];
	$topic = $_GET['topic'];
	mysql_query("DELETE from beta_board_reactie WHERE onderwerp='".$onderwerp."' and forum='".$forum."' and reactie='".$reactie."' and topic='".$topic."'") or die(mysql_error());
	if($topic=='onderwerp'){
		$t=2;
	}else{
		$t=1;
	}
	header("Location: index.php?page=topic&onderwerp=".$_POST['onderwerp']."&forum=".$_POST['forum']."&t=".$t);
	}
?>