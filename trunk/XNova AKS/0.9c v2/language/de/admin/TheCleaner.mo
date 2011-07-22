<?php
$lang['adm_clean_title']		= "Cleaner bugs on tables user, planets and galaxies";
$lang['adm_clean_explain']		= "This script creates 2 types of checks on the tables and on basis of these results determines the type of cleaning to do.<br> The possible types of cleaning are:<br>-1 Intelligent Cleaning<br>-2 brute force<br> If your tables only require intelligent cleaning the memory consumption and runtime of the script will be low, however if it requires cleaning by brute force the time and consumption will be higher and may stop the script depending on the server. If this happens you can ruin database (or have more problems than before).<br>Before using this script is preferable that you make a backup of your database.<br><br>Sure you want to clean the bugs?"; 
$lang['adm_clean']				= "Clean";
$lang['adm_deleted_users']		= "user deleted:% u <br> user id of disposed users are:<br>%iu<br>";
$lang['adm_deleted_planets']	= "planets deleted: %p <br>planets id of the disposed planets are:<br> %ip<br>";
$lang['adm_deleted_galaxy']		= "positions deleted: %g <br> galaxy positions eliminated are:<br> %ig<br>";
$lang['adm_time']               = "Total time of execution: %ti<br>";
$lang['adm_i_mem']              = "memory at the beginning of the script: %mi/%mti<br>";
$lang['adm_e_mem']              = "memory at the end of the script: %me/%mte<br>";
$lang['adm_succes']             = "The process completed successfully<br>";
$lang['adm_del_title']          ="Removal of unused id";
?>