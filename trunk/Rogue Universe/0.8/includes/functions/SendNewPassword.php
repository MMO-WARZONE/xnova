<?php

  function sendnewpassword($email){

  	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $email ."' LIMIT 1;", 'users', true);

    if (empty($ExistMail['email']))	{
	   message('That address is not found !','Error');
	}

	else{

    $Caracters="aazertyuiopqsdfghjklmwxcvbnåäöAZERTYUIOPQSDFGHJKLMWXCVBNÅÄÖ1234567890";

    $Count=strlen($Caracters);

    $NewPass="";
    $Taille=6;


    srand((double)microtime()*1000000);

     for($i=0;$i<$Taille;$i++){

      $CaracterBoucle=rand(0,$Count-1);

      $NewPass=$NewPass.substr($Caracters,$CaracterBoucle,1);
      }

    $Title = "Rogue Universe : Nytt lösenord";
    $Body = "Här är ditt nya lösenord : ";
    $Body .= $NewPass;

    mail($email,$Title,$Body);

    $NewPassSql = md5($NewPass);

    $QryPassChange = "UPDATE game_users SET ";
    $QryPassChange .= "`password` ='". $NewPassSql ."' ";
    $QryPassChange .= "WHERE `email`='". $email ."' LIMIT 1;";

    doquery( $QryPassChange, 'users');


    }



	}



?>