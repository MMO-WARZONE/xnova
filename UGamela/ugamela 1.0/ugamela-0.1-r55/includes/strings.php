<?php  //strings.php :: Funciones variadas para dar formato al texto

function colorNumber($n){

	if($n>0){
		$n = '<font color="#00ff00">'.$n.'</font>';
	}elseif($n<0){
		$n = '<font color="#ff0000">'.$n.'</font>';
	}

	return $n;
}

// Created by Perberos. All rights reversed (C) 2006
?>