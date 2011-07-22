<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

########## Angriffszonen ###########
    	$AZ = array( 
	    1 =>      100,
		2 =>      250,
		3 =>      500,
		4 =>      750,
		5 =>     1250,
		6 =>     1800,
		7 =>     3000,
		8 =>     4500,
		9 =>     6000,
	   10 =>     8000,
	   11 =>    10000,
	   12 =>    12500,
	   13 =>    16000,
	   14 =>    20000,
	   15 =>    25000,
	   16 =>    30000,
	   17 =>    37000,
	   18 =>    45000,
	   19 =>    55000,
	   20 =>    70000,
	   21 =>    85000,
	   22 =>   100000,
	   23 =>   120000,
	   24 =>   150000,
	   25 =>   185000,
	   26 =>   225000,
	   27 =>   275000,
	   28 =>   350000,
	   29 =>   400000,
	   30 =>   500000,
	   31 =>   625000,
	   32 =>   700000,
	   33 =>   800000,
	   34 =>   900000,
	   35 =>  1000000,
	   36 =>  1150000,
	   37 =>  1250000,
	   38 =>  1400000,
	   39 =>  1600000,
	   40 =>  1850000,
	   41 =>  2000000,
	   42 =>  2500000,
	   43 =>  3000000,
	   44 =>  4200000,
	   45 =>  6500000,
	   46 =>  8500000,
	   47 => 12000000,
	   48 => 16000000,
	   49 => 20000000,
	   50 => 25000000
		);
########### Angriffszonen updaten ############
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
	elseif($Stats['total_points'] > $AZ[14] AND $Stats['total_points'] < $AZ[15])
	{
	$UserAZ = 15;
	}
	elseif($Stats['total_points'] > $AZ[15] AND $Stats['total_points'] < $AZ[16])
	{
	$UserAZ = 16;
	}
	elseif($Stats['total_points'] > $AZ[16] AND $Stats['total_points'] < $AZ[17])
	{
	$UserAZ = 17;
	}
	elseif($Stats['total_points'] > $AZ[17] AND $Stats['total_points'] < $AZ[18])
	{
	$UserAZ = 18;
	}
	elseif($Stats['total_points'] > $AZ[18] AND $Stats['total_points'] < $AZ[19])
	{
	$UserAZ = 19;
	}
	elseif($Stats['total_points'] > $AZ[19] AND $Stats['total_points'] < $AZ[20])
	{
	$UserAZ = 20;
	}
	elseif($Stats['total_points'] > $AZ[20] AND $Stats['total_points'] < $AZ[21])
	{
	$UserAZ = 21;
	}
	elseif($Stats['total_points'] > $AZ[21] AND $Stats['total_points'] < $AZ[22])
	{
	$UserAZ = 22;
	}
	elseif($Stats['total_points'] > $AZ[22] AND $Stats['total_points'] < $AZ[23])
	{
	$UserAZ = 23;
	}
	elseif($Stats['total_points'] > $AZ[23] AND $Stats['total_points'] < $AZ[24])
	{
	$UserAZ = 24;
	}
	elseif($Stats['total_points'] > $AZ[24] AND $Stats['total_points'] < $AZ[25])
	{
	$UserAZ = 25;
	}
	elseif($Stats['total_points'] > $AZ[25] AND $Stats['total_points'] < $AZ[26])
	{
	$UserAZ = 26;
	}
	elseif($Stats['total_points'] > $AZ[26] AND $Stats['total_points'] < $AZ[27])
	{
	$UserAZ = 27;
	}
	elseif($Stats['total_points'] > $AZ[27] AND $Stats['total_points'] < $AZ[28])
	{
	$UserAZ = 28;
	}
	elseif($Stats['total_points'] > $AZ[28] AND $Stats['total_points'] < $AZ[29])
	{
	$UserAZ = 29;
	}
	elseif($Stats['total_points'] > $AZ[29] AND $Stats['total_points'] < $AZ[30])
	{
	$UserAZ = 30;
	}
	elseif($Stats['total_points'] > $AZ[30] AND $Stats['total_points'] < $AZ[31])
	{
	$UserAZ = 31;
	}
	elseif($Stats['total_points'] > $AZ[31] AND $Stats['total_points'] < $AZ[32])
	{
	$UserAZ = 32;
	}
	elseif($Stats['total_points'] > $AZ[32] AND $Stats['total_points'] < $AZ[33])
	{
	$UserAZ = 33;
	}
	elseif($Stats['total_points'] > $AZ[33] AND $Stats['total_points'] < $AZ[34])
	{
	$UserAZ = 34;
	}
	elseif($Stats['total_points'] > $AZ[34] AND $Stats['total_points'] < $AZ[35])
	{
	$UserAZ = 35;
	}
	elseif($Stats['total_points'] > $AZ[35] AND $Stats['total_points'] < $AZ[36])
	{
	$UserAZ = 36;
	}
	elseif($Stats['total_points'] > $AZ[36] AND $Stats['total_points'] < $AZ[37])
	{
	$UserAZ = 37;
	}
	elseif($Stats['total_points'] > $AZ[37] AND $Stats['total_points'] < $AZ[38])
	{
	$UserAZ = 38;
	}
	elseif($Stats['total_points'] > $AZ[38] AND $Stats['total_points'] < $AZ[39])
	{
	$UserAZ = 39;
	}
	elseif($Stats['total_points'] > $AZ[39] AND $Stats['total_points'] < $AZ[40])
	{
	$UserAZ = 40;
	}
	elseif($Stats['total_points'] > $AZ[40] AND $Stats['total_points'] < $AZ[41])
	{
	$UserAZ = 41;
	}
	elseif($Stats['total_points'] > $AZ[41] AND $Stats['total_points'] < $AZ[42])
	{
	$UserAZ = 42;
	}
	elseif($Stats['total_points'] > $AZ[42] AND $Stats['total_points'] < $AZ[43])
	{
	$UserAZ = 43;
	}
	elseif($Stats['total_points'] > $AZ[43] AND $Stats['total_points'] < $AZ[44])
	{
	$UserAZ = 44;
	}
	elseif($Stats['total_points'] > $AZ[44] AND $Stats['total_points'] < $AZ[45])
	{
	$UserAZ = 45;
	}
	elseif($Stats['total_points'] > $AZ[45] AND $Stats['total_points'] < $AZ[46])
	{
	$UserAZ = 46;
	}
	elseif($Stats['total_points'] > $AZ[46] AND $Stats['total_points'] < $AZ[47])
	{
	$UserAZ = 47;
	}
	elseif($Stats['total_points'] > $AZ[47] AND $Stats['total_points'] < $AZ[48])
	{
	$UserAZ = 48;
	}
	elseif($Stats['total_points'] > $AZ[48] AND $Stats['total_points'] < $AZ[49])
	{
	$UserAZ = 49;
	}
	elseif($Stats['total_points'] > $AZ[49])
	{
	$UserAZ = 50;
	}
	doquery("UPDATE {{table}} SET `angriffszone` = '".$UserAZ."' WHERE `id` = '".$Stats['id_owner']."'", 'users');
$i++;
}

?>