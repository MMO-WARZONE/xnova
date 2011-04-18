<?php

/**
########################################################
az.php by RedFighter

Funktion: 
Ermittelt die aktuelle Angriffszone jedes Spielers und speichert diese in der game_users ab.
Diese Datei muss entweder in der statbuilder.php includiert werden, oder manuell aufgerufen werden.

Unter "Angriffszonen definieren" kann die Mindestpunktzahl jederer Angriffszone selbst definiert werden.

Fehler und Verbesserungsvorschläge bitte im entsprechende Thread posten!
Support auch nur über diesen Thread!

(c) Copyright by RedFighter 
########################################################
**/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ADMINMENU_ANZEIGEN', true);
define('LEFTMENU_NICHT_ANZEIGEN', true);

#####################################
########## Angriffszonen definieren ###########
#####################################
    	$AZ = array( // Angriffszonen
	    1 =>       50,
		2 =>      200,
		3 =>      400,
		4 =>      800,
		5 =>     1200,
		6 =>     2000,
		7 =>     5000,
		8 =>    10000,
		9 =>    20000,
	   10 =>    40000,
	   11 =>    90000,
	   12 =>   200000,
	   13 =>   500000,
	   14 =>  1000000
		);
#####################################
########### Angriffszonen updaten ############
#####################################
$Query = doquery("SELECT * FROM {{table}} WHERE `stat_type` =1", 'statpoints');
$i = 0;	
while ($Stats = mysql_fetch_assoc($Query)) {
	if($Stats['total_points'] < $AZ[1]) 
	{
	$UserAZ = 1;
	}
	elseif($Stats['total_points'] > $AZ[1] AND $Stats['total_points'] < $AZ[2])
	{
	$UserAZ = 2;
	}
	elseif($Stats['total_points'] > $AZ[2] AND $Stats['total_points'] < $AZ[3])
	{
	$UserAZ = 3;
	}
	elseif($Stats['total_points'] > $AZ[3] AND $Stats['total_points'] < $AZ[4])
	{
	$UserAZ = 4;
	}
	elseif($Stats['total_points'] > $AZ[4] AND $Stats['total_points'] < $AZ[5])
	{
	$UserAZ = 5;
	}
	elseif($Stats['total_points'] > $AZ[5] AND $Stats['total_points'] < $AZ[6])
	{
	$UserAZ = 6;
	}
	elseif($Stats['total_points'] > $AZ[6] AND $Stats['total_points'] < $AZ[7])
	{
	$UserAZ = 7;
	}
	elseif($Stats['total_points'] > $AZ[7] AND $Stats['total_points'] < $AZ[8])
	{
	$UserAZ = 8;
	}
	elseif($Stats['total_points'] > $AZ[8] AND $Stats['total_points'] < $AZ[9])
	{
	$UserAZ = 9;
	}
	elseif($Stats['total_points'] > $AZ[9] AND $Stats['total_points'] < $AZ[10])
	{
	$UserAZ = 10;
	}
	elseif($Stats['total_points'] > $AZ[10] AND $Stats['total_points'] < $AZ[11])
	{
	$UserAZ = 11;
	}
	elseif($Stats['total_points'] > $AZ[11] AND $Stats['total_points'] < $AZ[12])
	{
	$UserAZ = 12;
	}
	elseif($Stats['total_points'] > $AZ[12] AND $Stats['total_points'] < $AZ[13])
	{
	$UserAZ = 13;
	}
	elseif($Stats['total_points'] > $AZ[13] AND $Stats['total_points'] < $AZ[14])
	{
	$UserAZ = 14;
	}
	elseif($Stats['total_points'] > $AZ[14])
	{
	$UserAZ = 15;
	} 
	doquery("UPDATE {{table}} SET `angriffszone` = '".$UserAZ."' WHERE `id` = '".$Stats['id_owner']."'", 'users');
$i++;
}
/**
###################################
(c) Copyright by RedFighter 
###################################
**/
?>