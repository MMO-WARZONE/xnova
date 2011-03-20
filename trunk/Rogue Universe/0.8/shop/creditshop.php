<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


$select = mysql_query("SELECT * FROM game_users");

$page = mysql_fetch_object($select);

$login=$user['username'];
$currentplanet=$user['current_planet']; 



?>
<div id="theLayer" style="border:none;background-color:transparent;position:absolute;width:20px;left:150;top:50;visibility:visible">

<table width="600" align="center" border=1>





<?php

if($user['arraki'] < 0){
echo "  <tr><td class=\"mainTxt\" align=\"center\"><font color=red><b><center>eRRoR</b></center></font></td></tr>";
            mysql_query("UPDATE game_planets SET `arraki`=0 WHERE username = '" . $login . "'") or die(mysql_error());
exit;
}

?>

<link rel="stylesheet" type="text/css" href="../skins/ds2/formate.css">
<form method="post" action="creditshop.php" name="f"><th>
<table width="441" height="477" align="center"><BR>
  <BR>
  <tr>
    <td class=subTitle colspan=3><b>VIP Shop</b></td>
  </tr>
  <tr><td class=mainTxt>
<tr>
<td class=subTitle width=20>&nbsp;#</td>
<td class=subTitle width="208"><b>Choices</b></td>
<td class=subTitle width="199">
<b>Price</b></td>
</tr>
<tr></tr>
<tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="metaal"></td>
<td class=mainTxt width="208">+20.000 Metall</td>
<td class=mainTxt width="199">50 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="crystal"></td>
<td class=mainTxt width="208">+20.000 Crystal</td>
<td class=mainTxt width="199">60 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="deuterium"></td>
<td class=mainTxt width="208">+20.000 Deuterium</td>
<td class=mainTxt width="199">60 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="heavyhunter"></td>
<td class=mainTxt width="208">+5 Heavy Hunters<font color=red><b></b></font></td><td class=mainTxt width="199">75 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="biglaser"></td>
<td class=mainTxt width="208">+5 Big Lasers<font color=red><b></b></font></td><td class=mainTxt width="199">75 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="solar_plant"></td>
<td class=mainTxt width="208">Upgrade Solar Plant 1 Level<font color=red><b></b></font></td><td class=mainTxt width="199">60 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="lab"></td>
<td class=mainTxt width="208">Upgrade Research Lab 1 Level<font color=red><b></b></font></td><td class=mainTxt width="199">100 Arraki</td>
</tr>

<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="fusion_plant"></td>
<td class=mainTxt width="208">Upgrade Fusion Plant 1 Level<font color=red><b></b></font></td><td class=mainTxt width="199">100 Arraki</td>
</tr>

<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="hangar"></td>
<td class=mainTxt width="208">Upgrade Alliance Depot 1 Level<font color=red><b></b></font></td><td class=mainTxt width="199">100 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="silo"></td>
<td class=mainTxt width="208">Upgrade Rocket Silo 1 Level<font color=red><b></b></font></td><td class=mainTxt width="199">100 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="big_protection_shield"></td>
<td class=mainTxt width="208">Buy 1 Big Protection Shield<font color=red><b></b></font></td><td class=mainTxt width="199">200 Arraki</td>
</tr>
<tr>
<td width=20 class=mainTxt><input type=radio name=gebruik value="terraformer"></td>
<td class=mainTxt width="208">Upgrade/Build Terraformer</td><td class=mainTxt width="199">300 Arraki</td>
</tr>


<tr>
<td colspan=2 class=mainTxt><BR>
  <b>Total amount of Arraki:</b> <?php echo $user[arraki]; ?></td>
<td align=right class=mainTxt width="199"><BR>
<p align="left"><input type=input value="1" size=3 name="bieden" maxlength=2>x
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=submit value="BUY" name="submit">

<p align="left"></tr></td>

<table width="441" align="center">
</div>
  <?php


  
if (isset($_POST['gebruik'])) {

           $aantal = htmlspecialchars(addslashes($_POST['bieden']));
           $aantal = substr($aantal,0,2);
           if(!is_numeric($aantal)){
           echo 'Illegal Character';
           exit;
           }
      if($gebruik == "crystal") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 60; 
           $kosttotaal = $kost*$aantal; 
           $wat = 20000; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "metaal") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 50; 
           $kosttotaal = $kost*$aantal; 
           $wat = 20000; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "deuterium") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 60; 
           $kosttotaal = $kost*$aantal; 
           $wat = 20000; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "hangar") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 100; 
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "silo") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 100; 
           $kosttotaal = $kost*$aantal;
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "big_protection_shield") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 200;
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}

      if($gebruik == "energie") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 60; 
           $kosttotaal = $kost*$aantal; 
           $wat = 20000; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "lab") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 100; 
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "heavyhunter") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 75; 
           $kosttotaal = $kost*$aantal; 
           $wat = 5;
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "biglaser") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 75; 
           $kosttotaal = $kost*$aantal; 
           $wat = 5; 
           $krijgen = $wat*$aantal;  
}



      if($gebruik == "solar_plant") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 60; 
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}

      if($gebruik == "fusion_plant") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 100; 
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}
      if($gebruik == "terraformer") {     
         $gebruik=htmlspecialchars(addslashes($_POST['gebruik']));
           $kost = 300;
           $kosttotaal = $kost*$aantal; 
           $wat = 1; 
           $krijgen = $wat*$aantal;  
}

if($kosttotaal > $user[arraki]){
print "  <tr><td class=\"mainTxt\" align=\"center\">You dont have enough Arraki. You need to <a href=\"#\" onclick=\"window.open('../call.php','VIP','width=650,height=410','resizable=no','toolbar=no')\">Buy More</a> before you try again.</td></tr>\n";
exit;
}
if($aantal ==0) {
    print "  <tr><td class=\"mainTxt\" align=\"center\">You need to choose more than 1</td></tr>\n";
exit;
}
if($aantal > 100) {
    print "  <tr><td class=\"mainTxt\" align=\"center\">Max amount is 99!</td></tr>\n";
exit;
}
if($aantal < 0) {
    print "  <tr><td class=\"mainTxt\" align=\"center\">Least amount is 1!</td></tr>\n";
exit;
}


if($gebruik == "crystal") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `crystal`=`crystal`+'$krijgen' WHERE `id` = '$currentplanet'");
$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
        
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." crystal</b> <b>$aantal</b><b> Total amount= $krijgen </b><br></td></tr>\n";
}

if($gebruik == "metaal") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `metal`=`metal`+'$krijgen' WHERE `id` = '$currentplanet'");
$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
        
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." metal</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "deuterium") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `deuterium`=`deuterium`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." deuterium</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "hangar") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `ally_deposit`=`ally_deposit`+'$krijgen' WHERE `id` = '$currentplanet'");
$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
        
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Alliance Depot(s)</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "silo") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `silo`=`silo`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." silo</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "big_protection_shield") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `big_protection_shield`=`big_protection_shield`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Big Protection Shield</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}


// START
if($gebruik == "terraformer") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `terraformer`=`terraformer`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Terraformer</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
//END 

/*
if($gebruik == "energie") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `energy_max`=`energy_max`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Energie</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
*/
if($gebruik == "lab") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `laboratory`=`laboratory`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Research labs</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "heavyhunter") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `heavy_hunter`=`heavy_hunter`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Heavy Hunters</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}
if($gebruik == "biglaser") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `big_laser`=`big_laser`+'$krijgen' WHERE `id` = '$currentplanet'");
$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
        
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Big Lasera</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}


if($gebruik == "solar_plant") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `solar_plant`=`solar_plant`+'$krijgen' WHERE `id` = '$currentplanet'");
 $query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
       
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Solar Plants</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}

if($gebruik == "fusion_plant") {
mysql_query("UPDATE `game_users` SET `arraki`=`arraki`-'$kosttotaal' WHERE username = '$login'");
mysql_query("UPDATE `game_planets` SET `fusion_plant`=`fusion_plant`+'$krijgen' WHERE `id` = '$currentplanet'");
$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());
        
        
    print "  <tr><td class=\"mainTxt\" align=\"center\">You have bought <b>".$wat." Fusion Plants</b> <b>$aantal</b> <b> Total amount= $krijgen </b> <br></td></tr>\n";
}


}
exit;


?> 
</table>
