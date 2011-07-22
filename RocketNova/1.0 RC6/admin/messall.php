<?php

define('INSIDE'  , true); 
define('INSTALL' , false); 
define('IN_ADMIN', true);  

$rocketnova_root_path = './../'; 
include($rocketnova_root_path . 'extension.inc'); 
include($rocketnova_root_path . 'common.' . $phpEx);  	
if ($user['authlevel'] >= 1) { 		
if ($_POST && $_GET['mode'] == "change") { 			
if ($user['authlevel'] == 4) { 				
$kolor = 'red'; 				
$ranga = 'Administrator'; 			
} elseif ($user['authlevel'] == 2) { 				
$kolor = 'skyblue'; 				
$ranga = 'GameOperator'; 			
} elseif ($user['authlevel'] == 3) { 				
$kolor = 'yellow'; 				
$ranga = 'SuperGameOperator'; 			}  			
if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != '')) { 				
$sq      = doquery("SELECT `id` FROM {{table}}", "users"); 				$Time    = time(); 				
$From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>"; 				
$Subject = "<font color=\"". $kolor ."\">". $_POST['temat'] ."</font>"; 				
$Message = "<font color=\"". $kolor ."\"><b>". $_POST['tresc'] ."</b></font>"; 				
while ($u = mysql_fetch_array($sq)) { 					
SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message); 				} 				
message("<font color=\"lime\">Deine Nachricht wurde an alle Spieler gesendet!</font>", "Gesendet", "../overview." . $phpEx, 3); 			
} else { 				message("<font color=\"red\">Du hast kein Betreff angegeben!</font>", "Fehler", "../overview." . $phpEx, 3); 			} 		
} else { 			$parse = $game_config; 			$parse['dpath'] = $dpath; 			
$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":''; 			
$page .= parsetemplate(gettemplate('admin/messall_body'), $parse); 			
display($page, '', false,'', true); 		} 	} else { 		
message($lang['sys_noalloaw'], $lang['sys_noaccess']); 	} ?>