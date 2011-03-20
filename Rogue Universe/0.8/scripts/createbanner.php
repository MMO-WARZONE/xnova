<?php 
/** 
* CreateBanner.php 
* 
* @version 1.0 
* @version 1.2 by Ihor 
* @copyright 2008 By e-Zobar for XNova 
*/ 
define('INSIDE' , true); 
define('INSTALL' , false); 
$ugamela_root_path = '../'; 
include($ugamela_root_path . 'extension.inc'); 
include($ugamela_root_path . 'common.' . $phpEx); 
includeLang('overview'); 
// Function to center text in the created banner 
function CenterTextBanner($z,$y,$zone) { 
$a = strlen($z); 
$b = imagefontwidth($y); 
$c = $a*$b; 
$d = $zone-$c; 
$e = $d/2; 
return $e; 
} 
extract($_GET); 
if (isset($id)) { 
// Parameters 
header ("Content-type: image/png"); 
$image = imagecreatefrompng($game_config['banner_source_post']); 
$date = date("d/m/y"); 
// Querys 
$Player = doquery("SELECT * FROM {{table}} WHERE `id` = '".$id."';", 'users', true); 
$Stats = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '".$id."';", 'statpoints', true); 
$Planet = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$id."' AND `planet_type` = '1' LIMIT 1;", 'planets', true); 
// Variables 
$b_univ = $game_config['game_name']; 
$b_user = $Player['username']; 
$b_planet = $Planet['name']; 
$b_xyz = "[".$Planet['galaxy'].":".$Planet['system'].":".$Planet['planet']."]"; 
$b_lvl = "".$Stats['total_rank']."/".$game_config['users_amount'].""; 
// Colors 
$color = "FFFFFF"; 
$red = hexdec(substr($color,0,2)); 
$green = hexdec(substr($color,2,4)); 
$blue = hexdec(substr($color,4,6)); 
$select = imagecolorallocate($image,$red,$green,$blue); 
$txt_shadow = imagecolorallocatealpha($image, 255, 255, 255, 255); 
$txt_color = imagecolorallocatealpha($image, 255, 255, 255, 2); 
$txt_shadow2 = imagecolorallocatealpha($image, 255, 255, 255, 255); 
$txt_color2 = imagecolorallocatealpha($image, 255, 255, 255, 40); 
// Player level 
imagettftext($image, 8, 0, 118, 20, $txt_shadow2, "terminator.TTF", $b_lvl); 
imagettftext($image, 8, 0, 116, 18, $txt_color2, "terminator.TTF", $b_lvl); 
// Player name 
imagettftext($image, 11, 0, 215, 22, $txt_shadow, "terminator.TTF", $b_user); 
imagettftext($image, 11, 0, 213, 19, $txt_color, "terminator.TTF", $b_user); 

// Player b_planet 
imagettftext($image, 6, 0, 5, 10, $txt_shadow2, "KLMNFP2005.ttf", $b_planet." ".$b_xyz.""); 
imagettftext($image, 6, 0, 4, 9, $txt_color2, "KLMNFP2005.ttf", $b_planet." ".$b_xyz.""); 

//StatPoint 
$b_points = "Points: ".pretty_number($Stats['total_points']).""; 
imagettftext($image, 6, 0, 242, 36, $txt_shadow2, "KLMNFP2005.ttf", $b_points); 
imagettftext($image, 6, 0, 240, 34, $txt_color2, "KLMNFP2005.ttf", $b_points); 
//StatPoint 
$b_points = "Raids: ".pretty_number($Player['raids']).""; 
imagettftext($image, 6, 0, 142, 36, $txt_shadow2, "KLMNFP2005.ttf", $b_points); 
imagettftext($image, 6, 0, 140, 34, $txt_color2, "KLMNFP2005.ttf", $b_points); 
//StatPoint 
$b_points = "Raids Win: ".pretty_number($Player['raidswin']).""; 
imagettftext($image, 6, 0, 152, 46, $txt_shadow2, "KLMNFP2005.ttf", $b_points); 
imagettftext($image, 6, 0, 150, 44, $txt_color2, "KLMNFP2005.ttf", $b_points); 
//StatPoint 
$b_points = "Raids Loose: ".pretty_number($Player['loose']).""; 
imagettftext($image, 6, 0, 162, 56, $txt_shadow2, "KLMNFP2005.ttf", $b_points); 
imagettftext($image, 6, 0, 160, 54, $txt_color2, "KLMNFP2005.ttf", $b_points); 

// Creat and delete banner 
imagepng ($image); 
imagedestroy ($image); 
} 
?>
