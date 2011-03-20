<?php 
require('connect.php');
if(isset($_POST['login'])) {
	$res=mysql_query("select naam, pass from login where id=0");
	$row=mysql_fetch_assoc($res);
	$naam = $_POST['naam'];
	$wacht = $_POST['wacht'];
	if($naam == $row['naam']){
		if($wacht == $row['pass']){
				echo '<hr><div align=\"center\">The forum isn\'t ready yet! <br>You got acces to forumtest <br> Click on this link to test forum <br> <a href="index.php">Forum link</a><div><hr>';
		}else{
		echo 'Wrong pass';	
		}
	}else{
	echo 'Wrong Username';
	}
}
?>