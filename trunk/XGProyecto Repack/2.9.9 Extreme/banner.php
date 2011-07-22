<?php
define('INSIDE'  , true);

   $id=$_GET["id"];
if($id){
   // Parameters
   header ("Content-type: image/png");
   $image  = imagecreatefrompng("./styles/images/bann.png");
  


   $date   = date("d/m/y");
require('./config.php');
$link=mysql_connect($dbsettings['server'], $dbsettings['user'],$dbsettings['pass']);
mysql_select_db($dbsettings['name'],$link);
   // Querys
   $querymostrar="u.*,u.username,s.*,p.*,g.*";
   $querybase=$dbsettings['prefix']."users as u,".$dbsettings['prefix']."statpoints as s,".$dbsettings['prefix']."planets as p,".$dbsettings['prefix']."config as g";
   $querywhere="u.id ='".$id."' AND s.stat_code=1 AND s.stat_type=1 AND s.id_owner=u.id AND p.id_owner=u.id AND p.planet_type=1 AND g.config_name='users_amount'";
   $query="SELECT ".$querymostrar." FROM ".$querybase." WHERE ".$querywhere.";";
//echo   $query;
   $sqlquery = mysql_query("SELECT ".$querymostrar." FROM ".$querybase." WHERE ".$querywhere.";");
   $sqlrow = mysql_fetch_array($sqlquery);

function pretty_number($a){
return number_format($a,0, ",", ".");
}
   // Variables
   $b_user   = $sqlrow["username"];//$Player['username'];
   $b_planet = $sqlrow['name'];
   $b_xyz    ="[".$sqlrow['galaxy'].":".$sqlrow['system'].":".$sqlrow['planet']."]";
   $b_lvl    = "".$sqlrow['total_rank']."/".$sqlrow['config_value']."";
   $b_build  = "EDIFICIOS: ".pretty_number($sqlrow['build_points']);
   $b_fleet  = "FLOTA: ".pretty_number($sqlrow['fleet_points']);
   $b_search = "INVESTIGACIONES: ".pretty_number($sqlrow['tech_points']);
   $b_total  = "TOTAL: ".pretty_number($sqlrow['total_points']);


   // Colors
   $color  = "FFFFFF";
   $red    = hexdec(substr($color,0,2));
   $green  = hexdec(substr($color,2,4));
   $blue   = hexdec(substr($color,4,6));
   $select = imagecolorallocate($image,$red,$green,$blue);
   $txt_shadow  = imagecolorallocatealpha($image, 255, 255, 255, 255);
   $txt_color   = imagecolorallocatealpha($image, 255, 255, 255, 2);
   $txt_shadow2  = imagecolorallocatealpha($image, 255, 255, 255, 255);
   $txt_color2   = imagecolorallocatealpha($image, 255, 255, 255, 50);

   // Player level
 imagettftext($image, 8, 0, 127, 20, $txt_shadow2, "./styles/banner/terminator.TTF", $b_lvl);
       imagettftext($image, 8, 0, 125, 18, $txt_color2, "./styles/banner/terminator.TTF", $b_lvl);
   // Player name
   imagettftext($image, 11, 0, 240, 22, $txt_shadow, "./styles/banner/terminator.TTF", $b_user);
      imagettftext($image, 11, 0, 239, 19, $txt_color, "./styles/banner/terminator.TTF", $b_user);
      
   // Player b_planet
   imagettftext($image, 6, 0, 5, 30, $txt_shadow, "./styles/banner/KLMNFP2005.ttf", "PLANETA: ".$b_planet." ".$b_xyz."");
      imagettftext($image, 6, 0, 4, 29, $txt_color, "./styles/banner/KLMNFP2005.ttf", "PLANETA: ".$b_planet." ".$b_xyz."");
   
   //STATS
   imagettftext($image, 6, 0, 155, 48, $txt_shadow, "./styles/banner/KLMNFP2005.ttf", $b_build);
      imagettftext($image, 6, 0, 153, 46, $txt_color, "./styles/banner/KLMNFP2005.ttf", $b_build);
   imagettftext($image, 6, 0, 155, 59, $txt_shadow, "./styles/banner/KLMNFP2005.ttf", $b_fleet);
      imagettftext($image, 6, 0, 153, 57, $txt_color, "./styles/banner/KLMNFP2005.ttf", $b_fleet);
   imagettftext($image, 6, 0, 300, 48, $txt_shadow, "./styles/banner/KLMNFP2005.ttf", $b_search);
      imagettftext($image, 6, 0, 298, 46, $txt_color, "./styles/banner/KLMNFP2005.ttf", $b_search);
   imagettftext($image, 6, 0, 300, 59, $txt_shadow, "./styles/banner/KLMNFP2005.ttf", $b_total);
      imagettftext($image, 6, 0, 298, 57, $txt_color, "./styles/banner/KLMNFP2005.ttf", $b_total);

   // Creat and delete banner
   imagepng ($image);
   imagedestroy ($image);
   unset($sqlrow);
}
?> 
