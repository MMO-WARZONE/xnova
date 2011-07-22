<?php


define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('overview');

// Banner
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
   // Parameter
   header ("Content-type: image/png");
   $image  = imagecreatefrompng($game_config['banner_source_post']);
   $date   = date("d/m/y");

   // Querys
   $Player = doquery("SELECT * FROM {{table}} WHERE `id` = '".$id."';", 'users', true);
   $Stats  = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '".$id."';", 'statpoints', true);
   $Planet = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$id."' AND `planet_type` = '1' LIMIT 1;", 'planets', true);

   // Variablen
   $b_univ   = $game_config['game_name'];
   $b_user   = $Player['username'];
   $b_planet = $Planet['name'];
   $b_xyz= "[".$Planet['galaxy'].":".$Planet['system'].":".$Planet['planet']."]";
   $b_lvl= "".$lang['ov_pts_rang'] ." ". $Stats['total_rank']."/".$game_config['users_amount']."";
   $b_build  = "".$lang['ov_pts_build'] .": ".pretty_number($Stats['build_points'])."";
   $b_fleet  = "".$lang['ov_pts_fleet'] .": ".pretty_number($Stats['fleet_points'])."";
   $b_def = "".$lang['ov_pts_def'] .": ".pretty_number($Stats['defs_points'])."";
   $b_search = "".$lang['ov_pts_reche'] .": ".pretty_number($Stats['tech_points'])."";
   $b_total  = "".$lang['ov_pts_total'] .": ".pretty_number($Stats['total_points'])."";


   // Renkler
   $color  = "FFFFFF";
   $red= hexdec(substr($color,0,2));
   $green  = hexdec(substr($color,2,4));
   $blue   = hexdec(substr($color,4,6));
   $select = imagecolorallocate($image,$red,$green,$blue);

   // Göster
   // Evren ismi
   imagestring($image, 1, CenterTextBanner($b_univ,1,653), 57, $b_univ, $select);
   // Tarih
   imagestring($image, 1, CenterTextBanner($date,1,653), 65, $date, $select);
   // Oyuncu ismi
   imagestring($image, 3, 15, 12, $b_user, $select);
   // Gezegen
   imagestring($image, 3, 150, 12, "".$b_planet." ".$b_xyz."", $select);
   // Oyuncu Level
   imagestring($image, 10, CenterTextBanner($b_lvl,10,795), 40, $b_lvl, $select);
   // Oyuncu istatistkler xD
   imagestring($image, 2, 15,  30, $b_build,  $select);
   imagestring($image, 2, 15,  45, $b_fleet,  $select);
   imagestring($image, 2, 15,  60, $b_def,$select);
   imagestring($image, 2, 150, 30, $b_search, $select);
   imagestring($image, 2, 150, 45, $b_total,  $select);

   // Banner olusturma silme iste budur yha xD
   imagepng ($image);
   imagedestroy ($image);
}

?>