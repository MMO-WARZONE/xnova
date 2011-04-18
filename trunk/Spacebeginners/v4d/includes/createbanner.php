<?php

/**
  * createbanner.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('menu_01/ubersicht');

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
   header ("Content-type: image/png");
   $image  = imagecreatefrompng($game_config['banner_source_post']);
   $date   = date("d/m/y");

   $Player = doquery("SELECT * FROM {{table}} WHERE `id` = '".$id."';", 'users', true);
   $Stats  = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '".$id."';", 'statpoints', true);
   $Planet = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$id."' AND `planet_type` = '1' LIMIT 1;", 'planets', true);

   $b_univ   = $game_config['game_name'];
   $b_user   = $Player['username'];
   $b_planet = $Planet['name'];
   $b_xyz    = "[".$Planet['galaxy'].":".$Planet['system'].":".$Planet['planet']."]";
   $b_lvl    = "".$Stats['total_rank']."/".$game_config['users_amount']."";
   $b_build  = "".$lang['over']['2001'] .": ".pretty_number($Stats['build_points'])."";
   $b_fleet  = "".$lang['over']['2002'] .": ".pretty_number($Stats['fleet_points'])."";
   $b_def    = "".$lang['over']['2003'] .": ".pretty_number($Stats['defs_points'])."";
   $b_search = "".$lang['over']['2004'] .": ".pretty_number($Stats['tech_points'])."";
   $b_total  = "".$lang['over']['2005'] .": ".pretty_number($Stats['total_points'])."";

   $color  = "FFFFFF";
   $red    = hexdec(substr($color,0,2));
   $green  = hexdec(substr($color,2,4));
   $blue   = hexdec(substr($color,4,6));
   $select = imagecolorallocate($image,$red,$green,$blue);

   imagestring($image, 1, CenterTextBanner($b_univ,1,653), 57, $b_univ, $select);
   imagestring($image, 1, CenterTextBanner($date,1,653), 65, $date, $select);
   imagestring($image, 3, 15, 12, $b_user, $select);
   imagestring($image, 3, 150, 12, "".$b_planet." ".$b_xyz."", $select);
   imagestring($image, 10, CenterTextBanner($b_lvl,10,795), 12, $b_lvl, $select);
   imagestring($image, 2, 15,  38, $b_build,  $select);
   imagestring($image, 2, 15,  55, $b_search, $select);
   imagestring($image, 2, 150, 38, $b_fleet,  $select);
   imagestring($image, 2, 150, 55, $b_def,  $select);
   imagestring($image, 2, 285, 38, $b_total,  $select);

   imagepng ($image);
   imagedestroy ($image);
}

?>