<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** SendNewPassword.php                   **
******************************************/

  function sendnewpassword($email){

  	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $email ."' LIMIT 1;", 'users', true);

    if (empty($ExistMail['email']))	{
	   message('That address is not found !','Error');
	}

	else{

    $Caracters="aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
    $Count=strlen($Caracters);
    $NewPass="";
    $Taille=6;

    srand((double)microtime()*1000000);
     for($i=0;$i<$Taille;$i++){
      $CaracterBoucle=rand(0,$Count-1);
      $NewPass=$NewPass.substr($Caracters,$CaracterBoucle,1);
      }

    $Title = "OasisRage : New Password";
    $Body = "Here is your new password : ";
    $Body .= $NewPass;

    mail($email,$Title,$Body);

    $NewPassSql = md5($NewPass);

    $QryPassChange = "UPDATE {{table}} SET ";
    $QryPassChange .= "`password` ='". $NewPassSql ."' ";
    $QryPassChange .= "WHERE `email`='". $email ."' LIMIT 1;";

    doquery( $QryPassChange, 'users');

    }

	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>