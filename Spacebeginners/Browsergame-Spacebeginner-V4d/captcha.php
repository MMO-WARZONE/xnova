<?php
// Captcha by Sercankd
//Retranscrit par Theptitprince

session_start();

function rastgele($length=5,$type=1){
$key = '';
switch($type){
case 2: 
$pattern ="ABCDEFGHJKMNPQRSTUVWXYZABCDEFGHJKMNPQRSTUVWXYZ";
break;
case 3:
$pattern = "2345678923456789234567892345678923456789";
break;
default:
$pattern = "23456789ABCDEFGHJKMNPQRSTUVWXYZ";
break;
}
for($i=0;$i<$length;$i++){
$key .= $pattern{rand(0,35)};
}
return $key;
}



$en=100;
$boy=25;
$sayi = rastgele(7,1);
$_SESSION['captcha'] = $sayi;
$sercankd = imagecreatefromgif("images/captchabg.gif");
$b = imagecolorallocate($sercankd,100,100,50);
$s = imagecolorallocate($sercankd,0,0,0);
imagefill($sercankd,0,0,$s);
imageline($sercankd,20,50,$en,$boy,$b);
imagestring($sercankd,3,27,7,$sayi,$b);
Header("content-type:image/gif");
imagegif($sercankd);
imagedestroy($sercankd);
?>