<?php 

/** 
* login.php 
* 
* @version 1.0 
* @copyright 2008 by ?????? for XNova 
some fix from mrlle xnova.pl 
*/ 

define('INSIDE' , true); 
define('INSTALL' , false); 

$InLogin = true; 

$ugamela_root_path = './'; 
include($ugamela_root_path . 'extension.inc'); 
include($ugamela_root_path . 'common.' . $phpEx); 

if ($game_config['game_disable'] == 1){ 

print $game_config['close_reason']; 

}else{ 
includeLang('startseite'); 
includeLang('portalnews');  

if ($_POST) { 
$login = doquery("SELECT * FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' LIMIT 1", "users", true); 

if ($login) { 
if ($login['password'] == md5($_POST['password'])) { 
if (isset($_POST["rememberme"])) { 
$expiretime = time() + 31536000; 
$rememberme = 1; 
} else { 
$expiretime = 0; 
$rememberme = 0; 
} 

@include('config.php'); 
$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme; 
setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0); 

unset($dbsettings); 
header("Location: ./frames.php"); 
exit; 
} else { 
message($lang['Login_FailPassword'], $lang['Login_Error']); 
} 
} else { 
message($lang['Login_FailUser'], $lang['Login_Error']); 
} 
} else { 
$parse = $lang; 
$query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true); 
$parse['last_user'] = $query['username']; 
$query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true); 
$parse['online_users'] = $query[0]; 
$parse['time']          = date("D M d H:i:s", time());
$parse['users_amount'] = $game_config['users_amount']; 
$parse['servername'] = $game_config['game_name']; 
$parse['forum_url'] = $game_config['forum_url']; 
$parse['PasswordLost'] = $lang['PasswordLost']; 
$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
$parse['maxcase']      = $game_config['initial_fields']; 
    $parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
    $parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
    
    $parse['hmetal']      = $game_config['metal_basic_income'];  
    $parse['hkris']      = $game_config['crystal_basic_income'];  
    $parse['hdeut']      = $game_config['deuterium_basic_income'];  
    $parse['buildq']     = MAX_BUILDING_QUEUE_SIZE; 
    $parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
    $parse['maxplani']     = MAX_PLAYER_PLANETS;  
    $parse['resstore']     = BASE_STORAGE_SIZE;
    $parse['resmetal']     = BUILD_METAL; 
    $parse['reskris']     = BUILD_CRISTAL;   
    $parse['resdeut']     = BUILD_DEUTERIUM;   

$page = parsetemplate(gettemplate('startseite/game_body'), $parse); 
display($page, $lang['Gameinfos']); 
} 
} 
// ----------------------------------------------------------------------------------------------------------- 
// History version 
?>